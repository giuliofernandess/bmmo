<?php

class Presentation
{
    private ?int $presentationId = null;
    private string $presentationName = '';
    private string $presentationDate = '';
    private string $presentationHour = '';
    private string $localOfPresentation = '';

    public static function fromArray(array $data): self
    {
        $entity = new self();
        $entity->setPresentationId(isset($data['presentation_id']) ? (int) $data['presentation_id'] : null);
        $entity->setPresentationName((string) ($data['presentation_name'] ?? ''));
        $entity->setPresentationDate((string) ($data['presentation_date'] ?? ''));
        $entity->setPresentationHour((string) ($data['presentation_hour'] ?? ''));
        $entity->setLocalOfPresentation((string) ($data['local_of_presentation'] ?? ''));

        return $entity;
    }

    public function toArray(): array
    {
        return [
            'presentation_id' => $this->presentationId,
            'presentation_name' => $this->presentationName,
            'presentation_date' => $this->presentationDate,
            'presentation_hour' => $this->presentationHour,
            'local_of_presentation' => $this->localOfPresentation,
        ];
    }

    public function getPresentationId(): ?int { return $this->presentationId; }
    public function setPresentationId(?int $presentationId): void { $this->presentationId = $presentationId; }
    public function getPresentationName(): string { return $this->presentationName; }
    public function setPresentationName(string $presentationName): void { $this->presentationName = trim($presentationName); }
    public function getPresentationDate(): string { return $this->presentationDate; }
    public function setPresentationDate(string $presentationDate): void { $this->presentationDate = trim($presentationDate); }
    public function getPresentationHour(): string { return $this->presentationHour; }
    public function setPresentationHour(string $presentationHour): void { $this->presentationHour = trim($presentationHour); }
    public function getLocalOfPresentation(): string { return $this->localOfPresentation; }
    public function setLocalOfPresentation(string $localOfPresentation): void { $this->localOfPresentation = trim($localOfPresentation); }
}
