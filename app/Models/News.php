<?php

class News
{
    private ?int $newsId = null;
    private string $newsTitle = '';
    private string $newsSubtitle = '';
    private string $newsImage = '';
    private string $newsDescription = '';
    private string $publicationDate = '';
    private string $publicationHour = '';

    public static function fromArray(array $data): self
    {
        $entity = new self();
        $entity->setNewsId(isset($data['news_id']) ? (int) $data['news_id'] : null);
        $entity->setNewsTitle((string) ($data['news_title'] ?? ''));
        $entity->setNewsSubtitle((string) ($data['news_subtitle'] ?? ''));
        $entity->setNewsImage((string) ($data['news_image'] ?? ''));
        $entity->setNewsDescription((string) ($data['news_description'] ?? ''));
        $entity->setPublicationDate((string) ($data['publication_date'] ?? ''));
        $entity->setPublicationHour((string) ($data['publication_hour'] ?? ''));

        return $entity;
    }

    public function toArray(): array
    {
        return [
            'news_id' => $this->newsId,
            'news_title' => $this->newsTitle,
            'news_subtitle' => $this->newsSubtitle,
            'news_image' => $this->newsImage,
            'news_description' => $this->newsDescription,
            'publication_date' => $this->publicationDate,
            'publication_hour' => $this->publicationHour,
        ];
    }

    public function getNewsId(): ?int { return $this->newsId; }
    public function setNewsId(?int $newsId): void { $this->newsId = $newsId; }
    public function getNewsTitle(): string { return $this->newsTitle; }
    public function setNewsTitle(string $newsTitle): void { $this->newsTitle = trim($newsTitle); }
    public function getNewsSubtitle(): string { return $this->newsSubtitle; }
    public function setNewsSubtitle(string $newsSubtitle): void { $this->newsSubtitle = trim($newsSubtitle); }
    public function getNewsImage(): string { return $this->newsImage; }
    public function setNewsImage(string $newsImage): void { $this->newsImage = trim($newsImage); }
    public function getNewsDescription(): string { return $this->newsDescription; }
    public function setNewsDescription(string $newsDescription): void { $this->newsDescription = trim($newsDescription); }
    public function getPublicationDate(): string { return $this->publicationDate; }
    public function setPublicationDate(string $publicationDate): void { $this->publicationDate = trim($publicationDate); }
    public function getPublicationHour(): string { return $this->publicationHour; }
    public function setPublicationHour(string $publicationHour): void { $this->publicationHour = trim($publicationHour); }
}
