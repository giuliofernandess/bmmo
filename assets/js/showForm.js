function showForm() {
  const formCard = document.querySelector("#presentation-form");  
  const icon = document.querySelector("#add-icon");
  
  if (formCard.style.display == "none") {
    formCard.style.display = "block";
    icon.classList = "bi bi-x-square-fill fs-3 text-primary cursor-pointer";
  } else {
    formCard.style.display = "none";
    icon.classList = "bi bi-plus-square-fill fs-3 text-primary cursor-pointer";
  }
}