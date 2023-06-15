<?php
include_once __DIR__ . '/../repositories/jazzRepository.php';
class jazzEventService
{
    private $jazzEventRepository;

    public function __construct()
    {
        $this->jazzEventRepository = new JazzRepository();
    }

    public function getAllEventsByArtist($artist)
    {
        return $this->jazzEventRepository->getAllEventsByArtist($artist);

    }

    public function getAllJazzEventsByDate($date)
    {
        $formatted_date = date('Y-m-d', strtotime($date));

        return $this->jazzEventRepository->getAllJazzEventsByDate($formatted_date);
    }

    public function getEventbyDate($date, $name){
        return $this->jazzEventRepository->getEventbyDate($date, $name);
    }

 

}