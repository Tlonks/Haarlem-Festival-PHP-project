<?php
include_once __DIR__ . '/../repositories/mainPageRepository.php';

class MainPageService
{
    private $mainPageRepository;

    public function __construct()
    {
        $this->mainPageRepository = new MainPageRepository();
    }

    public function getAllContentCards($page)
    {
        return $this->mainPageRepository->getAllContentCards($page);
    }

    public function getAllStartingLocations()
    {
        return $this->mainPageRepository->getAllStartingLocations();
    }  
}