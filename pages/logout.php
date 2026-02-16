<?php

/**
 * Página de logout
 */

require_once '../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';

// Redireciona para página inicial após logout
Auth::logout(BASE_URL . "pages/index.php");
