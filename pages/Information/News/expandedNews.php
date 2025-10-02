<?php
require_once '../../../general-features/bdConnect.php';

$id = (int)$_POST['newsId'];

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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notícias</title>
  <link rel="shortcut icon" href="../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/style.css">
  <link rel="stylesheet" href="../css/expandedNews.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online</span>
    </a>

    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../Index/index.php" class="nav-link text-white">Início</a>
        </li>
        <li class="nav-item">
          <a href="../../Information/News/news.php" class="nav-link text-white">Notícias</a>
        </li>
        <li class="nav-item">
          <a href="../../Information/AboutTheBand/aboutTheBand.php" class="nav-link text-white">Sobre</a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Conteúdo -->
  <main class="container my-5">
    <div class="row">
      <!-- Notícia Principal -->
      <div class="col-lg-8">
        <article class="card shadow-sm rounded p-4 mb-4 bg-white">
          <h1 class="mb-3 fw-bold"><?php echo htmlspecialchars($res['title']); ?></h1>
          <h5 class="text-muted mb-3 fw-bold"><?php echo htmlspecialchars($res['subtitle']); ?></h5>
          <p class="text-muted small mb-4">Publicado em <?php echo date('d/m/Y', strtotime($res['date'])); ?></p>
          <img src="../../../assets/news-images/<?php echo htmlspecialchars($res['image']); ?>" alt="Imagem da Notícia" class="news-image-main mb-4">
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
            <form action='expandedNews.php' method='post' class='mb-3'>
              <input type='hidden' name='newsId' value='$newsId'>
              <button type='submit' class='btn p-0 w-100 text-start'>
                <div class='card aside-card rounded shadow-sm h-100'>
                  <div class='row g-0'>
                    <div class='col-4'>
                      <img src='../../../assets/news-images/$image' class='img-fluid rounded-start h-100 object-fit-cover' alt='Imagem da notícia'>
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
              </button>
            </form>";
          }
        } else {
          echo "<p class='text-muted'>Nenhuma outra notícia disponível.</p>";
        }
        ?>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="mt-auto py-3">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
      <span>&copy; Banda de Música</span>
      <div class="d-flex gap-3">
        <a href="https://www.instagram.com/bmmooficial" target="_blank"><i class="bi bi-instagram fs-5"></i></a>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
