<?php

// Carrega config do projeto
require_once '../../../../config/config.php';

// Carrega classe de autenticação (POO)
require_once BASE_PATH . 'app/Auth/Auth.php';

// Inicia sessão para salvar mensagens de erro
session_start();

$redirect = BASE_URL . 'pages/login/admin/index.php';
$redirectSuccess = BASE_URL . 'pages/admin/index.php';

// Bloqueia acesso direto via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $redirect);
    exit;
}

// Captura os dados do formulário com fallback
$admLogin = trim($_POST['user_login'] ?? $_POST['login'] ?? '');
$admPassword = trim($_POST['user_password'] ?? $_POST['password'] ?? '');

// Validação simples (campos vazios)
if ($admLogin === '' || $admPassword === '') {
    Message::set('error', "Preencha todos os campos.");
    header('Location: ' . $redirect);
    exit;
}

// Tenta autenticar via classe Auth
if (Auth::regencyLogin($admLogin, $admPassword)) {

    // Adiciona a mensagem de sucesso aqui, apenas no login
    Message::set('success', "Login efetuado com sucesso!");

    // Login OK → redireciona para a sessão do maestro
    header('Location: ' . $redirectSuccess);
    exit;
}

// Login inválido → salva mensagem e volta para o form
Message::set('error', "Login ou senha inválidos.");
header('Location: ' . $redirect);
exit;
