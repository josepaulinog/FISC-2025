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
    ]);
  @endphp

  <x-people-grid
    title="Delegate Community"  
    userType="attendee"
    :users="$attendees"
    showSocial="true"
    showContact="true"
    showAdditionalInfo="false"
    description="FISC 2025 is proud to welcome an esteemed lineup of global leaders and public sector innovators who are shaping the future of Public Financial Management."
  />

@endsection

@push('scripts')
@endpush
