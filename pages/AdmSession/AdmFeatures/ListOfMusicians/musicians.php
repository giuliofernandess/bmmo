<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

Auth::requireRegency();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon" />

  <!-- Bootstrap + CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musicians.css">

  <title>Relação de músicos</title>
</head>

<body>
  <!-- Header -->
  <?php require_once BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="container mb-5 p-5">
    <h1 class="mb-4 text-center">Lista dos músicos BMMO</h1>

    <?php

    require_once BASE_PATH . "app/Models/Musicians.php";

    $musiciansList = Musicians::getAll();

    if (empty($musiciansList)) {
      echo "<div class='no-musician'>Nenhum músico cadastrado no momento.</div>";
    } else {
      $instrument = '';

      // Itera sobre cada músico
      foreach ($musiciansList as $res) {

        // Dados do músico
        $musicianId = (int) $res['musician_id'];
        $musicianName = htmlspecialchars($res['musician_name'] ?? '', ENT_QUOTES, 'UTF-8');
        $bandGroup = htmlspecialchars($res['group_name'] ?? '', ENT_QUOTES, 'UTF-8');

        // Verificação de imagem
        $musicianImage = basename($res['profile_image'] ?? '');

        $imagePath = BASE_PATH . "uploads/musicians-images/{$musicianImage}";
        $imageUrl = BASE_URL . "uploads/musicians-images/{$musicianImage}";

        $image = (!empty($musicianImage) && file_exists($imagePath))
          ? $imageUrl
          : BASE_URL . "uploads/musicians-images/default.png";

        if ($instrument != htmlspecialchars($res['instrument_name'] ?? '', ENT_QUOTES, 'UTF-8')) {
          $instrument = htmlspecialchars($res['instrument_name'] ?? '', ENT_QUOTES, 'UTF-8');
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$instrument</h2>";
          echo "<div class='row g-4 mt-3'>";
        } ?>


        <div class='col-12 col-md-6 col-lg-3 mb-5'>
          <div class='card musician-card border-0 shadow-sm'>
            <img src='<?= $image ?>' class='card-img-top' alt='Imagem de <?= $musicianName ?>'>
            <a href='Profile/musicianProfile.php?idMusician=<?= $musicianId ?>' class='card-body d-flex flex-column text-decoration-none'>
              <h4 class='card-title fw-semibold text-center mb-3'><?= $musicianName ?></h4>
              <p class="text-center text-dark-emphasis mb-3 fs-5"><?= $bandGroup ?></p>
              <button class='btn btn-outline-primary mt-auto w-100'>
                <i class='bi bi-person-lines-fill me-1'></i> Ver Perfil
              </button>
            </a>
          </div>
        </div>

      <?php }
    } ?>

  </main>


  <!-- Footer -->
  <?php require_once BASE_PATH . "includes/footer.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>