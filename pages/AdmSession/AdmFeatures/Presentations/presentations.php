<?php

require_once "../../../../config/config.php";

require_once BASE_PATH . "app/Models/BandGroups.php";
require_once BASE_PATH . "app/Models/MusicalScores.php";
require_once BASE_PATH . "app/Models/Presentations.php";


require_once BASE_PATH . "app/Auth/Auth.php";

Auth::requireRegency();

Presentations::automaticallyDelete();

$groups = BandGroups::getAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apresentações</title>

    <!-- Configurações Básicas -->
    <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

    <!-- CSS da página -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Toasts -->
    <?php include_once BASE_PATH . "includes/successToast.php" ?>
    <?php include_once BASE_PATH . "includes/errorToast.php" ?>

    <!-- Header -->
    <?php include_once BASE_PATH . "includes/secondHeader.php" ?>

    <main class="p-5">

        <!-- Título -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="mb-0">Próximas tocatas</h1>
            <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="addIcon" onclick="showForm()"
                title="Criar Tocata"></i>
        </div>

        <!-- Formulário -->
        <div class="bg-white p-4 rounded shadow-sm mb-4" style="display: none;" id="presentationForm">
            <h4 class="mb-3">Criar Apresentação</h4>

            <form action="PresentationFunctions/validateCreatePresentation.php" method="post">

                <div class="mb-3">
                    <label for="iname" class="form-label">Nome</label>
                    <input type="text" name="name" id="iname" class="form-control" required>
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
                    <input type="text" name="local" id="ilocal" class="form-control" required>
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
                    <label class="form-label">Músicas</label>

                    <div class="d-flex gap-2">
                        <select id="isongs" class="form-select">
                            <option value="">Selecione</option>
                            <?php
                            $musicsList = MusicalScores::ordenedGetAll();

                            if (!empty($musicsList)) {
                                $currentGenre = "";
                                $lastName = "";

                                foreach ($musicsList as $musics) {
                                    if ($currentGenre != $musics['music_genre']) {
                                        $currentGenre = $musics['music_genre'];
                                        echo "<option disabled>-- {$musics['music_genre']} --</option>";
                                    }
                                    if ($lastName != $musics['music_name']) {
                                        echo "<option value='{$musics['music_id']}'>
                                            {$musics['music_name']}
                                        </option>";
                                    }
                                    $lastName = $musics['music_name'];
                                }
                            } else {
                                echo "<option disabled>Nenhuma música cadastrada</option>";
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
                    style="padding-top: 6px;" id="ibutton" value="Criar Tocata">
            </form>
        </div>

        <!-- Cards -->
        <div class="row g-3">
            <?php
            $presentationsList = Presentations::getAll();

            if (!empty($presentationsList)) {
                foreach ($presentationsList as $presentations) {

                    $presentationGroups = Presentations::getPresentationGroups($presentations['presentation_id']);
                    $presentationSongs = Presentations::getPresentationSongs($presentations['presentation_id']);

                    $idGroups = [];
                    foreach ($presentationGroups as $presentationGroup) {
                        $idGroups[] = $presentationGroup['group_id'];
                    }

                    $idSongs = [];
                    foreach ($presentationSongs as $presentationSong) {
                        $idSongs[] = $presentationSong['song_id'];
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
                                    <?= (new DateTime($presentations['presentation_date']))->format("d/m/Y") ?></p>
                                <p class="mb-1">
                                    <strong>Horário:</strong> <?= date('H:i', strtotime($presentations['presentation_hour'])) ?>
                                </p>
                                <p class="mb-1"><strong>Local:</strong> <?= $presentations['local_of_presentation'] ?></p>

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

                                <div class="mt-auto d-flex justify-content-end gap-2">
                                    <a href="PresentationFunctions/validateDeletePresentation.php?presentation_id=<?= $presentations['presentation_id'] ?>"
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                        style="width:38px;height:38px;"
                                        onclick="return confirm('Tem certeza que deseja excluir esta tocata?');">
                                        <i class="bi bi-trash"></i>
                                    </a>

                                    <a class="btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                        style="width:38px;height:38px;" onclick="editPresentation(this)">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<p>Nenhuma tocata cadastrada.</p>";
            }
            ?>
        </div>

    </main>

    <?php include_once BASE_PATH . "includes/footer.php" ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/presentations.js"></script>

</body>

</html>