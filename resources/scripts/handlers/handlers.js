import { submitForm } from '../utils/formSubmit';

export const setupFormHandlers = () => {
  const forms = document.querySelectorAll('.form-with-loader');

  if (forms && forms.length) {
    forms.forEach((form) => {
      if (!form || !(form instanceof HTMLFormElement)) {
        return;
      }

      if (form.action && (form.action.includes('wp-login.php') || form.id === 'search-form' || form.id === 'filters-form')) {
        return;
      }

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        try {
          const formData = new FormData(form);
          await submitForm(form, formData);
        } catch (error) {
          console.error('Error submitting form:', error);
          const errorElement = form.querySelector('.error-message');
          if (errorElement) {
            errorElement.textContent = 'An error occurred while submitting the form. Please try again.';
          }
        }
      });
    });
  }
};