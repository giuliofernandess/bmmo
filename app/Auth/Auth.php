<?php

// Camada de autenticação e autorização da aplicação.
require_once BASE_PATH . 'app/Database/Database.php';
require_once BASE_PATH . 'app/DAO/RegencyDAO.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';

class Auth
{
    /**
    * Encerra a sessão do usuário e redireciona para a rota informada.
     */
    public static function logout(string $redirectUrl): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        Message::set('success', 'Logout realizado com sucesso!');

        header("Location: " . $redirectUrl);
        exit;
    }


    /**
        * Autentica um usuário com perfil de maestro.
        *
        * @return bool true quando login e senha são válidos.
     */
    public static function regencyLogin(string $login, string $password): bool
    {
        // Garante sessão ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $conn = Database::getConnection();
        $regencyDAO = new RegencyDAO($conn);

        // Busca o usuário no banco.
        $user = $regencyDAO->findByLogin($login);

        // Usuário não encontrado.
        if (!$user) {
            return false;
        } elseif (!password_verify($password, $user->getPassword())) {
            return false;
        } else {

            // Login válido: salva dados na sessão.
            $_SESSION['regency_login'] = $user->getRegencyLogin();
            $_SESSION['role'] = 'regency';

            return true;
        }

    }

    /**
        * Autentica um usuário com perfil de músico.
        *
        * @return bool true quando login e senha são válidos.
     */
    public static function musicianLogin(string $login, string $password): bool
    {
        // Garante sessão ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $conn = Database::getConnection();
        $musiciansDAO = new MusiciansDAO($conn);

        // Busca o usuário no banco.
        $user = $musiciansDAO->findByLogin($login);

        // Usuário não encontrado.
        if (!$user) {
            return false;
        } elseif (!password_verify($password, $user->getPassword())) {
            return false;
        } else {

            // Login válido: salva dados na sessão.
            $_SESSION['musician_login'] = $user->getMusicianLogin();
            $_SESSION['role'] = 'musician';

            return true;
        }

    }

    /**
        * Exige sessão válida de maestro para acessar a página.
     */
    public static function requireRegency(): void
    {
        // Garante sessão ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Se não estiver logado corretamente, redireciona.
        if (!isset($_SESSION['regency_login']) || ($_SESSION['role'] ?? '') !== 'regency') {
            header("Location: " . BASE_URL . "pages/login/admin/index.php");
            exit;
        }
    }

    /**
        * Exige sessão válida de músico para acessar a página.
     */
    public static function requireMusician(): void
    {
        // Garante sessão ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Se não estiver logado corretamente, redireciona.
        if (!isset($_SESSION['musician_login']) || ($_SESSION['role'] ?? '') !== 'musician') {
            header("Location: " . BASE_URL . "pages/login/musician/index.php");
            exit;
        }
    }
}
