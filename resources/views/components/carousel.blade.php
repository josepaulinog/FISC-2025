@props([
    // An array of speaker IDs to filter the query for featured speakers.
    'ids' => null,
    // Maximum number of speakers to display; defaults to all if not set.
    'limit' => null,
    // Boolean flag to show the call-to-action button.
    'showCTA' => false,
    // A custom CSS class for the background of the speakers section.
    'bgClass' => 'bg-base-200',
    // Title of the section.
    'title' => 'Featured Speakers',
    // Description of the section.
    'description' => 'Meet the innovative minds driving our mission forward with expertise and passion.'
])

@php
// Build the query arguments.
$args = [
    'post_type' => 'tribe_ext_speaker',
    'posts_per_page' => $limit ? $limit : -1,
];
// If IDs are provided, filter the query accordingly.
if ($ids) {
    $args['post__in'] = $ids;
    $args['orderby'] = 'post__in';
}
$speakersQuery = new WP_Query($args);

// Create array of speakers
$speakers = [];
$excludedTitles = ['Customer Representatives', 'FreeBalance Staff'];

if($speakersQuery->have_posts()) {
    while($speakersQuery->have_posts()) {
        $speakersQuery->the_post();
        $speakerTitle = get_the_title();
        if(in_array($speakerTitle, $excludedTitles)) {
            continue;
        }

        $speaker = [
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : null,
            'job_title' => get_post_meta(get_the_ID(), '_tribe_ext_speaker_job_title', true),
            'country' => get_post_meta(get_the_ID(), '_tribe_ext_speaker_country', true),
            'email' => get_post_meta(get_the_ID(), '_tribe_ext_speaker_email_address', true),
            'linkedin' => get_post_meta(get_the_ID(), '_tribe_ext_speaker_linkedin', true),
            'twitter' => get_post_meta(get_the_ID(), '_tribe_ext_speaker_twitter', true),
        ];
        $speakers[] = $speaker;
    }
    wp_reset_postdata();
}

// Calculate number of speakers for mobile carousel navigation
$speakerCount = count($speakers);

// Calculate number of slides needed for desktop (3 speakers per slide)
$desktopSlides = array_chunk($speakers, 3);
$desktopSlideCount = count($desktopSlides);
@endphp

