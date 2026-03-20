<?php

require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Controllers/NewsController.php';

$controller = new NewsController();
$controller->store();
