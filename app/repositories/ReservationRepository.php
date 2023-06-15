<?php
require_once __DIR__ . "/repository.php";

class ReservationRepository extends Repository
{
    public function getAllReservations()
    {
        $stmt = $this->connection->prepare("SELECT * FROM Reservations");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateReservation(mixed $id, mixed $isCanceled)
    {
        $stmt = $this->connection->prepare("UPDATE Reservations SET Canceled = :isCanceled WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":isCanceled", $isCanceled);
        $stmt->execute();
    }

    public function setReservationNull($cartItemId){

        $stmt = $this->connection->prepare("UPDATE Reservations AS RS
        JOIN ShoppingCartItems AS SI ON SI.id = RS.cartItemId
        SET RS.cartItemId = NULL
        WHERE RS.cartItemId = :cartItemId");

        $stmt->bindParam(':cartItemId', $cartItemId);

        $stmt->execute();
    }

    public function reservationCanceled($cartItemId)
    {
        $stmt = $this->connection->prepare("UPDATE Reservations AS RS
        JOIN ShoppingCartItems AS SI ON SI.id = RS.cartItemId
        SET RS.canceled = 'true', cartItemId = NULL
        WHERE RS.cartItemId = :cartItemId");

        $stmt->bindParam(':cartItemId', $cartItemId);

        $stmt->execute();
    }

    public function getLastIdOfShoppingCartItems()
    {
        $stmt = $this->connection->query("SELECT MAX(id) as last_id FROM ShoppingCartItems");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $last_id = $row['last_id'];

        $stmt = $this->connection->prepare("SELECT * FROM ShoppingCartItems WHERE id = :id");
        $stmt->bindParam(":id", $last_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result[0]['id'];
    }

    public function setReservation($restaurant, $date, $specialRequests, $amountOfPeople)
    {
        $cartItemId = $this->getLastIdOfShoppingCartItems();
        $stmt = $this->connection->prepare("INSERT INTO Reservations
        (date, specialRequests, amountOfPeople, restaurant, cartItemId) VALUES
        (:date, :specialRequests, :amountOfPeople, :restaurant, :cartItemId)
        ");

        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':specialRequests', $specialRequests);
        $stmt->bindParam(':amountOfPeople', $amountOfPeople);
        $stmt->bindParam(':restaurant', $restaurant);
        $stmt->bindParam(':cartItemId', $cartItemId);
        $stmt->execute();
    }

    public function updateQuantityOfReservation($cartItemId, $amountOfPeople)
    {
        $stmt = $this->connection->prepare("UPDATE Reservations AS RS
        JOIN ShoppingCartItems AS SI ON SI.id = RS.cartItemId
        SET amountOfPeople = :amountOfPeople
        WHERE RS.cartItemId = :cartItemId");
        $stmt->bindParam(':cartItemId', $cartItemId);
        $stmt->bindParam(':amountOfPeople', $amountOfPeople);
        $stmt->execute();
    }

    public function updateSeats($seats, $restaurant, $date)
    {
        $stmt = $this->connection->prepare("UPDATE Yummy AS YY JOIN Events AS ET ON YY.eventId = ET.eventId
        SET ET.quantity = :seats WHERE ET.date = :date AND YY.restaurant = :restaurant");

        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':restaurant', $restaurant);
        $stmt->bindParam(':seats', $seats);
        $stmt->execute();
    }

 
}