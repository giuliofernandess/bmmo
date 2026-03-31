<?php

class Regency
{
    private string $regencyLogin = '';
    private string $password = '';

    public static function fromArray(array $data): self
    {
        $entity = new self();
        $entity->setRegencyLogin((string) ($data['regency_login'] ?? ''));
        $entity->setPassword((string) ($data['password'] ?? ''));

        return $entity;
    }

    public function toArray(): array
    {
        return [
            'regency_login' => $this->regencyLogin,
            'password' => $this->password,
        ];
    }

    public function getRegencyLogin(): string
    {
        return $this->regencyLogin;
    }

    public function setRegencyLogin(string $regencyLogin): void
    {
        $this->regencyLogin = trim($regencyLogin);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
