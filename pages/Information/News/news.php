<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notícias</title>
  <link rel="shortcut icon" href="../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/style.css">
  <link rel="stylesheet" href="../css/news.css">
  <style>
    .news-card:hover {
      transform: scale(1.01);
      transition: 0.3s ease-in-out;
    }

    .news-image {
      height: 200px;
      object-fit: cover;
    }

    .no-news {
      text-align: center;
      font-size: 1.2rem;
      color: #6c757d;
      margin-top: 2rem;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-dark"
    style="background: rgba(13, 110, 253, 0.95); backdrop-filter: blur(6px); box-shadow: 0 2px 15px rgba(0,0,0,0.15);">
    <div class="container-fluid px-3">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
        <span class="fw-bold">BMMO Online</span>
      </a>

      <!-- Botão hamburguer -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Itens do menu -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white" href="../../Index/index.php">Início</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Notícias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="../AboutTheBand/aboutTheBand.php">Sobre</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="py-5 flex-grow-1">
    <div class="container">
      <h1 class="mb-4 text-center">Acompanhe as últimas notícias da banda</h1>
      <section class="row g-4">
        <?php
        require_once '../../../general-features/bdConnect.php';

        if (!$connect) {
          echo "<div class='alert alert-danger'>Erro ao conectar com o banco de dados.</div>";
          exit;
        }

        $sql = "SELECT * FROM news ORDER BY date DESC";
        $result = $connect->query($sql);

        if (!$result) {
          echo "<div class='alert alert-warning'>Erro ao buscar notícias: " . htmlspecialchars($connect->error) . "</div>";
        } elseif ($result->num_rows === 0) {
          echo "<div class='no-news'>Nenhuma notícia cadastrada no momento.</div>";
        } else {
          while ($res = $result->fetch_array(MYSQLI_ASSOC)) {
            $id = htmlspecialchars($res['id']);
            $title = htmlspecialchars($res['title']);
            $subtitle = htmlspecialchars($res['subtitle']);
            $image = htmlspecialchars($res['image']);
            $date = htmlspecialchars(date('d/m/Y', strtotime($res['date'])));

            echo "
                  <div class='col-md-6 col-lg-4'>
                      <a href='expandedNews.php?id=$id' class='text-decoration-none text-dark'>
                          <div class='card news-card rounded shadow-sm h-100'>
                              <img src='../../../assets/images/news-images/$image' class='card-img-top rounded-top news-image' alt='Imagem da notícia'>
                              <div class='card-body'>
                                  <h5 class='card-title mb-1'>$title</h5>
                                  <p class='card-text text-muted small mb-2'>$subtitle</p>
                                  <p class='card-text'><small class='text-muted'>Publicado em: $date</small></p>
                              </div>
                          </div>
                      </a>
                  </div>
                  ";
          }
        }
        ?>
      </section>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once '../../../general-features/footer.php'; ?>

  <!-- Hamburguer JS -->
  <script src="../../../js/hamburguer.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>