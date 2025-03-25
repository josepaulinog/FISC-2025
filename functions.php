<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

if (! function_exists('\Roots\bootloader')) {
    wp_die(
        __('You need to install Acorn to use this theme.', 'sage'),
        '',
        [
            'link_url' => 'https://roots.io/acorn/docs/installation/',
            'link_text' => __('Acorn Docs: Installation', 'sage'),
        ]
    );
}

\Roots\bootloader()->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });


add_filter('login_headerurl', fn() => home_url());
add_filter('login_headertext', fn() => get_bloginfo('name'));


if ( ! function_exists( 'tribe_include_view_list' ) ) {
    /**
     *
     * @param array $args Argumentos para la vista.
     * @return string HTML de la vista o cadena vacía.
     */
    function tribe_include_view_list( $args = array() ) {
        if ( function_exists( 'tribe_get_view' ) ) {
            return tribe_get_view( 'list', $args );
        }
        return '';
    }
}

/*
|--------------------------------------------------------------------------
| Register Custom Post Types: Attendees & Delegates
|--------------------------------------------------------------------------
*/

function create_attendees_and_delegates_post_types() {
    $post_types = [
        'attendee' => 'Attendee',
        'delegate' => 'Delegate',
    ];

    foreach ($post_types as $slug => $singular_name) {
        $labels = [
            'name'               => __($singular_name . 's', 'your-text-domain'),
            'singular_name'      => __($singular_name, 'your-text-domain'),
            'menu_name'          => __($singular_name . 's', 'your-text-domain'),
            'name_admin_bar'     => __($singular_name, 'your-text-domain'),
            'add_new'            => __('Add New', 'your-text-domain'),
            'add_new_item'       => __('Add New ' . $singular_name, 'your-text-domain'),
            'edit_item'          => __('Edit ' . $singular_name, 'your-text-domain'),
            'new_item'           => __('New ' . $singular_name, 'your-text-domain'),
            'view_item'          => __('View ' . $singular_name, 'your-text-domain'),
            'search_items'       => __('Search ' . $singular_name . 's', 'your-text-domain'),
            'not_found'          => __('No ' . strtolower($singular_name) . 's found', 'your-text-domain'),
            'not_found_in_trash' => __('No ' . strtolower($singular_name) . 's found in Trash', 'your-text-domain'),
        ];

        $args = [
            'label'               => __($singular_name, 'your-text-domain'),
            'labels'              => $labels,
            'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-groups',
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
        ];

        register_post_type($slug, $args);
    }
}
add_action('init', 'create_attendees_and_delegates_post_types', 0);


add_filter('em_calendar_get_args', function( $args ) {
    if ( is_array( $args ) && array_key_exists( 'style', $args ) ) {
        unset( $args['style'] );
    }
    return $args;
});


function tribe_attachment_404_fix () {
	if (class_exists('Tribe__Events__Main')) {
		remove_action( 'init', array( Tribe__Events__Main::instance(), 'init' ), 10 );
		add_action( 'init', array( Tribe__Events__Main::instance(), 'init' ), 1 );
	}
}

add_action( 'after_setup_theme', 'tribe_attachment_404_fix' );

// Checks the URL for the debug parameter
// example.com/event/event-name/?tribe_query_debug=true
function tribe_events_pre_get_posts_dumper ($query) {
	$show_debug_info = isset($_GET['tribe_query_debug']) ? $_GET['tribe_query_debug'] : false;

	if(($show_debug_info == "true" && $query->is_main_query() === true) || $show_debug_info == "full") {
		echo "<h3>&lt;Tribe Events Query&gt;</h3>";
		tribe_spit_it_out($query);

		add_filter('the_posts', 'tribe_dump_return_query', 100, 1);
	}

}
add_action('pre_get_posts', 'tribe_events_pre_get_posts_dumper');

function tribe_dump_return_query($query) {

	echo '<p>Query Results:</p>';
	tribe_spit_it_out($query);

	echo '<p>is_404() = </p>';
	var_dump(is_404());

	echo '<h3>&lt;/Tribe Events Query&gt;</h3>';

	// Only run this once
	remove_filter('the_posts', 'tribe_dump_return_query', 100, 1);

	return $query;
}

