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
    
    // Get all regular speakers except Manuel, Santina, and Doug
    $regularSpeakers = [];
    foreach ($speakersQuery->posts as $post) {
      if ($post->ID != $manuelId && $post->ID != $santinaId && $post->ID != $dougId) {
        $regularSpeakers[] = $post;
      }
    }
    
    // Step 3: Get Manuel, Santina, and Doug's full post objects
    $manuelPost = null;
    $santinaPost = null;
    $dougPost = null;
    
    if ($manuelId) {
      $manuelPost = get_post($manuelId);
    }
    
    if ($santinaId) {
      $santinaPost = get_post($santinaId);
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
    
    // Add Santina (the Minister) second if found
    if ($santinaPost) {
      $speakerPosts[] = $santinaPost;
    }
    
    // Add Doug third if found
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

@endsection

@push('scripts')
@endpush