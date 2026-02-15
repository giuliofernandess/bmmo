<?php

require_once '../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';

Auth::logout(BASE_URL . 'pages/index.php');

?>
