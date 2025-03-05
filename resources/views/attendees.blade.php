{{--
  Template Name: Attendees Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.headers.default')

  @php
    $attendees = new WP_Query([
      'post_type'      => 'attendee',
      'posts_per_page' => -1,
      'orderby'        => 'title',
      'order'          => 'ASC',
    ]);
    
    $attendeePosts = $attendees->posts;
  @endphp

  <x-people-grid 
    postType="attendee"
    :posts="$attendeePosts"
    showSocial="true"
    showContact="true"
    showAdditionalInfo="false"
    description="FISC 2025 is proud to welcome an esteemed lineup of global leaders and public sector innovators who are shaping the future of Public Financial Management."
  />

@endsection

@push('scripts')
@endpush
