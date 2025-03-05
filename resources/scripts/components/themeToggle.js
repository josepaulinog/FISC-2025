// components/themeToggle.js
import { updateUserTheme } from '../api/ajax';

export const setupThemeToggle = () => {
  const themeToggle = document.querySelector('.theme-controller');
  if (!themeToggle) return;

  const setTheme = async (isDark) => {
    document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
    document.body.classList.toggle('dark', isDark);
    themeToggle.checked = isDark;

    try {
      await updateUserTheme(isDark ? 'dark' : 'light');
    } catch (error) {
      console.error('Failed to update user theme:', error);
    }
  };

  // Initialize theme based on server-side user preference
  const userTheme = window.ajaxObject?.user_theme || 'light';
  setTheme(userTheme === 'dark');

  // Update theme when the toggle is changed
  themeToggle.addEventListener('change', (e) => {
    setTheme(e.target.checked);
  });
};