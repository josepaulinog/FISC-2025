{{-- resources/views/single-tribe_ext_speaker.blade.php --}}
@extends('layouts.app')

@php
    // Inject the plugin instance to access its methods.
    $extension_instance = Tribe__Extension__Speaker_Linked_Post_Type::instance();
@endphp

@section('content')
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-neutral-600">
    @while(have_posts())
      @php
          // Set up the post data and retrieve custom meta values.
          the_post();
          $speaker_id = get_the_ID();
          $phone      = get_post_meta($speaker_id, '_tribe_ext_speaker_phone', true);
          $website    = get_post_meta($speaker_id, '_tribe_ext_speaker_website', true);
          $email      = get_post_meta($speaker_id, '_tribe_ext_speaker_email_address', true);
          $job_title  = get_post_meta($speaker_id, '_tribe_ext_speaker_job_title', true);
          $organization = get_post_meta($speaker_id, '_tribe_ext_speaker_organization', true);
          $country    = get_post_meta($speaker_id, '_tribe_ext_speaker_country', true);
          $linkedin   = get_post_meta($speaker_id, '_tribe_ext_speaker_linkedin', true);
          $twitter    = get_post_meta($speaker_id, '_tribe_ext_speaker_twitter', true);
      @endphp

      <div class="tribe-events-{{ get_post_type() }}">
        <!-- Back Button -->
        <div class="mb-8">
          <a href="/speakers"
             class="inline-flex items-center space-x-2 text-primary hover:text-primary-focus transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            <span>Back to Speakers</span>
          </a>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border">
          @php(do_action('tribe_events_single_' . get_post_type() . '_before_item'))

          <!-- Speaker Header Section -->
          <div class="bg-gradient-to-r bg-base-200/50 px-8 py-12">
            <div class="grid md:grid-cols-3 gap-8 items-center">
              <!-- Avatar Section -->
              <div class="md:col-span-1 flex justify-center">
                @if(has_post_thumbnail())
                  <div class="rounded-full overflow-hidden shadow-lg" style="width: 200px; height: 200px;">
                    <img 
                      src="{{ get_the_post_thumbnail_url($speaker_id, 'full') }}" 
                      alt="{{ get_the_title() }}"
                      class="w-full h-full object-cover"
                    >
                  </div>
                @endif
              </div>

              <!-- Speaker Info Section -->
              <div class="md:col-span-2">
                @php(do_action('tribe_events_single_' . get_post_type() . '_before_title'))
                <h1 class="text-4xl text-gray-900 mb-12">{{ get_the_title() }}</h1>
                @php(do_action('tribe_events_single_' . get_post_type() . '_after_title'))

                <!-- Customized Contact Information -->
                @php(do_action('tribe_events_single_' . get_post_type() . '_before_the_meta'))
                <div class="space-y-3">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                  @if($job_title)
                    <div class="flex items-center space-x-2">
                      <!-- Heroicon: Briefcase -->
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                      </svg>
                      <span>{{ $job_title }}</span>
                    </div>
                  @endif

                  @if($organization)
                    <div class="flex items-center space-x-2">
                      <!-- Heroicon: Building Office -->
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                      </svg>
                      <span>{{ $organization }}</span>
                    </div>
                  @endif

                  @if($country)
                    <div class="flex items-center space-x-2">
                      <!-- Heroicon: Map Pin -->
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                      </svg>
                      <span>{{ $country }}</span>
                    </div>
                  @endif

                  @if($twitter)
                    <div class="flex items-center space-x-2">
                      <!-- Heroicon: Twitter -->
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                      <a href="{{ $twitter }}" class="text-orange-500 hover:underline" target="_blank">
                        Twitter Profile
                      </a>
                    </div>
                  @endif

                  @if($linkedin)
                    <div class="flex items-center space-x-2">
                      <!-- Heroicon: Linkedin -->
                      <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path></svg>
                      <a href="{{ $linkedin }}" class="text-orange-500 hover:underline" target="_blank">
                        Linkedin Profile
                      </a>
                    </div>
                  @endif

                  @if($website)
                    <div class="flex items-center space-x-2">
                      <!-- Heroicon: Globe -->
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                      <a href="{{ $website }}" class="text-orange-500 hover:underline" target="_blank">
                        {{ $website }}
                      </a>
                    </div>
                  @endif

                  @if($email)
                    <div class="flex items-center space-x-2">
                      <!-- Heroicon: Mail -->
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>

                      <a href="mailto:{{ $email }}" class="text-orange-500 hover:underline">
                        {{ $email }}
                      </a>
                    </div>
                  @endif
                  
                </div>
                </div>
                @php(do_action('tribe_events_single_' . get_post_type() . '_after_the_meta'))
              </div>
            </div>
          </div>

          <!-- Speaker Bio Section -->
          <div class="px-8 py-12">
            @if(get_the_content())
              <div class="prose prose-lg max-w-none">
                @php(the_content())
              </div>
            @endif

            <!-- Optional Additional Content -->
            <div class="mt-12">
              <!-- Extra content placeholder -->
            </div>

            @php(do_action('tribe_events_single_' . get_post_type() . '_after_item'))
          </div>
        </div>
        @php(do_action('tribe_events_single_' . get_post_type() . '_after_template'))
      </div>
    @endwhile
  </section>
@endsection
