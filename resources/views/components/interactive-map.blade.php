<!-- Map Section with Tailwind & DaisyUI -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
  /* Only keeping essential Leaflet overrides that can't be handled by Tailwind/DaisyUI */
  .leaflet-popup-content-wrapper {
    padding: 0 !important;
    overflow: hidden;
  }

  .leaflet-popup-content .btn-primary {
    color: #ffffff !important;
  }
  .leaflet-popup-content {
    margin: 0 !important;
    width: 300px !important;
  }
  .leaflet-container {
    font-family: inherit !important;
  }

  .leaflet-popup-content p {
    margin: 0 !important;
  }

</style>

<section class="py-16 bg-base-200">
    <div class="text-center mb-12">
        <h2 class="text-3xl mb-4">Location & Directions</h2>
        <div class="w-24 h-1 bg-primary rounded-full mx-auto mb-4"></div>
        <p class="text-lg text-base-content/70">Find your way around the conference area</p>
    </div>

    <div class="container mx-auto px-4">
        <div class="card bg-base-100 border shadow-xl overflow-hidden">
            <div class="card-body p-0">
                <div id="map" class="h-[600px] w-full"></div>

                <div class="p-6 bg-base-200/50">
                    <h3 class="text-lg font-medium mb-4">Key Locations</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="flex items-center gap-3">
                            <div class="badge badge-primary badge-lg"></div>
                            <span class="text-base-content/80">Conference Venue</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="badge badge-secondary badge-lg"></div>
                            <span class="text-base-content/80">Hotels</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="badge badge-accent badge-lg"></div>
                            <span class="text-base-content/80">Restaurants</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
const MAP_DATA = {
  venue: [
    {
      position: [-8.556099, 125.567694],
      title: 'Dili Convention Center - FISC 2025',
      category: 'venue',
      icon: 'venue',
      address: '123 Convention Ave, Dili, Timor-Leste',
      description: 'Main conference venue hosting all keynotes and sessions',
      amenities: ['Free WiFi', 'Accessible', 'Parking Available']
    }
  ],
  hotels: [
    {
      position: [-8.555099, 125.566694],
      title: 'Hotel Timor - Main Conference Hotel',
      category: 'hotels',
      icon: 'hotel',
      address: '45 Beach Road, Dili, Timor-Leste',
      description: 'Official conference hotel with special rates for attendees',
      amenities: ['Conference Rate', 'Restaurant', 'Pool']
    },
    {
      position: [-8.557099, 125.568694],
      title: 'Plaza Hotel',
      category: 'hotels',
      icon: 'hotel',
      address: '78 Plaza Street, Dili, Timor-Leste',
      description: 'Alternative accommodation option near the venue',
      amenities: ['Business Center', 'Gym', 'Free Breakfast']
    }
  ],
  dining: [
    {
      position: [-8.554099, 125.565694],
      title: 'Agora Food Studio',
      category: 'dining',
      icon: 'restaurant',
      address: '22 Food Street, Dili, Timor-Leste',
      description: 'Local cuisine featuring Timorese specialties',
      amenities: ['Local Cuisine', 'Vegetarian Options', 'Outdoor Seating']
    },
    {
      position: [-8.558099, 125.569694],
      title: 'Castaway Restaurant',
      category: 'dining',
      icon: 'restaurant',
      address: '89 Beach Front, Dili, Timor-Leste',
      description: 'Seafood restaurant with ocean views',
      amenities: ['Seafood', 'Ocean View', 'Bar']
    },
    {
      position: [-8.553099, 125.564694],
      title: 'Dili Beach Hotel Restaurant',
      category: 'dining',
      icon: 'restaurant',
      address: '33 Seaside Ave, Dili, Timor-Leste',
      description: 'International cuisine with beach views',
      amenities: ['International Cuisine', 'Beach View', 'Full Bar']
    }
  ]
};

