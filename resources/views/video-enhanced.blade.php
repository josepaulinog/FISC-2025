{{--
  Template Name: Enhanced Video Gallery
--}}

@extends('layouts.app')

@section('content')
@include('partials.headers.default')

<div class="container mx-auto py-16">
    <div class="text-center lg:mb-12">
        <h2 class="text-3xl mb-4">Video Gallery</h2>
        <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
        <p class="text-lg max-w-2xl mx-auto text-neutral-600 dark:text-neutral-400 lg:mb-8">
            Missed a session? Watch expert discussions and key insights from FISC 2025, featuring top voices in government finance, technology, and policy.
        </p>
    </div>

    <!-- Alpine.js Video Gallery -->
    <div x-data="videoGallery()" x-init="initialize()">
    @php
// Get all events with videos
$events_with_videos = get_posts([
    'post_type' => 'tribe_events',
    'posts_per_page' => -1,
    'meta_query' => [
        [
            'key' => 'enable_video',
            'value' => '1',
            'compare' => '='
        ],
        [
            'key' => 'video_embed',
            'compare' => 'EXISTS'
        ]
    ]
]);

// Define custom days in the specific order
$custom_days = [
    '2025-04-07' => ['label' => 'Day 1', 'date' => 'April 7, 2025'],
    '2025-04-08' => ['label' => 'Day 2', 'date' => 'April 8, 2025'],
    '2025-04-09' => ['label' => 'Day 3', 'date' => 'April 9, 2025'],
    '2025-04-10' => ['label' => 'Day 4', 'date' => 'April 10, 2025'],
];

// Extract days from events (for filtering purposes)
$days = [];
foreach ($events_with_videos as $event) {
    $event_date = get_post_meta($event->ID, '_EventStartDate', true);
    if ($event_date) {
        $day = date('Y-m-d', strtotime($event_date));
        if (isset($custom_days[$day])) {
            $days[$day] = $custom_days[$day];
        }
    }
}

// Get categories from events with videos
$event_categories = [];
foreach ($events_with_videos as $event) {
    $terms = get_the_terms($event->ID, 'tribe_events_cat');
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            if (!isset($event_categories[$term->slug])) {
                $event_categories[$term->slug] = [
                    'name' => $term->name,
                    'count' => 1
                ];
            } else {
                $event_categories[$term->slug]['count']++;
            }
        }
    }
}

// Sort categories by count
uasort($event_categories, function($a, $b) {
    return $b['count'] - $a['count'];
});
@endphp

<!-- Day Tabs -->
<div class="tabs tabs-boxed mb-10">
    <a class="h-10 tab tab-bordered day-tab" 
       :class="activeDay === 'all' ? 'tab-active text-primary' : ''" 
       data-day="all" 
       @click="setDayFilter('all')">
        All Days
    </a>
    @foreach($custom_days as $day_key => $day_info)
        <a class="h-10 tab tab-bordered day-tab" 
           :class="activeDay === '{{ $day_key }}' ? 'tab-active text-primary' : ''" 
           data-day="{{ $day_key }}" 
           @click="setDayFilter('{{ $day_key }}')">
            <div class="flex flex-col items-center">
                <span class="font-medium">{{ $day_info['label'] }}</span>
                <span class="text-sm hidden">{{ $day_info['date'] }}</span>
            </div>
        </a>
    @endforeach
</div>

<div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6 mb-10">
    <!-- Category Filter -->
    <div>
        <h3 class="text-lg font-medium mb-3">Filter by Category</h3>
        <div role="tablist" class="filter-tabs tabs tabs-lifted tabs-lg">
            <a class="tab tab-bordered filter-tab" 
               :class="{ 'tab-active text-primary': activeCategory === 'all' }"
               data-filter="all" 
               @click="setCategoryFilter('all')">
                All
            </a>
            
            @foreach($event_categories as $slug => $category)
            <a class="tab tab-bordered filter-tab" 
               :class="{ 'tab-active text-primary': activeCategory === '{{ $slug }}' }"
               data-filter="{{ $slug }}" 
               @click="setCategoryFilter('{{ $slug }}')">
                {{ $category['name'] }}
                <span class="ml-1 text-xs opacity-70">({{ $category['count'] }})</span>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Search & Reset -->
    <div class="flex items-center gap-2">
        <div class="form-control">
            <input type="text"
                placeholder="Search videos..."
                class="input input-bordered w-full md:w-auto"
                x-model="searchQuery"
                @input="updateFilters()">
        </div>
        <button class="btn btn-ghost btn-sm" @click="resetFilters()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Reset
        </button>
    </div>
