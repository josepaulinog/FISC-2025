{{--
  Template Name: Gallery Template
--}}

@extends('layouts.app')

@section('content')
@include('partials.headers.default')

<div class="container mx-auto py-16">

  <div class="text-center lg:mb-12">
    <h2 class="text-3xl mb-4">FISC 2025 in Pictures</h2>
    <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
    <p class="max-w-2xl mx-auto text-neutral-600 dark:text-neutral-400 lg:mb-12 mb-8">
      A visual journey through the moments that shaped the conversation.
    </p>
  </div>

  @php
  $years = get_field('gallery_years');
  @endphp

  @if($years && is_array($years) && !empty($years))
  <!-- Optional Gallery Archives (currently hidden) -->
  <div class="mb-10 hidden">
    <h2 class="text-3xl font-bold mb-6">Gallery</h2>
    <div class="flex flex-wrap gap-4">
      @foreach($years as $year)
      <a href="#year-{{ $year['year'] }}"
        class="btn btn-primary year-selector"
        data-year="{{ $year['year'] }}">
        {{ $year['year'] }}
      </a>
      @endforeach
    </div>
  </div>

  @foreach($years as $year)
  <div id="year-{{ $year['year'] }}" class="gallery-year mb-20" data-year="{{ $year['year'] }}" style="display: none;">
    <!-- Day Tabs -->
    <div class="tabs tabs-boxed mb-10 p-2">
      @for($i = 1; $i <= 5; $i++)
        @php
        // Count photos for this day to show count
        $day_photos_count=0;
        $current_day_number=0;
        if(isset($year['gallery_days']) && is_array($year['gallery_days'])) {
        foreach($year['gallery_days'] as $day_index=> $day) {
        // Use the explicit day_number field rather than array index
        $current_day_number = isset($day['day_number']) ? intval($day['day_number']) : ($day_index + 1);
        if($current_day_number == $i && isset($day['photos']) && is_array($day['photos'])) {
        $day_photos_count = count($day['photos']);
        }
        }
        }
        @endphp
        <a class="h-10 tab tab-bordered day-tab {{ $i === 1 ? 'tab-active' : '' }}"
          data-day="{{ $i }}"
          data-year="{{ $year['year'] }}">
          Day {{ $i }} <span class="text-xs ml-1">({{ $day_photos_count }})</span>
        </a>
        @endfor
    </div>

    <!-- Day Captions -->
    @if(isset($year['gallery_days']) && is_array($year['gallery_days']))
    @foreach($year['gallery_days'] as $day_index => $day)
    @php
    // Get the day number from the field or default to index+1
    $day_number = isset($day['day_number']) ? intval($day['day_number']) : ($day_index + 1);
    // If there's a caption field in the day, use it, otherwise create a default one
    $day_caption = isset($day['day_caption']) ? $day['day_caption'] : "Day " . $day_number . " of FISC 2025";
    @endphp

    @endforeach
    @endif

    <h3 class="text-lg font-medium mb-3">Filter by Category</h3>

    <!-- Desktop Category Filter Tabs (hidden on mobile) -->
    <div role="tablist" class="hidden md:flex mb-6 flex-wrap filter-tabs tabs tabs-lifted tabs-lg" data-year="{{ $year['year'] }}">
      @php
      // Count photos for each category to show in filters
      $categories = ['all' => 0, 'sessions' => 0, 'opening' => 0, 'closing' => 0, 'social' => 0, 'other' => 0];
      if(isset($year['gallery_days']) && is_array($year['gallery_days'])) {
      foreach($year['gallery_days'] as $day) {
      if(isset($day['photos']) && is_array($day['photos'])) {
      foreach($day['photos'] as $photo) {
      $categories['all']++;
      if(isset($photo['category']) && isset($categories[$photo['category']])) {
      $categories[$photo['category']]++;
      }
      }
      }
      }
      }
      @endphp

      <a class="tab tab-bordered filter-tab tab-active" data-filter="all" data-year="{{ $year['year'] }}">
        All <span class="text-xs ml-1">({{ $categories['all'] }})</span>
      </a>
      @php
      $terms = get_terms([
      'taxonomy' => 'photo_category',
      'hide_empty' => false,
      ]);
      @endphp

      @foreach($terms as $term)
      @php
      $category = $term->slug;
      @endphp
      @if(isset($categories[$category]) && $categories[$category] > 0)
      <a class="tab tab-bordered filter-tab" data-filter="{{ $category }}" data-year="{{ $year['year'] }}">
        {{ $term->name }} <span class="text-xs ml-1">({{ $categories[$category] }})</span>
      </a>
      @endif
      @endforeach

    </div>

    <!-- Mobile Filter Dropdown (visible only on mobile) -->
    <div class="md:hidden mb-6">
      <select id="mobile-filter-{{ $year['year'] }}" class="select select-bordered w-full" data-year="{{ $year['year'] }}">
        <option value="all" selected>All Categories ({{ $categories['all'] }})</option>
        @php
        $terms = get_terms([
        'taxonomy' => 'photo_category',
        'hide_empty' => false, // true if you want only terms with posts/photos
        ]);
        @endphp

        @foreach($terms as $term)
        @php $category = $term->slug; @endphp
        @if(isset($categories[$category]) && $categories[$category] > 0)
        <option value="{{ $category }}">{{ $term->name }} ({{ $categories[$category] }})</option>
        @endif
        @endforeach

      </select>
    </div>

    <!-- Download Album Button (now visible) -->
    @if(isset($year['album_download_link']) && !empty($year['album_download_link']))
    <div class="mb-6 hidden">
      <a href="{{ $year['album_download_link'] }}" class="btn btn-secondary" target="_blank" rel="noopener">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        Download Full Album
      </a>
    </div>
    @endif

    <!-- Grid Container using Shuffle Template Markup -->
    <div id="grid-{{ $year['year'] }}" class="js-grid my-shuffle" data-year="{{ $year['year'] }}">
      @if(isset($year['gallery_days']) && is_array($year['gallery_days']))
      @foreach($year['gallery_days'] as $day_index => $day)
      @php
      // Get the day number from the field or default to index+1
      $day_number = isset($day['day_number']) ? intval($day['day_number']) : ($day_index + 1);
      // Get day caption for this group of photos
      $day_caption = isset($day['day_caption']) ? $day['day_caption'] : "Day " . $day_number . " of FISC 2025";
      @endphp

      @if(isset($day['photos']) && is_array($day['photos']))
      @foreach($day['photos'] as $photo_index => $photo)
      @php
      // Get the attachment ID from the full image URL (if not already available)
      $attachment_id = attachment_url_to_postid($photo['full_image']);

      // Get the thumbnail image URL using wp_get_attachment_image_src()
      $thumbnail = wp_get_attachment_image_src($attachment_id, 'large'); // 'large' size
      $thumbnail_url = $thumbnail ? $thumbnail[0] : $photo['full_image']; // Fallback to full image if no thumbnail exists

      // Define an array with all aspect ratio classes
      $aspectClasses = ['aspect--16x9', 'aspect--9x80', 'aspect--4x3'];
      // Cycle through the classes based on the photo index
      $aspectClass = $aspectClasses[$photo_index % count($aspectClasses)];
      @endphp
      <figure class="js-item column group relative"
        data-groups='["{{ $photo['category'] }}"]'
        data-day="{{ $day_number }}"
        data-year="{{ $year['year'] }}"
        data-full-image="{{ $photo['full_image'] }}"
        data-caption="{{ $day_caption }}"
        data-category="{{ $photo['category'] }}">
        <div class="shadow-lg aspect {{ $aspectClass }}">
          <div class="aspect__inner">
            <div class="relative w-full h-full image-container">
              <!-- DaisyUI Skeleton -->
              <div class="skeleton absolute inset-0 rounded-lg"></div>
              
              <!-- Image with lazy loading -->
              <img data-src="{{ $thumbnail_url }}"
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                alt="{{ $day_caption }}"
                class="shadow-lg rounded-lg object-cover w-full h-full cursor-pointer lazy opacity-0 transition-opacity duration-300"
                loading="lazy">
            </div>
            <div
              class="cursor-pointer absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center gallery-image-trigger">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
              </svg>
            </div>
          </div>
        </div>
      </figure>
      @endforeach
      @endif
      @endforeach
      @endif
      <!-- Sizer element for Shuffle.js (if needed) -->
      <div class="column my-sizer-element"></div>
    </div>
    
    <!-- Pagination (dynamically created) -->
    @if(isset($year['gallery_days']) && is_array($year['gallery_days']))
    @foreach($year['gallery_days'] as $day_index => $day)
    @php
    $day_number = isset($day['day_number']) ? intval($day['day_number']) : ($day_index + 1);
    @endphp
    <div id="pagination-{{ $year['year'] }}-day-{{ $day_number }}" class="pagination flex justify-center items-center mt-8 {{ $day_number == 1 ? '' : 'hidden' }}">
      <div class="join">
        <button class="join-item btn btn-sm prev-page">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <div class="page-numbers join flex"></div>
        <button class="join-item btn btn-sm next-page">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>
    @endforeach
    @endif
  </div>
  @endforeach
  @else
  <div class="text-center py-12">
    <h2 class="text-2xl font-bold mb-4">No Gallery Items Found</h2>
    <p>Please add gallery items using the admin panel.</p>
  </div>
  @endif

  <!-- Social Media & Follow -->
  <div class="mt-16 mb-16 text-center px-20">
    <h3 class="text-2xl mb-4">Connect With Us</h3>
    <p class="mb-6 max-w-2xl mx-auto">Follow the conversation and get the latest updates on FISC 2025</p>

    <div class="flex justify-center space-x-4 mb-4">
      <a target="_blank" href="https://x.com/FreeBalance" class="btn btn-circle btn-outline border-gray-400">
        <svg width="24" height="24" class="w-5 h-5 fill-current" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
        </svg>
      </a>
      <a target="_blank" href="https://www.linkedin.com/company/freebalance/" class="btn btn-circle btn-outline border-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="h-5 w-5 fill-current">
          <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
        </svg>
      </a>
    </div>

    <a target="_blank" href="https://x.com/hashtag/FISC2025?src=hashtag_click" class="mt-4">
      <span class="btn btn-secondary rounded-full text-white btn-sm">#FISC2025</span>
    </a>
  </div>
