// components/passwordToggle.js
export const setupPasswordToggle = () => {
    const togglePasswordBtn = document.getElementById('toggle-password-btn');
    const passwordInput = document.getElementById('toggle-password');
    const showIcon = document.getElementById('show-password-icon');
    const hideIcon = document.getElementById('hide-password-icon');
  
    if (!togglePasswordBtn || !passwordInput || !showIcon || !hideIcon) return;
  
    togglePasswordBtn.addEventListener('click', () => {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showIcon.classList.add('hidden');
        hideIcon.classList.remove('hidden');
      } else {
        passwordInput.type = 'password';
        hideIcon.classList.add('hidden');
        showIcon.classList.remove('hidden');
      }
    });
  };