<?php
require_once __DIR__ . "/../services/ArtistService.php";
require_once __DIR__ . "/../repositories/dancePageRepository.php";
require_once __DIR__ . "/../services/danceService.php";
require_once __DIR__ . "/../controllers/TimeTableController.php";
require_once __DIR__ . "/../services/ShoppingCartService.php";
require_once __DIR__ . "/../services/IntroInformationService.php";
require_once __DIR__ . '/../services/timeTableService.php';

class MainDanceController
{
    public $artistService;

    public function index()
    {
        $timeTableService = new TimeTableService();
        $this->artistService = new ArtistService();
        $repository = new dancePageRepository();

        $shoppingCartService = new ShoppingCartService();
        $danceService = new DanceEventService();

        $contentEvents = $repository->getAllVenues();
        if (isset($_SESSION['showPopUpMessage'])) {
            $popUp = $_SESSION['showPopUpMessage'];
        }

        try {
            //determine which button is pressed and add the event to the cart
            if (isset($_POST['danceFridayPass'])) {
                //the daypassdance haarlem is the value to get the correct event
                //second value is for the corresponding day
                //third value is for the kind of ticket  
                //since it unknown what type of ticket it will be, the type of ticket is determined in the addEventToCart function
                $this->addEventToCart('Daypass Dance Haarlem', 'Friday', 'Day', $danceService, $timeTableService, $shoppingCartService);
            } else if (isset($_POST['danceDayPass'])) {
                $this->addEventToCart('Daypass Dance Haarlem', 'SaturdaySunday', 'Day', $danceService, $timeTableService, $shoppingCartService);
            } else if (isset($_POST['danceweekendPass'])) {
                $this->addEventToCart('Weekendpass Dance Haarlem', 'weekendday', 'Weekend', $danceService, $timeTableService, $shoppingCartService);
            }
        } catch (Exception $ex) {
            $_SESSION['showPopUpMessage'] = $ex->getMessage();
            header("Location: /MainDance");
        }


        $pageService = new IntroInformationService();
        $dancePage = $pageService->getPageById(3);



        require __DIR__ . '/../views/Dance/mainDance.php';
    }

    public function addEventToCart($typeOfPass, $day, $kindOfTicket, $danceService, $timeTableService, $shoppingCartService)
    {
        if (!($this->checkForUser())) {
            throw new Exception("Please, Log in to buy tickets");
        }
        $day = htmlspecialchars($_POST[$day]);

        $event = $danceService->getEventbyDate($day, $typeOfPass);

        $typeOfTicket = $timeTableService->getTypeOfTicketByType($kindOfTicket);

        $cartId = $_SESSION["user"]["cartId"];

        $this->addPassToCart($shoppingCartService, $cartId, $event[0]['eventId'], $typeOfTicket, $event[0]['price']);
        $_SESSION['showPopUpMessage'] = "Pass added to shopping cart";
        header("Location: /MainDance");
    }

    public function checkForUser()
    {
        if (isset($_SESSION["user"])) {
            return true;
        }
        return false;
    }

    public function danceTimeTables()
    {
        $timeTableService = new TimeTableService();

        if (isset($_SESSION['showPopUpMessage'])) {
            $popUp = $_SESSION['showPopUpMessage'];
        }

        //When a error message is send to the session it will displayed using the popUpMessage
        $dateOfAllEvents = $timeTableService->getDateOfAllDanceEvents();

        //check if the session is set if not set it to the first date of the event
        if (!isset($_SESSION["TimeTableDateDance"])) {
            $_SESSION["TimeTableDateDance"] = $dateOfAllEvents[0]->date;
        }

        //this will display every single event orderd by date
        $allEventsOfDanceByDate = $timeTableService->getAllDanceEventsByDate($_SESSION["TimeTableDateDance"]);

        //when a new date is selected. The session will be set to the new date and the events will be displayed
        if (isset($_POST["btnTimeTableDate"])) {
            $_SESSION["TimeTableDateDance"] = htmlspecialchars($_POST["btnTimeTableDate"]);
            $allEventsOfDanceByDate = $timeTableService->getAllDanceEventsByDate($_SESSION["TimeTableDateDance"]);
        }

        try {
            if (isset($_POST["btnAddTicket"])) {
                $timeTableController = new TimeTableController();
                $timeTableController->addToShoppingCart();
                $_SESSION['showPopUpMessage'] = "Event added to shopping cart";
                header("Location: /MainDance/danceTimeTables");

            }
        } catch (Exception $ex) {
            $_SESSION['showPopUpMessage'] = $ex->getMessage();
            header("Location: /MainDance/danceTimeTables");

        }



        require __DIR__ . '/../views/Dance/danceTimeTables.php';
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

    public function detailMartinGarrix()
    {

        require __DIR__ . '/../views/dance/detailPages/detailMartinGarrix.php';
    }

    public function detailTiesto()
    {
        $artistName = "Tiësto";
        require __DIR__ . '/../views/dance/detailPages/detailTiesto.php';
    }

    public function detailGeneralArtist()
    {
        require __DIR__ . '/../views/dance/detailPages/detailGenericArtist.php';
    }

    public function __call($name, $args)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $args);
        } else {
            $this->detailGeneralArtist();
        }
    }

}