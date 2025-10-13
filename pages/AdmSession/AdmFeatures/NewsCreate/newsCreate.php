<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Notícias</title>
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../../assets/css/style.css">
  <link rel="stylesheet" href="../../../../assets/css/form.css">
  <style>
    input, textarea {
      margin-bottom: 10px;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../admPage.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main>

    <!-- Início Formulário -->
    <form action="validateNewsCreate.php" method="post" enctype="multipart/form-data" class="container login-container my-5">

      <!-- Card: Título -->
      <div>
        <label for="newsTitle" class="form-label">Título da notícia *</label><br>
        <input type="text" name="newsTitle" id="newsTitle" class="form-control" required>
      </div>

      <!-- Card: SubTítulo -->
      <div>
        <label for="newsSubtitle" class="form-label">Subtítulo da notícia *</label>
        <input type="text" name="newsSubtitle" id="newsSubtitle" class="form-control">
      </div>

      <!-- Card: Detalhamento -->
      <div>
        <label for="description" class="form-label">Detalhamento *</label><br>
        <textarea name="description" id="description" rows="10" class="form-control" style="height: auto" required></textarea>
      </div>

      <!-- Card: Arquivo -->
      <div>
        <label for="file" class="form-label">Imagem *</label><br>
        <input type="file" name="file" id="inputFile" class="form-control" accept="image/*">
      </div>

      <!-- Botão: Criar Notícia -->
      <button type="submit" class="btn btn-primary mt-2">Publicar Notícia</button>
    </form>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>
</body>

</html>