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
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apresentações</title>

    <?php require_once BASE_PATH . 'includes/basicHead.php'; ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include_once BASE_PATH . 'includes/successToast.php' ?>
    <?php include_once BASE_PATH . 'includes/errorToast.php' ?>

    <?php include_once BASE_PATH . 'includes/secondHeader.php' ?>

    <main class="p-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="mb-0">Proximas apresentações</h1>
            <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="add-icon" onclick="showForm()"
                title="Criar apresentacao"></i>
        </div>

        <div class="bg-white p-4 rounded shadow-sm mb-4" style="display: none;" id="presentation-form">
            <h4 class="mb-3">Criar Apresentação</h4>

            <form action="<?= BASE_URL ?>pages/admin/presentations/actions/create.php" method="post">
                <div class="mb-3">
                    <label for="iname" class="form-label">Nome</label>
                    <input type="text" name="name" id="iname" class="form-control" placeholder="Nome da apresentação" required>
                </div>

                <div class="mb-3">
                    <label for="idate" class="form-label">Data</label>
                    <input type="date" name="date" id="idate" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="ihour" class="form-label">Hora</label>
                    <input type="time" name="hour" id="ihour" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="ilocal" class="form-label">Local</label>
                    <input type="text" name="local" id="ilocal" class="form-control" placeholder="Local da apresentação" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Grupo da Banda</label><br>
                    <?php foreach ($groups as $group): ?>
                        <input type="checkbox" class="form-check-input" name="groups[]" value="<?= $group['group_id'] ?>">
                        <label class="form-check-label">
                            <?= $group['group_name'] ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Musicas</label>

                    <div class="d-flex gap-2">
                        <select id="isongs" class="form-select">
                            <option value="">Selecione</option>
                            <?php
                            $musicList = $musicalScoresDAO->getAll();

                            if (!empty($musicList)) {
                                $currentGenre = '';
                                $lastName = '';

                                foreach ($musicList as $musicItem) {
                                    if ($currentGenre != $musicItem['music_genre']) {
                                        $currentGenre = $musicItem['music_genre'];
                                        echo "<option disabled>-- {$musicItem['music_genre']} --</option>";
                                    }
                                    if ($lastName != $musicItem['music_name']) {
                                        echo "<option value='{$musicItem['music_id']}'>
                                            {$musicItem['music_name']}
                                        </option>";
                                    }
                                    $lastName = $musicItem['music_name'];
                                }
                            } else {
                                echo '<option disabled>Nenhuma música cadastrada</option>';
                            }
                            ?>
                        </select>

                        <button type="button" class="btn btn-primary btn-lg rounded-pill w-100" style="max-width: 30%;"
                            onclick="addSong()">
                            Adicionar
                        </button>
                    </div>
                </div>

                <div class="res mb-3"></div>

                <input type="submit" class="btn btn-outline-primary btn-lg rounded-pill w-100 mt-3"
                    style="padding-top: 6px;" id="ibutton" value="Criar apresentação">
            </form>
        </div>

        <div class="row g-3">
            <?php
            $presentationsList = $presentationsDAO->getAll();

            if (!empty($presentationsList)) {
                foreach ($presentationsList as $presentations) {
                    $presentationGroups = $presentationsDAO->getPresentationGroups($presentations['presentation_id']);
                    $presentationSongs = $presentationsDAO->getPresentationSongs($presentations['presentation_id']);

                    $idGroups = [];
                    foreach ($presentationGroups as $presentationGroup) {
                        $idGroups[] = $presentationGroup['group_id'];
                    }

                    $idSongs = [];
                    foreach ($presentationSongs as $presentationSong) {
                        $idSongs[] = $presentationSong['song_id'];
                    }

                    $formattedPresentationDate = htmlspecialchars((string) ($presentations['presentation_date'] ?? ''));
                    try {
                        $formattedPresentationDate = (new DateTime((string) $presentations['presentation_date']))->format('d/m/Y');
                    } catch (Exception $e) {
                        // Keep raw date string to avoid breaking page rendering.
                    }
                    ?>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column presentation-info"
                                data-id="<?= htmlspecialchars($presentations['presentation_id']) ?>"
                                data-name="<?= htmlspecialchars($presentations['presentation_name']) ?>"
                                data-date="<?= htmlspecialchars($presentations['presentation_date']) ?>"
                                data-hour="<?= htmlspecialchars($presentations['presentation_hour']) ?>"
                                data-local="<?= htmlspecialchars($presentations['local_of_presentation']) ?>"
                                data-groups="<?= htmlspecialchars(json_encode($idGroups)) ?>"
                                data-songs="<?= htmlspecialchars(json_encode($idSongs)) ?>">

                                <h4 class="card-title"><?= htmlspecialchars($presentations['presentation_name']) ?></h4>

                                <p class="mb-1"><strong>Data:</strong>
                                    <?= $formattedPresentationDate ?></p>
                                <p class="mb-1">
                                    <strong>Horario:</strong> <?= date('H:i', strtotime($presentations['presentation_hour'])) ?>
                                </p>
                                <p class="mb-1"><strong>Local:</strong> <?= $presentations['local_of_presentation'] ?></p>

                                <p class="mb-1"><strong>Grupo(s):</strong><br>
                                    <?php foreach ($presentationGroups as $presentationGroup): ?>
                                        <span><?= htmlspecialchars($presentationGroup['group_name']); ?></span><br>
                                    <?php endforeach ?>
                                </p>

                                <p class="mb-1"><strong>Musicas:</strong><br>
                                    <?php foreach ($presentationSongs as $presentationSong): ?>
                                        <span><?= htmlspecialchars($presentationSong['music_name']); ?></span><br>
                                    <?php endforeach ?>
                                </p>

                                <div class="mt-auto d-flex justify-content-end gap-2">
                                    <form action="<?= BASE_URL ?>pages/admin/presentations/actions/delete.php" method="post"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta apresentação?');">
                                        <input type="hidden" name="presentation_id" value="<?= (int) $presentations['presentation_id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                                            style="width:62px;height:38px;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                    <a class="btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                        style="width:62px;height:38px;" onclick="editPresentation(this)">
                                        <i class="bi bi-pencil-square"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/presentations.js"></script>

</body>

</html>
