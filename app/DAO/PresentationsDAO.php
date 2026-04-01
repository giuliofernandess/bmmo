<?php

require_once BASE_PATH . 'app/Models/EntityInterface.php';
require_once BASE_PATH . 'app/Models/Presentation.php';

class PresentationsDAO implements EntityInterface
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Cria uma apresentação com grupos e músicas vinculadas.
     */

    public function create(array $presentationInfo): mixed
    {
        $db = $this->conn;

        $db->begin_transaction();

        $presentation = Presentation::fromArray([
            'presentation_name' => $presentationInfo['name'] ?? '',
            'presentation_date' => $presentationInfo['date'] ?? '',
            'presentation_hour' => $presentationInfo['hour'] ?? '',
            'local_of_presentation' => $presentationInfo['local'] ?? '',
        ]);

        // Normaliza os dados principais da apresentação.
        $name = $presentation->getPresentationName();
        $date = $presentation->getPresentationDate();
        $hour = $presentation->getPresentationHour();
        $local = $presentation->getLocalOfPresentation();
        $musicGroups = $presentationInfo['groups'];
        $songGroups = $presentationInfo['songs'];

        // Salva apresentação e vínculos em transação.
        try {

            $stmt = $db->prepare("INSERT INTO presentations (presentation_name, presentation_date, presentation_hour, local_of_presentation) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $date, $hour, $local);

            $stmt->execute();

            $presentationId = $db->insert_id;

            $stmt->close();

            // Inserir grupos
            $stmtGroups = $db->prepare(
                "INSERT INTO presentations_groups (presentation_id, group_id) VALUES (?, ?)"
            );

            $stmtGroups->bind_param("ii", $presentationId, $groupId);

            foreach ($musicGroups as $group => $groupId) {

                $groupId = (int) $groupId;

                if (!$stmtGroups->execute()) {
                    throw new Exception("Erro ao vincular grupo.");
                }
            }

            $stmtGroups->close();

            // Inserir músicas.
            $stmtSongs = $db->prepare(
                "INSERT INTO presentations_songs (presentation_id, song_id) VALUES (?, ?)"
            );

            $stmtSongs->bind_param("ii", $presentationId, $songId);

            foreach ($songGroups as $song => $songId) {

                $songId = (int) $songId;

                if (!$stmtSongs->execute()) {
                    throw new Exception("Erro ao vincular música.");
                }
            }

            $stmtSongs->close();

            $db->commit();

            return true;
        } catch (\Exception $e) {
            $db->rollback();
            return false;
        }
    }

    /**
     * Atualiza uma apresentação e recria vínculos de grupos/músicas.
     */

    public function edit(array $presentationInfo): bool
    {
        $db = $this->conn;

        $db->begin_transaction();

        $presentation = Presentation::fromArray([
            'presentation_id' => $presentationInfo['id'] ?? 0,
            'presentation_name' => $presentationInfo['name'] ?? '',
            'presentation_date' => $presentationInfo['date'] ?? '',
            'presentation_hour' => $presentationInfo['hour'] ?? '',
            'local_of_presentation' => $presentationInfo['local'] ?? '',
        ]);

        // Normaliza os dados principais da apresentação.
        $presentationId = (int) ($presentation->getPresentationId() ?? 0);
        $name = $presentation->getPresentationName();
        $date = $presentation->getPresentationDate();
        $hour = $presentation->getPresentationHour();
        $local = $presentation->getLocalOfPresentation();
        $musicGroups = $presentationInfo['groups'];
        $songGroups = $presentationInfo['songs'];

        // Atualiza apresentação e vínculos em transação.
        try {

            $stmt = $db->prepare("UPDATE presentations SET presentation_name = ?, presentation_date = ?, presentation_hour = ?, local_of_presentation = ? WHERE presentation_id = ?");
            $stmt->bind_param("ssssi", $name, $date, $hour, $local, $presentationId);

            $stmt->execute();

            $stmt->close();

            // Limpar grupos e músicas
            $stmtDeleteGroups = $db->prepare("DELETE FROM presentations_groups WHERE presentation_id = ?");
            $stmtDeleteGroups->bind_param("i", $presentationId);
            $stmtDeleteGroups->execute();
            $stmtDeleteGroups->close();

            $stmtDeleteSongs = $db->prepare("DELETE FROM presentations_songs WHERE presentation_id = ?");
            $stmtDeleteSongs->bind_param("i", $presentationId);
            $stmtDeleteSongs->execute();
            $stmtDeleteSongs->close();

            // Editar grupos
            $stmtGroups = $db->prepare(
                "INSERT INTO presentations_groups (presentation_id, group_id) VALUES (?, ?)"
            );

            $stmtGroups->bind_param("ii", $presentationId, $groupId);

            foreach ($musicGroups as $group => $groupId) {

                $groupId = (int) $groupId;

                if (!$stmtGroups->execute()) {
                    throw new Exception("Erro ao vincular grupo.");
                }
            }

            $stmtGroups->close();

            // Inserir músicas.
            $stmtSongs = $db->prepare(
                "INSERT INTO presentations_songs (presentation_id, song_id) VALUES (?, ?)"
            );

            $stmtSongs->bind_param("ii", $presentationId, $songId);

            foreach ($songGroups as $song => $songId) {

                $songId = (int) $songId;

                if (!$stmtSongs->execute()) {
                    throw new Exception("Erro ao vincular música.");
                }
            }

            $stmtSongs->close();

            $db->commit();

            return true;
        } catch (\Exception $e) {
            $db->rollback();
            return false;
        }
    }

    /**
     * Remove uma apresentação e seus vínculos.
     */

    public function delete(int $presentationId): bool
    {
        $db = $this->conn;

        $db->begin_transaction();

        // Remove apresentação; vínculos são removidos por ON DELETE CASCADE.
        try {
            $stmtDeleteMainTable = $db->prepare("DELETE FROM presentations WHERE presentation_id = ?");
            $stmtDeleteMainTable->bind_param("i", $presentationId);
            $stmtDeleteMainTable->execute();
            $stmtDeleteMainTable->close();

            $db->commit();

            return true;
        } catch (\Exception $e) {
            $db->rollback();
            return false;
        }
    }

    /**
     * Remove automaticamente apresentações com data anterior ao dia atual.
     */

    public function automaticallyDelete(): void
    {
        $db = $this->conn;

        $today = (new DateTime())->format('Y-m-d');

        $sql = "DELETE FROM presentations WHERE presentation_date < '$today'";
        $stmt = $db->prepare($sql);

        $stmt->execute();

        $stmt->close();
    }

    /**
     * Lista apresentações em ordem cronológica.
     */

    public function getAll(array $filters = []): array
    {
        $db = $this->conn;

        $sql = "SELECT * FROM presentations ORDER BY presentation_date ASC, presentation_hour ASC";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $presentationsList = [];

        while ($res = $result->fetch_assoc()) {
            $presentationsList[] = $res;
        }

        $stmt->close();

        return $presentationsList;
    }

    /**
     * Lista os grupos vinculados a uma apresentação.
     */

    public function getPresentationGroups(int $presentationId): array
    {
        $db = $this->conn;

        $stmt = $db->prepare("SELECT pg.group_id, bg.group_name FROM presentations_groups AS pg 
        JOIN band_groups AS bg ON pg.group_id = bg.group_id
        WHERE pg.presentation_id = ?");
        $stmt->bind_param('i', $presentationId);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $groupsList = [];

        while ($res = $result->fetch_assoc()) {
            $groupsList[] = $res;
        }

        $stmt->close();

        return $groupsList;
    }

    /**
     * Lista as músicas vinculadas a uma apresentação.
     */

    public function getPresentationSongs(int $presentationId): array
    {
        $db = $this->conn;

        $stmt = $db->prepare("SELECT ps.song_id, ms.music_name FROM presentations_songs AS ps 
        JOIN musical_scores AS ms ON ps.song_id = ms.music_id
        WHERE ps.presentation_id = ?");
        $stmt->bind_param('i', $presentationId);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $songsList = [];

        while ($res = $result->fetch_assoc()) {
            $songsList[] = $res;
        }

        $stmt->close();

        return $songsList;
    }
}
