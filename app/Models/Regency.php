<?php

class Regency
{
    private string $login;
    private string $password;

    public function hydrate(array $data): void
    {
        $this->login = $data['regency_login'];
        $this->password = $data['password'];
    }

    // Getters
    public function getLogin() { return $this->login; }
    public function getPassword() { return $this->password; }

    // Setters
    public function setLogin($v) { $this->login = trim($v); }
    public function setPassword($v) { $this->password = $v; }
}
