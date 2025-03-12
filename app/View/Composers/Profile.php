<?php
namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Profile extends Composer
{
    protected static $views = ['profile'];

    public function with()
    {
        $user = wp_get_current_user();
        $avatar = get_user_meta($user->ID, 'profile_avatar', true);
        
        $data = [
            'display_name' => $user->display_name,
            'user_email' => $user->user_email,
            'bio' => get_user_meta($user->ID, 'description', true),
            'avatar' => $avatar ?: get_avatar_url($user->ID),
            'company' => get_user_meta($user->ID, 'company', true),
            
            // Add attendee fields
            'job_title' => get_user_meta($user->ID, 'job_title', true),
            'country' => get_user_meta($user->ID, 'country', true),
            'phone' => get_user_meta($user->ID, 'phone', true),
            'attendee_type' => get_user_meta($user->ID, 'attendee_type', true),
            
            // Social media fields
            'linkedin' => get_user_meta($user->ID, 'linkedin', true),
            'twitter' => get_user_meta($user->ID, 'twitter', true),
            'website' => get_user_meta($user->ID, 'website', true),
        ];
        
        // Allow filtering of profile data
        return apply_filters('fisc_profile_data', $data, $user->ID);
    }
}