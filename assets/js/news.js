function showForm() {
  const formCard = document.querySelector("#newsForm");
  const icon = document.querySelector("#addIcon");

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
  const form = document.querySelector("#newsFormElement");
  form.action = "validateCreateNews.php";
  document.querySelector("#formTitle").textContent = "Criar Notícia";
  document.querySelector("#news-title").value = "";
  document.querySelector("#news-subtitle").value = "";
  document.querySelector("#news-description").value = "";
  document.querySelector("#input-file").value = "";
  document.querySelector("#newsSubmit").value = "Publicar Notícia";

  const existingId = document.querySelector("input[name='id']");
  if (existingId) existingId.remove();
  const imageHint = document.querySelector("#imageHint");
  if (imageHint) imageHint.textContent = "";
}

function editNews(btn) {
  const formCard = document.querySelector("#newsForm");
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

  const form = document.querySelector("#newsFormElement");

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

  const imageHint = document.querySelector("#imageHint");
  imageHint.textContent = image ? `Imagem atual: ${image}` : "Sem imagem atual";

  form.action = "validateEditNews.php";
  document.querySelector("#formTitle").textContent = "Editar Notícia";
  document.querySelector("#newsSubmit").value = "Editar Notícia";
}

function editCancel() {
  resetNewsForm();
}

