<?php

class BandGroup
{
    private ?int $groupId = null;
    private string $groupName = '';

    public static function fromArray(array $data): self
    {
        $entity = new self();
        $entity->setGroupId(isset($data['group_id']) ? (int) $data['group_id'] : null);
        $entity->setGroupName((string) ($data['group_name'] ?? ''));

        return $entity;
    }

    public function toArray(): array
    {
        return [
            'group_id' => $this->groupId,
            'group_name' => $this->groupName,
        ];
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(?int $groupId): void
    {
        $this->groupId = $groupId;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): void
    {
        $this->groupName = trim($groupName);
    }
}
