<?php
require_once __DIR__ . "/../services/mainPageService.php";
require_once __DIR__ . "/../controllers/TimeTableController.php";
require_once __DIR__ . "/../services/IntroInformationService.php";
require_once __DIR__ . '/../services/timeTableService.php';


class HomeController
{


    public function index()
    {
        try {
            $timeTableService = new TimeTableService();
            $mainPageService = new MainPageService();

            //get all the needed content from the database
            $contentEvents = $mainPageService->getAllContentCards('Home');
            $footerContentCards = $mainPageService->getAllContentCards('MainPage');


            $startingLocations = $mainPageService->getAllStartingLocations();

            //When the user clicks on the add to cart button a pop up message will appear
            if (isset($_SESSION['showPopUpMessage'])) {
                $popUp = $_SESSION['showPopUpMessage'];
            }

            $this->setNewHeader();

            //displays every single date from a event
            $allHistoricEventDates = $timeTableService->getDateOfAllHistoricEvents();
            $allDanceAndJazzEventDates = $timeTableService->getDateOfAllDanceAndJazzEvents();

            $historicEventsByDate = $this->getAllHistoricEventsByDate($allHistoricEventDates, $timeTableService);

            //check if the session is set if not set it to the first date of the event
            if (!isset($_SESSION["TimeTableDateDanceJazz"])) {
                $_SESSION["TimeTableDateDanceJazz"] = $allDanceAndJazzEventDates[0]->date;
            }

            $danceEventsByDate = $timeTableService->getAllDanceEventsByDate($_SESSION["TimeTableDateDanceJazz"]);
            $jazzEventsByDate = $timeTableService->getAllJazzEventsByDate($_SESSION["TimeTableDateDanceJazz"]);


            //if the user clicks on a date the session will be set to that date and the events will be displayed
            if (isset($_POST["btnTimeTableDate"])) {
                $_SESSION["TimeTableDate"] = htmlspecialchars($_POST["btnTimeTableDate"]);
                $historicEventsByDate = $timeTableService->getAllHistoricEventsByDate($_SESSION["TimeTableDate"]);
            } else if (isset($_POST["btnTimeTableDateDanceJazz"])) {
                $_SESSION["TimeTableDateDanceJazz"] = htmlspecialchars($_POST["btnTimeTableDateDanceJazz"]);
                $danceEventsByDate = $timeTableService->getAllDanceEventsByDate($_SESSION["TimeTableDateDanceJazz"]);
                $jazzEventsByDate = $timeTableService->getAllJazzEventsByDate($_SESSION["TimeTableDateDanceJazz"]);
            }

            $this->addTicketToCart();


            $pageService = new IntroInformationService();
            $homePage = $pageService->getPageById(6);

            require __DIR__ . '/../views/home/index.php';
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }

    private function setNewHeader()
    {
        //The location of that item is saved in the database so when the user clicks on the button he will be redirected to the correct page
        if (isset($_POST["sightInformationBtn"])) {
            $url = htmlspecialchars($_POST["sightInformationBtn"]);
            header("Location: /$url");
        }
    }

    private function getAllHistoricEventsByDate($allHistoricEventDates, $timeTableService)
    {
        //check if the session is set if not set it to the first date of the event
        if (!isset($_SESSION["TimeTableDate"])) {
            $_SESSION["TimeTableDate"] = $allHistoricEventDates[0]->date;
        }

        //this will display every single event orderd by date
        return $timeTableService->getAllHistoricEventsByDate($_SESSION["TimeTableDate"]);

    }


    private function addTicketToCart()
    {
        try {
            if (isset($_POST["btnAddTicket"])) {
                $timeTableController = new TimeTableController();
                $timeTableController->addToShoppingCart();
                $_SESSION['showPopUpMessage'] = "Event added to shopping cart";
                header("Location: /");
            }
        } catch (Exception $ex) {
            $_SESSION['showPopUpMessage'] = $ex->getMessage();
            header("Location: /");
        }
    }

}