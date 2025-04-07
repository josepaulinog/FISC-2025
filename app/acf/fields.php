<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_event_subtitle',
    'title' => 'Event Subtitle',
    'fields' => array(
        array(
            'key' => 'field_event_subtitle',
            'label' => 'Subtitle',
            'name' => 'event_subtitle',
            'type' => 'text',
            'instructions' => 'Enter a subtitle for this event.',
            'required' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'tribe_events',
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key' => 'group_page_subheading',
    'title' => 'Page Subheading',
    'fields' => array(
        array(
            'key' => 'field_page_subheading',
            'label' => 'Subheading',
            'name' => 'subheading',
            'type' => 'text',
            'instructions' => 'Enter a subheading for this page',
            'required' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key' => 'group_page_header_template',
    'title' => 'Page Header Template',
    'fields' => array(
        array(
            'key' => 'field_page_header_template',
            'label' => 'Header Template',
            'name' => 'header_template',
            'type' => 'select',
            'instructions' => 'Select a header template for this page',
            'required' => 0,
            'choices' => array(
                'default' => 'Default Header',
                'hero' => 'Hero Header',
                'minimal' => 'Minimal Header',
            ),
            'default_value' => 'default',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
));

acf_add_local_field_group(array(
    'key' => 'group_contact_form_settings',
    'title' => 'Contact Form Settings',
    'fields' => array(
        array(
            'key' => 'field_contact_form_title',
            'label' => 'Form Title',
            'name' => 'contact_form_title',
            'type' => 'text',
            'instructions' => 'Enter the title to display above the form',
            'default_value' => 'Send Us A Message',
            'required' => 0,
        ),
        array(
            'key' => 'field_contact_form_description',
            'label' => 'Form Description',
            'name' => 'contact_form_description',
            'type' => 'textarea',
            'instructions' => 'Enter the description to display above the form',
            'default_value' => 'We\'re here to answer your questions and provide the resources you need.',
            'required' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_template',
                'operator' => '==',
                'value' => 'contact.blade.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));

function get_gravity_forms_choices() {
    if (!class_exists('GFAPI')) {
        return [];
    }

    $forms = GFAPI::get_forms();
    $choices = [];

    foreach ($forms as $form) {
        $choices[$form['id']] = $form['title'];
    }

    return $choices;
}

// Add a new ACF group for the Pre Login template
acf_add_local_field_group(array(
    'key' => 'group_6542bc10acf_group',
    'title' => 'Prelogin Form Selector',
    'fields' => array(
        array(
            'key' => 'field_6542de8f72f00',
            'label' => 'Select Gravity Form',
            'name' => 'gravity_form_selector',
            'type' => 'select',
            'instructions' => 'Choose a form to display in the modal.',
            'required' => 1,
            'choices' => get_gravity_forms_choices(),
            'default_value' => false,
            'allow_null' => 1,
            'multiple' => 0,
            'ui' => 1,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => 'Select a form',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'template-landing.blade.php',
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key' => 'group_event_attachments',
    'title' => 'Event Attachments',
    'fields' => array(
        array(
            'key' => 'field_event_attachments',
            'label' => 'Attachments',
            'name' => 'event_attachments',
            'type' => 'repeater',
            'instructions' => 'Upload files related to this event.',
            'required' => 0,
            'sub_fields' => array(
                array(
                    'key' => 'field_attachment_file',
                    'label' => 'File',
                    'name' => 'file',
                    'type' => 'file',
                    'return_format' => 'array',
                    'library' => 'all',
                    'required' => 1,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'tribe_events', // Target The Events Calendar post type
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key' => 'group_event_video',
    'title' => 'Event Video',
    'fields' => array(
        array(
            'key' => 'field_enable_video',
            'label' => 'Enable Video',
            'name' => 'enable_video',
            'type' => 'true_false',
            'instructions' => 'Enable or disable the video for this event.',
            'default_value' => 0,
        ),
        array(
            'key' => 'field_video_embed',
            'label' => 'Video Embed URL',
            'name' => 'video_embed',
            'type' => 'url',
            'instructions' => 'Enter the embed URL for the video (e.g., YouTube or Vimeo).',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_enable_video',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_video_cover',
            'label' => 'Video Cover Image',
            'name' => 'video_cover',
            'type' => 'image',
            'instructions' => 'Upload a cover image for the video.',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_enable_video',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'tribe_events', // Target The Events Calendar post type
            ),
        ),
    ),
));

acf_add_local_field_group(array(
    'key' => 'group_gallery_years',
    'title' => 'Gallery Years',
    'fields' => array(
        array(
            'key' => 'field_gallery_years',
            'label' => 'Gallery Years',
            'name' => 'gallery_years',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Year',
            'sub_fields' => array(
                array(
                    'key' => 'field_year',
                    'label' => 'Year',
                    'name' => 'year',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_album_download_link',
                    'label' => 'Album Download Link',
                    'name' => 'album_download_link',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_gallery_days',
                    'label' => 'Gallery Days',
                    'name' => 'gallery_days',
                    'type' => 'repeater',
                    'layout' => 'row',
                    'min' => 1,
                    'max' => 5,
                    'button_label' => 'Add Day',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_day_number',
                            'label' => 'Day Number',
                            'name' => 'day_number',
                            'type' => 'number',
                            'required' => 1,
                            'min' => 1,
                            'max' => 5,
                        ),
                        array(
                            'key' => 'field_day_caption',
                            'label' => 'Day Caption',
                            'name' => 'day_caption',
                            'type' => 'textarea',
                            'instructions' => 'Enter a caption for all photos on this day',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'field_photos',
                            'label' => 'Photos',
                            'name' => 'photos',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => 'Add Photo',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_photo_full_image',
                                    'label' => 'Full Image',
                                    'name' => 'full_image',
                                    'type' => 'image',
                                    'return_format' => 'url',
                                    'preview_size' => 'medium',
                                    'required' => 1,
                                ),
                                array(
                                    'key' => 'field_photo_category',
                                    'label' => 'Category',
                                    'name' => 'category',
                                    'type' => 'select',
                                    'choices' => array(
                                        'sessions' => 'Sessions',
                                        'social' => 'Social',
                                        'opening' => 'Opening',
                                        'closing' => 'Closing',
                                        'other' => 'Other',
                                    ),
                                    'default_value' => 'sessions',
                                    'required' => 1,
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'gallery.blade.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
));

endif;

if ( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_gallery_settings',
        'title' => 'Gallery Settings',
        'fields' => array(
            array(
                'key' => 'field_gallery_year',
                'label' => 'Gallery Year',
                'name' => 'gallery_year',
                'type' => 'text',
                'instructions' => 'Enter the year for this gallery',
                'required' => 1,
            ),
            array(
                'key' => 'field_gallery_items',
                'label' => 'Gallery Items',
                'name' => 'gallery_items',
                'type' => 'repeater',
                'instructions' => 'Add images and details for the gallery',
                'sub_fields' => array(
                    array(
                        'key' => 'field_gallery_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_gallery_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_gallery_category',
                        'label' => 'Category',
                        'name' => 'category',
                        'type' => 'select',
                        'choices' => array(
                            'Ceremonies'    => 'Ceremonies',
                            'Sessions'      => 'Sessions',
                            'Social Events' => 'Social Events',
                            'Workshops'     => 'Workshops',
                        ),
                        'default_value' => 'Sessions',
                        'allow_null'    => 0,
                        'multiple'      => 0,
                    ),
                    array(
                        'key' => 'field_gallery_date',
                        'label' => 'Date',
                        'name' => 'date',
                        'type' => 'date_picker',
                        'display_format' => 'F j, Y',
                        'return_format'  => 'Y-m-d',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'gallery.blade.php',
                ),
            ),
        ),
        'menu_order'          => 0,
        'position'            => 'normal',
        'style'               => 'default',
        'label_placement'     => 'top',
        'instruction_placement' => 'label',
        'active'              => true,
    ));

endif;
