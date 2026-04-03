setTimeout(() => {
  const toasts = document.querySelectorAll('.app-toast-container');

  toasts.forEach((toast) => {
    toast.classList.add('app-toast-closing');

    setTimeout(() => {
      toast.remove();
    }, 220);
  });
}, 5000);

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.app-toast-close').forEach((button) => {
    button.addEventListener('click', () => {
      const toast = button.closest('.app-toast-container');
      if (toast) {
        toast.remove();
      }
    });
  });
});