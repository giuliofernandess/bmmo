<?php

require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

Auth::requireRegency();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Notícias</title>
  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
  
  <style>
    input,
    textarea {
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <!-- Toasts -->
  <?php require BASE_PATH . "includes/sucessToast.php"; ?>
  <?php require BASE_PATH . "includes/errorToast.php"; ?>


  <!-- Header -->
  <?php require BASE_PATH . 'includes/secondHeader.php'; ?>

  <main style="padding: 20px;">

    <!-- Início Formulário -->

    <form action="validateNewsCreate.php" method="post" enctype="multipart/form-data"
      class="container login-container my-5" style="max-width: 800px;">
      <h1 class="text-center mb-4">Adicionar Notícia</h1>

      <!-- Card: Título -->
      <div>
        <label for="news-title" class="form-label">Título da notícia *</label><br>
        <input type="text" name="title" id="news-title" class="form-control" required>
      </div>

      <!-- Card: SubTítulo -->
      <div>
        <label for="news-subtitle" class="form-label">Subtítulo da notícia *</label>
        <input type="text" name="subtitle" id="news-subtitle" class="form-control">
      </div>

      <!-- Card: Detalhamento -->
      <div>
        <label for="news-description" class="form-label">Texto de Detalhamento *</label><br>
        <textarea name="description" id="news-description" rows="10" class="form-control" style="height: auto"
          required></textarea>
      </div>

      <!-- Card: Arquivo -->
      <div>
        <label for="input-file" class="form-label">Imagem *</label><br>
        <input type="file" name="file" id="input-file" class="form-control" accept="image/*" required>
      </div>

      <!-- Botão: Criar Notícia -->
      <button type="submit" class="btn btn-primary mt-2">Publicar Notícia</button>
    </form>
  </main>

  <!-- Footer -->
  <?php require BASE_PATH . 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>

</body>

</html>