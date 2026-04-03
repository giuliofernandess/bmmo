function showForm() {
  const formCard = document.querySelector("#musical-score-form-container");
  const icon = document.querySelector("#form-toggle-icon");

  if (!formCard || !icon) {
    return;
  }

  const isOpen = icon.classList.contains("is-open");

  icon.classList.toggle("is-open", !isOpen);
  icon.className = !isOpen
    ? "bi bi-x-square-fill fs-3 text-primary cursor-pointer is-open"
    : "bi bi-plus-square-fill fs-3 text-primary cursor-pointer";

  formCard.classList.toggle("is-hidden", isOpen);
}

document.addEventListener('DOMContentLoaded', () => {
  const toggleIcon = document.querySelector('#form-toggle-icon');

  if (toggleIcon) {
    toggleIcon.addEventListener('click', showForm);
  }
});