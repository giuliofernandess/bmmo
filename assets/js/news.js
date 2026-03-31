function showForm() {
  const formCard = document.querySelector("#news-form");
  const icon = document.querySelector("#add-icon");

  if (formCard.style.display === "none" || formCard.style.display === "") {
    formCard.style.display = "block";
    icon.className = "bi bi-x-square-fill fs-3 text-primary cursor-pointer";
  } else {
    formCard.style.display = "none";
    icon.className = "bi bi-plus-square-fill fs-3 text-primary cursor-pointer";
    resetNewsForm();
  }
}

function resetNewsForm() {
  const form = document.querySelector("#news-form-element");
  form.action = `${window.BASE_URL}pages/admin/news/actions/create.php`;
  document.querySelector("#form-title").textContent = "Criar Notícia";
  document.querySelector("#news-title").value = "";
  document.querySelector("#news-subtitle").value = "";
  document.querySelector("#news-description").value = "";
  document.querySelector("#input-file").value = "";
  document.querySelector("#news-submit").value = "Publicar Notícia";

  const existingId = document.querySelector("input[name='id']");
  if (existingId) existingId.remove();
  const imageHint = document.querySelector("#image-hint");
  if (imageHint) imageHint.textContent = "";
}

function editNews(btn) {
  const formCard = document.querySelector("#news-form");
  if (formCard.style.display === "block") {
    alert("[ERRO] Não é possível editar enquanto o formulário está aberto em modo de criação.");
    return;
  }

  showForm();

  const card = btn.closest(".news-card-item");
  const newsId = Number(card.dataset.id);
  const title = card.dataset.title;
  const subtitle = card.dataset.subtitle;
  const description = card.dataset.description;
  const image = card.dataset.image;

  const form = document.querySelector("#news-form-element");

  let existingId = document.querySelector("input[name='id']");
  if (!existingId) {
    existingId = document.createElement("input");
    existingId.type = "hidden";
    existingId.name = "id";
    form.appendChild(existingId);
  }
  existingId.value = newsId;

  document.querySelector("#news-title").value = title;
  document.querySelector("#news-subtitle").value = subtitle;
  document.querySelector("#news-description").value = description;

  const imageHint = document.querySelector("#image-hint");
  imageHint.textContent = image ? `Imagem atual: ${image}` : "Sem imagem atual";

  form.action = `${window.BASE_URL}pages/admin/news/actions/edit.php`;
  document.querySelector("#form-title").textContent = "Editar Notícia";
  document.querySelector("#news-submit").value = "Editar Notícia";
}

function editCancel() {
  resetNewsForm();
}

