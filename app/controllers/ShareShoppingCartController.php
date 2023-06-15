<?php
require_once __DIR__ . "/../services/ShoppingCartService.php";
require_once __DIR__ . "/../controllers/ShoppingCartInfoController.php";
class ShareShoppingCartController extends ShoppingCartInfoController
{
    public function index()
    {
        try {
            if (isset($_SESSION['showPopUpMessage'])) {
                $popUp = $_SESSION['showPopUpMessage'];
            }
            
            $ShoppingCartService = new ShoppingCartService();
            $infoShoppingCart = $ShoppingCartService->getShoppingCart(base64_decode($_GET['userId']));
            $eventInfo = $this->extraEventInfo($infoShoppingCart, $ShoppingCartService);
            $price = $this->checkFamilyTicket($infoShoppingCart, $ShoppingCartService);

            require __DIR__ . '/../views/Checkout/ShareShoppingCart.php';

        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }
}
