<?php
require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
$auth = new Auth();

$auth->requireMusician();

require_once BASE_PATH ."helpers/getMusicianInfo.php";

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

  <!-- Card do músico -->
  <?php include_once BASE_PATH . "includes/musicianProfileCard.php"; ?>

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