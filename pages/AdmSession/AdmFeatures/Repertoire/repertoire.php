<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../../Index/index.php");
    exit;
} else {
    require_once '../../../../general-features/bdConnect.php';

    if (!$connect) {
        die('Erro de conexão: ' . mysqli_connect_error());
    }

    $today = (new DateTime())->format('Y-m-d');
    $connect->query("DELETE FROM repertoire WHERE date < '$today'");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repertório</title>

    <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../../../../assets/css/style.css">
    <link rel="stylesheet" href="../../../../assets/css/form.css">

    <style>
        .cursor-pointer { cursor: pointer; }
    </style>
</head>

<body>

<!-- Header -->
<header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
        <img src="../../../../assets/images/logo_banda.png" width="30" height="30" class="me-2">
        <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>

    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a href="../../admPage.php" class="nav-link text-white fs-4">
                    <i class="bi bi-arrow-90deg-left"></i>
                </a>
            </li>
        </ul>
    </nav>
</header>

<main class="p-5">

    <!-- Título -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="mb-0">Próximas tocatas</h1>
        <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="addIcon"
           onclick="showForm()" title="Criar Tocata"></i>
    </div>

    <!-- Formulário -->
    <div class="bg-white p-4 rounded shadow-sm mb-4" style="display: none;" id="presentationForm">
        <h4 class="mb-3">Criar Apresentação</h4>

        <form action="RepertoireFunctions/createRepertoire.php" method="post">

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
                <label class="form-label">Grupo da Banda</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="bandGroup[]" value="Banda Principal">
                    <label class="form-check-label">Banda Principal</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="bandGroup[]" value="Banda Auxiliar">
                    <label class="form-check-label">Banda Auxiliar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="bandGroup[]" value="Escola de Música">
                    <label class="form-check-label">Escola de Música</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="bandGroup[]" value="Fanfarra">
                    <label class="form-check-label">Fanfarra</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="bandGroup[]" value="Flauta Doce">
                    <label class="form-check-label">Flauta Doce</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Músicas</label>

                <div class="d-flex gap-2">
                    <select id="isongs" class="form-select">
                        <option value="">Selecione</option>
                        <?php
                        $sql = "SELECT * FROM musical_scores ORDER BY musicalGenre ASC, name ASC";
                        $result = $connect->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $currentGenre = "";
                            $lastName = "";

                            while ($res = $result->fetch_assoc()) {
                                if ($currentGenre != $res['musicalGenre']) {
                                    $currentGenre = $res['musicalGenre'];
                                    echo "<option disabled>-- {$res['musicalGenre']} --</option>";
                                }
                                if ($lastName != $res['name']) {
                                    echo "<option value='{$res['name']}'>{$res['name']}</option>";
                                }
                                $lastName = $res['name'];
                            }
                        } else {
                            echo "<option disabled>Nenhuma música cadastrada</option>";
                        }
                        ?>
                    </select>

                    <button type="button"
                        class="btn btn-primary btn-lg rounded-pill w-100" style="max-width: 30%;"
                        onclick="addSong()">
                        Adicionar
                    </button>
                </div>
            </div>

            <div class="res mb-3"></div>

            <input type="submit"
                   class="btn btn-outline-primary btn-lg rounded-pill w-100 mt-3" style="padding-top: 6px;" id="ibutton"
                   value="Criar Tocata">
        </form>
    </div>

    <!-- Cards -->
    <div class="row g-3">
        <?php
        $sql = "SELECT * FROM repertoire ORDER BY date ASC, hour ASC";
        $result = $connect->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($res = $result->fetch_assoc()) {
        ?>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column repertoire-info" data-id="<?= htmlspecialchars($res['id']) ?>" data-name="<?= htmlspecialchars($res['presentationName']) ?>" data-date="<?= htmlspecialchars($res['date']) ?>" data-hour="<?= htmlspecialchars($res['hour']) ?>" data-local="<?= htmlspecialchars($res['local']) ?>" data-group="<?= htmlspecialchars($res['bandGroup']) ?>" data-songs="<?= htmlspecialchars($res['songs']) ?>">

                    <h5 class="card-title"><?= htmlspecialchars($res['presentationName']) ?></h5>

                    <p class="mb-1"><strong>Data:</strong> <?= (new DateTime($res['date']))->format("d/m/Y") ?></p>
                    <p class="mb-1"><strong>Horário:</strong> <?= $res['hour'] ?></p>
                    <p class="mb-1"><strong>Local:</strong> <?= $res['local'] ?></p>

                    <p class="mb-1"><strong>Grupo(s):</strong><br>
                        <?= str_replace('-', '<br>', $res['bandGroup']) ?>
                    </p>

                    <p class="mb-1"><strong>Músicas:</strong><br>
                        <?= str_replace('-', '<br>', $res['songs']) ?>
                    </p>

                    <div class="mt-auto d-flex justify-content-end gap-2">
                        <a href="RepertoireFunctions/deleteRepertoire.php?id=<?= $res['id'] ?>"
                           class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                           style="width:38px;height:38px;"
                           onclick="return confirm('Tem certeza que deseja excluir esta tocata?');">
                            <i class="bi bi-trash"></i>
                        </a>

                        <a class="btn btn-success btn-sm d-flex align-items-center justify-content-center editRepertoire" 
                           style="width:38px;height:38px;" onclick="editRepertoire(this)">
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

<?php require_once '../../../../general-features/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
