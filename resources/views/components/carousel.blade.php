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

// Calculate number of slides needed (3 speakers per slide)
$slides = array_chunk($speakers, 3);
$slideCount = count($slides);
@endphp

<section class="team-section py-16 {{ $bgClass }}">
    <div class="container mx-auto px-4">
        <div class="text-center mb-4">
            <h2 class="text-3xl text-gray-800 dark:text-white mb-4">{{ $title }}</h2>
            <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
            <p class="text-lg max-w-2xl mx-auto text-gray-600 dark:text-gray-300">
                {{ $description }}
            </p>
        </div>

        <!-- Speaker Carousel -->
        @if(count($speakers) > 0)
        <div class="relative">
            <div class="carousel w-full">
                @foreach($slides as $index => $slide)
                <div id="slide-{{ $index + 1 }}" class="carousel-item relative w-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full px-12 md:px-12 lg:mx-4 lg:mt-3 mb-8">
                        @foreach($slide as $speaker)
                        <div class="cursor-pointer card bg-base-100 rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg relative border"
                            onclick="window.location='{{ $speaker['permalink'] }}'">
                            <!-- Gray header background -->
                            <div class="h-24 bg-base-200/50 dark:bg-gray-700 relative"></div>
                            
                            <!-- Avatar positioned to overlap header and content -->
                            <div class="relative -mt-16 text-center px-6">
                                <!-- Speaker Image -->
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
                                
                                <!-- Speaker information -->
                                <h3 class="text-sm text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $speaker['title'] }}</h3>
                                
                                @if($speaker['job_title'])
                                <p class="px-8 text-sm text-orange-600 dark:text-orange-400 font-medium mb-2">{{ $speaker['job_title'] }}</p>
                                @endif
                                
                                @if($speaker['country'])
                                <p class="text-gray-500 dark:text-gray-400 mb-4 hidden">{{ $speaker['country'] }}</p>
                                @endif
                                
                                <!-- Social Links -->
                                <div class="flex justify-center space-x-6 mb-6">
                                    {{-- Email Link --}}
                                    @if($speaker['email'])
                                    <a href="mailto:{{ $speaker['email'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400"
                                        onclick="event.stopPropagation();">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                    </a>
                                    @endif

                                    {{-- LinkedIn Link --}}
                                    @if($speaker['linkedin'])
                                    <a href="{{ $speaker['linkedin'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
                                        onclick="event.stopPropagation();">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                                        </svg>
                                    </a>
                                    @endif

                                    {{-- Twitter Link --}}
                                    @if($speaker['twitter'])
                                    <a href="{{ $speaker['twitter'] }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
                                        onclick="event.stopPropagation();">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                                        </svg>
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

            <!-- Navigation Arrows - fixed version -->
            <div class="absolute left-0 right-0 top-1/2 flex -translate-y-1/2 transform justify-between z-10">
                <!-- Previous Slide Button -->
                <button type="button" onclick="prevSlide()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hover:text-primary size-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <!-- Next Slide Button -->
                <button type="button" onclick="nextSlide()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hover:text-primary size-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>

            <!-- Updated navigation script -->
            <script>
                // Track current slide
                let currentSlide = 1;
                const totalSlides = {{ $slideCount }};
                
                function prevSlide() {
                    currentSlide = currentSlide > 1 ? currentSlide - 1 : totalSlides;
                    navigateToSlide(currentSlide);
                }
                
                function nextSlide() {
                    currentSlide = currentSlide < totalSlides ? currentSlide + 1 : 1;
                    navigateToSlide(currentSlide);
                }
                
                function navigateToSlide(slideNumber) {
                    currentSlide = slideNumber;
                    const targetSlide = document.getElementById(`slide-${slideNumber}`);
                    if (targetSlide) {
                        targetSlide.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest',
                            inline: 'center'
                        });
                    }
                }
            </script>

            <!-- Slide indicators remain the same -->
            <div class="flex justify-center w-full py-4 gap-2 hidden">
                @for($i = 1; $i <= $slideCount; $i++)
                <a onclick="event.preventDefault(); navigateToSlide({{ $i }});" href="javascript:void(0);" class="btn btn-xs {{ $i == 1 ? 'btn-primary' : '' }}">{{ $i }}</a>
                @endfor
            </div>
        </div>
        @else
        <p class="text-center">No speakers found.</p>
        @endif

        @if($showCTA)
        <div class="text-center mt-4">
            <a class="btn btn-outline px-8 border-gray-400" href="/speakers">View All Speakers</a>
        </div>
        @endif

    </div>
</section>

<style>
    /* Hide second and third cards on mobile */
    @media (max-width: 767px) {
        .carousel-item .grid > div:not(:first-child) {
            display: none;
        }
        
        /* Center the single visible card */
        .carousel-item .grid > div:first-child {
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>