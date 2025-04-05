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
    // Get the IDs of your custom login and landing pages
    $login_page = get_page_by_path('login');
    $landing_page = get_page_by_path('landing');
    
    // Set up page IDs safely
    $login_page_id = $login_page ? $login_page->ID : 0;
    $landing_page_id = $landing_page ? $landing_page->ID : 0;
    
    // Get current page ID
    $current_page_id = get_queried_object_id();
    
    // Skip this check for admin pages, direct wp-login.php access, and AJAX requests
    if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php' || wp_doing_ajax()) {
        return;
    }
    
    // If user is not logged in
    if (!is_user_logged_in()) {
        // If accessing the home page, redirect to landing page
        if (is_front_page() || is_home()) {
            wp_safe_redirect(get_permalink($landing_page_id));
            exit;
        }
        
        // If trying to access any page other than login or landing, redirect to login
        if (!is_page([$login_page_id, $landing_page_id])) {
            // Save the current URL to redirect back after login
            $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            wp_safe_redirect(add_query_arg('redirect_to', urlencode($current_url), get_permalink($login_page_id)));
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

add_action('wp_login', function($user_login, $user) {
    // Only apply to attendee users
    if (!in_array('attendee', (array) $user->roles)) {
        return;
    }
    
    // Check if user needs to reset password
    $reset_required = get_user_meta($user->ID, 'password_reset_required', true);
    
    if ($reset_required) {
        // Generate a password reset key
        $key = get_password_reset_key($user);
        
        if (is_wp_error($key)) {
            return;
        }
        
        // Build the reset URL
        $reset_url = home_url('/reset-password/');
        $reset_url = add_query_arg(array(
            'login' => rawurlencode($user->user_login),
            'key' => $key,
            'first_login' => '1'
        ), $reset_url);
        
        // Redirect to the password reset page
        wp_redirect($reset_url);
        exit;
    }
}, 10, 2);

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
 * JavaScript to remove intro tour classes and disable the plugin functionality on mobile
 */
add_action('wp_footer', function() {
    ?>
    <script>
    (function() {
        // Check if we're on a mobile device (screen width <= 768px)
        if (window.innerWidth <= 768) {
            // Function to disable intro tours
            function disableIntroTours() {
                // Remove classes from html element
                document.documentElement.classList.remove('dpit-on');
                document.documentElement.classList.remove('dpit-on-35666');
                document.documentElement.classList.remove('dpit-step-1');
                
                // Find and hide any intro tour elements
                var tourElements = document.querySelectorAll('.dpit-wrap, .dpit-wrap--dummy, .dp-intro-tooltip, .dp-intro-backdrop, .dp-intro-animation-container, .dp-intro-overlay');
                tourElements.forEach(function(el) {
                    if(el) {
                        el.style.display = 'none';
                        el.style.visibility = 'hidden';
                        el.style.opacity = '0';
                        el.style.pointerEvents = 'none';
                    }
                });
                
                // If dpIntroTourPublicConfig exists, try to disable it
                if(window.dpIntroTourPublicConfig) {
                    window.dpIntroTourPublicConfig.tours = [];
                }
            }
            
            // Run immediately
            disableIntroTours();
            
            // Also run when DOM is loaded
            document.addEventListener('DOMContentLoaded', disableIntroTours);
            
            // Set up observer to watch for class changes
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if(mutation.attributeName === 'class') {
                        disableIntroTours();
                    }
                });
            });
            
            // Start observing document.documentElement for class changes
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
            
            // As a fail-safe, run the function periodically
            setInterval(disableIntroTours, 1000);
        }
    })();
    </script>
    <?php
}, 999);