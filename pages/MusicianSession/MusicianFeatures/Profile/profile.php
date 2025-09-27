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
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
  </head>
  <body>
    <a href="../../musicianPage.php">Voltar</a>

  <main>
    <div>
          <p><strong>Nome:</strong> <?php echo htmlspecialchars($res['name']); ?></p>
          <p><strong>Instrumento:</strong> <?php echo htmlspecialchars($res['instrument']); ?></p>
          <p><strong>Grupo:</strong> <?php echo htmlspecialchars($res['bandGroup']); ?></p>
          <p><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($res['dateOfBirth']); ?></p>
          <p><strong>Telefone:</strong> <?php echo htmlspecialchars($res['telephone']); ?></p>
          <p><strong>Bairro:</strong> <?php echo htmlspecialchars($res['neighborhood']); ?></p>
          <p><strong>Instituição:</strong> <?php echo htmlspecialchars($res['institution']); ?></p>
    </div>
  </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>