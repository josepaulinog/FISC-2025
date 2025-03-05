// components/gallery.js
import Shuffle from 'shufflejs';
import { debounce } from 'lodash';

// Modal implementation for DaisyUI modal with checkbox toggle
window.openModal = (imageUrl, caption, category, resetGallery = true) => {
  // For DaisyUI modal with checkbox toggle
  const modalToggle = document.getElementById('gallery-modal-toggle');
  if (!modalToggle) return;
  
  // Reset gallery collection if requested
  if (resetGallery) {
    // Will be set by the click handler
  }
  
  // Update navigation button visibility
  const prevButton = document.getElementById('prev-button');
  const nextButton = document.getElementById('next-button');
  
  if (prevButton && nextButton) {
    if (currentGalleryImages.length <= 1) {
      prevButton.classList.add('hidden');
      nextButton.classList.add('hidden');
    } else {
      prevButton.classList.remove('hidden');
      nextButton.classList.remove('hidden');
    }
  }
  
  // Find elements, with fallbacks if they don't exist yet
  const modalImage = document.getElementById('modal-image');
  if (modalImage) {
    // Show loading state
    modalImage.classList.add('opacity-50');
    
    // Preload image to get dimensions
    const img = new Image();
    img.onload = function() {
      modalImage.src = imageUrl;
      modalImage.classList.remove('opacity-50');
      
      // Show the caption only if provided
      const modalTitle = document.getElementById('modal-title');
      if (modalTitle) modalTitle.textContent = caption || '';
      
      const modalCategory = document.getElementById('modal-category');
      if (modalCategory) modalCategory.textContent = category || '';
      
      // Hide caption if empty
      const modalCaption = document.getElementById('modal-caption');
      if (modalCaption) {
        if (caption || category) {
          modalCaption.style.display = 'block';
        } else {
          modalCaption.style.display = 'none';
        }
      }
      
      // Setup download link
      const downloadLink = document.getElementById('download-link');
      if (downloadLink) downloadLink.href = imageUrl;
    };
    img.src = imageUrl;
  }
  
  // Check/set the toggle to show the modal
  modalToggle.checked = true;
  document.body.classList.add('overflow-hidden');
};

window.closeModal = () => {
  const modalToggle = document.getElementById('gallery-modal-toggle');
  if (modalToggle) {
    modalToggle.checked = false;
  }
  document.body.classList.remove('overflow-hidden');
};

export const setupGallery = () => {
  const years = document.querySelectorAll('.gallery-year');
  const shuffleInstances = {};
  const currentFilters = {};
  const currentSearch = {};

  // Helper: Apply combined filters (day, category, and search)
  const applyFilters = (year) => {
    const activeDayElem = document.querySelector(`.day-tab.tab-active[data-year="${year}"]`);
    const activeDay = activeDayElem ? activeDayElem.dataset.day : '1';
    const filterValue = currentFilters[year] || 'all';
    const searchValue = (currentSearch[year] || '').toLowerCase();

    if (shuffleInstances[year]) {
      shuffleInstances[year].filter(item => {
        // Check day filter
        if (item.dataset.day !== activeDay) return false;
        // Check category filter
        if (filterValue !== 'all' && !JSON.parse(item.dataset.groups).includes(filterValue)) return false;
        // Check search filter
        const captionElem = item.querySelector('.font-medium');
        if (searchValue && captionElem) {
          const captionText = captionElem.textContent.toLowerCase();
          if (!captionText.includes(searchValue)) return false;
        }
        return true;
      });
    }
  };

  // Initialize shuffle for each year with v6 configuration
  years.forEach(yearEl => {
    const year = yearEl.dataset.year;
    const container = yearEl.querySelector(`#grid-${year}`);
    currentFilters[year] = 'all';
    currentSearch[year] = '';
    
    if (container) {
      shuffleInstances[year] = new Shuffle(container, {
        itemSelector: '.js-item',
        // Remove sizer element as we're using CSS Grid
        gutterWidth: 0, // Grid gap is handled by Tailwind
        buffer: 0, // Optional: Reduce buffer since we're using CSS Grid
        roundTransforms: false, // Disable round transforms for better performance
        // New v6 options for better performance
        delimiter: ',',
        throttleTime: 300,
        filterMode: Shuffle.FilterMode.ALL,
      });

      // Force layout update after images load
      container.querySelectorAll('img').forEach(img => {
        img.onload = () => {
          shuffleInstances[year].update();
        };
      });
    }
  });

  // Year selection handler
  const yearSelectors = document.querySelectorAll('.year-selector');
  yearSelectors.forEach(selector => {
    selector.addEventListener('click', (e) => {
      e.preventDefault();
      const selectedYear = selector.dataset.year;
      
      years.forEach(yearEl => {
        yearEl.style.display = 'none';
      });
      
      const targetYear = document.querySelector(`#year-${selectedYear}`);
      if (targetYear) {
        targetYear.style.display = 'block';
        // Add delay for DOM update before shuffle update
        requestAnimationFrame(() => {
          if (shuffleInstances[selectedYear]) {
            shuffleInstances[selectedYear].update();
          }
        });
      }
    });
  });

  // Day tabs handler
  const dayTabs = document.querySelectorAll('.day-tab');
  dayTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const year = tab.dataset.year;
      
      const siblingTabs = tab.parentElement.querySelectorAll('.day-tab');
      siblingTabs.forEach(sibTab => sibTab.classList.remove('tab-active'));
      tab.classList.add('tab-active');
      
      applyFilters(year);
    });
  });

  // Category filter tabs handler
  const filterTabs = document.querySelectorAll('.filter-tab');
  filterTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const year = tab.dataset.year;
      const filterValue = tab.dataset.filter;
      currentFilters[year] = filterValue;
      
      const siblingTabs = tab.parentElement.querySelectorAll('.filter-tab');
      siblingTabs.forEach(sibling => sibling.classList.remove('tab-active'));
      tab.classList.add('tab-active');
      
      applyFilters(year);
    });
  });

  // Search input handler - use lodash debounce function
  const searchInputs = document.querySelectorAll('[id^="shuffle-search-"]');
  searchInputs.forEach(searchInput => {
    const handleSearch = debounce((year, value) => {
      currentSearch[year] = value;
      applyFilters(year);
    }, 150);
    
    searchInput.addEventListener('input', () => {
      const year = searchInput.dataset.year;
      handleSearch(year, searchInput.value);
    });
  });

  // Show first year by default
  if (years.length > 0) {
    const firstYear = years[0];
    firstYear.style.display = 'block';
    const year = firstYear.dataset.year;
    
    // Use intersection observer to update layout when visible
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && shuffleInstances[year]) {
          shuffleInstances[year].update();
          applyFilters(year);
          observer.disconnect(); // Only need to observe once
        }
      });
    }, { threshold: 0.1 });
    
    observer.observe(firstYear);
  }

  // Handle window resize with proper debouncing
  const handleResize = debounce(() => {
    Object.values(shuffleInstances).forEach(instance => {
      instance.update();
    });
  }, 100);
  
  window.addEventListener('resize', handleResize);
};

