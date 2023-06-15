<?php

class checkoutService{

    public function calculateTotal($infoShoppingCart)
    {
        $totalPrice = 0;
        for ($i = 0; $i < count($infoShoppingCart); $i++) {
            $totalPrice += $infoShoppingCart[$i]['subTotal'];
        }
        return $totalPrice;
    }

    public function setRevervationNull($infoShoppingCart, $reservationService)
    {
        for ($i = 0; $i < count($infoShoppingCart); $i++) {
            if ($infoShoppingCart[$i]['category'] == 'Yummy') {
                $reservationService->setReservationNull($infoShoppingCart[$i]['id']);
            }
        }
    }


    //Maakt nieuwe tickets aan en geeft alle qr codes terug in een array
    public function generateQrCodes($orderItems, $ticketService){
        $qrCodeArray = array();
        $itemsArray = array();
        for ($i = 0; $i < count($orderItems); $i++) {

            for ($j = 0; $j < $orderItems[$i]['quantityOrder']; $j++) {
                if ($orderItems[$i]['typeOfTicket'] == "3" || $orderItems[$i]['typeOfTicket'] == "4") {

                    $qrcode = $ticketService->newPassTicket($orderItems[$i], $_SESSION["user"]['userId']);

                    $itemsArray[$j]['value'] = $qrcode;
                    $qrCodeArray[$orderItems[$i]['0']]['value'] = $itemsArray;


                } else {

                    $qrcode = $ticketService->newTicket($orderItems[$i], $_SESSION["user"]['userId']);

                    $itemsArray[$j]['value'] = $qrcode;

                    $qrCodeArray[$orderItems[$i]['0']]['value'] = $itemsArray;

                }
            }
        }
        return $qrCodeArray;
    }

}

?>