<?php
$day = $_POST['day'];
$dayTitle = $_POST['dayTitle'];
$dayProgramation = $_POST['dayProgramation'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar dia</title>
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
  <link rel="stylesheet" href="css/style.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <!-- Estilo interno -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 10px;
    }

    .form-container {
      max-width: 700px;
      margin: 50px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #2c3e50;
      font-size: 24px;
      margin-bottom: 25px;
      text-align: center;
    }

    textarea {
      width: 100%;
      height: 270px;
      padding: 15px;
      font-size: 16px;
      border: 1px solid #2c3e50;
      border-radius: 8px;
      resize: vertical;
      box-sizing: border-box;
    }

    button {
      margin-top: 20px;
      padding: 12px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
    <a href="weeklySchedule.php" class="back-button">Voltar</a>

  <div class="form-container">
    <h1>Programação de <?php echo htmlspecialchars($dayTitle); ?></h1>

    <form action="validateEditDay.php" method="post">
      <div class="mb-3">
        <textarea name="dayProgramation" required><?php echo htmlspecialchars($dayProgramation); ?></textarea>
      </div>

      <!-- Campo oculto para manter o dia selecionado -->
      <input type="hidden" name="day" value="<?php echo htmlspecialchars($day); ?>">

      <button type="submit">Editar Dia</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
