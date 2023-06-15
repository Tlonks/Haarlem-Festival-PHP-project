<?php
require_once __DIR__ . "/../services/YummyService.php";
require_once __DIR__ . '/../services/IntroInformationService.php';
class MainYummyController
{
    public function index()
    {
        try {
 
            $YummyService = new YummyService;
            $pageService = new IntroInformationService();
            $contentRestaurants = $YummyService->getAllContentOfRestaurants();
            $yummyPage = $pageService->getPageById(1);

            if (isset($_POST["seeMoreRestaurantsBtn"])) {
                $_SESSION['restaurantInformation'] = htmlspecialchars($_POST["seeMoreRestaurantsBtn"]);
                header("Location: /YummyInformation");
            } else if (isset($_SESSION['showPopUpMessage'])) {
                $popUp = $_SESSION['showPopUpMessage'];
            }

            require __DIR__ . '/../views/Yummy/MainYummy.php';
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }
}
