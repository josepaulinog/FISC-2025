{{--
  Template Name: Speakers Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.headers.default')

  @php
    $speakers = new WP_Query([
      'post_type'      => 'tribe_ext_speaker',
      'posts_per_page' => -1,
      'orderby'        => 'title',
      'order'          => 'ASC',
    ]);
    
    $speakerPosts = $speakers->posts;
  @endphp

  <x-people-grid 
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