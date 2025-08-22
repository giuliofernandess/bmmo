<?php
    $idMusician = $_POST['idMusician'];

    $connect = mysqli_connect('localhost', 'root', '', 'bmmo') or die('Erro de conexão'. mysqli_connect_error());

    $sql = "SELECT * FROM `musicians` WHERE idMusician = '$idMusician'";

    $result = $connect->query($sql);

    $res = $result -> fetch_array();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Músico</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="css/register.css">
  <script src="js/jquery.js"></script>
  <link
    rel="shortcut icon"
    href="images/logo_banda.png"
    type="image/x-icon"
  />

  <style>
    .delete-music {
        background-color: red;
    }
  </style>
</head>
<body>
    <a href="musicians.php" class="back-button">Voltar</a>

  <main>
    <!-- Form Container -->
    <div class="form-container mt-5">
      <h1 class="form-title text-center">Editar Músico</h1>
      <form method="post" action="validateEditMusician.php" class="form-box row g-3">

        <!-- Nome -->
        <div class="col-md-8">
          <label for="name" class="form-label">Nome</label>
          <input type="text" class="form-control" name="name" id="name" value="<?php echo $res['name'] ?>" disabled />
        </div>

        <!-- Instrumento -->
        <div class="col-md-4">
          <label for="instrument" class="form-label">Instrumento</label>
          <select name="instrument" id="instrument" class="form-select">
            <option value="<?php echo $res['instrument'] ?>">Selecione</option>
            <option value="Flauta">Flauta</option>
            <option value="1 Clarinet">1° Clarinete</option>
            <option value="2 Clarinet">2° Clarinete</option>
            <option value="3 Clarinet">3° Clarinete</option>
            <option value="1 Alto Sax">1° Sax Alto</option>
            <option value="2 Alto Sax">2° Sax Alto</option>
            <option value="1 Tenor Sax">1° Sax Tenor</option>
            <option value="2 Tenor Sax">2° Sax Tenor</option>
            <option value="1 Trumpet">1° Trompete</option>
            <option value="2 Trumpet">2° Trompete</option>
            <option value="3 Trumpet">3° Trompete</option>
            <option value="1 Trombone">1° Trombone</option>
            <option value="2 Trombone">2° Trombone</option>
            <option value="3 Trombone">3° Trombone</option>
            <option value="Euphonium">Bombardino</option>
            <option value="Tuba">Tuba</option>
            <option value="Percussion">Percussão</option>
          </select>
        </div>

        <!-- Telefone + Responsável -->
        <div class="col-md-6">
          <label for="tel" class="form-label">Contato do Músico</label>
          <input type="text" class="form-control" name="telephone" id="tel" value="<?php echo $res['telephone'] ?>"/>
        </div>
        <div class="col-md-6">
          <label for="responsible" class="form-label">Responsável</label>
          <input type="text" class="form-control" name="responsible" id="responsible" value="<?php echo $res['responsible'] ?>"/>
        </div>

        <!-- Contato do responsável -->
        <div class="col-md-6">
          <label for="contactOfResponsible" class="form-label">Contato do Responsável</label>
          <input type="text" class="form-control" name="contactOfResponsible" id="contactOfResponsible" value="<?php echo $res['telephoneOfResponsible'] ?>" />
        </div>

        <!-- Bairro + Instituição -->
        <div class="col-md-6">
          <label for="neighborhood" class="form-label">Bairro</label>
          <select name="neighborhood" id="neighborhood" class="form-select" >
            <option value="<?php echo $res['neighborhood'] ?>">Selecione</option>
            <option value="Boa Esperança">Boa Esperança</option>
            <option value="Centro">Centro</option>
            <option value="Croatá">Croatá</option>
            <option value="Curupira">Curupira</option>
            <option value="Novo Horizonte">Novo Horizonte</option>
            <option value="Placa de Ocara">Placa de Ocara</option>
            <option value="Placa José Pereira">Placa José Pereira</option>
            <option value="São Marcos">São Marcos</option>
            <option value="São Pedro">São Pedro</option>
            <option value="Sereno">Sereno</option>
            <option value="Outro">Outro</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="institution" class="form-label">Instituição</label>
          <input type="text" class="form-control" name="institution" id="institution" value="<?php echo $res['institution'] ?>" />
        </div>

        <!-- Senha + Confirmar senha -->
        <div class="col-md-6">
          <label for="password" class="form-label">Senha</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Digite a nova senha" minlength="8" maxlength="20" />
        </div>
        <div class="col-md-6">
          <label for="confirmPassword" class="form-label">Confirmar Senha</label>
          <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirme a nova senha" />
        </div>

        <!-- Botão de cadastrar -->
        <div class="col-md-12">
            <input type='hidden' name='idMusician' value='<?php echo $res['idMusician'] ?>'>
            <button type="submit" class="btn btn-primary w-100">Editar Músico</button>
        </div>        

      </form>

      <form action="validateDeleteMusic.php" method="post">
            <div class="col-md-12 mt-2">
            <input type='hidden' name='idMusician' value='<?php echo $res['idMusician'] ?>'>
            <button type="submit" class="btn btn-danger w-100">Deletar Músico</button>
            </div>
        </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script>
    $("#tel").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
    $("#contactOfResponsible").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
  </script>
</body>
</html>
