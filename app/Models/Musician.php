<?php

class Musician
{
    private ?int $musicianId = null;
    private string $musicianName = '';
    private string $musicianLogin = '';
    private string $dateOfBirth = '';
    private int $instrument = 0;
    private int $bandGroup = 0;
    private ?string $musicianContact = null;
    private ?string $responsibleName = null;
    private ?string $responsibleContact = null;
    private string $neighborhood = '';
    private ?string $institution = null;
    private string $password = '';
    private ?string $profileImage = null;

    public static function fromArray(array $data): self
    {
        $entity = new self();
        $entity->setMusicianId(isset($data['musician_id']) ? (int) $data['musician_id'] : null);
        $entity->setMusicianName((string) ($data['musician_name'] ?? ''));
        $entity->setMusicianLogin((string) ($data['musician_login'] ?? ''));
        $entity->setDateOfBirth((string) ($data['date_of_birth'] ?? ''));
        $entity->setInstrument(isset($data['instrument']) ? (int) $data['instrument'] : 0);
        $entity->setBandGroup(isset($data['band_group']) ? (int) $data['band_group'] : 0);
        $entity->setMusicianContact(isset($data['musician_contact']) ? (string) $data['musician_contact'] : null);
        $entity->setResponsibleName(isset($data['responsible_name']) ? (string) $data['responsible_name'] : null);
        $entity->setResponsibleContact(isset($data['responsible_contact']) ? (string) $data['responsible_contact'] : null);
        $entity->setNeighborhood((string) ($data['neighborhood'] ?? ''));
        $entity->setInstitution(isset($data['institution']) ? (string) $data['institution'] : null);
        $entity->setPassword((string) ($data['password'] ?? ''));
        $entity->setProfileImage(isset($data['profile_image']) ? (string) $data['profile_image'] : null);

        return $entity;
    }

    public function getMusicianId(): ?int { return $this->musicianId; }
    public function setMusicianId(?int $musicianId): void { $this->musicianId = $musicianId; }
    public function getMusicianName(): string { return $this->musicianName; }
    public function setMusicianName(string $musicianName): void { $this->musicianName = trim($musicianName); }
    public function getMusicianLogin(): string { return $this->musicianLogin; }
    public function setMusicianLogin(string $musicianLogin): void { $this->musicianLogin = trim($musicianLogin); }
    public function getDateOfBirth(): string { return $this->dateOfBirth; }
    public function setDateOfBirth(string $dateOfBirth): void { $this->dateOfBirth = trim($dateOfBirth); }
    public function getInstrument(): int { return $this->instrument; }
    public function setInstrument(int $instrument): void { $this->instrument = $instrument; }
    public function getBandGroup(): int { return $this->bandGroup; }
    public function setBandGroup(int $bandGroup): void { $this->bandGroup = $bandGroup; }
    public function getMusicianContact(): ?string { return $this->musicianContact; }
    public function setMusicianContact(?string $musicianContact): void { $this->musicianContact = $musicianContact !== null ? trim($musicianContact) : null; }
    public function getResponsibleName(): ?string { return $this->responsibleName; }
    public function setResponsibleName(?string $responsibleName): void { $this->responsibleName = $responsibleName !== null ? trim($responsibleName) : null; }
    public function getResponsibleContact(): ?string { return $this->responsibleContact; }
    public function setResponsibleContact(?string $responsibleContact): void { $this->responsibleContact = $responsibleContact !== null ? trim($responsibleContact) : null; }
    public function getNeighborhood(): string { return $this->neighborhood; }
    public function setNeighborhood(string $neighborhood): void { $this->neighborhood = trim($neighborhood); }
    public function getInstitution(): ?string { return $this->institution; }
    public function setInstitution(?string $institution): void { $this->institution = $institution !== null ? trim($institution) : null; }
    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function getProfileImage(): ?string { return $this->profileImage; }
    public function setProfileImage(?string $profileImage): void { $this->profileImage = $profileImage !== null ? trim($profileImage) : null; }
}
