<?php
require_once __DIR__."/repository.php";
class TicketRepository extends Repository
{
    public function newTicket($orderId,$userId,$code,$eventCount,$orderItemId){
        $stmt = $this->connection->prepare("INSERT INTO Ticket (ticketId,orderId,orderItemId, userId, qrCode,isScanned,eventCount) VALUES (null,:OrderId,:OrderItemId, :UserId, :QrCode, 0, :EventCount)");
        $stmt->bindParam(':OrderId', $orderId);
        $stmt->bindParam(':UserId', $userId);
        $stmt->bindParam(':QrCode', $code);
        $stmt->bindParam(':EventCount', $eventCount);
        $stmt->bindParam(':OrderItemId', $orderItemId);
        $stmt->execute();
    }
    public function updateQR($orderId, $qrCode)
    {
        $stmt = $this->connection->prepare("UPDATE Ticket SET qrCode = :QrCode WHERE orderId = :OrderId");
        $stmt->bindParam(':QrCode', $qrCode);
        $stmt->bindParam(':OrderId', $orderId);
        $stmt->execute();
    }
    //Past de status aan van de tickets maar aleen van tickets die nog niet zijn gebruikt
    public function scanTicket($key)
    {
        $stmt = $this->connection->prepare("UPDATE Ticket SET eventCount = eventCount - 1 WHERE qrCode = :QrCode AND eventCount > 0");
        $stmt->bindParam(':QrCode', $key);
        $stmt->execute();
        
    }
    //Checken of de ticket bestaat en of de ticket nog niet is gebruikt
    public function checkTicket($key){
        $stmt = $this->connection->prepare("SELECT * FROM Ticket WHERE qrCode = :QrCode AND eventCount = 0");
        $stmt->bindParam(':QrCode', $key);
        $stmt->execute();
        $result = $stmt->fetch();
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
}