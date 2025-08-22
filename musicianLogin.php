<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BMMO Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon" />
  <link rel="stylesheet" href="css/form.css">
</head>

<body>

  <!-- Header -->
  <header>
    <nav class="navbar bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand text-white d-flex align-items-center" href="index.php">
          <img src="images/logo_banda.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top me-2" />
          BMMO Online
        </a>
      </div>
    </nav>
  </header>

  <!-- Main -->
  <main>
    <form action="validateMusicianLogin.php" method="post" novalidate>
      <div class="mb-3">
        <label for="loginMusic" class="form-label">Login</label>
        <input type="text" class="form-control" name="login" id="loginMusic" required />
      </div>

      <div class="mb-3">
        <label for="passwordMusic" class="form-label">Senha</label>
        <input type="password" class="form-control" name="password" id="passwordMusic" required />
      </div>

      <button type="submit" class="btn btn-primary w-100">Acessar</button>
    </form>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container-fluid bg-primary text-white text-center py-2">
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
          <a href="/" class="mb-3 me-2 mb-md-0 text-white text-decoration-none lh-1">
            <img src="images/logo_mosa.png" width="30" height="24" />
          </a>
          <span class="mb-3 mb-md-0 text-white">&copy; EEEP Maria Môsa da Silva</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
          <li class="ms-3">
            <a class="text-white" href="#">
              <img src="images/brasao-ceara.png" width="24" height="24" />
            </a>
          </li>
          <li class="ms-3">
            <a class="text-white" href="#">
              <img src="images/logo_banda.png" width="24" height="24" />
            </a>
          </li>
          <li class="ms-3">
            <a class="text-white" href="#">
              <svg class="bi" width="24" height="24">
                <use xlink:href="#facebook" />
              </svg>
            </a>
          </li>
        </ul>
      </footer>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
