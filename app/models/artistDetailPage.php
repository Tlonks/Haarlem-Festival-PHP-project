<?php

class artistsDetailPage
{

    public int $id;
    public string $title;
    public string $headText;
    public string $firstImage;
    public string $secondImage;
    public string $thirdImage;

    //setters
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setHeadText(string $headText): self
    {
        $this->headText = $headText;
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


    public function setThirdImage(string $thirdImage): self
    {
        $this->thirdImage = $thirdImage;
        return $this;
    }

    //getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getHeadText(): string
    {
        return $this->headText;
    }

    public function getFirstImage(): string
    {
        return $this->firstImage;
    }

    public function getSecondImage(): string
    {
        return $this->secondImage;
    }

    public function getThirdImage(): string
    {
        return $this->thirdImage;
    }


}