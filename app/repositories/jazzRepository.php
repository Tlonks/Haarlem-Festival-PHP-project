<?php
require_once __DIR__ . "/../models/jazzEvent.php";

require_once __DIR__ . "/repository.php";

class JazzRepository extends Repository
{

    public function getAllEventsByArtist($artist)
    {
        $stmt = $this->connection->prepare("SELECT EV.date, JZ.endTime, JZ.location, JZ.hall, EV.price FROM Jazz AS JZ JOIN Events AS EV ON JZ.eventId = EV.eventId JOIN Artists AS A ON JZ.artistId = A.id WHERE A.name = :artist");
        $stmt->bindParam(':artist', $artist);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'jazzEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllJazzEventsByDate($date)
    {
        $stmt = $this->connection->prepare("SELECT a.name as artist, j.hall, DATE_FORMAT(e.date, '%d-%m-%Y %H:%i') as date, e.price, j.location, j.endTime 
        FROM Jazz j 
        JOIN Events e ON j.eventId = e.eventId 
        JOIN Artists a ON j.artistId = a.id 
        WHERE DATE(`date`) = DATE(:date);;
        ");
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'jazzEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

   public function getEventbyDate($date, $name)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Events WHERE DATE(`date`) = DATE(:date) AND name = :name");
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }


    

}