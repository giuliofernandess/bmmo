<?php 

require_once '../../../config/config.php';


require_once BASE_PATH . 'app/DAO/NewsDAO.php';

$newsDAO = new NewsDAO($conn);
$newsList = $newsDAO->getAll();
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notícias</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/news.css">
  
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <?php include_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Conteúdo principal -->
  <main class="py-5 flex-grow-1">
    <div class="container">
      <h1 class="mb-4 text-center">Acompanhe as últimas notícias da banda</h1>

      <section class="row g-4">

        <?php
        if (empty($newsList)) {
            echo "<div class='no-news'>Nenhuma notícia cadastrada no momento.</div>";
        } else {
            
            foreach ($newsList as $newsItem) {

                
              $newsId = (int) ($newsItem->getNewsId() ?? 0);
                $newsTitle = htmlspecialchars($newsItem->getNewsTitle(), ENT_QUOTES, 'UTF-8');
                $newsSubtitle = htmlspecialchars($newsItem->getNewsSubtitle(), ENT_QUOTES, 'UTF-8');
              $newsImage = basename($newsItem->getNewsImage());
              $publicationDateRaw = $newsItem->getPublicationDate();
              $publicationHourRaw = $newsItem->getPublicationHour();
                $publicationDate = $publicationDateRaw !== '' ? date('d/m/Y', strtotime($publicationDateRaw)) : '';
                $publicationHour = $publicationHourRaw !== '' ? date('H:i', strtotime($publicationHourRaw)) : '';
        ?>

                <!-- Card da notícia -->
                <div class='col-md-6 col-lg-4'>
                  <a href='<?= BASE_URL ?>pages/information/news/expanded.php?news_id=<?= htmlspecialchars($newsId) ?>' class='text-decoration-none text-dark'>
                    <div class='card news-card rounded shadow-sm h-100'>
                      <div class='card-img-top rounded-top news-image' style='background-image: url("<?= BASE_URL ?>uploads/news-images/<?= htmlspecialchars($newsImage) ?>"); background-size: cover; background-position: top center; height: 200px;'></div>
                      <div class='card-body'>
                        <h5 class='card-title mb-1'><?= $newsTitle ?></h5>
                        <p class='card-text text-muted small mb-2'><?= $newsSubtitle ?></p>
                        <p class='card-text'><small class='text-muted'>Publicado em: <?= $publicationDate ?> às <?= $publicationHour ?></small></p>
                      </div>
                    </div>
                  </a>
                </div>

        <?php
            }
        }
        ?>

      </section>
    </div>
  </main>

  <!-- Footer -->
  <?php include_once BASE_PATH . 'includes/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
