<?php
require_once BASE_PATH . "app/Services/RegencyService.php";

class RegencyController
{
    private RegencyService $service;

    public function __construct()
    {
        $this->service = new RegencyService();
    }

    public function findByLogin(string $login): ?Regency
    {
        return $this->service->findByLogin($login);
    }
}
