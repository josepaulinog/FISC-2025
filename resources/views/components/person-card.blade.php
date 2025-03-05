@props([
    'person' => null,
    'postType' => 'speaker', // or 'attendee'
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
    </div>
  
    <div class="text-center px-6 mb-6">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
        @if($link)
          <a href="{{ get_permalink($person->ID) }}" class="hover:underline">
            {{ $postType === 'attendee' ? $fullName ?? $person->post_title : $person->post_title }}
          </a>
        @else
          {{ $postType === 'attendee' ? $fullName ?? $person->post_title : $person->post_title }}
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

        <!-- Phone (Contact) -->
        @if($showContact && $phone)
          <a href="tel:{{ $phone }}" class="text-gray-600 hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400"
             {{ $link ? 'onclick="event.stopPropagation();"' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
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
                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
            </svg>
          </a>
        @endif
      </div>

      <!-- Additional Information for Attendees -->
      @if(filter_var($showAdditionalInfo, FILTER_VALIDATE_BOOLEAN) && $postType === 'attendee')
        <div class="mt-4 text-left">
          @if($arrival_date)
            <p class="text-gray-600 dark:text-gray-300">
              <strong>Arrival Date:</strong> {{ $arrival_date }}
            </p>
          @endif

          @if($hotel_name)
            <p class="text-gray-600 dark:text-gray-300">
              <strong>Hotel:</strong> {{ $hotel_name }}
            </p>
          @endif

          @if($visa_required)
            <p class="text-gray-600 dark:text-gray-300">
              <strong>Visa Required:</strong> Yes
            </p>
          @endif

          @if($dietary_restrictions)
            <p class="text-gray-600 dark:text-gray-300">
              <strong>Dietary Restrictions:</strong> {{ $dietary_restrictions }}
            </p>
          @endif

          @if($accessibility_requirements)
            <p class="text-gray-600 dark:text-gray-300">
              <strong>Accessibility:</strong> {{ $accessibility_requirements }}
            </p>
          @endif
        </div>
      @endif
    </div>
  </div>
</div>