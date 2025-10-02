<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Partituras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../../../assets/images/logo_banda.png" type="image/x-icon">
  </head>
  <body>
    <h1>Lista de partituras</h1>

    <?php
    
      $connect = mysqli_connect('localhost', 'root', '', 'bmmo'); 
        if (!$connect) { 
          die('Erro de conexão: ' . mysqli_connect_error()); 
        }
           $sql = "SELECT * FROM musical_scores ORDER BY musicalGenre ASC, name ASC";
           $result = $connect->query($sql);

           if ($result && $result -> num_rows > 0) { 
            $res = $result->fetch_assoc();
            $name = "";
            $musicalGenre = $res['musicalGenre'];
            echo "<h2>$musicalGenre</h2>";
            while ($result && $result -> num_rows > 0) { 
              if ($musicalGenre != $res['musicalGenre']) {
                echo "<h2>$musicalGenre</h2>";
                
                $musicalGenre = $res['musicalGenre'];
              }
              if ($name != $res['name']) {
                  echo "<a href='MusicalScoresEdit/musicalScoreEdit.php'>{$res['name']}</a>";

                  $name = $res['name'];
              }
            }
           }
    
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
