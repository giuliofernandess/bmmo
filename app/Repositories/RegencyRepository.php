<?php
require_once BASE_PATH . 'app/Database/Database.php';

class RegencyRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByLogin(string $login): ?Regency
    {
        $stmt = $this->db->prepare("SELECT regency_login, password FROM regency WHERE regency_login = ?");
        
        if (!$stmt)
            return null;

        $stmt->bind_param("s", $login);
        $stmt->execute();

        $res = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$res)
            return null;

        $regency = new Regency();
        $regency->hydrate($res);

        return $regency;
    }
}
