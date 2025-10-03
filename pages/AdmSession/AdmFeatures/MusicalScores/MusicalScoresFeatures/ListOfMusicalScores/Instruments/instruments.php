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
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
</head>
<body>
    <a href="../../admPage.php">Voltar</a>

  <!-- Conteúdo -->
  <main>
    <div>
      <!-- Card: Banda Principal -->
      <form action="WeeklyScheduleEdit/weeklySchedule.php" method="post">
        <input type="hidden" name="bandGroup" value="Banda Principal">
        <button>
          <div>
            <div>
              <h5>Banda Principal</h5>
            </div>
          </div>
        </button>
      </form>

      <!-- Card: Banda Auxiliar -->
      <form action="WeeklyScheduleEdit/weeklySchedule.php" method="post">
        <input type="hidden" name="bandGroup" value="Banda Auxiliar">
        <button>
              <h5>Banda Auxiliar</h5>
        </button>
      </form>

      <!-- Card: Escola de Música -->
      <form action="WeeklyScheduleEdit/weeklySchedule.php" method="post">
        <input type="hidden" name="bandGroup" value="Escola">
        <button>
              <h5>Escola de Música</h5>
        </button>
      </form>

      <!-- Card: Fanfarra -->
      <form action="WeeklyScheduleEdit/weeklySchedule.php" method="post">
        <input type="hidden" name="bandGroup" value="Fanfarra">
        <button>
              <h5>Fanfarra</h5>
        </button>
      </form>

      <!-- Card: Flauta Doce -->
      <form action="WeeklyScheduleEdit/weeklySchedule.php" method="post">
        <input type="hidden" name="bandGroup" value="Flauta Doce">
        <button>
              <h5>Flauta Doce</h5>
        </button>
      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
