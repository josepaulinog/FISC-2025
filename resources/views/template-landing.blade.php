{{--
  Template Name: Landing Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.home.header')
    @include('partials.home.intro-landing')
  @endwhile
@endsection
