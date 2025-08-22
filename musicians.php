<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <title>Relação de músicos</title>
  <link rel="stylesheet" href="css/style.css">

  <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f5f5f5;
        margin: 20px;
        color: #333;
    }

    h1 {
        text-align: center;
        color: #0D6EFD;
        margin-bottom: 30px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    th {
        background-color: #0D6EFD;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        vertical-align: middle;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    button {
        background-color: #0DCAF0;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
        transition: background-color 0.3s;
        cursor: pointer;
    }

    button:hover {
        background-color: #0D6EFD;
    }

    form {
        margin: 0;
    }
  </style>
</head>
<body>
  <a href="admPage.php" class="back-button">Voltar</a>

  <h1>Relação de Músicos</h1>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Data de nascimento</th>
          <th>Instrumento</th>
          <th>Ano de Admissão</th>
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

          $sql = "SELECT * FROM `musicians` ORDER BY instrument ASC";
          $result = $connect->query($sql);

          if ($result && $result->num_rows > 0) {
              while ($res = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>{$res['idMusician']}</td>";
                  echo "<td>{$res['name']}</td>";
                  echo "<td>{$res['dateOfBirth']}</td>";
                  echo "<td>{$res['instrument']}</td>";
                  echo "<td>{$res['yearOfAdmission']}</td>";
                  echo "<td>{$res['telephone']}</td>";
                  echo "<td>{$res['responsible']}</td>";
                  echo "<td>{$res['telephoneOfResponsible']}</td>";
                  echo "<td>{$res['neighborhood']}</td>";
                  echo "<td>{$res['institution']}</td>";
                  echo "<td>{$res['password']}</td>";
                  echo "<td>
                          <form action='editMusician.php' method='post'>
                            <input type='hidden' name='idMusician' value='{$res['idMusician']}'>
                            <button type='submit'>✏️</button>
                          </form>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='12'>Nenhum músico encontrado.</td></tr>";
          }

          $connect->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
