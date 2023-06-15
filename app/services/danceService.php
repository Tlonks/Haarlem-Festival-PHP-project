<?php
include_once __DIR__ . '/../repositories/dancePageRepository.php';
class DanceEventService
{
    private $danceEventRepository;

    public function __construct()
    {
        $this->danceEventRepository = new dancePageRepository();
    }

    public function getEventbyDate($date, $name)
    {
        return $this->danceEventRepository->getEventbyDate($date, $name);
    }

    public function getAllEventsByArtist($artist)
    {
        return $this->danceEventRepository->getEventbyArtist($artist);

    }



}