<?php
require_once __DIR__ . "/event.php";

class HistoryEvent extends event{
    public int $infoId;
    public string $location;
    public string $guide;
    public string $language;
    public float $familyPrice;
}