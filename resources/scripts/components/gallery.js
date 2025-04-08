// components/gallery.js
import Shuffle from 'shufflejs';
import { debounce } from 'lodash';
import lozad from 'lozad';

// Initialize lazy loading with lozad
const initLazyLoad = () => {
  // Initialize lozad observer
  const observer = lozad('.lazy', {
    loaded: function(el) {
      // Add loaded class for fade-in effect
      el.classList.add('loaded');
    },
    rootMargin: '10px 0px', // Preload images slightly before they appear in viewport
    threshold: 0.1 // Trigger load when 10% of the image is visible
  });
  
  // Start observing
  observer.observe();
  
  return observer;
};

// Pagination configuration
const ITEMS_PER_PAGE = 100; // Set to 30 photos max per page
let shuffleInstances = {};
let currentFilters = {};
let currentSearch = {};
let currentPage = {};
let totalPages = {};

// Modal implementation for DaisyUI modal with checkbox toggle
// Modal implementation for DaisyUI modal with checkbox toggle
window.openModal = (imageUrl, caption, category, resetGallery = true) => {
  // For DaisyUI modal with checkbox toggle
  const modalToggle = document.getElementById('gallery-modal-toggle');
  if (!modalToggle) return;
  
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
    // Important: Clear the src immediately to prevent showing old image
    modalImage.src = '';
    
    // Make sure the image is initially hidden
    modalImage.classList.add('opacity-0');
    
    // Show skeleton in modal while loading
    const modalSkeleton = document.getElementById('modal-skeleton');
    if (modalSkeleton) {
      modalSkeleton.classList.remove('hidden');
    }
    
    // Preload image to get dimensions before setting the src
    const img = new Image();
    
    // When image is fully loaded, update the modal image
    img.onload = function() {
      // Set the modal image src to the loaded image
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
    
    // Handle errors in image loading
    img.onerror = function() {
      console.error('Failed to load image:', imageUrl);
      
      // Hide skeleton
      if (modalSkeleton) {
        modalSkeleton.classList.add('hidden');
      }
      
      // Display error message
      const modalTitle = document.getElementById('modal-title');
      if (modalTitle) modalTitle.textContent = 'Error loading image';
    };
    
    // Start loading the image
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

// Apply CSS based pagination (showing/hiding items)
const applyPagination = (year, day, page) => {
  // Get all items for this day (filtered and unfiltered)
  const allItems = document.querySelectorAll(`#grid-${year} .js-item[data-day="${day}"]`);
  
  // Get only the items that aren't filtered out by category/search
  const visibleItems = Array.from(allItems).filter(item => 
    !item.classList.contains('shuffle-filtered')
  );
  
  // Calculate total pages
  const totalItems = visibleItems.length;
  const totalPagesCount = Math.ceil(totalItems / ITEMS_PER_PAGE);
  
  // Validate current page
  const currentPageNum = Math.min(Math.max(1, page), totalPagesCount || 1);
  
  // Calculate start and end indices
  const startIndex = (currentPageNum - 1) * ITEMS_PER_PAGE;
  const endIndex = Math.min(startIndex + ITEMS_PER_PAGE - 1, totalItems - 1);
  
  // Apply pagination by adding/removing the CSS class
  visibleItems.forEach((item, index) => {
    if (index >= startIndex && index <= endIndex) {
      item.classList.remove('hidden-by-pagination');
    } else {
      item.classList.add('hidden-by-pagination');
    }
  });
  
  // Update shuffle layout
  if (shuffleInstances[year]) {
    shuffleInstances[year].update();
  }
  
  return { totalPages: totalPagesCount, currentPage: currentPageNum };
};

// Go to specific page in pagination
const goToPage = (year, day, page) => {
  // Update pagination state
  if (!currentPage[year]) {
    currentPage[year] = {};
  }
  
  // Apply pagination and get updated state
  const paginationState = applyPagination(year, day, page);
  currentPage[year][day] = paginationState.currentPage;
  
  if (!totalPages[year]) {
    totalPages[year] = {};
  }
  totalPages[year][day] = paginationState.totalPages;
  
  // Update pagination UI
  updatePaginationUI(year, day);
  
  // Scroll to top of the gallery section
  document.querySelector(`#year-${year}`).scrollIntoView({ behavior: 'smooth', block: 'start' });
  
  // Trigger lazy loading for newly visible images
  setTimeout(() => {
    window.dispatchEvent(new Event('scroll'));
  }, 300);
};

// Update the pagination buttons based on current state
const updatePaginationUI = (year, day) => {
  const paginationContainer = document.getElementById(`pagination-${year}-day-${day}`);
  if (!paginationContainer) return;
  
  const pageNumbersContainer = paginationContainer.querySelector('.page-numbers');
  if (!pageNumbersContainer) return;
  
  // Ensure pagination state is initialized
  if (!currentPage[year]) currentPage[year] = {};
  if (!currentPage[year][day]) currentPage[year][day] = 1;
  if (!totalPages[year]) totalPages[year] = {};
  if (!totalPages[year][day]) {
    // Recalculate total pages
    const visibleItems = Array.from(document.querySelectorAll(`#grid-${year} .js-item[data-day="${day}"]`))
      .filter(item => !item.classList.contains('shuffle-filtered'));
    totalPages[year][day] = Math.ceil(visibleItems.length / ITEMS_PER_PAGE) || 1;
  }
  
  const currentPageNum = currentPage[year][day];
  const totalPagesNum = totalPages[year][day];
  
  // Show/hide pagination if necessary
  if (totalPagesNum > 1) {
    paginationContainer.classList.remove('hidden');
  } else {
    paginationContainer.classList.add('hidden');
    return;
  }
  
  // Clear existing page numbers
  pageNumbersContainer.innerHTML = '';
  
  // Determine range of page numbers to show
  let startPage = Math.max(1, currentPageNum - 2);
  let endPage = Math.min(totalPagesNum, startPage + 4);
  
  // Adjust if we're at the end
  if (endPage - startPage < 4) {
    startPage = Math.max(1, endPage - 4);
  }
  
  // Add page buttons
  if (startPage > 1) {
    // Add first page and ellipsis
    const firstPageBtn = document.createElement('button');
    firstPageBtn.className = 'btn btn-sm';
    firstPageBtn.textContent = '1';
    firstPageBtn.addEventListener('click', () => {
      goToPage(year, day, 1);
    });
    pageNumbersContainer.appendChild(firstPageBtn);
    
    if (startPage > 2) {
      const ellipsis = document.createElement('span');
      ellipsis.className = 'px-2';
      ellipsis.textContent = '...';
      pageNumbersContainer.appendChild(ellipsis);
    }
  }
  
  for (let i = startPage; i <= endPage; i++) {
    const pageBtn = document.createElement('button');
    pageBtn.className = `btn btn-sm ${i === currentPageNum ? 'active' : ''}`;
    pageBtn.textContent = i;
    pageBtn.addEventListener('click', () => {
      goToPage(year, day, i);
    });
    pageNumbersContainer.appendChild(pageBtn);
  }
  
  if (endPage < totalPagesNum) {
    // Add ellipsis and last page
    if (endPage < totalPagesNum - 1) {
      const ellipsis = document.createElement('span');
      ellipsis.className = 'px-2';
      ellipsis.textContent = '...';
      pageNumbersContainer.appendChild(ellipsis);
    }
    
    const lastPageBtn = document.createElement('button');
    lastPageBtn.className = 'btn btn-sm';
    lastPageBtn.textContent = totalPagesNum;
    lastPageBtn.addEventListener('click', () => {
      goToPage(year, day, totalPagesNum);
    });
    pageNumbersContainer.appendChild(lastPageBtn);
  }
  
  // Update prev/next buttons
  const prevBtn = paginationContainer.querySelector('.prev-page');
  const nextBtn = paginationContainer.querySelector('.next-page');
  
  if (prevBtn) {
    prevBtn.disabled = currentPageNum <= 1;
    // Remove existing event listeners
    const newPrevBtn = prevBtn.cloneNode(true);
    prevBtn.parentNode.replaceChild(newPrevBtn, prevBtn);
    newPrevBtn.addEventListener('click', () => {
      if (currentPageNum > 1) {
        goToPage(year, day, currentPageNum - 1);
      }
    });
  }
  
  if (nextBtn) {
    nextBtn.disabled = currentPageNum >= totalPagesNum;
    // Remove existing event listeners
    const newNextBtn = nextBtn.cloneNode(true);
    nextBtn.parentNode.replaceChild(newNextBtn, nextBtn);
    newNextBtn.addEventListener('click', () => {
      if (currentPageNum < totalPagesNum) {
        goToPage(year, day, currentPageNum + 1);
      }
    });
  }
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

// Apply combined filters (day, category, and search) and pagination
const applyFilters = (year) => {
  const activeDayElem = document.querySelector(`.day-tab.tab-active[data-year="${year}"]`);
  if (!activeDayElem) return;
  
  const activeDay = activeDayElem.dataset.day;
  const filterValue = currentFilters[year] || 'all';
  const searchValue = (currentSearch[year] || '').toLowerCase();

  if (shuffleInstances[year]) {
    // First remove pagination classes to let Shuffle see all items
    document.querySelectorAll(`#grid-${year} .js-item`).forEach(item => {
      item.classList.remove('hidden-by-pagination');
    });
    
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
    
    // Reset pagination to page 1 for active day
    if (!currentPage[year]) {
      currentPage[year] = {};
    }
    currentPage[year][activeDay] = 1;
    
    // Update day caption
    updateDayCaptions(year, activeDay);
    
    // Hide all day paginations first
    document.querySelectorAll(`[id^="pagination-${year}-day-"]`).forEach(pagination => {
      pagination.classList.add('hidden');
    });
    
    // Apply pagination for current day
    goToPage(year, activeDay, 1);
  }
};

export const setupGallery = () => {
  const years = document.querySelectorAll('.gallery-year');
  shuffleInstances = {};
  currentFilters = {};
  currentSearch = {};
  currentPage = {};
  totalPages = {};
  
  // Add CSS for pagination
  const style = document.createElement('style');
  style.textContent = `
    .hidden-by-pagination {
      display: none !important;
    }
  `;
  document.head.appendChild(style);
  
  // Initialize lazy loading
  const lazyLoadObserver = initLazyLoad();

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
            
            // Apply filters and pagination for the selected year
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
      
      // Apply filters and pagination for the new day
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
          // Apply initial filters and pagination
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
      
      // Skip if this image is hidden by pagination
      if (figureElement.classList.contains('hidden-by-pagination')) {
        return;
      }
      
      // Extract data from the figure element attributes
      const imageUrl = figureElement.dataset.fullImage;
      const caption = figureElement.dataset.caption;
      const category = figureElement.dataset.category;
      
      // Get all images in the same group (year and day) that are visible
      const year = figureElement.dataset.year;
      const day = figureElement.dataset.day;
      
      const selector = `figure.js-item[data-year="${year}"][data-day="${day}"]:not(.shuffle-filtered):not(.hidden-by-pagination)`;
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