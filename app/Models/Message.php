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

    public static function get(string $type): ?string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['flash_messages'][$type])) {
            return null;
        } else {
            return $_SESSION['flash_messages'][$type];
        }
        
    }

    public static function clear(string $type): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['flash_messages'][$type]);

        if (empty($_SESSION['flash_messages'])) {
            unset($_SESSION['flash_messages']);
        }
    }
}