class InteractiveMap {
  constructor() {
    this.map = null;
    this.markers = [];
    this.mapStyle = 'https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=VhMYYW4B1qp8ZpsVF2LP';
    
    // DaisyUI themed markers
    this.icons = {
      venue: L.divIcon({
        html: `<div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
               </div>`,
        className: 'custom-marker'
      }),
      hotel: L.divIcon({
        html: `<div class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white  shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
               </div>`,
        className: 'custom-marker'
      }),
      restaurant: L.divIcon({
        html: `<div class="flex items-center justify-center w-8 h-8 rounded-full bg-accent text-white shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 7.5h10.5a.75.75 0 0 0 0-1.5H6.75a.75.75 0 0 0 0 1.5Z" />
                </svg>
               </div>`,
        className: 'custom-marker'
      })
    };
  }

  createPopupContent(location) {
    const badgeClass = {
      venue: 'badge-primary',
      hotels: 'badge-secondary',
      dining: 'badge-accent'
    }[location.category];

    const typeLabel = {
      venue: 'Conference Venue',
      hotels: 'Hotel',
      dining: 'Restaurant'
    }[location.category];

    return `
      <div class="card card-compact bg-base-100">
        <div class="card-body gap-3">
          <div>
            <div class="badge ${badgeClass} gap-2 mb-2 text-white">
              ${typeLabel}
            </div>
            <h3 class="card-title text-base-content">${location.title}</h3>
          </div>
          
          <div class="text-sm text-base-content/70">
            <p class="flex gap-2 items-start">
              <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
              </svg>
              ${location.address}
            </p>
            <p class="pt-2">${location.description}</p>
          </div>

          <div class="flex flex-wrap gap-2 mt-2">
            ${location.amenities.map(amenity => `
              <span class="badge badge-ghost badge-sm">${amenity}</span>
            `).join('')}
          </div>

          <div class="card-actions justify-end mt-4">
            <a href="https://www.google.com/maps/dir/?api=1&destination=${location.position[0]},${location.position[1]}" 
               target="_blank" 
               class="btn btn-primary btn-sm gap-2 text-white font-normal">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
              </svg>
              Get Directions
            </a>
          </div>
        </div>
      </div>
    `;
  }

  initialize() {
    this.map = L.map('map', {
      center: [-8.556099, 125.567694],
      zoom: 13,
      scrollWheelZoom: false,
      zoomControl: true,
    });
    
    L.tileLayer(this.mapStyle, {
      attribution: '',
      maxZoom: 18,
      tileSize: 512,
      zoomOffset: -1,
    }).addTo(this.map);

    // Show all markers
    this.showAllMarkers();

    // Enable zoom on click
    this.map.on('click', () => {
      if (!this.map.scrollWheelZoom.enabled()) {
        this.map.scrollWheelZoom.enable();
      }
    });
    
    // Disable zoom on mouse leave
    this.map.on('mouseout', () => {
      this.map.scrollWheelZoom.disable();
    });
  }

  showAllMarkers() {
    const allMarkers = [];
    
    // Combine all location data
    Object.keys(MAP_DATA).forEach(category => {
      MAP_DATA[category].forEach(location => {
        const marker = L.marker(location.position, {
          icon: this.icons[location.icon]
        })
        .bindPopup(this.createPopupContent(location), {
          closeButton: true,
          maxWidth: 300,
          className: 'custom-popup'
        })
        .addTo(this.map);
        
        // Open venue popup by default
        if (location.category === 'venue') {
          marker.openPopup();
        }
        
        allMarkers.push(marker);
      });
    });

    // Fit bounds to show all markers
    const bounds = L.featureGroup(allMarkers).getBounds();
    this.map.fitBounds(bounds, { padding: [50, 50], maxZoom: 16 });
  }
}

// Initialize map when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('map')) {
    const interactiveMap = new InteractiveMap();
    interactiveMap.initialize();
  }
});
</script>