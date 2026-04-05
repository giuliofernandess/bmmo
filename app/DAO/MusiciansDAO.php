<?php

require_once BASE_PATH . 'app/Models/EntityInterface.php';
require_once BASE_PATH . 'app/Models/Musician.php';

class MusiciansDAO implements EntityInterface
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Cria um novo músico.
     */

    public function create(object $entity): mixed
    {
        $db = $this->conn;

        if (!$entity instanceof Musician) {
            return false;
        }

        // Normaliza os dados recebidos para persistência.
        $musicianName = $entity->getMusicianName();
        $login = $entity->getMusicianLogin();

        $dateOfBirth = $entity->getDateOfBirth();
        $birthObj = $dateOfBirth ? DateTime::createFromFormat('Y-m-d', $dateOfBirth) : null;
        $birth = $birthObj ? $birthObj->format('Y-m-d') : null;

        $instrument = $entity->getInstrument();
        $bandGroup = $entity->getBandGroup();

        $musicianContact = $entity->getMusicianContact();
        $responsibleName = $entity->getResponsibleName();
        $responsibleContact = $entity->getResponsibleContact();
        $neighborhood = $entity->getNeighborhood();
        $institution = $entity->getInstitution();

        $profileImage = $entity->getProfileImage();

        // Gera hash seguro da senha.
        $passwordRaw = $entity->getPassword();

        if (!$passwordRaw) {
            return false;
        }

        $password = password_hash($passwordRaw, PASSWORD_DEFAULT);


        // Persiste músico no banco.
        try {

            $stmt = $db->prepare(
                "INSERT INTO musicians (musician_name, musician_login, date_of_birth, instrument, band_group, musician_contact, responsible_name, responsible_contact, neighborhood, institution, profile_image, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("sssiisssssss", $musicianName, $login, $birth, $instrument, $bandGroup, $musicianContact, $responsibleName, $responsibleContact, $neighborhood, $institution, $profileImage, $password);

            $success = $stmt->execute();

            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Atualiza dados administrativos do músico.
     */

    public function edit(object $entity): bool
    {
        $db = $this->conn;

        if (!$entity instanceof Musician) {
            return false;
        }

        $musicianId = (int) ($entity->getMusicianId() ?? 0);
        $musicianLogin = $entity->getMusicianLogin();

        $instrument = $entity->getInstrument();
        $bandGroup = $entity->getBandGroup();

        $musicianContact = $entity->getMusicianContact();
        $responsibleName = $entity->getResponsibleName();
        $responsibleContact = $entity->getResponsibleContact();
        $neighborhood = $entity->getNeighborhood();
        $institution = $entity->getInstitution();

        $profileImage = $entity->getProfileImage();

        try {

            // Atualiza sem mexer na senha
            $stmt = $db->prepare("
                UPDATE musicians 
                SET musician_login = ?, 
                    instrument = ?, 
                    band_group = ?, 
                    musician_contact = ?, 
                    responsible_name = ?, 
                    responsible_contact = ?, 
                    neighborhood = ?, 
                    institution = ?, 
                    profile_image = ?
                WHERE musician_id = ?
            ");

            $stmt->bind_param(
                "siissssssi",
                $musicianLogin,
                $instrument,
                $bandGroup,
                $musicianContact,
                $responsibleName,
                $responsibleContact,
                $neighborhood,
                $institution,
                $profileImage,
                $musicianId
            );

            $success = $stmt->execute();

            $stmt->close();

            return $success;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Atualiza os dados do próprio músico logado.
     */

    public function editOwnProfile(object $entity): bool
    {
        $db = $this->conn;

        if (!$entity instanceof Musician) {
            return false;
        }

        $musicianId = (int) ($entity->getMusicianId() ?? 0);

        $musicianContact = $entity->getMusicianContact();
        $responsibleName = $entity->getResponsibleName();
        $responsibleContact = $entity->getResponsibleContact();
        $neighborhood = $entity->getNeighborhood();
        $institution = $entity->getInstitution();

        try {

            // Atualiza sem mexer na senha
            $stmt = $db->prepare("
                UPDATE musicians 
                SET musician_contact = ?, 
                    responsible_name = ?, 
                    responsible_contact = ?, 
                    neighborhood = ?, 
                    institution = ?
                WHERE musician_id = ?
            ");

            $stmt->bind_param(
                "sssssi",
                $musicianContact,
                $responsibleName,
                $responsibleContact,
                $neighborhood,
                $institution,
                $musicianId
            );

            $success = $stmt->execute();

            $stmt->close();

            return $success;

        } catch (\Exception $e) {
            return false;
        }
    }
    

    /**
     * Atualiza a senha de um músico.
     */

    public function editPassword(int $musicianId, string $newPassword): bool
    {
        $db = $this->conn;

        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        try {
            $stmt = $db->prepare("UPDATE musicians SET password = ? WHERE musician_id = ?");
            $stmt->bind_param("si", $passwordHash, $musicianId);

            $success = $stmt->execute();

            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * Remove um músico por ID.
     */

    public function delete(int $musicianId): bool
    {
        $db = $this->conn;

        $stmt = $db->prepare("DELETE FROM musicians WHERE musician_id = ?");
        $stmt->bind_param("i", $musicianId);
        $stmt->execute();

        $affected = $stmt->affected_rows;

        $stmt->close();

        return $affected > 0;
    }

    /**
     * Busca músico por login.
     */
    public function findByLogin(string $login): ?Musician
    {
        $db = $this->conn;

        $sql = "SELECT * FROM musicians WHERE musician_login = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("s", $login);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ? Musician::fromArray($data) : null;
    }


    /**
     * Lista músicos com filtros opcionais de nome, grupo e instrumento.
     */

    public function getAll(array $filters = []): array
    {
        $db = $this->conn;

        $musicianName = (string) ($filters['musician_name'] ?? '');
        $bandGroup = (int) ($filters['band_group'] ?? 0);
        $instrument = (int) ($filters['instrument'] ?? 0);

        $sql = "SELECT * FROM musicians";
        $conditions = [];
        $params = [];
        $types = "";

        if ($musicianName !== '') {
            $conditions[] = "musician_name LIKE ?";
            $params[] = "%$musicianName%";
            $types .= "s";
        }

        if ($bandGroup !== 0) {
            $conditions[] = "band_group = ?";
            $params[] = $bandGroup;
            $types .= "i";
        }

        if ($instrument !== 0) {
            $conditions[] = "instrument = ?";
            $params[] = $instrument;
            $types .= "i";
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY instrument, band_group, musician_name";

        $stmt = $db->prepare($sql);
        if (!$stmt) {
            return [];
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $musicians = [];

        while ($row = $result->fetch_assoc()) {
            $musicians[] = Musician::fromArray($row);
        }

        $stmt->close();

        return $musicians;
    }

    /**
     * Busca músico por ID.
     */
    public function getById(int $musicianId): ?Musician
    {
        $db = $this->conn;

        $sql = "SELECT * FROM musicians WHERE musician_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $musicianId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ? Musician::fromArray($data) : null;
    }

    /**
     * Retorna o nome do arquivo da foto de perfil do músico.
     */

    public function getProfileImage(int $musicianId): string
    {
        $db = $this->conn;

        $stmt = $db->prepare("SELECT profile_image FROM musicians WHERE musician_id = ?");
        $stmt->bind_param("i", $musicianId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        if (!$data) {
            return '';
        }

        return (string) ($data['profile_image'] ?? '');
    }


    /**
     * Verifica se já existe um músico com o login informado.
     */

    public function verifyLogin(string $musicianLogin): bool
    {
        $db = $this->conn;

        $stmt = $db->prepare("SELECT musician_login FROM musicians WHERE musician_login = ?");

        $stmt->bind_param("s", $musicianLogin);
        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

}
