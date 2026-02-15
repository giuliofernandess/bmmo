<?php
// Carrega config do projeto
require_once '../../../config/config.php';
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sobre</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon">

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/aboutTheBand.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <?php require_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Conteúdo principal -->
  <main class="container my-5">
    <div class="main-container">

      <!-- Título da página -->
      <h1 class="mb-5 text-center fw-bold">
        A história e o legado da Banda de Música Municipal de Ocara Maestro Jairo Cláudio Silveira
      </h1>

      <!-- Primeira seção com imagem histórica -->
      <section class="mb-5">
        <figure class="text-center">
          <img src="<?= BASE_URL ?>assets/images/about-the-band/first_image.jpg"
               alt="Imagem da primeira turma da banda no ano de 2002" class="about-image img-fluid">
          <figcaption>Imagem da primeira turma da banda no ano de 2002</figcaption>
        </figure>
      </section>

      <!-- Segunda seção com texto histórico -->
      <section class="mb-4">
        <p class="fs-6 text-dark">
          A Banda de Música Municipal de Ocara Maestro Jairo Cláudio Silveira foi fundada no ano de 2002 e só foi
          registrada no dia 16 de junho de 2008 pela Lei Nº 569. Com a finalidade de atividades musicais como um fator
          importante para o desenvolvimento social e cultural do ser humano e de ser um espaço de criação e educação
          musical para jovens e adolescentes do município, tendo em vista aptidão musical na região, como também ser uma
          opção musical no contra turno.
        </p>
      </section>

      <!-- Terceira seção: continuidade da tradição e imagem atual -->
      <section class="mb-5">
        <p class="fs-6 text-dark">
          Para que a tradição se mantenha, é necessária a continuidade dos valores, normas e práticas assumidas em
          grupo. Assim, a participação de crianças, jovens e adolescentes neste grupo, além de possibilitar essa
          continuidade, também promove um amadurecimento nessas pessoas, pois é dentro desses grupos que muitos se
          encontram e veem em sua atividade muito mais que uma distração ou uma brincadeira.
        </p>
        <div class="text-center mt-4">
          <picture>
            <img src="<?= BASE_URL ?>assets/images/about-the-band/actually_image.JPG"
                 alt="Imagem do grupo atual da banda" class="about-image img-fluid">
            <figcaption>Imagem atual da Banda de Música</figcaption>
          </picture>
        </div>
      </section>

      <!-- Quarta seção: estrutura atual da banda -->
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
  <?php require_once BASE_PATH . 'includes/footer.php'; ?>

  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
