<?php
require_once '../../../../general-features/bdConnect.php';

session_start();

if (!isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../../../Index/index.php'>";
}

if (!$connect) {
  die("Erro na conexão com o banco de dados.");
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Repertórios</title>
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

  <main class="p-5">
    <!-- Título -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="mb-0 text-primary">Próximas tocatas</h1>
    </div>

    <!-- Cards -->
    <div class="row g-3">
        <?php
        $sql = "SELECT * FROM repertoire ORDER BY date ASC, hour ASC";
        $result = $connect->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($res = $result->fetch_assoc()) {
        ?>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">

                    <h5 class="card-title"><?= htmlspecialchars($res['presentationName']) ?></h5>

                    <p class="mb-1"><strong>Data:</strong> <?= $res['date'] ?></p>
                    <p class="mb-1"><strong>Horário:</strong> <?= $res['hour'] ?></p>
                    <p class="mb-1"><strong>Local:</strong> <?= $res['local'] ?></p>

                    <p class="mb-1"><strong>Grupo(s):</strong><br>
                        <?= str_replace('-', '<br>', $res['bandGroup']) ?>
                    </p>

                    <p class="mb-1"><strong>Músicas:</strong><br>
                        <?= str_replace('-', '<br>', $res['songs']) ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<p>Nenhuma tocata cadastrada.</p>";
        }
        ?>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once '../../../../general-features/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>