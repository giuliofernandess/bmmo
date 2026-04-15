<?php

class Instrument
{
    private ?int $instrumentId = null;
    private string $instrumentName = '';

    public static function fromArray(array $data): self
    {
        $entity = new self();
        $entity->setInstrumentId(isset($data['instrument_id']) ? (int) $data['instrument_id'] : null);
        $entity->setInstrumentName((string) ($data['instrument_name'] ?? ''));

        return $entity;
    }

    public function getInstrumentId(): ?int
    {
        return $this->instrumentId;
    }

    public function setInstrumentId(?int $instrumentId): void
    {
        $this->instrumentId = $instrumentId;
    }

    public function getInstrumentName(): string
    {
        return $this->instrumentName;
    }

    public function setInstrumentName(string $instrumentName): void
    {
        $this->instrumentName = trim($instrumentName);
    }
}
