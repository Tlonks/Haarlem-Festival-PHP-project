<?php
require_once __DIR__ . "/../models/startingLocations.php";
require_once __DIR__ . "/../models/contentCards.php";
require_once __DIR__ . "/../models/historyEvent.php";
require_once __DIR__ . "/../models/danceEvent.php";
require_once __DIR__ . "/repository.php";

class MainPageRepository extends Repository
{
    //get all the content cards from the database 
    public function getAllContentCards($page)
    {
        $stmt = $this->connection->prepare("SELECT * FROM ContentCards WHERE page = :page");
        $stmt->bindParam(':page', $page);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'contentCards');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getAllStartingLocations()
    {
        $stmt = $this->connection->prepare("SELECT * FROM StartingLocations");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'startingLocations');
        $result = $stmt->fetchAll();
        return $result;
    }   
}
