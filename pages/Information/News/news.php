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
</head>
<body>
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
          <a href="#" class="nav-link text-white">Notícias</a>
        </li>
        <li class="nav-item">
          <a href="../../Information/AboutTheBand/aboutTheBand.php" class="nav-link text-white">Sobre</a>
        </li>
      </ul>
    </nav>
  </header>

<main class="py-5">
  <h1 class="mb-4 text-center">Acompanhe as últimas notícias da banda</h1>
  <div class="container">  
    <section class="row g-4">
        <?php
            // Conexão e Sql
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
                        <form action='expandedNews.php' method='post' class='h-100'>
                            <input type='hidden' name='newsId' value='$id'>
                            <button type='submit' class='btn p-0 w-100 text-start'>
                                <div class='card news-card rounded shadow-sm h-100'>
                                    <img src='../../../assets/images/news-images/$image' class='card-img-top rounded-top news-image' alt='Imagem da notícia'>
                                    <div class='card-body'>
                                        <h5 class='card-title mb-1'>$title</h5>
                                        <p class='card-text text-muted small mb-2'>$subtitle</p>
                                        <p class='card-text'><small class='text-muted'>Publicado em: $date</small></p>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                    ";
                }
            }
        ?>
    </section>
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
