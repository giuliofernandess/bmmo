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

// Captura os dados do formulário com fallback
$login = postValueAny(['user_login', 'login']) ?? '';
$password = postValueAny(['user_password', 'password']) ?? '';

if ($_POST['type'] == 'admin') {
    $redirect = BASE_URL . 'pages/login/admin/index.php';
    $redirectSuccess = BASE_URL . 'pages/admin/index.php';
    $method = Auth::regencyLogin($login, $password);
    
} else {
    $redirect = BASE_URL . 'pages/login/musician/index.php';
    $redirectSuccess = BASE_URL . 'pages/musician/index.php';
    $method = Auth::musicianLogin($login, $password);
}

// Bloqueia acesso direto via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage('error', 'Método inválido.', $redirect);
}

// Validação simples (campos vazios)
if ($login === '' || $password === '') {
    redirectWithMessage('error', 'Preencha todos os campos.', $redirect);
}

// Tenta autenticar via classe Auth
if ($method) {
    redirectWithMessage('success', 'Login efetuado com sucesso!', $redirectSuccess);
}

// Login inválido → salva mensagem e volta para o form
redirectWithMessage('error', 'Login ou senha inválidos.', $redirect);
