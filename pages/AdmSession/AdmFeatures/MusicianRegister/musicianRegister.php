<!DOCTYPE html>
<html lang="pt-br">
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
</head>
<body>
  <a href="../../admPage.php" class="back-button">Voltar</a>

  <main>
    <!-- Form Container -->
    <div>
      <form method="post" action="validateMusicianRegister.php">

        <!-- Nome +  Login + Data de nascimento -->
        <div>
          <label for="name">Nome *</label>
          <input type="text"name="name" id="name" placeholder="Nome do músico" required />
        </div>
        <div>
          <label for="login">Login *</label>
          <input type="text" name="login" id="login" placeholder="Login do músico" required />
        </div>
        <div>
          <label for="date">Data de Nascimento *</label>
          <input type="date" name="dateOfBirth" id="date" required />
        </div>

        <!-- Instrumento + Grupo pertencente -->
        <div>
          <label for="instrument">Instrumento *</label>
          <select name="instrument" id="instrument" required>
            <option value="">Selecione</option>
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

        <div>
          <label for="group">Grupo da Banda *</label>
          <select name="bandGroup" id="group" required>
            <option value="">Selecione</option>
            <option value="Banda Principal">Banda Principal</option>
            <option value="Banda Auxiliar">Banda Auxiliar</option>
            <option value="Escola">Escola de Música</option>
            <option value="Fanfarra">Fanfarra</option>
            <option value="Flauta Doce">Flauta Doce</option>
          </select>
        </div>

        <!-- Telefone + Responsável -->
        <div>
          <label for="tel">Contato do Músico *</label>
          <input type="text" name="telephone" id="tel" required />
        </div>
        <div>
          <label for="responsible">Responsável</label>
          <input type="text" name="responsible" id="responsible" placeholder="Nome do responsável" />
        </div>

        <!-- Contato do responsável -->
        <div>
          <label for="contactOfResponsible">Contato do Responsável</label>
          <input type="text" name="contactOfResponsible" id="contactOfResponsible" placeholder="Contato do responsável" />
        </div>

        <!-- Bairro + Instituição -->
        <div>
          <label for="neighborhood">Bairro *</label>
          <select name="neighborhood" id="neighborhood" required>
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
        <div>
          <label for="institution">Instituição</label>
          <input type="text" name="institution" id="institution" placeholder="Escola, faculdade ou emprego" />
        </div>

        <!-- Senha + Confirmar senha -->
        <div>
          <label for="password">Senha *</label>
          <input type="password" name="password" id="password" placeholder="Digite a senha" required minlength="8" maxlength="20" />
        </div>
        <div>
          <label for="confirmPassword">Confirmar Senha *</label>
          <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirme a senha" required />
        </div>

        <!-- Botão de cadastrar -->
        <div>
          <button type="submit">Cadastrar Músico</button>
        </div>

      </form>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script>
    $(document).ready(function(){
      $("#tel").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
      $("#contactOfResponsible").mask("(00) 00000-0000", { placeholder: "(00) 00000-0000" });
    });
  </script>

 </body>
</html>
