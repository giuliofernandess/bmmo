<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class Musicians
{
    /**
     * Resgistra um novo músico.
     * 
     * @param array $musicianInfo Array de informações do músico
     * @return bool Booleano (true, false)
     */

    public static function musicianRegister(array $musicianInfo): bool
    {
        $db = Database::getConnection();

        function sanitizeValue($value, string $type = 'string')
        {
            if ($value === null) {
                return null;
            }

            if ($type === 'int') {
                return (int) $value;
            }

            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }

        // Sanitização dos dados
        $musicianName = sanitizeValue($musicianInfo['name'] ?? null);
        $login = sanitizeValue($musicianInfo['login'] ?? null);

        $dateOfBirth = sanitizeValue($musicianInfo['birth'] ?? null);
        $birthObj = $dateOfBirth ? DateTime::createFromFormat('Y-m-d', $dateOfBirth) : null;
        $birth = $birthObj ? $birthObj->format('Y-m-d') : null;

        $instrument = sanitizeValue($musicianInfo['instrument'] ?? null, 'int');
        $bandGroup = sanitizeValue($musicianInfo['band_group'] ?? null, 'int');

        $musicianContact = sanitizeValue($musicianInfo['musician_contact'] ?? null);
        $responsibleName = sanitizeValue($musicianInfo['responsible_name'] ?? null);
        $responsibleContact = sanitizeValue($musicianInfo['responsible_contact'] ?? null);
        $neighborhood = sanitizeValue($musicianInfo['neighborhood'] ?? null);
        $institution = sanitizeValue($musicianInfo['institution'] ?? null);

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
            $db->close();

            return $success;
        } catch (\Exception $e) {
            $db->close();
            return false;
        }
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
