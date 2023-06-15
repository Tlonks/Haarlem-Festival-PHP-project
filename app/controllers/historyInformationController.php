<?php
require_once __DIR__ . "/../services/HistoryService.php";
class HistoryInformationController
{

    public function index()
    {
        try {
            $historyService = new HistoryService;
            $informationSight = $historyService->getMoreInformationOfSight($_SESSION['sightInformation']);
            require __DIR__ . '/../views/history/historyinformation.php';
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }
}