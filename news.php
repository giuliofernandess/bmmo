<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias</title>
    <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
</head>
<body>
    <h1>Acompanhe aqui as notícias da banda</h1>
    <section class="news-container">
        <?php
        
            $conexao = mysqli_connect("localhost", "root", "", "bmmo");

            $sql = "SELECT * FROM news";

            $resultado = $conexao->query($sql);

            while ($res = $resultado->fetch_array()) { 
        
        ?>

        <div class="news">
            <h2 class="news-title"><?php echo $res['title'] ?></h2>
            <h3 class="news-subtitle"><?php echo $res['subtitle'] ?></h3>
        </div>

        <?php } ?>
    </section>
</body>
</html>