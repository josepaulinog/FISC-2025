<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Contact extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'contact',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'formTitle' => get_field('contact_form_title'),
            'formDescription' => get_field('contact_form_description'),
            'formId' => get_field('contact_form_id'),
        ];
    }
}
