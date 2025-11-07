<?php
require_once '../../../general-features/bdConnect.php';

if (!isset($_GET['id'])) {
  die("ID da notícia não fornecido.");
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM news WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$res = $result->fetch_array(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Notícias</title>
  <link rel="shortcut icon" href="../../../assets/images/logo_banda.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../assets/css/style.css" />
  <link rel="stylesheet" href="../css/expandedNews.css" />
  <style>
    .news-image-main {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      border-radius: 0.25rem;
    }

    .aside-card img {
      height: 100%;
      object-fit: cover;
      border-top-left-radius: 0.25rem;
      border-bottom-left-radius: 0.25rem;
    }

    .aside-card {
      transition: transform 0.2s ease-in-out;
    }

    .aside-card:hover {
      transform: scale(1.02);
      text-decoration: none;
    }

    main {
      flex-grow: 1;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-dark mb-auto"
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
            <a class="nav-link text-white" href="../News/news.php">Notícias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="../AboutTheBand/aboutTheBand.php">Sobre</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Conteúdo -->
  <main class="container my-5">
    <div class="row">
      <!-- Notícia Principal -->
      <div class="col-lg-8">
        <article class="card shadow-sm rounded p-4 mb-4 bg-white">
          <h1 class="mb-3 fw-bold"><?php echo htmlspecialchars($res['title']); ?></h1>
          <h5 class="text-muted mb-3 fw-bold"><?php echo htmlspecialchars($res['subtitle']); ?></h5>
          <p class="text-muted small mb-4">Publicado em <?php echo date('d/m/Y', strtotime($res['date'])); ?></p>
          <img src="../../../assets/images/news-images/<?php echo htmlspecialchars($res['image']); ?>"
            alt="Imagem da Notícia" class="news-image-main mb-4" />
          <div class="news-text"><?php echo nl2br(htmlspecialchars($res['text'])); ?></div>
        </article>
      </div>

      <!-- Outras Notícias -->
      <div class="col-lg-4">
        <h4 class="mb-3">Outras notícias</h4>
        <?php
        $sql = "SELECT * FROM news WHERE id != ? ORDER BY id DESC LIMIT 2";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
          while ($news = $result->fetch_array(MYSQLI_ASSOC)) {
            $newsId = htmlspecialchars($news['id']);
            $title = htmlspecialchars($news['title']);
            $subtitle = htmlspecialchars($news['subtitle']);
            $image = htmlspecialchars($news['image']);
            $date = htmlspecialchars(date('d/m/Y', strtotime($news['date'])));
            echo "
            <a href='expandedNews.php?id=$newsId' class='mb-3 text-decoration-none text-dark d-block'>
              <div class='card aside-card rounded shadow-sm h-100'>
                <div class='row g-0'>
                  <div class='col-4'>
                    <img src='../../../assets/images/news-images/$image' class='img-fluid rounded-start' alt='Imagem da notícia' />
                  </div>
                  <div class='col-8'>
                    <div class='card-body'>
                      <h6 class='card-title mb-1'>$title</h6>
                      <p class='card-text small text-muted mb-1'>$subtitle</p>
                      <p class='card-text'><small class='text-muted'>Publicado em: $date</small></p>
                    </div>
                  </div>
                </div>
              </div>
            </a>";
          }
        } else {
          echo "<p class='text-muted'>Nenhuma outra notícia disponível.</p>";
        }
        ?>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once '../../../general-features/footer.php'; ?>

  <!-- Hamburguer JS -->
  <script src="../../../js/hamburguer.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>