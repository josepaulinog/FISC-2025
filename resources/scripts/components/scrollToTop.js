// components/scrollToTop.js
import { debounce } from '../utils/debounce';

export const setupScrollToTop = () => {
  const scrollToTopBtn = document.getElementById('scroll-to-top');
  if (!scrollToTopBtn) return;

  const progressPath = scrollToTopBtn.querySelector('.progress-circle path');
  if (!progressPath) return;

  const pathLength = progressPath.getTotalLength();
  const offsetShow = 100;

  progressPath.style.strokeDasharray = `${pathLength} ${pathLength}`;
  progressPath.style.strokeDashoffset = pathLength;

  const updateProgress = () => {
    const scroll = window.scrollY;
    const height = document.documentElement.scrollHeight - window.innerHeight;
    const progress = pathLength - (scroll * pathLength) / height;
    progressPath.style.strokeDashoffset = progress;
  };

  const handleScroll = () => {
    if (window.scrollY > offsetShow) {
      scrollToTopBtn.classList.add('active');
      scrollToTopBtn.classList.remove('hidden');
    } else {
      scrollToTopBtn.classList.remove('active');
      scrollToTopBtn.classList.add('hidden');
    }
    updateProgress();
  };

  scrollToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  window.addEventListener('scroll', debounce(handleScroll, 10));
};