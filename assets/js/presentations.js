let selectedSongs = [];

const form = document.querySelector("form");
const res = document.querySelector(".res");
const formCard = document.querySelector("#presentationForm");

function showForm() {
  const icon = document.querySelector("#addIcon");

  if (formCard.style.display === "none" || formCard.style.display === "") {
    formCard.style.display = "block";
    icon.className = "bi bi-x-square-fill fs-3 text-primary cursor-pointer";
  } else {
    formCard.style.display = "none";
    icon.className = "bi bi-plus-square-fill fs-3 text-primary cursor-pointer";
  }
}

function addSong() {
  const select = document.querySelector("#isongs");

  const selectedId = select.value;
  const selectedName = select.options[select.selectedIndex].text;

  if (!selectedId) {
    alert("[ERRO] Selecione uma música válida!");
    return;
  }

  if (selectedSongs.some(song => song.id === selectedId)) {
    alert("[ERRO] Música já adicionada!");
    return;
  }

  selectedSongs.push({
    id: selectedId,
    name: selectedName
  });

  showSongs();
  addInput();

  select.value = "";
}

function showSongs() {
  res.innerHTML = "";

  selectedSongs.forEach((song) => {
    const p = document.createElement("p");

    const span = document.createElement("span");
    span.textContent = song.name + " ";

    const trash = document.createElement("i");
    trash.className = "bi bi-trash text-danger cursor-pointer";
    trash.role = "button";

    trash.addEventListener("click", () => {
      selectedSongs = selectedSongs.filter(s => s.id !== song.id);
      showSongs();
      addInput();
    });

    p.appendChild(span);
    p.appendChild(trash);

    res.appendChild(p);
  });
}

function addInput() {
  document.querySelectorAll(".song-hidden").forEach(el => el.remove());

  selectedSongs.forEach(song => {
    const input = document.createElement("input");

    input.type = "hidden";
    input.className = "song-hidden";
    input.name = "songs[]";
    input.value = song.id;

    form.appendChild(input);
  });
}

function editPresentation(btn) {

  if (formCard.style.display === "block") {
    alert("[ERRO] Não é possível editar uma tocata enquanto cria ou edita outra!");
    return;
  }

  showForm();

  const info = btn.closest(".presentation-info");

  const idInput = document.createElement("input");
  idInput.type = "hidden";
  idInput.name = "iid";
  idInput.value = info.dataset.id;

  form.appendChild(idInput);

  document.querySelector("#iname").value = info.dataset.name;
  document.querySelector("#idate").value = info.dataset.date;
  document.querySelector("#ihour").value = info.dataset.hour;
  document.querySelector("#ilocal").value = info.dataset.local;

  // grupos
  const bandGroups = info.dataset.group.split("-");
  const checkboxes = document.querySelectorAll('input[name="groups[]"]');

  checkboxes.forEach(cb => {
    cb.checked = bandGroups.includes(cb.value);
  });

  selectedSongs = [];

  const songs = info.dataset.songs.split("-");

  const select = document.querySelector("#isongs");

  songs.forEach(songName => {

    for (let option of select.options) {
      if (option.text === songName) {
        selectedSongs.push({
          id: option.value,
          name: option.text
        });
      }
    }

  });

  showSongs();
  addInput();

  document.querySelector("#ibutton").value = "Editar Tocata";

  form.action = "PresentationFunctions/validateEditPresentation.php";
}
