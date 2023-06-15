<?php
require_once __DIR__ . "/../repositories/ArtistDetailRepository.php";

class ArtistDetailService
{

    private $artistDetailRepository;

    public function __construct()
    {
        $this->artistDetailRepository = new ArtistDetailRepository();
    }

    public function generateArtistDetailHtml($name)
    {
        $artist = $this->artistDetailRepository->getArtistDetail($name);
        if (!$artist) {
            return '';
        }
        return $artist;
    }

    public function generateArtistDetailTable($name)
    {

        $jazzEventSercice = new JazzEventService();
        return $jazzEventSercice->getAllEventsByArtist($name);

    }

    public function generateArtistDetailTableDance($name)
    {

        $danceService = new DanceEventService();
        return $danceService->getAllEventsByArtist($name);

    }

    public function generateDanceArtistDetailHtml($name)
    {
        $artist = $this->artistDetailRepository->getDanceArtistDetail($name);
        if (!$artist) {
            return '';
        }
        return $artist;
    }
}

?>