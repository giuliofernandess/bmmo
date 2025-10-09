<?php
    require_once '../../../../../general-features/bdConnect.php';

    if (!isset($_POST['idMusician']) || !is_numeric($_POST['idMusician'])) {
        die('ID do músico inválido.');
    }

    $idMusician = intval($_POST['idMusician']);

    $stmt = $connect->prepare("SELECT * FROM musicians WHERE idMusician = ?");
    $stmt->bind_param("i", $idMusician);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('Músico não encontrado.');
    }

    $res = $result->fetch_array(MYSQLI_ASSOC);

    $stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Músico</title>
  <script src="../../../../../js/jquery.js"></script>
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

  <a href="../musicians.php">Voltar</a>

  <main>
    <!-- Formulário -->
    <div>
      <form method="post" action="validateMusicianEdit.php">

        <!-- Nome -->
        <div>
          <label for="name">Nome</label>
          <input type="text" name="name" id="name" value="<?php echo $res['name'] ?>" disabled />
        </div>

        <!-- Login -->
        <div>
          <label for="login">Login</label>
          <input type="text" name="login" id="login" value="<?php echo $res['login'] ?>" />
        </div>

        <!-- Instrumento -->
        <div>
          <label for="instrument">Instrumento</label>
          <select name="instrument" id="instrument">
            <option value="<?php echo $res['instrument'] ?>">Selecione</option>
            <option value="Flauta Doce">Flauta Doce</option>
            <option value="Flute">Flauta</option>
            <option value="Lira">Lira</option>
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
            <option value="1 Horn">1° Trompa</option>
            <option value="2 Horn">2° Trompa</option>
            <option value="1 Trombone">1° Trombone</option>
            <option value="2 Trombone">2° Trombone</option>
            <option value="3 Trombone">3° Trombone</option>
            <option value="Euphonium">Bombardino</option>
            <option value="Tuba">Tuba</option>
            <option value="Percussion">Percussão</option>
            <option value="Caixa">Caixa</option>
            <option value="Prato">Prato</option>
            <option value="Tarol">Tarol</option>
            <option value="Bumbo">Bumbo</option>
          </select>
        </div>

        <!-- Grupo da Banda -->
        <div>
          <label for="group">Grupo da Banda</label>
          <select name="bandGroup" id="group">
            <option value="">Selecione</option>
            <option value="Banda Principal">Banda Principal</option>
            <option value="Banda Auxiliar">Banda Auxiliar</option>
            <option value="Escola">Escola de Música</option>
            <option value="Fanfarra">Fanfarra</option>
            <option value="Flauta Doce">Flauta Doce</option>
          </select>
        </div>

        <!-- Contato do Músico -->
        <div>
          <label for="tel">Contato do Músico</label>
          <input type="text" name="telephone" id="tel" value="<?php echo $res['telephone'] ?>" />
        </div>

        <!-- Responsável -->
        <div>
          <label for="responsible">Responsável</label>
          <input type="text" name="responsible" id="responsible" value="<?php echo $res['responsible'] ?>" />
        </div>

        <!-- Contato do Responsável -->
        <div>
          <label for="contactOfResponsible">Contato do Responsável</label>
          <input type="text" name="contactOfResponsible" id="contactOfResponsible" value="<?php echo $res['telephoneOfResponsible'] ?>" />
        </div>

        <!-- Bairro -->
        <div>
          <label for="neighborhood">Bairro</label>
          <select name="neighborhood" id="neighborhood">
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

        <!-- Instituição -->
        <div>
          <label for="institution">Instituição</label>
          <input type="text" name="institution" id="institution" value="<?php echo $res['institution'] ?>" />
        </div>

        <!-- Senhas -->
        <div>
          <label for="password">Senha</label>
          <input type="password" name="password" id="password" placeholder="Digite a nova senha" minlength="8" maxlength="20" />
        </div>
        <div>
          <label for="confirmPassword">Confirmar Senha</label>
          <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirme a nova senha" />
        </div>

        <!-- Botão Editar -->
        <div>
          <input type='hidden' name='idMusician' value='<?php echo $res['idMusician'] ?>'>
          <button type="submit">Editar Músico</button>
        </div>
      </form>

      <!-- Formulário para deletar músico -->
      <form action="MusicianDelete/validateMusicianDelete.php" method="post">
        <div>
          <input type='hidden' name='idMusician' value='<?php echo $res['idMusician'] ?>'>
          <button type="submit">Deletar Músico</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script>
    $("#tel").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
    $("#contactOfResponsible").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
  </script>
</body>
</html>
