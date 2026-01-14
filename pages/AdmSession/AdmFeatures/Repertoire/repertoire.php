<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../../Index/index.php");
    exit;
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
        input,
        textarea {
            margin-bottom: 10px;
        }

        main {
            padding: 50px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none">
            <img src="../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
            <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
        </a>
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a href="../../admPage.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
                            class="bi bi-arrow-90deg-left"></i></a>
                </li>
            </ul>
        </nav>
    </header>


    <main>
        <div class="main-header">
            <h1>Próximas tocatas</h1>
            <span onclick="showForm()"><i class="bi bi-plus-square-fill"></i></span>
        </div>

        <div class="main-form" style="display:none;" id="presentationForm">
            <h4>Criar Apresentação</h4>
            <form action="validateRepertoire.php" method="post">
                <div>
                    <label for="iname">Nome: </label><br>
                    <input type="text" name="name" id="iname" required>
                </div>

                <div>
                    <label for="idate">Data: </label><br>
                    <input type="date" name="date" id="idate" required>
                </div>

                <div>
                    <label for="ihour">Hora: </label><br>
                    <input type="time" name="hour" id="ihour" required>
                </div>

                <div>
                    <label for="">Grupo da Banda:</label><br>
                    <input type="checkbox" name="bandGroup[]" value="Banda Principal"> Banda Principal<br>
                    <input type="checkbox" name="bandGroup[]" value="Banda Auxiliar"> Banda Auxiliar<br>
                    <input type="checkbox" name="bandGroup[]" value="Escola de Música"> Escola de Música<br>
                    <input type="checkbox" name="bandGroup[]" value="Fanfarra"> Fanfarra<br>
                    <input type="checkbox" name="bandGroup[]" value="Flauta Doce"> Flauta Doce<br>
                </div>

                <div>
                    <label for="isongs">Músicas:</label><br>
                    <select id="isongs">
                        <option value=''>Selecione</option>
                        <?php
                        require_once '../../../../general-features/bdConnect.php';

                        if (!$connect) {
                            die('Erro de conexão: ' . mysqli_connect_error());
                        }

                        $sql = "SELECT * FROM musical_scores ORDER BY musicalGenre ASC, name ASC";
                        $result = $connect->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $currentGenre = "";
                            $lastName = "";

                            while ($res = $result->fetch_assoc()) {
                                if ($currentGenre != $res['musicalGenre']) {

                                    $currentGenre = $res['musicalGenre'];
                                    echo "<option disabled>-- " . htmlspecialchars($res['musicalGenre']) . " --</option>";
                                }

                                if ($lastName != $res['name']) {
                                    echo "<option value='" . htmlspecialchars($res['name']) . "'>" . htmlspecialchars($res['name']) . " </option>";
                                }

                                $lastName = $res['name'];
                            }
                        } else {
                            echo "<option disabled>Nenhuma música cadastrada</option>";
                        }
                        ?>
                    </select>
                    <button type='button' onclick="addSong()">Adicionar</button>
                </div>

                <div>
                    <input type='submit' value='Criar Tocata'>
                </div>

            </form>

            <div class="res"></div>
        </div>

        <div class="container">

        </div>

    </main>

    <!-- Footer -->
    <?php require_once '../../../../general-features/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <script>
    let selectedSongs = [];
    const form = document.querySelector('form');
    const res = document.querySelector('.res');

    function showForm() {
        document.getElementById('presentationForm').style.display = 'block';
    }

    function addSong() {
        const select = document.querySelector('#isongs');
        const selectedSong = select.value.trim();

        if (!selectedSong) {
            alert('[ERRO] Selecione uma música válida!');
            return;
        }

        if (selectedSongs.includes(selectedSong)) {
            alert('[ERRO] Música já adicionada!');
            return;
        }

        selectedSongs.push(selectedSong);

        showSongs();
        addInput();

        select.value = '';
    }

    function showSongs() {
        res.innerHTML = '';
        selectedSongs.forEach(el => {
            const p = document.createElement('p');
            p.innerHTML = `${el} <i class="bi bi-trash" onclick="deleteSong('${el}')"></i>`;
            res.appendChild(p);
        });
    }

    function addInput() {
        document.querySelectorAll('.song-hidden').forEach(el => el.remove());

        selectedSongs.forEach(el => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.className = 'song-hidden';
            input.name = 'songs[]';
            input.value = el;
            form.appendChild(input);
        });
    }

    function deleteSong(nameSong) {
        selectedSongs = selectedSongs.filter(el => el != nameSong);

        addInput();
        showSongs();
    }
</script>

</body>

</html>