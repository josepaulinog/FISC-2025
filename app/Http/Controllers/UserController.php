<?php 

namespace App\Http\Controllers;

class UserController {
    public static function updateProfile() {
        check_ajax_referer('update_user_profile', '_ajax_nonce');

        $user_id = get_current_user_id();
        $display_name = sanitize_text_field($_POST['display_name'] ?? '');
        $user_email = sanitize_email($_POST['user_email'] ?? '');
        $bio = wp_kses_post($_POST['bio'] ?? '');
        $company = sanitize_text_field($_POST['company'] ?? '');
        $job_title = sanitize_text_field($_POST['job_title'] ?? '');
        $country = sanitize_text_field($_POST['country'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $attendee_type = sanitize_text_field($_POST['attendee_type'] ?? '');
        
        // Get social media fields
        $linkedin = esc_url_raw($_POST['linkedin'] ?? '');
        $twitter = esc_url_raw($_POST['twitter'] ?? '');
        $website = esc_url_raw($_POST['website'] ?? '');

        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
        }

        if (!current_user_can('edit_user', $user_id)) {
            wp_send_json_error('Insufficient permissions');
        }

        // Handle avatar upload
        if (!empty($_FILES['avatar']) && !$_FILES['avatar']['error']) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            $uploaded_file = wp_handle_upload($_FILES['avatar'], ['test_form' => false]);
            if (isset($uploaded_file['url'])) {
                update_user_meta($user_id, 'profile_avatar', esc_url($uploaded_file['url']));
            }
        }

        $user_data = [
            'ID'           => $user_id,
            'display_name' => $display_name,
            'user_email'   => $user_email,
        ];

        $updated_user_id = wp_update_user($user_data);

        if (is_wp_error($updated_user_id)) {
            wp_send_json_error($updated_user_id->get_error_message());
        }

        // Update user meta fields
        update_user_meta($user_id, 'description', $bio);
        update_user_meta($user_id, 'company', $company);
        update_user_meta($user_id, 'job_title', $job_title);
        update_user_meta($user_id, 'country', $country);
        update_user_meta($user_id, 'phone', $phone);
        update_user_meta($user_id, 'attendee_type', $attendee_type);
        
        // Update social media links
        update_user_meta($user_id, 'linkedin', $linkedin);
        update_user_meta($user_id, 'twitter', $twitter);
        update_user_meta($user_id, 'website', $website);

        wp_send_json_success('Profile updated successfully');
    }
    
    public static function updateTheme() {
        check_ajax_referer('update_user_theme', '_ajax_nonce');  // Changed from 'update_user_settings'
    
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
        }
    
        $user_id = get_current_user_id();
        $theme = sanitize_text_field($_POST['theme'] ?? 'light');
    
        if (!in_array($theme, ['light', 'dark'])) {
            wp_send_json_error('Invalid theme value');
        }
    
        update_user_meta($user_id, 'theme', $theme);
    
        wp_send_json_success('Theme updated successfully');
    }  

    // Display the user profile fields including attendee fields
    public static function showCompanyField($user) {
        ?>
        <h3><?php _e("FISC 2025 Attendee Information", "sage"); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="job_title"><?php _e("Job Title"); ?></label></th>
                <td>
                    <input type="text" name="job_title" id="job_title" value="<?php echo esc_attr(get_user_meta($user->ID, 'job_title', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Enter your job title."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="company"><?php _e("Organization"); ?></label></th>
                <td>
                    <input type="text" name="company" id="company" value="<?php echo esc_attr(get_user_meta($user->ID, 'company', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Enter your organization name."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="country"><?php _e("Country"); ?></label></th>
                <td>
                    <input type="text" name="country" id="country" value="<?php echo esc_attr(get_user_meta($user->ID, 'country', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Enter your country."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="phone"><?php _e("Phone Number"); ?></label></th>
                <td>
                    <input type="text" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Enter your phone number (include country code)."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="attendee_type"><?php _e("Attendee Type"); ?></label></th>
                <td>
                    <input type="text" name="attendee_type" id="attendee_type" value="<?php echo esc_attr(get_user_meta($user->ID, 'attendee_type', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Type of attendee (e.g., Delegate, Observer, etc.)"); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="linkedin"><?php _e("LinkedIn Profile"); ?></label></th>
                <td>
                    <input type="url" name="linkedin" id="linkedin" value="<?php echo esc_attr(get_user_meta($user->ID, 'linkedin', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Enter your LinkedIn profile URL."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="twitter"><?php _e("X.com Profile"); ?></label></th>
                <td>
                    <input type="url" name="twitter" id="twitter" value="<?php echo esc_attr(get_user_meta($user->ID, 'twitter', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Enter your X.com profile URL."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="website"><?php _e("Website"); ?></label></th>
                <td>
                    <input type="url" name="website" id="website" value="<?php echo esc_attr(get_user_meta($user->ID, 'website', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Enter your website URL."); ?></span>
                </td>
            </tr>
        </table>
        <?php
    }

    // Save the user profile fields
    public static function saveCompanyField($user_id) {
        if (!current_user_can('edit_user', $user_id)) { return false; }
        
        // Standard fields
        if (isset($_POST['company'])) {
            update_user_meta($user_id, 'company', sanitize_text_field($_POST['company']));
        }
        
        // Attendee specific fields
        if (isset($_POST['job_title'])) {
            update_user_meta($user_id, 'job_title', sanitize_text_field($_POST['job_title']));
        }
        
        if (isset($_POST['country'])) {
            update_user_meta($user_id, 'country', sanitize_text_field($_POST['country']));
        }
        
        if (isset($_POST['phone'])) {
            update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
        }
        
        if (isset($_POST['attendee_type'])) {
            update_user_meta($user_id, 'attendee_type', sanitize_text_field($_POST['attendee_type']));
        }
        
        // Social media fields
        if (isset($_POST['linkedin'])) {
            update_user_meta($user_id, 'linkedin', esc_url_raw($_POST['linkedin']));
        }
        
        if (isset($_POST['twitter'])) {
            update_user_meta($user_id, 'twitter', esc_url_raw($_POST['twitter']));
        }
        
        if (isset($_POST['website'])) {
            update_user_meta($user_id, 'website', esc_url_raw($_POST['website']));
        }
    }
}

add_action('show_user_profile', [UserController::class, 'showCompanyField']);
add_action('edit_user_profile', [UserController::class, 'showCompanyField']);
add_action('personal_options_update', [UserController::class, 'saveCompanyField']);
add_action('edit_user_profile_update', [UserController::class, 'saveCompanyField']);