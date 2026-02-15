<?php
require_once '../../../config/config.php';
require_once BASE_PATH . 'app/Models/News.php';

if (!isset($_GET['newsId'])) {
  die("ID da notícia não fornecido.");
}

$newsId = (int) $_GET['newsId'];

$news = News::getById($newsId);

if (!$news) {
  die("Notícia não encontrada.");
}

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

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/expandedNews.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <?php require_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Conteúdo -->
  <main class="container my-5">
    <div class="row">

      <!-- Notícia Principal -->
      <div class="col-lg-8">
        <article class="card shadow-sm rounded p-4 mb-4 bg-white">
          <h1 class="mb-3 fw-bold"><?= $news->getSafeTitle(); ?></h1>
          <h5 class="text-muted mb-3 fw-bold"><?= $news->getSafeSubtitle(); ?></h5>
          <p class="text-muted small mb-4">Publicado em <?= htmlspecialchars($news->getFormattedDate()); ?></p>
          <img src="<?= BASE_URL ?>uploads/news-images/<?= $news->getSafeImage(); ?>"
            alt="Imagem da notícia: <?= $news->getSafeTitle(); ?>" loading="lazy"
            class="news-image-main mb-4" />
          <div class="news-text"><?= $news->getSafeDescription(); ?></div>
        </article>
      </div>

      <!-- Outras Notícias -->
      <div class="col-lg-4">
        <h4 class="mb-3">Outras notícias</h4>
        <?php
        
        // Chamada do model
        $otherNews = News::getOtherNews($newsId, 2);

        if (empty($otherNews)) { ?>
          <p class="text-muted">Nenhuma outra notícia disponível.</p>
        <?php } else { 
          
          foreach ($otherNews as $asideNews) { ?>
            <a href="expandedNews.php?newsId=<?= $asideNews->id ?>" class="mb-3 text-decoration-none text-dark d-block">
              <div class="card aside-card rounded shadow-sm h-100">
                <div class="row g-0">
                  <div class="col-4">
                    <img src="<?= BASE_URL ?>uploads/news-images/<?= $asideNews->getSafeImage(); ?>"
                      class="img-fluid rounded-start" alt="Imagem da notícia: <?= $asideNews->getSafeTitle(); ?>"
                      loading="lazy" />
                  </div>

                  <div class="col-8">
                    <div class="card-body">
                      <h6 class="card-title mb-1">
                        <?= $asideNews->getSafeTitle(); ?>
                      </h6>
                      <p class="card-text small text-muted mb-1">
                        <?= $asideNews->getSafeSubtitle(); ?>
                      </p>
                      <p class="card-text">
                        <small class="text-muted">
                          Publicado em:
                          <?= htmlspecialchars($asideNews->getFormattedDate()); ?>
                        </small>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          <?php } ?>

        <?php } ?>

      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once BASE_PATH . 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>