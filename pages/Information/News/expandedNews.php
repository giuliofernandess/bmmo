<?php
// Config e classe de notícias
require_once '../../../config/config.php';
require_once BASE_PATH . 'app/Models/News.php';

// Captura o ID da notícia via GET
if (!isset($_GET['newsId'])) {
    die("ID da notícia não fornecido.");
}

$newsId = (int)$_GET['newsId'];

// Busca notícia principal via POO
$res = News::getById($newsId);
if (!$res) {
    die("Notícia não encontrada.");
}

// Busca outras notícias para sidebar (exceto a principal)
$otherNews = News::getLatestExcept($newsId, 2);
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notícia</title>

  <!-- Favicon e CSS -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/expandedNews.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <?php require_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Conteúdo principal -->
  <main class="container my-5">
    <div class="row">

      <!-- Notícia principal -->
      <div class="col-lg-8">
        <article class="card shadow-sm rounded p-4 mb-4 bg-white">
          <h1 class="mb-3 fw-bold"><?= htmlspecialchars($res['news_title']); ?></h1>
          <h5 class="text-muted mb-3 fw-bold"><?= htmlspecialchars($res['news_subtitle']); ?></h5>
          <p class="text-muted small mb-4">Publicado em <?= date('d/m/Y', strtotime($res['publication_date'])); ?></p>
          <img src="<?= BASE_URL ?>uploads/news-images/<?= htmlspecialchars($res['news_image']); ?>"
               alt="Imagem da notícia: <?= htmlspecialchars($res['news_title']) ?>" loading="lazy" class="news-image-main mb-4" />
          <div class="news-text"><?= nl2br(htmlspecialchars($res['news_description'])); ?></div>
        </article>
      </div>

      <!-- Sidebar: Outras notícias -->
      <div class="col-lg-4">
        <h4 class="mb-3">Outras notícias</h4>

        <?php if (!empty($otherNews)) : ?>
            <?php foreach ($otherNews as $news) : 
                $asideNewsId = (int)$news['news_id'];
                $asideNewsTitle = htmlspecialchars($news['news_title'] ?? '', ENT_QUOTES, 'UTF-8');
                $asideNewsSubtitle = htmlspecialchars($news['news_subtitle'] ?? '', ENT_QUOTES, 'UTF-8');
                $asideNewsImage = basename($news['news_image'] ?? '');
                $asidePublicationDate = !empty($news['publication_date']) ? date('d/m/Y', strtotime($news['publication_date'])) : '';
            ?>
                <!-- Card de notícia da sidebar -->
                <a href='expandedNews.php?newsId=<?= $asideNewsId ?>' class='mb-3 text-decoration-none text-dark d-block'>
                  <div class='card aside-card rounded shadow-sm h-100'>
                    <div class='row g-0'>
                      <div class='col-4'>
                        <img src='<?= BASE_URL ?>uploads/news-images/<?= $asideNewsImage ?>' 
                             class='img-fluid rounded-start' 
                             alt="Imagem da notícia: <?= $asideNewsTitle ?>" loading="lazy" />
                      </div>
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
            <?php endforeach; ?>
        <?php else: ?>
            <p class='text-muted'>Nenhuma outra notícia disponível.</p>
        <?php endif; ?>

      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once BASE_PATH . 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
