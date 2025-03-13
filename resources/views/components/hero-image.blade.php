<section class="hero min-h-[550px] relative overflow-hidden">
  @php
    // Set default image if not provided
    $backgroundImage = $backgroundImage ?? 'https://replicate.delivery/xezq/RvPsYyTIquoYMlykr5JTw8yMyNz5eNemQb2Mui7QwGIX5oXUA/tmpdx5k9d5d.png';

    $backgroundImage2 = $backgroundImage ?? 'https://replicate.delivery/xezq/6AvTTfeFqjhTiEIpjZY1ZDImemjftgTX2hDc9EB2Q4kPTjeiC/tmpe4r2w_3a.jpg';
    
    // Optional overlay opacity (can be passed as a prop)
    $overlayOpacity = $overlayOpacity ?? 50; // Default 50%
    $overlayOpacityValue = $overlayOpacity / 100;
  @endphp

  <!-- Parallax Background Image Layer -->
  <div
    class="absolute inset-0 bg-cover bg-center transform-gpu will-change-transform"
    style="background-image: url('{{ $backgroundImage }}'); background-attachment: fixed;"
    data-parallax="scroll" data-speed="0.5"
  ></div>

  <!-- Fixed Overlay (No Parallax) -->
  <div class="absolute inset-0 z-0 bg-black opacity-{{ $overlayOpacity }}">
    <div id="bgPattern" class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
  </div>

  <!-- Content with Different Parallax Speed -->
  <div class="relative flex items-center justify-center h-full w-full px-4 transform-gpu will-change-transform container" data-parallax="scroll" data-speed="0.1">
    <div class="text-left">
      <h1 class="mb-4 text-4xl md:text-5xl drop-shadow-lg text-white mt-6">{{ $title ?? 'FISC 2025: The Digital Transformation of Public Financial Management' }}</h1>
      <p class="mb-8 text-lg md:text-2xl drop-shadow text-white text-opacity-80">{{ $subtitle ?? 'April 7-10, 2025 | Dili, Timor-Leste' }}</p>
      
      @if(isset($primaryButtonText))
      <div>
        <a href="{{ $primaryButtonUrl ?? '/agenda' }}" class="btn btn-primary text-white group">
          {{ $primaryButtonText }} 
          <svg class="w-3 h-3 text-white transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
          </svg>
        </a>
        
        @if(isset($secondaryButtonText))
        <a href="{{ $secondaryButtonUrl ?? '#' }}" class="btn btn-ghost text-white border-white hover:bg-white hover:text-gray-900 ml-4 group">
          {{ $secondaryButtonText }}
          <svg class="w-3 h-3 transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
          </svg>
        </a>
        @endif
      </div>
      @endif
      
      {{ $slot ?? '' }}
    </div>
  </div>
</section>

<style>
.bg-cover {
  background-size: cover;
  background-position: center;
}

#bgPattern {
  background: url(https://eventim.bold-themes.com/conference/wp-content/themes/eventim/gfx/diagonalstripe-black.png);
}

/* Ensure proper parallax functionality */
[data-parallax="scroll"] {
  transform: translateZ(0);
  backface-visibility: hidden;
}

/* Add a subtle animation to the background for visual interest */
@keyframes slowly-zoom {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(1.05);
  }
}

.hero .absolute.inset-0.bg-cover {
  animation: slowly-zoom 20s alternate infinite ease-in-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  
  .hero .absolute.inset-0.bg-cover {
    background-attachment: scroll; /* Disable fixed background on mobile */
  }
}
</style>