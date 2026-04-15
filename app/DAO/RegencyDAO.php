<?php

require_once BASE_PATH . 'app/Models/Regency.php';

class RegencyDAO
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function findByLogin(string $login): ?Regency
    {
        
        $db = $this->conn;

        
        $sql = "SELECT regency_login, password FROM regency WHERE regency_login = ?";
        $stmt = $db->prepare($sql);

        
        if (!$stmt) {
            return null;
        }

        
        $stmt->bind_param("s", $login);
        $stmt->execute();

        
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        
        return $data ? Regency::fromArray($data) : null;
    }
}