<section class="team-section py-16 {{ $bgClass }}">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8"> {{-- Increased bottom margin --}}
            <h2 class="text-3xl text-gray-800 dark:text-white mb-4">{{ $title }}</h2>
            <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
            <p class="text-lg max-w-2xl mx-auto text-gray-600 dark:text-gray-300">
                {{ $description }}
            </p>
        </div>

        @if($speakerCount > 0)
            {{-- Mobile Carousel (1 speaker per slide) --}}
            <div class="relative block md:hidden" x-data="{ currentMobileSlide: 1, totalMobileSlides: {{ $speakerCount }} }">
                <div class="carousel w-full">
                    @foreach($speakers as $index => $speaker)
                        <div id="mobile-slide-{{ $index + 1 }}" class="carousel-item relative w-full justify-center px-4">
                            {{-- Re-use the speaker card component/structure --}}
                            <div class="card w-full max-w-sm bg-base-100 rounded-lg shadow-md overflow-hidden relative border mb-8">
                                {{-- Gray header background --}}
                                <div class="h-24 bg-base-200/50 dark:bg-gray-700 relative"></div>

                                {{-- Avatar positioned to overlap header and content --}}
                                <div class="relative -mt-16 text-center px-6 pb-6"> {{-- Added pb-6 --}}
                                    {{-- Speaker Image --}}
                                    <div class="inline-block mb-4 cursor-pointer" onclick="window.location='{{ $speaker['permalink'] }}'">
                                        @if($speaker['thumbnail'])
                                        <img src="{{ $speaker['thumbnail'] }}"
                                            alt="{{ $speaker['title'] }}"
                                            class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-white dark:border-gray-800">
                                        @else
                                        <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center mx-auto border-4 border-white dark:border-gray-800">
                                            <span class="text-gray-500">No Image</span>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Speaker information --}}
                                    <h3 class="text-sm text-xl font-semibold text-gray-800 dark:text-white mb-2 cursor-pointer" onclick="window.location='{{ $speaker['permalink'] }}'">
                                        {{ $speaker['title'] }}
                                    </h3>

                                    @if($speaker['job_title'])
                                    <p class="px-8 text-sm text-orange-600 dark:text-orange-400 font-medium mb-2">{{ $speaker['job_title'] }}</p>
                                    @endif

                                    @if($speaker['country'])
                                    <p class="text-gray-500 dark:text-gray-400 mb-4 hidden">{{ $speaker['country'] }}</p>
                                    @endif

                                    {{-- Social Links --}}
                                    <div class="flex justify-center space-x-6 mb-6">
                                        {{-- Email Link --}}
                                        @if($speaker['email'])
                                        <a href="mailto:{{ $speaker['email'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400"
                                            onclick="event.stopPropagation();">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /> </svg>
                                        </a>
                                        @endif
                                        {{-- LinkedIn Link --}}
                                        @if($speaker['linkedin'])
                                        <a href="{{ $speaker['linkedin'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
                                            onclick="event.stopPropagation();">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"> <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/> </svg>
                                        </a>
                                        @endif
                                        {{-- Twitter Link --}}
                                        @if($speaker['twitter'])
                                        <a href="{{ $speaker['twitter'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
                                            onclick="event.stopPropagation();">
                                             <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"> <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/> </svg>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Mobile Navigation Arrows --}}
                <div class="absolute left-0 right-0 top-1/2 flex -translate-y-1/2 transform justify-between z-10 px-1"> {{-- Reduced padding --}}
                    <button type="button" class="btn btn-ghost btn-circle"
                        x-on:click="currentMobileSlide = currentMobileSlide > 1 ? currentMobileSlide - 1 : totalMobileSlides; document.getElementById('mobile-slide-' + currentMobileSlide).scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /> </svg>
                    </button>
                    <button type="button" class="btn btn-ghost btn-circle"
                        x-on:click="currentMobileSlide = currentMobileSlide < totalMobileSlides ? currentMobileSlide + 1 : 1; document.getElementById('mobile-slide-' + currentMobileSlide).scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"> <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /> </svg>
                    </button>
                </div>

                {{-- Mobile Slide indicators (optional) --}}
                <div class="flex justify-center w-full py-2 gap-2 hidden">
                    @for($i = 1; $i <= $speakerCount; $i++)
                        <button class="btn btn-xs btn-circle"
                                :class="{ 'btn-primary': currentMobileSlide === {{ $i }} }"
                                x-on:click="currentMobileSlide = {{ $i }}; document.getElementById('mobile-slide-' + currentMobileSlide).scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });">
                            {{-- You can put $i here if you want numbers instead of dots --}}
                        </button>
                    @endfor
                </div>
            </div>

            {{-- Desktop Carousel (3 speakers per slide) --}}
            <div class="relative hidden md:block" x-data="{ currentDesktopSlide: 1, totalDesktopSlides: {{ $desktopSlideCount }} }">
                <div class="carousel w-full">
                    @foreach($desktopSlides as $index => $slide)
                        <div id="desktop-slide-{{ $index + 1 }}" class="carousel-item relative w-full">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full px-12 md:px-12 lg:mx-4 lg:mt-3 mb-8">
                                @foreach($slide as $speaker)
                                    {{-- Re-use the speaker card component/structure --}}
                                    <div class="cursor-pointer card bg-base-100 rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg relative border"
                                        onclick="window.location='{{ $speaker['permalink'] }}'">
                                        {{-- Gray header background --}}
                                        <div class="h-24 bg-base-200/50 dark:bg-gray-700 relative"></div>

                                        {{-- Avatar positioned to overlap header and content --}}
                                        <div class="relative -mt-16 text-center px-6 pb-6"> {{-- Added pb-6 --}}
                                            {{-- Speaker Image --}}
                                            <div class="inline-block mb-4">
                                                @if($speaker['thumbnail'])
                                                <img src="{{ $speaker['thumbnail'] }}"
                                                    alt="{{ $speaker['title'] }}"
                                                    class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-white dark:border-gray-800">
                                                @else
                                                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center mx-auto border-4 border-white dark:border-gray-800">
                                                    <span class="text-gray-500">No Image</span>
                                                </div>
                                                @endif
                                            </div>

                                            {{-- Speaker information --}}
                                            <h3 class="text-sm text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $speaker['title'] }}</h3>

                                            @if($speaker['job_title'])
                                            <p class="px-8 text-sm text-orange-600 dark:text-orange-400 font-medium mb-2">{{ $speaker['job_title'] }}</p>
                                            @endif

                                            @if($speaker['country'])
                                            <p class="text-gray-500 dark:text-gray-400 mb-4 hidden">{{ $speaker['country'] }}</p>
                                            @endif

                                            {{-- Social Links --}}
                                            <div class="flex justify-center space-x-6 mb-6">
                                                {{-- Email Link --}}
                                                @if($speaker['email'])
                                                <a href="mailto:{{ $speaker['email'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400"
                                                    onclick="event.stopPropagation();">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /> </svg>
                                                </a>
                                                @endif
                                                {{-- LinkedIn Link --}}
                                                @if($speaker['linkedin'])
                                                <a href="{{ $speaker['linkedin'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
                                                    onclick="event.stopPropagation();">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"> <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/> </svg>
                                                </a>
                                                @endif
                                                {{-- Twitter Link --}}
                                                @if($speaker['twitter'])
                                                <a href="{{ $speaker['twitter'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
                                                    onclick="event.stopPropagation();">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"> <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/> </svg>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop Navigation Arrows --}}
                 @if($desktopSlideCount > 1) {{-- Only show arrows if more than one slide --}}
                <div class="absolute left-0 right-0 top-1/2 flex -translate-y-1/2 transform justify-between z-10">
                    <button type="button" class="btn btn-ghost btn-circle -ml-4" {{-- Adjusted margin --}}
                         x-on:click="currentDesktopSlide = currentDesktopSlide > 1 ? currentDesktopSlide - 1 : totalDesktopSlides; document.getElementById('desktop-slide-' + currentDesktopSlide).scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8"> <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /> </svg>
                    </button>
                    <button type="button" class="btn btn-ghost btn-circle -mr-4" {{-- Adjusted margin --}}
                         x-on:click="currentDesktopSlide = currentDesktopSlide < totalDesktopSlides ? currentDesktopSlide + 1 : 1; document.getElementById('desktop-slide-' + currentDesktopSlide).scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8"> <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /> </svg>
                    </button>
                </div>
                @endif

                {{-- Desktop Slide indicators (optional) --}}
                <div class="flex justify-center w-full py-2 gap-2 hidden">
                    @for($i = 1; $i <= $desktopSlideCount; $i++)
                         <button class="btn btn-xs btn-circle"
                                :class="{ 'btn-primary': currentDesktopSlide === {{ $i }} }"
                                x-on:click="currentDesktopSlide = {{ $i }}; document.getElementById('desktop-slide-' + currentDesktopSlide).scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });">
                             {{-- $i --}}
                         </button>
                    @endfor
                </div>
            </div>

        @else
            <p class="text-center text-gray-600 dark:text-gray-400">No speakers found.</p>
        @endif

        @if($showCTA)
        <div class="text-center mt-0"> {{-- Increased top margin --}}
            <a class="btn btn-outline px-8 border-gray-400 hover:text-white" href="/speakers">View All Speakers</a>
        </div>
        @endif

    </div>
</section>