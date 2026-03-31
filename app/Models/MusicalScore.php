<?php

class MusicalScore
{
    private ?int $musicId = null;
    private string $musicName = '';
    private string $musicGenre = '';

    public static function fromArray(array $data): self
    {
        $entity = new self();
        $entity->setMusicId(isset($data['music_id']) ? (int) $data['music_id'] : null);
        $entity->setMusicName((string) ($data['music_name'] ?? ''));
        $entity->setMusicGenre((string) ($data['music_genre'] ?? ''));

        return $entity;
    }

    public function toArray(): array
    {
        return [
            'music_id' => $this->musicId,
            'music_name' => $this->musicName,
            'music_genre' => $this->musicGenre,
        ];
    }

    public function getMusicId(): ?int
    {
        return $this->musicId;
    }

    public function setMusicId(?int $musicId): void
    {
        $this->musicId = $musicId;
    }

    public function getMusicName(): string
    {
        return $this->musicName;
    }

    public function setMusicName(string $musicName): void
    {
        $this->musicName = trim($musicName);
    }

    public function getMusicGenre(): string
    {
        return $this->musicGenre;
    }

    public function setMusicGenre(string $musicGenre): void
    {
        $this->musicGenre = trim($musicGenre);
    }
}
