<?php
require_once __DIR__ . "/../models/HistoryInformationPage.php";
require_once __DIR__ . "/../models/contentCards.php";
require_once __DIR__ . "/../models/historyEvent.php";


require_once __DIR__ . "/repository.php";

class HistoryRepository extends Repository
{

    public function getAllContentOfSights()
    {
        $stmt = $this->connection->prepare("SELECT id, title, information, image, page FROM ContentCards WHERE page = 'History';");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'contentCards');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getMoreInformationOfSight($sightTitle)
    {
        $stmt = $this->connection->prepare("SELECT * FROM HistoryInformationPage AS HI JOIN InformationPages AS IP WHERE HI.IdInformationPage = IP.id && IP.title = :SightTitle");
        $stmt->bindParam(':SightTitle', $sightTitle);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'HistoryInformationPage');
        $result = $stmt->fetchAll();

        return $result;
    }
    //om alle evenementen van een datum te krijgen
    public function getAllEventsByDate($date)
    {
        $stmt = $this->connection->prepare("SELECT * FROM History as HI JOIN Events as EV ON HI.eventId = EV.eventId WHERE DATE(`date`) = DATE(:date)");
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'historyEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getEventById($historyEventId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM History as HI JOIN Events as EV ON HI.eventId = EV.eventId WHERE HI.eventId = :historyEventId");
        $stmt->bindParam(':historyEventId', $historyEventId);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'historyEvent');
        $result = $stmt->fetchAll();

        return $result[0];
    }

    public function UpdateAvailableTickets($amountTotal, $eventId)
    {
        $stmt = $this->connection->prepare("UPDATE Events SET quantity = :amountTickets WHERE eventId = :eventId;");
        $stmt->bindParam(':amountTickets', $amountTotal);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->execute();
    }

    public function getTimeTableEventById($eventId)
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

    public function addSight(ContentCards $sight)
    {
        $stmt = $this->connection->prepare("INSERT INTO ContentCards (title, information, image, page) VALUES (:title, :information, :image, :page)");
        $stmt->bindParam(':title', $sight->title);
        $stmt->bindParam(':information', $sight->information);
        if (!isset($sight->image)) {
            $stmt->bindValue(':image', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':image', $sight->image);
        }
        $stmt->bindParam(':page', $sight->page);
        $stmt->execute();
    }

    public function getSightById(mixed $id)
    {
        /*$stmt = $this->connection->prepare("SELECT id, title, information, image FROM ContentCards WHERE id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();*/

        $stmt = $this->connection->prepare("SELECT id, title, information, image FROM ContentCards WHERE id = :id;");
        $stmt->execute([
            "id" => $id
        ]);

        $result = $stmt->fetch();

        $card = new ContentCards();
        $card->title = $result['title'];
        $card->id = $result['id'];
        $card->information = $result['information'];

        return $card;
    }

    public function deleteSight(mixed $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM ContentCards WHERE id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function updateSight(ContentCards $sight)
    {
        $stmt = $this->connection->prepare("UPDATE ContentCards SET title = :title, information = :information, image = :image WHERE id = :id;");
        $stmt->bindParam(':title', $sight->title);
        $stmt->bindParam(':information', $sight->information);
        $stmt->bindParam(':image', $sight->image);
        $stmt->bindParam(':id', $sight->id);
        $stmt->execute();
    }
}
