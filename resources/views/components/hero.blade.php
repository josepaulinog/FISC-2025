<section class="hero min-h-[550px] relative overflow-hidden">
  @php
    // Generate the YouTube embed URL and poster URL
    $cleanVideoUrl = str_replace("watch?v=", "embed/", str_replace("youtube.com", "youtube-nocookie.com", $videoUrl));
    $videoId = null;
    
    // Extract video ID from YouTube URL
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^\/\?\&]+)/', $videoUrl, $matches)) {
        $videoId = $matches[1];
    } elseif (preg_match('/^[a-zA-Z0-9_-]{11}$/', $videoUrl)) {
        // If it's just the video ID (11 characters)
        $videoId = $videoUrl;
    }
    
    // Fallback to a default if no ID found (for testing only)
    if (!$videoId && Str::contains($videoUrl, 'youtube')) {
        $videoId = 'vTzAYp-oXS4';
    }
  @endphp

  <!-- Parallax Background Layer (Mobile Fallback) -->
  <div
    class="absolute inset-0 bg-cover bg-center transform-gpu will-change-transform"
    style="background: url('https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg'); background-attachment: fixed;background-size: cover;"
    data-parallax="scroll" data-speed="0.5"
  ></div>

  @if($videoUrl)
  <div class="absolute inset-0 hidden md:block transform-gpu will-change-transform" data-parallax="scroll" data-speed="0.7">
      @if(Str::contains($videoUrl, 'youtube'))

        <div id="background-video" class="w-full h-full" data-src="{{ $videoUrl }}">
        </div>
      @else

        <div id="background-video" data-src="{{ $videoUrl }}">
        </div>
      @endif
  </div>
  @endif

  <div class="absolute inset-0 z-0 bg-black opacity-50">
  </div>

  <div id="bgImg" class="absolute inset-0 z-0 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>


  <!-- Content with Different Parallax Speed -->
  <div class="z-3 relative flex items-center justify-center h-full w-full px-4 transform-gpu will-change-transform container" data-parallax="scroll" data-speed="0.1">
    <div class="text-left">
      <h1 class="mb-4 text-4xl md:text-6xl drop-shadow-lg text-white mt-6">FISC 2025: The Digital Transformation of Public Financial Management</h1>
      <p class="mb-8 text-lg md:text-2xl drop-shadow text-white text-opacity-80">April 7-10, 2025 | Dili, Timor-Leste</p>
      <div>
        <a href="/agenda" class="btn btn-primary text-white group">
          View Agenda 
          <svg class="w-3 h-3 text-white transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>

<style>
.bg-cover {
  background-size: cover;
  background-position: center;
}
#bgImg {
  background: url(https://eventim.bold-themes.com/conference/wp-content/themes/eventim/gfx/diagonalstripe-black.png);
  background-repeat: repeat;
  background-size: auto;
  opacity: 0.3; 
}
#background-video {
  position: absolute;
  top: -10px;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transform: scale(1.05); /* Slight scale to prevent white edges during parallax */
}

/* YouTube container styles */
#youtube-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  pointer-events: none;
}

#youtube-player {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  /* Calculate scale based on aspect ratio to ensure full coverage */
  transform: translate(-50%, -50%) scale(1.2);
  pointer-events: none;
}

/* Ensure proper parallax functionality */
[data-parallax="scroll"] {
  transform: translateZ(0);
  backface-visibility: hidden;
}

</style>
