<?php

class Message
{
    public function setMessage(string $type, string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['flash_messages'][$type] = $message;
    }

    public function getMessage(string $type): ?string
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

    public function clearMessage(string $type): void
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