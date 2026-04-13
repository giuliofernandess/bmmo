<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


define('BASE_URL', '/bmmo/');
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/bmmo/');


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bmmo');


require_once BASE_PATH . 'app/Database/Database.php';
require_once BASE_PATH . 'app/Models/Message.php';


$conn = Database::getConnection();
?>
