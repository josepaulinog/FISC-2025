<?php

/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @link http://evnt.is/1aiy
 *
 * @package TribeEventsCalendar
 *
 * @version 4.6.19
 */


$event_id             = Tribe__Main::post_id_helper();
$time_format          = get_option('time_format', Tribe__Date_Utils::TIMEFORMAT);
$time_range_separator = tec_events_get_time_range_separator();
$show_time_zone       = tribe_get_option('tribe_events_timezones_show_zone', false);
$local_start_time     = tribe_get_start_date($event_id, true, Tribe__Date_Utils::DBDATETIMEFORMAT);
$time_zone_label      = Tribe__Events__Timezones::is_mode('site') ? Tribe__Events__Timezones::wp_timezone_abbr($local_start_time) : Tribe__Events__Timezones::get_event_timezone_abbr($event_id);

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date(null, false);
$start_time = tribe_get_start_date(null, false, $time_format);
$start_ts = tribe_get_start_date(null, false, Tribe__Date_Utils::DBDATEFORMAT);

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date(null, false);
$end_time = tribe_get_end_date(null, false, $time_format);
$end_ts = tribe_get_end_date(null, false, Tribe__Date_Utils::DBDATEFORMAT);

$time_formatted = null;
if ($start_time == $end_time) {
    $time_formatted = esc_html($start_time);
} else {
    $time_formatted = esc_html($start_time . $time_range_separator . $end_time);
}

/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters('tribe_events_single_event_time_formatted', $time_formatted, $event_id);

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters('tribe_events_single_event_time_title', __('Time:', 'the-events-calendar'), $event_id);

$cost    = tribe_get_formatted_cost();
$website = tribe_get_event_website_link($event_id);
$website_title = tribe_events_get_event_website_title();

// Get categories without links
$categories = get_the_terms($event_id, 'tribe_events_cat');
$categories_list = '';
if (!empty($categories) && !is_wp_error($categories)) {
    $cat_names = array();
    foreach ($categories as $category) {
        $cat_names[] = $category->name;
    }
    $categories_list = implode(', ', $cat_names);
}

// Get tags without links
$tags = get_the_terms($event_id, 'post_tag');
$tags_list = '';
if (!empty($tags) && !is_wp_error($tags)) {
    $tag_names = array();
    foreach ($tags as $tag) {
        $tag_names[] = $tag->name;
    }
    $tags_list = implode(', ', $tag_names);
}
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Left Column - Date & Time -->
    <div class="space-y-4">
        <?php
        do_action('tribe_events_single_meta_details_section_start');

        // All day (multiday) events
        if (tribe_event_is_all_day() && tribe_event_is_multiday()) : ?>
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div>
                    <dt class="font-medium"> <?php esc_html_e('Start:', 'the-events-calendar'); ?> </dt>
                    <dd class="text-gray-600">
                        <abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr($start_ts); ?>">
                            <?php echo esc_html($start_date); ?>
                        </abbr>
                    </dd>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div>
                    <dt class="font-medium"> <?php esc_html_e('End:', 'the-events-calendar'); ?> </dt>
                    <dd class="text-gray-600">
                        <abbr class="tribe-events-abbr tribe-events-end-date dtend" title="<?php echo esc_attr($end_ts); ?>">
                            <?php echo esc_html($end_date); ?>
                        </abbr>
                    </dd>
                </div>
            </div>

        <?php
        // All day (single day) events
        elseif (tribe_event_is_all_day()): ?>
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 mt-1 text-gray-500">
                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                </svg>
                <div>
                    <dt class="font-medium"> <?php esc_html_e('Date:', 'the-events-calendar'); ?> </dt>
                    <dd class="text-gray-600">
                        <abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr($start_ts); ?>">
                            <?php echo esc_html($start_date); ?>
                        </abbr>
                    </dd>
                </div>
            </div>

        <?php
        // Multiday events
        elseif (tribe_event_is_multiday()) : ?>
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <dt class="font-medium"> <?php esc_html_e('Start:', 'the-events-calendar'); ?> </dt>
                    <dd class="text-gray-600">
                        <abbr class="tribe-events-abbr tribe-events-start-datetime updated published dtstart" title="<?php echo esc_attr($start_ts); ?>">
                            <?php echo esc_html($start_datetime); ?>
                        </abbr>
                        <?php if ($show_time_zone) : ?>
                            <span class="tribe-events-abbr tribe-events-time-zone published text-sm ml-1">
                                <?php echo esc_html($time_zone_label); ?>
                            </span>
                        <?php endif; ?>
                    </dd>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <dt class="font-medium"> <?php esc_html_e('End:', 'the-events-calendar'); ?> </dt>
                    <dd class="text-gray-600">
                        <abbr class="tribe-events-abbr tribe-events-end-datetime dtend" title="<?php echo esc_attr($end_ts); ?>">
                            <?php echo esc_html($end_datetime); ?>
                        </abbr>
                        <?php if ($show_time_zone) : ?>
                            <span class="tribe-events-abbr tribe-events-time-zone published text-sm ml-1">
                                <?php echo esc_html($time_zone_label); ?>
                            </span>
                        <?php endif; ?>
                    </dd>
                </div>
            </div>

        <?php
        // Single day events
        else : ?>
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div>
                    <dt class="font-medium"> <?php esc_html_e('Date:', 'the-events-calendar'); ?> </dt>
                    <dd class="text-gray-600">
                        <abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr($start_ts); ?>">
                            <?php echo esc_html($start_date); ?>
                        </abbr>
                    </dd>
                </div>
            </div>

            <div class="flex items-start gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
