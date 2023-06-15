<?php
require_once __DIR__ . '/orderItems.php';

class Orders extends OrderItems{
    public int $id;
    public float $totalPrice;
    public float $addedVAT;
    public int $userId;
    public $isPaid;

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}