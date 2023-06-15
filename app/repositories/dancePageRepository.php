<?php
require_once __DIR__ . "/repository.php";

class dancePageRepository extends Repository
{
    public function getAllVenues()
    {
        $stmt = $this->connection->prepare("SELECT * FROM `Venues`");
        $stmt->execute();

        return $stmt->fetchAll();
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

    public function getEventbyArtist($name)
    {
        $stmt = $this->connection->prepare("SELECT DA.location, DA.session, EV.date, EV.price FROM Dance as DA JOIN Events as EV ON DA.eventId = EV.eventId WHERE DA.artist = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'danceEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

}