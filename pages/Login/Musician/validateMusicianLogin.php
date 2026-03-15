<?php

// Carrega config do projeto
require_once '../../../config/config.php';

// Carrega classe de autenticação (POO)
require_once BASE_PATH . 'app/Auth/Auth.php';

// Inicia sessão para salvar mensagens de erro
session_start();

// Bloqueia acesso direto via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: musicianLogin.php");
    exit;
}

// Captura os dados do formulário com fallback
$musiciansLogin = trim($_POST['login'] ?? '');
$musicianPassword = trim($_POST['password'] ?? '');

// Validação simples (campos vazios)
if ($musiciansLogin === '' || $musicianPassword === '') {
    $_SESSION['error'] = "Preencha todos os campos.";
    header("Location: musicianLogin.php");
    exit;
}

// Tenta autenticar via classe Auth
if (Auth::musicianLogin($musiciansLogin, $musicianPassword)) {

    $_SESSION['musician_login'] = $res['musician_login'];

    // Adiciona a mensagem de sucesso aqui, apenas no login
    $_SESSION['success'] = "Login efetuado com sucesso!";

    // Login OK → redireciona para a sessão do músico
    header("Location: " . BASE_URL . "pages/MusicianSession/musicianPage.php");
    exit;
}

// Login inválido → salva mensagem e volta para o form
$_SESSION['error'] = "Login ou senha inválidos.";
header("Location: musicianLogin.php");
exit;
