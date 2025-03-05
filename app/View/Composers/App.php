<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {

        return [
            'siteName' => $this->siteName(),
            'title' => get_the_title() ?: 'Default Title',
            'header_template' => $this->getHeaderTemplate(),
            'pagination' => get_the_posts_pagination(),
        ];
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }

    /**
     * Fetches the ACF header template field and provides a default.
     */
    protected function getHeaderTemplate()
    {
        return get_field('header_template') ?: 'default';
    }
}