</div>

<!-- Modal Toggle (Hidden Input) -->
<input type="checkbox" id="gallery-modal-toggle" class="modal-toggle" />

<!-- Modal Container -->
<div id="gallery-modal" class="modal">
  <!-- Modal Backdrop -->
  <div class="modal-backdrop backdrop-blur-sm bg-black/80" onclick="window.closeModal()"></div>

  <!-- Modal Content -->
  <div class="modal-box w-full h-full max-w-none max-h-none rounded-none p-0 bg-transparent">
    <!-- Close Button -->
    <button onclick="window.closeModal()" class="absolute right-10 top-4 z-50 text-3xl text-white btn btn-sm btn-circle btn-ghost">✕</button>

    <!-- Navigation Arrows -->
    <button id="prev-button" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-50 text-white btn btn-circle btn-ghost opacity-70 hover:opacity-100">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
      </svg>
    </button>

    <button id="next-button" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-50 text-white btn btn-circle btn-ghost opacity-70 hover:opacity-100">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
      </svg>
    </button>

    <!-- Image and Caption -->
    <div class="flex flex-col h-full justify-center items-center p-4 md:p-8 lg:p-16">
      <div class="max-w-7xl max-h-[80vh] bg-transparent rounded-lg overflow-hidden relative">
        <!-- Modal Skeleton -->
        <div id="modal-skeleton" class="skeleton w-full h-[75vh] rounded-lg"></div>
        
        <img id="modal-image" src="" alt="" class="max-w-full max-h-[75vh] object-contain mx-auto">

        <!-- Caption and Category -->
        <div id="modal-caption" class="bg-black/50 text-white p-2 rounded">
          <h3 id="modal-title" class="font-bold text-lg"></h3>
          <p id="modal-category" class="text-sm hidden"></p>
        </div>
      </div>

      <!-- Download Button -->
      <div id="modal-download" class="mt-4">
        <a id="download-link" href="#" download class="btn btn-primary text-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
          </svg> Download
        </a>
      </div>
    </div>
  </div>
