<?php

require_once BASE_PATH . 'app/Models/BandGroup.php';

class BandGroupsDAO
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getAll(): array
    {
        $db = $this->conn;

        $sql = "SELECT * FROM band_groups ORDER BY group_id";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $groupsList = [];

        while ($row = $result->fetch_assoc()) {
            $groupsList[] = BandGroup::fromArray($row);
        }

        $stmt->close();

        return $groupsList;
    }
}
