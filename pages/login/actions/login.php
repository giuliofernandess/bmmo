<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once '../../../config/config.php';


require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';


session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage(BASE_URL . 'pages/login/admin/index.php', 'error', 'Método inválido.');
}


$login = filter_input(INPUT_POST, 'user_login');
$password = filter_input(INPUT_POST, 'user_password');

$type = filter_input(INPUT_POST, 'type');

if ($type !== 'admin' && $type !== 'musician') {
    redirectWithMessage(BASE_URL . 'pages/login/admin/index.php', 'error', 'Tipo de login inválido.');
}

$redirect = $type === 'admin'
    ? BASE_URL . 'pages/login/admin/index.php'
    : BASE_URL . 'pages/login/musician/index.php';

validateRequiredFields([
    'login' => $login,
    'password' => $password,
    'type' => $type,
], $redirect);

if ($type === 'admin') {
    $redirectSuccess = BASE_URL . 'pages/admin/index.php';
    $method = Auth::regencyLogin($login, $password);
    
} else {
    $redirectSuccess = BASE_URL . 'pages/musician/index.php';
    $method = Auth::musicianLogin($login, $password);
}


if ($method) {
    redirectWithMessage($redirectSuccess, 'success', 'Login efetuado com sucesso!');
}


redirectWithMessage($redirect, 'error', 'Login ou senha inválidos.');
