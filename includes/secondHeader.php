<header class="d-flex align-items-center justify-content-between px-3 bg-primary">
    <a href="<?= BASE_URL ?><?= $_SESSION['musician_login'] ? 'pages/MusicianSession/musicianPage.php' : 'pages/AdmSession/admPage.php';?>" class="d-flex align-items-center text-white text-decoration-none">
        <img src="<?= BASE_URL ?>assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
        <span class="fs-5 fw-bold"><?= $_SESSION['musician_login'] ? 'BMMO Online - Músico' : 'BMMO Online - Maestro';?></span>
    </a>

    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a href="#" class="nav-link text-white" onclick="safeBack(); return false;" style="font-size: 1.4rem;">
                    <i class="bi bi-arrow-90deg-left"></i>
                </a>
            </li>
        </ul>
    </nav>
</header>

<!-- Script para validação do botão back -->
<script>

const currentPage = location.pathname;

const lastPage = sessionStorage.getItem("lastPage");

sessionStorage.setItem("lastPage", currentPage);

function safeBack() {

    const last = sessionStorage.getItem("lastPage");

    if (!last) {
        history.back();
        return;
    }

    const file = last.split("/").pop();

    if (file.includes("validate") || last.includes("?")) {
        return;
    }

    history.back();
}

</script>