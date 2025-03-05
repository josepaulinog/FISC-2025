<?php

namespace App;

/**
 * Video Helper Functions for the video gallery
 */

// Function to extract video ID from various video platforms
function extract_video_id($url) {
    $video_id = '';
    
    // YouTube
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches) || 
        preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches) || 
        preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
        $video_id = $matches[1];
        return [
            'platform' => 'youtube',
            'id' => $video_id
        ];
    }
    
    // Vimeo
    if (preg_match('/vimeo\.com\/([0-9]+)/', $url, $matches) || 
        preg_match('/player\.vimeo\.com\/video\/([0-9]+)/', $url, $matches)) {
        $video_id = $matches[1];
        return [
            'platform' => 'vimeo',
            'id' => $video_id
        ];
    }
    
    return false;
}

// Function to get video thumbnail URL
function get_video_thumbnail($url) {
    $video = extract_video_id($url);
    
    if (!$video) {
        return '';
    }
    
    if ($video['platform'] === 'youtube') {
        // Return the highest quality thumbnail
        return 'https://img.youtube.com/vi/' . $video['id'] . '/maxresdefault.jpg';
    }
    
    if ($video['platform'] === 'vimeo') {
        // Get Vimeo thumbnail (needs API access, fallback to placeholder)
        $vimeo_data = json_decode(file_get_contents('https://vimeo.com/api/v2/video/' . $video['id'] . '.json'));
        
        if ($vimeo_data && !empty($vimeo_data[0]->thumbnail_large)) {
            return $vimeo_data[0]->thumbnail_large;
        }
    }
    
    // Return default placeholder if no thumbnail found
    return get_template_directory_uri() . '/resources/images/video-placeholder.jpg';
}

// Function to get embed URL
function get_embed_url($url) {
    $video = extract_video_id($url);
    
    if (!$video) {
        return $url; // Return original if not recognized
    }
    
    if ($video['platform'] === 'youtube') {
        return 'https://www.youtube.com/embed/' . $video['id'] . '?autoplay=1&rel=0';
    }
    
    if ($video['platform'] === 'vimeo') {
        return 'https://player.vimeo.com/video/' . $video['id'] . '?autoplay=1';
    }
    
    return $url;
}

// Function to validate video URL
function is_valid_video_url($url) {
    return (
        strpos($url, 'youtube.com') !== false ||
        strpos($url, 'youtu.be') !== false ||
        strpos($url, 'vimeo.com') !== false ||
        strpos($url, '.mp4') !== false
    );
}

// Function to group videos by year
function group_videos_by_year($videos) {
    $grouped = [];
    
    foreach ($videos as $video) {
        $event_date = get_post_meta($video->ID, '_EventStartDate', true);
        $year = date('Y', strtotime($event_date));
        
        if (!isset($grouped[$year])) {
            $grouped[$year] = [];
        }
        
        $grouped[$year][] = $video;
    }
    
    // Sort years in descending order
    krsort($grouped);
    
    return $grouped;
}

// Get all available video categories
function get_video_categories() {
    $events_with_videos = get_posts([
        'post_type' => 'tribe_events',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => 'enable_video',
                'value' => '1',
                'compare' => '='
            ]
        ]
    ]);
    
    $categories = [];
    
    foreach ($events_with_videos as $event) {
        $terms = get_the_terms($event->ID, 'tribe_events_cat');
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                if (!isset($categories[$term->slug])) {
                    $categories[$term->slug] = [
                        'name' => $term->name,
                        'count' => 1
                    ];
                } else {
                    $categories[$term->slug]['count']++;
                }
            }
        }
    }
    
    // Sort by count
    uasort($categories, function($a, $b) {
        return $b['count'] - $a['count'];
    });
    
    return $categories;
}

