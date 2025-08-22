<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Músico</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <script src="js/jquery.js"></script>
  <link
    rel="shortcut icon"
    href="images/logo_banda.png"
    type="image/x-icon"
  />
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background-color: #F2F2F2;
      font-family: "Segoe UI", Arial, sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      margin: 20px auto;
      background: #fff;
      padding: 20px;
      max-width: 95%;
      border-radius: 12px;
      width: 100%;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .form-title {
      text-align: center;
      margin-bottom: 20px;
      color: #0d47a1;
      font-weight: bold;
    }

    .form-label {
      font-weight: 600;
      color: #0d47a1;
    }

    @media (min-width: 768px) {
      .form-container {
        padding: 30px;
        max-width: 900px;  
      }
    }
  </style>
</head>
<body>
  <a href="admPage.php" class="back-button">Voltar</a>

  <main>
    <!-- Form Container -->
    <div class="form-container mt-5">
      <h1 class="form-title text-center">Cadastrar Músico</h1>
      <form method="post" action="validateMusicianRegister.php" class="form-box row g-3">

        <!-- Nome + Data de nascimento -->
        <div class="col-md-8">
          <label for="name" class="form-label">Nome</label>
          <input type="text" class="form-control" name="name" id="name" placeholder="Nome do músico" required />
        </div>
        <div class="col-md-4">
          <label for="date" class="form-label">Data de Nascimento</label>
          <input type="date" class="form-control" name="dateOfBirth" id="date" required />
        </div>

        <!-- Instrumento + Ano de admissão -->
        <div class="col-md-6">
          <label for="instrument" class="form-label">Instrumento</label>
          <select name="instrument" id="instrument" class="form-select" required>
            <option value="">Selecione</option>
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

        <div class="col-md-6">
          <label for="year" class="form-label">Ano de Admissão</label>
          <input type="number" class="form-control" name="yearOfAdmission" id="year" placeholder="Ano de ingresso" required />
        </div>

        <!-- Telefone + Responsável -->
        <div class="col-md-6">
          <label for="tel" class="form-label">Contato do Músico</label>
          <input type="text" class="form-control" name="telephone" id="tel" required />
        </div>
        <div class="col-md-6">
          <label for="responsible" class="form-label">Responsável</label>
          <input type="text" class="form-control" name="responsible" id="responsible" placeholder="Nome do responsável" />
        </div>

        <!-- Contato do responsável -->
        <div class="col-md-6">
          <label for="contactOfResponsible" class="form-label">Contato do Responsável</label>
          <input type="text" class="form-control" name="contactOfResponsible" id="contactOfResponsible" placeholder="Contato do responsável" />
        </div>

        <!-- Bairro + Instituição -->
        <div class="col-md-6">
          <label for="neighborhood" class="form-label">Bairro</label>
          <select name="neighborhood" id="neighborhood" class="form-select" required>
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
          <label for="institution" class="form-label">Instituição</label>
          <input type="text" class="form-control" name="institution" id="institution" placeholder="Escola, faculdade ou emprego" />
        </div>

        <!-- Senha + Confirmar senha -->
        <div class="col-md-6">
          <label for="password" class="form-label">Senha</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Digite a senha" required minlength="8" maxlength="20" />
        </div>
        <div class="col-md-6">
          <label for="confirmPassword" class="form-label">Confirmar Senha</label>
          <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirme a senha" required />
        </div>

        <!-- Botão de cadastrar -->
        <div class="col-12">
          <button type="submit" class="btn btn-primary w-100">Cadastrar Músico</button>
        </div>

      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script>
    $("#tel").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
    $("#contactOfResponsible").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
 
