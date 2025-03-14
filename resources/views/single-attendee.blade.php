{{-- resources/views/single-attendee.blade.php --}}
@extends('layouts.app')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-neutral-600">
    @while(have_posts())
      @php
          the_post();
          $person_id    = get_the_ID();
          $phone        = get_post_meta($person_id, 'phone_number', true);
          $website      = get_post_meta($person_id, 'website', true);
          $email        = get_post_meta($person_id, 'email_address', true);
          $job_title    = get_post_meta($person_id, 'job_title', true);
          $organization = get_post_meta($person_id, 'organization', true);
          $country      = get_post_meta($person_id, 'country', true);
          $linkedin     = get_post_meta($person_id, 'linkedin', true);
          $twitter      = get_post_meta($person_id, 'twitter', true);
      @endphp

      <div class="attendee-profile">
        <!-- Back Button -->
        <div class="mb-8">
          <a href="/attendees"
             class="inline-flex items-center space-x-2 text-primary hover:text-primary-focus transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Back to Attendees</span>
          </a>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border">
          <div class="bg-base-200 px-8 py-12">
            <div class="grid md:grid-cols-3 gap-8 items-center">
              <!-- Profile Picture -->
              <div class="md:col-span-1 flex justify-center">
                @if(has_post_thumbnail())
                  <div class="rounded-full overflow-hidden border-4 border-white shadow-lg" style="width: 200px; height: 200px;">
                    <img 
                      src="{{ get_the_post_thumbnail_url($person_id, 'thumbnail') }}" 
                      alt="{{ get_the_title() }}"
                      class="w-full h-full object-cover"
                    >
                  </div>
                @else
                  <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center">
                    <span class="text-xl text-gray-700">{{ strtoupper(substr(get_the_title(), 0, 1)) }}</span>
                  </div>
                @endif
              </div>

              <!-- Attendee Information -->
              <div class="md:col-span-2">
                <h1 class="text-4xl text-gray-900 mb-8">{{ get_the_title() }}</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                  @if($job_title)
                    <div class="flex items-center space-x-2">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                      </svg>
                      <span>{{ $job_title }}</span>
                    </div>
                  @endif

                  @if($organization)
                    <div class="flex items-center space-x-2">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                      </svg>
                      <span>{{ $organization }}</span>
                    </div>
                  @endif

                  @if($country)
                    <div class="flex items-center space-x-2">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                      </svg>
                      <span>{{ $country }}</span>
                    </div>
                  @endif

                  @if($phone)
                    <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                      <span>{{ $phone }}</span>
                    </div>
                  @endif
                </div>

                <!-- Social Links -->
                <div class="flex space-x-2 mt-4">
                  @if($email)
                    <a href="mailto:{{ $email }}" class="flex items-center space-x-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                      </svg>
                      <span class="text-orange-500 underline hover:underline ms-2">Email</span>
                    </a>
                  @endif

                  @if($linkedin)
                    <a href="{{ $linkedin }}" class="text-orange-500 hover:underline flex items-center space-x-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                      </svg>
                      <span>LinkedIn</span>
                    </a>
                  @endif

                  @if($twitter)
                    <a href="{{ $twitter }}" class="text-orange-500 hover:underline flex items-center space-x-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                      </svg>
                      <span>Twitter</span>
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Attendee Bio -->
          <div class="px-8 py-12">
            @if(get_the_content())
              <div class="prose prose-lg max-w-none">
                @php(the_content())
              </div>
            @endif
          </div>
        </div>
      </div>
    @endwhile
  </div>
@endsection