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

        return [
            'display_name' => $user->display_name,
            'user_email' => $user->user_email,
            'bio' => get_user_meta($user->ID, 'description', true),
            'avatar' => $avatar ?: get_avatar_url($user->ID),
            'company' => get_user_meta($user->ID, 'company', true),
        ];
    }
}