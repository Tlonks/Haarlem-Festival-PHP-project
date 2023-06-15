<?php
require_once __DIR__ . "/../controllers/TimeTableController.php";
require_once __DIR__ . '/../services/timeTableService.php';


class HistoryTimeTableController
{

    public function index()
    {
        try {
            $timeTableService = new TimeTableService;

            //When a error message is send to the session it will displayed using the popUpMessage
            if (isset($_SESSION['showPopUpMessage'])) {
                $popUp = $_SESSION['showPopUpMessage'];
            }

            //get every date on which an historic event is happening
            $historicEventsDates = $timeTableService->getDateOfAllHistoricEvents();

            //check if the session is set if not set it to the first date of the event
            if (!isset($_SESSION["TimeTableDate"])) {
                $_SESSION["TimeTableDate"] = $historicEventsDates[0]->date;
            }

            //this will display every single event orderd by date
            $historicEventsByDate = $timeTableService->getAllHistoricEventsByDate($_SESSION["TimeTableDate"]);


            //when a new date is selected. The session will be set to the new date and the events will be displayed
            if (isset($_POST["btnTimeTableDate"])) {
                $_SESSION["TimeTableDate"] = htmlspecialchars($_POST["btnTimeTableDate"]);
                $historicEventsByDate = $timeTableService->getAllHistoricEventsByDate($_SESSION["TimeTableDate"]);
            }




            //When the button is clicked, The timetablecontroller and the selected event will be added to the shoppingcart as shoppingcartitem
            try {
                if (isset($_POST["btnAddTicket"])) {
                    $timeTableController = new TimeTableController();
                    $timeTableController->addToShoppingCart();
                    $_SESSION['showPopUpMessage'] = "Event added to shopping cart";
                    header("Location: /HistoryTimeTable");
                }
            } catch (Exception $ex) {
                $_SESSION['showPopUpMessage'] = $ex->getMessage();
                header("Location: /HistoryTimeTable");
            }


            require __DIR__ . '/../views/history/historytimetable.php';

        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }

    

}