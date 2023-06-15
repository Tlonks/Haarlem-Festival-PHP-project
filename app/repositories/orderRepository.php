<?php
require_once __DIR__ . "/repository.php";
require_once __DIR__ . "/../models/orders.php";
require_once __DIR__ . "/../models/orderItems.php";

class orderRepository extends Repository
{
    //Haalt alle orders op en de orderitems
    public function getAll()
    {
        $stmt = $this->connection->prepare("SELECT * FROM Orders AS OS
        JOIN OrderItems AS OI ON OS.id = OI.orderId
        JOIN Events AS ET ON ET.eventId = OI.eventId");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Orders');
        $result = $stmt->fetchAll();
        return $result;
    }
    //Haalt alleen de orders op
    public function getAllOrders()
    {
        $stmt = $this->connection->prepare("SELECT id, userId, totalPrice, addedVAT, isPaid FROM Orders;");
        $stmt->execute();

        return $stmt->fetchAll();
    }
    //Haalt alleen de orderitems op
    public function getOrderItemInfo($orderId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM OrderItems
        JOIN TypeOfTicket ON TypeOfTicket.id = OrderItems.typeOfTicket
        JOIN Events ON Events.eventId = OrderItems.eventId
        WHERE orderId = :OrderId");
        $stmt->bindParam(':OrderId', $orderId);
        $stmt->execute();


        $result = $stmt->fetchAll();
        return $result;
    }

    public function newOrder($infoShoppingCart, $userId, $totalPrice, $addedVAT)
    {
        $stmt = $this->connection->prepare("INSERT INTO Orders 
        (id, userId, totalPrice, addedVAT) VALUES (NULL, :UserId, :TotalPrice, :AddedVAT);
        Select LAST_INSERT_ID() as id");
        $stmt->bindParam(':UserId', $userId);
        $stmt->bindParam(':TotalPrice', $totalPrice);
        $stmt->bindParam(':AddedVAT', $addedVAT);
        $stmt->execute();
        $last_id = $this->connection->lastInsertId();
        return $last_id;
    }

    public function newOrderItems($item, $orderId)
    {
        $stmt = $this->connection->prepare("INSERT INTO `OrderItems` 
        (`id`, `orderId`, `eventId`, `quantityOrder`, `subTotal`, `typeOfTicket`) VALUES (NULL, :orderId, :eventId, :quantityOrder, :subTotal, :typeOfTicket)");
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':eventId', $item->eventId);
        $stmt->bindParam(':quantityOrder', $item->quantityOrder);
        $stmt->bindParam(':subTotal', $item->subTotal);
        $stmt->bindParam(':typeOfTicket', $item->typeOfTicket);
        $stmt->execute();
    }


    //Haalt specifieke order op
    public function getOrder($orderId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM OrderItems
        JOIN Orders ON Orders.id = OrderItems.orderId
        JOIN Events ON Events.eventId = OrderItems.eventId
        WHERE Orders.userId = :orderId");
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Orders');
        $result = $stmt->fetchAll();
        return $result;
    }
    //Haalt specifieke orderitems op
    public function getOrderItems($orderId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM OrderItems WHERE orderId = :OrderId");
        $stmt->bindParam(':OrderId', $orderId);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'OrderItems');
        $result = $stmt->fetchAll();
        return $result;

    }
    //Haalt specifieke order op zonder orderitems
    public function getSingleOrder($orderId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Orders WHERE id = :OrderId");
        $stmt->bindParam(':OrderId', $orderId);
        $stmt->execute();


        $result = $stmt->fetchAll();
        return $result;
    }
    //Haalt alle orderitems op met event info
    public function getAllOrderItems()
    {
        $stmt = $this->connection->prepare("SELECT * FROM OrderItems
        JOIN Events ON Events.eventId = OrderItems.eventId");

        $stmt->execute();


        $result = $stmt->fetchAll();
        return $result;
    }
    //Haalt alle orders op voor api in array formaat met event informatie
    public function getAllOrderItemsAPI()
    {
        $stmt = $this->connection->prepare("SELECT * FROM OrderItems JOIN Events ON Events.eventId = OrderItems.eventId");

        $stmt->execute();


        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Haalt alle orders op voor api in array formaat
    public function getAllordersAPI()
    {
        $stmt = $this->connection->prepare("SELECT * FROM Orders");

        $stmt->execute();


        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Order status aanpassen
    public function setOrderPaid($orderId, $status)
    {
        $stmt = $this->connection->prepare("UPDATE Orders SET isPaid = :isPaid WHERE id = :OrderId");
        $stmt->bindParam(':OrderId', $orderId);
        $stmt->bindParam(':isPaid', $status);
        $stmt->execute();
    }

    public function getOrderPaid($userId)
    {
        $stmt = $this->connection->prepare("SELECT isPaid FROM Orders WHERE userId = :userId ORDER BY Orders.id DESC LIMIT 1;");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $result = $stmt->fetchColumn(); // fetch the value of the isPaid column
        return $result;
    }

}