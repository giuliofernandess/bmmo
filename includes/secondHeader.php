<header class="d-flex align-items-center justify-content-between px-3 bg-primary">
    <?php $isMusician = !empty($_SESSION['musician_login']); ?>

    <a href="<?= BASE_URL ?><?= $isMusician ? 'pages/musician/index.php' : 'pages/admin/index.php'; ?>" class="d-flex align-items-center text-white text-decoration-none">
        <img src="<?= BASE_URL ?>assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
        <span class="fs-5 fw-bold"><?= $isMusician ? 'BMMO Online - Músico' : 'BMMO Online - Maestro'; ?></span>
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

const currentPage = location.pathname + location.search;
const previousPage = sessionStorage.getItem("currentPage");
const fallbackPage = "<?= BASE_URL ?><?= $isMusician ? 'pages/musician/index.php' : 'pages/admin/index.php'; ?>";

if (previousPage) {
    sessionStorage.setItem("lastPage", previousPage);
}

sessionStorage.setItem("currentPage", currentPage);

function isUnsafeBackTarget(urlValue) {

    if (!urlValue) {
        return false;
    }

    let parsed;

    try {
        parsed = new URL(urlValue, window.location.origin);
    } catch (e) {
        return true;
    }

    const pathname = (parsed.pathname || "").toLowerCase();
    const file = (pathname.split("/").pop() || "");

    const receivesGet = parsed.search.length > 0;
    const receivesPost = pathname.includes("/actions/") || /^(create|edit|delete|login)\.php$/.test(file);

    return receivesGet || receivesPost;
}

function safeBack() {

    const last = sessionStorage.getItem("lastPage");

    if (!last) {
        history.back();
        return;
    }

    if (isUnsafeBackTarget(last)) {
        window.location.href = fallbackPage;
        return;
    }

    history.back();
}

</script>