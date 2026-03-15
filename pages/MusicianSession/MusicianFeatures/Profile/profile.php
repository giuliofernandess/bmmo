<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/Models/Musicians.php";

Auth::requireMusician();

$login = $_SESSION["musician_login"] ? trim($_SESSION["musician_login"]) : null;
$musicianInfo = Musicians::findByLogin($login);

?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Músico</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>
</head>

<body>
  <!-- Header -->
  <?php include_once BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="flex-fill d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="card shadow mx-auto my-5" style="max-width: 800px;">
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
                <li class="list-group-item"><strong>Bairro:</strong>
                  <?= htmlspecialchars($musicianInfo['neighborhood']); ?></li>
              </ul>
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