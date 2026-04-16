<?php
require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
$auth = new Auth();
require_once BASE_PATH ."app/DAO/PresentationsDAO.php";

$presentationsDAO = new PresentationsDAO($conn);

$auth->requireMusician();

$presentationsDAO->automaticallyDelete();

$presentationsList = $presentationsDAO->getAll();

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apresentações</title>

    <!-- Configurações Básicas -->
    <?php require_once BASE_PATH . "includes/basicHead.php"; ?>
</head>

<body>
    <!-- Header -->
    <?php include_once BASE_PATH . "includes/secondHeader.php"; ?>

    <main class="container p-5 presentations-page">
        <!-- Título -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="mb-0 text-primary fw-bold">Próximas apresentações</h1>
        </div>

        <!-- Cards -->
        <div class="row g-3">
            <?php
            if (!empty($presentationsList)) {
                foreach ($presentationsList as $presentation) {

                    $presentationId = (int) ($presentation->getPresentationId() ?? 0);
                    $presentationGroups = $presentationsDAO->getPresentationGroups($presentationId);
                    $presentationSongs = $presentationsDAO->getPresentationSongs($presentationId);

                    $presentationDate = $presentation->getPresentationDate();
                    $formattedPresentationDate = htmlspecialchars($presentationDate);
                    try {
                        $formattedPresentationDate = (new DateTime($presentationDate))->format("d/m/Y");
                    } catch (Exception $e) {
                        
                    }

                    ?>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm h-100 presentation-card">
                            <div class="card-body d-flex flex-column presentation-card-body">

                                <h5 class="card-title"><?= htmlspecialchars($presentation->getPresentationName()) ?></h5>

                                <p class="mb-1"><strong>Data:</strong>
                                    <?= $formattedPresentationDate ?></p>
                                <p class="mb-1"><strong>Horário:</strong>
                                    <?= date('H:i', strtotime($presentation->getPresentationHour())) ?></p>
                                <p class="mb-1"><strong>Local:</strong>
                                    <?= htmlspecialchars($presentation->getLocalOfPresentation()) ?></p>

                                <p class="mb-1"><strong>Grupo(s):</strong><br>
                                    <?php foreach ($presentationGroups as $presentationGroup) { ?>
                                        <span><?= htmlspecialchars($presentationGroup->getGroupName()); ?></span><br>
                                    <?php } ?>
                                </p>

                                <p class="mb-1"><strong>Músicas:</strong><br>
                                    <?php foreach ($presentationSongs as $presentationSong) { ?>
                                        <span><?= htmlspecialchars($presentationSong->getMusicName()); ?></span><br>
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Nenhuma apresentação cadastrada.</p>";
            }
            ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include_once BASE_PATH . "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>