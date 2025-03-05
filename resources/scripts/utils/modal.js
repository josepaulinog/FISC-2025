import domReady from '../utils/domReady';

export const showModal = () => {
  const successModal = document.getElementById('successModal');
  if (successModal) {
    successModal.classList.add('modal-open');
  }
};

export const hideModal = () => {
  const successModal = document.getElementById('successModal');
  if (successModal) {
    successModal.classList.remove('modal-open');
  }
};

export const isModalOpen = () => {
  const successModal = document.getElementById('successModal');
  return successModal && successModal.classList.contains('modal-open');
};

export const setupModal = (modalId, closeButtonId) => {
  domReady(() => {
    const closeModalBtn = document.getElementById(closeButtonId);
    const modal = document.getElementById(modalId);

    if (closeModalBtn && modal) {
      closeModalBtn.addEventListener('click', function () {
        modal.classList.remove('modal-open');
      });
    }
  });
};
