<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Maestro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
</head>
<body>
  <!-- Header -->
  <a href="../../admPage.php" class="back-button">Voltar</a>

  <!-- Conteúdo -->
  <main>
    <div>
      <!-- Card: Lista de Partituras -->
      <div>
        <a href="MusicalScoresFeatures/ListOfMusicalScores/listOfMusicalScores.php">
              <h5>Lista de Partituras</h5>
              <p>Veja todas as partituras disponíveis</p>
        </a>
      </div>

      <!-- Card: Adicionar Partitura -->
      <div>
        <a href="MusicalScoresFeatures/AddMusicalScores/addMusicalScore.php">
              <h5>Adicionar Partitura</h5>
              <p>Adicione partituras à seus músicos</p>
        </a>
      </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
