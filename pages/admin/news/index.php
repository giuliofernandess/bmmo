<?php

require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/DAO/NewsDAO.php";

$newsDAO = new NewsDAO($conn);

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
</head>

<body>
  <?php include_once BASE_PATH . "includes/successToast.php" ?>
  <?php include_once BASE_PATH . "includes/errorToast.php" ?>

  <?php include_once BASE_PATH . 'includes/secondHeader.php'; ?>

  <main class="p-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="mb-0">Notícias</h1>
      <i id="form-toggle-icon" class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" title="Criar Notícia"></i>
    </div>

    <div class="bg-white p-4 rounded shadow-sm mb-4 is-hidden" id="news-form-container">
      <h4 class="mb-3" id="news-form-title">Criar Notícia</h4>

      <form id="news-form-element" action="<?= BASE_URL ?>pages/admin/news/actions/create.php" method="post" enctype="multipart/form-data">

        <div class="mb-3">
          <label for="news-title" class="form-label">Titulo da notícia *</label>
          <input type="text" name="news_title" id="news-title" class="form-control" placeholder="Título da notícia" required>
        </div>

        <div class="mb-3">
          <label for="news-subtitle" class="form-label">Subtitulo da notícia *</label>
          <input type="text" name="news_subtitle" id="news-subtitle" class="form-control" placeholder="Subtítulo da notícia" required>
        </div>

        <div class="mb-3">
          <label for="news-description" class="form-label">Texto de Detalhamento *</label>
          <textarea name="news_description" id="news-description" class="form-control news-description-field" required></textarea>
        </div>

        <div class="mb-3">
          <label for="input-file" class="form-label">Imagem (jpg, jpeg, png)</label>
          <input type="file" name="news_image" id="news-image" class="form-control" accept="image/*">
          <small id="image-hint" class="text-muted"></small>
        </div>

        <input type="submit" id="submit-news-button" class="btn btn-primary btn-lg w-100 py-1"
               value="Publicar Notícia">
      </form>
    </div>

    <div class="row g-3">
      <?php if (!empty($newsList)) { ?>
        <?php foreach ($newsList as $newsItem) { ?>
          <?php
            $newsId = (int) ($newsItem->getNewsId() ?? 0);
            $newsTitle = $newsItem->getNewsTitle();
            $newsSubtitle = $newsItem->getNewsSubtitle();
            $newsDescription = $newsItem->getNewsDescription();
            $newsImage = $newsItem->getNewsImage();
            $escapedNewsTitle = htmlspecialchars($newsTitle, ENT_QUOTES, 'UTF-8');
            $escapedNewsSubtitle = htmlspecialchars($newsSubtitle, ENT_QUOTES, 'UTF-8');
            $escapedNewsDescription = htmlspecialchars($newsDescription, ENT_QUOTES, 'UTF-8');
            $escapedNewsImage = htmlspecialchars($newsImage, ENT_QUOTES, 'UTF-8');
            $publicationDate = $newsItem->getPublicationDate();
            $publicationHour = $newsItem->getPublicationHour();
            $pubDate = $publicationDate !== '' ? date('d/m/Y', strtotime($publicationDate)) : '';
            $pubHour = $publicationHour !== '' ? date('H:i', strtotime($publicationHour)) : '';
          ?>
          <div class="col-12 col-md-6 col-lg-4 news-card-column">
            <div class="card shadow-sm h-100 news-card-item" data-news-id="<?= $newsId ?>" data-news-title="<?= $escapedNewsTitle ?>" data-news-subtitle="<?= $escapedNewsSubtitle ?>" data-news-description="<?= $escapedNewsDescription ?>" data-news-image="<?= $escapedNewsImage ?>">
              <?php if (!empty($newsImage)) { ?>
                <div class="card-img-top" style="background-image: url('<?= BASE_URL ?>uploads/news-images/<?= $escapedNewsImage ?>'); background-size: cover; background-position: top center; min-height: 220px;"></div>
              <?php } ?>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $escapedNewsTitle ?></h5>
                <p class="card-text text-muted mb-1"><?= $escapedNewsSubtitle ?></p>

                <p class="card-text text-secondary small mb-2">Publicado em: <?= $pubDate ?> as <?= $pubHour ?></p>

                <div class="d-flex flex-column gap-2 mt-auto">
                  <button type="button" class="btn btn-success btn-sm news-edit-button">Editar</button>
                  <form action="<?= BASE_URL ?>pages/admin/news/actions/delete.php" method="post" class="news-delete-form">
                    <input type="hidden" name="news_id" value="<?= $newsId ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="col-12"><p>Nenhuma notícia cadastrada no momento.</p></div>
      <?php } ?>
    </div>

  </main>

  <?php include_once BASE_PATH . "includes/footer.php" ?>

  <script>
    window.BASE_URL = <?= json_encode(BASE_URL) ?>;
  </script>
  <script src="<?= BASE_URL ?>assets/js/confirmAction.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/news.js"></script>
</body>

</html>
