<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class HeaderTemplateComposer extends Composer
{
    // Specify the views where this composer is applied
    protected static $views = [
        'page',
        'opportunity',
    ];

    public function with()
    {
        return [
            'title' => get_the_title() ?: 'Default Title',
            'header_template' => $this->getHeaderTemplate(),
            'pagination' => get_the_posts_pagination(),
        ];
    }

    /**
     * Fetches the ACF header template field and provides a default.
     */
    protected function getHeaderTemplate()
    {
        return get_field('header_template') ?: 'default';
    }
}
