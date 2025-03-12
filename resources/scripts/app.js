import domReady from './utils/domReady';
import { setupScrollToTop } from './components/scrollToTop';
import { setupThemeToggle } from './components/themeToggle';
import { setupPasswordToggle } from './components/passwordToggle';
import { setupProfileForm } from './forms/profileForm';
import { setupLoginForm } from './forms/loginForm';
import { setupModal } from './utils/modal';
import { setupFormHandlers } from './handlers/handlers';
import Alpine from 'alpinejs';
// Import only the specific lodash functions we need
import { debounce } from 'lodash';

// Replace global lodash with just the functions we need
window._ = { debounce };
window.Alpine = Alpine;

domReady(async () => {
  // Load core functionality immediately
  setupScrollToTop();
  setupThemeToggle();
  setupPasswordToggle();
  setupProfileForm();
  setupLoginForm();
  setupModal('successModal', 'closeModal');
  setupFormHandlers();
  Alpine.start();
  
  // Lazy load components that might not be needed immediately
  Promise.all([
    // Load video component if ANY video element exists
    (document.querySelector('#background-video') || document.querySelector('#event-video')) ? 
      import('./components/videoBackground').then(({ setupVideoBackground }) => setupVideoBackground()) :
      Promise.resolve(),
    // Only load gallery components if gallery exists on the page
    document.querySelector('.gallery-year') ? 
      import('./components/gallery').then(({ setupGallery, setupGalleryModal }) => {
        setupGallery();
        setupGalleryModal();
      }) : 
      Promise.resolve()
  ]).catch(err => console.error('Component loading error:', err));
});