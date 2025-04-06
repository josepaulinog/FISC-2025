@props([
    // An array of speaker IDs to filter the query for featured speakers.
    'ids'         => null,
    // Maximum number of speakers to display; defaults to all if not set.
    'limit'       => null,
    // Boolean flag to show the call-to-action button.
    'showCTA'     => false,
    // A custom CSS class for the background of the speakers section.
    'bgClass'     => 'bg-base-200',
    // Title of the section.
    'title'       => 'Featured Speakers',
    // Description of the section.
    'description' => 'Meet the innovative minds driving our mission forward with expertise and passion.'
])

@php
    // Build the query arguments.
    $args = [
        'post_type'      => 'tribe_ext_speaker',
        'posts_per_page' => $limit ? $limit : -1,
    ];
    // If IDs are provided, filter the query accordingly.
    if ($ids) {
        $args['post__in'] = $ids;
        $args['orderby']  = 'post__in';
    }
    $speakersQuery = new WP_Query($args);
@endphp

<section class="team-section py-16 {{ $bgClass }}">
  <div class="container mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl text-gray-800 dark:text-white mb-4">{{ $title }}</h2>
      <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
      <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-300">
        {{ $description }}
      </p>
    </div>

    <!-- Speaker Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @if($speakersQuery->have_posts())
        @while($speakersQuery->have_posts())
          @php($speakersQuery->the_post())
          <div class="cursor-pointer speaker-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 ease-in-out"
               onclick="window.location='{{ get_permalink() }}'">
            <div class="p-6 text-center">
              <!-- Speaker Image -->
              <div class="relative inline-block mb-4">
                @if(has_post_thumbnail())
                  <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'medium') }}" 
                       alt="{{ get_the_title() }}" 
                       class="w-32 h-32 rounded-full mx-auto object-cover hover:animate-pulse">
                @else
                  <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mx-auto">
                    <span class="text-gray-500">No Image</span>
                  </div>
                @endif
              </div>
              <!-- Speaker Name -->
              <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ get_the_title() }}</h3>
              <!-- Speaker Title -->
              @php($speakerJob = get_post_meta(get_the_ID(), '_tribe_ext_speaker_job_title', true))
              @if($speakerJob)
                <p class="text-sm px-8 text-orange-600 dark:text-orange-400 font-medium mb-2">{{ $speakerJob }}</p>
              @endif
              <!-- Speaker Location -->
              @php($speakerCountry = get_post_meta(get_the_ID(), '_tribe_ext_speaker_country', true))
              @if($speakerCountry)
                <p class="text-gray-500 dark:text-gray-400 mb-4">{{ $speakerCountry }}</p>
              @endif
              <!-- Social Links -->
              <div class="flex justify-center space-x-6">
                {{-- Email Link --}}
                @php($speakerEmail = get_post_meta(get_the_ID(), '_tribe_ext_speaker_email_address', true))
                @if($speakerEmail)
                  <a href="mailto:{{ $speakerEmail }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400"
                     onclick="event.stopPropagation();">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                  </a>
                @endif

                {{-- LinkedIn Link --}}
                @php($speakerLinkedIn = get_post_meta(get_the_ID(), '_tribe_ext_speaker_linkedin', true))
                @if($speakerLinkedIn)
                  <a href="{{ $speakerLinkedIn }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
                     onclick="event.stopPropagation();">
                     <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                    </svg>
                  </a>
                @endif

                {{-- Twitter Link --}}
                @php($speakerTwitter = get_post_meta(get_the_ID(), '_tribe_ext_speaker_twitter', true))
                @if($speakerTwitter)
                  <a href="{{ $speakerTwitter }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
                     onclick="event.stopPropagation();">
                     <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                    </svg>
                  </a>
                @endif
              </div>
            </div>
          </div>
        @endwhile
        @php(wp_reset_postdata())
      @else
        <p class="text-center col-span-full">No speakers found.</p>
      @endif
    </div>

    @if($showCTA)
      <div class="text-center mt-8">
        <a class="btn btn-primary px-8 text-white" href="/speakers">View All Speakers</a>
      </div>
    @endif

  </div>
</section>
