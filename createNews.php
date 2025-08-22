<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Notícias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
  <link rel="stylesheet" href="css/style.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .form-container {
      max-width: 600px;
      margin: 50px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container h3 {
      background-color: #007bff;
      color: #ffffff;
      padding: 15px;
      border-radius: 8px 8px 0 0;
      text-align: center;
      margin: -30px -30px 30px -30px;
    }

    button {
      width: 100%;
    }
  </style>
</head>
<body>
    <a href="admPage.php" class="back-button">Voltar</a>

  <div class="form-container">
    <h3>Criar Notícia</h3>

    <!-- Início Formulário -->
    <form action="validateCreateNews.php" method="post" enctype="multipart/form-data">

    <!-- Card: Título -->
      <div class="mb-3">
        <label for="newsTitle" class="form-label">Título da notícia</label>
        <input type="text" name="newsTitle" id="newsTitle" class="form-control" required>
      </div>

      <!-- Card: SubTítulo -->
      <div class="mb-3">
        <label for="newsSubtitle" class="form-label">Subtítulo da notícia</label>
        <input type="text" name="newsSubtitle" id="newsSubtitle" class="form-control">
      </div>

      <!-- Card: Detalhamento -->
      <div class="mb-3">
        <label for="description" class="form-label">Detalhamento</label>
        <textarea name="description" id="description" rows="8" class="form-control" required></textarea>
      </div>

      <!-- Card: Arquivo -->
      <div class="mb-4">
        <label for="arquivo" class="form-label">Arquivo</label>
        <input type="file" name="arquivo" id="arquivo" class="form-control">
      </div>

      <!-- Botão: Criar Notícia -->
      <button type="submit" class="btn btn-primary">Publicar Notícia</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
