import domReady from '../utils/domReady';

export const setupProfileForm = () => {
  domReady(() => {
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
      profileForm.setAttribute('data-action', 'updateUserProfile'); // Set the form action attribute

      // File Input: Display selected file name
      const avatarInput = document.getElementById('avatar');
      const fileNameDisplay = document.getElementById('file-name'); // Element where file name will be shown
      const avatarPreview = document.getElementById('avatar-preview'); // Preview avatar element

      if (avatarInput && fileNameDisplay) {
        avatarInput.addEventListener('change', function () {
          const file = this.files[0];
          if (file) {
            // Display the file name
            fileNameDisplay.textContent = `Selected file: ${file.name}`;

            // Optionally preview the image if it's an image file
            const reader = new FileReader();
            reader.onload = function (e) {
              avatarPreview.src = e.target.result;
              // Optionally, update other avatars
              const headerAvatar = document.querySelector('.header-avatar');
              if (headerAvatar) {
                headerAvatar.src = e.target.result; // Update header avatar dynamically
              }
            };
            reader.readAsDataURL(file);
          } else {
            // Reset the text if no file is selected
            fileNameDisplay.textContent = 'No file selected';
          }
        });
      }
    }
  });
};