function tribe_spit_it_out($var_for_dumping) {
	echo '<pre>';
	var_dump($var_for_dumping);
	echo '</pre>';
}

function tribe_link_prev_class($format) {
    $format = str_replace('href=', 'class="btn flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white space-x-2" href=', $format);
    return $format;
}
add_filter('tribe_the_prev_event_link', 'tribe_link_prev_class');

function tribe_link_next_class($format) {
    $format = str_replace('href=', 'class="btn flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white space-x-2" href=', $format);
    return $format;
}
add_filter('tribe_the_next_event_link', 'tribe_link_next_class');

// Add these functions to display and save custom user fields
function display_custom_user_fields($user) {
    ?>
    <h3><?php _e("FISC 2025 Attendee Information", "sage"); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="job_title"><?php _e("Job Title"); ?></label></th>
            <td>
                <input type="text" name="job_title" id="job_title" value="<?php echo esc_attr(get_user_meta($user->ID, 'job_title', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="company"><?php _e("Organization"); ?></label></th>
            <td>
                <input type="text" name="company" id="company" value="<?php echo esc_attr(get_user_meta($user->ID, 'company', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="country"><?php _e("Country"); ?></label></th>
            <td>
                <input type="text" name="country" id="country" value="<?php echo esc_attr(get_user_meta($user->ID, 'country', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="linkedin"><?php _e("LinkedIn Profile"); ?></label></th>
            <td>
                <input type="url" name="linkedin" id="linkedin" value="<?php echo esc_attr(get_user_meta($user->ID, 'linkedin', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="twitter"><?php _e("X.com Profile"); ?></label></th>
            <td>
                <input type="url" name="twitter" id="twitter" value="<?php echo esc_attr(get_user_meta($user->ID, 'twitter', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="website"><?php _e("Website"); ?></label></th>
            <td>
                <input type="url" name="website" id="website" value="<?php echo esc_attr(get_user_meta($user->ID, 'website', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}

function save_custom_user_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) return false;
    
    update_user_meta($user_id, 'job_title', sanitize_text_field($_POST['job_title'] ?? ''));
    update_user_meta($user_id, 'company', sanitize_text_field($_POST['company'] ?? ''));
    update_user_meta($user_id, 'country', sanitize_text_field($_POST['country'] ?? ''));
    update_user_meta($user_id, 'linkedin', esc_url_raw($_POST['linkedin'] ?? ''));
    update_user_meta($user_id, 'twitter', esc_url_raw($_POST['twitter'] ?? ''));
    update_user_meta($user_id, 'website', esc_url_raw($_POST['website'] ?? ''));
}

// Register the hooks directly in functions.php
add_action('show_user_profile', 'display_custom_user_fields');
add_action('edit_user_profile', 'display_custom_user_fields');
add_action('personal_options_update', 'save_custom_user_fields');
add_action('edit_user_profile_update', 'save_custom_user_fields');

/**
 * Force password reset functionality for attendee users
 */

// Add admin menu item for the password reset management
add_action('admin_menu', function() {
    add_management_page(
        'Attendee Password Reset', 
        'Attendee Password Reset', 
        'manage_options', 
        'attendee-password-reset', 
        'render_attendee_password_reset_page'
    );
});

