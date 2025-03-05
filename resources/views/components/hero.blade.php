<section class="hero min-h-[500px] lg:min-h-[600px] relative overflow-hidden">
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
    class="absolute inset-0 bg-cover bg-center lg:hidden transform-gpu will-change-transform"
    style="background: url('https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg'); background-attachment: fixed;"
    data-parallax="scroll" data-speed="0.5"
  ></div>

  <!-- Desktop Video with Parallax Effect -->
  @if($videoUrl)
  <div class="absolute inset-0 hidden md:block transform-gpu will-change-transform" data-parallax="scroll" data-speed="0.7">
    @if(Str::contains($videoUrl, 'youtube'))
      <!-- For YouTube videos, use YouTube iframe API -->
      <div id="youtube-container" class="w-full h-full">
        <div id="youtube-player"></div>
      </div>
    @else
      <!-- For direct video files, use native HTML5 video -->
      <video
        id="background-video"
        class="object-cover absolute inset-0 w-full h-full"
        autoplay
        muted
        playsinline
        loop
        preload="auto"
      >
        <source src="{{ $videoUrl }}" type="video/mp4">
      </video>
    @endif
  </div>
  @endif

  <!-- YouTube API Script -->
  @if(Str::contains($videoUrl, 'youtube') && $videoId)
  <script>
    // Load the YouTube IFrame Player API code asynchronously
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    function onYouTubeIframeAPIReady() {
      // Calculate optimal size to ensure video always covers the container
      const updatePlayerSize = () => {
        const containerWidth = document.getElementById('youtube-container').offsetWidth;
        const containerHeight = document.getElementById('youtube-container').offsetHeight;
        const playerElement = document.getElementById('youtube-player');
        
        // 16:9 is YouTube's aspect ratio
        const videoRatio = 16/9;
        const containerRatio = containerWidth/containerHeight;
        
        let newWidth, newHeight;
        
        // If container is wider than video aspect ratio
        if (containerRatio > videoRatio) {
          newWidth = containerWidth * 1.2; // Add 20% to ensure coverage
          newHeight = newWidth / videoRatio;
        } else {
          newHeight = containerHeight * 1.2; // Add 20% to ensure coverage
          newWidth = newHeight * videoRatio;
        }
        
        if (playerElement) {
          playerElement.style.width = newWidth + 'px';
          playerElement.style.height = newHeight + 'px';
        }
      };
      
      // Initialize player with larger dimensions
      player = new YT.Player('youtube-player', {
        videoId: '{{ $videoId }}',
        playerVars: {
          autoplay: 1,
          loop: 1,
          mute: 1,
          controls: 0,
          showinfo: 0,
          modestbranding: 1,
          rel: 0,
          iv_load_policy: 3,
          fs: 0,
          playsinline: 1,
          disablekb: 1,
          playlist: '{{ $videoId }}' // Required for looping
        },
        events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
        }
      });
      
      // Update size on load and window resize
      window.addEventListener('resize', updatePlayerSize);
      setTimeout(updatePlayerSize, 500); // Initial size after player loads
    }

    function onPlayerReady(event) {
      event.target.mute();
      event.target.playVideo();
    }

    function onPlayerStateChange(event) {
      // Restart video if it ends
      if (event.data === YT.PlayerState.ENDED) {
        player.playVideo();
      }
      
      // For some browsers, we need to re-mute on state change
      if (event.data === YT.PlayerState.PLAYING) {
        event.target.mute();
      }
    }
    
    // Additional check to ensure full coverage on window resize
    window.addEventListener('resize', function() {
      // Force redraw of player element to ensure it covers the container
      const playerElement = document.querySelector('#youtube-player');
      if (playerElement) {
        const iframe = playerElement.querySelector('iframe');
        if (iframe) {
          // Get container dimensions
          const container = document.getElementById('youtube-container');
          const containerWidth = container.offsetWidth;
          const containerHeight = container.offsetHeight;
          
          // Calculate dimensions that will cover the container with some extra padding
          // YouTube's aspect ratio is 16:9
          const videoRatio = 16/9;
          const containerRatio = containerWidth/containerHeight;
          
          let newWidth, newHeight;
          
          if (containerRatio > videoRatio) {
            // Container is wider than the video's aspect ratio
            newWidth = containerWidth * 1.2;
            newHeight = newWidth / videoRatio;
          } else {
            // Container is taller than the video's aspect ratio
            newHeight = containerHeight * 1.2;
            newWidth = newHeight * videoRatio;
          }
          
          // Apply the new dimensions to the iframe
          iframe.style.width = newWidth + 'px';
          iframe.style.height = newHeight + 'px';
        }
      }
    });
  </script>
  @endif

  <!-- Fixed Overlay (No Parallax) -->
  <div class="absolute inset-0 z-0 bg-black opacity-50">
    <div id="bgImg" class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
  </div>

  <!-- Content with Different Parallax Speed -->
  <div class="relative flex items-center justify-center h-full w-full px-4 transform-gpu will-change-transform container" data-parallax="scroll" data-speed="0.1">
    <div class="text-left">
      <h1 class="mb-4 text-4xl md:text-6xl drop-shadow-lg text-white">FISC 2025: Empowering Public Finance Innovation</h1>
      <p class="mb-8 text-lg md:text-2xl drop-shadow text-white text-opacity-80">April 7-10, 2025 | Dili, Timor-Leste</p>
      <div class="mt-6">
        <a href="/agenda" class="btn btn-primary text-white mt-6 group">
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
}
#background-video {
  position: absolute;
  top: -10px;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -1;
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
  z-index: -1;
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

:where(.menu li:not(.menu-title):not(.disabled)>:not(ul):not(details):not(.menu-title)):not(summary):not(.active):not(.btn):focus {
  color: #fff !important;
}
</style>