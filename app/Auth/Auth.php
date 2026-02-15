<?php

// Model responsável por consultar o maestro no banco
require_once BASE_PATH . 'app/Models/Regency.php';

class Auth
{
    /**
     * Faz logout limpando a sessão e redirecionando para uma URL.
     */
    public static function logout(string $redirectUrl): void
    {
        // Garante que a sessão está ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Remove dados e destrói sessão
        session_unset();
        session_destroy();

        // Redireciona
        header("Location: " . $redirectUrl);
        exit;
    }

    /**
     * Faz login do maestro (regency).
     * Retorna true se autenticou, false se falhou.
     */
    public static function loginRegency(string $login, string $password): bool
    {
        // Garante sessão ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Busca o usuário no banco
        $user = Regency::findByLogin($login);

        // Usuário não encontrado
        if (!$user) {
            return false;
        }

        /**
         * ⚠️ Sua senha no banco está em texto puro.
         * (mais pra frente podemos migrar para password_hash)
         */
        if ($password !== $user['password']) {
            return false;
        }

        // Login OK: salva dados na sessão
        $_SESSION['regency_login'] = $user['regency_login'];
        $_SESSION['role'] = 'regency';

        return true;
    }

    /**
     * Protege páginas do maestro.
     * Se não estiver logado, manda para o login.
     */
    public static function requireRegency(): void
    {
        // Garante sessão ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Se não estiver logado corretamente, redireciona
        if (!isset($_SESSION['regency_login']) || ($_SESSION['role'] ?? '') !== 'regency') {
            header("Location: " . BASE_URL . "pages/Login/Adm/admLogin.php");
            exit;
        }
    }
}
