<?php


require_once BASE_PATH . 'app/Database/Database.php';
require_once BASE_PATH . 'app/DAO/RegencyDAO.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';

class Auth
{
    


    public function redirectIfLoggedIn(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $role = $_SESSION['role'] ?? '';

        if (($role === 'regency' && isset($_SESSION['regency_login'])) || isset($_SESSION['regency_login'])) {
            header("Location: " . BASE_URL . "pages/admin/index.php");
            exit;
        }

        if (($role === 'musician' && isset($_SESSION['musician_login'])) || isset($_SESSION['musician_login'])) {
            header("Location: " . BASE_URL . "pages/musician/index.php");
            exit;
        }
    }


    public function logout(string $redirectUrl): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

    $messageHelper = new Message();
    $messageHelper->setMessage('success', 'Logout realizado com sucesso!');

        header("Location: " . $redirectUrl);
        exit;
    }


    




    public function regencyLogin(string $login, string $password): bool
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $conn = $database->getConnection();
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

    




    public function musicianLogin(string $login, string $password): bool
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $conn = $database->getConnection();
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

    


    public function requireRegency(): void
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        if (!isset($_SESSION['regency_login']) || ($_SESSION['role'] ?? '') !== 'regency') {
            header("Location: " . BASE_URL . "pages/login/admin/index.php");
            exit;
        }
    }

    


    public function requireMusician(): void
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
