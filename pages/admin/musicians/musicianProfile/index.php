<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/DAO/MusiciansDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musiciansDAO = new MusiciansDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);
$bandGroupsDAO = new BandGroupsDAO($conn);

Auth::requireRegency();

// Verifica se recebeu o id do músico
$musicianId = filter_input(INPUT_GET, 'musician_id');

if (!$musicianId) {
  redirectWithMessage(BASE_URL . "pages/admin/musicians/index.php");
}

$musician = $musiciansDAO->getById($musicianId);

if (!$musician) {
  echo "<div class='alert alert-warning m-4'>Músico não encontrado.</div>";
  exit;
}


//Recebimento de variáveis
$musicianName = trim($musician->getMusicianName()) ?: null;

$instrumentName = null;
foreach ($instrumentsDAO->getAll() as $instrumentItem) {
  if (($instrumentItem->getInstrumentId() ?? 0) === $musician->getInstrument()) {
    $instrumentName = trim($instrumentItem->getInstrumentName()) ?: null;
    break;
  }
}

$groupName = null;
foreach ($bandGroupsDAO->getAll() as $group) {
  if (($group->getGroupId() ?? 0) === $musician->getBandGroup()) {
    $groupName = trim($group->getGroupName()) ?: null;
    break;
  }
}

//Tratamento de data
$dateOfBirthRaw = trim($musician->getDateOfBirth()) ?: null;
$dateOfBirth = htmlspecialchars((string) $dateOfBirthRaw);
try {
  $date = new DateTime((string) $dateOfBirthRaw);
  $dateOfBirth = htmlspecialchars($date->format('d-m-Y'));
} catch (Exception $e) {
  // Keep raw date string to avoid fatal error if database value is invalid.
}

$musicianContact = trim((string) ($musician->getMusicianContact() ?? '')) ?: null;
$neighborhood = trim($musician->getNeighborhood()) ?: null;
$institution = trim((string) ($musician->getInstitution() ?? '')) ?: null;
$responsibleName = trim((string) ($musician->getResponsibleName() ?? '')) ?: null;
$responsibleContact = trim((string) ($musician->getResponsibleContact() ?? '')) ?: null;
$profileImage = trim((string) ($musician->getProfileImage() ?? '')) ?: null;


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

  <!-- Card do músico -->
  <?php include_once BASE_PATH . "includes/musicianProfileCard.php"; ?>

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