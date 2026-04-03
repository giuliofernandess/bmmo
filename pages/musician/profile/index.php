<?php
require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

Auth::requireMusician();

require_once BASE_PATH ."includes/getMusicianInfo.php";

?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Músico</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/profile.css">
</head>

<body>
  <!-- Toast de sucesso -->
   <?php include_once BASE_PATH . "includes/successToast.php"; ?>

  <!-- Header -->
  <?php include_once BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="flex-fill d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="card shadow mx-auto my-5 profile-summary-card">
        <div class="row g-0">
          <!-- Imagem -->
          <div class="col-md-4 text-center bg-secondary">
            <img src="<?= BASE_URL ?>uploads/musicians-images/<?= $musicianInfo['profile_image'] ? $musicianInfo['profile_image'] : 'default.png'?>" class="img-fluid rounded-start h-100 object-fit-cover"
              alt="Imagem de <?= htmlspecialchars($musicianInfo['musician_name']) ?>">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h4 class="card-title mb-3"><?= htmlspecialchars($musicianInfo['musician_name']); ?></h4>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Instrumento:</strong>
                  <?= htmlspecialchars($musicianInfo['instrument_name']); ?></li>
                <li class="list-group-item"><strong>Grupo:</strong> <?= htmlspecialchars($musicianInfo['group_name']); ?>
                </li>
                <li class="list-group-item"><strong>Data de Nascimento:</strong>
                  <?= htmlspecialchars($musicianInfo['date_of_birth']); ?></li>
                <li class="list-group-item"><strong>Telefone:</strong>
                  <?= htmlspecialchars($musicianInfo['musician_contact']); ?></li>
                <li class="list-group-item"><strong>Nome do responsável:</strong>
                  <?= htmlspecialchars($musicianInfo['responsible_name']); ?></li>
                <li class="list-group-item"><strong>Contato do responsável:</strong>
                  <?= htmlspecialchars($musicianInfo['responsible_contact']); ?></li>
                <li class="list-group-item"><strong>Bairro:</strong>
                  <?= htmlspecialchars($musicianInfo['neighborhood']); ?></li>
                <li class="list-group-item"><strong>Instituição:</strong>
                  <?= htmlspecialchars($musicianInfo['institution']); ?></li>
              </ul>

              <!-- Botão editar -->
              <div class="mt-auto d-flex justify-content-end gap-2">

                <a href="<?= BASE_URL ?>pages/musician/profile/edit/index.php" class="btn btn-outline-primary">
                  <i class="bi bi-pencil-square"></i> Editar
                </a>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php include_once BASE_PATH . "includes/footer.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>