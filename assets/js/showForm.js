function showForm() {
  const formCard = document.querySelector("#presentationForm");  
  const icon = document.querySelector("#addIcon");
  
  if (formCard.style.display == "none") {
    formCard.style.display = "block";
    icon.classList = "bi bi-x-square-fill fs-3 text-primary cursor-pointer";
  } else {
    formCard.style.display = "none";
    icon.classList = "bi bi-plus-square-fill fs-3 text-primary cursor-pointer";
  }
}