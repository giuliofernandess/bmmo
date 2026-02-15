<?php

class Auth
{
    public static function logout(string $redirectUrl): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header("Location: " . $redirectUrl);
        exit;
    }
}

?>