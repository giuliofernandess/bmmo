<nav class="navbar navbar-expand-md navbar-dark fixed-top">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>pages/index.php">
            <img src="<?= BASE_URL ?>assets/images/logo_banda.png" width="30" height="30" class="me-2">
            <span class="fw-bold">BMMO Online</span>
        </a>

        <!-- Botão oficial do Bootstrap -->
        <button class="navbar-toggler border-0 shadow-none d-md-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>


        <!-- Menu Desktop -->
        <div class="collapse navbar-collapse justify-content-end d-none d-md-flex">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= BASE_URL ?>pages/index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= BASE_URL ?>pages/Information/News/news.php">Notícias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white"
                        href="<?= BASE_URL ?>pages/Information/AboutTheBand/aboutTheBand.php">Sobre</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

<!-- Off canvas mobile -->
<div class="offcanvas offcanvas-end bg-white text-dark d-md-none"
     tabindex="-1"
     id="offcanvasNavbar">

  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title fw-semibold text-primary">
      Menu
    </h5>
    <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
    </button>
  </div>

  <div class="offcanvas-body">

    <ul class="navbar-nav gap-2">

      <li class="nav-item">
        <a class="nav-link rounded px-3 py-2 text-dark"
           href="<?= BASE_URL ?>pages/index.php">
          <i class="bi bi-house-door me-2 text-primary"></i>Início
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded px-3 py-2 text-dark"
           href="<?= BASE_URL ?>pages/Information/News/news.php">
          <i class="bi bi-newspaper me-2 text-primary"></i>Notícias
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded px-3 py-2 text-dark"
           href="<?= BASE_URL ?>pages/Information/AboutTheBand/aboutTheBand.php">
          <i class="bi bi-info-circle me-2 text-primary"></i>Sobre
        </a>
      </li>

    </ul>

  </div>
</div>
