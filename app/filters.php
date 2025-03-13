<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Filters WordPress menu items and adds custom data.
 *
 * @param array $items An array of menu item post objects.
 * @param array $args An array of arguments.
 * @return array
 */
add_filter('wp_nav_menu_objects', function ($items, $args) {
    // First, index all items by their ID for quick lookup
    $indexed_items = [];
    foreach ($items as $item) {
        $indexed_items[$item->ID] = $item;
        $item->children = []; // Initialize children array for all items
    }

    // Build tree
    foreach ($items as $item) {
        if ($item->menu_item_parent && isset($indexed_items[$item->menu_item_parent])) {
            $indexed_items[$item->menu_item_parent]->children[] = $item;
        }
    }

    // Remove children from top level
    $top_level_items = array_filter($items, function ($item) {
        return !$item->menu_item_parent || !isset($indexed_items[$item->menu_item_parent]);
    });

    return $top_level_items;
}, 10, 2);

/**
 * Redirect non-logged-in users to the landing page by default,
 * and to the login page when they try to access internal pages.
 */
add_action('template_redirect', function () {
    $login_page = get_page_by_path('login');
    $landing_page = get_page_by_path('landing');

    $login_page_id = $login_page ? $login_page->ID : 0;
    $landing_page_id = $landing_page ? $landing_page->ID : 0;

    if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php' || wp_doing_ajax()) {
        return;
    }

    if (!is_user_logged_in()) {
        if (is_front_page() || is_home()) {
            wp_safe_redirect(get_permalink($landing_page_id));
            exit;
        }

        if (!is_page([$login_page_id, $landing_page_id])) {
            $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            wp_safe_redirect(add_query_arg(
                [
                    'redirect_to'    => urlencode($current_url),
                    'login_required' => 'true'
                ],
                get_permalink($login_page_id)
            ));
            exit;
        }
    }
});

/**
 * Override the default WordPress login URL
 */
add_filter('login_url', function ($login_url, $redirect, $force_reauth) {
    $login_page_id = get_page_by_path('login')->ID;
    $custom_login_url = get_permalink($login_page_id);
    
    if ($redirect) {
        $custom_login_url = add_query_arg('redirect_to', urlencode($redirect), $custom_login_url);
    }
    
    if ($force_reauth) {
        $custom_login_url = add_query_arg('reauth', '1', $custom_login_url);
    }
    
    return $custom_login_url;
}, 10, 3);

/**
 * Redirect users to the homepage after successful login.
 */
add_filter('login_redirect', function ($redirect_to, $request, $user) {
    // Is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        // Redirect to the homepage for all users after login
        $redirect_to = home_url();
    }
    return $redirect_to;
}, 10, 3);

// Redirect failed login attempts to the custom login page with error messages
add_action('wp_login_failed', function ($username) {
    $login_page = get_permalink(get_page_by_path('login')->ID);
    wp_redirect($login_page . '?login=failed');
    exit;
});

// Redirect login errors to the custom login page
add_filter('authenticate', function ($user, $username, $password) {
    if (is_wp_error($user)) {
        $login_page = get_permalink(get_page_by_path('login')->ID);
        $error_code = $user->get_error_code();

        if ($error_code === 'invalid_username' || $error_code === 'incorrect_password') {
            wp_redirect($login_page . '?login=failed');
            exit;
        }
    }
    return $user;
}, 99, 3);

// Redirect wp-login.php to the custom login page
add_action('login_init', function () {
    $login_page = get_permalink(get_page_by_path('login')->ID);

    if (strtolower($_SERVER['REQUEST_URI']) == '/wp-login.php' && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
});

// Hide the admin bar for all users
add_filter('show_admin_bar', '__return_false');
