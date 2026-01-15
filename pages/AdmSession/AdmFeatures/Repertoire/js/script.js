let selectedSongs = [];
const form = document.querySelector("form");
const res = document.querySelector(".res");
const formCard = document.querySelector("#presentationForm");

function showForm() {
  const icon = document.querySelector("#addIcon");
  if (formCard.style.display == "none") {
    formCard.style.display = "block";
    icon.classList = "bi bi-x-square-fill fs-3 text-primary cursor-pointer";
  } else {
    formCard.style.display = "none";
    icon.classList = "bi bi-plus-square-fill fs-3 text-primary cursor-pointer";
  }
}


function addSong() {
  const select = document.querySelector("#isongs");
  const selectedSong = select.value.trim();

  if (!selectedSong) {
    alert("[ERRO] Selecione uma música válida!");
    return;
  }

  if (selectedSongs.includes(selectedSong)) {
    alert("[ERRO] Música já adicionada!");
    return;
  }

  selectedSongs.push(selectedSong);

  showSongs();
  addInput();

  select.value = "";
}


function showSongs() {
  res.innerHTML = "";

  selectedSongs.forEach((song) => {
    const p = document.createElement("p");

    const span = document.createElement("span");
    span.textContent = song + " ";

    const trash = document.createElement("i");
    trash.className = "bi bi-trash text-danger cursor-pointer";
    trash.role = "button";

    trash.addEventListener("click", () => {
      selectedSongs = selectedSongs.filter(s => s !== song);
      addInput();
      showSongs();
    });

    p.appendChild(span);
    p.appendChild(trash);
    res.appendChild(p);
  });
}


function addInput() {
  document.querySelectorAll(".song-hidden").forEach((el) => el.remove());

  selectedSongs.forEach((el) => {
    const input = document.createElement("input");
    input.type = "hidden";
    input.className = "song-hidden";
    input.name = "songs[]";
    input.value = el;
    form.appendChild(input);
  });
}


function editRepertoire(btn) {
  if (formCard.style.display == "block") {
    alert("[ERRO] Não é possível editar uma tocata enquanto está criando ou editando outra!");
  } else {
    showForm();
    const info = btn.closest(".repertoire-info");

    const id = document.createElement("input");
    id.type = "hidden";
    id.name = 'iid'
    id.value = info.dataset.id;
    form.appendChild(id);

    document.querySelector("#iname").value = info.dataset.name;
    document.querySelector("#idate").value = info.dataset.date;
    document.querySelector("#ihour").value = info.dataset.hour;
    document.querySelector("#ilocal").value = info.dataset.local;

    const bandGroups = info.dataset.group.split("-");
    const checkboxes = document.querySelectorAll('input[name="bandGroup[]"]');

    checkboxes.forEach(cb => {
      if (bandGroups.includes(cb.value)) {
        cb.checked = true;
      }
    });

    selectedSongs = info.dataset.songs.split("-");
    showSongs();
    addInput();

    document.querySelector("#ibutton").value = "Editar Tocata";
    document.querySelector("form").action =
      "RepertoireFunctions/editRepertoire.php";
  }
}