</div>       

        <!-- Video Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="video-grid" :class="{ 'opacity-50': isLoading }">
            @php
            foreach ($events_with_videos as $event) {
            $event_id = $event->ID;
            $video_url = get_post_meta($event_id, 'video_embed', true);

            // Skip if no video URL
            if (empty($video_url)) {
            continue;
            }

            // *** VIDEO COVER IMAGE RETRIEVAL ***
            $video_cover_id = get_post_meta($event_id, 'video_cover', true);
            $thumbnail_url = '';

            if (!empty($video_cover_id)) {
            // If it's an ID (numeric)
            if (is_numeric($video_cover_id)) {
            $image_array = wp_get_attachment_image_src($video_cover_id, 'large');
            if ($image_array) {
            $thumbnail_url = $image_array[0]; // The URL is the first element of the array
            }
            }
            // If it's already an array with URL key (ACF image field format)
            else if (is_array($video_cover_id) && isset($video_cover_id['url'])) {
            $thumbnail_url = $video_cover_id['url'];
            }
            // If it's a direct URL string
            else if (is_string($video_cover_id) && filter_var($video_cover_id, FILTER_VALIDATE_URL)) {
            $thumbnail_url = $video_cover_id;
            }
            }

            // Fallback to featured image if no video cover
            if (empty($thumbnail_url) && has_post_thumbnail($event_id)) {
            $thumbnail_url = get_the_post_thumbnail_url($event_id, 'large');
            }

            // Final fallback to placeholder
            if (empty($thumbnail_url)) {
            $thumbnail_url = get_template_directory_uri() . '/resources/images/video-placeholder.jpg';
            }

            // Get event date info
            $event_date = get_post_meta($event_id, '_EventStartDate', true);
            $event_day = date('Y-m-d', strtotime($event_date));
            $formatted_date = date('F j, Y', strtotime($event_date));

            // Get event categories
            $category_terms = get_the_terms($event_id, 'tribe_events_cat');
            $categories = [];
            $category_slugs = [];

            if ($category_terms && !is_wp_error($category_terms)) {
            foreach ($category_terms as $term) {
            $categories[] = $term->name;
            $category_slugs[] = $term->slug;
            }
            }

            // Get excerpt and content
            $excerpt = wp_trim_words(get_the_excerpt($event_id), 15);
            $description = wpautop(get_the_excerpt($event_id));

            // Get event permalink
            $event_url = get_permalink($event_id);

            // Prepare data attributes for filtering
            $title_attr = esc_attr($event->post_title);
            $videoUrlAttr = esc_attr($video_url);
            $description_attr = esc_attr($description);
            $event_url_attr = esc_attr($event_url);
            $date_attr = esc_attr($formatted_date);
            $categories_json = esc_attr(json_encode($categories));

            echo '<div class="video-item-container"
                data-day="' . $event_day . '"
                data-categories="' . implode(' ', $category_slugs) . '"
                data-title="' . strtolower($title_attr) . '"
                data-date="' . $date_attr . '"
                data-description="' . $description_attr . '"
                data-event-url="' . $event_url_attr . '"
                data-categories-json="' . $categories_json . '"
                x-show="isVisible(\'' . $event_day . '\', \'' . implode(' ', $category_slugs) . '\', \'' . strtolower($title_attr) . '\')"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">';
                echo '<div class="video-item group shadow-xl rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 border">
                    <div class="relative aspect-video cursor-pointer video-trigger"
                        data-video-url="' . $videoUrlAttr . '"
                        data-title="' . $title_attr . '"
                        data-date="' . $date_attr . '"
                        data-description="' . $description_attr . '"
                        data-event-url="' . $event_url_attr . '"
                        data-categories-json="' . $categories_json . '"
                        @click="openVideoModal(\'' . $videoUrlAttr . '\', \'' . $title_attr . '\')">
                        <img src="' . esc_url($thumbnail_url) . '"
                            alt="' . $title_attr . '"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-white opacity-80">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold line-clamp-2">' . $event->post_title . '</h3>';
                            if ($event_day) {
                            echo '<span class="badge badge-primary hidden">' . $event_day . '</span>';
                            }
                            echo '
                        </div>';

                        if ($formatted_date) {
                        echo '<div class="flex items-center text-sm text-gray-500 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                            </svg>
                            ' . $formatted_date . '
                        </div>';
                        }

                        if (count($categories) > 0) {
                        echo '<div class="flex flex-wrap gap-1 mb-3">';
                            foreach ($categories as $category) {
                            echo '<span class="badge badge-outline badge-sm">' . $category . '</span>';
                            }
                            echo '</div>';
                        }

                        if ($excerpt) {
                        echo '<div class="mt-2 line-clamp-2 text-sm text-gray-600">' . $excerpt . '</div>';
                        }

                        echo '
                    </div>
                </div>
            </div>';
            }
            @endphp
        </div>

        <!-- Empty State -->
        <div class="text-center py-12" id="empty-state" x-show="!hasVisibleItems" x-cloak>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto mb-4 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M12 18.75H4.5a2.25 2.25 0 01-2.25-2.25V9m12.841 9.091L16.5 19.5m-1.409-1.409c.407-.407.659-.97.659-1.591v-9a2.25 2.25 0 00-2.25-2.25h-9c-.621 0-1.184.252-1.591.659m12.182 12.182L2.909 5.909M1.5 4.5l1.409 1.409" />
            </svg>
            <h3 class="text-2xl font-semibold mb-2">No videos found</h3>
            <p class="text-gray-600">No videos match your current filter criteria.</p>
            <button class="btn btn-primary mt-4 text-white" @click="resetFilters()">Reset Filters</button>
        </div>

        <!-- Loading State -->
        <div class="text-center py-12" id="loading-state" x-show="isLoading" x-cloak>
            <div class="loading-spinner mb-4"></div>
            <p class="text-gray-600">Loading videos...</p>
        </div>

        <!-- Updated Full-Screen Video Modal with Event Details -->
        <dialog id="video-modal" class="modal" x-ref="videoModal">
            <div class="modal-box max-w-none w-full h-full m-0 p-0 rounded-none bg-black overflow-hidden flex flex-col">
                <!-- Close button -->
                <form method="dialog">
                    <button class="btn btn-circle btn-ghost text-white absolute right-4 top-4 z-10">✕</button>
                </form>

                <!-- Navigation arrows -->
                <button id="prev-video-btn"
                    class="hidden md:flex absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-black/50 hover:bg-black/75 text-white rounded-full p-2"
                    @click="navigateVideo('prev')"
                    x-show="videoItems.length > 1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button id="next-video-btn"
                    class="hidden md:flex absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-black/50 hover:bg-black/75 text-white rounded-full p-2"
                    @click="navigateVideo('next')"
                    x-show="videoItems.length > 1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Video container - adjusted to take up available space -->
                <div class="w-full flex-1 flex items-center justify-center bg-black">
                    <iframe id="video-iframe"
                        class="w-full h-full md:h-auto md:aspect-video md:max-h-[70vh]"
                        x-ref="videoIframe"
                        title="Video"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>

                <!-- Video details section -->
                <div class="p-6 bg-black text-white max-h-[30vh] overflow-y-auto">
                    <div class="container mx-auto max-w-4xl">
                        <h3 id="video-title" class="text-2xl font-bold mb-2" x-text="currentVideoTitle"></h3>

                        <!-- Event meta info -->
                        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-300 mb-4">
                            <span x-show="currentVideoDate" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                </svg>
                                <span x-text="currentVideoDate"></span>
                            </span>

                            <span x-show="currentVideoCategories && currentVideoCategories.length > 0" class="flex flex-wrap gap-1">
                                <template x-for="category in currentVideoCategories" :key="category">
                                    <span class="badge badge-outline badge-sm" x-text="category"></span>
                                </template>
                            </span>
                        </div>

                        <!-- Event description -->
                        <div class="prose prose-sm prose-invert mb-6" x-html="currentVideoDescription"></div>

                        <!-- Link to event button -->
                        <a x-bind:href="currentVideoEventUrl" class="btn btn-primary text-white" x-show="currentVideoEventUrl">
                            View Event Details
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Modal backdrop - clickable to close -->
            <form method="dialog" class="modal-backdrop backdrop-filter backdrop-blur-sm">
                <button>close</button>
            </form>
        </dialog>
    </div>
