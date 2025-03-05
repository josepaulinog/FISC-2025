export const showLoader = () => {
    const loaderOverlay = document.getElementById('loader-overlay');
    if (loaderOverlay) {
      loaderOverlay.classList.remove('hidden');
    }
  };
  
  export const hideLoader = () => {
    const loaderOverlay = document.getElementById('loader-overlay');
    if (loaderOverlay) {
      loaderOverlay.classList.add('hidden');
    }
  };