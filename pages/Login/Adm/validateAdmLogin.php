<?php

// Carrega config do projeto
require_once '../../../config/config.php';

// Carrega classe de autenticação (POO)
require_once BASE_PATH . 'app/Auth/Auth.php';

// Inicia sessão para salvar mensagens de erro
session_start();

// Bloqueia acesso direto via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admLogin.php");
    exit;
}

// Captura os dados do formulário com fallback
$loginAdm = trim($_POST['login'] ?? '');
$passwordAdm = trim($_POST['password'] ?? '');

// Validação simples (campos vazios)
if ($loginAdm === '' || $passwordAdm === '') {
    $_SESSION['error'] = "Preencha todos os campos.";
    header("Location: admLogin.php");
    exit;
}

// Tenta autenticar via classe Auth
if (Auth::loginRegency($loginAdm, $passwordAdm)) {

    $_SESSION['login'] = $res['regency_login'];

    // Adiciona a mensagem de sucesso aqui, apenas no login
    $_SESSION['success'] = "Login efetuado com sucesso!";

    // Login OK → redireciona para a sessão do maestro
    header("Location: " . BASE_URL . "pages/AdmSession/admPage.php");
    exit;
}

// Login inválido → salva mensagem e volta para o form
$_SESSION['error'] = "Login ou senha inválidos.";
header("Location: admLogin.php");
exit;
