@props([
    'videoUrl' => '',
    'title' => '',
    'thumbnailUrl' => '',
    'date' => '',
    'categories' => [],
    'excerpt' => '',
    'year' => '',
])

<div class="video-item group shadow-xl rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
  <div class="relative aspect-video cursor-pointer" 
       onclick="openVideoModal('{{ $videoUrl }}', '{{ $title }}')">
    <img src="{{ $thumbnailUrl }}" 
         alt="{{ $title }}" 
         class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-white opacity-80">
        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z" clip-rule="evenodd" />
      </svg>
    </div>
  </div>
  <div class="p-4">
    <div class="flex justify-between items-start mb-2">
      <h3 class="text-lg font-semibold line-clamp-2">{{ $title }}</h3>
      @if($year)
        <span class="badge badge-primary">{{ $year }}</span>
      @endif
    </div>
    @if($date)
      <div class="flex items-center text-sm text-gray-500 mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
        </svg>
        {{ $date }}
      </div>
    @endif
    
    @if(count($categories) > 0)
      <div class="flex flex-wrap gap-1 mb-3">
        @foreach($categories as $category)
          <span class="badge badge-outline badge-sm">{{ $category }}</span>
        @endforeach
      </div>
    @endif
    
    @if($excerpt)
      <div class="mt-2 line-clamp-2 text-sm text-gray-600">{{ $excerpt }}</div>
    @endif
  </div>
</div>