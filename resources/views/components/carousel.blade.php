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