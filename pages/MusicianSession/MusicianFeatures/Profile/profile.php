<?php
require_once '../../../../general-features/bdConnect.php';

session_start();

$login = $_SESSION['login'];

if (!$connect) {
  die("Erro na conexão com o banco de dados.");
}

$sql = "SELECT * FROM `musicians` WHERE login = '$login'";
$result = $connect->query($sql);

if (!$result) {
  die("Erro na consulta: " . $connect->error);
}

$res = $result->fetch_assoc();
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Meu Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link rel="stylesheet" href="../../../../assets/css/style.css">
</head>

<body>
  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Músico</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../musicianPage.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main class="flex-fill d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="card shadow mx-auto my-5" style="max-width: 800px;">
        <div class="row g-0">
          <!-- Imagem -->
          <div class="col-md-4 text-center bg-secondary">
            <img src="../../../../assets/images/musicians-images/<?php if ($res['image'] == "") {
              echo 'default.png';
            } else {
              echo $res['image'];
            } ?>" class="img-fluid rounded-start h-100 object-fit-cover"
              alt="Imagem de <?php echo htmlspecialchars($res['name']) ?>">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h4 class="card-title mb-3"><?php echo htmlspecialchars($res['name']); ?></h4>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Instrumento:</strong>
                  <?php echo htmlspecialchars($res['instrument']); ?></li>
                <li class="list-group-item"><strong>Grupo:</strong> <?php echo htmlspecialchars($res['bandGroup']); ?>
                </li>
                <li class="list-group-item"><strong>Data de Nascimento:</strong>
                  <?php echo htmlspecialchars($res['dateOfBirth']); ?></li>
                <li class="list-group-item"><strong>Telefone:</strong>
                  <?php echo htmlspecialchars($res['telephone']); ?></li>
                <li class="list-group-item"><strong>Bairro:</strong>
                  <?php echo htmlspecialchars($res['neighborhood']); ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>