<?php
require_once __DIR__ . '/event.php';
class ShoppingCartItems extends event{
    public int $id;
    public int $cartId;
    public int $eventId;
    public string $quantityOrder;
    public string $subTotal;
    public int $typeOfTicket;
}
