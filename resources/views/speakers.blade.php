{{--
  Template Name: Speakers Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.headers.default')

  @php
    // Step 1: Find IDs of posts to exclude
    $excludeTitles = ['FreeBalance Staff', 'Customer Representatives'];
    $excludeIds = [];
    
    // Get all speaker posts first
    $allSpeakers = new WP_Query([
      'post_type'      => 'tribe_ext_speaker',
      'posts_per_page' => -1,
      'fields'         => 'ids'
    ]);
    
    // Find the IDs to exclude and the IDs to prioritize
    $manuelId = null;
    $santinaId = null;
    $kayId = null;
    $dougId = null;
    
    if ($allSpeakers->have_posts()) {
      foreach ($allSpeakers->posts as $postId) {
        $title = get_the_title($postId);
        
        if (in_array($title, $excludeTitles)) {
          $excludeIds[] = $postId;
        } elseif ($title === 'Manuel Schiappa Pietra') {
          $manuelId = $postId;
        } elseif ($title === 'Santina Viegas Cardoso') {
          $santinaId = $postId;
        } elseif ($title === 'HE Kay Rala Xanana Gusmão') {
          $kayId = $postId;
        } elseif ($title === 'Doug Hadden') {
          $dougId = $postId;
        }
      }
    }
    
    // Step 2: Create the main query for displayed speakers
    $speakersQuery = new WP_Query([
      'post_type'      => 'tribe_ext_speaker',
      'posts_per_page' => -1,
      'post__not_in'   => $excludeIds,
      'orderby'        => 'title',
      'order'          => 'ASC',
    ]);
    
    // Get all regular speakers except Manuel, Santina, Kay, and Doug
    $regularSpeakers = [];
    foreach ($speakersQuery->posts as $post) {
      if ($post->ID != $manuelId && $post->ID != $santinaId && $post->ID != $kayId && $post->ID != $dougId) {
        $regularSpeakers[] = $post;
      }
    }
    
    // Step 3: Get Manuel, Santina, Kay, and Doug's full post objects
    $manuelPost = null;
    $santinaPost = null;
    $kayPost = null;
    $dougPost = null;
    
    if ($manuelId) {
      $manuelPost = get_post($manuelId);
    }
    
    if ($santinaId) {
      $santinaPost = get_post($santinaId);
    }
    
    if ($kayId) {
      $kayPost = get_post($kayId);
    }
    
    if ($dougId) {
      $dougPost = get_post($dougId);
    }
    
    // Step 4: Create the final ordered array of speakers
    $speakerPosts = [];
    
    // Add Manuel first if found
    if ($manuelPost) {
      $speakerPosts[] = $manuelPost;
    }
    
    // Add Santina second if found
    if ($santinaPost) {
      $speakerPosts[] = $santinaPost;
    }
    
    // Add Kay (the Prime Minister) third if found
    if ($kayPost) {
      $speakerPosts[] = $kayPost;
    }
    
    // Add Doug fourth if found
    if ($dougPost) {
      $speakerPosts[] = $dougPost;
    }
    
    // Add the rest of the speakers (already alphabetically sorted)
    $speakerPosts = array_merge($speakerPosts, $regularSpeakers);
  @endphp

  <x-people-grid
    title="2025 Featured Presenters" 
    postType="speaker"
    description="FISC 2025 is proud to welcome an esteemed lineup of global leaders and public sector innovators who are shaping the future of Public Financial Management."
    :posts="$speakerPosts"
    showSocial="true"
    showContact="true"
    showAdditionalInfo="false"
  />

          <!-- Social Media & Follow -->
          <div class="mb-20 text-center px-20">
            <h3 class="text-2xl mb-4">Connect With Us</h3>
            <p class="mb-6 max-w-2xl mx-auto">Follow the conversation and get the latest updates on FISC 2025</p>

<div class="flex justify-center space-x-4 mb-4">
    <a target="_blank" href="https://x.com/FreeBalance" class="btn btn-circle btn-outline border-gray-400 hover:bg-black hover:border-black hover:text-white transition-colors duration-300">
        <svg width="24" height="24" class="w-5 h-5 fill-current" fill="currentColor" viewBox="0 0 24 24">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
        </svg>
    </a>
    <a target="_blank" href="https://www.linkedin.com/company/freebalance/" class="btn btn-circle btn-outline border-gray-400 hover:bg-[#0077b5] hover:border-[#0077b5] hover:text-white transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="h-5 w-5 fill-current">
            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
        </svg>
    </a>
</div>

            <a target="_blank" href="https://x.com/hashtag/FISC2025?src=hashtag_click" class="mt-4">
                <span class="btn btn-secondary rounded-full text-white btn-sm">#FISC2025</span>
            </a>
        </div>

@endsection

@push('scripts')
@endpush