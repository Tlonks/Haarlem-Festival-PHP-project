<?php
//https://stackoverflow.com/questions/32444572/why-include-dir-in-the-require-once
require_once __DIR__ ."/../services/HistoryService.php";
require_once __DIR__ . "/../services/IntroInformationService.php";

class MainHistoryController
{

    public function index()
    {
        //get all the content where the page is history
        $repository = new HistoryService();
        $contentSights = $repository->getAllContentOfSights();
        
        //when the button for the sightinformation is clicked.
        //Place the title of that sightinformation into a session, so that it can be used in the historyInformationController
        if (isset($_POST["sightInformationBtn"])) {
            $_SESSION['sightInformation'] = htmlspecialchars($_POST["sightInformationBtn"]);
            header("Location: /historyInformation");
        }

        $pageService = new IntroInformationService();
        $historyPage = $pageService->getPageById(2);

        require __DIR__ . '/../views/History/MainHistory.php';
    }
}