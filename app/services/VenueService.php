<?php
include_once __DIR__ . '/../repositories/VenueRepository.php';
class VenueService
{
    private VenueRepository $venueRepository;

    public function __construct()
    {
        $this->venueRepository = new VenueRepository();
    }

    public function getAllVenueEvents()
    {
        return $this->venueRepository->getAllVenueEvents();
    }

    public function addVenue(Venue $venue)
    {
        $this->venueRepository->addVenue($venue);
    }

    public function deleteVenue(mixed $param)
    {
        $this->venueRepository->deleteVenue($param);
    }

    public function updateVenue(Venue $venue)
    {
        $this->venueRepository->updateVenue($venue);
    }

    public function getVenueById(mixed $id)
    {
        return $this->venueRepository->getVenueById($id);
    }
}