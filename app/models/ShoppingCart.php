<?php
require_once __DIR__ . '/ShoppingCartItems.php';
class ShoppingCart{
    public int $id;
    public float $totalPrice;
    public float $addedVAT;
    public int $userId;


    // public int $cartId;
    // public int $eventId;
    // public string $quantityOrder;
    // public string $subTotal;
    // public string $name;
    // public string $category;
    // public string $date;
    // public float $price;
    // public int $quantity;

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    
    
}
    