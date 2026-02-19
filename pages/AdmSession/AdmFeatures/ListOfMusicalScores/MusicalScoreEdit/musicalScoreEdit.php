<?php
session_start();

if (!isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../../../../../../../Index/index.php'>";
}

require_once '../../../../../../../general-features/bdConnect.php';

$name = trim($_GET['name']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Partitura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../../../../../assets/images/logo_banda.png" type="image/x-icon" />
  <link rel="stylesheet" href="../../../../../../../assets/css/style.css">
  <link rel="stylesheet" href="../../../../../../../assets/css/form.css">
  <style>
    .form-control, .btn {
      margin-bottom: 10px
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../listOfMusicalScores.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main>
    <!-- Form Container -->
    <div class="container login-container mt-5 mb-5">
      <h1 class="text-center">Editar Partitura</h1>
      <form method="post" action="validateMusicalScoreEdit.php" enctype="multipart/form-data">

        <!-- Nome da partitura -->
        <div class="col-md-12">
          <label for="name" class="form-label">Nome</label>
          <input type="text" name="name" id="name" class="form-control" value="<?php echo $name ?>" disabled />
          <input type="hidden" name="name" value="<?php echo $name ?>" />
        </div>

        <!-- Grupo da banda + Instrumento-->
        <div>
          <label for="group" class="form-label">Grupo da Banda:</label><br>
          <input type="checkbox" name="bandGroup[]" id="group" value="Banda Principal"> Banda Principal<br>
          <input type="checkbox" name="bandGroup[]" id="group" value="Banda Auxiliar"> Banda Auxiliar<br>
          <input type="checkbox" name="bandGroup[]" id="group" value="Escola de Música"> Escola de Música<br>
          <input type="checkbox" name="bandGroup[]" id="group" value="Fanfarra"> Fanfarra<br>
          <input type="checkbox" name="bandGroup[]" id="group" value="Flauta Doce"> Flauta Doce<br>
        </div>

        <div>
          <label for="instrument" class="form-label mt-2">Instrumento</label>
          <select name="instrument" id="instrument" class="form-control select">
            <option value="">Selecione</option>
            <option value="Flauta Doce">Flauta Doce</option>
            <option value="Flauta">Flauta</option>
            <option value="Lira">Lira</option>
            <option value="Clarinete 1">1° Clarinete</option>
            <option value="Clarinete 2">2° Clarinete</option>
            <option value="Clarinete 3">3° Clarinete</option>
            <option value="Sax Alto 1">1° Sax Alto</option>
            <option value="Sax Alto 2">2° Sax Alto</option>
            <option value="Sax Tenor 1">1° Sax Tenor</option>
            <option value="Sax Tenor 2">2° Sax Tenor</option>
            <option value="Trompete 1">1° Trompete</option>
            <option value="Trompete 2">2° Trompete</option>
            <option value="Trompete 3">3° Trompete</option>
            <option value="Trompa 1">1° Trompa</option>
            <option value="Trompa 2">2° Trompa</option>
            <option value="Trombone 1">1° Trombone</option>
            <option value="Trombone 2">2° Trombone</option>
            <option value="Trombone 3">3° Trombone</option>
            <option value="Bombardino">Bombardino</option>
            <option value="Tuba">Tuba</option>
            <option value="Percussão">Percussão</option>
            <option value="Caixa">Caixa</option>
            <option value="Prato">Prato</option>
            <option value="Tarol">Tarol</option>
            <option value="Bumbo">Bumbo</option>
          </select>
        </div>

        <!-- Arquivo -->
        <div>
          <label for="inputFile" class="form-label ps-2">Arquivo</label>
          <input type="file" name="file" id="inputFile" class="form-control" accept="application/pdf">
        </div>

        <!-- Botão de editar -->
        <div class="col-md-12">
          <button type="submit" class="btn btn-primary">Editar Partitura</button>
        </div>

      </form>

      <form action="#" method="post">
        <div>
          <button type="submit" class="btn btn-danger">Deletar Partitura</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once '../../../../../../../general-features/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>

</html>