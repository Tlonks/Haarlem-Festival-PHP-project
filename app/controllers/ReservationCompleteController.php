<?php
class ReservationCompleteController
{
    public function index()
    {
        try {

            if (isset($_SESSION['showPopUpMessage'])) {
                $popUp = $_SESSION['showPopUpMessage'];
            }

            require __DIR__ . '/../views/Yummy/ReservationComplete.php';
        } catch (Exception) {
            $_SESSION['showPopUpMessage'] = "something went wrong with loading the page.";
        }
    }
}
