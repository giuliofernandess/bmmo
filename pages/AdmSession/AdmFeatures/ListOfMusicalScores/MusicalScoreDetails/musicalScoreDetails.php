<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<meta http-equiv='refresh' content='0; url=../../../../../../../Index/index.php'>";
}

require_once '../../../../../../../general-features/bdConnect.php';

$name = trim($_GET['name']);

$stmt = $connect->prepare('SELECT * FROM musical_scores WHERE name = ?');
$stmt->bind_param('s', $name);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalhes - <?php echo htmlspecialchars($name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../../../../../../../assets/images/logo_banda.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../../../../../../assets/css/style.css">
</head>

<body>
    <!-- Header -->
    <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none">
            <img src="../../../../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30"
                class="me-2">
            <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
        </a>
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a href="../listOfMusicalScores.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
                            class="bi bi-arrow-90deg-left"></i></a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="container my-5">
        <h1 class="mb-4 text-center"><?php echo htmlspecialchars($name); ?></h1>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Instrumento</th>
                        <th>Grupo da Banda</th>
                        <th>Gênero</th>
                        <th>Arquivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($res = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>" . htmlspecialchars($res['instrument']) . "</td>
                        <td>" . htmlspecialchars($res['bandGroup']) . "</td>
                        <td>" . htmlspecialchars($res['musicalGenre']) . "</td>
                        <td class='text-center'><a href='../../../../../../../assets/musical-scores/" . htmlspecialchars($res['file']) . "' target='_blank'><i class='bi bi-file-earmark-bar-graph fs-5'></i></a></td>
                    </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <?php require_once '../../../../../../../general-features/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>

</html>