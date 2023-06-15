<?php
require_once __DIR__ . '/contentCards.php';
class YummyContentCards extends ContentCards {

    public int $id;
    public float $stars;
    public float $price;
    public string $duration;
    public string $typeOfFood;
    public string $location;
    public string $contentCardId;
}