<?php
require_once BASE_PATH . "app/Models/Regency.php";
require_once BASE_PATH . "app/Repositories/RegencyRepository.php";

class RegencyService
{
    private RegencyRepository $repo;

    public function __construct()
    {
        $this->repo = new RegencyRepository();
    }

    public function findByLogin(string $login): ?Regency
    {
        return $this->repo->findByLogin($login);
    }
}
