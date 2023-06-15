<?php
require_once __DIR__ . "/../models/event.php";

class JazzEvent extends event
{
    public int $infoId;
    public string $location;
    public string $hall;
    public int $artistId;

    public int $id;
    public string $artist;

    public string $picture;

    public string $endTime;

    public int $eventId;

}



?>