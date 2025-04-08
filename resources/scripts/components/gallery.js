// components/gallery.js
import Shuffle from 'shufflejs';
import { debounce } from 'lodash';
import lozad from 'lozad';

// Initialize lazy loading with lozad
const initLazyLoad = () => {
  // Initialize lozad observer
  const observer = lozad('.lazy', {
    loaded: function(el) {
      // When the image is loaded, we don't immediately add the class
      // Instead, use a small timeout to ensure the image is fully rendered
      // before starting the fade-in transition
      setTimeout(() => {
        // When image is loaded, hide the skeleton
        const imageContainer = el.closest('.image-container');
        if (imageContainer) {
          const skeleton = imageContainer.querySelector('.skeleton');
          if (skeleton) {
            skeleton.classList.add('hidden');
          }
        }
        
        // Now add the loaded class for fade-in effect
        el.classList.add('loaded');
      }, 50);
    },
    rootMargin: '10px 0px', // Preload images slightly before they appear in viewport
    threshold: 0.1 // Trigger load when 10% of the image is visible
  });
  
  // Start observing
  observer.observe();
  
  return observer;
};

let shuffleInstances = {};
let currentFilters = {};
let currentSearch = {};

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
    if (window.currentGalleryImages.length <= 1) {
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
    // Reset the image and make it invisible during loading
    modalImage.src = '';
    modalImage.classList.add('opacity-0');
    
    // Show skeleton in modal while loading
    const modalSkeleton = document.getElementById('modal-skeleton');
    if (modalSkeleton) {
      modalSkeleton.classList.remove('hidden');
    }
    
    // Preload image to get dimensions
    const img = new Image();
    img.onload = function() {
      // Update the src attribute
      modalImage.src = imageUrl;
      
      // Hide skeleton when image is loaded
      if (modalSkeleton) {
        modalSkeleton.classList.add('hidden');
      }
      
      // Add a small delay to ensure smooth transition
      setTimeout(() => {
        // Show the image with fade-in effect
        modalImage.classList.remove('opacity-0');
      }, 50);
      
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

// Count images in specific category for a year/day
const countImagesInCategory = (year, day, category) => {
  const selector = category === 'all' 
    ? `#grid-${year} .js-item[data-day="${day}"]`
    : `#grid-${year} .js-item[data-day="${day}"][data-groups*="${category}"]`;
  
  return document.querySelectorAll(selector).length;
};

// Update category counts based on current active day
const updateCategoryCounts = (year) => {
  const activeDayElem = document.querySelector(`.day-tab.tab-active[data-year="${year}"]`);
  if (!activeDayElem) return;
  
  const activeDay = activeDayElem.dataset.day;
  
  // Update desktop filter tabs
  document.querySelectorAll(`.filter-tab[data-year="${year}"]`).forEach(tab => {
    const category = tab.dataset.filter;
    const count = countImagesInCategory(year, activeDay, category);
    
    // Update count in tab
    const countSpan = tab.querySelector('span');
    if (countSpan) {
      countSpan.textContent = `(${count})`;
    }
    
    // Hide categories with no images
    if (count === 0 && category !== 'all') {
      tab.classList.add('hidden');
    } else {
      tab.classList.remove('hidden');
    }
  });
  
  // Update mobile dropdown
  const mobileFilter = document.getElementById(`mobile-filter-${year}`);
  if (mobileFilter) {
    Array.from(mobileFilter.options).forEach(option => {
      const category = option.value;
      const count = countImagesInCategory(year, activeDay, category);
      
      // Update option text with count
      option.textContent = `${category === 'all' ? 'All Categories' : category.charAt(0).toUpperCase() + category.slice(1)} (${count})`;
      
      // Disable options with no images
      if (count === 0 && category !== 'all') {
        option.disabled = true;
      } else {
        option.disabled = false;
      }
    });
  }
};

// Update day caption visibility
const updateDayCaptions = (year, day) => {
  // Hide all captions
  document.querySelectorAll(`.day-caption[data-year="${year}"]`).forEach(caption => {
    caption.classList.add('hidden');
  });
  
  // Show the active day caption
  const activeCaption = document.querySelector(`.day-caption[data-year="${year}"][data-day="${day}"]`);
  if (activeCaption) {
    activeCaption.classList.remove('hidden');
  }
  
  // Also update any counts in the day tabs
  document.querySelectorAll(`.day-tab[data-year="${year}"]`).forEach(tab => {
    const tabDay = tab.dataset.day;
    const countSpan = tab.querySelector('span');
    if (countSpan) {
      const selector = `#grid-${year} .js-item[data-day="${tabDay}"]:not(.shuffle-filtered)`;
      const count = document.querySelectorAll(selector).length;
      countSpan.textContent = `(${count})`;
    }
  });
};

// Apply combined filters (day, category, and search)
const applyFilters = (year) => {
  const activeDayElem = document.querySelector(`.day-tab.tab-active[data-year="${year}"]`);
  if (!activeDayElem) return;
  
  const activeDay = activeDayElem.dataset.day;
  const filterValue = currentFilters[year] || 'all';
  const searchValue = (currentSearch[year] || '').toLowerCase();

  if (shuffleInstances[year]) {
    // Apply category and search filters
    shuffleInstances[year].filter(item => {
      // Check day filter
      if (item.dataset.day !== activeDay) return false;
      
      // Check category filter
      if (filterValue !== 'all') {
        try {
          const groups = JSON.parse(item.dataset.groups);
          if (!groups.includes(filterValue)) return false;
        } catch (e) {
          console.error('Error parsing groups:', e);
          return false;
        }
      }
      
      // Check search filter
      if (searchValue) {
        const captionElem = item.querySelector('.font-medium');
        if (captionElem) {
          const captionText = captionElem.textContent.toLowerCase();
          if (!captionText.includes(searchValue)) return false;
        } else {
          return false;
        }
      }
      
      return true;
    });
    
    // Update shuffle layout after filtering
    shuffleInstances[year].update();
    
    // Update category counts after filtering
    updateCategoryCounts(year);
    
    // Update day caption
    updateDayCaptions(year, activeDay);
  }
};

export const setupGallery = () => {
  const years = document.querySelectorAll('.gallery-year');
  shuffleInstances = {};
  currentFilters = {};
  currentSearch = {};
  
  // Initialize lazy loading for all gallery images
  const lazyLoadObserver = initLazyLoad();

  // Initialize lazy loading for modal image
  const modalImage = document.getElementById('modal-image');
  if (modalImage) {
    modalImage.classList.add('lazy');
    lazyLoadObserver.observe();
  }

  // Initialize shuffle for each year
  years.forEach(yearEl => {
    const year = yearEl.dataset.year;
    const container = yearEl.querySelector(`#grid-${year}`);
    currentFilters[year] = 'all';
    currentSearch[year] = '';
    
    if (container) {
      shuffleInstances[year] = new Shuffle(container, {
        itemSelector: '.js-item',
        gutterWidth: 0,
        buffer: 0,
        roundTransforms: false,
        delimiter: ',',
        throttleTime: 300,
        filterMode: Shuffle.FilterMode.ALL,
      });

      // Add event handler for when shuffle layout completes
      shuffleInstances[year].on(Shuffle.EventType.LAYOUT, () => {
        // Update lazy loading for newly visible images
        lazyLoadObserver.observe();
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
        
        requestAnimationFrame(() => {
          if (shuffleInstances[selectedYear]) {
            shuffleInstances[selectedYear].update();
            
            // Apply filters for the selected year
            applyFilters(selectedYear);
            
            // Trigger lazy loading
            lazyLoadObserver.observe();
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
      const day = tab.dataset.day;
      
      // Update tab active state
      const siblingTabs = tab.parentElement.querySelectorAll('.day-tab');
      siblingTabs.forEach(sibTab => sibTab.classList.remove('tab-active'));
      tab.classList.add('tab-active');
      
      // Apply filters for the new day
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
      
      // Update tab active state
      const siblingTabs = tab.parentElement.querySelectorAll('.filter-tab');
      siblingTabs.forEach(sibling => sibling.classList.remove('tab-active'));
      tab.classList.add('tab-active');
      
      // Apply filters with the new category
      applyFilters(year);
    });
  });

  // Mobile filter dropdown handler
  const mobileFilters = document.querySelectorAll('[id^="mobile-filter-"]');
  mobileFilters.forEach(filter => {
    filter.addEventListener('change', () => {
      const year = filter.dataset.year;
      const filterValue = filter.value;
      currentFilters[year] = filterValue;
      
      // Update desktop tabs to match (for consistency)
      document.querySelectorAll(`.filter-tab[data-year="${year}"]`).forEach(tab => {
        if (tab.dataset.filter === filterValue) {
          tab.classList.add('tab-active');
        } else {
          tab.classList.remove('tab-active');
        }
      });
      
      // Apply filters with the new category
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

  // Show first year by default and initialize
  if (years.length > 0) {
    const firstYear = years[0];
    firstYear.style.display = 'block';
    const year = firstYear.dataset.year;
    
    // Use intersection observer to initialize when visible
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && shuffleInstances[year]) {
          // Apply initial filters
          applyFilters(year);
          observer.disconnect();
        }
      });
    }, { threshold: 0.1 });
    
    observer.observe(firstYear);
  }

  // Handle window resize with proper debouncing
  const handleResize = debounce(() => {
    Object.keys(shuffleInstances).forEach(year => {
      shuffleInstances[year].update();
    });
  }, 100);
  
  window.addEventListener('resize', handleResize);
};

// Track current gallery state
window.currentGalleryImages = [];
window.currentImageIndex = 0;

// Navigate to the previous image in the gallery
function navigatePrev() {
  if (!window.currentGalleryImages || window.currentGalleryImages.length <= 1) return;
  
  window.currentImageIndex = (window.currentImageIndex - 1 + window.currentGalleryImages.length) % window.currentGalleryImages.length;
  const prevImage = window.currentGalleryImages[window.currentImageIndex];
  
  if (prevImage) {
    window.openModal(
      prevImage.dataset.fullImage,
      prevImage.dataset.caption,
      prevImage.dataset.category,
      false // Don't reset the gallery
    );
  }
}

// Navigate to the next image in the gallery
function navigateNext() {
  if (!window.currentGalleryImages || window.currentGalleryImages.length <= 1) return;
  
  window.currentImageIndex = (window.currentImageIndex + 1) % window.currentGalleryImages.length;
  const nextImage = window.currentGalleryImages[window.currentImageIndex];
  
  if (nextImage) {
    window.openModal(
      nextImage.dataset.fullImage,
      nextImage.dataset.caption,
      nextImage.dataset.category,
      false // Don't reset the gallery
    );
  }
}

export const setupGalleryModal = () => {
  // Setup using event delegation for better performance
  document.addEventListener('click', function(e) {
    // Handle gallery image clicks
    const trigger = e.target.closest('.gallery-image-trigger');
    if (trigger) {
      e.preventDefault();
      e.stopPropagation();
      
      // Get parent figure element which contains the data attributes
      const figureElement = trigger.closest('figure.js-item');
      if (!figureElement) return;
      
      // Extract data from the figure element attributes
      const imageUrl = figureElement.dataset.fullImage;
      const caption = figureElement.dataset.caption;
      const category = figureElement.dataset.category;
      
      // Get all images in the same group (year and day) that are visible
      const year = figureElement.dataset.year;
      const day = figureElement.dataset.day;
      
      const selector = `figure.js-item[data-year="${year}"][data-day="${day}"]:not(.shuffle-filtered)`;
      window.currentGalleryImages = Array.from(document.querySelectorAll(selector));
      
      // Find index of current image
      window.currentImageIndex = window.currentGalleryImages.indexOf(figureElement);
      
      // Open modal with the image
      window.openModal(imageUrl, caption, category);
    }
    
    // Handle prev button click
    if (e.target.closest('#prev-button')) {
      e.stopPropagation();
      navigatePrev();
    }
    
    // Handle next button click
    if (e.target.closest('#next-button')) {
      e.stopPropagation();
      navigateNext();
    }
  });
  
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