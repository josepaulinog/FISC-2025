export const ajaxObject = window.ajaxObject || {
  ajax_url: '/wp-admin/admin-ajax.php',
  update_profile_nonce: '',
  update_settings_nonce: '',
  update_roles_nonce: '',
  load_more_search_results_nonce: '',
  update_user_theme_nonce: '',
  upload_files_nonce: '', // Add the missing nonce for file uploads
};

export async function performAjaxRequest(action, formData) {
  const nonceName = {
    'update_user_profile': 'update_profile_nonce',
    'update_user_settings': 'update_settings_nonce',
    'update_user_roles': 'update_roles_nonce',
    'update_user_theme': 'update_user_theme_nonce',
    'load_more_search_results': 'load_more_search_results_nonce',
    'upload_files': 'upload_files_nonce',  // Add nonce for upload files action
  }[action];

  console.log(
    'Performing AJAX request for action:',
    action,
    'with nonce:',
    ajaxObject[nonceName]
  );
  formData.append('action', action);
  formData.append('_ajax_nonce', ajaxObject[nonceName]);  // Attach the correct nonce

  try {
    const response = await fetch(ajaxObject.ajax_url, {
      method: 'POST',
      body: formData,
      credentials: 'same-origin',
    });
    console.log(`AJAX request for ${action} successful`);
    return await response.json();
  } catch (error) {
    console.error(`Error in ${action}:`, error);
    throw error;
  }
}

// Add file upload function
export async function uploadFile(file) {
  const formData = new FormData();
  formData.append('file', file);
  return performAjaxRequest('upload_files', formData); 
}

export async function updateUserProfile(formData) {
  return performAjaxRequest('update_user_profile', formData);
}

export async function updateUserSettings(formData) {
  return performAjaxRequest('update_user_settings', formData);
}

export async function updateUserRoles(formData) {
  return performAjaxRequest('update_user_roles', formData);
}

export async function updateUserTheme(theme) {
  const formData = new FormData();
  formData.append('theme', theme);
  return performAjaxRequest('update_user_theme', formData);
}

export async function loadMoreSearchResults(page) {
  const formData = new FormData();
  formData.append('paged', page);
  return performAjaxRequest('load_more_search_results', formData);
}
