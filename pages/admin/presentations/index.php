<?php

require_once '../../../config/config.php';

require_once BASE_PATH . 'app/DAO/BandGroupsDAO.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Auth/Auth.php';

$bandGroupsDAO = new BandGroupsDAO($conn);
$musicalScoresDAO = new MusicalScoresDAO($conn);
$presentationsDAO = new PresentationsDAO($conn);

Auth::requireRegency();

$presentationsDAO->automaticallyDelete();

$groups = $bandGroupsDAO->getAll();
$musicList = $musicalScoresDAO->getAll();
$presentationsList = $presentationsDAO->getAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apresentações</title>

    <?php require_once BASE_PATH . 'includes/basicHead.php'; ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
</head>

<body>
    <?php include_once BASE_PATH . 'includes/successToast.php' ?>
    <?php include_once BASE_PATH . 'includes/errorToast.php' ?>

    <?php include_once BASE_PATH . 'includes/secondHeader.php' ?>

    <main class="p-5 presentations-page">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="mb-0">Proximas apresentações</h1>
            <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="presentation-form-toggle-icon"
                title="Criar apresentacao"></i>
        </div>

        <div class="bg-white p-4 rounded shadow-sm mb-4 is-hidden" id="presentation-form">
            <h4 class="mb-3">Criar Apresentação</h4>

            <form id="presentation-form-element" action="<?= BASE_URL ?>pages/admin/presentations/actions/create.php" method="post">
                <div class="mb-3">
                    <label for="presentation-name" class="form-label">Nome *</label>
                    <input type="text" name="presentation_name" id="presentation-name" class="form-control" placeholder="Nome da apresentação" required>
                </div>

                <div class="mb-3">
                    <label for="presentation-date" class="form-label">Data *</label>
                    <input type="date" name="presentation_date" id="presentation-date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="presentation-hour" class="form-label">Hora *</label>
                    <input type="time" name="presentation_hour" id="presentation-hour" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="presentation-location" class="form-label">Local *</label>
                    <input type="text" name="presentation_location" id="presentation-location" class="form-control" placeholder="Local da apresentação" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Grupo da Banda</label><br>
                    <?php foreach ($groups as $group) { ?>
                        <input type="checkbox" class="form-check-input" name="groups[]" value="<?= (int) ($group->getGroupId() ?? 0) ?>">
                        <label class="form-check-label">
                            <?= htmlspecialchars($group->getGroupName()) ?>
                        </label><br>
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Musicas</label>

                    <div class="d-flex gap-2">
                        <select id="presentation-songs" class="form-select">
                            <option value="">Selecione</option>
                            <?php
                            if (!empty($musicList)) {
                                $currentGenre = '';
                                $lastName = '';

                                foreach ($musicList as $musicItem) {
                                    $musicGenre = $musicItem->getMusicGenre();
                                    $musicName = $musicItem->getMusicName();
                                    $musicId = (int) ($musicItem->getMusicId() ?? 0);

                                    if ($currentGenre !== $musicGenre) {
                                        $currentGenre = $musicGenre;
                                        echo "<option disabled>-- " . htmlspecialchars($musicGenre) . " --</option>";
                                    }
                                    if ($lastName !== $musicName) {
                                        echo "<option value='" . $musicId . "'>
                                            " . htmlspecialchars($musicName) . "
                                        </option>";
                                    }
                                    $lastName = $musicName;
                                }
                            } else {
                                echo '<option disabled>Nenhuma música cadastrada</option>';
                            }
                            ?>
                        </select>

                        <button type="button" class="btn btn-primary btn-lg rounded-pill w-100 presentation-add-song-button" id="presentation-add-song-button">
                            Adicionar
                        </button>
                    </div>
                </div>

                <div class="selected-songs mb-3"></div>

                <input type="submit" class="btn btn-outline-primary btn-lg w-100 mt-3 presentation-submit-button py-1"
                    id="presentation-submit" value="Criar apresentação">
            </form>
        </div>

        <div class="row g-3">
            <?php
            if (!empty($presentationsList)) {
                foreach ($presentationsList as $presentation) {
                    $presentationId = (int) ($presentation->getPresentationId() ?? 0);
                    $presentationGroups = $presentationsDAO->getPresentationGroups($presentationId);
                    $presentationSongs = $presentationsDAO->getPresentationSongs($presentationId);

                    $idGroups = [];
                    foreach ($presentationGroups as $presentationGroup) {
                        $idGroups[] = (int) ($presentationGroup->getGroupId() ?? 0);
                    }

                    $idSongs = [];
                    foreach ($presentationSongs as $presentationSong) {
                        $idSongs[] = (int) ($presentationSong->getMusicId() ?? 0);
                    }

                    $presentationDate = $presentation->getPresentationDate();
                    $formattedPresentationDate = htmlspecialchars($presentationDate);
                    try {
                        $formattedPresentationDate = (new DateTime($presentationDate))->format('d/m/Y');
                    } catch (Exception $e) {
                        // Keep raw date string to avoid breaking page rendering.
                    }
                    ?>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm h-100 presentation-card">
                            <div class="card-body d-flex flex-column presentation-card-body presentation-info"
                                data-presentation-id="<?= $presentationId ?>"
                                data-presentation-name="<?= htmlspecialchars($presentation->getPresentationName()) ?>"
                                data-presentation-date="<?= htmlspecialchars($presentationDate) ?>"
                                data-presentation-hour="<?= htmlspecialchars($presentation->getPresentationHour()) ?>"
                                data-presentation-location="<?= htmlspecialchars($presentation->getLocalOfPresentation()) ?>"
                                data-presentation-groups="<?= htmlspecialchars(json_encode($idGroups)) ?>"
                                data-presentation-songs="<?= htmlspecialchars(json_encode($idSongs)) ?>">

                                <h4 class="card-title"><?= htmlspecialchars($presentation->getPresentationName()) ?></h4>

                                <p class="mb-1"><strong>Data:</strong>
                                    <?= $formattedPresentationDate ?></p>
                                <p class="mb-1">
                                    <strong>Horario:</strong> <?= date('H:i', strtotime($presentation->getPresentationHour())) ?>
                                </p>
                                <p class="mb-1"><strong>Local:</strong> <?= htmlspecialchars($presentation->getLocalOfPresentation()) ?></p>

                                <p class="mb-1"><strong>Grupo(s):</strong><br>
                                    <?php foreach ($presentationGroups as $presentationGroup) { ?>
                                        <span><?= htmlspecialchars($presentationGroup->getGroupName()); ?></span><br>
                                    <?php } ?>
                                </p>

                                <p class="mb-1"><strong>Musicas:</strong><br>
                                    <?php foreach ($presentationSongs as $presentationSong) { ?>
                                        <span><?= htmlspecialchars($presentationSong->getMusicName()); ?></span><br>
                                    <?php } ?>
                                </p>

                                <div class="mt-auto d-flex justify-content-end gap-2">
                                    <form action="<?= BASE_URL ?>pages/admin/presentations/actions/delete.php" method="post"
                                        class="presentation-delete-form" style="width: 60px;">
                                        <input type="hidden" name="presentation_id" value="<?= $presentationId ?>">
                                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0 presentation-action-button">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </form>

                                    <a class="btn btn-success btn-sm d-flex align-items-center justify-content-center presentation-edit-button presentation-action-button" style="max-width: 50px;"
                                        href="#">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>Nenhuma apresentação cadastrada.</p>';
            }
            ?>
        </div>
    </main>

    <?php include_once BASE_PATH . 'includes/footer.php' ?>

    <script>
        window.BASE_URL = <?= json_encode(BASE_URL) ?>;
    </script>
    <script src="<?= BASE_URL ?>assets/js/confirmAction.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/presentations.js"></script>

</body>

</html>
