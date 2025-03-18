{{--
  Template Name: Contact Template
--}}

@extends('layouts.app')

@section('content')
    @while(have_posts()) @php(the_post())
        <!-- Hero Section -->
        <section class="relative bg-gray-100 dark:bg-gray-800">
            <div class="w-full bg-cover bg-center h-60" style="background-image: url('https://cdn.midjourney.com/7fc0c967-a030-4509-9415-313e54c4776e/0_0.png');">
                <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                    <div class="text-center">
                        <h1 class="text-4xl md:text-5xl text-white mb-4">Get in Touch</h1>
                        <p class="text-xl text-white max-w-4xl mx-auto">We're here to assist you with any questions about FISC 2025 in Timor-Leste</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-16 bg-base-100 dark:bg-base-200">
            <div class="container mx-auto px-4 max-w-7xl">
                
                <!-- Contact Details Cards with DaisyUI Slide -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
    <!-- Before the Event Card -->
    <div class="card bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700 h-full">
        <div class="card-body">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Before the Event</h3>
                <div class="divider my-2"></div>
                
                <!-- Single contact slide -->
                <div class="w-full">
                    <p class="font-medium">Ludmila Patralska</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Director of Human Resources</p>
                    <p class="flex items-center justify-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <a href="mailto:lpatralska@freebalance.com" class="text-primary underline">lpatralska@freebalance.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- During the Event Card -->
    <div class="card bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700 h-full">
        <div class="card-body">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">During the Event</h3>
                <div class="divider my-2"></div>
                
                <!-- First contact -->
                <div class="w-full mb-4">
                    <p class="font-medium">Carolyn Bowick</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Director of Marketing Communications</p>
                    <p class="flex items-center justify-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <a href="mailto:carolyn.bowick@freebalance.com" class="text-primary underline">carolyn.bowick@freebalance.com</a>
                    </p>
                </div>
                
                <div class="divider my-2"></div>
                
                <!-- Second contact -->
                <div class="w-full">
                    <p class="font-medium">Ana Santos</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Human Resources Manager</p>
                    <p class="flex items-center justify-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <a href="mailto:ana.santos@freebalance.com" class="text-primary underline">ana.santos@freebalance.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Venue Assistance Card -->
    <div class="card bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700 h-full">
        <div class="card-body">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Venue Assistance</h3>
                <div class="divider my-2"></div>
                
                <!-- Single contact info -->
                <div class="w-full">
                    <p class="font-medium">Palm Springs Hotel Dili</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Front Desk Support</p>
                    <p class="flex items-center justify-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <a href="mailto:info@palmspringshoteldili.com" class="text-primary underline">info@palmspringshoteldili.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

                <style>
                    /* Add smooth slide transitions */
                    .carousel-item {
                        transition: transform 0.5s ease-in-out;
                    }
                    
                    /* Highlight navigation buttons on hover */
                    .slide-nav:hover {
                        background-color: rgba(var(--p), 0.2);
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Prevent default behavior for carousel navigation links
                        const slideNavLinks = document.querySelectorAll('.slide-nav');
                        
                        slideNavLinks.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const targetSlide = this.getAttribute('data-slide');
                                
                                // Navigate to the slide without changing page URL
                                const carousel = document.getElementById('event-contacts-carousel');
                                const slides = carousel.querySelectorAll('.carousel-item');
                                
                                slides.forEach(slide => {
                                    if (slide.id === targetSlide) {
                                        slide.classList.add('active');
                                        // Scroll the carousel to this slide
                                        document.getElementById(targetSlide).scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'nearest',
                                            inline: 'start'
                                        });
                                    } else {
                                        slide.classList.remove('active');
                                    }
                                });
                            });
                        });
                    });
                </script>
                
                <!-- Social Media & Follow -->
                <div class="mt-16 text-center">
                    <h3 class="text-2xl mb-4">Connect With Us</h3>
                    <p class="mb-6 max-w-2xl mx-auto">Follow the conversation and get the latest updates on FISC 2025</p>
                    
                    <div class="flex justify-center space-x-4 mb-4">
                        <a target="_blank" href="https://x.com/FreeBalance" class="btn btn-circle btn-outline border-gray-400">
                            <svg width="24" height="24" class="w-5 h-5 fill-current" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a target="_blank" href="https://www.linkedin.com/company/freebalance/" class="btn btn-circle btn-outline border-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="h-5 w-5 fill-current">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                            </svg>
                        </a>
                    </div>
                    
                    <a target="_blank" href="https://x.com/hashtag/FISC2025?src=hashtag_click" class="mt-4">
                        <span class="badge badge-secondary badge-lg text-white">#FISC2025</span>
                    </a>
                </div>
            </div>
        </section>
    @endwhile
@endsection

<style>
    #gform_submit_button_2 {
        border-radius: 8px !important;
    }
</style>