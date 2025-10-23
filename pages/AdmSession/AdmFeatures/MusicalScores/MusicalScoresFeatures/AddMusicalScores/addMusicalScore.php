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
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Adicionar Partitura</title>
  <script src="../../../../../../js/jquery.js"></script>
  <link rel="shortcut icon" href="../../../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../../../../assets/css/style.css">
  <link rel="stylesheet" href="../../../../../../assets/css/form.css">
</head>

<body>

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../musicalScores.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">
    <div class="container login-container">
      <h1 class="text-center mb-4">Criar Partitura</h1>
      <form method="post" action="validateAddMusicalScore.php" enctype="multipart/form-data" class="row g-3">

        <!-- Nome + Instrumento -->
        <div>
          <label for="name" class="form-label ps-2">Nome *</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Nome da partitura" required />
        </div>

        <div>
          <label for="instrument" class="form-label ps-2">Instrumento *</label>
          <select name="instrument" id="instrument" class="form-control" required>
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
          </select>
        </div>

        <!-- Grupo pertencente + Tipo de Música -->
        <div>
          <label for="group" class="form-label ps-2">Grupo da Banda *</label>
          <select name="bandGroup" id="group" class="form-control" required>
            <option value="">Selecione</option>
            <option value="Banda Principal">Banda Principal</option>
            <option value="Banda Auxiliar">Banda Auxiliar</option>
            <option value="Escola">Escola de Música</option>
            <option value="Flauta Doce">Flauta Doce</option>
          </select>
        </div>

        <div>
          <label for="musicalGenre" class="form-label ps-2">Categoria *</label>
          <select name="musicalGenre" id="musicalGenre" class="form-control" required>
            <option value="">Selecione</option>
            <option value="Carnaval">Carnaval</option>
            <option value="Datas Comemorativas">Datas Comemorativas</option>
            <option value="Dobrados">Dobrados</option>
            <option value="Festa Junina">Festa Junina</option>
            <option value="Hinos">Hinos</option>
            <option value="Infantil">Infantil</option>
            <option value="Internacionais">Internacionais</option>
            <option value="Medleys">Medleys</option>
            <option value="Nacionais">Nacionais</option>
            <option value="Natal">Natal</option>
            <option value="Religiosas">Religiosas</option>
            <option value="Outras">Outras</option>
          </select>
        </div>

        <!-- Arquivo -->
        <div>
          <label for="inputFile" class="form-label ps-2">Arquivo *</label>
          <input type="file" name="file" id="inputFile" class="form-control" accept="application/pdf" required>
        </div>

        <!-- Botão de adicionar -->
        <div>
          <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100">Adicionar Partitura</button>
        </div>

      </form>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>

</html>