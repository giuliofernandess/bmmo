<?php
require_once "../../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/Models/Musicians.php";

Auth::requireRegency();

// Verifica se recebeu o id do músico
$musicianId = isset($_GET["musicianId"]) ? (int)$_GET["musicianId"] : null;

if (!$musicianId) {
  header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/musicians.php");
  exit;
}

$res = Musicians::getById($musicianId);

if (!$res) {
  echo "<div class='alert alert-warning m-4'>Músico não encontrado.</div>";
  exit;
}


//Recebimento de variáveis
$musician_name = trim($res['musician_name'] ?? '') ?: null;
$instrument = trim($res['instrument_name'] ?? '') ?: null;
$band_group = trim($res['group_name'] ?? '') ?: null;

//Tratamento de data
$date_of_birth_raw = trim($res['date_of_birth'] ?? '') ?: null;
$date = new DateTime($date_of_birth_raw);
$date_of_birth = htmlspecialchars($date->format('d-m-Y'));

$musician_contact = trim($res['musician_contact'] ?? '') ?: null;
$neighborhood = trim($res['neighborhood'] ?? '') ?: null;
$institution = trim($res['institution'] ?? '') ?: null;
$responsible_name = trim($res['responsible_name'] ?? '') ?: null;
$responsible_contact = trim($res['responsible_contact'] ?? '') ?: null;
$profile_image = trim($res['profile_image'] ?? '') ?: null;


// Tratamento de possível NULL
$institution = $institution ? htmlspecialchars($institution) : "Não informado";
$responsible_name = $responsible_name ? htmlspecialchars($responsible_name) : "Não informado";
$responsible_contact = $responsible_contact ? htmlspecialchars($responsible_contact) : "Não informado";

$profile_image = $profile_image ? htmlspecialchars($profile_image) : "default.png";
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Perfil do Músico</title>

  <link rel="shortcut icon" href="<?= BASE_URL ?>/assets/images/logo_banda.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musicianProfile.css">

  <style>
    
  </style>
</head>

<body>
  <!-- Toast de sucesso -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
      <div class="toast align-items-center text-bg-success border-0 show" role="alert">
        <div class="d-flex">
          <div class="toast-body">
            <?= htmlspecialchars($_SESSION['success']); ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto"
            onclick="this.closest('.toast-container').remove()"></button>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['success']); // remove para não aparecer novamente ?>
  <?php endif; ?>

  <?php require_once BASE_PATH . "includes/secondHeader.php"; ?>
  

  <main class="flex-fill py-5">
    <div class="container">
      <div class="card shadow mx-auto">
        <div class="row g-0">

          <!-- Imagem -->
          <div class="col-md-4 text-center bg-secondary">
            <img src="<?= BASE_URL ?>uploads/musicians-images/<?= $profile_image; ?>"
              class="img-fluid rounded-start w-100 h-100 object-fit-cover card-image" alt="Imagem de <?= $musician_name; ?>">
          </div>

          <!-- Dados do músico -->
          <div class="col-md-8">
            <div class="card-body d-flex flex-column h-100">
              <h4 class="card-title mb-3"><?= $musician_name; ?></h4>

              <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item"><strong>Instrumento:</strong> <?= $instrument; ?></li>
                <li class="list-group-item"><strong>Grupo:</strong> <?= $band_group; ?></li>
                <li class="list-group-item"><strong>Data de Nascimento:</strong> <?= $date_of_birth; ?></li>
                <li class="list-group-item"><strong>Telefone:</strong> <?= $musician_contact; ?></li>
                <li class="list-group-item"><strong>Bairro:</strong> <?= $neighborhood; ?></li>
                <li class="list-group-item"><strong>Instituição:</strong> <?= $institution; ?></li>
                <li class="list-group-item"><strong>Responsável:</strong> <?= $responsible_name; ?></li>
                <li class="list-group-item"><strong>Telefone do Responsável:</strong> <?= $responsible_contact; ?></li>
              </ul>

              <!-- Botões -->
              <div class="mt-auto d-flex justify-content-end gap-2">

                <a href="MusicianEdit/musicianEdit.php?musicianId=<?= $musicianId; ?>" class="btn btn-outline-primary">
                  <i class="bi bi-pencil-square"></i> Editar
                </a>

                <form action="MusicianEdit/MusicianDelete/validateMusicianDelete.php" method="POST"
                  onsubmit="return confirm('Tem certeza que deseja excluir este músico?');">

                  <input type="hidden" name="musicianId" value="<?= $musicianId; ?>">

                  <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash"></i> Excluir
                  </button>
                </form>

              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </main>

  <?php require_once BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
   <script src="<?= BASE_URL ?>assets/js/removeToast.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>