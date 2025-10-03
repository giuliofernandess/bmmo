<?php
    require_once '../../../../../../../general-features/bdConnect.php';

    $name = trim($_POST['musicalScore']);

    $stmt = $connect->prepare("SELECT * FROM musical_scores WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
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
  <link
    rel="shortcut icon"
    href="../../../../../../../assets/images/logo_banda.png"
    type="image/x-icon"
  />
</head>
<body>
  <a href="../listOfMusicalScores.php">Voltar</a>

  <main>
    <!-- Form Container -->
    <div>
      <form method="post" action="validateMusicalScoreEdit.php">

        <!-- Nome da partitura -->
        <div class="col-md-12">
          <label for="name">Nome</label>
          <input type="text" name="name" id="name" value="<?php echo $res['name'] ?>" disabled />
        </div>

        <!-- Grupo da banda + Tipo da música -->
        <div>
          <label for="group">Grupo da Banda</label>
          <select name="bandGroup" id="group">
            <option value="<?php $res['bandGroup'] ?>">Selecione</option>
            <option value="Banda Principal">Banda Principal</option>
            <option value="Banda Auxiliar">Banda Auxiliar</option>
            <option value="Escola">Escola de Música</option>
            <option value="Fanfarra">Fanfarra</option>
            <option value="Flauta Doce">Flauta Doce</option>
          </select>
        </div>

        <div>
          <label for="musicalGenre">Categoria</label>
          <select name="musicalGenre" id="musicalGenre">
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
            <button type="submit">Editar Partitura</button>
        </div>        

      </form>

      <form action="#" method="post">
            <div>
            <button type="submit">Deletar Partitura</button>
            </div>
        </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>
</html>
