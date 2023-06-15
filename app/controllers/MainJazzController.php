<?php
require_once __DIR__ . "/../services/JazzEventService.php";
require_once __DIR__ . "/../controllers/TimeTableController.php";
require_once __DIR__ . "/../services/ShoppingCartService.php";
require_once __DIR__ . "/../services/IntroInformationService.php";
require_once __DIR__ . '/../services/timeTableService.php';


class MainJazzController
{
    public function index()
    {
        $timeTableService = new TimeTableService();
        $shoppingCartService = new ShoppingCartService();
        $eventService = new jazzEventService();
        if (isset($_SESSION['showPopUpMessage'])) {
            $popUp = $_SESSION['showPopUpMessage'];
        }

        try {
            //determine which button is pressed and add the event to the cart
            if (isset($_POST['jazzDayPass'])) {
                //the daypassdance haarlem is the value to get the correct event
                //second value is for the corresponding day
                //third value is for the kind of ticket  
                //since it unknown what type of ticket it will be, the type of ticket is determined in the addEventToCart function
                $this->addEventToCart('Daypass Jazz Haarlem','Day',  $eventService, $timeTableService, $shoppingCartService);
            }
            else if (isset($_POST['jazzWeekendPass'])) {
                $this->addEventToCart('Weekendpass Jazz Haarlem','Weekend',  $eventService, $timeTableService, $shoppingCartService);
            }
        } catch (Exception $ex) {
            $_SESSION['showPopUpMessage'] = $ex->getMessage();
            header("Location: /MainJazz");
        }

        $pageService = new IntroInformationService();
        $jazzPage = $pageService->getPageById(5);

        require __DIR__ . '/../views/jazz/mainJazz.php';
    }

    public function addEventToCart($typeOfPass, $kindOfTicket, $eventService, $timeTableService, $shoppingCartService)
    {
        //check if the user is logged in
        if (!($this->checkForUser())) {
            throw new Exception("Please, Log in to buy tickets");
        }
        
        //get the selected day from the form
        $day = htmlspecialchars($_POST[$kindOfTicket]);

        $event = $eventService->getEventbyDate($day, $typeOfPass);

        //The tickettype is needed so the correct amount of people can be added to the cart
        $typeOfTicket = $timeTableService->getTypeOfTicketByType($kindOfTicket);

        $cartId = $_SESSION["user"]["cartId"];

        $this->addPassToCart($shoppingCartService, $cartId, $event[0]['eventId'], $typeOfTicket, $event[0]['price']);
        $_SESSION['showPopUpMessage'] = "Pass added to shopping cart";
        header("Location: /MainJazz");
    }

    public function checkForUser()
    {
        if (isset($_SESSION["user"])) {
            return true;
        }
        return false;
    }



    public function detailJonnaFraser()
    {
        require __DIR__ . '/../views/jazz/detailPages/detailJonnaFraser.php';
    }

    public function detailTheNordanians()
    {
        require __DIR__ . '/../views/jazz/detailPages/detailTheNordanians.php';
    }

    public function detailGeneralArtist()
    {
        require __DIR__ . '/../views/jazz/detailPages/detailGeneralArtist.php';
    }

    public function JazzTimeTable()
    {
        $timeTableService = new TimeTableService();

        //When a error message is send to the session it will displayed using the popUpMessage
        if (isset($_SESSION['showPopUpMessage'])) {
            $popUp = $_SESSION['showPopUpMessage'];
        }

        //get every date on which an jazz event is happening
        $dateOfAllEvents = $timeTableService->getDateOfAllJazzEvents();

        //check if the session is set if not set it to the first date of the event
        if (!isset($_SESSION["TimeTableDateJazz"])) {
            $_SESSION["TimeTableDateJazz"] = $dateOfAllEvents[0]->date;
        }

        //this will display every single event orderd by date
        $allEventsOfJazzByDate = $timeTableService->getAllJazzEventsByDate($_SESSION["TimeTableDateJazz"]);

        //when a new date is selected. The session will be set to the new date and the events will be displayed
        if (isset($_POST["btnTimeTableDate"])) {
            $_SESSION["TimeTableDateJazz"] = htmlspecialchars($_POST["btnTimeTableDate"]);
            $allEventsOfJazzByDate = $timeTableService->getAllJazzEventsByDate($_SESSION["TimeTableDateJazz"]);
        }

        try {
            if (isset($_POST["btnAddTicket"])) {
                $timeTableController = new TimeTableController();
                $timeTableController->addToShoppingCart();
                $_SESSION['showPopUpMessage'] = "Event added to shopping cart";
                header("Location: /mainJazz/jazzTimeTable");
            }
        } catch (Exception $ex) {
            $_SESSION['showPopUpMessage'] = $ex->getMessage();
            header("Location: /mainJazz/jazzTimeTable");
        }

        require __DIR__ . '/../views/jazz/jazzTimeTable.php';
    }

    public function addPassToCart($shoppingCartService, $cartId, $eventId, $typeOfTicket, $price)
    {
        $shoppingCartItem = $shoppingCartService->checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket);

        if (COUNT($shoppingCartItem) == 0) {
            $shoppingCartService->addItemToShoppingCart($cartId, $eventId, $typeOfTicket['amount'], $price, $typeOfTicket['id']);
        } else {
            $shoppingCartService->updateShoppingCartItemById($shoppingCartItem[0]->id, $typeOfTicket['amount'], $price);
        }
    }
    public function __call($method, $args)
    {
        // Check if the requested method does not exist
        if (!method_exists($this, $method)) {
            // If so, redirect to the detailGeneralArtists() method
            $this->detailGeneralArtist();
        }
    }


}