</div>

@endsection

<style>
  /* Full-screen modal styles */
  .modal-box {
    background: transparent;
    box-shadow: none;
  }

  .modal-backdrop {
    background: rgba(0, 0, 0, 0.8);
  }

  /* Rest of the styles remain the same */
  .tabs-boxed>.tab-active {
    color: #ffffff !important;
  }

  .tabs-lifted>.tab-active {
    color: #fd6b18 !important;
  }

  .column {
    position: relative;
    float: left;
    min-height: 1px;
    width: 33%;
    padding-left: 10px;
    padding-right: 10px;
    margin-top: 20px;
  }

  .col-span {
    width: 50%;
  }

  .my-sizer-element {
    width: 8.33333%;
  }

  .my-shuffle {
    position: relative;
    overflow: hidden;
  }

  .aspect {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 100%;
    overflow: hidden;
  }

  .aspect__inner {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }

  .aspect--16x9 {
    padding-bottom: 56.25%;
  }

  .aspect--9x80 {
    padding-bottom: calc(112.5% + 8px);
  }

  .aspect--32x9 {
    padding-bottom: calc(28.125% - 3px);
  }

  .aspect--4x3 {
    padding-bottom: 75%;
  }

  img {
    display: block;
    width: 100%;
    max-width: none;
    height: 100%;
    object-fit: cover;
  }

  /* Lazy loading effect with smooth fade-in */
  img.lazy {
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
  }

  img.lazy.loaded {
    opacity: 1;
  }

  /* DaisyUI v4 already has skeleton animations built-in */

  /* Pagination styles */
  .pagination .page-numbers {
    display: flex;
    align-items: center;
  }

  .pagination .join-item.btn {
    margin: 0;
    min-width: 2.5rem;
    height: 2rem;
  }

  .pagination .btn.btn-active {
    background-color: #fd6b18;
    color: white;
    border-color: #fd6b18;
  }

  /* Additional responsive styling for mobile */
  @media (max-width: 768px) {
    .column {
      width: 50%;
      /* Two columns on small devices */
    }
  }

  @media (max-width: 480px) {
    .column {
      width: 100%;
      /* One column on very small devices */
      padding-left: 5px;
      padding-right: 5px;
      margin-top: 10px;
    }
  }

  /* Improve day tabs on mobile */
  @media (max-width: 640px) {
    .tabs-boxed {
      flex-wrap: wrap;
      justify-content: center;
    }
  }

  /* Make modal controls more touch-friendly */
  @media (max-width: 768px) {

    #prev-button,
    #next-button {
      padding: 15px;
    }

    .modal-box button.btn-circle {
      width: 3rem;
      height: 3rem;
    }
  }
</style>