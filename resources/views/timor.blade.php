{{--
  Template Name:Guide Template
--}}

@extends('layouts.app')

@section('content')
<!-- Enhanced Hero Section - Simplified -->
<div class="hero bg-cover bg-center relative" style="background-image: url('http://fisc.freebalance.com/wp-content/uploads/2025/03/Timor-Leste.jpg')">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-4 lg:py-10 py-12">
        <div class="inline-block py-1 px-3 bg-black bg-opacity-20 text-white text-sm rounded-full mb-3">FISC 2025</div>
        <h1 class="text-4xl md:text-6xl mb-4">Timor-Leste Delegate Guide</h1>
        <p class="text-xl mb-10">April 7-10, 2025 | Palm Springs Hotel Dili</p>

        <!-- Single Primary Call-to-Action -->
        <a href="#about-timor" class="btn btn-primary text-white text-white">
            Get Started
            <svg class="w-3 h-3 text-white transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"></path>
            </svg>
        </a>
    </div>
</div>

@endsection