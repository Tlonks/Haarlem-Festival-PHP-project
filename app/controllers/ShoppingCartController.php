<?php

use BaconQrCode\Renderer\Path\OperationInterface;
use LDAP\Result;
use PgSql\Result as PgSqlResult;

require_once __DIR__ . "/../services/ShoppingCartService.php";
require_once __DIR__ . "/../services/reservationService.php";
require_once __DIR__ . "/../controllers/ShoppingCartInfoController.php";
class ShoppingCartController extends ShoppingCartInfoController
{
    public function index()
    {
        try {
            if (isset($_SESSION["user"]['userId'])) {
                if (isset($_SESSION['showPopUpMessage'])) {
                    $popUp = $_SESSION['showPopUpMessage'];
                }

                $ShoppingCartService = new ShoppingCartService();
                $reservationService = new reservationService();
                $infoShoppingCart = $ShoppingCartService->getShoppingCart($_SESSION["user"]['userId']);
                $eventInfo = $this->extraEventInfo($infoShoppingCart, $ShoppingCartService);
                $price = $this->checkFamilyTicket($infoShoppingCart, $ShoppingCartService);

                if (isset($_POST['btnRemove'])) {
                    $this->reduceOrIncreaseTicketAmount($ShoppingCartService, $infoShoppingCart, '-', '+', 'btnRemove', $reservationService);
                    
                    if ($infoShoppingCart[$_POST['btnRemove']]['quantityOrder'] == 1) {
                        if($infoShoppingCart[$_POST['btnRemove']]['category'] == 'Yummy') {
                            $reservationService->reservationCanceled($infoShoppingCart[htmlspecialchars($_POST['btnRemove'])]['id']);
                        }
                        $ShoppingCartService->deleteShoppingCartItem($infoShoppingCart[htmlspecialchars($_POST['btnRemove'])]['id']);
                    }
                } else if (isset($_POST['btnAdd'])) {
                    $this->reduceOrIncreaseTicketAmount($ShoppingCartService, $infoShoppingCart, '+', '-', 'btnAdd', $reservationService);
                } else if (isset($_POST['btnCheckOut'])) {
                    header("Location: /Checkout");
                } else if (isset($_POST['btnShare'])) {
                    header("Location: /ShareShoppingCart");
                }

                $infoShoppingCart = $ShoppingCartService->getShoppingCart($_SESSION["user"]['userId']);
                require_once __DIR__ . '/../views/Checkout/ShoppingCart.php';
            } else {
                header("Location: /Login");
            }
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }

    // Deze method zorgt ervoor dat de hoeveelheid van de tickets omhoog of omlaag gaat
    // er word daarom ook gecheckt of het een family of solo ticket is 
    // duplicate code
    // begonnen met shoppingCart en kwamen steeds nieuwe problemen tegen
    public function reduceOrIncreaseTicketAmount($ShoppingCartService, $infoShoppingCart,  $firstOperator, $secondOperator, $btn, $reservationService)
    {
        try {
            $familyPrice = $ShoppingCartService->getFamilyPriceOnUserId($_SESSION["user"]['userId'], $infoShoppingCart[htmlspecialchars($_POST[$btn])]['eventId']);
            $quantityOrder = $this->addOrSubstract($infoShoppingCart[htmlspecialchars($_POST[$btn])]['quantityOrder'], 1, $firstOperator);
            $subTotal = $this->addOrSubstract($infoShoppingCart[htmlspecialchars($_POST[$btn])]['subTotal'], $infoShoppingCart[htmlspecialchars($_POST[$btn])]['price'], $firstOperator);
            $quantity = $this->addOrSubstract($infoShoppingCart[htmlspecialchars($_POST[$btn])]['quantity'], 1, $secondOperator);

            if ($infoShoppingCart[$_POST[$btn]]['type'] == 'Family') {
                $subTotal = $this->addOrSubstract($infoShoppingCart[htmlspecialchars($_POST[$btn])]['subTotal'], $familyPrice[0]['familyPrice'], $firstOperator);
                $quantity = $this->addOrSubstract($infoShoppingCart[htmlspecialchars($_POST[$btn])]['quantity'], $infoShoppingCart[htmlspecialchars($_POST[$btn])]['amount'], $secondOperator);
            } 

            $ShoppingCartService->updateQuantityOfItems((int) $infoShoppingCart[htmlspecialchars($_POST[$btn])]['id'], $quantityOrder, $subTotal);
            $ShoppingCartService->UpdateAmountTickets((int) $infoShoppingCart[htmlspecialchars($_POST[$btn])]['eventId'], $quantity);
            $reservationService->updateQuantityOfReservation($infoShoppingCart[htmlspecialchars($_POST[$btn])]['id'], $quantityOrder);

        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong while adding or removing a ticket.";
        }
    }

    public function addOrSubstract($a, $b, $operator)
    {
        try {
            switch ($operator) {
                case '+':
                    $result = $a + $b;
                    break;
                case '-':
                    $result = $a - $b;
                    break;
            }

            return $result;
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with adding or substracting values.";
        }
    }

}
