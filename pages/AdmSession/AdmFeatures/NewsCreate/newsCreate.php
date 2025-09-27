<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Notícias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
</head>
<body>

  <a href="../../admPage.php">Voltar</a>

  <div>

    <!-- Início Formulário -->
    <form action="validateNewsCreate.php" method="post" enctype="multipart/form-data">

    <!-- Card: Título -->
      <div>
        <label for="newsTitle">Título da notícia *</label>
        <input type="text" name="newsTitle" id="newsTitle" required>
      </div>

      <!-- Card: SubTítulo -->
      <div>
        <label for="newsSubtitle">Subtítulo da notícia *</label>
        <input type="text" name="newsSubtitle" id="newsSubtitle">
      </div>

      <!-- Card: Detalhamento -->
      <div>
        <label for="description">Detalhamento *</label>
        <textarea name="description" id="description" rows="8" required></textarea>
      </div>

      <!-- Card: Arquivo -->
      <div>
        <label for="file">Imagem *</label><br>
        <input type="file" name="file" id="inputFile" accept="image/*">
      </div>

      <!-- Botão: Criar Notícia -->
      <button type="submit">Publicar Notícia</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
