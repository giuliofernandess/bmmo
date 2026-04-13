let selectedSongs = [];

const form = document.querySelector("#presentation-form-element");
const selectedSongsContainer = document.querySelector(".selected-songs");
const formCard = document.querySelector("#presentation-form");

function showForm() {
  const icon = document.querySelector("#presentation-form-toggle-icon");
  const isOpen = formCard.classList.contains("is-open");

  if (!isOpen) {
    formCard.classList.remove("is-hidden");
    formCard.classList.add("is-open");
    icon.className = "bi bi-x-square-fill fs-3 text-primary cursor-pointer";
  } else {
    formCard.classList.remove("is-open");
    formCard.classList.add("is-hidden");
    icon.className = "bi bi-plus-square-fill fs-3 text-primary cursor-pointer";
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const toggleIcon = document.querySelector('#presentation-form-toggle-icon');
  const addSongButton = document.querySelector('#presentation-add-song-button');

  if (toggleIcon) {
    toggleIcon.addEventListener('click', showForm);
  }

  if (addSongButton) {
    addSongButton.addEventListener('click', addSong);
  }

  document.querySelectorAll('.presentation-delete-form').forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!confirmAction('Tem certeza que deseja excluir esta apresentação?')) {
        event.preventDefault();
      }
    });
  });

  document.querySelectorAll('.presentation-edit-button').forEach((button) => {
    button.addEventListener('click', (event) => {
      event.preventDefault();
      editPresentation(button);
    });
  });
});

function addSong() {
  const select = document.querySelector("#presentation-songs");

  const selectedId = select.value;
  const selectedName = select.options[select.selectedIndex].text;

  if (!selectedId) {
    alert("[ERRO] Selecione uma música válida!");
    return;
  }

  if (selectedSongs.some((song) => song.id === selectedId)) {
    alert("[ERRO] Música já adicionada!");
    return;
  }

  selectedSongs.push({
    id: selectedId,
    name: selectedName,
  });

  showSongs();
  addInput();

  select.value = "";
}

function showSongs() {
  selectedSongsContainer.innerHTML = "";

  selectedSongs.forEach((song) => {
    const p = document.createElement("p");

    const span = document.createElement("span");
    span.textContent = song.name + " ";

    const trash = document.createElement("i");
    trash.className = "bi bi-trash text-danger cursor-pointer";
    trash.role = "button";

    trash.addEventListener("click", () => {
      selectedSongs = selectedSongs.filter((s) => s.id !== song.id);
      showSongs();
      addInput();
    });

    p.appendChild(span);
    p.appendChild(trash);

    selectedSongsContainer.appendChild(p);
  });
}

function addInput() {
  document.querySelectorAll(".song-hidden").forEach((el) => el.remove());

  selectedSongs.forEach((song) => {
    const input = document.createElement("input");

    input.type = "hidden";
    input.className = "song-hidden";
    input.name = "songs[]";
    input.value = song.id;

    form.appendChild(input);
  });
}

function editPresentation(btn) {
  if (formCard.classList.contains("is-open")) {
    alert(
      "[ERRO] Não é possível editar uma apresentação enquanto cria ou edita outra!",
    );
    return;
  }

  showForm();

  const info = btn.closest(".presentation-info");

  const existingPresentationId = document.querySelector(
    "input[name='presentation_id']",
  );

  if (existingPresentationId) {
    existingPresentationId.remove();
  }

  const idInput = document.createElement("input");
  idInput.type = "hidden";
  idInput.name = "presentation_id";
  idInput.value = info.dataset.presentationId;

  form.appendChild(idInput);

  document.querySelector("#presentation-name").value = info.dataset.presentationName;
  document.querySelector("#presentation-date").value = info.dataset.presentationDate;
  document.querySelector("#presentation-hour").value = info.dataset.presentationHour;
  document.querySelector("#presentation-location").value = info.dataset.presentationLocation;
  const bandGroups = JSON.parse(info.dataset.presentationGroups);
  const checkboxes = document.querySelectorAll('input[name="groups[]"]');

  checkboxes.forEach((cb) => {
    cb.checked = bandGroups.includes(Number(cb.value));
  });

  selectedSongs = [];

  const songs = JSON.parse(info.dataset.presentationSongs);

  const select = document.querySelector("#presentation-songs");

  songs.forEach((songId) => {
    for (let option of select.options) {
      if (option.value == songId) {
        selectedSongs.push({
          id: option.value,
          name: option.text,
        });
      }
    }
  });

  showSongs();
  addInput();

  document.querySelector("#presentation-submit").value = "Editar apresentação";

  form.action = `${window.BASE_URL}pages/admin/presentations/actions/edit.php`;
}
