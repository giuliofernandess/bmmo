<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sobre</title>
  <link rel="shortcut icon" href="../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/style.css">
  <link rel="stylesheet" href="../css/aboutTheBand.css">
  <style>
    .main-container {
      background-color: #fff;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-dark"
    style="background: rgba(13, 110, 253, 0.95); backdrop-filter: blur(6px); box-shadow: 0 2px 15px rgba(0,0,0,0.15);">
    <div class="container-fluid px-3">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
        <span class="fw-bold">BMMO Online</span>
      </a>

      <!-- Botão hamburguer -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Itens do menu -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white" href="../../Index/index.php">Início</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="../News/news.php">Notícias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Sobre</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <main class="container my-5">
    <div class="main-container">

      <h1 class="mb-5 text-center fw-bold">
        A história e o legado da Banda de Música Municipal de Ocara Maestro Jairo Cláudio Silveira
      </h1>

      <section class="mb-5">
        <figure class="text-center">
          <img src="../../../assets/images/about-the-band/first_image.jpg"
            alt="Imagem da primeira turma da banda no ano de 2002" class="about-image img-fluid">
          <figcaption>Imagem da primeira turma da banda no ano de 2002</figcaption>
        </figure>
      </section>

      <section class="mb-4">
        <p class="fs-6 text-dark">
          A Banda de Música Municipal de Ocara Maestro Jairo Cláudio Silveira foi fundada no ano de 2002 e só foi
          registrada no dia 16 de junho de 2008 pela Lei Nº 569. Com a finalidade de atividades musicais como um fator
          importante para o desenvolvimento social e cultural do ser humano e de ser um espaço de criação e educação
          musical para jovens e adolescentes do município, tendo em vista aptidão musical na região, como também ser uma
          opção musical no contra turno.
        </p>
      </section>

      <section class="mb-5">
        <p class="fs-6 text-dark">
          Para que a tradição se mantenha, é necessária a continuidade dos valores, normas e práticas assumidas em
          grupo. Assim, a participação de crianças, jovens e adolescentes neste grupo, além de possibilitar essa
          continuidade, também promove um amadurecimento nessas pessoas, pois é dentro desses grupos que muitos se
          encontram e veem em sua atividade muito mais que uma distração ou uma brincadeira.
        </p>
        <div class="text-center mt-4">
          <picture>
            <img src="../../../assets/images/about-the-band/second_image.jpg" alt="Imagem do grupo atual da banda"
              class="about-image img-fluid">
            <figcaption>Imagem atual da Banda de Música</figcaption>
          </picture>
        </div>
      </section>

      <section>
        <p class="fs-6 text-dark">
          Atualmente, a Banda de Música Municipal de Ocara Maestro Jairo Cláudio Silveira é subordinada à Secretaria de
          Cultura e Turismo, tendo sua sede no prédio da escola CATAVENTO. Lá, realiza aulas teóricas, práticas e
          ensaios gerais de segunda a sábado nos turnos da manhã, tarde e noite, sob a regência do maestro e professor
          Raul Anderson.
        </p>
      </section>

    </div>
  </main>

  <!-- Footer -->
  <?php require_once '../../../general-features/footer.php'; ?>

  <!-- Hamburguer JS -->
  <script src="../../../js/hamburguer.js"></script>

  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>