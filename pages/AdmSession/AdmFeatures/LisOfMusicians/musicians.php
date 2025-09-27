<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <title>Relação de músicos</title>
</head>

<body>
  <a href="../../admPage.php">Voltar</a>
  <div>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Login</th>
          <th>Data de nascimento</th>
          <th>Instrumento</th>
          <th>Grupo</th>
          <th>Telefone</th>
          <th>Responsável</th>
          <th>Telefone do responsável</th>
          <th>Bairro</th>
          <th>Instituição</th>
          <th>Senha</th>
          <th>Editar</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $connect = mysqli_connect('localhost', 'root', '', 'bmmo'); 
        if (!$connect) { 
          die('Erro de conexão: ' . mysqli_connect_error()); 
        }
           $sql = "SELECT * FROM musicians ORDER BY instrument ASC"; 
           $result = $connect->query($sql); 
           if ($result && $result->num_rows > 0) { 
            while ($res = $result->fetch_assoc()) { 
              echo "<tr>"; 
              echo "<td>{$res['name']}</td>"; 
              echo "<td>{$res['login']}</td>"; 
              echo "<td>{$res['dateOfBirth']}</td>"; 
              echo "<td>{$res['instrument']}</td>"; 
              echo "<td>{$res['bandGroup']}</td>"; 
              echo "<td>{$res['telephone']}</td>"; 
              echo "<td>{$res['responsible']}</td>"; 
              echo "<td>{$res['telephoneOfResponsible']}</td>"; 
              echo "<td>{$res['neighborhood']}</td>"; 
              echo "<td>{$res['institution']}</td>"; 
              echo "<td>{$res['password']}</td>"; 
              echo "<td> <form action='MusicianEdit/musicianEdit.php' method='post'> 
              <input type='hidden' name='idMusician' value='{$res['idMusician']}'> 
              <button type='submit'>✏️</button> 
              </form> </td>";
              echo "</tr>"; 
              } 
              } else { 
                echo "<tr><td colspan='12'>Nenhum músico encontrado.</td></tr>"; } $connect->close(); ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
