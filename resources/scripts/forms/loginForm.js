import { showLoader } from '../utils/loader';

export const setupLoginForm = () => {
  const loginForm = document.querySelector('form[action*="wp-login.php"]');
  if (loginForm) {
    loginForm.addEventListener('submit', function () {
      showLoader();
    });
  }
};
