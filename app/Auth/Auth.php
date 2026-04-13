<?php


require_once BASE_PATH . 'app/Database/Database.php';
require_once BASE_PATH . 'app/DAO/RegencyDAO.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';

class Auth
{
    


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


    




    public static function regencyLogin(string $login, string $password): bool
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $conn = Database::getConnection();
        $regencyDAO = new RegencyDAO($conn);

        
        $user = $regencyDAO->findByLogin($login);

        
        if (!$user) {
            return false;
        } elseif (!password_verify($password, $user->getPassword())) {
            return false;
        } else {

            
            $_SESSION['regency_login'] = $user->getRegencyLogin();
            $_SESSION['role'] = 'regency';

            return true;
        }

    }

    




    public static function musicianLogin(string $login, string $password): bool
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $conn = Database::getConnection();
        $musiciansDAO = new MusiciansDAO($conn);

        
        $user = $musiciansDAO->findByLogin($login);

        
        if (!$user) {
            return false;
        } elseif (!password_verify($password, $user->getPassword())) {
            return false;
        } else {

            
            $_SESSION['musician_login'] = $user->getMusicianLogin();
            $_SESSION['role'] = 'musician';

            return true;
        }

    }

    


    public static function requireRegency(): void
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        if (!isset($_SESSION['regency_login']) || ($_SESSION['role'] ?? '') !== 'regency') {
            header("Location: " . BASE_URL . "pages/login/admin/index.php");
            exit;
        }
    }

    


    public static function requireMusician(): void
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        if (!isset($_SESSION['musician_login']) || ($_SESSION['role'] ?? '') !== 'musician') {
            header("Location: " . BASE_URL . "pages/login/musician/index.php");
            exit;
        }
    }
}
