<?php
require_once __DIR__ . "/../models/ShoppingCart.php";
require_once __DIR__ . "/../models/ShoppingCartItems.php";
require_once __DIR__ . "/../models/jazzEvent.php";
require_once __DIR__ . "/../models/historyEvent.php";
require_once __DIR__ . "/repository.php";

class ShoppingCartRepository extends Repository
{
    public function getShoppingCart($userId)
    {
        $stmt = $this->connection->prepare("SELECT US.userId, US.cartId, SI.eventId,
        SI.quantityOrder, SI.subTotal, ET.name, ET.category, ET.date, ET.price,
        ET.quantity, SI.id, SS.totalPrice, SS.addedVAT, TT.type, TT.amount
        FROM Users AS US
        JOIN ShoppingCart AS SS ON US.cartId = SS.id
        JOIN ShoppingCartItems AS SI ON SS.id = SI.cartId
        JOIN TypeOfTicket AS TT ON TT.id = SI.typeOfTicket
        JOIN Events AS ET ON ET.eventId = SI.eventId
        WHERE userId = :userId AND ET.eventId = SI.eventId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }
    public function getFamilyPriceOnUserId($userId, $eventId)
    {
        $stmt = $this->connection->prepare("SELECT HY.familyPrice
        FROM Users AS US
        JOIN ShoppingCart AS SS ON US.cartId = SS.id
        JOIN ShoppingCartItems AS SI ON SS.id = SI.cartId
        JOIN Events AS ET ON ET.eventId = SI.eventId
        JOIN History AS HY ON HY.eventId = ET.eventId
        WHERE US.userId = :userId AND ET.eventId = :eventId");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }

   


    public function getShoppingCartById($cartId){
        $stmt = $this->connection->prepare("SELECT * FROM ShoppingCart WHERE id = :cartId;");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }

  

    //to do last_inserted_id anders doen.
    public function createShoppingCart()
    {
        $stmt = $this->connection->prepare("INSERT INTO `ShoppingCart` 
        (`id`, `totalPrice`, `addedVAT`) VALUES (NULL, '0', '0');
        Select LAST_INSERT_ID() as id");
        $stmt->execute();
        $last_id = $this->connection->lastInsertId();
        return $last_id;
    }


    public function getAll()
    {
        $stmt = $this->connection->prepare("SELECT SS.cartId, SI.eventId,
        SI.quantityOrder, SI.subTotal, ET.name, ET.category, ET.date, ET.price,
        ET.quantity FROM ShoppingCartItems AS SI
        JOIN ShoppingCart AS SS ON ShoppingCart.id = ShoppingCartItems.cartId
        JOIN Events AS ET ON Events.eventId = ShoppingCartItems.eventId");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'ShoppingCart');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function deleteShoppingCart($id)
    {
        $stmt = $this->connection->prepare("UPDATE ShoppingCart SET totalPrice = 0, addedVAT = 0
        WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteShoppingCartItems($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM ShoppingCartItems
        WHERE cartId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }



    public function getShoppingCartItems($cartId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM ShoppingCartItems
        WHERE cartId = :cartId");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'ShoppingCartItems');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function deleteShoppingCartItem($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM ShoppingCartItems
        WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function addItemToShoppingCart($cartId, $eventId, $quantityOrder, $subTotal, $typeOfTicketId)
    {
        $stmt = $this->connection->prepare("INSERT INTO `ShoppingCartItems`(`cartId`, `eventId`, `quantityOrder`, `subTotal`, `typeOfTicket`) 
        VALUES (:cartId,:eventId,:quantityOrder,:subTotal, :typeOfTicket);
        UPDATE `ShoppingCart` SET `totalPrice`=`totalPrice`+ :subTotal WHERE id=:cartId;");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':quantityOrder', $quantityOrder);
        $stmt->bindParam(':subTotal', $subTotal);
        $stmt->bindParam(':typeOfTicket', $typeOfTicketId);
        $stmt->execute();
    }

    public function getTotalPrice($cartId)
    {
        $stmt = $this->connection->prepare("SELECT totalPrice FROM ShoppingCart
        WHERE id = :cartId");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }


    public function getHistoryEventsOnEventId($eventId)
    {
        $stmt = $this->connection->prepare("SELECT language FROM Events
        JOIN History ON History.eventId = Events.eventId
        WHERE Events.eventId = :eventId AND Events.eventId = History.eventId");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }

  
    public function getJazzEventsOnEventId($eventId)
    {
        $stmt = $this->connection->prepare("SELECT hall FROM Events
        JOIN Jazz ON Jazz.eventId = Jazz.eventId
        WHERE Jazz.eventId = :eventId AND Jazz.eventId = Events.eventId");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }

    public function getDanceEventsOnEventId($eventId)
    {
        $stmt = $this->connection->prepare("SELECT location FROM Events
        JOIN Dance AS DC ON DC.eventId = Events.eventId
        WHERE Events.eventId = :eventId AND Events.eventId = DC.eventId");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }

    public function getYummyEvent($userId, $date)
    {
        $stmt = $this->connection->prepare("SELECT SS.id, ET.eventId, ET.quantity FROM Users AS US
        JOIN ShoppingCart AS SS ON US.cartId = SS.id
        JOIN Events AS ET ON ET.eventId = ET.eventId
        WHERE US.userId = :userId AND category = 'Yummy' AND date = :date");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }
    public function getYummyEventsOnEventId($eventId)
    {
        $stmt = $this->connection->prepare("SELECT YY.restaurant, ET.date FROM Events AS ET
        JOIN Yummy AS YY ON YY.eventId = ET.eventId
        WHERE ET.eventId = :eventId AND ET.eventId = YY.eventId");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }

    public function getEventIdYummy($restaurant, $date)
    {
        $stmt = $this->connection->prepare("SELECT ET.eventId, ET.price, ET.quantity
        FROM Events AS ET
        JOIN Yummy AS YY ON YY.eventId = ET.eventId
        WHERE YY.restaurant = :restaurant AND ET.eventId = YY.eventId
        AND ET.date = :date");
        $stmt->bindParam(':restaurant', $restaurant);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;
    }

    public function updateQuantityOfItems($id, $quantityOrder, $subTotal)
    {
        $stmt = $this->connection->prepare("UPDATE ShoppingCartItems
        SET quantityOrder = :quantityOrder, subTotal = :subTotal
        WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':quantityOrder', $quantityOrder);
        $stmt->bindParam(':subTotal', $subTotal);
        $stmt->execute();
    }

    public function UpdateAmountTickets($eventId, $quantity)
    {
        $stmt = $this->connection->prepare("UPDATE Events SET quantity = :quantity WHERE eventId = :eventId;");
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }

   


    public function getEventById($eventId)
    {
        $stmt = $this->connection->prepare("SELECT eventId, name, category, date, price, quantity FROM Events WHERE eventId = :eventId");
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

    public function checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket){
        $stmt = $this->connection->prepare("SELECT * FROM ShoppingCartItems
        WHERE cartId = :cartId AND eventId = :eventId AND typeOfTicket = :typeOfTicket");
        $stmt->bindParam(':cartId', $cartId);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':typeOfTicket', $typeOfTicket['id']);
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

    
    
}