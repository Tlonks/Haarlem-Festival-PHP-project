<?php
require_once __DIR__ . '/../services/timeTableService.php';

class TimeTableController
{
    public function addToShoppingCart()
    {
        //First check if a user is logged in
        if (!($this->checkForUser())) {
            throw new Exception("Please, Log in to buy tickets");
        }
        $timeTableService = new TimeTableService();

        //retrieve the event id of the selected event and the amount of solo tickets
        $eventId = htmlspecialchars($_POST["btnAddTicket"]);
        $amountSoloTickets = htmlspecialchars($_POST["amountSoloTickets"]);
        $amountFamilyTickets = htmlspecialchars($_POST["amountFamilyTickets"]);

        //check if the user has entered a valid amount of tickets
        $this->checkSoloAndFamilyTickets($amountSoloTickets, $amountFamilyTickets, $timeTableService, $eventId);
        
        if($amountSoloTickets != 0){
            $this->addSelectedEventToCart('Solo', $timeTableService, $amountSoloTickets, $eventId); 
        }

        if($amountFamilyTickets != 0){
            $this->addSelectedEventToCart('Family', $timeTableService, $amountFamilyTickets, $eventId);  
        }
            
        
    }
    public function checkForUser()
    {
        if (isset($_SESSION["user"])) {
            return true;
        }
        return false;
    }

    public function checkSoloAndFamilyTickets($amountSoloTickets, $amountFamilyTickets, $timeTableService, $eventId)
    {
        if ($amountSoloTickets != 0 && $amountFamilyTickets != 0) {
            $event = $timeTableService->getEventById($eventId);

            //get from the database how many tickets a familyTicket is in total
            $typeOfTicket = $timeTableService->getTypeOfTicketByType('Family');

            if ($amountSoloTickets + $amountFamilyTickets * $typeOfTicket['amount'] > $event['quantity']) {
                throw new Exception("Not enough Solo and Family tickets");
            }
        }
        else if($amountSoloTickets == 0 && $amountFamilyTickets == 0){
            throw new Exception("Please, enter a valid amount of tickets");
        }
    }

    public function addSelectedEventToCart($ticket, $timeTableService, $amountTickets, $eventId)
    {
        $event = $timeTableService->getEventById($eventId);
        $typeOfTicket = $timeTableService->getTypeOfTicketByType($ticket);

        $subTotal = $this->calculateSubTotal($event, $amountTickets, $typeOfTicket);
        
        //place 1 event in the shopping cart by creating one shoppingcartitem

        if ($this->checkAddedEvent($event['eventId'], $typeOfTicket['id'])) {
            $this->createShoppingCartItem($event, $amountTickets, $subTotal, $typeOfTicket['id'], $typeOfTicket['amount']);
        } else {
            $this->addToExistingShoppingCartItem($amountTickets, $subTotal, $event['eventId'], $typeOfTicket['id'], $event, $typeOfTicket['amount']);
        }
    }

    public function calculateSubTotal($event, $amountTickets, $typeOfTicket)
    {
        //Since a family ticket is 4 tickets in total, we need to calculate the subtotal differently
        switch($typeOfTicket['type']){
            case 'Solo':
                return $this->calculateSubTotalSolo($event, $amountTickets);
            case 'Family':
                return $this->calculateSubTotalFamilyHistory($event, $amountTickets);
        }
    }


    public function calculateSubTotalSolo($event, $amountSoloTickets)
    {
        return ($amountSoloTickets * $event['price']);
    }

    public function calculateSubTotalFamilyHistory($event, $amountFamilyTickets)
    {
        $timeTableService = new TimeTableService();

        $historyEvent = $timeTableService->getHistoryEventById($event['eventId']);
        return ($amountFamilyTickets * $historyEvent[0]->familyPrice);
    }
    public function createShoppingCartItem($event, $amountTotal, $subTotal, $typeOfTicket, $typeOfTicketMinius)
    {
        // get the user id from the session and place it in the shopping cart
        $cartId = $_SESSION["user"]["cartId"];

        $timeTableService = new TimeTableService();

        //check if the event contains enough tickets for purchase
        if ($this->CheckForTickets($amountTotal, $event, $typeOfTicketMinius)) {
            $timeTableService->addItemToShoppingCart($cartId, $event['eventId'], $amountTotal, $subTotal, $typeOfTicket);
        } else {
            throw new Exception("Not enough tickets");
        }
    }
    
    public function addToExistingShoppingCartItem($quantityAmount, $subTotal, $eventId, $typeOfTicket, $event, $typeOfTicketMinius)
    {
        //If the shopping cart item already exists, update the existing shopping cart
        $timeTableService = new TimeTableService();

        $cartId = $_SESSION["user"]["cartId"];
        if ($this->CheckForTickets($quantityAmount, $event, $typeOfTicketMinius)) {
            $shoppingCartItem = $timeTableService->checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket);
            $timeTableService->updateShoppingCartItemById($shoppingCartItem[0]->id, $quantityAmount, $subTotal);
        } else {
            throw new Exception("Not enough tickets");
        }
    }
    public function CheckForTickets($amountTotal, $event, $typeOfTicketMinius)
    {
        //When there are enough tickets return true and update the amount of tickets
        $timeTableService = new TimeTableService();
        $amountTotal = $amountTotal * $typeOfTicketMinius;

        if ($event['quantity'] >= $amountTotal) {
            $event['quantity'] -= $amountTotal;
            $timeTableService->UpdateAvailableTickets($event['quantity'], $event['eventId']);
            return true;
        }
        return false;
    }

    public function checkAddedEvent($eventId, $typeOfTicket)
    {
        $timeTableService = new TimeTableService();

        $cartId = $_SESSION["user"]["cartId"];
        $shoppingCartItem = $timeTableService->checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket);
        if (COUNT($shoppingCartItem) == 0) {
            return true;
        }
        return false;
    }
}