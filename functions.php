<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

if (! function_exists('\Roots\bootloader')) {
    wp_die(
        __('You need to install Acorn to use this theme.', 'sage'),
        '',
        [
            'link_url' => 'https://roots.io/acorn/docs/installation/',
            'link_text' => __('Acorn Docs: Installation', 'sage'),
        ]
    );
}

\Roots\bootloader()->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });


add_filter('login_headerurl', fn() => home_url());
add_filter('login_headertext', fn() => get_bloginfo('name'));


if ( ! function_exists( 'tribe_include_view_list' ) ) {
    /**
     *
     * @param array $args Argumentos para la vista.
     * @return string HTML de la vista o cadena vacía.
     */
    function tribe_include_view_list( $args = array() ) {
        if ( function_exists( 'tribe_get_view' ) ) {
            return tribe_get_view( 'list', $args );
        }
        return '';
    }
}

/*
|--------------------------------------------------------------------------
| Register Custom Post Types: Attendees & Delegates
|--------------------------------------------------------------------------
*/

function create_attendees_and_delegates_post_types() {
    $post_types = [
        'attendee' => 'Attendee',
        'delegate' => 'Delegate',
    ];

    foreach ($post_types as $slug => $singular_name) {
        $labels = [
            'name'               => __($singular_name . 's', 'your-text-domain'),
            'singular_name'      => __($singular_name, 'your-text-domain'),
            'menu_name'          => __($singular_name . 's', 'your-text-domain'),
            'name_admin_bar'     => __($singular_name, 'your-text-domain'),
            'add_new'            => __('Add New', 'your-text-domain'),
            'add_new_item'       => __('Add New ' . $singular_name, 'your-text-domain'),
            'edit_item'          => __('Edit ' . $singular_name, 'your-text-domain'),
            'new_item'           => __('New ' . $singular_name, 'your-text-domain'),
            'view_item'          => __('View ' . $singular_name, 'your-text-domain'),
            'search_items'       => __('Search ' . $singular_name . 's', 'your-text-domain'),
            'not_found'          => __('No ' . strtolower($singular_name) . 's found', 'your-text-domain'),
            'not_found_in_trash' => __('No ' . strtolower($singular_name) . 's found in Trash', 'your-text-domain'),
        ];

        $args = [
            'label'               => __($singular_name, 'your-text-domain'),
            'labels'              => $labels,
            'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-groups',
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
        ];

        register_post_type($slug, $args);
    }
}
add_action('init', 'create_attendees_and_delegates_post_types', 0);


add_filter('em_calendar_get_args', function( $args ) {
    if ( is_array( $args ) && array_key_exists( 'style', $args ) ) {
        unset( $args['style'] );
    }
    return $args;
});


function tribe_attachment_404_fix () {
	if (class_exists('Tribe__Events__Main')) {
		remove_action( 'init', array( Tribe__Events__Main::instance(), 'init' ), 10 );
		add_action( 'init', array( Tribe__Events__Main::instance(), 'init' ), 1 );
	}
}

add_action( 'after_setup_theme', 'tribe_attachment_404_fix' );

// Checks the URL for the debug parameter
// example.com/event/event-name/?tribe_query_debug=true
function tribe_events_pre_get_posts_dumper ($query) {
	$show_debug_info = isset($_GET['tribe_query_debug']) ? $_GET['tribe_query_debug'] : false;

	if(($show_debug_info == "true" && $query->is_main_query() === true) || $show_debug_info == "full") {
		echo "<h3>&lt;Tribe Events Query&gt;</h3>";
		tribe_spit_it_out($query);

		add_filter('the_posts', 'tribe_dump_return_query', 100, 1);
	}

}
add_action('pre_get_posts', 'tribe_events_pre_get_posts_dumper');

function tribe_dump_return_query($query) {

	echo '<p>Query Results:</p>';
	tribe_spit_it_out($query);

	echo '<p>is_404() = </p>';
	var_dump(is_404());

	echo '<h3>&lt;/Tribe Events Query&gt;</h3>';

	// Only run this once
	remove_filter('the_posts', 'tribe_dump_return_query', 100, 1);

	return $query;
}

function tribe_spit_it_out($var_for_dumping) {
	echo '<pre>';
	var_dump($var_for_dumping);
	echo '</pre>';
}

function tribe_link_prev_class($format) {
    $format = str_replace('href=', 'class="btn flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white space-x-2" href=', $format);
    return $format;
}
add_filter('tribe_the_prev_event_link', 'tribe_link_prev_class');

function tribe_link_next_class($format) {
    $format = str_replace('href=', 'class="btn flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white space-x-2" href=', $format);
    return $format;
}
add_filter('tribe_the_next_event_link', 'tribe_link_next_class');