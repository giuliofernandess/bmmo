<?php

require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/Models/News.php";

Auth::requireRegency();

$newsList = News::getAll();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Notícias</title>
  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">

  <style>
    .cursor-pointer { cursor: pointer; }
    .news-card-item img { max-height: 160px; object-fit: cover; }
  </style>
</head>

<body>
  <!-- Toasts -->
  <?php include_once BASE_PATH . "includes/successToast.php" ?>
  <?php include_once BASE_PATH . "includes/errorToast.php" ?>

  <!-- Header -->
  <?php include_once BASE_PATH . 'includes/secondHeader.php'; ?>

  <main class="p-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="mb-0">Notícias</h1>
      <i id="addIcon" class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" onclick="showForm()" title="Criar Notícia"></i>
    </div>

    <div class="bg-white p-4 rounded shadow-sm mb-4" style="display: none;" id="newsForm">
      <h4 class="mb-3" id="formTitle">Criar Notícia</h4>

      <form id="newsFormElement" action="newsFunctions/validateCreateNews.php" method="post" enctype="multipart/form-data">

        <div class="mb-3">
          <label for="news-title" class="form-label">Título da notícia *</label>
          <input type="text" name="title" id="news-title" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="news-subtitle" class="form-label">Subtítulo da notícia</label>
          <input type="text" name="subtitle" id="news-subtitle" class="form-control">
        </div>

        <div class="mb-3">
          <label for="news-description" class="form-label">Texto de Detalhamento *</label>
          <textarea name="description" id="news-description" class="form-control" style="height: 200px" required></textarea>
        </div>

        <div class="mb-3">
          <label for="input-file" class="form-label">Imagem (jpg, jpeg, png, gif) *</label>
          <input type="file" name="file" id="input-file" class="form-control" accept="image/*">
          <small id="imageHint" class="text-muted"></small>
        </div>

        <input type="submit" id="newsSubmit" class="btn btn-outline-primary" value="Publicar Notícia">
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

                <p class="card-text text-secondary small mb-2">Publicado em: <?= $pubDate ?> às <?= $pubHour ?></p>

                <div class="d-flex justify-content-end gap-2">
                  <a href="newsFunctions/validateDeleteNews.php?news_id=<?= $newsId ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta notícia?');">Excluir</a>
                  <button type="button" class="btn btn-success btn-sm" onclick="editNews(this)">Editar</button>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/news.js"></script>
</body>

</html>
