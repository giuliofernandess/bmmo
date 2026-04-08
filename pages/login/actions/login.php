<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Carrega config do projeto
require_once '../../../config/config.php';

// Carrega classe de autenticação (POO)
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

// Inicia sessão para salvar mensagens de erro
session_start();

// Bloqueia acesso direto via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage(BASE_URL . 'pages/login/admin/index.php', 'error', 'Método inválido.');
}

// Captura os dados do formulário
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

// Tenta autenticar via classe Auth
if ($method) {
    redirectWithMessage($redirectSuccess, 'success', 'Login efetuado com sucesso!');
}

// Login inválido → salva mensagem e volta para o form
redirectWithMessage($redirect, 'error', 'Login ou senha inválidos.');
