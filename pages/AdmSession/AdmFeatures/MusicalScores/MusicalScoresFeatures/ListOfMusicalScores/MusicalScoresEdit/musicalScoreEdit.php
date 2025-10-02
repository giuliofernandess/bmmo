<?php
    require_once '../../../../../../../assets/general-features/bdConnect.php';

    $name = trim($_POST['musicalScore']);

    $stmt = $connect->prepare("SELECT * FROM musical_scores WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('Partitura não encontrada.');
    }

    $res = $result->fetch_array(MYSQLI_ASSOC);

    $stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Partitura</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="css/register.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/edit.css">
  <script src="js/jquery.js"></script>
  <link
    rel="shortcut icon"
    href="images/logo_banda.png"
    type="image/x-icon"
  />
</head>
<body>
  <a href="listOfMusicalScores.php" class="back-button">Voltar</a>

  <!-- Header -->
  <header>
    <h1>Editar Partitura</h1>
  </header>

  <main>
    <!-- Form Container -->
    <div class="form-container mt-5">
      <form method="post" action="validateMusicalScoreEdit.php" class="form-box row g-3">

        <!-- Nome da partitura -->
        <div class="col-md-12">
          <label for="name" class="form-label">Nome</label>
          <input type="text" class="form-control" name="name" id="name" value="<?php echo $res['name'] ?>" disabled />
        </div>

        <!-- Grupo da banda + Tipo da música -->
        <div class="col-md-6">
          <label for="group" class="form-label">Grupo da Banda</label>
          <select name="bandGroup" id="group" class="form-select">
            <option value="<?php $res['bandGroup'] ?>">Selecione</option>
            <option value="Banda Principal">Banda Principal</option>
            <option value="Banda Auxiliar">Banda Auxiliar</option>
            <option value="Escola">Escola de Música</option>
            <option value="Fanfarra">Fanfarra</option>
            <option value="Flauta Doce">Flauta Doce</option>
          </select>
        </div>

        <div class="col-md-6">
          <label for="musicalGenre" class="form-label">Categoria</label>
          <select name="musicalGenre" id="musicalGenre" class="form-select">
            <option value="<?php $res['musicalGenre'] ?>">Selecione</option>
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

        <!-- Botão de editar -->
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary w-100">Editar Músico</button>
        </div>        

      </form>

      <form action="#" method="post">
            <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-danger w-100">Deletar Músico</button>
            </div>
        </form>
    </div>
  </main>

  <footer class="text-center py-3 mt-auto">
    <small>&copy; <?php echo date("Y"); ?> Banda Musical - Maestro</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>
</html>
