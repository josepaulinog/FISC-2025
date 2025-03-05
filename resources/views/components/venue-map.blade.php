@props([
    'venueLabel'       => 'Venue',
    'venueTitle'       => 'Timor-leste Convention Centre',
    'venueImage'       => 'https://cdn.midjourney.com/7fc0c967-a030-4509-9415-313e54c4776e/0_0.png',
    'venueSVG'         => '<svg class="mx-auto" width="92" height="148" viewBox="0 0 92 148" fill="none" xmlns="http://www.w3.org/2000/svg"><path
    d="M90.9673 138.146C91.6004 137.612 91.6807 136.666 91.1465 136.033L82.4411 125.714C81.9069 125.081 80.9605 125.001 80.3274 125.535C79.6942 126.069 79.6139 127.016 80.1481 127.649L87.8863 136.821L78.7145 144.559C78.0813 145.093 78.0011 146.039 78.5353 146.673C79.0695 147.306 80.0158 147.386 80.649 146.852L90.9673 138.146ZM2.14339 0.748035C-0.804437 18.0478 -0.804677 50.5058 10.8439 79.6263C22.5313 108.844 46.0002 134.775 89.8733 138.495L90.1267 135.505C47.6245 131.902 24.9929 106.92 13.6293 78.5121C2.22694 50.007 2.22537 18.1266 5.10077 1.25196L2.14339 0.748035Z"
    fill="#fd6b18" /></svg>',
    'mapCaption'       => 'Dili Convention Centre, Timor Leste',
    'mapUrl'           => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15707.524751609307!2d125.56969491541241!3d-8.556099999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d01ddbf53388799%3A0x9f0afa8afce6fc82!2sDili%20Convention%20Center!5e0!3m2!1sen!2s!4v1707307167149!5m2!1sen!2s',
    'modalId'          => 'my_modal_4',
    'latitude'         => '-8.556099999999999',
    'longitude'        => '125.56969491541241',
    'apiKey'           => '',
    'width'            => '600',
    'height'           => '300'
])

@php
  // Build the static map URL using Google Maps Static API
  $location = urlencode($mapCaption);
  $zoom = 14;
  $size = $width . 'x' . $height;
  $staticMapUrl = "https://maps.googleapis.com/maps/api/staticmap?center={$location}&zoom={$zoom}&size={$size}&maptype=roadmap&markers=color:red%7C{$location}";
  
  // Add API key if provided
  if (!empty($apiKey)) {
    $staticMapUrl .= "&key={$apiKey}";
  }
@endphp

<section class="container mx-auto py-16 bg-base-100">
  <!-- Top Section -->
  <div class="mt-4 md:mt-8 lg:mt-12 pt-1 md:pt-8 lg:pt-12">
    <div class="grid md:grid-cols-12 gap-6">
      <!-- Left Column -->
      <div class="md:col-span-4 xl:col-span-3 text-center md:text-left">
        <h3 class="text-lg">{{ $venueLabel }}</h3>
        <h2 class="text-3xl mb-8">{{ $venueTitle }}</h2>
        <div class="hidden md:block text-orange-500">
          {!! $venueSVG !!}
        </div>
      </div>
      <!-- Right Column -->
      <div class="relative md:col-span-8 xl:col-span-9">
        <img src="{{ $venueImage }}" class="rounded-lg w-full" alt="Venue">
        <div class="absolute inset-0 bottom-0 bg-gradient-to-t from-white via-transparent to-transparent dark:from-[#2a2e37] rounded-lg"></div>
      </div>
    </div>
  </div>

  <!-- Bottom Section with Map Preview -->
  <div class="mt-8 sm:-mt-20 mb-8 md:mb-12 lg:mb-16">
    <div class="grid md:grid-cols-12">
      <div class="md:col-start-7 lg:col-start-8 md:col-span-5 lg:col-span-4 -mt-20">
        <div class="max-w-[416px] mx-auto">
          <!-- Static Map from Google Maps API with Hover Overlay -->
          <div class="map-container relative rounded-lg shadow-lg overflow-hidden cursor-pointer" 
               onclick="document.getElementById('{{ $modalId }}').showModal()">
            <img 
              src="{{ $staticMapUrl }}" 
              class="w-full rounded-lg map-image" 
              alt="Map of {{ $venueTitle }}"
            >
            <div class="map-overlay absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 rounded-lg">
              <div class="text-white text-center p-3 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-10 h-10 mx-auto mb-2">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span class="text-lg font-medium">View Interactive Map</span>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal for Interactive Google Maps -->
<dialog id="{{ $modalId }}" class="modal">
  <div class="modal-box w-11/12 max-w-5xl p-0">
    <!-- Map container -->
    <div class="w-full h-[70vh] rounded-lg overflow-hidden">
      <iframe 
        src="{{ $mapUrl }}" 
        width="100%" 
        height="100%" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
    </div>
    <div class="modal-action mt-0">
      <form method="dialog">
        <button class="btn btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<style>
  /* Custom CSS for hover effect */
  .map-container:hover .map-overlay {
    opacity: 1;
    transition: opacity 0.3s ease;
  }
  
  .map-container .map-overlay {
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  
  .map-container:hover .map-image {
    transform: scale(1.05);
    transition: transform 0.3s ease;
  }
  
  .map-container .map-image {
    transition: transform 0.3s ease;
  }
</style>