{{--
  Template Name: Video Gallery Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.headers.default')

  <div class="container mx-auto py-16">
    <div class="text-center lg:mb-12">
      <h2 class="text-3xl mb-4">Key Insights, Anytime</h2>
      <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
      <p class="text-lg max-w-2xl mx-auto text-neutral-600 dark:text-neutral-400 lg:mb-12">
      Watch expert discussions and top takeaways from FISC 2025, all in one place.
      </p>
    </div>

    <!-- Filter controls -->
    <div class="mb-10">
      <!-- Year filter -->
      <div class="mb-6">
        <h3 class="text-xl font-semibold mb-4">Filter by Year</h3>
        <div class="flex flex-wrap gap-2">
          <button class="btn btn-sm year-filter active" data-year="all">All Years</button>
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
                ]
              ]
            ]);
            
            // Extract years from events
            $years = [];
            foreach ($events_with_videos as $event) {
              $event_date = get_post_meta($event->ID, '_EventStartDate', true);
              if ($event_date) {
                $year = date('Y', strtotime($event_date));
                if (!in_array($year, $years)) {
                  $years[] = $year;
                }
              }
            }
            
            // Sort years in descending order
            rsort($years);
          @endphp
          
          @foreach($years as $year)
            <button class="btn btn-sm year-filter" data-year="{{ $year }}">{{ $year }}</button>
          @endforeach
        </div>
      </div>
      
      <!-- Category filter -->
      <div class="mb-6">
        <h3 class="text-xl font-semibold mb-4">Filter by Category</h3>
        <div class="tabs tabs-boxed">
          <button class="tab tab-active category-filter" data-category="all">All Categories</button>
          @php
            // Get all categories from events with videos
            $categories = [];
            foreach ($events_with_videos as $event) {
              $terms = get_the_terms($event->ID, 'tribe_events_cat');
              if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                  if (!isset($categories[$term->slug])) {
                    $categories[$term->slug] = $term->name;
                  }
                }
              }
            }
          @endphp
          
          @foreach($categories as $slug => $name)
            <button class="tab category-filter" data-category="{{ $slug }}">{{ $name }}</button>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Video Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 video-gallery">
      @php
        foreach ($events_with_videos as $event) {
          $event_id = $event->ID;
          $video_url = get_post_meta($event_id, 'video_embed', true);
          $video_cover = get_post_meta($event_id, 'video_cover', true);
          $event_date = get_post_meta($event_id, '_EventStartDate', true);
          $event_year = date('Y', strtotime($event_date));
          
          // Get event categories
          $event_categories = [];
          $terms = get_the_terms($event_id, 'tribe_events_cat');
          if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
              $event_categories[] = $term->slug;
            }
          }
          
          // Only include events with videos
          if (!empty($video_url)) {
            // Get cover image
            $cover_image = '';
            if (!empty($video_cover) && is_array($video_cover)) {
              $cover_image = $video_cover['url'];
            } elseif (has_post_thumbnail($event_id)) {
              $cover_image = get_the_post_thumbnail_url($event_id, 'large');
            } else {
              // Default cover with play button
              $cover_image = get_template_directory_uri() . '/resources/images/video-placeholder.jpg';
            }
            
            // Format event date for display
            $formatted_date = date('F j, Y', strtotime($event_date));
            
            echo '<div class="video-item group shadow-xl rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300" 
                      data-year="' . $event_year . '" 
                      data-categories="' . implode(' ', $event_categories) . '">
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
                        <span class="badge badge-primary">' . $event_year . '</span>
                      </div>
                      <div class="flex items-center text-sm text-gray-500 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                        </svg>
                        ' . $formatted_date . '
                      </div>';
                      
                      if (!empty($event_categories)) {
                        echo '<div class="flex flex-wrap gap-1">';
                        foreach ($terms as $term) {
                          echo '<span class="badge badge-outline badge-sm">' . $term->name . '</span>';
                        }
                        echo '</div>';
                      }
                      
                      echo '<div class="mt-2 line-clamp-2 text-sm text-gray-600">' . wp_trim_words(get_the_excerpt($event_id), 15) . '</div>
                    </div>
                  </div>';
          }
        }
      @endphp
    </div>
    
    <!-- Empty State -->
    <div class="hidden empty-state text-center py-12">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto mb-4 text-gray-400">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M12 18.75H4.5a2.25 2.25 0 01-2.25-2.25V9m12.841 9.091L16.5 19.5m-1.409-1.409c.407-.407.659-.97.659-1.591v-9a2.25 2.25 0 00-2.25-2.25h-9c-.621 0-1.184.252-1.591.659m12.182 12.182L2.909 5.909M1.5 4.5l1.409 1.409" />
      </svg>
      <h3 class="text-2xl font-semibold mb-2">No videos found</h3>
      <p class="text-gray-600">No videos match your current filters. Try adjusting your filters or check back later.</p>
      <button class="btn btn-primary mt-4 reset-filters">Reset Filters</button>
    </div>
  </div>

  <!-- Video Modal -->
  <div id="video-modal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl p-0 bg-black">
      <form method="dialog" class="absolute right-2 top-2 z-10">
        <button class="btn btn-sm btn-circle btn-ghost text-white">✕</button>
      </form>
      <div class="aspect-video">
        <iframe id="video-iframe" class="w-full h-full" src="" title="Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
      <div class="p-4 bg-black text-white">
        <h3 id="video-title" class="text-xl font-bold"></h3>
      </div>
    </div>
    <form method="dialog" class="modal-backdrop">
      <button>close</button>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    window.openVideoModal = function(videoUrl, title) {
      const modal = document.getElementById('video-modal');
      const iframe = document.getElementById('video-iframe');
      const videoTitle = document.getElementById('video-title');
      
      // Process YouTube URLs
      if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
        // Extract YouTube ID
        let youtubeId = '';
        if (videoUrl.includes('youtube.com/watch?v=')) {
          youtubeId = videoUrl.split('v=')[1].split('&')[0];
        } else if (videoUrl.includes('youtu.be/')) {
          youtubeId = videoUrl.split('youtu.be/')[1];
        }
        
        if (youtubeId) {
          iframe.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1`;
        }
      } 
      // Process Vimeo URLs
      else if (videoUrl.includes('vimeo.com')) {
        const vimeoId = videoUrl.split('vimeo.com/')[1];
        iframe.src = `https://player.vimeo.com/video/${vimeoId}?autoplay=1`;
      }
      // Direct embed URL
      else {
        iframe.src = videoUrl;
      }
      
      videoTitle.textContent = title;
      modal.showModal();
      
      // Clean up when modal is closed
      modal.addEventListener('close', function() {
        iframe.src = '';
      }, { once: true });
    };
    
    // Filtering functionality
    const videoItems = document.querySelectorAll('.video-item');
    const emptyState = document.querySelector('.empty-state');
    let activeYear = 'all';
    let activeCategory = 'all';
    
    function updateFilters() {
      let hasVisibleItems = false;
      
      videoItems.forEach(item => {
        const year = item.dataset.year;
        const categories = item.dataset.categories;
        
        const yearMatch = activeYear === 'all' || year === activeYear;
        const categoryMatch = activeCategory === 'all' || categories.includes(activeCategory);
        
        if (yearMatch && categoryMatch) {
          item.classList.remove('hidden');
          hasVisibleItems = true;
        } else {
          item.classList.add('hidden');
        }
      });
      
      // Show/hide empty state
      if (hasVisibleItems) {
        emptyState.classList.add('hidden');
      } else {
        emptyState.classList.remove('hidden');
      }
    }
    
    // Year filter buttons
    document.querySelectorAll('.year-filter').forEach(button => {
      button.addEventListener('click', function() {
        document.querySelectorAll('.year-filter').forEach(btn => {
          btn.classList.remove('btn-primary', 'active');
          btn.classList.add('btn-outline');
        });
        
        this.classList.add('btn-primary', 'active');
        this.classList.remove('btn-outline');
        
        activeYear = this.dataset.year;
        updateFilters();
      });
    });
    
    // Category filter buttons
    document.querySelectorAll('.category-filter').forEach(button => {
      button.addEventListener('click', function() {
        document.querySelectorAll('.category-filter').forEach(btn => {
          btn.classList.remove('tab-active');
        });
        
        this.classList.add('tab-active');
        activeCategory = this.dataset.category;
        updateFilters();
      });
    });
    
    // Reset filters button
    document.querySelector('.reset-filters')?.addEventListener('click', function() {
      activeYear = 'all';
      activeCategory = 'all';
      
      document.querySelectorAll('.year-filter').forEach(btn => {
        btn.classList.remove('btn-primary', 'active');
        btn.classList.add('btn-outline');
        if (btn.dataset.year === 'all') {
          btn.classList.add('btn-primary', 'active');
          btn.classList.remove('btn-outline');
        }
      });
      
      document.querySelectorAll('.category-filter').forEach(btn => {
        btn.classList.remove('tab-active');
        if (btn.dataset.category === 'all') {
          btn.classList.add('tab-active');
        }
      });
      
      updateFilters();
    });
    
    // Initial filter application
    updateFilters();
  });
</script>
@endpush

@push('styles')
<style>
  /* Transition effects for filtering */
  .video-item {
    transition: opacity 0.3s ease, transform 0.3s ease;
  }
  
  .video-item.hidden {
    display: none;
  }
  
  /* Active filter button styles */
  .btn.active {
    @apply btn-primary;
  }
  
  .tab.tab-active {
    @apply bg-primary text-primary-content;
  }
  
  /* Placeholder image for videos without thumbnails */
  .placeholder-video {
    @apply bg-gray-200 flex items-center justify-center;
  }
</style>
@endpush