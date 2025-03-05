<?php
/**
 * Event Video Template Part
 *
 * This template part renders the event video using native browser capabilities
 * instead of video.js. It supports both YouTube and direct video files.
 *
 * @package FISC_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check if video is enabled
$video_enabled = get_field('enable_video');

// Get video URL and cover image
$video_url = get_field('video_embed');
$video_cover = get_field('video_cover');

// Only proceed if video is enabled and URL is provided
if (!$video_enabled || empty($video_url)) {
    return;
}

// Extract YouTube video ID if needed
$youtube_id = '';
$is_youtube = false;

if (preg_match('/youtu\.be\/([^\?&]+)/', $video_url, $matches) || 
    preg_match('/youtube\.com\/watch\?v=([^\?&]+)/', $video_url, $matches) ||
    preg_match('/youtube\.com\/embed\/([^\/\?&]+)/', $video_url, $matches)) {
    $youtube_id = $matches[1];
    $is_youtube = true;
}

// Get poster URL
$poster_url = '';
if (!empty($video_cover) && is_array($video_cover) && isset($video_cover['url'])) {
    $poster_url = $video_cover['url'];
} elseif ($is_youtube && !empty($youtube_id)) {
    $poster_url = "https://img.youtube.com/vi/{$youtube_id}/maxresdefault.jpg";
}

// Generate a unique ID for the video container
$container_id = 'event-video-' . uniqid();
?>

<div class="event-video-container w-full max-w-4xl mx-auto">
    <hr class="my-4">
    <h3 class="text-xl mb-4">Video</h3>
    
    <?php if ($is_youtube && !empty($youtube_id)) : ?>
        <!-- YouTube Video with Alpine.js -->
        <div x-data="{ 
            videoLoaded: false,
            videoId: '<?php echo esc_attr($youtube_id); ?>',
            posterId: '<?php echo esc_attr($container_id); ?>-poster',
            playerId: '<?php echo esc_attr($container_id); ?>-player'
        }" class="relative overflow-hidden rounded-lg shadow-lg border">
            <!-- Poster Image with Play Button (shown until clicked) -->
            <div 
                x-show="!videoLoaded" 
                x-on:click="videoLoaded = true; loadYouTubePlayer()"
                x-bind:id="posterId"
                class="aspect-w-16 aspect-h-9 cursor-pointer"
            >
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url($poster_url); ?>');">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                        <div class="w-16 h-16 md:w-24 md:h-24 rounded-full bg-primary/80 flex items-center justify-center transition-transform hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- YouTube Player (hidden until poster is clicked) -->
            <div 
                x-show="videoLoaded" 
                x-bind:id="playerId" 
                class="aspect-w-16 aspect-h-9"
            ></div>
        </div>
        
        <!-- JavaScript to load YouTube API and initialize player -->
        <script>
            document.addEventListener('alpine:init', () => {
                window.loadYouTubePlayer = function() {
                    const containerId = '<?php echo esc_attr($container_id); ?>';
                    const playerId = containerId + '-player';
                    const videoId = '<?php echo esc_attr($youtube_id); ?>';
                    
                    // Load YouTube API if needed
                    if (!window.YT) {
                        const tag = document.createElement('script');
                        tag.src = "https://www.youtube.com/iframe_api";
                        
                        tag.onload = function() {
                            // API will call onYouTubeIframeAPIReady automatically
                            window.onYouTubeIframeAPIReady = function() {
                                createYouTubePlayer(playerId, videoId);
                            };
                        };
                        
                        const firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                    } else if (window.YT && window.YT.Player) {
                        // API already loaded
                        createYouTubePlayer(playerId, videoId);
                    } else {
                        // API script added but not yet ready
                        window.onYouTubeIframeAPIReady = function() {
                            createYouTubePlayer(playerId, videoId);
                        };
                    }
                };
                
                function createYouTubePlayer(playerId, videoId) {
                    new YT.Player(playerId, {
                        videoId: videoId,
                        playerVars: {
                            autoplay: 1,
                            modestbranding: 1,
                            rel: 0,
                            showinfo: 0,
                            controls: 1,
                            playsinline: 1
                        },
                        events: {
                            'onReady': function(event) {
                                event.target.playVideo();
                            }
                        }
                    });
                }
            });
        </script>
    <?php else : ?>
        <!-- Native HTML5 Video Player -->
        <div class="relative overflow-hidden rounded-lg shadow-lg border">
            <div class="aspect-w-16 aspect-h-9">
                <video
                    id="<?php echo esc_attr($container_id); ?>"
                    class="rounded-lg w-full h-full object-cover"
                    controls
                    preload="auto"
                    playsinline
                    <?php if (!empty($poster_url)) : ?>
                        poster="<?php echo esc_url($poster_url); ?>"
                    <?php endif; ?>
                >
                    <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($video_cover) && isset($video_cover['caption']) && !empty($video_cover['caption'])) : ?>
        <div class="mt-2 text-sm text-gray-600 italic">
            <?php echo esc_html($video_cover['caption']); ?>
        </div>
    <?php endif; ?>
</div>