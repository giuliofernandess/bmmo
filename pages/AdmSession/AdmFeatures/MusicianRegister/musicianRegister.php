<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Músico</title>

  <!-- Estilos principais -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon" />
  <link rel="stylesheet" href="../../../../assets/css/style.css">
  <link rel="stylesheet" href="../../../../assets/css/form.css">
  <style>
    main {
      padding: 0 30px
    }

    .login-container {
      max-width: 1000px;
    }

    select.form-control {
      padding: 0 0 0 12px;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../admPage.php" class="nav-link text-white" style="font-size: 1.4rem;"><i class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">
    <div class="container login-container">
      <h1 class="text-center mb-4">Cadastrar Músico</h1>
      <form method="post" action="validateMusicianRegister.php" enctype="multipart/form-data" class="row g-3">

        <!-- Nome + Login + Nascimento -->
        <div class="col-md-6">
          <label for="name" class="form-label ps-2">Nome *</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Nome do músico" required />
        </div>

        <div class="col-md-6">
          <label for="login" class="form-label ps-2">Login *</label>
          <input type="text" name="login" id="login" class="form-control" placeholder="Login do músico" required />
        </div>

        <div class="col-md-6">
          <label for="date" class="form-label ps-2">Data de Nascimento *</label>
          <input type="date" name="dateOfBirth" id="date" class="form-control" required />
        </div>

        <!-- Instrumento + Grupo -->
        <div class="col-md-6">
          <label for="instrument" class="form-label ps-2">Instrumento *</label>
          <select name="instrument" id="instrument" class="form-control select" required>
            <option value="">Selecione</option>
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

        <div class="col-md-6">
          <label for="group" class="form-label ps-2">Grupo da Banda *</label>
          <select name="bandGroup" id="group" class="form-control" required>
            <option value="">Selecione</option>
            <option value="Banda Principal">Banda Principal</option>
            <option value="Banda Auxiliar">Banda Auxiliar</option>
            <option value="Escola">Escola de Música</option>
            <option value="Fanfarra">Fanfarra</option>
            <option value="Flauta Doce">Flauta Doce</option>
          </select>
        </div>

        <!-- Contatos -->
        <div class="col-md-6">
          <label for="tel" class="form-label ps-2">Contato do Músico *</label>
          <input type="text" name="telephone" id="tel" class="form-control" placeholder="(xx) xxxxx-xxxx" required />
        </div>

        <div class="col-md-6">
          <label for="responsible" class="form-label ps-2">Responsável</label>
          <input type="text" name="responsible" id="responsible" class="form-control" placeholder="Nome do responsável" />
        </div>

        <div class="col-md-6">
          <label for="contactOfResponsible" class="form-label ps-2">Contato do Responsável</label>
          <input type="text" name="contactOfResponsible" id="contactOfResponsible" class="form-control" placeholder="(xx) xxxxx-xxxx" />
        </div>

        <!-- Bairro + Instituição -->
        <div class="col-md-6">
          <label for="neighborhood" class="form-label ps-2">Bairro *</label>
          <select name="neighborhood" id="neighborhood" class="form-control" required>
            <option value="">Selecione</option>
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
          <label for="institution" class="form-label ps-2">Instituição</label>
          <input type="text" name="institution" id="institution" class="form-control" placeholder="Escola, faculdade ou emprego" />
        </div>

        <!-- Upload -->
        <div class="col-md-6">
          <label for="file" class="form-label ps-2">Imagem do músico</label>
          <input type="file" name="file" id="inputFile" accept="image/*" class="form-control" />
        </div>

        <!-- Senhas -->
        <div class="col-md-6">
          <label for="password" class="form-label ps-2">Senha *</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Digite a senha" required minlength="8" maxlength="20" />
        </div>

        <div class="col-md-6">
          <label for="confirmPassword" class="form-label ps-2">Confirmar Senha *</label>
          <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirme a senha" required />
        </div>

        <!-- Botão -->
        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100">Cadastrar Músico</button>
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
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#tel").mask("(00) 00000-0000");
      $("#contactOfResponsible").mask("(00) 00000-0000");
    });
  </script>
</body>
</html>