// Register custom shortcode for video gallery
add_shortcode('video_gallery', function($atts) {
    $atts = shortcode_atts([
        'category' => '',
        'year' => '',
        'limit' => 12,
    ], $atts);
    
    $args = [
        'post_type' => 'tribe_events',
        'posts_per_page' => $atts['limit'],
        'meta_query' => [
            [
                'key' => 'enable_video',
                'value' => '1',
                'compare' => '='
            ]
        ],
        'orderby' => 'meta_value',
        'meta_key' => '_EventStartDate',
        'order' => 'DESC',
    ];
    
    // Filter by category if specified
    if (!empty($atts['category'])) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'tribe_events_cat',
                'field' => 'slug',
                'terms' => $atts['category'],
            ]
        ];
    }
    
    // Filter by year if specified
    if (!empty($atts['year'])) {
        $start_date = $atts['year'] . '-01-01 00:00:00';
        $end_date = $atts['year'] . '-12-31 23:59:59';
        
        $args['meta_query'][] = [
            'key' => '_EventStartDate',
            'value' => [$start_date, $end_date],
            'compare' => 'BETWEEN',
            'type' => 'DATETIME'
        ];
    }
    
    $events = get_posts($args);
    
    if (empty($events)) {
        return '<div class="text-center py-6">No videos found matching your criteria.</div>';
    }
    
    ob_start();
    
    echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';
    
    foreach ($events as $event) {
        $event_id = $event->ID;
        $video_url = get_post_meta($event_id, 'video_embed', true);
        
        if (empty($video_url)) {
            continue;
        }
        
        $video_cover = get_post_meta($event_id, 'video_cover', true);
        $cover_image = '';
        
        if (!empty($video_cover) && is_array($video_cover)) {
            $cover_image = $video_cover['url'];
        } elseif (has_post_thumbnail($event_id)) {
            $cover_image = get_the_post_thumbnail_url($event_id, 'large');
        } else {
            // Get thumbnail from video URL
            $cover_image = get_video_thumbnail($video_url);
        }
        
        $event_date = get_post_meta($event_id, '_EventStartDate', true);
        $formatted_date = date('F j, Y', strtotime($event_date));
        
        echo '<div class="video-item group shadow-xl rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <div class="relative aspect-video cursor-pointer" 
                     onclick="openVideoModal(\'' . esc_attr($video_url) . '\', \'' . esc_attr($event->post_title) . '\')">
                  <img src="' . esc_url($cover_image) . '" 
                       alt="' . esc_attr($event->post_title) . '" 
                       class="w-full h-full object-cover">
                  <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-white opacity-80">
                      <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z" clip-rule="evenodd" />
                    </svg>
                  </div>
                </div>
                <div class="p-4">
                  <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-semibold line-clamp-2">' . $event->post_title . '</h3>
                  </div>
                  <div class="flex items-center text-sm text-gray-500 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                    </svg>
                    ' . $formatted_date . '
                  </div>';
                  
        // Show event categories
        $terms = get_the_terms($event_id, 'tribe_events_cat');
        if ($terms && !is_wp_error($terms)) {
            echo '<div class="flex flex-wrap gap-1">';
            foreach ($terms as $term) {
                echo '<span class="badge badge-outline badge-sm">' . $term->name . '</span>';
            }
            echo '</div>';
        }
          
        echo '</div>
            </div>';
    }
    
    echo '</div>';
    
    return ob_get_clean();
});

