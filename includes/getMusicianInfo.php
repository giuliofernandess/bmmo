<?php

require_once BASE_PATH . "app/Models/MusicalScores.php";

$login = $_SESSION["musician_login"] ? trim($_SESSION["musician_login"]) : null;
$musicianInfo = Musicians::findByLogin($login);

?>