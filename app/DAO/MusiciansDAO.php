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

    public function create(array $musicianInfo): mixed
    {
        $db = $this->conn;

        $musician = Musician::fromArray([
            'musician_name' => $musicianInfo['name'] ?? null,
            'musician_login' => $musicianInfo['login'] ?? null,
            'date_of_birth' => $musicianInfo['birth'] ?? null,
            'instrument' => $musicianInfo['instrument'] ?? null,
            'band_group' => $musicianInfo['band_group'] ?? null,
            'musician_contact' => $musicianInfo['musician_contact'] ?? null,
            'responsible_name' => $musicianInfo['responsible_name'] ?? null,
            'responsible_contact' => $musicianInfo['responsible_contact'] ?? null,
            'neighborhood' => $musicianInfo['neighborhood'] ?? null,
            'institution' => $musicianInfo['institution'] ?? null,
            'profile_image' => $musicianInfo['profile_image'] ?? null,
            'password' => $musicianInfo['password'] ?? null,
        ]);

        // Normaliza os dados recebidos para persistência.
        $musicianName = $musician->getMusicianName();
        $login = $musician->getMusicianLogin();

        $dateOfBirth = $musician->getDateOfBirth();
        $birthObj = $dateOfBirth ? DateTime::createFromFormat('Y-m-d', $dateOfBirth) : null;
        $birth = $birthObj ? $birthObj->format('Y-m-d') : null;

        $instrument = $musician->getInstrument();
        $bandGroup = $musician->getBandGroup();

        $musicianContact = $musician->getMusicianContact();
        $responsibleName = $musician->getResponsibleName();
        $responsibleContact = $musician->getResponsibleContact();
        $neighborhood = $musician->getNeighborhood();
        $institution = $musician->getInstitution();

        $profileImage = $musician->getProfileImage();

        // Gera hash seguro da senha.
        $passwordRaw = $musician->getPassword();

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

    public function edit(array $musicianInfo): bool
    {
        $db = $this->conn;

        $musician = Musician::fromArray([
            'musician_id' => $musicianInfo['id'] ?? null,
            'musician_login' => $musicianInfo['login'] ?? null,
            'instrument' => $musicianInfo['instrument'] ?? null,
            'band_group' => $musicianInfo['band_group'] ?? null,
            'musician_contact' => $musicianInfo['musician_contact'] ?? null,
            'responsible_name' => $musicianInfo['responsible_name'] ?? null,
            'responsible_contact' => $musicianInfo['responsible_contact'] ?? null,
            'neighborhood' => $musicianInfo['neighborhood'] ?? null,
            'institution' => $musicianInfo['institution'] ?? null,
            'profile_image' => $musicianInfo['profile_image'] ?? null,
            'password' => $musicianInfo['password'] ?? null,
        ]);

        $musicianId = (int) ($musician->getMusicianId() ?? 0);
        $musicianLogin = $musician->getMusicianLogin();

        $instrument = $musician->getInstrument();
        $bandGroup = $musician->getBandGroup();

        $musicianContact = $musician->getMusicianContact();
        $responsibleName = $musician->getResponsibleName();
        $responsibleContact = $musician->getResponsibleContact();
        $neighborhood = $musician->getNeighborhood();
        $institution = $musician->getInstitution();

        $profileImage = $musician->getProfileImage();
        $passwordRaw = $musician->getPassword();

        try {

            // Se a senha foi informada, atualiza também
            if (!empty($passwordRaw)) {

                $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

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
                    profile_image = ?, 
                    password = ?
                WHERE musician_id = ?
            ");

                $stmt->bind_param(
                    "siisssssssi",
                    $musicianLogin,
                    $instrument,
                    $bandGroup,
                    $musicianContact,
                    $responsibleName,
                    $responsibleContact,
                    $neighborhood,
                    $institution,
                    $profileImage,
                    $password,
                    $musicianId
                );

            } else {

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
            }

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

    public function editOwnProfile(array $musicianInfo): bool
    {
        $db = $this->conn;

        $musician = Musician::fromArray([
            'musician_id' => $musicianInfo['id'] ?? null,
            'musician_contact' => $musicianInfo['musician_contact'] ?? null,
            'responsible_name' => $musicianInfo['responsible_name'] ?? null,
            'responsible_contact' => $musicianInfo['responsible_contact'] ?? null,
            'neighborhood' => $musicianInfo['neighborhood'] ?? null,
            'institution' => $musicianInfo['institution'] ?? null,
            'password' => $musicianInfo['password'] ?? null,
        ]);

        $musicianId = (int) ($musician->getMusicianId() ?? 0);

        $musicianContact = $musician->getMusicianContact();
        $responsibleName = $musician->getResponsibleName();
        $responsibleContact = $musician->getResponsibleContact();
        $neighborhood = $musician->getNeighborhood();
        $institution = $musician->getInstitution();

        $passwordRaw = $musician->getPassword();

        try {

            // Se a senha foi informada, atualiza também
            if (!empty($passwordRaw)) {

                $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

                $stmt = $db->prepare("
                UPDATE musicians 
                SET musician_contact = ?, 
                    responsible_name = ?, 
                    responsible_contact = ?, 
                    neighborhood = ?, 
                    institution = ?, 
                    password = ?
                WHERE musician_id = ?
            ");

                $stmt->bind_param(
                    "ssssssi",
                    $musicianContact,
                    $responsibleName,
                    $responsibleContact,
                    $neighborhood,
                    $institution,
                    $password,
                    $musicianId
                );

            } else {

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
            }

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
    public function findByLogin(string $login): ?array
    {
        // Usa conexão ativa do DAO.
        $db = $this->conn;

        // Consulta preparada.
        $sql = "SELECT m.*, i.instrument_name, bg.group_name FROM musicians AS m 
        JOIN instruments AS i ON i.instrument_id = m.instrument
        JOIN band_groups AS bg ON bg.group_id = m.band_group
        WHERE musician_login = ?";
        $stmt = $db->prepare($sql);

        // Falha de preparação.
        if (!$stmt) {
            return null;
        }

        // Vincula parâmetros e executa.
        $stmt->bind_param("s", $login);
        $stmt->execute();

        // Lê resultado.
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        // Retorna array com dados ou null se vazio.
        return $data ?: null;
    }


    /**
     * Lista músicos com filtros opcionais de nome, grupo e instrumento.
     */

    public function getAll(...$filters): array
    {
        $db = $this->conn;

        $musicianName = (string) ($filters[0] ?? '');
        $bandGroup = (int) ($filters[1] ?? 0);
        $instrument = (int) ($filters[2] ?? 0);

        $sql = "SELECT m.musician_id, m.musician_name, i.instrument_name, bg.group_name, m.profile_image FROM musicians AS m";
        $conditions = [];
        $params = [];
        $types = "";

        $sql .= " JOIN instruments AS i ON i.instrument_id = m.instrument
                JOIN band_groups AS bg ON bg.group_id = m.band_group";

        if ($musicianName !== '') {
            $conditions[] = "m.musician_name LIKE ?";
            $params[] = "%$musicianName%";
            $types .= "s";
        }

        if ($bandGroup !== 0) {
            $conditions[] = "m.band_group = ?";
            $params[] = $bandGroup;
            $types .= "i";
        }

        if ($instrument !== 0) {
            $conditions[] = "m.instrument = ?";
            $params[] = $instrument;
            $types .= "i";
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY m.instrument, m.band_group, m.musician_name";

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
        $musiciansList = [];

        while ($row = $result->fetch_assoc()) {
            $musiciansList[] = $row;
        }

        $stmt->close();

        return $musiciansList;
    }

    /**
     * Busca músico por ID.
     */
    public function getById(int $musicianId): ?array
    {
        $db = $this->conn;

        $sql = "SELECT m.*, i.instrument_name, bg.group_name  
        FROM musicians AS m 
        JOIN instruments AS i ON i.instrument_id = m.instrument
        JOIN band_groups AS bg ON bg.group_id = m.band_group
        WHERE m.musician_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $musicianId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ?: null;
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

        return $data['profile_image'] ?? '';
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