function create_youtube_player($video_url, $poster_url = '', $container_id = null, $autoplay = false) {
    // Extract video ID
    $video = extract_video_id($video_url);
    
    if (!$video || $video['platform'] !== 'youtube') {
        return '<div class="alert alert-error">Invalid YouTube URL</div>';
    }
    
    $video_id = $video['id'];
    
    // Generate unique ID if not provided
    if (!$container_id) {
        $container_id = 'youtube-player-' . uniqid();
    }
    
    // Use provided poster or get YouTube thumbnail
    if (empty($poster_url) && is_array($poster_url) && isset($poster_url['url'])) {
        $poster_url = $poster_url['url'];
    } elseif (empty($poster_url)) {
        $poster_url = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
    }
    
    $output = '<div class="aspect-w-16 aspect-h-9 relative" id="' . esc_attr($container_id) . '-container">';
    
    // Create poster with play button overlay
    if (!$autoplay) {
        $output .= '<div class="youtube-poster absolute inset-0 bg-cover bg-center flex items-center justify-center cursor-pointer" 
                      style="background-image: url(\'' . esc_url($poster_url) . '\');" 
                      onclick="initYouTubePlayer_' . esc_attr($container_id) . '()">
                    <div class="play-button w-16 h-16 md:w-24 md:h-24 rounded-full bg-primary/80 flex items-center justify-center transition-transform hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>';
    }
    
    $output .= '<div id="' . esc_attr($container_id) . '" class="' . ($autoplay ? '' : 'hidden') . ' w-full h-full"></div>';
    
    // Add script to initialize YouTube player
    $output .= '<script>
        // Load YouTube API if needed
        if (!window.YT) {
            var tag = document.createElement("script");
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName("script")[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        }
        
        // Initialize player function
        function initYouTubePlayer_' . esc_attr($container_id) . '() {
            var poster = document.querySelector("#' . esc_attr($container_id) . '-container .youtube-poster");
            if (poster) {
                poster.classList.add("hidden");
            }
            
            document.getElementById("' . esc_attr($container_id) . '").classList.remove("hidden");
            
            if (typeof YT !== "undefined" && YT.Player) {
                createYouTubePlayer_' . esc_attr($container_id) . '();
            } else {
                // Wait for API to load
                window.onYouTubeIframeAPIReady = function() {
                    createYouTubePlayer_' . esc_attr($container_id) . '();
                };
            }
        }
        
        // Create player function
        function createYouTubePlayer_' . esc_attr($container_id) . '() {
            new YT.Player("' . esc_attr($container_id) . '", {
                videoId: "' . esc_attr($video_id) . '",
                playerVars: {
                    autoplay: 1,
                    modestbranding: 1,
                    rel: 0,
                    showinfo: 0,
                    controls: 1,
                    playsinline: 1
                },
                events: {
                    onReady: function(event) {
                        event.target.playVideo();
                    }
                }
            });
        }
        
        ' . ($autoplay ? 'document.addEventListener("DOMContentLoaded", initYouTubePlayer_' . esc_attr($container_id) . ');' : '') . '
    </script>';
    
    $output .= '</div>';
    
    return $output;
}

// Function to create native HTML5 video player
function create_html5_player($video_url, $poster_url = '', $autoplay = false) {
    // Handle ACF image field
    if (is_array($poster_url) && isset($poster_url['url'])) {
        $poster_url = $poster_url['url'];
    }
    
    $poster_attr = !empty($poster_url) ? ' poster="' . esc_url($poster_url) . '"' : '';
    $autoplay_attr = $autoplay ? ' autoplay' : '';
    
    return '<div class="aspect-w-16 aspect-h-9">
        <video class="rounded-lg w-full h-full object-cover" controls' . $poster_attr . $autoplay_attr . ' preload="auto" playsinline>
            <source src="' . esc_url($video_url) . '" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>';
}

// Function to create appropriate video player based on URL
function create_video_player($video_url, $poster_url = '', $autoplay = false) {
    if (empty($video_url)) {
        return '';
    }
    
    // Determine video type and use appropriate player
    $video = extract_video_id($video_url);
    
    if ($video && $video['platform'] == 'youtube') {
        return create_youtube_player($video_url, $poster_url, null, $autoplay);
    } elseif ($video && $video['platform'] == 'vimeo') {
        // For vimeo, we could create a similar player but keeping simple for now
        return '<div class="aspect-w-16 aspect-h-9">
            <iframe class="rounded-lg w-full h-full" src="https://player.vimeo.com/video/' . esc_attr($video['id']) . '?autoplay=' . ($autoplay ? '1' : '0') . '&title=0&byline=0&portrait=0" 
                frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        </div>';
    } else {
        // Default to HTML5 player for direct video files
        return create_html5_player($video_url, $poster_url, $autoplay);
    }
}

// Add helper function to setup.php
add_action('after_setup_theme', function() {
    require_once __DIR__ . '/video-helper.php';
}, 20);