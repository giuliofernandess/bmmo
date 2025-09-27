<?php

$groupId = isset($_POST['id']) ? htmlspecialchars(trim($_POST['id'])) : '';
$day = isset($_POST['day']) ? htmlspecialchars(trim($_POST['day'])) : '';
$dayTitle = isset($_POST['dayTitle']) ? htmlspecialchars(trim($_POST['dayTitle'])) : '';
$dayProgramation = isset($_POST['dayProgramation']) ? htmlspecialchars(trim($_POST['dayProgramation'])) : '';

if (empty($day) || empty($dayTitle)) {
    die('Dados incompletos. Volte e tente novamente.');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar dia</title>
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
</head>
<body>

  <a href="../../bandGroups.php">Voltar</a>

  <div>
    <div>
      <div>
        <h1>Programação de <?php echo htmlspecialchars($dayTitle); ?></h1>

        <form action="validateDayEdit.php" method="post">
          <div>
            <textarea name="dayProgramation" rows="10" required><?php echo htmlspecialchars($dayProgramation); ?></textarea>
          </div>

          <input type="hidden" name="id" value="<?php echo htmlspecialchars($groupId); ?>">
          <input type="hidden" name="day" value="<?php echo htmlspecialchars($day); ?>">

          <button type="submit">Editar Dia</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