</div>
@endsection

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('videoGallery', () => ({
            videoItems: [],
            currentVideoIndex: 0,
            currentVideoTitle: '',
            currentVideoDate: '',
            currentVideoDescription: '',
            currentVideoEventUrl: '',
            currentVideoCategories: [],
            activeDay: 'all',
            activeCategory: 'all',
            searchQuery: '',
            isLoading: false,
            hasVisibleItems: true,

            initialize() {
                // Collect all video items on page load
                this.collectVideoItems();

                // Set up keyboard navigation for the modal
                document.addEventListener('keydown', (e) => {
                    const modal = this.$refs.videoModal;
                    if (modal && modal.open) {
                        if (e.key === 'ArrowLeft') {
                            this.navigateVideo('prev');
                        } else if (e.key === 'ArrowRight') {
                            this.navigateVideo('next');
                        }
                    }
                });

                // Setup dialog close event to stop video playback
                this.$refs.videoModal.addEventListener('close', () => {
                    this.$refs.videoIframe.src = '';
                });

                // Initial check for visible items
                this.checkVisibleItems();
            },

            collectVideoItems() {
                // Get all video trigger elements and create the video item array
                const videoTriggers = document.querySelectorAll('.video-trigger');
                this.videoItems = Array.from(videoTriggers).map(trigger => {
                    return {
                        url: trigger.dataset.videoUrl,
                        title: trigger.dataset.title,
                        date: trigger.dataset.date || '',
                        description: trigger.dataset.description || '',
                        eventUrl: trigger.dataset.eventUrl || '',
                        categories: trigger.dataset.categoriesJson ? JSON.parse(trigger.dataset.categoriesJson) : []
                    };
                });

                console.log('Collected video items:', this.videoItems.length);
            },

            isVisible(day, categories, title) {
                // Day filter - check if we should show all days or this specific day
                const dayMatch = this.activeDay === 'all' || day === this.activeDay;

                // Category filter
                const categoryMatch = this.activeCategory === 'all' || categories.includes(this.activeCategory);

                // Search filter
                const searchMatch = this.searchQuery === '' || title.includes(this.searchQuery.toLowerCase());

                return dayMatch && categoryMatch && searchMatch;
            },

            setDayFilter(day) {
                // Changed from setdayFilter to setDayFilter
                this.isLoading = true;
                this.activeDay = day;

                setTimeout(() => {
                    this.isLoading = false;
                    this.checkVisibleItems();
                }, 300);
            },

            setCategoryFilter(category) {
                this.isLoading = true;
                this.activeCategory = category;

                setTimeout(() => {
                    this.isLoading = false;
                    this.checkVisibleItems();
                }, 300);
            },

            updateFilters() {
                this.isLoading = true;

                setTimeout(() => {
                    this.isLoading = false;
                    this.checkVisibleItems();
                }, 300);
            },

            resetFilters() {
                this.isLoading = true;
                this.activeDay = 'all';
                this.activeCategory = 'all';
                this.searchQuery = '';

                setTimeout(() => {
                    this.isLoading = false;
                    this.checkVisibleItems();
                }, 300);
            },

            checkVisibleItems() {
                const containers = document.querySelectorAll('.video-item-container');
                this.hasVisibleItems = Array.from(containers).some(item => {
                    const day = item.dataset.day;
                    const categories = item.dataset.categories;
                    const title = item.dataset.title;

                    return this.isVisible(day, categories, title);
                });
            },

            openVideoModal(videoUrl, title) {
                // Find the video item in our collected array
                const videoItem = this.videoItems.find(item =>
                    item.url === videoUrl && item.title === title
                );

                if (!videoItem) {
                    console.error('Video not found in collection:', videoUrl, title);
                    return;
                }

                // Update all video metadata
                this.currentVideoTitle = videoItem.title;
                this.currentVideoDate = videoItem.date;
                this.currentVideoDescription = videoItem.description;
                this.currentVideoEventUrl = videoItem.eventUrl;
                this.currentVideoCategories = videoItem.categories;

                // Find the index for navigation
                this.currentVideoIndex = this.videoItems.findIndex(item =>
                    item.url === videoUrl && item.title === title
                );

                // Process YouTube URLs
                if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                    // Extract YouTube ID
                    let youtubeId = '';
                    if (videoUrl.includes('youtube.com/watch?v=')) {
                        youtubeId = videoUrl.split('v=')[1].split('&')[0];
                    } else if (videoUrl.includes('youtu.be/')) {
                        youtubeId = videoUrl.split('youtu.be/')[1].split('?')[0];
                    } else if (videoUrl.includes('youtube.com/embed/')) {
                        youtubeId = videoUrl.split('embed/')[1].split('?')[0];
                    }

                    if (youtubeId) {
                        this.$refs.videoIframe.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0`;
                    }
                }
                // Process Vimeo URLs
                else if (videoUrl.includes('vimeo.com')) {
                    const vimeoId = videoUrl.split('vimeo.com/')[1].split('?')[0];
                    this.$refs.videoIframe.src = `https://player.vimeo.com/video/${vimeoId}?autoplay=1`;
                }
                // Direct embed URL or fallback
                else {
                    this.$refs.videoIframe.src = videoUrl;
                }

                // Open the modal using the DaisyUI dialog method
                this.$refs.videoModal.showModal();
            },

            navigateVideo(direction) {
                if (this.videoItems.length <= 1) return;

                if (direction === 'prev') {
                    this.currentVideoIndex = (this.currentVideoIndex - 1 + this.videoItems.length) % this.videoItems.length;
                } else {
                    this.currentVideoIndex = (this.currentVideoIndex + 1) % this.videoItems.length;
                }

                const nextVideo = this.videoItems[this.currentVideoIndex];

                // Update all metadata for the next video
                this.currentVideoTitle = nextVideo.title;
                this.currentVideoDate = nextVideo.date;
                this.currentVideoDescription = nextVideo.description;
                this.currentVideoEventUrl = nextVideo.eventUrl;
                this.currentVideoCategories = nextVideo.categories;

                // Process the video URL
                let videoUrl = nextVideo.url;

                // Process YouTube URLs
                if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                    // Extract YouTube ID
                    let youtubeId = '';
                    if (videoUrl.includes('youtube.com/watch?v=')) {
                        youtubeId = videoUrl.split('v=')[1].split('&')[0];
                    } else if (videoUrl.includes('youtu.be/')) {
                        youtubeId = videoUrl.split('youtu.be/')[1].split('?')[0];
                    } else if (videoUrl.includes('youtube.com/embed/')) {
                        youtubeId = videoUrl.split('embed/')[1].split('?')[0];
                    }

                    if (youtubeId) {
                        this.$refs.videoIframe.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0`;
                    }
                    // Process Vimeo URLs
                } else if (videoUrl.includes('vimeo.com')) {
                    const vimeoId = videoUrl.split('vimeo.com/')[1].split('?')[0];
                    this.$refs.videoIframe.src = `https://player.vimeo.com/video/${vimeoId}?autoplay=1`;
                    // Direct embed URL or fallback
                } else {
                    this.$refs.videoIframe.src = videoUrl;
                }
            }
        }));
    });
