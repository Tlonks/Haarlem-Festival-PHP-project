<?php
require_once __DIR__ . '/event.php';
class OrderItems extends event{
    public int $id;
    public int $orderId;
    public string $cartId;
    public int $eventId;
    public string $quantityOrder;
    public string $subTotal;
    public int $typeOfTicket;
    
}