function showForm() {
  const formCard = document.querySelector("#news-form-container");
  const icon = document.querySelector("#form-toggle-icon");

  if (!formCard || !icon) {
    return;
  }

  const isOpen = icon.classList.contains("is-open");

  icon.classList.toggle("is-open", !isOpen);
  icon.className = !isOpen
    ? "bi bi-x-square-fill fs-3 text-primary cursor-pointer is-open"
    : "bi bi-plus-square-fill fs-3 text-primary cursor-pointer";

  if (!isOpen) {
    formCard.classList.remove("is-hidden");
  } else {
    formCard.classList.add("is-hidden");
    resetNewsForm();
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const toggleIcon = document.querySelector('#form-toggle-icon');
  if (toggleIcon) {
    toggleIcon.addEventListener('click', showForm);
  }

  document.querySelectorAll('.news-delete-form').forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!confirmAction('Tem certeza que deseja excluir esta notícia?')) {
        event.preventDefault();
      }
    });
  });

  document.querySelectorAll('.news-edit-button').forEach((button) => {
    button.addEventListener('click', () => editNews(button));
  });
});

function resetNewsForm() {
  const form = document.querySelector("#news-form-element");
  form.action = `${window.BASE_URL}pages/admin/news/actions/create.php`;
  document.querySelector("#news-form-title").textContent = "Criar Notícia";
  document.querySelector("#news-title").value = "";
  document.querySelector("#news-subtitle").value = "";
  document.querySelector("#news-description").value = "";
  document.querySelector("#news-image").value = "";
  document.querySelector("#submit-news-button").value = "Publicar Notícia";

  const existingId = document.querySelector("input[name='news_id']");
  if (existingId) existingId.remove();
  const imageHint = document.querySelector("#image-hint");
  if (imageHint) imageHint.textContent = "";
}

function editNews(btn) {
  const formCard = document.querySelector("#news-form-container");
  if (!formCard.classList.contains("is-hidden")) {
    alert("[ERRO] Não é possível editar enquanto o formulário está aberto em modo de criação.");
    return;
  }

  showForm();

  const card = btn.closest(".news-card-item");
  const newsId = Number(card.dataset.newsId);
  const title = card.dataset.newsTitle;
  const subtitle = card.dataset.newsSubtitle;
  const description = card.dataset.newsDescription;
  const image = card.dataset.newsImage;

  const form = document.querySelector("#news-form-element");

  // Remove input hidden anterior se existir
  const existingId = document.querySelector("input[name='news_id']");
  if (existingId) existingId.remove();

  // Criar novo input hidden
  const newIdInput = document.createElement("input");
  newIdInput.type = "hidden";
  newIdInput.name = "news_id";
  newIdInput.value = newsId;
  form.appendChild(newIdInput);

  document.querySelector("#news-title").value = title;
  document.querySelector("#news-subtitle").value = subtitle;
  document.querySelector("#news-description").value = description;

  const imageHint = document.querySelector("#image-hint");
  imageHint.textContent = image ? `Imagem atual: ${image}` : "Sem imagem atual";

  form.action = `${window.BASE_URL}pages/admin/news/actions/edit.php`;
  document.querySelector("#news-form-title").textContent = "Editar Notícia";
  document.querySelector("#submit-news-button").value = "Editar Notícia";
}

function editCancel() {
  resetNewsForm();
}

