<?php

require_once BASE_PATH . 'app/Models/EntityInterface.php';
require_once BASE_PATH . 'app/Models/BandGroup.php';
require_once BASE_PATH . 'app/Models/MusicalScore.php';
require_once BASE_PATH . 'app/Models/Presentation.php';

class PresentationsDAO implements EntityInterface
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function create(object $entity): mixed
    {
        $db = $this->conn;

        $db->begin_transaction();

        if (!$entity instanceof Presentation) {
            return false;
        }

        $name = $entity->getPresentationName();
        $date = $entity->getPresentationDate();
        $hour = $entity->getPresentationHour();
        $local = $entity->getLocalOfPresentation();
        $musicGroups = $entity->getGroups();
        $songGroups = $entity->getSongs();

        try {

            $stmt = $db->prepare("INSERT INTO presentations (presentation_name, presentation_date, presentation_hour, local_of_presentation) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $date, $hour, $local);

            $stmt->execute();

            $presentationId = $db->insert_id;

            $stmt->close();

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

    public function edit(object $entity): bool
    {
        $db = $this->conn;

        $db->begin_transaction();

        if (!$entity instanceof Presentation) {
            return false;
        }

        $presentationId = (int) ($entity->getPresentationId() ?? 0);
        $name = $entity->getPresentationName();
        $date = $entity->getPresentationDate();
        $hour = $entity->getPresentationHour();
        $local = $entity->getLocalOfPresentation();
        $musicGroups = $entity->getGroups();
        $songGroups = $entity->getSongs();

        try {

            $stmt = $db->prepare("UPDATE presentations SET presentation_name = ?, presentation_date = ?, presentation_hour = ?, local_of_presentation = ? WHERE presentation_id = ?");
            $stmt->bind_param("ssssi", $name, $date, $hour, $local, $presentationId);

            $stmt->execute();

            $stmt->close();

            $stmtDeleteGroups = $db->prepare("DELETE FROM presentations_groups WHERE presentation_id = ?");
            $stmtDeleteGroups->bind_param("i", $presentationId);
            $stmtDeleteGroups->execute();
            $stmtDeleteGroups->close();

            $stmtDeleteSongs = $db->prepare("DELETE FROM presentations_songs WHERE presentation_id = ?");
            $stmtDeleteSongs->bind_param("i", $presentationId);
            $stmtDeleteSongs->execute();
            $stmtDeleteSongs->close();

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

    public function delete(int $presentationId): bool
    {
        $db = $this->conn;

        $db->begin_transaction();

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

    public function automaticallyDelete(): void
    {
        $db = $this->conn;

        $today = (new DateTime())->format('Y-m-d');

        $sql = "DELETE FROM presentations WHERE presentation_date < '$today'";
        $stmt = $db->prepare($sql);

        $stmt->execute();

        $stmt->close();
    }

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

        while ($row = $result->fetch_assoc()) {
            $presentationsList[] = Presentation::fromArray($row);
        }

        $stmt->close();

        return $presentationsList;
    }

    public function getById(int $musicId): ?MusicalScore
    {
        $db = $this->conn;

        $sql = "SELECT * FROM presentations WHERE presentation_id = ?";
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

        while ($row = $result->fetch_assoc()) {
            $groupsList[] = BandGroup::fromArray($row);
        }

        $stmt->close();

        return $groupsList;
    }

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

        while ($row = $result->fetch_assoc()) {
            $songsList[] = MusicalScore::fromArray([
                'music_id' => $row['song_id'] ?? null,
                'music_name' => $row['music_name'] ?? '',
            ]);
        }

        $stmt->close();

        return $songsList;
    }
}