</script>

<style>
    /* Full-screen modal styles */
    #video-modal {
        overflow: hidden;
    }

    #video-modal .modal-box {
        max-width: 80%;
        width: 80%;
        height: 80vh;
        margin: auto;
        padding: 0;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* Responsive modal content */
    @media (min-width: 768px) {
        #video-modal .modal-box {
            display: flex;
            flex-direction: column;
        }

        #video-modal iframe {
            max-height: 70vh;
        }
    }

    /* Video container */
    #video-modal .w-full.flex-1 {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: black;
    }

    /* Details section */
    #video-modal .p-6 {
        max-height: 20vh;
        overflow-y: auto;
        background-color: #0f0f0f;
    }

    /* Prevent body scrolling when modal is open */
    body.overflow-hidden {
        overflow: hidden;
    }

    /* Navigation button styling with improved contrast */
    #prev-video-btn,
    #next-video-btn {
        opacity: 0.8;
        transition: opacity 0.2s ease, transform 0.2s ease;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    #prev-video-btn:hover,
    #next-video-btn:hover {
        opacity: 1;
    }

    /* Transition effects */
    .video-item-container {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    /* Video item hover effects */
    .video-item {
        transition: all 0.3s ease;
    }

    .video-item:hover {
        transform: translateY(-5px);
    }

    /* Loading animation */
    .loading-spinner {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        border: 3px solid rgba(0, 0, 0, 0.1);
        border-top-color: #fd6b18;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Smooth transitions for filter changes */
    #video-grid {
        transition: opacity 0.3s ease;
    }

    /* Alpine cloak to prevent flash of unstyled content */
    [x-cloak] {
        display: none !important;
    }

    /* Event details styling */
    #video-modal .prose.prose-invert {
        color: #e0e0e0;
    }

    #video-modal .badge {
        background-color: rgba(255, 255, 255, 0.1);
        color: #e0e0e0;
    }

    /* "View Event Details" button styling */
    #video-modal .btn-primary {
        display: inline-flex;
        align-items: center;
        transition: transform 0.2s ease;
    }

    #video-modal .btn-primary:hover {
        transform: translateY(-2px);
    }

    /* Animation for modal open */
    @keyframes modal-scale-in {
        from {
            opacity: 0;
            transform: scale(0.98);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    #video-modal.modal-open .modal-box {
        animation: modal-scale-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Make close button more visible */
    #video-modal .btn-circle {
        background-color: rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: background-color 0.2s ease;
    }

    #video-modal .btn-circle:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .tabs-boxed>.tab-active {
        color: #ffffff !important;
    }
</style>