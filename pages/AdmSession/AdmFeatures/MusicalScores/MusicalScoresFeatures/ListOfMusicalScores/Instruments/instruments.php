<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<meta http-equiv='refresh' content='0; url=../../../../../../Index/index.php'>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instrumentos</title>
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
</head>
<body>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
