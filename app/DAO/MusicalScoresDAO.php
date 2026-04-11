<?php

require_once BASE_PATH . 'app/Models/EntityInterface.php';
require_once BASE_PATH . 'app/Models/MusicalScore.php';

class MusicalScoresDAO implements EntityInterface
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Cria uma nova partitura com grupos vinculados.
     */
    public function create(object $entity): mixed
    {
        if (!$entity instanceof MusicalScore) {
            return false;
        }

        $db = $this->conn;

        $musicName = $entity->getMusicName();
        $musicGenre = $entity->getMusicGenre();
        $musicGroups = $entity->getMusicGroups();

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


                // Confirma transação.
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
     * Atualiza uma partitura e seus vínculos de grupos/instrumentos.
     */

    public function edit(object $entity): bool
    {
        if (!$entity instanceof MusicalScore) {
            return false;
        }

        $db = $this->conn;

        $musicId = (int) ($entity->getMusicId() ?? 0);
        $musicName = $entity->getMusicName();
        $musicGenre = $entity->getMusicGenre();
        $musicGroups = $entity->getMusicGroups();
        $instrumentsVoiceOff = $entity->getInstrumentsVoiceOff();
        $instruments = $entity->getInstruments();

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

                    if ($this->verifyInstrument($musicId, $instrumentId)) {

                        $oldFile = $this->getFile($musicId, $instrumentId);

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

                if ($this->verifyInstrument($musicId, $instrument)) {

                    // Deleta os arquivos antigos
                    $oldFile = $this->getFile($musicId, $instrument);

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

            // Confirma transação.
            $db->commit();

            return true;

        } catch (\Exception $e) {
            $db->rollback();
            return false;
        }
    }

    /**
     * Remove uma partitura e os vínculos relacionados.
     */

    public function delete(int $musicId): bool
    {
        $db = $this->conn;

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

            $stmt = $db->prepare("DELETE FROM musical_scores 
            WHERE music_id = ?");
            $stmt->bind_param("i", $musicId);
            $stmt->execute();
            $stmt->close();

            // Confirma transação.
            $db->commit();

            foreach ($files as $file) {
                $path = BASE_PATH . 'uploads/musical-scores/' . $file;

                if ($file && file_exists($path)) {
                    unlink($path);
                }
            }

            return true;
        } catch (Exception $e) {
            $db->rollback();
            return false;
        }

    }

    /**
     * Remove arquivo(s) de instrumento de uma partitura.
     */

    public function deleteMusicalScoreInstrument(int $musicId, int $instrumentId = 0, bool $voiceOff = false): bool
    {
        $db = $this->conn;

        if ($instrumentId === 0) {
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
     * Lista partituras com filtros opcionais de nome, grupo e gênero.
     */

    public function getAll(array $filters = []): array
    {
        $db = $this->conn;

        $musicName = (string) ($filters['music_name'] ?? '');
        $bandGroup = (int) ($filters['band_group'] ?? 0);
        $musicGenre = (string) ($filters['music_genre'] ?? '');

        $sql = "SELECT ms.* FROM musical_scores ms
            LEFT JOIN musical_scores_groups msg ON ms.music_id = msg.music_id";

        $conditions = [];
        $params = [];
        $types = "";

        if ($musicName !== '') {
            $conditions[] = "music_name LIKE ?";
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
        $musics = [];

        while ($row = $result->fetch_assoc()) {
            $musics[] = MusicalScore::fromArray($row);
        }

        $stmt->close();

        return $musics;
    }

    /**
     * Lista partituras filtradas por instrumento, grupo e filtros opcionais.
     */

    public function getAllByInstrument(int $instrumentId, int $groupId, string|null $musicName = '', string|null $musicGenre = ''): array
    {
        $db = $this->conn;
        $musicName = trim((string) ($musicName ?? ''));
        $musicGenre = trim((string) ($musicGenre ?? ''));

        $sql = "SELECT ms.* FROM musical_scores_groups AS msg
                JOIN musical_scores_instruments AS msi ON msg.music_id = msi.music_id
                JOIN musical_scores AS ms ON msg.music_id = ms.music_id
                WHERE msg.group_id = ? AND msi.instrument_id = ?";

        $conditions = [];
        $params = [$groupId, $instrumentId];
        $types = "ii";

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

        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
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
            $musicsList[] = MusicalScore::fromArray($row);
        }

        $stmt->close();

        return $musicsList;
    }

    /**
     * Busca partitura por ID.
     */
    public function getById(int $musicId): ?MusicalScore
    {
        $db = $this->conn;

        $sql = "SELECT * FROM musical_scores WHERE music_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $musicId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ? MusicalScore::fromArray($data) : null;
    }

    /**
     * Retorna o nome do arquivo de partitura para um instrumento.
     */
    public function getFile(int $musicId, int $instrumentId): ?string
    {
        $db = $this->conn;

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
     * Verifica se um grupo está vinculado à partitura.
     */
    public function verifyGroup(int $musicId, int $groupId): ?bool
    {

        $db = $this->conn;

        $sql = "SELECT * FROM musical_scores_groups WHERE music_id = ? and group_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("ii", $musicId, $groupId);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        if ($result->num_rows === 0) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * Verifica se um instrumento está vinculado à partitura.
     */

    public function verifyInstrument(int $musicId, int $instrumentId): ?bool
    {

        $db = $this->conn;

        $sql = "SELECT * FROM musical_scores_instruments WHERE music_id = ? and instrument_id = ? ";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("ii", $musicId, $instrumentId);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        if ($result->num_rows === 0) {
            return false;
        } else {
            return true;
        }

    }
}