</svg>
                <div>
                    <dt class="font-medium"> <?php echo esc_html($time_title); ?> </dt>
                    <dd class="text-gray-600">
                        <div class="tribe-events-abbr tribe-events-start-time published dtstart" title="<?php echo esc_attr($end_ts); ?>">
                            <?php echo $time_formatted; ?>
                            <?php if ($show_time_zone) : ?>
                                <span class="tribe-events-abbr tribe-events-time-zone published text-sm ml-1">
                                    <?php echo esc_html($time_zone_label); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </dd>
                </div>
            </div>
        <?php endif ?>
    </div>

    <!-- Right Column - Additional Details -->
    <div class="space-y-4">
        <?php do_action('tribe_events_single_meta_details_section_after_datetime'); ?>

        <?php if (! empty($cost)) : ?>
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <dt class="font-medium"> <?php esc_html_e('Cost:', 'the-events-calendar'); ?> </dt>
                    <dd class="text-gray-600"> <?php echo esc_html($cost); ?> </dd>
                </div>
            </div>
        <?php endif ?>

        <?php if (!empty($categories_list)) : ?>
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                </svg>
                <div>
                    <dt class="font-medium"><?php esc_html_e('Categories:', 'the-events-calendar'); ?></dt>
                    <dd class="text-gray-600"><?php echo esc_html($categories_list); ?></dd>
                </div>
            </div>
        <?php endif; ?>

        <?php if (! empty($website)) : ?>
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                <div>
                    <?php if (! empty($website_title)): ?>
                        <dt class="font-medium"> <?php echo esc_html($website_title); ?> </dt>
                    <?php endif; ?>
                    <dd class="text-gray-600"> <?php echo $website; ?> </dd>
                </div>
            </div>
        <?php endif ?>

        <?php if (!empty($tags_list)) : ?>
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                <div>
                    <dt class="font-medium">Tags: </dt>
                    <dd class="text-gray-600"><?php echo esc_html($tags_list); ?></dd>
                </div>
            </div>
        <?php endif; ?>

        <?php do_action('tribe_events_single_meta_details_section_end'); ?>
    </div>
</div>