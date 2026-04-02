<?php

class Message
{
    public static function set(string $type, string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['flash_messages'][$type] = $message;
    }

    public static function pull(string $type): ?string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['flash_messages'][$type])) {
            return null;
        }

        $message = $_SESSION['flash_messages'][$type];
        unset($_SESSION['flash_messages'][$type]);

        if (empty($_SESSION['flash_messages'])) {
            unset($_SESSION['flash_messages']);
        }

        return $message;
    }
}