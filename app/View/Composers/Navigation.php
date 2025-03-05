<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use App\Tailwind_Navwalker;

class Navigation extends Composer
{
    protected static $views = [
        'partials.navigation',
        'sections.header',
        'sections.header-transparent',
        'partials.mobile-drawer',
    ];

    public function with()
    {
        return [
            'navigation' => $this->navigation(),
            'mobileNavigation' => $this->mobileNavigation(),
        ];
    }

    public function navigation()
    {
        return wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'menu menu-horizontal mx-auto',
            'container_class' => 'navbar-center',
            'echo' => false,
            'depth' => 2,
            'walker' => new Tailwind_Navwalker(),
        ]);
    }
    
    public function mobileNavigation()
    {
        return wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'menu menu-vertical w-full',
            'container_class' => 'w-full',
            'echo' => false,
            'depth' => 2,
            'walker' => new Tailwind_Navwalker(),
        ]);
    }
}