// Render admin page for managing password resets
function render_attendee_password_reset_page() {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    
    // Handle bulk reset action
    if ($action === 'reset_all_attendees' && current_user_can('manage_options')) {
        check_admin_referer('reset_all_attendees');
        flag_all_attendees_for_password_reset();
        echo '<div class="notice notice-success"><p>All attendees have been flagged to reset their passwords on next login.</p></div>';
    }
    
    // Handle individual user reset
    if ($action === 'reset_user' && $user_id > 0 && current_user_can('manage_options')) {
        check_admin_referer('reset_user_' . $user_id);
        update_user_meta($user_id, 'password_reset_required', true);
        echo '<div class="notice notice-success"><p>User has been flagged to reset their password on next login.</p></div>';
    }
    
    // Handle clear reset flag for individual user
    if ($action === 'clear_reset' && $user_id > 0 && current_user_can('manage_options')) {
        check_admin_referer('clear_reset_' . $user_id);
        update_user_meta($user_id, 'password_reset_required', false);
        echo '<div class="notice notice-success"><p>Password reset requirement has been removed for this user.</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>Attendee Password Reset Management</h1>
        
        <div class="card" style="max-width: 800px; padding: 20px; margin-bottom: 20px;">
            <h2>Force Password Reset for All Attendees</h2>
            <p>Use this option to require all users with the "attendee" role to reset their passwords on next login.</p>
            
            <a href="<?php echo wp_nonce_url(admin_url('tools.php?page=attendee-password-reset&action=reset_all_attendees'), 'reset_all_attendees'); ?>" 
               class="button button-primary" 
               onclick="return confirm('Are you sure you want to force ALL attendees to reset their passwords on next login?');">
                Force Password Reset for All Attendees
            </a>
        </div>
        
        <h2>Manage Individual Attendees</h2>
        
        <?php
        // Get all users with attendee role
        $attendees = get_users(['role' => 'attendee']);
        
        if (empty($attendees)) {
            echo '<p>No users with the attendee role were found.</p>';
        } else {
            ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Reset Required</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendees as $user): ?>
                        <?php $reset_required = get_user_meta($user->ID, 'password_reset_required', true); ?>
                        <tr>
                            <td><?php echo esc_html($user->user_login); ?></td>
                            <td><?php echo esc_html($user->display_name); ?></td>
                            <td><?php echo esc_html($user->user_email); ?></td>
                            <td><?php echo $reset_required ? '<span style="color: #d63638;">Yes</span>' : '<span style="color: #00a32a;">No</span>'; ?></td>
                            <td>
                                <?php if ($reset_required): ?>
                                    <a href="<?php echo wp_nonce_url(admin_url('tools.php?page=attendee-password-reset&action=clear_reset&user_id=' . $user->ID), 'clear_reset_' . $user->ID); ?>" class="button button-small">
                                        Remove Reset Requirement
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo wp_nonce_url(admin_url('tools.php?page=attendee-password-reset&action=reset_user&user_id=' . $user->ID), 'reset_user_' . $user->ID); ?>" class="button button-small">
                                        Require Password Reset
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
        }
        ?>
    </div>
    <?php
}

/**
 * Flag all attendee users for password reset
 */
function flag_all_attendees_for_password_reset() {
    $attendees = get_users(['role' => 'attendee']);
    
    foreach ($attendees as $user) {
        update_user_meta($user->ID, 'password_reset_required', true);
    }
    
    return count($attendees);
}

/**
 * Flag new attendee users as needing to reset password on first login
 */
add_action('user_register', function($user_id) {
    $user = get_userdata($user_id);
    
    // Only apply to users with the attendee role
    if ($user && in_array('attendee', (array) $user->roles)) {
        update_user_meta($user_id, 'password_reset_required', true);
    }
});

/**
 * Handle the password reset form submission
 */
add_action('password_reset', function($user, $new_pass) {
    // Update the user meta to indicate they've reset their password
    update_user_meta($user->ID, 'password_reset_required', false);
    
    // If this is the first login, redirect to home
    if (isset($_POST['first_login']) && $_POST['first_login'] == '1') {
        add_filter('login_redirect', function($redirect_to, $requested_redirect_to, $user) {
            return home_url();
        }, 10, 3);
    }
}, 10, 2);

