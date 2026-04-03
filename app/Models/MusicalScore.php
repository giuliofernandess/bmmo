<?php

class MusicalScore
{
    private ?int $musicId = null;
    private string $musicName = '';
    private string $musicGenre = '';
    private array $musicGroups = [];
    private array $instrumentsVoiceOff = [];
    private array $instruments = [];

    public static function fromArray(array $data): self
    {
        $entity = new self();
        $entity->setMusicId(isset($data['music_id']) ? (int) $data['music_id'] : null);
        $entity->setMusicName((string) ($data['music_name'] ?? ''));
        $entity->setMusicGenre((string) ($data['music_genre'] ?? ''));
        $entity->setMusicGroups(is_array($data['music_groups'] ?? null) ? $data['music_groups'] : []);
        $entity->setInstrumentsVoiceOff(is_array($data['instruments_voice_off'] ?? null) ? $data['instruments_voice_off'] : []);
        $entity->setInstruments(is_array($data['instruments'] ?? null) ? $data['instruments'] : []);

        return $entity;
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

    public function getMusicGroups(): array
    {
        return $this->musicGroups;
    }

    public function setMusicGroups(array $musicGroups): void
    {
        $this->musicGroups = array_map('intval', $musicGroups);
    }

    public function getInstrumentsVoiceOff(): array
    {
        return $this->instrumentsVoiceOff;
    }

    public function setInstrumentsVoiceOff(array $instrumentsVoiceOff): void
    {
        $this->instrumentsVoiceOff = [];
        foreach ($instrumentsVoiceOff as $instrumentId => $file) {
            $this->instrumentsVoiceOff[(int) $instrumentId] = (string) $file;
        }
    }

    public function getInstruments(): array
    {
        return $this->instruments;
    }

    public function setInstruments(array $instruments): void
    {
        $this->instruments = [];
        foreach ($instruments as $instrumentId => $file) {
            $this->instruments[(int) $instrumentId] = (string) $file;
        }
    }
}
