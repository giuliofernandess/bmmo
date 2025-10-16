<?php
require_once '../../../../../../general-features/bdConnect.php';

if (!isset($_GET['idMusician']) || !is_numeric($_GET['idMusician'])) {
  die('ID do músico inválido.');
}

$idMusician = intval($_GET['idMusician']);

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
  <script src="../../../../../../js/jquery.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link rel="stylesheet" href="../../../../../../assets/css/style.css">
  <link rel="stylesheet" href="../../../../../../assets/css/form.css">
  <style>
    main {
      padding: 0 30px
    }

    .login-container {
      max-width: 1000px;
    }

    select.form-control,
    .btn {
      padding: 0 0 0 12px;
    }

    form i.show-password {
      right: 10%;
      bottom: 18.8%;
    }

    @media screen and (min-width: 481px) {
      form i.show-password {
        right: 7%;
        bottom: 18.8%;
      }
    }

    @media screen and (min-width: 768px) {
      form i.show-password {
        left: 45.5%;
        bottom: 21.2%;
      }
    }

    @media screen and (min-width: 993px) {
      form i.show-password {
        left: 46%;
      }
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../musicianProfile.php?idMusician=<?php echo $res['idMusician'] ?>" class="nav-link text-white"
            style="font-size: 1.4rem;"><i class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">
    <!-- Formulário -->
    <div class="container login-container">
      <h1 class="text-center mb-4">Editar Músico</h1>
      <form method="post" action="validateMusicianEdit.php" enctype="multipart/form-data" class="row g-3">

        <!-- Nome -->
        <div class="col-md-6">
          <label for="name" class="form-label ps-2">Nome</label>
          <input type="text" name="name" id="name" value="<?php echo $res['name'] ?>" class="form-control" disabled />
        </div>

        <!-- Login -->
        <div class="col-md-6">
          <label for="login" class="form-label ps-2">Login</label>
          <input type="text" name="login" id="login" value="<?php echo $res['login'] ?>" class="form-control" />
        </div>

        <!-- Instrumento -->
        <div class="col-md-6">
          <label for="instrument" class="form-label ps-2">Instrumento</label>
          <select name="instrument" id="instrument" class="form-control">
            <option value="<?php echo $res['instrument'] ?>">Selecione</option>
            <option value="Flauta Doce">Flauta Doce</option>
            <option value="Flauta">Flauta</option>
            <option value="Lira">Lira</option>
            <option value="Clarinete 1">1° Clarinete</option>
            <option value="Clarinete 2">2° Clarinete</option>
            <option value="Clarinete 3">3° Clarinete</option>
            <option value="Sax Alto 1">1° Sax Alto</option>
            <option value="Sax Alto 2">2° Sax Alto</option>
            <option value="Sax Tenor 1">1° Sax Tenor</option>
            <option value="Sax Tenor 2">2° Sax Tenor</option>
            <option value="Trompete 1">1° Trompete</option>
            <option value="Trompete 2">2° Trompete</option>
            <option value="Trompete 3">3° Trompete</option>
            <option value="Trompa 1">1° Trompa</option>
            <option value="Trompa 2">2° Trompa</option>
            <option value="Trombone 1">1° Trombone</option>
            <option value="Trombone 2">2° Trombone</option>
            <option value="Trombone 3">3° Trombone</option>
            <option value="Bombardino">Bombardino</option>
            <option value="Tuba">Tuba</option>
            <option value="Percussão">Percussão</option>
            <option value="Caixa">Caixa</option>
            <option value="Prato">Prato</option>
            <option value="Tarol">Tarol</option>
            <option value="Bumbo">Bumbo</option>
            <option value="Caixa">Caixa</option>
            <option value="Prato">Prato</option>
            <option value="Tarol">Tarol</option>
            <option value="Bumbo">Bumbo</option>
          </select>
        </div>

        <!-- Grupo da Banda -->
        <div class="col-md-6">
          <label for="group" class="form-label ps-2">Grupo da Banda</label>
          <select name="bandGroup" id="group" class="form-control">
            <option value="<?php echo $res['bandGroup'] ?>">Selecione</option>
            <option value="Banda Principal">Banda Principal</option>
            <option value="Banda Auxiliar">Banda Auxiliar</option>
            <option value="Escola">Escola de Música</option>
            <option value="Fanfarra">Fanfarra</option>
            <option value="Flauta Doce">Flauta Doce</option>
          </select>
        </div>

        <!-- Contato do Músico -->
        <div class="col-md-6">
          <label for="tel" class="form-label ps-2">Contato do Músico</label>
          <input type="text" name="telephone" id="tel" value="<?php echo $res['telephone'] ?>" class="form-control" />
        </div>

        <!-- Responsável -->
        <div class="col-md-6">
          <label for="responsible" class="form-label ps-2">Responsável</label>
          <input type="text" name="responsible" id="responsible" value="<?php echo $res['responsible'] ?>"
            class="form-control" />
        </div>

        <!-- Contato do Responsável -->
        <div class="col-md-6">
          <label for="contactOfResponsible" class="form-label ps-2">Contato do Responsável</label>
          <input type="text" name="contactOfResponsible" id="contactOfResponsible"
            value="<?php echo $res['telephoneOfResponsible'] ?>" class="form-control" />
        </div>

        <!-- Bairro -->
        <div class="col-md-6">
          <label for="neighborhood" class="form-label ps-2">Bairro</label>
          <select name="neighborhood" id="neighborhood" class="form-control">
            <option value="<?php echo $res['neighborhood'] ?>">Selecione</option>
            <option value="Boa Esperança">Boa Esperança</option>
            <option value="Centro">Centro</option>
            <option value="Croatá">Croatá</option>
            <option value="Curupira">Curupira</option>
            <option value="Novo Horizonte">Novo Horizonte</option>
            <option value="Placa de Ocara">Placa de Ocara</option>
            <option value="Placa José Pereira">Placa José Pereira</option>
            <option value="Prainha">Prainha</option>
            <option value="São Marcos">São Marcos</option>
            <option value="São Pedro">São Pedro</option>
            <option value="Sereno">Sereno</option>
            <option value="Outro">Outro</option>
          </select>
        </div>

        <!-- Instituição -->
        <div class="col-md-6">
          <label for="institution" class="form-label ps-2">Instituição</label>
          <input type="text" name="institution" id="institution" value="<?php echo $res['institution'] ?>"
            class="form-control" />
        </div>

        <!-- Upload -->
        <div class="col-md-6">
          <label for="file" class="form-label ps-2">Imagem do músico</label>
          <input type="file" name="file" id="inputFile" accept="image/*" class="form-control"/>
        </div>

        <!-- Senhas -->
        <div class="col-md-6">
          <label for="password" class="form-label ps-2">Senha</label>
          <input type="password" name="password" id="password" placeholder="Digite a nova senha" minlength="8"
            maxlength="20" value="<?php echo $res['password'] ?>" class="form-control" />
        </div>
        <div class="col-md-6">
          <label for="confirmPassword" class="form-label ps-2">Confirmar Senha</label>
          <div>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirme a nova senha"
              class="form-control"  minlength="8" maxlength="20" value="<?php echo $res['password'] ?>" />
            <i class="bi bi-eye-fill show-password" id="passwordBtn" onclick="showPassword()"></i>
          </div>
        </div>

        <!-- Botão Editar -->
        <div class="col-12 mt-3">
          <input type='hidden' name='idMusician' value='<?php echo $res['idMusician'] ?>'>
          <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100">Editar Músico</button>
        </div>
      </form>

      <!-- Formulário para deletar músico -->
      <form action="MusicianDelete/validateMusicianDelete.php" method="post">
        <div class="col-12 mt-3">
          <input type='hidden' name='idMusician' value='<?php echo $res['idMusician'] ?>'>
          <button type="submit" class="btn btn-danger btn-lg rounded-pill w-100">Deletar Músico</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="mt-auto py-3">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
      <span>&copy; Banda de Música</span>
      <div class="d-flex gap-3">
        <a href="https://www.instagram.com/bmmooficial" target="_blank"><i class="bi bi-instagram fs-5"></i></a>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
   <script src="../../../../../../js/password.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script>
    $("#tel").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
    $("#contactOfResponsible").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
  </script>
</body>

</html>