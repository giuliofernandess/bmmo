<?php
require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH ."app/DAO/PresentationsDAO.php";

Auth::requireMusician();

$presentationsDAO->automaticallyDelete();

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

    <main class="p-5">
        <!-- Título -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="mb-0 text-primary fw-bold">Próximas apresentações</h1>
        </div>

        <!-- Cards -->
        <div class="row g-3">
            <?php
            $presentationsList = $presentationsDAO->getAll();

            if (!empty($presentationsList)) {
                foreach ($presentationsList as $presentationInfo):

                    $presentationGroups = $presentationsDAO->getPresentationGroups($presentationInfo['presentation_id']);
                    $presentationSongs = $presentationsDAO->getPresentationSongs($presentationInfo['presentation_id']);

                    $formattedPresentationDate = htmlspecialchars((string) ($presentationInfo['presentation_date'] ?? ''));
                    try {
                        $formattedPresentationDate = (new DateTime((string) $presentationInfo['presentation_date']))->format("d/m/Y");
                    } catch (Exception $e) {
                        // Keep raw date string to avoid breaking page rendering.
                    }

                    ?>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">

                                <h5 class="card-title"><?= htmlspecialchars($presentationInfo['presentation_name']) ?></h5>

                                <p class="mb-1"><strong>Data:</strong>
                                    <?= $formattedPresentationDate ?></p>
                                <p class="mb-1"><strong>Horário:</strong>
                                    <?= date('H:i', strtotime($presentationInfo['presentation_hour'])) ?></p>
                                <p class="mb-1"><strong>Local:</strong>
                                    <?= htmlspecialchars($presentationInfo['local_of_presentation']) ?></p>

                                <p class="mb-1"><strong>Grupo(s):</strong><br>
                                    <?php foreach ($presentationGroups as $presentationGroup):
                                        ?>

                                        <span><?= htmlspecialchars($presentationGroup['group_name']); ?></span><br>

                                    <?php endforeach ?>
                                </p>

                                <p class="mb-1"><strong>Músicas:</strong><br>
                                    <?php foreach ($presentationSongs as $presentationSong):
                                        ?>

                                        <span><?= htmlspecialchars($presentationSong['music_name']); ?></span><br>

                                    <?php endforeach ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
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