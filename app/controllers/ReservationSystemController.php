<?php
require_once __DIR__ . "/../services/YummyService.php";
require_once __DIR__ . "/../services/ShoppingCartService.php";
require_once __DIR__ . "/../services/reservationService.php";
class ReservationSystemController
{
    public function index()
    {
        try {
            if (isset($_SESSION["user"]['userId'])) {

                if (isset($_SESSION['showPopUpMessage'])) {
                    $popUp = $_SESSION['showPopUpMessage'];
                }

                $errorMessage = "";
                $YummyService = new YummyService();
                $ShoppingCartService = new ShoppingCartService();
                $reservationService = new reservationService();
                $informationRestaurants = $YummyService->getMoreInformationOfRestaurants($_SESSION['restaurantInformation']);

                $this->resetSessions();
                $dateTime = $this->setSessions($informationRestaurants);

                $yummyEventInfo = $YummyService->getEvent($_SESSION['restaurantName']);
                $errorMessage = $this->clickReservationButton($reservationService, $dateTime, $ShoppingCartService);

                $this->backgroundColorChange('amountOfPeople', "#tableBorder");
                $this->backgroundColorChange('time', ".time");
                $this->backgroundColorChange('date', ".date");

                require __DIR__ . '/../views/Yummy/ReservationSystem.php';
            } else {
                header("Location: /Login");
            }
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }

    public function clickReservationButton($reservationService, $dateTime, $ShoppingCartService)
    {
        try {
            $reservationCheck = false;

            if (isset($_POST["makeReservation"])) {
                if (isset($_SESSION['date']) && isset($_SESSION['time']) && isset($_SESSION['amountOfPeople'])) {
                    $infoShoppingCart = $ShoppingCartService->getYummyEvent($_SESSION["user"]['userId'], $dateTime);

                    $errorMessage = $this->updateSeats($reservationService, $infoShoppingCart, $dateTime);
                    if ($errorMessage != "") { return $errorMessage; }

                    // get shoppingCart information
                    $shoppingCart = $ShoppingCartService->getShoppingCart($_SESSION["user"]['userId']);
                    // get yummy event infomation
                    $eventId = $ShoppingCartService->getEventIdYummy($_SESSION['restaurantName'], $dateTime);
                    //Check if this user already made a reservation at this restaurant at the exact time to increase the amount instead of adding a new item
                    $reservationCheck = $this->checkShoppingCartOnYummyItems($shoppingCart, $ShoppingCartService, $eventId, $dateTime, $reservationCheck, $reservationService);

                    if (!$reservationCheck) {
                        $ShoppingCartService->addItemToShoppingCart($infoShoppingCart[0]['id'], $eventId[0]['eventId'], $_SESSION['amountOfPeople'], ($_SESSION['amountOfPeople'] * $eventId[0]['price']), 2);
                        $reservationService->setReservation($_SESSION['restaurantName'], $dateTime, $_SESSION['specialRequests'], $_SESSION['amountOfPeople']);
                    }

                    header("Location: /ReservationComplete");
                } else {
                    return $errorMessage = "Please fill all fields before proceeding!";
                }
            }
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "Something went wrong while making the reservation.";
        }
    }


    public function checkShoppingCartOnYummyItems($shoppingCart, $ShoppingCartService, $eventId, $dateTime, $reservationCheck, $reservationService)
    {
        try {
            for ($i = 0; $i < count($shoppingCart); $i++) {
                $restaurant = $ShoppingCartService->getYummyEventsOnEventId($shoppingCart[$i]['eventId']);

                //Check if this user already made a reservation at this restaurant at the exact time to increase the amount instead of adding a new item
                if ($shoppingCart[$i]['category'] == 'Yummy' && $reservationCheck == false && $restaurant[0]['restaurant'] == $_SESSION['restaurantName'] && date("y-m-d H:i:s", strtotime($restaurant[0]['date'])) == $dateTime) {
                    $quantity = $shoppingCart[$i]['quantityOrder'] + $_SESSION['amountOfPeople'];
                    $subTotal = ($_SESSION['amountOfPeople'] * $eventId[0]['price']) + $shoppingCart[$i]['subTotal'];
                    $ShoppingCartService->updateQuantityOfItems($shoppingCart[$i]['id'], $quantity, $subTotal);
                    $reservationService->updateQuantityOfReservation($shoppingCart[$i]['id'], $quantity);
                    return true;
                }
            }
            return false;
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "Something went wrong while checking the reservations.";
        }
    }

    // hier word gecheckt of er nog genoeg plekken zijn en update dan de quantity
    private function updateSeats($reservationService, $infoShoppingCart, $dateTime)
    {
        try {
            $seats = $infoShoppingCart[0]['quantity'] - $_SESSION['amountOfPeople'];

            if ($seats >= 0) {
                if ($_SESSION['specialRequests'] == "") {
                    $_SESSION['specialRequests'] = "None";
                }
                $reservationService->updateSeats($seats, $_SESSION['restaurantName'], $dateTime);
            } else if ($infoShoppingCart[0]['quantity'] > 0) {
                throw new Exception("Sorry, there are only " . $infoShoppingCart[0]['quantity'] . " seats available. Please choose another time or day!");
            } else {
                throw new Exception("Sorry, there are no seats available. Please choose another time or day!");
            }
        } catch (Exception $e) {
            return $errorMessage = $e->getMessage();
        }
    }
// hier worden de sessions geset waar de waarden instaan van wat je aanklikt bij het reserveren
    private function setSessions($informationRestaurants)
    {
        try {
            $dateTime = "";
            $_SESSION['restaurantName'] = $informationRestaurants[0]->title;

            for ($i = 1; $i < 4; $i++) {
                
                if (isset($_POST["date"])) {
                    $_SESSION['date'] = htmlspecialchars($_POST["date"]);
                } else if (isset($_POST["time"])) {
                    $_SESSION['time'] = htmlspecialchars($_POST["time"]);
                } else if (isset($_POST["peopleBtn" . $i])) {
                    $_SESSION['amountOfPeople'] = htmlspecialchars($_POST["peopleBtn" . $i]);
                } else if (isset($_POST['specialRequests'])) {
                    $_SESSION['specialRequests'] = htmlspecialchars($_POST['specialRequests']);
                }
            }

            if (isset($_SESSION['date']) && isset($_SESSION['time'])) {
                $dateTime = date("y-m-d H:i:s", strtotime($_SESSION['date'] . ' ' . $_SESSION['time']));
            }

            return $dateTime;
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "Something went wrong with moving some data.";
        }
    }


    // Ik had de waardes in een session gestopt waardoor als je geen reservering maakte
    // de waardes van de reservering wel blijven staan
    public function resetSessions()
    {
        try {
            for ($i = 0; $i < 4; $i++) {
                if (!isset($_POST["date"]) && !isset($_POST["time"]) && !isset($_POST["specialRequests"]) && !isset($_POST["peopleBtn" . $i])) {
                    $session_names = array('specialRequests', 'date', 'time', 'amountOfPeople');

                    foreach ($session_names as $session_name) {
                        $_SESSION[$session_name] = null;
                    }
                }
            }
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "Something went wrong with deleting some data.";
        }
    }

    //hier word het roze kleurtje op de juiste plek geset
    private function backgroundColorChange($stringSession, $stringStyle)
    {
        try {
            if (isset($_SESSION[$stringSession])) {
                echo "<style> " . $stringStyle .  $_SESSION[$stringSession] . "{ background-color: #FF7E7E; } </style>";
            }
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "Something went wrong with loading the page.";
        }
    }
}
