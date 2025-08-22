<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BMMO Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">
</head>

<body>
    <header class="bg-primary d-flex align-items-center justify-content-between px-3" style="height: 50px;">
  <a href="#" class="d-flex align-items-center text-white text-decoration-none">
    <img src="images/logo_banda.png" alt="Logo Banda" width="30" height="24" class="me-2">
    <span class="fs-5">BMMO Online</span>
  </a>

  <nav>
    <ul class="nav">
      <li class="nav-item">
        <a href="news.php" class="nav-link text-white fs-6">Notícias</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link text-white fs-6">Sobre</a>
      </li>
    </ul>
  </nav>
</header>

<main>
  <div class="container my-5">
    <div class="introduction-container text-center mx-auto" style="max-width: 75%;">
      <img src="images/logo_banda.png" width="100" height="100" class="mb-3">
      <h1>A Banda Online</h1>
      <p class="fs-5">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni reiciendis repellat nihil labore ab totam culpa et quo! Beatae quod porro, reprehenderit placeat aut accusantium cum magni fugit assumenda illo.
      </p>

      <div class="d-inline-flex gap-3 mb-3">
        <a href="musicianLogin.php" class="btn btn-primary btn-lg rounded-pill px-4">
          Entrar como integrante
        </a>
        <a href="admLogin.php" class="btn btn-outline-info btn-lg rounded-pill px-4">
          Entrar como Maestro
        </a>
      </div>
    </div>
  </div>
</main>


    <footer>
        <div class="container-fluid bg-primary text-white text-center py-2">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <div class="col-md-4 d-flex align-items-center">
                    <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                        <img src="images/logo_mosa.png" width="30" height="24">
                    </a>
                    <span class="mb-3 mb-md-0 text-body-light">&copy; EEEP Maria Môsa da Silva</span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3">
                        <a class="text-body-secondary" href="#">
                            <img src="images/brasao-ceara.png" width="24" height="24">
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="text-body-secondary" href="#">
                            <svg class="bi" width="24" height="24">
                                <use xlink:href="#instagram" />
                            </svg>
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="text-body-secondary" href="#">
                            <svg class="bi" width="24" height="24">
                                <use xlink:href="#facebook" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </footer>
        </div>


    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>