// Track current gallery state
let currentGalleryImages = [];
let currentImageIndex = 0;

// Navigate to the previous image in the gallery
const navigatePrev = () => {
  if (currentGalleryImages.length <= 1) return;
  
  currentImageIndex = (currentImageIndex - 1 + currentGalleryImages.length) % currentGalleryImages.length;
  const prevImage = currentGalleryImages[currentImageIndex];
  
  if (prevImage) {
    window.openModal(
      prevImage.dataset.fullImage || prevImage.querySelector('img').src,
      prevImage.dataset.caption || '',
      prevImage.dataset.category || '',
      false // Don't reset the gallery (prevents loop)
    );
  }
};

// Navigate to the next image in the gallery
const navigateNext = () => {
  if (currentGalleryImages.length <= 1) return;
  
  currentImageIndex = (currentImageIndex + 1) % currentGalleryImages.length;
  const nextImage = currentGalleryImages[currentImageIndex];
  
  if (nextImage) {
    window.openModal(
      nextImage.dataset.fullImage || nextImage.querySelector('img').src,
      nextImage.dataset.caption || '',
      nextImage.dataset.category || '',
      false // Don't reset the gallery (prevents loop)
    );
  }
};

export const setupGalleryModal = () => {
  // Initialize gallery from onclick elements
  document.querySelectorAll('[onclick*="openModal"]').forEach(el => {
    // Extract parameters from onclick attribute
    const onclickAttr = el.getAttribute('onclick');
    if (onclickAttr && onclickAttr.includes('openModal')) {
      el.removeAttribute('onclick');
      
      el.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        // Extract parameters using regex
        const match = onclickAttr.match(/openModal\('([^']+)',\s*'([^']*)'\s*,\s*'([^']*)'/);
        if (match) {
          const [_, imageUrl, caption, category] = match;
          
          // Find the parent figure to get the correct image in the collection
          const figureElement = el.closest('figure.js-item');
          if (figureElement) {
            // Get all images in the same group (year and day)
            const year = figureElement.dataset.year;
            const day = figureElement.dataset.day;
            
            // Get all images in this year/day
            const yearDaySelector = `figure.js-item[data-year="${year}"][data-day="${day}"]`;
            currentGalleryImages = Array.from(document.querySelectorAll(yearDaySelector));
            
            // Find index of current image
            currentImageIndex = currentGalleryImages.findIndex(item => item === figureElement);
            
            // Show modal with image
            window.openModal(imageUrl, caption, category, true);
          } else {
            // Fallback if figure not found
            window.openModal(imageUrl, caption, category);
          }
        }
      });
    }
  });
  
  // Set up navigation buttons
  const prevButton = document.getElementById('prev-button');
  if (prevButton) {
    prevButton.addEventListener('click', (e) => {
      e.stopPropagation();
      navigatePrev();
    });
  }
  
  const nextButton = document.getElementById('next-button');
  if (nextButton) {
    nextButton.addEventListener('click', (e) => {
      e.stopPropagation();
      navigateNext();
    });
  }
  
  // Add keyboard navigation
  document.addEventListener('keydown', (event) => {
    // Only handle keyboard events when modal is open
    const modalToggle = document.getElementById('gallery-modal-toggle');
    if (!modalToggle || !modalToggle.checked) return;
    
    switch (event.key) {
      case 'Escape':
        window.closeModal();
        break;
      case 'ArrowLeft':
        navigatePrev();
        break;
      case 'ArrowRight':
        navigateNext();
        break;
    }
  });
};