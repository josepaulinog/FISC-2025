// formSubmit.js
import { showLoader, hideLoader } from './loader';
import { showModal, isModalOpen } from './modal';
import { updateUserProfile, updateUserSettings, updateUserRoles } from '../api/ajax';

export const submitForm = async (form, formData) => {
  const action = form.getAttribute('data-action');

  // If the form doesn't have a custom action, allow default behavior
  if (!action) {
    return;
  }

  if (!isModalOpen()) {
    showLoader();
  }

  let response;
  try {
    switch (action) {
      case 'updateUserProfile':
        response = await updateUserProfile(formData);
        break;
      case 'updateUserSettings':
        response = await updateUserSettings(formData);
        break;
      case 'updateUserRoles':
        response = await updateUserRoles(formData);
        break;
      default:
        throw new Error('Invalid form action');
    }

    if (response.success && !isModalOpen()) {
      showModal();
    } else {
      // alert('Error: ' + (response.data || 'Unknown error'));
    }
  } catch (error) {
    console.error('Error during form submission:', error);
  } finally {
    hideLoader();
  }
};
