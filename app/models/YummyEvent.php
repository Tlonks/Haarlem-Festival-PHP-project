<?php
require_once __DIR__ . "/event.php";

class YummyEvent extends event
{
    public int $id;
    public int $duration;
    public float $reservationPrice;
    public string $restaurant;
    public int $eventId;
}