<?php
include_once __DIR__ . '/../repositories/historyRepository.php';

class HistoryService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new HistoryRepository();
    }

    public function getAllContentOfSights(){
        return $this->repo->getAllContentOfSights();
    }

    public function getMoreInformationOfSight($sightTitle){
        return $this->repo->getMoreInformationOfSight($sightTitle);
    }

    public function getAllSights()
    {
        return $this->repo->getAllContentOfSights();
    }

    public function addSight(ContentCards $sight)
    {
        $this->repo->addSight($sight);
    }

    public function getSightById(mixed $id)
    {
        return $this->repo->getSightById($id);
    }

    public function deleteSight(mixed $id)
    {
        $this->repo->deleteSight($id);
    }

    public function updateSight(ContentCards $sight)
    {
        $this->repo->updateSight($sight);
    }
}