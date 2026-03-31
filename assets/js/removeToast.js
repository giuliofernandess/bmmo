setTimeout(() => {
  const toasts = document.querySelectorAll('.app-toast-container');

  toasts.forEach((toast) => {
    toast.classList.add('app-toast-closing');

    setTimeout(() => {
      toast.remove();
    }, 220);
  });
}, 5000);