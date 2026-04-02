<?php

require_once BASE_PATH . "app/DAO/MusiciansDAO.php";

$musiciansDAO = new MusiciansDAO($conn);

$login = $_SESSION["musician_login"] ? trim($_SESSION["musician_login"]) : null;
$musicianInfo = $musiciansDAO->findByLogin($login);

?>