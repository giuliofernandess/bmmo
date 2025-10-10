<?php
require_once '../../../../../general-features/bdConnect.php';

session_start();

$idMusician = $_GET['idMusician'];

if (!$connect) {
    die("Erro na conexão com o banco de dados.");
}

$sql = "SELECT * FROM `musicians` WHERE idMusician = '$idMusician'";
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
    <title>Perfil do Músico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../../../../../assets/images/logo_banda.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../../../assets/css/style.css">
  </head>
  <body>
    <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../bandGroups.php" class="nav-link text-white" style="font-size: 1.4rem;"><i class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main class="flex-fill py-5">
  <div class="container">
    <div class="card shadow mx-auto" style="max-width: 800px;">
      <div class="row g-0">
        <!-- Imagem -->
        <div class="col-md-4 text-center bg-secondary">
          <img src="../../../../../assets/images/musicians-images/<?php if ($res['image'] == "") {
            echo 'default.png';
          } else {
            echo $res['image'];
          } ?>" 
               class="img-fluid rounded-start h-100 object-fit-cover" 
               alt="Imagem de <?php echo htmlspecialchars($res['name']) ?>">
        </div>

        <!-- Dados do músico -->
        <div class="col-md-8">
          <div class="card-body d-flex flex-column h-100">
            <h4 class="card-title mb-3"><?php echo htmlspecialchars($res['name']); ?></h4>

            <ul class="list-group list-group-flush mb-4">
              <li class="list-group-item"><strong>Instrumento:</strong> <?php echo htmlspecialchars($res['instrument']); ?></li>
              <li class="list-group-item"><strong>Grupo:</strong> <?php echo htmlspecialchars($res['bandGroup']); ?></li>
              <li class="list-group-item"><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($res['dateOfBirth']); ?></li>
              <li class="list-group-item"><strong>Telefone:</strong> <?php echo htmlspecialchars($res['telephone']); ?></li>
              <li class="list-group-item"><strong>Bairro:</strong> <?php echo htmlspecialchars($res['neighborhood']); ?></li>
            </ul>

            <!-- Botões de ação -->
            <div class="mt-auto d-flex justify-content-end gap-2">
              <a href="MusicianEdit/musicianEdit.php?idMusician=<?php echo $res['idMusician']; ?>" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Editar
              </a>
              <form action="MusicianEdit/MusicianDelete/validateMusicianDelete.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este músico?');">
                <input type="hidden" name="idMusician" value="<?php echo $res['idMusician']; ?>">
                <button type="submit" class="btn btn-danger">
                  <i class="bi bi-trash"></i> Excluir
                </button>
              </form>
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>