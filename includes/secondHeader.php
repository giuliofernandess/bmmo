<?php $isMusician = isset($_SESSION['musician_login']); ?>

<header class="py-2">
    <div class="container d-flex align-items-center justify-content-between">

        <a href="<?= BASE_URL ?><?= $isMusician ? 'pages/musician/index.php' : 'pages/admin/index.php'; ?>"
            class="d-flex align-items-center text-white text-decoration-none">
            <img src="<?= BASE_URL ?>assets/images/band_logo.png" alt="Logo Banda" width="32" height="32" class="me-2">
            <span class="fs-5 fw-bold"><?= $isMusician ? 'BMMO Online - Músico' : 'BMMO Online - Maestro'; ?></span>
        </a>

        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white header-back-link" id="safe-back-button" aria-label="Voltar">
                        <i class="bi bi-arrow-90deg-left"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<!-- Script para validação do botão back -->
<script>
    window.fallbackPage = "<?= BASE_URL ?><?= $isMusician ? 'pages/musician/index.php' : 'pages/admin/index.php'; ?>";
</script>
<script src="<?= BASE_URL ?>assets/js/verifyBackButton.js"></script>