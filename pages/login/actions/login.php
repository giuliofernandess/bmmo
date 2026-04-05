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
    redirectWithMessage('error', 'Método inválido.', BASE_URL . 'pages/login/admin/index.php');
}

// Captura os dados do formulário
$login = postValue('user_login') ?? '';
$password = postValue('user_password') ?? '';

$type = postValue('type') ?? '';

if ($type !== 'admin' && $type !== 'musician') {
    redirectWithMessage('error', 'Tipo de login inválido.', BASE_URL . 'pages/login/admin/index.php');
}

$redirect = $type === 'admin'
    ? BASE_URL . 'pages/login/admin/index.php'
    : BASE_URL . 'pages/login/musician/index.php';

validateRequiredFields([
    'Login' => $login,
    'Senha' => $password,
    'Tipo de usuário' => $type,
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
    redirectWithMessage('success', 'Login efetuado com sucesso!', $redirectSuccess);
}

// Login inválido → salva mensagem e volta para o form
redirectWithMessage('error', 'Login ou senha inválidos.', $redirect);
