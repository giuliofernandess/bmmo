<?php

// Carrega config do projeto
require_once '../../../../config/config.php';

// Carrega classe de autenticação (POO)
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

// Inicia sessão para salvar mensagens de erro
session_start();

$redirect = BASE_URL . 'pages/login/musician/index.php';
$redirectSuccess = BASE_URL . 'pages/musician/index.php';

// Bloqueia acesso direto via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage('error', 'Método inválido.', $redirect);
}

// Captura os dados do formulário com fallback
$musicianLogin = postValueAny(['user_login', 'login']) ?? '';
$musicianPassword = postValueAny(['user_password', 'password']) ?? '';

// Validação simples (campos vazios)
if ($musicianLogin === '' || $musicianPassword === '') {
    redirectWithMessage('error', 'Preencha todos os campos.', $redirect);
}

// Tenta autenticar via classe Auth
if (Auth::musicianLogin($musicianLogin, $musicianPassword)) {
    redirectWithMessage('success', 'Login efetuado com sucesso!', $redirectSuccess);
}

// Login inválido → salva mensagem e volta para o form
redirectWithMessage('error', 'Login ou senha inválidos.', $redirect);
