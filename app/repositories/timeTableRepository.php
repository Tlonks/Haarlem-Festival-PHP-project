<?php
require_once __DIR__ . "/repository.php";
require_once __DIR__ . "/../models/historyEvent.php";
require_once __DIR__ . "/../models/danceEvent.php";
require_once __DIR__ . "/../models/jazzEvent.php";
require_once __DIR__ . "/../models/ShoppingCartItems.php";


class TimeTableRepository extends Repository
{
    public function getDateOfAllHistoricEvents()
    {
        $stmt = $this->connection->prepare("SELECT * FROM `Events` WHERE category = 'History' GROUP BY DATE(`date`)");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'historyEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getDateOfAllDanceEvents()
    {
        $stmt = $this->connection->prepare("SELECT * FROM `Events` WHERE category = 'Dance' GROUP BY DATE(`date`)");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'danceEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getDateOfAllJazzEvents()
    {
        $stmt = $this->connection->prepare("SELECT * FROM `Events` WHERE category = 'Jazz' GROUP BY DATE(`date`)");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'jazzEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getDateOfAllDanceAndJazzEvents()
    {
        $stmt = $this->connection->prepare("SELECT * FROM `Events` WHERE category = 'Dance' OR category = 'Jazz' GROUP BY DATE(`date`)");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'jazzEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllHistoricEventsByDate($date)
    {
        $stmt = $this->connection->prepare("SELECT * FROM History as HI JOIN Events as EV ON HI.eventId = EV.eventId WHERE DATE(`date`) = DATE(:date)");
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'historyEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllDanceEventsByDate($date)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Dance as DA JOIN Events as EV ON DA.eventId = EV.eventId WHERE DATE(`date`) = DATE(:date)");
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'danceEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllJazzEventsByDate($date)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Jazz as JZ JOIN Events as EV ON JZ.eventId = EV.eventId JOIN Artists as AR ON JZ.artistId = AR.id WHERE DATE(`date`) = DATE(:date)");
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'jazzEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getEventById($eventId)
    {
        $stmt = $this->connection->prepare("SELECT eventId, name , category, date, price, quantity FROM Events WHERE eventId = :eventId");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }

    public function getHistoryEventById($eventId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM History AS HI JOIN Events AS EV ON HI.eventId = EV.eventId WHERE HI.eventId = :eventId");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'historyEvent');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function addItemToShoppingCart($cartId, $eventId, $quantityOrder, $subTotal, $typeOfTicket)
    {
        $stmt = $this->connection->prepare("INSERT INTO `ShoppingCartItems`(`cartId`, `eventId`, `quantityOrder`, `subTotal`, `typeOfTicket`) 
        VALUES (:cartId,:eventId,:quantityOrder,:subTotal, :typeOfTicket);
        UPDATE `ShoppingCart` SET `totalPrice`=`totalPrice`+ :subTotal WHERE id=:cartId;");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':quantityOrder', $quantityOrder);
        $stmt->bindParam(':subTotal', $subTotal);
        $stmt->bindParam(':typeOfTicket', $typeOfTicket);
        $stmt->execute();
    }

    public function UpdateAvailableTickets($amountTotal, $eventId)
    {
        $stmt = $this->connection->prepare("UPDATE Events SET quantity = :amountTickets WHERE eventId = :eventId;");
        $stmt->bindParam(':amountTickets', $amountTotal);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();
    }

    public function checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket){
        $stmt = $this->connection->prepare("SELECT * FROM ShoppingCartItems
        WHERE cartId = :cartId AND eventId = :eventId AND typeOfTicket = :typeOfTicket");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':typeOfTicket', $typeOfTicket);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'ShoppingCartItems');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function updateShoppingCartItemById($shoppingCartId, $quantityAmount, $subTotal){
        $stmt = $this->connection->prepare("UPDATE ShoppingCartItems
        SET quantityOrder = quantityOrder + :quantityOrder, subTotal = subTotal + :subTotal
        WHERE id = :id");
        $stmt->bindParam(':id', $shoppingCartId);
        $stmt->bindParam(':subTotal', $subTotal);
        $stmt->bindParam(':quantityOrder', $quantityAmount);
        $stmt->execute();
    }
    
    public function getTypeOfTicketByType($TypeOFTicket){
        $stmt = $this->connection->prepare("SELECT * FROM TypeOfTicket WHERE type = :TypeOFTicket");
        $stmt->bindParam(':TypeOFTicket', $TypeOFTicket);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

}
