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
  <title>Página do Músico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="shortcut icon" href="../../assets/images/logo_banda.png" type="image/x-icon">
</head>
<body>

  <main>

    <!-- Cards -->
    <div>
      <div>
        <a href="MusicianFeatures/Profile/profile.php">
          <div>
            <div>
              <h5>Meu Perfil</h5>
              <p>Veja suas informações detalhadas.</p>
            </div>
          </div>
        </a>
      </div>

      <div>
        <a href="MusicianFeatures/WeeklySchedule/musicianWeeklySchedule.php">
          <div>
            <div>
              <h5>Agenda</h5>
              <p>Veja o cronograma semanal.</p>
            </div>
          </div>
        </a>
      </div>

      <div>
        <a href="#">
          <div>
            <div>
              <h5>Partituras</h5>
              <p>Acesse as partituras da banda.</p>
            </div>
          </div>
        </a>
      </div>

      <div>
        <a href="../../general-features/logout.php">
          <div>
            <div>
              <h5>Sair</h5>
              <p>Encerrar sessão do músico.</p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
