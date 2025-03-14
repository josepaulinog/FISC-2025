@props([
  // Background class for the section container.
  'bgClass' => 'bg-white',
  // URL for the illustration image.
  'imageUrl' => '',
  // Alternative text for the image.
  'imageAlt' => '',
  // Position of the image relative to the text: 'left' or 'right' (default is 'right').
  'imagePosition' => 'right',
  // Main title of the section.
  'title' => '',
  // Primary paragraph text.
  'paragraph1' => '',
  // Secondary paragraph text.
  'paragraph2' => '',
  'items' => [] 
])

<section class="py-16 {{ $bgClass }}">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row w-full lg:gap-16">
      @if($imagePosition === 'vectorLeft')
        <!-- Illustration on the left -->
        <div class="w-full lg:w-1/2">
          <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="mx-auto mb-8 lg:mb-0" />
        </div>
        <!-- Text Content on the right -->
        <div class="w-full lg:w-1/2">
          <h2 class="text-3xl text-gray-800 dark:text-white mb-4">{{ $title }}</h2>
          <p class="py-4 leading-relaxed text-neutral-600 dark:text-neutral-400">
            {{ $paragraph1 }}
          </p>
          <p class="mb-6 leading-relaxed text-neutral-600 dark:text-neutral-400">
            {{ $paragraph2 }}
          </p>
          @if (!empty($items))
            <ul class="space-y-4 text-left text-neutral-600 dark:text-gray-400 mb-8 md:mb-0 ms-4">
              @foreach ($items as $item)
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <svg class="shrink-0 w-4 h-4 text-secondary dark:text-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>  
                <span>{{ $item }}</span></li>
              @endforeach
            </ul>
          @endif
          {{ $slot }}
        </div>
       @elseif($imagePosition === 'vectorRight')
        <!-- Text Content on the left -->
        <div class="w-full lg:w-1/2">
          <h2 class="text-3xl text-gray-800 dark:text-white mb-4">{{ $title }}</h2>
          <p class="py-4 leading-relaxed text-neutral-600 dark:text-neutral-400">
            {{ $paragraph1 }}
          </p>
          @if (!empty($paragraph2))
          <p class="mb-6 leading-relaxed text-neutral-600 dark:text-neutral-400">
            {{ $paragraph2 }}
          </p>
          @endif
          @if (!empty($items))
            <ul class="space-y-4 text-left text-neutral-600 dark:text-gray-400 mb-8 md:mb-0 ms-4">
              @foreach ($items as $item)
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <svg class="shrink-0 w-4 h-4 text-secondary dark:text-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>  
                <span>{{ $item }}</span></li>
              @endforeach
            </ul>
          @endif
          {{ $slot }}
        </div>
        <!-- Illustration on the right -->
        <div class="w-full lg:w-1/2">
          <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="lg:max-w-md mx-auto" />
        </div>
      @elseif($imagePosition === 'left')
        <!-- Illustration on the left -->
        <div class="w-full lg:w-1/2">
          <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="lg:max-w-md mx-auto rounded-lg shadow-lg mb-8 lg:mb-0" />
        </div>
        <!-- Text Content on the right -->
        <div class="w-full lg:w-1/2">
          <h2 class="text-3xl text-gray-800 dark:text-white mb-4">{{ $title }}</h2>
          <p class="py-4 leading-relaxed text-neutral-600 dark:text-neutral-400">
            {{ $paragraph1 }}
          </p>
          @if (!empty($paragraph2))
          <p class="mb-6 leading-relaxed text-neutral-600 dark:text-neutral-400">
            {{ $paragraph2 }}
          </p>
          @endif
          @if (!empty($items))
            <ul class="space-y-4 text-left text-neutral-600 dark:text-gray-40 lg:mb-8 ms-4">
              @foreach ($items as $item)
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <svg class="shrink-0 w-4 h-4 text-secondary dark:text-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>  
                <span>{{ $item }}</span></li>
              @endforeach
            </ul>
          @endif
          {{ $slot }}
        </div>
      @else
        <!-- Text Content on the left -->
        <div class="w-full lg:w-1/2">
          <h2 class="text-3xl text-gray-800 dark:text-white mb-4">{{ $title }}</h2>
          <p class="py-4 leading-relaxed text-neutral-600 dark:text-neutral-400">
            {{ $paragraph1 }}
          </p>
          @if (!empty($paragraph2))
          <p class="mb-6 leading-relaxed text-neutral-600 dark:text-neutral-400">
            {{ $paragraph2 }}
          </p>
          @endif

          @if (!empty($items))
            <ul class="space-y-4 text-left text-neutral-600 dark:text-gray-400 mb-8 md:mb-0 ms-4">
              @foreach ($items as $item)
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <svg class="shrink-0 w-4 h-4 text-secondary dark:text-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>  
                <span>{{ $item }}</span></li>
              @endforeach
            </ul>
          @endif

          {{ $slot }}
        </div>
        <!-- Illustration on the right -->
        <div class="w-full lg:w-1/2">
          <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="lg:max-w-md mx-auto rounded-lg shadow-lg" />
        </div>
      @endif
    </div>
  </div>
</section>