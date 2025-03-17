<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Filters WordPress menu items and adds custom data.
 */
add_filter('wp_nav_menu_objects', function ($items, $args) {
    $indexed_items = [];
    foreach ($items as $item) {
        $indexed_items[$item->ID] = $item;
        $item->children = [];
    }

    foreach ($items as $item) {
        if ($item->menu_item_parent && isset($indexed_items[$item->menu_item_parent])) {
            $indexed_items[$item->menu_item_parent]->children[] = $item;
        }
    }

    return array_values($items); // Keep full structure to prevent errors
}, 10, 2);

/**
 * Redirect non-logged-in users to the landing page or login.
 */
add_action('template_redirect', function () {
    $login_page = get_page_by_path('login');
    $landing_page = get_page_by_path('landing');

    if (!$login_page || !$landing_page) {
        return; // Prevents execution if login or landing pages do not exist
    }

    $login_page_id = $login_page->ID;
    $landing_page_id = $landing_page->ID;

    if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php' || wp_doing_ajax()) {
        return;
    }

    if (!is_user_logged_in()) {
        if (is_front_page() || is_home()) {
            wp_safe_redirect(get_permalink($landing_page_id));
            exit;
        }

        if (!is_page([$login_page_id, $landing_page_id])) {
            $current_url = home_url(add_query_arg([]));
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
    $login_page = get_page_by_path('login');
    if (!$login_page) {
        return $login_url;
    }

    $custom_login_url = get_permalink($login_page->ID);

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
    if (isset($user->roles) && is_array($user->roles)) {
        $redirect_to = home_url();
    }
    return $redirect_to;
}, 10, 3);

/**
 * Redirect failed login attempts to the custom login page.
 */
add_action('wp_login_failed', function ($username) {
    $login_page = get_page_by_path('login');
    if (!$login_page) {
        return;
    }
    wp_redirect(get_permalink($login_page->ID) . '?login=failed');
    exit;
});

/**
 * Redirect `wp-login.php` to the custom login page.
 */
add_action('login_init', function () {
    $login_page = get_page_by_path('login');
    if (!$login_page) {
        return;
    }

    if (basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) === 'wp-login.php' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        wp_redirect(get_permalink($login_page->ID));
        exit;
    }
});

/**
 * Hide the admin bar for all users.
 */
add_filter('show_admin_bar', '__return_false');
