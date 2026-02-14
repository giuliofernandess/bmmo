<?php require_once '../../../config/config.php'; ?>

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

        // Conexão com o banco
        require_once BASE_PATH . 'utilities/bdConnect.php';

        if (!$connect) {
          echo "<div class='alert alert-danger'>Erro ao conectar com o banco de dados.</div>";
          exit;
        }

        // Query
        $sql = "SELECT * FROM news ORDER BY publication_date DESC";
        $stmt = $connect->prepare($sql);

        if (!$stmt) {
          echo "<div class='alert alert-warning'>Erro ao preparar a consulta.</div>";
          exit;
        }

        if (!$stmt->execute()) {
          echo "<div class='alert alert-warning'>Erro ao executar a consulta.</div>";
          exit;
        }

        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
          echo "<div class='no-news'>Nenhuma notícia cadastrada no momento.</div>";
        } else {

          while ($res = $result->fetch_array(MYSQLI_ASSOC)) {

            // Definição de variáveis
            $newsId = (int) $res['news_id'];
            $newsTitle = htmlspecialchars($res['news_title'] ?? '', ENT_QUOTES, 'UTF-8');
            $newsSubtitle = htmlspecialchars($res['news_subtitle'] ?? '', ENT_QUOTES, 'UTF-8');
            $newsImage = basename($res['news_image'] ?? '');

            $publicationDate = '';
            if (!empty($res['publication_date'])) {
              $publicationDate = date('d/m/Y', strtotime($res['publication_date']));
            }

            ?>

            <!-- Impressão do card -->
            <div class='col-md-6 col-lg-4'>
              <a href='expandedNews.php?id=<?= htmlspecialchars($newsId) ?>' class='text-decoration-none text-dark'>
                <div class='card news-card rounded shadow-sm h-100'>
                  <img src='<?= BASE_URL ?>uploads/news-images/<?= htmlspecialchars($newsImage) ?>' class='card-img-top rounded-top news-image'
                    alt="Imagem da notícia: <?= htmlspecialchars($newsTitle) ?>"
                    loading="lazy">
                  <div class='card-body'>
                    <h5 class='card-title mb-1'><?= htmlspecialchars($newsTitle) ?></h5>
                    <p class='card-text text-muted small mb-2'><?= htmlspecialchars($newsSubtitle) ?></p>
                    <p class='card-text'><small class='text-muted'>Publicado em: <?= htmlspecialchars($publicationDate) ?></small></p>
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
  <?php require_once BASE_PATH . 'includes/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>