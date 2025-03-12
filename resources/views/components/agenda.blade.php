@props([
  'title'        => 'Schedule',
  'description'  => 'Explore our schedule of sessions and keynotes.',
  'days'         => [
    '2025-04-06' => 'April 6, 2025',
    '2025-04-07' => 'April 7, 2025',
    '2025-04-08' => 'April 8, 2025',
    '2025-04-09' => 'April 9, 2025',
    '2025-04-10' => 'April 10, 2025',
  ],
  'organizer'    => 'FreeBalance',
  'venue'        => 'Dilli Conference center',
  'location'     => 'Timor Leste',
  'layout'       => 'horizontal', // Add new prop for layout: 'horizontal' or 'vertical'
])

<!-- Alpine.js powered tab navigation with simple slide effect -->
<section class="container py-16 px-4" x-data="{
  activeDay: 1,
  
  init() {
    this.$nextTick(() => this.setActiveContent(1));
  },
  
  setActiveTab(tab) {
    this.activeDay = tab;
    this.setActiveContent(tab);
  },
  
  setActiveContent(tab) {
    const contents = document.querySelectorAll('.day-content');
    const targetContent = document.getElementById(`day-${tab}-content`);
    
    // Hide all contents first
    contents.forEach(content => {
      content.style.display = 'none';
      content.classList.remove('slide-in');
    });
    
    // Show and animate the target content
    if (targetContent) {
      targetContent.style.display = 'block';
      setTimeout(() => {
        targetContent.classList.add('slide-in');
      }, 50);
    }
  }
}">
  <div class="text-center lg:mb-12">
    <h2 class="text-3xl mb-4">{{ $title }}</h2>
    <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
    <p class="text-lg max-w-2xl mx-auto text-neutral-500 dark:text-neutral-400 lg:mb-12">
      {{ $description }}
    </p>
  </div>
  
  @if($layout === 'horizontal')
    <div class="shadow-lg rounded-lg dark:bg-black/25">  
      <!-- Horizontal Tabs Container -->
      <div class="mb-8">
        <div class="grid grid-cols-{{ count($days) }} w-full" role="tablist">
          @foreach ($days as $dayKey => $dayLabel)
            <button
              @click="setActiveTab({{ $loop->iteration }})"
              :class="{ 
                'bg-orange-500 text-white': activeDay === {{ $loop->iteration }},
                'bg-base-200 hover:bg-orange-400 hover:text-white': activeDay !== {{ $loop->iteration }}
              }"
              class="py-4 text-center focus:outline-none transition-colors duration-300 {{ $loop->first ? 'rounded-tl-lg' : '' }} {{ $loop->last ? 'rounded-tr-lg' : '' }}"
              role="tab"
              :aria-selected="activeDay === {{ $loop->iteration }}"
              aria-controls="day-{{ $loop->iteration }}-content">
              <div class="text-sm font-medium">Day {{ $loop->iteration }}</div>
              <div class="text-lg font-semibold">{{ $dayLabel }}</div>
            </button>
          @endforeach
        </div>
      </div>

      <!-- Tab Content Container -->
      <div class="w-full px-8 lg:px-16 relative">
        @foreach ($days as $dayKey => $dayLabel)
          @php
            // Define the date range for the entire day.
            $start_range = $dayKey . ' 00:00:00';
            $end_range = $dayKey . ' 23:59:59';

            // Fetch events using Tribe Events API.
            $events = tribe_get_events([
              'posts_per_page' => -1,
              'order'          => 'ASC',
              'start_date'     => $start_range,
              'end_date'       => $end_range,
              'eventDisplay'   => 'custom'
            ]);
          @endphp
          <div 
            id="day-{{ $loop->iteration }}-content" 
            class="day-content w-full" 
            style="display: {{ $loop->first ? 'block' : 'none' }};"
            role="tabpanel">
            <div class="space-y-8 mt-10">
              @if(count($events))
                @foreach ($events as $event)
                  @php
                    // Retrieve event timing and date.
                    $start_time = tribe_get_start_date($event, false, 'g:i A');
                    $end_time   = tribe_get_end_date($event, false, 'g:i A');
                    $full_date  = tribe_get_start_date($event, false, 'F j, Y');

                    // Fetch event category from taxonomy.
                    $terms = get_the_terms($event->ID, 'tribe_events_cat');
                    $category = ($terms && ! is_wp_error($terms))
                                ? array_shift($terms)->name
                                : 'Session';

                    // Define which categories should have their labels hidden
                    $hideLabelCategories = ['opening', 'lunch', 'dinner', 'break', 'closing', 'social'];
                    $shouldDisplayLabel = !in_array(strtolower($category), $hideLabelCategories);

                    // Set CSS classes based on event category.
                    $cat = strtolower($category);
                    switch ($cat) {
                    case 'presentation':
                      $labelClasses = 'bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-orange-700/10 ring-inset';
                      break;
                    case 'workshop':
                      $labelClasses = 'bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset';
                      break;
                    case 'panel':
                      $labelClasses = 'bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/10 ring-inset';
                      break;
                    case 'demonstration':
                      $labelClasses = 'bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-blue-700/10 ring-inset';
                      break;
                    case 'discussion':
                      $labelClasses = 'bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-700/10 ring-inset';
                      break;
                    default:
                      $labelClasses = 'bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-blue-700/10 ring-inset';
                      break;
                  }
                  @endphp

                  <div class="group pb-8 border-b border-gray-200 last:border-0 space-x-8">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                      <div class="md:col-span-2 space-y-1 space-x-3">
                        <time class="block font-semibold mb-4">{{ $start_time }} - {{ $end_time }}</time>
                        <div class="text-xs/5 text-gray-500 pb-5 hidden">{{ $full_date }}</div>
                        @if($shouldDisplayLabel)
                          <span class="inline-flex items-center rounded-md {{ $labelClasses }}">
                            {{ $category }}
                          </span>
                        @endif
                      </div>
                      <div class="md:col-span-4 space-y-3">
                      @if(in_array(strtolower($category), ['closing', 'opening', 'lunch', 'dinner', 'break']))
                          <h3 class="text-xl font-semibold text-gray-900 transition-colors dark:text-white">
                            {{ $event->post_title }}
                          </h3>
                        @else
                          <a href="{{ get_permalink($event->ID) }}" class="block">
                            <h3 class="text-xl font-semibold text-gray-900 hover:text-orange-600 transition-color dark:text-white">
                              {{ $event->post_title }}
                            </h3>
                          </a>
                        @endif

                        <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed">
                          {!! get_the_excerpt($event->ID) !!}
                        </p>

                        @php
                          // Retrieve the linked speakers.
                          $associated_speakers = tribe_get_linked_posts_by_post_type($event->ID, 'tribe_ext_speaker');
                        @endphp
                        @if(!empty($associated_speakers))
                          <div class="grid gap-4 md:grid-cols-2 pt-2">
                            @foreach($associated_speakers as $speaker)
                              @php
                                $speaker_id    = $speaker->ID;
                                $speaker_name  = get_the_title($speaker_id);
                                $speaker_image = get_the_post_thumbnail_url($speaker_id, 'thumbnail');
                                $speaker_job   = get_post_meta($speaker_id, '_tribe_ext_speaker_job_title', true);
                                
                                // Check if the speaker is a generic speaker that shouldn't be linked
                                $nonLinkableSpeakers = ['FreeBalance Staff', 'Customer Representatives'];
                                $isGenericSpeaker = in_array($speaker_name, $nonLinkableSpeakers);
                              @endphp
                              
                              @if($isGenericSpeaker)
                                {{-- Non-linkable speakers just display as text --}}
                                <div class="flex items-center space-x-3">
                                  <img src="{{ $speaker_image ? $speaker_image : 'https://via.placeholder.com/40' }}"
                                      class="w-10 h-10 rounded-full border"
                                      alt="{{ $speaker_name }}">
                                  <div>
                                    <p class="font-medium text-gray-900 dark:text-neutral-300">
                                      {{ $speaker_name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                      {{ $speaker_job }}
                                    </p>
                                  </div>
                                </div>
                              @else
                                {{-- Regular speakers are linked --}}
                                <a href="{{ get_permalink($speaker_id) }}" class="flex items-center space-x-3 group">
                                  <img src="{{ $speaker_image ? $speaker_image : 'https://via.placeholder.com/40' }}"
                                      class="w-10 h-10 rounded-full border"
                                      alt="{{ $speaker_name }}">
                                  <div>
                                    <p class="font-medium text-gray-900 transition-colors hover:text-orange-600 dark:text-neutral-300">
                                      {{ $speaker_name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                      {{ $speaker_job }}
                                    </p>
                                  </div>
                                </a>
                              @endif
                            @endforeach
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <p class="text-gray-600">No events found for this day.</p>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @else
    <!-- Vertical Layout -->
    <div class="flex flex-col lg:flex-row mt-4">
      <!-- Tabs Container -->
      <div class="w-full lg:w-1/3 mb-6 lg:mb-0">
        <div class="flex flex-col space-y-3 w-full lg:w-80 sticky top-0" role="tablist">
          <h2 class="text-3xl text-center lg:text-left mt-8">{{ $title }}</h2>
          @foreach ($days as $dayKey => $dayLabel)
            <button
              @click="setActiveTab({{ $loop->iteration }})"
              :class="{ 
                'bg-orange-500 text-white': activeDay === {{ $loop->iteration }},
                'bg-base-200 hover:bg-orange-400 hover:text-white': activeDay !== {{ $loop->iteration }}
              }"
              class="w-full rounded-lg px-8 py-8 text-left focus:outline-none transition-colors duration-300"
              role="tab"
              :aria-selected="activeDay === {{ $loop->iteration }}"
              aria-controls="day-{{ $loop->iteration }}-content">
              <div class="text-lg font-medium">Day {{ $loop->iteration }}</div>
              <div class="text-xl font-semibold">{{ $dayLabel }}</div>
            </button>
          @endforeach
        </div>
      </div>

      <!-- Schedule Content -->
      <div class="w-full lg:w-2/3 lg:ms-[8rem]">
        @foreach ($days as $dayKey => $dayLabel)
          @php
            // Define the date range for the entire day.
            $start_range = $dayKey . ' 00:00:00';
            $end_range = $dayKey . ' 23:59:59';

            // Fetch events using Tribe Events API.
            $events = tribe_get_events([
              'posts_per_page' => -1,
              'order'          => 'ASC',
              'start_date'     => $start_range,
              'end_date'       => $end_range,
              'eventDisplay'   => 'custom'
            ]);
          @endphp
          <div 
            id="day-{{ $loop->iteration }}-content" 
            class="day-content" 
            style="display: {{ $loop->first ? 'block' : 'none' }};"
            role="tabpanel">
            <div class="space-y-8">
              @if(count($events))
                @foreach ($events as $event)
                  @php
                    // Retrieve event timing and date.
                    $start_time = tribe_get_start_date($event, false, 'g:i A');
                    $end_time   = tribe_get_end_date($event, false, 'g:i A');
                    $full_date  = tribe_get_start_date($event, false, 'F j, Y');

                    // Fetch event category from taxonomy.
                    $terms = get_the_terms($event->ID, 'tribe_events_cat');
                    $category = ($terms && ! is_wp_error($terms))
                                ? array_shift($terms)->name
                                : 'Session';

                    // Define which categories should have their labels hidden
                    $hideLabelCategories = ['opening', 'lunch', 'dinner', 'break', 'closing', 'social'];
                    $shouldDisplayLabel = !in_array(strtolower($category), $hideLabelCategories);

                    // Set CSS classes based on event category.
                    $cat = strtolower($category);
                    switch ($cat) {
                      case 'opening':
                        $labelClasses = 'bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-orange-700/10 ring-inset';
                        break;
                      case 'lunch':
                        $labelClasses = 'bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset';
                        break;
                      case 'dinner':
                      case 'social':
                        $labelClasses = 'bg-pink-50 px-2 py-1 text-xs font-medium text-pink-700 ring-1 ring-pink-700/10 ring-inset';
                        break;
                      case 'closing':
                        $labelClasses = 'bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/10 ring-inset';
                        break;
                      case 'break':
                        $labelClasses = 'bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-gray-500/10 ring-inset';
                        break;
                      case 'session':
                      default:
                        $labelClasses = 'bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-blue-700/10 ring-inset';
                        break;
                    }
                  @endphp

                  <div class="group pb-8 border-b border-gray-200 last:border-0">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                      <div class="md:col-span-2 space-y-1 space-x-3">
                        <time class="block font-semibold">{{ $start_time }} - {{ $end_time }}</time>
                        <div class="text-xs/5 text-gray-500 pb-5 hidden">{{ $full_date }}</div>
                        @if($shouldDisplayLabel)
                          <span class="inline-flex items-center rounded-md {{ $labelClasses }}">
                            {{ $category }}
                          </span>
                        @endif
                      </div>
                      <div class="md:col-span-4 space-y-3">
                        <a href="{{ get_permalink($event->ID) }}" class="block">
                          <h3 class="text-xl font-semibold text-gray-900 hover:text-orange-600 transition-colors">
                            {{ $event->post_title }}
                          </h3>
                        </a>
                        <p class="text-gray-600 text-sm leading-relaxed">
                          {!! get_the_excerpt($event->ID) !!}
                        </p>

                        @php
                          // Retrieve the linked speakers.
                          $associated_speakers = tribe_get_linked_posts_by_post_type($event->ID, 'tribe_ext_speaker');
                        @endphp
                        @if(!empty($associated_speakers))
                          <div class="grid gap-4 md:grid-cols-2 pt-2">
                            @foreach($associated_speakers as $speaker)
                              @php
                                $speaker_id    = $speaker->ID;
                                $speaker_name  = get_the_title($speaker_id);
                                $speaker_image = get_the_post_thumbnail_url($speaker_id, 'thumbnail');
                                $speaker_job   = get_post_meta($speaker_id, '_tribe_ext_speaker_job_title', true);
                              @endphp
                              <a href="{{ get_permalink($speaker_id) }}" class="flex items-center space-x-3 group">
                                <img src="{{ $speaker_image ? $speaker_image : 'https://via.placeholder.com/40' }}"
                                    class="w-10 h-10 rounded-full ring-2 ring-white transition-all"
                                    alt="{{ $speaker_name }}">
                                <div>
                                  <p class="font-medium text-gray-900 transition-colors hover:text-orange-600">
                                    {{ $speaker_name }}
                                  </p>
                                  <p class="text-xs text-gray-500">
                                    {{ $speaker_job }}
                                  </p>
                                </div>
                              </a>
                            @endforeach
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <p class="text-gray-600">No events found for this day.</p>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
</section>

<style>
  /* Simple slide-in animation */
  .day-content {
    opacity: 0;
    transform: translateX(20px);
    transition: opacity 0.3s ease-out, transform 0.3s ease-out;
  }
  
  .day-content.slide-in {
    opacity: 1;
    transform: translateX(0);
  }
</style>

<style>
  .schedule-content {
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
  }

  .schedule-content.active {
    opacity: 1;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('[role="tab"]');
    const contents = document.querySelectorAll('[role="tabpanel"]');

    function activateTab(tab) {
      // Deactivate all tabs.
      tabs.forEach(t => {
        t.setAttribute('aria-selected', 'false');
        t.classList.remove('bg-orange-500', 'text-white');
        t.classList.add('bg-base-200');
      });

      // Activate the selected tab.
      tab.setAttribute('aria-selected', 'true');
      tab.classList.remove('bg-base-200');
      tab.classList.add('bg-orange-500', 'text-white');

      // Fade out all contents.
      contents.forEach(c => {
        c.classList.remove('active');
        setTimeout(() => c.classList.add('hidden'), 300); // Wait for the fade-out transition to complete
      });

      // Fade in the corresponding content.
      const target = document.getElementById(tab.getAttribute('aria-controls'));
      setTimeout(() => {
        target.classList.remove('hidden');
        setTimeout(() => target.classList.add('active'), 10); // Small delay to ensure the element is visible before fading in
      }, 300);
    }

    // Assign event listeners.
    tabs.forEach(tab => {
      tab.addEventListener('click', () => activateTab(tab));
      tab.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') activateTab(tab);
      });
    });

    // Activate the first tab by default.
    activateTab(tabs[0]);
  });
</script>