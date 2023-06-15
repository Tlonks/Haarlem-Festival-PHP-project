<?php

class danceArtistsDetailPage
{

    public int $id;
    public string $name;
    public string $firstImage;
    public string $secondImage;
    public string $bodyText;

    //setters
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setFirstImage(string $firstImage): self
    {
        $this->firstImage = $firstImage;
        return $this;
    }

    public function setSecondImage(string $secondImage): self
    {
        $this->secondImage = $secondImage;
        return $this;
    }

    public function setBodyText(string $bodyText): self
    {
        $this->bodyText = $bodyText;
        return $this;
    }

    //getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFirstImage(): string
    {
        return $this->firstImage;
    }

    public function getSecondImage(): string
    {
        return $this->secondImage;
    }

    public function getBodyText(): string
    {
        return $this->bodyText;
    }
}