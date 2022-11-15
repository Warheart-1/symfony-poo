<?php 

    namespace App\Entity;

    class Article
    {
        private int $id;
        private string $title;
        private ?string $content;
        private string $author;
        //private DateTime $createdAt;
        //private DateTime $updatedAt;

        public function getID(): int
        {
            return $this->id;
        }

        public function getTitle(): string
        {
            return $this->title;
        }


        public function setTitle(string $title): void
        {
            !empty($title)?$this->title = $title : trigger_error("Le titre ne peut pas être vide", E_USER_ERROR);
        }

        public function getContent(): ?string
        {
            return $this->content;
        }

        public function setContent(?string $content): void
        {
            $this->content = $content;
        }

        public function getAuthor(): string
        {
            return $this->author;
        }

        public function setAuthor(string $author): void
        {
            !empty($author)?$this->author = $author : trigger_error("L'auteur ne peut pas être vide", E_USER_ERROR);
        }
    }