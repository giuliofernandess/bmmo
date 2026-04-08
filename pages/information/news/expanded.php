<?php
// Config e classe de notícias
require_once '../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$newsDAO = new NewsDAO($conn);

// Captura o ID da notícia via GET
$newsId = filter_input(INPUT_GET, 'news_id');

if ($newsId === null || $newsId <= 0) {
    die("ID da notícia não fornecido.");
}

// Busca notícia principal via POO
$news = $newsDAO->getById($newsId);
if (!$news) {
    die("Notícia não encontrada.");
}

// Busca outras notícias para sidebar (exceto a principal)
$otherNews = $newsDAO->getLatestExcept($newsId, 2);
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notícia</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/news.css">
  
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <?php include_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Conteúdo principal -->
  <main class="container my-5">
    <div class="row">

      <!-- Notícia principal -->
      <div class="col-lg-8">
        <article class="card shadow-sm rounded p-4 mb-4 bg-white">
          <h1 class="mb-3 fw-bold"><?= htmlspecialchars($news->getNewsTitle()); ?></h1>
          <h5 class="text-muted mb-3 fw-bold"><?= htmlspecialchars($news->getNewsSubtitle()); ?></h5>
          <p class="text-muted small mb-4">Publicado em <?= date('d/m/Y', strtotime($news->getPublicationDate())); ?></p>
          <div class='news-image-main mb-4' style='background-image: url("<?= BASE_URL ?>uploads/news-images/<?= htmlspecialchars($news->getNewsImage()); ?>"); background-size: cover; background-position: top center; height: 400px;'></div>
          <div class="news-text"><?= nl2br(htmlspecialchars($news->getNewsDescription())); ?></div>
        </article>
      </div>

      <!-- Sidebar: Outras notícias -->
      <div class="col-lg-4">
        <h4 class="mb-3">Outras notícias</h4>

        <?php if (!empty($otherNews)) { ?>
            <?php foreach ($otherNews as $newsItem) { 
              $asideNewsId = (int) ($newsItem->getNewsId() ?? 0);
              $asideNewsTitle = htmlspecialchars($newsItem->getNewsTitle(), ENT_QUOTES, 'UTF-8');
              $asideNewsSubtitle = htmlspecialchars($newsItem->getNewsSubtitle(), ENT_QUOTES, 'UTF-8');
              $asideNewsImage = basename($newsItem->getNewsImage());
              $asidePublicationDateRaw = $newsItem->getPublicationDate();
              $asidePublicationDate = $asidePublicationDateRaw !== '' ? date('d/m/Y', strtotime($asidePublicationDateRaw)) : '';
            ?>
                <!-- Card de notícia da sidebar -->
                <a href='<?= BASE_URL ?>pages/information/news/expanded.php?news_id=<?= $asideNewsId ?>' class='mb-3 text-decoration-none text-dark d-block'>
                  <div class='card aside-card rounded shadow-sm h-100'>
                    <div class='row g-0'>
                      <div class='col-4 news-aside-image' style='background-image: url("<?= BASE_URL ?>uploads/news-images/<?= $asideNewsImage ?>"); background-size: cover; background-position: top center;'></div>
                      <div class='col-8'>
                        <div class='card-body'>
                          <h6 class='card-title mb-1'><?= $asideNewsTitle ?></h6>
                          <p class='card-text small text-muted mb-1'><?= $asideNewsSubtitle ?></p>
                          <p class='card-text'><small class='text-muted'>Publicado em: <?= $asidePublicationDate ?></small></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
            <?php } ?>
          <?php } else { ?>
            <p class='text-muted'>Nenhuma outra notícia disponível.</p>
          <?php } ?>

      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php include_once BASE_PATH . 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
