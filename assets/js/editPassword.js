function showForm() {  
  const formCard = document.querySelector("#edit-password-form-container");
  const icon = document.querySelector("#profile-password-form-toggle-icon");

  if (!formCard || !icon) {
    return;
  }

  const isOpen = icon.classList.contains("is-open");

  icon.classList.toggle("is-open", !isOpen);
  icon.className = !isOpen
    ? "bi bi-caret-up-square-fill fs-3 text-primary cursor-pointer is-open"
    : "bi bi-caret-down-square-fill fs-3 text-primary cursor-pointer";

  formCard.classList.toggle("is-hidden", isOpen);
}

document.addEventListener('DOMContentLoaded', () => {
  const toggleIcon = document.querySelector('#profile-password-form-toggle-icon');

  if (toggleIcon) {
    toggleIcon.addEventListener('click', showForm);
  }
});