// Add reset button to user profile page (for admins only)
add_action('edit_user_profile', function($user) {
    if (current_user_can('edit_users') && in_array('attendee', (array) $user->roles)) {
        $reset_required = get_user_meta($user->ID, 'password_reset_required', true);
        ?>
        <h3>Password Reset Settings</h3>
        <table class="form-table">
            <tr>
                <th><label for="force_reset">Force Password Reset</label></th>
                <td>
                    <label for="force_reset">
                        <input name="force_reset" type="checkbox" id="force_reset" value="1" <?php checked($reset_required); ?>>
                        Require this attendee to reset their password on next login
                    </label>
                </td>
            </tr>
        </table>
        <?php
    }
});

// Save force reset setting from user profile page
add_action('edit_user_profile_update', function($user_id) {
    if (current_user_can('edit_users')) {
        $user = get_userdata($user_id);
        
        if ($user && in_array('attendee', (array) $user->roles)) {
            $force_reset = isset($_POST['force_reset']) ? true : false;
            update_user_meta($user_id, 'password_reset_required', $force_reset);
        }
    }
});

/**
 * Override the default lost password URL
 */
add_filter('lostpassword_url', function($lostpassword_url, $redirect) {
    // Get your custom reset password page
    $reset_page = get_page_by_path('reset-password');
    
    if (!$reset_page) {
        return $lostpassword_url;
    }
    
    $custom_lostpassword_url = get_permalink($reset_page->ID);
    
    if ($redirect) {
        $custom_lostpassword_url = add_query_arg('redirect_to', urlencode($redirect), $custom_lostpassword_url);
    }
    
    return $custom_lostpassword_url;
}, 10, 2);

/**
 * Handle custom password reset process
 */
add_action('init', function() {
    // Check if this is a password reset form submission
    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'resetpass') {
        // If there's no key or login, do nothing
        if (!isset($_REQUEST['key']) || !isset($_REQUEST['login'])) {
            return;
        }
        
        // Get our custom reset password page
        $reset_page = get_page_by_path('reset-password');
        
        if (!$reset_page) {
            return;
        }
        
        // Check if the reset key is valid
        $user = check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);
        
        // If the key is invalid, redirect to our custom page with error
        if (is_wp_error($user)) {
            wp_redirect(add_query_arg(
                array(
                    'error' => 'invalidkey',
                    'login' => urlencode($_REQUEST['login'])
                ),
                get_permalink($reset_page->ID)
            ));
            exit;
        }
        
        // If no password is submitted or passwords don't match
        if (!isset($_POST['pass1']) || empty($_POST['pass1']) || $_POST['pass1'] !== $_POST['pass2']) {
            wp_redirect(add_query_arg(
                array(
                    'key' => urlencode($_REQUEST['key']),
                    'login' => urlencode($_REQUEST['login']),
                    'error' => 'password'
                ),
                get_permalink($reset_page->ID)
            ));
            exit;
        }
        
        // Reset the password
        reset_password($user, $_POST['pass1']);
        
        // Check if this is a first login
        $first_login = isset($_POST['first_login']) && $_POST['first_login'] == '1';
        
        // Update the user meta to indicate they've reset their password
        if ($first_login) {
            update_user_meta($user->ID, 'password_reset_required', false);
        }
        
        // Redirect to login page with success message
        wp_redirect(add_query_arg('password-reset', 'true', get_permalink(get_page_by_path('login')->ID)));
        exit;
    }
});

/**
 * Enforce strong password requirements
 */
add_action('validate_password_reset', function($errors, $user) {
    if (isset($_POST['pass1']) && !empty($_POST['pass1'])) {
        $password = $_POST['pass1'];
        
        // Check password length
        if (strlen($password) < 8) {
            $errors->add('password_too_short', '<strong>Error</strong>: Password must be at least 8 characters long.');
        }
        
        // Check for uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            $errors->add('password_no_upper', '<strong>Error</strong>: Password must include at least one uppercase letter.');
        }
        
        // Check for number
        if (!preg_match('/[0-9]/', $password)) {
            $errors->add('password_no_number', '<strong>Error</strong>: Password must include at least one number.');
        }
        
        // Check for special character
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            $errors->add('password_no_special', '<strong>Error</strong>: Password must include at least one special character (like !@#$%^&*).');
        }
    }
    
    return $errors;
}, 10, 2);