@props([
    // Support both user and post type data
    'user' => null,
    'userType' => 'attendee',
    'person' => null,
    'postType' => 'speaker',
    'link' => true,
    'showSocial' => true,
    'showContact' => true,
    'showAdditionalInfo' => false,
    
    // Common fields
    'job_title' => null,
    'organization' => null,
    'country' => null,
    'email' => null,
    'phone' => null,
    'linkedin' => null,
    'twitter' => null,
    'website' => null,
    'bio' => null,
    'avatar' => null,
    
    // Attendee specific fields
    'fullName' => null,
    'arrival_date' => null,
    'hotel_name' => null,
    'visa_required' => null,
    'dietary_restrictions' => null,
    'accessibility_requirements' => null,
])

<div class="card bg-base-100 rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg relative border">
  <!-- Gray header background -->
  <div class="h-24 bg-base-200 dark:bg-gray-700"></div>
  
  <!-- Avatar positioned to overlap header and content -->
  <div class="relative -mt-16 px-6 text-center">
    <div class="avatar flex justify-center mb-4">
      @if($user)
        {{-- User avatar handling --}}
        @if($avatar)
          @if($link)
            <a class="inline-block" href="{{ get_author_posts_url($user->ID) }}">
              <div class="w-32 h-32 mx-auto">
                <img src="{{ $avatar }}" 
                     alt="{{ $user->display_name }}" 
                     class="object-cover w-full h-full rounded-full border-4 border-white dark:border-gray-800 hover:animate-pulse">
              </div>
            </a>
          @else
            <div class="w-32 h-32 mx-auto">
              <img src="{{ $avatar }}" 
                   alt="{{ $user->display_name }}" 
                   class="object-cover w-full h-full rounded-full border-4 border-white dark:border-gray-800">
            </div>
          @endif
        @else
          @if($link)
            <a href="{{ get_author_posts_url($user->ID) }}">
              <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-white dark:border-gray-800">
                <span class="text-2xl text-gray-700">{{ strtoupper(substr($user->display_name, 0, 1)) }}</span>
              </div>
            </a>
          @else
            <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-white dark:border-gray-800">
              <span class="text-2xl text-gray-700">{{ strtoupper(substr($user->display_name, 0, 1)) }}</span>
            </div>
          @endif
        @endif
      @elseif($person)
        {{-- Original post thumbnail handling --}}
        @if(has_post_thumbnail($person->ID))
          @if($link)
            <a class="inline-block" href="{{ get_permalink($person->ID) }}">
              <div class="w-32 h-32 mx-auto">
                <img src="{{ get_the_post_thumbnail_url($person->ID, 'thumbnail') }}" 
                     alt="{{ $person->post_title }}" 
                     class="object-cover w-full h-full rounded-full border-4 border-white dark:border-gray-800 hover:animate-pulse">
              </div>
            </a>
          @else
            <div class="w-32 h-32 mx-auto">
              <img src="{{ get_the_post_thumbnail_url($person->ID, 'thumbnail') }}" 
                   alt="{{ $person->post_title }}" 
                   class="object-cover w-full h-full rounded-full border-4 border-white dark:border-gray-800">
            </div>
          @endif
        @else
          @if($link)
            <a href="{{ get_permalink($person->ID) }}">
              <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-white dark:border-gray-800">
                <span class="text-2xl text-gray-700">{{ strtoupper(substr($person->post_title, 0, 1)) }}</span>
              </div>
            </a>
          @else
            <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-white dark:border-gray-800">
              <span class="text-2xl text-gray-700">{{ strtoupper(substr($person->post_title, 0, 1)) }}</span>
            </div>
          @endif
        @endif
      @endif
    </div>
  
    <div class="text-center px-6 mb-6">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
        @if($user)
          @if($link)
            <a href="{{ get_author_posts_url($user->ID) }}" class="hover:underline">
              {{ $user->display_name }}
            </a>
          @else
            {{ $user->display_name }}
          @endif
        @elseif($person)
          @if($link)
            <a href="{{ get_permalink($person->ID) }}" class="hover:underline">
              {{ $postType === 'attendee' ? $fullName ?? $person->post_title : $person->post_title }}
            </a>
          @else
            {{ $postType === 'attendee' ? $fullName ?? $person->post_title : $person->post_title }}
          @endif
        @endif
      </h3>

      @if($job_title)
        <p class="px-8 text-sm text-orange-600 dark:text-orange-400 font-medium mb-2">{{ $job_title }}</p>
      @endif

      @if($organization)
        <p class="text-gray-500 dark:text-gray-400 mb-4">{{ $organization }}</p>
      @endif

      @if($country)
        <p class="text-gray-500 dark:text-gray-400 mb-4 hidden">{{ $country }}</p>
      @endif

      <!-- Contact and Social Information -->
      <div class="flex justify-center space-x-6">
        <!-- Email (Contact) -->
        @if($showContact && $email)
          <a href="mailto:{{ $email }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400"
             {{ $link ? 'onclick="event.stopPropagation();"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
          </a>
        @endif

        <!-- LinkedIn (Social) -->
        @if($showSocial && $linkedin)
          <a href="{{ $linkedin }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
             {{ $link ? 'onclick="event.stopPropagation();"' : '' }}>
             <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
            </svg>
          </a>
        @endif

        <!-- Twitter (Social) -->
        @if($showSocial && $twitter)
          <a href="{{ $twitter }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400" target="_blank"
             {{ $link ? 'onclick="event.stopPropagation();"' : '' }}>
             <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
          </a>
        @endif
      </div>
    </div>
  </div>
</div>