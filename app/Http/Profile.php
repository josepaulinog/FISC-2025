<?php

namespace App\Http;

function updateProfile() {
    check_ajax_referer('update_user_profile', '_ajax_nonce');

    if (!is_user_logged_in()) {
        return wp_send_json_error('User not logged in');
    }

    $user_id = get_current_user_id();
    $display_name = sanitize_text_field($_POST['display_name'] ?? '');
    $user_email = sanitize_email($_POST['user_email'] ?? '');
    $bio = wp_kses_post($_POST['bio'] ?? '');
    $company = sanitize_text_field($_POST['company'] ?? '');
    
    // Get social media fields
    $linkedin = esc_url_raw($_POST['linkedin'] ?? '');
    $twitter = esc_url_raw($_POST['twitter'] ?? '');
    $website = esc_url_raw($_POST['website'] ?? '');

    // Update user data
    $user_data = [
        'ID'           => $user_id,
        'display_name' => $display_name,
        'user_email'   => $user_email,
    ];

    $updated_user_id = wp_update_user($user_data);

    if (is_wp_error($updated_user_id)) {
        return wp_send_json_error($updated_user_id->get_error_message());
    }

    update_user_meta($user_id, 'description', $bio);
    update_user_meta($user_id, 'company', $company);
    
    // Update social media fields
    update_user_meta($user_id, 'linkedin', $linkedin);
    update_user_meta($user_id, 'twitter', $twitter);
    update_user_meta($user_id, 'website', $website);

    return wp_send_json_success('Profile updated successfully');
}