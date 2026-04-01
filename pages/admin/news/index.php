<?php

require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/DAO/NewsDAO.php";

Auth::requireRegency();

$newsList = $newsDAO->getAll();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Notícias</title>
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">

  <style>
    .cursor-pointer { cursor: pointer; }
    .news-card-item img { max-height: 160px; object-fit: cover; }
  </style>
</head>

<body>
  <?php include_once BASE_PATH . "includes/successToast.php" ?>
  <?php include_once BASE_PATH . "includes/errorToast.php" ?>

  <?php include_once BASE_PATH . 'includes/secondHeader.php'; ?>

  <main class="p-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="mb-0">Notícias</h1>
      <i id="add-icon" class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" onclick="showForm()" title="Criar Notícia"></i>
    </div>

    <div class="bg-white p-4 rounded shadow-sm mb-4" style="display: none;" id="news-form">
      <h4 class="mb-3" id="form-title">Criar Notícia</h4>

      <form id="news-form-element" action="<?= BASE_URL ?>pages/admin/news/actions/create.php" method="post" enctype="multipart/form-data">

        <div class="mb-3">
          <label for="news-title" class="form-label">Titulo da notícia *</label>
          <input type="text" name="title" id="news-title" class="form-control" placeholder="Título da notícia" required>
        </div>

        <div class="mb-3">
          <label for="news-subtitle" class="form-label">Subtitulo da notícia</label>
          <input type="text" name="subtitle" id="news-subtitle" class="form-control" placeholder="Subtítulo da notícia">
        </div>

        <div class="mb-3">
          <label for="news-description" class="form-label">Texto de Detalhamento *</label>
          <textarea name="description" id="news-description" class="form-control" style="height: 200px" required></textarea>
        </div>

        <div class="mb-3">
          <label for="input-file" class="form-label">Imagem (jpg, jpeg, png, gif) *</label>
          <input type="file" name="file" id="input-file" class="form-control" accept="image/*">
          <small id="image-hint" class="text-muted"></small>
        </div>

        <input type="submit" id="news-submit" class="btn btn-outline-primary" value="Publicar Notícia">
      </form>
    </div>

    <div class="row g-3">
      <?php if (!empty($newsList)): ?>
        <?php foreach ($newsList as $news): ?>
          <?php
            $newsId = (int) $news['news_id'];
            $newsTitle = htmlspecialchars($news['news_title'] ?? '', ENT_QUOTES, 'UTF-8');
            $newsSubtitle = htmlspecialchars($news['news_subtitle'] ?? '', ENT_QUOTES, 'UTF-8');
            $newsDescription = htmlspecialchars($news['news_description'] ?? '', ENT_QUOTES, 'UTF-8');
            $newsImage = htmlspecialchars($news['news_image'] ?? '', ENT_QUOTES, 'UTF-8');
            $pubDate = !empty($news['publication_date']) ? date('d/m/Y', strtotime($news['publication_date'])) : '';
            $pubHour = !empty($news['publication_hour']) ? date('H:i', strtotime($news['publication_hour'])) : '';
          ?>
          <div class="col-12 col-md-6 col-lg-4" style="max-width: 400px">
            <div class="card shadow-sm h-100 news-card-item" data-id="<?= $newsId ?>" data-title="<?= htmlspecialchars($newsTitle, ENT_QUOTES, 'UTF-8') ?>" data-subtitle="<?= htmlspecialchars($newsSubtitle, ENT_QUOTES, 'UTF-8') ?>" data-description="<?= htmlspecialchars($newsDescription, ENT_QUOTES, 'UTF-8') ?>" data-image="<?= htmlspecialchars($newsImage, ENT_QUOTES, 'UTF-8') ?>">
              <?php if (!empty($newsImage)): ?>
                <img src="<?= BASE_URL ?>uploads/news-images/<?= htmlspecialchars($newsImage, ENT_QUOTES, 'UTF-8') ?>" class="card-img-top" alt="<?= htmlspecialchars($newsTitle, ENT_QUOTES, 'UTF-8') ?>">
              <?php endif; ?>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($newsTitle, ENT_QUOTES, 'UTF-8') ?></h5>
                <p class="card-text text-muted mb-1"><?= htmlspecialchars($newsSubtitle, ENT_QUOTES, 'UTF-8') ?></p>

                <p class="card-text text-secondary small mb-2">Publicado em: <?= $pubDate ?> as <?= $pubHour ?></p>

                <div class="d-flex flex-column gap-2 mt-auto">
                  <button type="button" class="btn btn-success btn-sm" onclick="editNews(this)">Editar</button>
                  <form action="<?= BASE_URL ?>pages/admin/news/actions/delete.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta notícia?');">
                    <input type="hidden" name="news_id" value="<?= $newsId ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12"><p>Nenhuma notícia cadastrada no momento.</p></div>
      <?php endif; ?>
    </div>

  </main>

  <?php include_once BASE_PATH . "includes/footer.php" ?>

  <script>
    window.BASE_URL = <?= json_encode(BASE_URL) ?>;
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/news.js"></script>
</body>

</html>
