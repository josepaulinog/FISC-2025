<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;
use WP_Query;

use App\Http\Controllers\UserController;

require_once __DIR__ . '/Helpers/video-helper.php';


/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    bundle('app')->enqueue();
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    bundle('editor')->enqueue();

    wp_enqueue_script(
        'sage/filtered-materials',
        asset('scripts/editor.js')->uri(), 
        [
            'wp-blocks',
            'wp-i18n',
            'wp-element',
            'wp-block-editor',
            'wp-components',
            'wp-data'
        ],
        null,
        true
    );

}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

add_action('init', function () {
    flush_rewrite_rules();
});

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);

    /**
     * Register ACF Field Groups.
     */
    add_action('acf/init', function () {
        require_once __DIR__ . '/acf/fields.php';
    });
});

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/material', [
        'methods' => 'GET',
        'callback' => function ($request) {
            $args = [
                'post_type' => 'material',
                'posts_per_page' => $request->get_param('per_page') ?: 5,
                's' => $request->get_param('search'),
            ];

            $query = new \WP_Query($args);
            $posts = $query->posts;

            $data = [];
            foreach ($posts as $post) {
                $data[] = [
                    'id' => $post->ID,
                    'title' => ['rendered' => $post->post_title],
                    'excerpt' => ['rendered' => wp_trim_words($post->post_content, 20)],
                    'link' => get_permalink($post->ID),
                ];
            }

            return $data;
        },
        'permission_callback' => '__return_true',
    ]);
});

// Handle AJAX for profile updates
add_action('wp_ajax_update_user_profile', [UserController::class, 'updateProfile']);

// Handle AJAX for settings updates
add_action('wp_ajax_update_user_settings', [UserController::class, 'updateSettings']);

// Handle AJAX for theme updates
add_action('wp_ajax_update_user_theme', [UserController::class, 'updateTheme']);

add_action('wp_ajax_update_user_roles', [UserController::class, 'updateRoles']);

/**
 * Localize script for AJAX URL.
 */
add_action('wp_enqueue_scripts', function () {
    $user_theme = is_user_logged_in() ? get_user_meta(get_current_user_id(), 'theme', true) : 'light';

    $upload_nonce = wp_create_nonce('wp_rest');
    error_log('Generated upload nonce: ' . $upload_nonce);

    bundle('app')->enqueue()->localize('ajaxObject', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'update_profile_nonce' => wp_create_nonce('update_user_profile'),
        'update_settings_nonce' => wp_create_nonce('update_user_settings'),
        'update_roles_nonce' => wp_create_nonce('update_user_roles'),
        'delete_user_nonce' => wp_create_nonce('delete_user_nonce'),
        'get_users_nonce' => wp_create_nonce('get_users_nonce'),
        'update_user_theme_nonce' => wp_create_nonce('update_user_theme'),
        'load_more_search_results_nonce' => wp_create_nonce('load_more_search_results'),
        'upload_files_nonce' => $upload_nonce,
        'send_form_data_nonce' => wp_create_nonce('send_form_data'),
        'currentUser' => wp_get_current_user()->user_login,
        'user_theme' => $user_theme,
    ]);
}, 100);

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/upload', [
        'methods' => 'POST',
        'callback' => function ($request) {
            error_log('Upload request received');
            
            if (!function_exists('wp_handle_upload')) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }

            $uploadedfile = $request->get_file_params();
            error_log('Uploaded file params: ' . print_r($uploadedfile, true));

            $upload_overrides = ['test_form' => false];
            $movefile = wp_handle_upload($uploadedfile['file'], $upload_overrides);

            if ($movefile && !isset($movefile['error'])) {
                error_log('File uploaded successfully: ' . print_r($movefile, true));
                return new \WP_REST_Response($movefile, 200);
            } else {
                error_log('File upload failed: ' . print_r($movefile, true));
                return new \WP_Error('upload_error', $movefile['error']);
            }
        },
        'permission_callback' => function ($request) {
            return true; 
        },
    ]);
});

// Add REST API support for terms
add_action('rest_api_init', function () {
    register_rest_field(['material_category', 'material_tag'], 'term_data', [
        'get_callback' => function($term_arr) {
            $term = get_term($term_arr['id']);
            return [
                'name' => $term->name,
                'slug' => $term->slug,
                'id' => $term->term_id,
            ];
        },
        'schema' => [
            'description' => __('Term data'),
            'type' => 'object',
        ],
    ]);
});

// Remove default REST API filters that might block access
remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
add_filter('rest_pre_serve_request', function($value) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Credentials: true');
    return $value;
});

// Add Ajax handler
add_action('wp_ajax_create_user', function() {
    check_ajax_referer('create_user_nonce', 'nonce');

    if (!current_user_can('create_users')) {
        wp_send_json_error('Permission denied');
    }

    $username = sanitize_user($_POST['user_login']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $role = sanitize_text_field($_POST['role']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $send_notification = isset($_POST['send_user_notification']) ? true : false;

    // Validate required fields
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        wp_send_json_error('Please fill in all required fields');
    }

    // Create user
    $userdata = array(
        'user_login' => $username,
        'user_email' => $email,
        'user_pass' => $password,
        'role' => $role,
        'first_name' => $first_name,
        'last_name' => $last_name,
    );

    $user_id = wp_insert_user($userdata);

    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id->get_error_message());
    }

    // Send notification if requested
    if ($send_notification) {
        wp_new_user_notification($user_id, null, 'both');
    }

    wp_send_json_success('User created successfully');
});

// Add shortcode
add_shortcode('custom_add_user_page', function() {
    return view('partials.add-user-form', [
        'nonce' => wp_create_nonce('create_user_nonce'),
        'roles' => wp_roles()->roles,
    ])->render();
});

// Get Users AJAX handler
add_action('wp_ajax_get_users', function () {
    check_ajax_referer('get_users_nonce', 'nonce');
    
    if (!current_user_can('list_users')) {
        wp_send_json_error('Permission denied.');
        return;
    }

    $users = get_users();
    $user_list = array_map(function($user) {
        return [
            'id' => $user->ID,
            'username' => $user->user_login,
            'email' => $user->user_email,
            'role' => implode(', ', $user->roles),
        ];
    }, $users);

    wp_send_json_success($user_list);
});

// Delete User AJAX handler
add_action('wp_ajax_delete_user', function () {
    check_ajax_referer('delete_user_nonce', 'nonce');

    if (!current_user_can('delete_users')) {
        wp_send_json_error('Permission denied.');
    }

    $user_id = intval($_POST['user_id']);

    if ($user_id === get_current_user_id()) {
        wp_send_json_error('You cannot delete your own account.');
    }

    $result = wp_delete_user($user_id);

    if ($result) {
        wp_send_json_success('User deleted successfully.');
    } else {
        wp_send_json_error('Failed to delete user.');
    }
});

add_filter('sage/template', function($data) {
    $data['extension_instance'] = Tribe__Extension__Speaker_Linked_Post_Type::instance();
    return $data;
});

add_action('init', function () {
    register_taxonomy('photo_category', ['tribe_events'], [
        'label' => 'Photo Categories',
        'hierarchical' => false,
        'public' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'photo-category'],
    ]);
});
