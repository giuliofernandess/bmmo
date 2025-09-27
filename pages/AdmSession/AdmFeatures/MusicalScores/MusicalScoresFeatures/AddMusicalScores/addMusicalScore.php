<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Adicionar Partitura</title>
  <script src="../../../../../../js/jquery.js"></script>
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

  <a href="../../musicalScores.php">Voltar</a>

  <main>
    <div>
      <form method="post" action="validateAddMusicalScore.php" enctype="multipart/form-data">

        <!-- Nome + Instrumento -->
        <div>
          <label for="name">Nome *</label>
          <input type="text" name="name" id="name" placeholder="Nome da partitura" required />
        </div>

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

        <!-- Grupo pertencente + Tipo de Música -->
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

        <div>
          <label for="musicalGenre">Categoria *</label>
          <select name="musicalGenre" id="musicalGenre" required>
            <option value="">Selecione</option>
            <option value="Carnaval">Carnaval</option>
            <option value="Datas Comemorativas">Datas Comemorativas</option>
            <option value="Dobrados">Dobrados</option>
            <option value="Festa Junina">Festa Junina</option>
            <option value="Hinos">Hinos</option>
            <option value="Infantil">Infantil</option>
            <option value="Internacionais">Internacionais</option>
            <option value="Medleys">Medleys</option>
            <option value="Nacionais">Nacionais</option>
            <option value="Natal">Natal</option>
            <option value="Religiosas">Religiosas</option>
            <option value="Outras">Outras</option>
          </select>
        </div>

        <!-- Arquivo -->
        <div>
          <label for="inputFile">Arquivo *</label>
          <input type="file" name="file" id="inputFile" accept="application/pdf" required>
        </div>

        <!-- Botão de adicionar -->
        <div>
          <button type="submit">Adicionar Partitura</button>
        </div>

      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>
</html>
