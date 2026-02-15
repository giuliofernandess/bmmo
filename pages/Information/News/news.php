<?php
require_once '../../../config/config.php';
require_once BASE_PATH . 'app/Models/News.php';
?>


<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notícias</title>

  <!-- Links -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/news.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <?php require_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Main Content -->
  <main class="py-5 flex-grow-1">
    <div class="container">
      <h1 class="mb-4 text-center">Acompanhe as últimas notícias da banda</h1>
      <section class="row g-4">
        <?php

        // Chamada do model
        $newsList = News::getAll();


        if (empty($newsList)) { ?>
          <div class="no-news">Nenhuma notícia cadastrada no momento.</div>
        <?php } else { ?>

          <?php foreach ($newsList as $news) { ?>
            <div class='col-md-6 col-lg-4'>
              <a href='expandedNews.php?newsId=<?= $news->id ?>' class='text-decoration-none text-dark'>
                <div class='card news-card rounded shadow-sm h-100'>
                  <img src='<?= BASE_URL ?>uploads/news-images/<?= $news->getSafeImage() ?>'
                    class='card-img-top rounded-top news-image' alt="Imagem da notícia: <?= $news->getSafeTitle() ?>"
                    loading="lazy">
                  <div class='card-body'>
                    <h5 class='card-title mb-1'>
                      <?= $news->getSafeTitle() ?>
                    </h5>
                    <p class='card-text text-muted small mb-2'>
                      <?= $news->getSafeSubtitle() ?>
                    </p>
                    <p class='card-text'>
                      <small class='text-muted'>
                        Publicado em:
                        <?= htmlspecialchars($news->getFormattedDate()) ?>
                      </small>
                    </p>
                  </div>
                </div>
              </a>
            </div>
          <?php } ?>

        <?php } ?>

      </section>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once BASE_PATH . 'includes/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>