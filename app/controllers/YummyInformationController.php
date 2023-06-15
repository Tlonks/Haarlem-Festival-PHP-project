<?php
require_once __DIR__ . "/../services/YummyService.php";
class YummyInformationController
{
    public function index()
    {
        try {
            if (isset($_SESSION['showPopUpMessage'])) {
                $popUp = $_SESSION['showPopUpMessage'];
            }

            $YummyService = new YummyService();
            $informationRestaurants = $YummyService->getMoreInformationOfRestaurants($_SESSION['restaurantInformation']);

            require __DIR__ . '/../views/Yummy/YummyInformation.php';
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }
}
