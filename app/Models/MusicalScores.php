<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class MusicalScores
{

    /**
     * Adiciona uma nova partitura ao database.
     * 
     * @param string $musicName String com o nome da partitura
     * @param string $musicGenre String com o gênero da partitura
     * @param array $musicGroups Array contendo os grupos selecionados
     * @return int|false Retorna o id se a inserção for concluída ou false se não for
     */

    public static function AddMusicalScore(
        string $musicName,
        string $musicGenre,
        array $musicGroups
    ): int|false {

        $db = Database::getConnection();

        $db->begin_transaction();

        if (!empty($musicGroups)) {

            try {

                // Inserir partitura
                $stmt = $db->prepare(
                    "INSERT INTO musical_scores (music_name, music_genre) VALUES (?, ?)"
                );

                $stmt->bind_param("ss", $musicName, $musicGenre);

                if (!$stmt->execute()) {
                    throw new Exception("Erro ao inserir partitura.");
                }

                $musicId = $db->insert_id;

                $stmt->close();


                // Inserir grupos
                $stmtGroups = $db->prepare(
                    "INSERT INTO musical_scores_groups (music_id, group_id) VALUES (?, ?)"
                );

                foreach ($musicGroups as $groupId) {

                    $groupId = (int) $groupId;

                    $stmtGroups->bind_param("ii", $musicId, $groupId);

                    if (!$stmtGroups->execute()) {
                        throw new Exception("Erro ao vincular grupo.");
                    }
                }

                $stmtGroups->close();


                // Commit final
                $db->commit();

                return $musicId;

            } catch (\Exception $e) {

                $db->rollback();
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Edita uma partitura de acordo com o id.
     * 
     * @param int ID da partitura 
     * @param string $musicName String com o nome da partitura
     * @param string $musicGenre String com o gênero da partitura
     * @param array $musicGroups Array contendo os grupos selecionados
     * @param array $instrumentsVoiceOff Array contendo os arquivos dos instrumentos sem vozes
     * @param array $instruments Array contendo os arquivos dos instrumentos com vozes
     * @return bool Booleano (true, false)
     */

    public static function EditMusicalScore(
        int $musicId,
        string $musicName,
        string $musicGenre,
        array $musicGroups,
        array $instrumentsVoiceOff,
        array $instruments
    ): bool {

        $db = Database::getConnection();

        $db->begin_transaction();

        try {

            // Edição de características gerais
            $stmt = $db->prepare(
                "UPDATE musical_scores SET music_name= ?, music_genre= ? WHERE music_id = ?"
            );
            $stmt->bind_param("ssi", $musicName, $musicGenre, $musicId);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao editar partitura.");
            }

            $stmt->close();

            // Limpar grupos antigos
            $stmtDel = $db->prepare("DELETE FROM musical_scores_groups WHERE music_id = ?");
            $stmtDel->bind_param("i", $musicId);
            $stmtDel->execute();
            $stmtDel->close();

            // Inserir grupos novos
            if (!empty($musicGroups)) {
                $stmtGroups = $db->prepare(
                    "INSERT INTO musical_scores_groups (music_id, group_id) VALUES (?, ?)"
                );

                foreach ($musicGroups as $groupId) {
                    $groupId = (int) $groupId;
                    $stmtGroups->bind_param("ii", $musicId, $groupId);

                    if (!$stmtGroups->execute()) {
                        throw new Exception("Erro ao vincular grupo.");
                    }
                }

                $stmtGroups->close();
            }

            $stmtVoiceOff = $db->prepare("INSERT INTO musical_scores_instruments VALUES (?, ?, ?)");

            // Inserir instrumentos sem vozes
            foreach ($instrumentsVoiceOff as $instrumentVoiceOff => $file) {

                $baseInstrument = (int) $instrumentVoiceOff;

                for ($i = 0; $i < 3; $i++) {
                    $instrumentId = $baseInstrument + $i;

                    if (self::verifyInstrument($musicId, $instrumentId)) {

                        $oldFile = self::getFile($musicId, $instrumentId);

                        if ($oldFile) {
                            $path = BASE_PATH . "uploads/musical-scores/" . $oldFile;

                            if (file_exists($path)) {
                                unlink($path);
                            }
                        }

                        $stmtDel = $db->prepare("DELETE FROM musical_scores_instruments WHERE music_id = ? and instrument_id = ?");
                        $stmtDel->bind_param("ii", $musicId, $instrumentId);
                        $stmtDel->execute();
                        $stmtDel->close();
                    }

                    $stmtVoiceOff->bind_param("iis", $musicId, $instrumentId, $file);

                    if (!$stmtVoiceOff->execute()) {
                        throw new Exception("Erro ao editar partitura.");
                    }
                }
            }

            $stmtVoiceOff->close();

            $stmt = $db->prepare("INSERT INTO musical_scores_instruments VALUES (?, ?, ?)");

            // Inserir instrumentos com vozes
            foreach ($instruments as $instrument => $file) {
                $instrument = (int) $instrument;

                if (self::verifyInstrument($musicId, $instrument)) {

                    // Deleta os arquivos antigos
                    $oldFile = self::getFile($musicId, $instrument);

                    if ($oldFile) {
                        $path = BASE_PATH . "uploads/musical-scores/" . $oldFile;

                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }

                    $stmtDel = $db->prepare("DELETE FROM musical_scores_instruments WHERE music_id = ? and instrument_id = ?");
                    $stmtDel->bind_param("ii", $musicId, $instrument);
                    $stmtDel->execute();
                    $stmtDel->close();

                }

                $stmt->bind_param("iis", $musicId, $instrument, $file);

                if (!$stmt->execute()) {
                    throw new Exception("Erro ao editar partitura.");
                }

            }

            $stmt->close();

            // Commit final
            $db->commit();

            return true;

        } catch (\Exception $e) {
            $db->rollback();
            return false;
        }
    }

    /**
     * Apaga uma partitura do banco de dados.
     *
     * @param int $musicId Id do músico
     * @return bool Booleano (true, false)
     */

    public static function DeleteMusicalScoreGeneral(int $musicId): bool
    {
        $db = Database::getConnection();

        $db->begin_transaction();


        try {
            $stmtDelInstruments = $db->prepare("SELECT file FROM musical_scores_instruments WHERE music_id = ?");
            $stmtDelInstruments->bind_param("i", $musicId);
            $stmtDelInstruments->execute();

            $result = $stmtDelInstruments->get_result();

            $files = [];
            while ($row = $result->fetch_assoc()) {
                $files[] = $row['file'];
            }

            $stmtDelInstruments->close();

            self::DeleteMusicalScoreInstrument($musicId);

            $stmtDelGroups = $db->prepare("DELETE FROM musical_scores_groups 
            WHERE music_id = ?");
            $stmtDelGroups->bind_param("i", $musicId);
            $stmtDelGroups->execute();
            $stmtDelGroups->close();

            $stmt = $db->prepare("DELETE FROM musical_scores 
            WHERE music_id = ?");
            $stmt->bind_param("i", $musicId);
            $stmt->execute();
            $stmt->close();

            // Commit final
            $db->commit();

            foreach ($files as $file) {
                $path = BASE_PATH . 'uploads/musical-scores/' . $file;

                if ($file && file_exists($path)) {
                    unlink($path);
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    /**
     * Apaga o instrumento de uma partitura do banco de dados.
     *
     * @param int $musicId Id do músico
     * @param int $instrumentId Id da partitura
     * @param bool $voiceOff Se os instrumentos vão ter voz ou não
     * @return bool Booleano (true, false)
     */

    public static function DeleteMusicalScoreInstrument(int $musicId, int $instrumentId = 0, bool $voiceOff = false): bool
    {
        $db = Database::getConnection();

        if ($instrumentId == 0) {
            $stmt = $db->prepare("DELETE FROM musical_scores_instruments 
            WHERE music_id = ?");
            $stmt->bind_param("i", $musicId);
        } else {
            if (!$voiceOff) {
                $stmt = $db->prepare("DELETE FROM musical_scores_instruments 
                WHERE music_id = ? and instrument_id = ?");
                $stmt->bind_param("ii", $musicId, $instrumentId);
            } else {
                $secondVoice = $instrumentId + 1;
                $thirdVoice = $instrumentId + 2;

                $stmt = $db->prepare("DELETE FROM musical_scores_instruments 
                    WHERE music_id = ? and instrument_id IN (?, ?, ?)");
                $stmt->bind_param("iiii", $musicId, $instrumentId, $secondVoice, $thirdVoice);
            }
        }

        $stmt->execute();

        $affected = $stmt->affected_rows;

        $stmt->close();

        return $affected > 0;
    }

    /**
     * Retorna todos as partituras do banco, selecionados por grupos da banda, gênero ou os dois e * ordenados pelos mesmos.
     *
     * @param string $musicName nome da partitura
     * @param int $bandGroup grupo da banda
     * @param string $musicGenre gênero da partitura
     * @return array Array de músicos (cada músico é um array associativo)
     */

    public static function getAll(string $musicName = '', int $bandGroup = 0, string $musicGenre = ''): array
    {
        $db = Database::getConnection();

        $sql = "SELECT ms.*, msg.group_id 
            FROM musical_scores ms
            LEFT JOIN musical_scores_groups msg ON ms.music_id = msg.music_id";

        $conditions = [];
        $params = [];
        $types = "";

        if ($musicName !== '') {
            $conditions[] = "ms.music_name LIKE ?";
            $params[] = "%$musicName%";
            $types .= "s";
        }

        if ($musicGenre !== '') {
            $conditions[] = "ms.music_genre = ?";
            $params[] = $musicGenre;
            $types .= "s";
        }

        if ($bandGroup > 0) {
            $conditions[] = "msg.group_id = ?";
            $params[] = $bandGroup;
            $types .= "i";
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY ms.music_genre, ms.music_name";

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
        $musicsList = [];

        while ($row = $result->fetch_assoc()) {
            $musicsList[] = $row;
        }

        $stmt->close();

        return $musicsList;
    }

    /**
     * Retorna uma partitura específica pelo ID.
     *
     * @param int $musicId ID da partitura
     * @return array|null Array associativo com os dados ou null se não encontrado
     */
    public static function getById(int $musicId): ?array
    {
        $db = Database::getConnection();

        $sql = "SELECT ms.music_name, ms.music_genre, msg.music_id, msg.group_id, bg.group_id, bg.group_name 
        FROM musical_scores AS ms
        JOIN musical_scores_groups AS msg ON ms.music_id = msg.music_id
        JOIN band_groups AS bg ON msg.group_id = bg.group_id
        WHERE ms.music_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $musicId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ?: null;

    }

    /**
     * Retorna o arquivo da partitura de acordo com o id da partitura e o id do instrumento.
     *
     * @param int $musicId
     * @param int $instrumentId
     * @return string|null
     */
    public static function getFile(int $musicId, int $instrumentId): ?string
    {
        $db = Database::getConnection();

        $sql = "SELECT file 
            FROM musical_scores_instruments 
            WHERE music_id = ? AND instrument_id = ?
            LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $musicId, $instrumentId);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return $row['file'] ?? null;
    }

    /**
     * Verifica se existe determinado grupo de acordo com o id da música.
     *
     * @param int $musicId ID da partitura
     * @param int $groupId ID do grupo
     * @return bool Booleano(true, false)
     */
    public static function verifyGroup(int $musicId, int $groupId): ?bool
    {

        $db = Database::getConnection();

        $sql = "SELECT * FROM musical_scores_groups WHERE music_id = ? and group_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("ii", $musicId, $groupId);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        if ($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * Verifica se existe determinado instrumento de acordo com o id da música.
     *
     * @param int $musicId ID da partitura
     * @param int $instrumentId ID do instrumento
     * @return bool Booleano(true, false)
     */

    public static function verifyInstrument(int $musicId, int $instrumentId): ?bool
    {

        $db = Database::getConnection();

        $sql = "SELECT * FROM musical_scores_instruments WHERE music_id = ? and instrument_id = ? ";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("ii", $musicId, $instrumentId);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        if ($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }

    }
}
