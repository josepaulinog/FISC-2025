{{--
  Template Name: Agenda Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.headers.hero')

  <x-agenda 
    title="Schedule and Agenda" 
    description="Stay informed with our detailed schedule and agenda for FISC 2025. This section provides a comprehensive rundown of all events, sessions, and activities from the first day to the last." 
    :days="[
      '2025-04-06' => 'April 6, 2025',
      '2025-04-07' => 'April 7, 2025',
      '2025-04-08' => 'April 8, 2025',
      '2025-04-09' => 'April 9, 2025',
      '2025-04-10' => 'April 10, 2025'
    ]"
    organizer="FreeBalance"
    venue="dilli Conference center"
    location="Timor Leste"
  />
  
@endsection

@push('scripts')
@endpush
