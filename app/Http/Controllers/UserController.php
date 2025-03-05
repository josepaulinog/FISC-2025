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

        update_user_meta($user_id, 'description', $bio);
        update_user_meta($user_id, 'company', $company);

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

    // Display the "Company" field in the user profile
    public static function showCompanyField($user) {
        ?>
        <h3><?php _e("Additional Information", "sage"); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="company"><?php _e("Company"); ?></label></th>
                <td>
                    <input type="text" name="company" id="company" value="<?php echo esc_attr(get_user_meta($user->ID, 'company', true)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your company name."); ?></span>
                </td>
            </tr>
        </table>
        <?php
    }

    // Save the "Company" field value
    public static function saveCompanyField($user_id) {
        if (!current_user_can('edit_user', $user_id)) { return false; }
        
        if (isset($_POST['company'])) {
            update_user_meta($user_id, 'company', sanitize_text_field($_POST['company']));
            error_log('Company field saved for user ID: ' . $user_id); // Debugging
        } else {
            error_log('Company field not set'); // Debugging
        }
    }
}

add_action('show_user_profile', [UserController::class, 'showCompanyField']);
add_action('edit_user_profile', [UserController::class, 'showCompanyField']);
add_action('personal_options_update', [UserController::class, 'saveCompanyField']);
add_action('edit_user_profile_update', [UserController::class, 'saveCompanyField']);