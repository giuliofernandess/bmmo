<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<meta http-equiv='refresh' content='0; url=../Index/index.php'>";
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
  <link rel="shortcut icon" href="../../assets/images/logo_banda.png" type="image/x-icon">
</head>

<body>

  <main>
    <div>
      <div>

        <!-- Cards -->
        <a href="AdmFeatures/MusicianRegister/musicianRegister.php">
              <h5>Cadastrar Músico</h5>
              <p>Adicione novos músicos à banda.</p>
        </a>
      </div>

      <div>
        <a href="AdmFeatures/ListOfMusicians/musicians.php">
              <h5>Relação de Músicos</h5>
              <p>Veja a lista completa dos integrantes.</p>
        </a>
      </div>

      <div>
        <a href="AdmFeatures/WeeklySchedule/bandGroups.php">
              <h5>Agenda</h5>
              <p>Publique o cronograma semanal.</p>
        </a>
      </div>

      <div>
        <a href="AdmFeatures/MusicalScores/musicalScores.php">
              <h5>Partituras</h5>
              <p>Acesse as partituras da banda.</p>
        </a>
      </div>

      <div>
        <a href="AdmFeatures/NewsCreate/newsCreate.php">
              <h5>Notícias</h5>
              <p>Adicione notícias sobre a banda.</p>
        </a>
      </div>

      <div>
        <a href="../../general-features/logout.php">
              <h5>Sair</h5>
              <p>Encerrar sessão do maestro.</p>
              
        </a>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
