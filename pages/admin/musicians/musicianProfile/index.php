<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/DAO/MusiciansDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";

$musiciansDAO = new MusiciansDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);
$bandGroupsDAO = new BandGroupsDAO($conn);

Auth::requireRegency();

// Verifica se recebeu o id do músico
$musicianId = isset($_GET['musician_id']) ? (int)$_GET['musician_id'] : null;

if (!$musicianId) {
  header("Location: " . BASE_URL . "pages/admin/musicians/index.php");
  exit;
}

$res = $musiciansDAO->getById($musicianId);

if (!$res) {
  echo "<div class='alert alert-warning m-4'>Músico não encontrado.</div>";
  exit;
}


//Recebimento de variáveis
$musicianName = trim($res->getMusicianName()) ?: null;

$instrument = null;
foreach ($instrumentsDAO->getAll() as $instrumentItem) {
  if (($instrumentItem->getInstrumentId() ?? 0) === $res->getInstrument()) {
    $instrument = trim($instrumentItem->getInstrumentName()) ?: null;
    break;
  }
}

$bandGroup = null;
foreach ($bandGroupsDAO->getAll() as $group) {
  if (($group->getGroupId() ?? 0) === $res->getBandGroup()) {
    $bandGroup = trim($group->getGroupName()) ?: null;
    break;
  }
}

//Tratamento de data
$dateOfBirthRaw = trim($res->getDateOfBirth()) ?: null;
$dateOfBirth = htmlspecialchars((string) $dateOfBirthRaw);
try {
  $date = new DateTime((string) $dateOfBirthRaw);
  $dateOfBirth = htmlspecialchars($date->format('d-m-Y'));
} catch (Exception $e) {
  // Keep raw date string to avoid fatal error if database value is invalid.
}

$musicianContact = trim((string) ($res->getMusicianContact() ?? '')) ?: null;
$neighborhood = trim($res->getNeighborhood()) ?: null;
$institution = trim((string) ($res->getInstitution() ?? '')) ?: null;
$responsibleName = trim((string) ($res->getResponsibleName() ?? '')) ?: null;
$responsibleContact = trim((string) ($res->getResponsibleContact() ?? '')) ?: null;
$profileImage = trim((string) ($res->getProfileImage() ?? '')) ?: null;


// Tratamento de possível NULL
$institution = $institution ? htmlspecialchars($institution) : "Não informado";
$responsibleName = $responsibleName ? htmlspecialchars($responsibleName) : "Não informado";
$responsibleContact = $responsibleContact ? htmlspecialchars($responsibleContact) : "Não informado";

$profileImage = $profileImage ? htmlspecialchars($profileImage) : "default.png";
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Perfil do Músico</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/profile.css">
  
</head>

<body>
  <!-- Toasts de sucesso -->
  <?php include_once BASE_PATH . "includes/successToast.php"; ?>
  <?php include_once BASE_PATH . "includes/errorToast.php"; ?>

  <!-- Header -->
  <?php include_once BASE_PATH . "includes/secondHeader.php"; ?>
  

  <main class="flex-fill py-5">
    <div class="container">
      <div class="card shadow mx-auto">
        <div class="row g-0">

          <!-- Imagem -->
          <div class="col-md-4 text-center bg-secondary">
            <img src="<?= BASE_URL ?>uploads/musicians-images/<?= $profileImage; ?>"
              class="img-fluid rounded-start w-100 h-100 object-fit-cover card-image" alt="Imagem de <?= $musicianName; ?>">
          </div>

          <!-- Dados do músico -->
          <div class="col-md-8">
            <div class="card-body d-flex flex-column h-100">
              <h4 class="card-title mb-3"><?= $musicianName; ?></h4>

              <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item"><strong>Instrumento:</strong> <?= $instrument; ?></li>
                <li class="list-group-item"><strong>Grupo:</strong> <?= $bandGroup; ?></li>
                <li class="list-group-item"><strong>Data de Nascimento:</strong> <?= $dateOfBirth; ?></li>
                <li class="list-group-item"><strong>Telefone:</strong> <?= $musicianContact; ?></li>
                <li class="list-group-item"><strong>Bairro:</strong> <?= $neighborhood; ?></li>
                <li class="list-group-item"><strong>Instituição:</strong> <?= $institution; ?></li>
                <li class="list-group-item"><strong>Responsável:</strong> <?= $responsibleName; ?></li>
                <li class="list-group-item"><strong>Telefone do Responsável:</strong> <?= $responsibleContact; ?></li>
              </ul>

              <!-- Botões -->
              <div class="mt-auto d-flex justify-content-end gap-2">

                <a href="edit/index.php?musician_id=<?= $musicianId; ?>" class="btn btn-outline-primary">
                  <i class="bi bi-pencil-square"></i> Editar
                </a>

                <form action="<?= BASE_URL ?>pages/admin/musicians/actions/delete.php" method="POST"
                  class="musician-delete-form">

                  <input type="hidden" name="musician_id" value="<?= $musicianId; ?>">

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

  <!-- Footer -->
  <?php include_once BASE_PATH . "includes/footer.php"; ?>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.musician-delete-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
          if (!confirmAction('Tem certeza que deseja excluir este músico?')) {
            event.preventDefault();
          }
        });
      });
    });
  </script>

  <script src="<?= BASE_URL ?>assets/js/confirmAction.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>