<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class Musicians
{

    /**
     * Usada para sanitização de variáveis.
     * 
     * @param $value Valor da variável
     * @param array $type Tipo da variável
     * @return int|string|null Retorna a variável sanitizada ou null
     */

    private static function sanitizeValue($value, string $type = 'string')
    {
        if ($value === null) {
            return null;
        }

        if ($type === 'int') {
            return (int) $value;
        }

        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Resgistra um novo músico.
     * 
     * @param array $musicianInfo Array de informações do músico
     * @return bool Booleano (true, false)
     */

    public static function musicianRegister(array $musicianInfo): bool
    {
        $db = Database::getConnection();

        // Sanitização dos dados
        $musicianName = self::sanitizeValue($musicianInfo['name'] ?? null);
        $login = self::sanitizeValue($musicianInfo['login'] ?? null);

        $dateOfBirth = self::sanitizeValue($musicianInfo['birth'] ?? null);
        $birthObj = $dateOfBirth ? DateTime::createFromFormat('Y-m-d', $dateOfBirth) : null;
        $birth = $birthObj ? $birthObj->format('Y-m-d') : null;

        $instrument = self::sanitizeValue($musicianInfo['instrument'] ?? null, 'int');
        $bandGroup = self::sanitizeValue($musicianInfo['band_group'] ?? null, 'int');

        $musicianContact = self::sanitizeValue($musicianInfo['musician_contact'] ?? null);
        $responsibleName = self::sanitizeValue($musicianInfo['responsible_name'] ?? null);
        $responsibleContact = self::sanitizeValue($musicianInfo['responsible_contact'] ?? null);
        $neighborhood = self::sanitizeValue($musicianInfo['neighborhood'] ?? null);
        $institution = self::sanitizeValue($musicianInfo['institution'] ?? null);

        $profileImage = $musicianInfo['profile_image'] ?? null;

        // Senha hash
        $passwordRaw = $musicianInfo['password'] ?? null;

        if (!$passwordRaw) {
            return false;
        }

        $password = password_hash($passwordRaw, PASSWORD_DEFAULT);


        // Inserção no bando de dados
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
     * Edita um músico.
     * 
     * @param array $musicianInfo Array de informações do músico
     * @return bool Booleano (true, false)
     */

    public static function musicianEdit(array $musicianInfo): bool
    {
        $db = Database::getConnection();

        $musicianId = self::sanitizeValue($musicianInfo['id'] ?? null, 'int');
        $musicianLogin = self::sanitizeValue($musicianInfo['login'] ?? null);

        $instrument = self::sanitizeValue($musicianInfo['instrument'] ?? null, 'int');
        $bandGroup = self::sanitizeValue($musicianInfo['band_group'] ?? null, 'int');

        $musicianContact = self::sanitizeValue($musicianInfo['musician_contact'] ?? null);
        $responsibleName = self::sanitizeValue($musicianInfo['responsible_name'] ?? null);
        $responsibleContact = self::sanitizeValue($musicianInfo['responsible_contact'] ?? null);
        $neighborhood = self::sanitizeValue($musicianInfo['neighborhood'] ?? null);
        $institution = self::sanitizeValue($musicianInfo['institution'] ?? null);

        $profileImage = $musicianInfo['profile_image'] ?? null;
        $passwordRaw = $musicianInfo['password'] ?? null;

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
     * Apaga uma linha do banco de dados.
     *
     * @param int $musicianId Id do músico
     * @return bool Booleano (true, false)
     */

    public static function deleteMusician(int $musicianId): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM musicians WHERE musician_id = ?");
        $stmt->bind_param("i", $musicianId);
        $stmt->execute();

        $affected = $stmt->affected_rows;

        $stmt->close();

        return $affected > 0;
    }


    /**
     * Retorna todos os músicos do banco, selecionados por grupo da banda, instrumento ou os dois e * ordenados pelos mesmos.
     *
     * @param string $musicianName nome do músico
     * @param int $bandGroup grupo da banda
     * @param int $instrument instrumento
     * @return array Array de músicos (cada músico é um array associativo)
     */

    public static function getAll(string $musicianName = '', int $bandGroup = 0, int $instrument = 0): array
    {
        $db = Database::getConnection();

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
     * Retorna um músico específica pelo ID.
     *
     * @param int $musicianId ID do músico
     * @return array|null Array associativo com os dados ou null se não encontrado
     */
    public static function getById(int $musicianId): ?array
    {
        $db = Database::getConnection();

        $sql = "SELECT m.musician_name, m.musician_login, m.instrument, i.instrument_name, m.band_group, bg.group_name, m.date_of_birth, m.musician_contact, m.neighborhood, m.institution, m.responsible_name, m.responsible_contact, m.profile_image 
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
     * Recebe a imagem do músico.
     *
     * @param int $musicianId Id do músico
     * @return string Imagem do músico
     */

    public static function getProfileImage(int $musicianId): string
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT profile_image FROM musicians WHERE musician_id = ?");
        $stmt->bind_param("i", $musicianId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data['profile_image'] ?? '';
    }


    /**
     * Verifica se o login do músico a ser registrado já existe.
     *
     * @param string $musicianLogin Login do músico
     * @return bool Booleano (true, false)
     */

    public static function verifyLogin(string $musicianLogin): bool
    {
        $db = Database::getConnection();

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

    /**
     * Verifica se a data de nascimento do músico é válida.
     *
     * @param string $dateOfBirth Data de nascimento do músico
     * @return bool Booleano (true, false)
     */
    public static function ageVerification(string $dateOfBirth): bool
    {

        $birth = DateTime::createFromFormat('Y-m-d', $dateOfBirth);
        $today = new DateTime();
        $age = $today->diff($birth)->y;

        if ($birth > $today) {
            return false;
        } else if ($age < 7 || $age > 100) {
            return false;
        } else {
            return true;
        }

    }
}
