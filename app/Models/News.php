<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class News
{
    private ?int $id = null;
    private string $title;
    private string $subtitle;
    private string $description;
    private ?string $image;
    private string $date;
    private string $hour;

    public function __construct()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $this->date = date('Y-m-d');
        $this->hour = date('H:i:s');
    }

    public function hydrate(array $data): void
    {
        $this->id = $data['news_id'] ?? null;
        $this->title = $data['news_title'];
        $this->subtitle = $data['news_subtitle'];
        $this->description = $data['news_description'];
        $this->image = $data['news_image'];
        $this->date = $data['publication_date'];
        $this->hour = $data['publication_hour'];
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getSubtitle() { return $this->subtitle; }
    public function getDescription() { return $this->description; }
    public function getImage() { return $this->image; }
    public function getDate() { return $this->date; }

    // Setters
    public function setTitle($v) { $this->title = trim($v); }
    public function setSubtitle($v) { $this->subtitle = trim($v); }
    public function setDescription($v) { $this->description = trim($v); }
    public function setImage($v) { $this->image = $v; }
}
