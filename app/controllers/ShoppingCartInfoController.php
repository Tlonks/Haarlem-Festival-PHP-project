<?php
class ShoppingCartInfoController
{
    public function extraEventInfo($infoShoppingCart, $ShoppingCartService)
    {
        $eventInfo = array();

        for ($i = 0; $i < count($infoShoppingCart); $i++) {

            switch ($infoShoppingCart[$i]['category']) {
                case "History":
                    $historyEvents = $ShoppingCartService->getHistoryEventsOnEventId($infoShoppingCart[$i]['eventId']);
                    $eventInfo[$i] = " - " . $historyEvents[0]['language'];
                    break;
                case "Jazz":
                    $jazzEvents = $ShoppingCartService->getJazzEventsOnEventId($infoShoppingCart[$i]['eventId']);
                    $eventInfo[$i] = " - " . $jazzEvents[0]['hall'];
                    break;
                case "Dance":
                    $DanceEvents = $ShoppingCartService->getDanceEventsOnEventId($infoShoppingCart[$i]['eventId']);
                    $eventInfo[$i] = " - " . $DanceEvents[0]['location'];
                    break;
                case "Yummy":
                    $YummyEvents = $ShoppingCartService->getYummyEventsOnEventId($infoShoppingCart[$i]['eventId']);
                    $eventInfo[$i] = " - " . $YummyEvents[0]['restaurant'];
                    break;
                default:
                    $eventInfo[$i] = "";
                    break;
            }
        }
        return $eventInfo;
    }

    public function checkFamilyTicket($infoShoppingCart, $ShoppingCartService)
    {
        $price = array();

        for ($i = 0; $i < count($infoShoppingCart); $i++) {
            if ($infoShoppingCart[$i]['type'] == 'Family') {
                $familyPrice = $ShoppingCartService->getFamilyPriceOnUserId($_SESSION["user"]['userId'], $infoShoppingCart[$i]['eventId']);
                $price[$i] = $familyPrice[0]['familyPrice'];
            } else {
                $price[$i] = $infoShoppingCart[$i]['price'];
            }
        }
        return $price;
    }
}
