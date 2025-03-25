{{--
  Template Name: Attendees Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.headers.default')

  @php
    // Query for users with the 'attendee' role instead of custom post type
    $attendees = get_users([
      'role'    => 'attendee',
      'orderby' => 'display_name',
      'order'   => 'ASC',
      'meta_query' => [
        [
          'key' => 'show_in_directory',
          'value' => '1',
          'compare' => '='
        ]
      ]
    ]);
  @endphp

  <x-people-grid
    title="Delegate Community"  
    userType="attendee"
    :users="$attendees"
    showSocial="true"
    showContact="true"
    showAdditionalInfo="false"
    description="FISC 2025 brings together a community of delegates from across the globe committed to advancing Public Financial Management. "
  />

@endsection

@push('scripts')
@endpush
