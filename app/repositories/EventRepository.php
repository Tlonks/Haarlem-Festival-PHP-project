<?php

require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../models/danceEvent.php";
require_once __DIR__ . "/../models/historyEvent.php";
require_once __DIR__ . "/repository.php";

class EventRepository extends Repository
{
    //get all events

    public function getAllEvents()
    {
        $stmt = $this->connection->prepare("SELECT eventId, name, category, date, price, quantity FROM Events");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getAllHistoryEvents()
    {
        $stmt = $this->connection->prepare("SELECT SE.eventId, name, date, price, quantity, location, guide, language, familyPrice FROM `Events` as SE JOIN History as EV WHERE EV.eventId = SE.eventId AND SE.category = 'History';");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getAllDanceEvents()
    {
        $stmt = $this->connection->prepare("SELECT SE.eventId, name, date, price, quantity, location, artist, session FROM `Events` as SE JOIN Dance as EV WHERE EV.eventId = SE.eventId AND SE.category = 'Dance';");
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllJazzEvents()
    {
        $stmt = $this->connection->prepare("SELECT SE.eventId, SE.location, EV.date, SE.hall, EV.price, SE.infoId, SE.endTime, EV.name, EV.quantity, SE.hall, AR.name AS artist FROM Events AS EV JOIN Jazz AS SE ON EV.eventId = SE.eventId JOIN Artists AS AR ON SE.artistId = AR.id WHERE EV.category = 'Jazz'");

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllYummyEvents()
    {
        $stmt = $this->connection->prepare("SELECT SE.eventId, name, date, SE.price as reservationprice, quantity, duration, restaurant, EV.price FROM `Events` as SE JOIN Yummy as EV WHERE EV.eventId = SE.eventId AND SE.category = 'Yummy';");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //add events

    public function addTypeOfEvent($event, $typeOfEvent)
    {
        $stmt = $this->connection->prepare("INSERT INTO Events (`eventId`, `name`, `category`, `date`, `price`, `quantity`) VALUES (NULL, :name, :category, :date, :price, :quantity);");
        $stmt->bindParam("name", $event->name);
        $stmt->bindParam("category", $typeOfEvent);
        $stmt->bindParam("date", $event->date);
        $stmt->bindParam("price", $event->price);
        $stmt->bindParam("quantity", $event->quantity);
        $stmt->execute();

        //get last inserted id
        $lastId = $this->latestId();

        switch (strtolower($typeOfEvent)) {
            case "dance":
                $this->addDanceEventInfo($event, $lastId);
                break;
            case "history":
                $this->addHistoryEventInfo($event, $lastId);
                break;
            case "jazz":
                $this->addJazzEventInfo($event, $lastId);
                break;
            case "yummy":
                $this->addYummyEventInfo($event, $lastId);
                break;
            default:
                break;
        }
    }

    private function latestId()
    {
        $stmt = $this->connection->prepare("SELECT MAX(eventId) FROM Events");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result[0];
    }

    private function addDanceEventInfo($event, $lastId)
    {
        $stmt = $this->connection->prepare("INSERT INTO Dance (`location`, `artist`, `session`, `eventId`) VALUES (:location, :artist, :sessi, :eventId);");
        $stmt->bindParam("artist", $event->getArtist());
        $stmt->bindParam("sessi", $event->getSession());
        $stmt->bindParam("location", $event->getLocation());
        $stmt->bindParam("eventId", $lastId);
        $stmt->execute();
    }

    private function addHistoryEventInfo($event, $lastId)
    {
        $stmt = $this->connection->prepare("INSERT INTO History (location, guide, language, familyprice, eventId) 
        VALUES (:location, :guide, :language, :familyPrice, :eventId);");
        $stmt->execute([
            "guide" => $event->guide,
            "language" => $event->language,
            "location" => $event->location,
            "familyPrice" => $event->familyPrice,
            "eventId" => $lastId
        ]);
    }

    private function addJazzEventInfo($event, $lastId)
    {
        $stmt = $this->connection->prepare("INSERT INTO Jazz (location, hall, endTime, artistId, eventId) 
        VALUES (:location, :hall, :endTime, :artistId, :eventId);");
        $stmt->execute([
            "location" => $event->location,
            "hall" => $event->hall,
            "endTime" => $event->endTime,
            "artistId" => $event->artistId,
            "eventId" => $lastId
        ]);
    }

    private function addYummyEventInfo($event, mixed $lastId)
    {
        $stmt = $this->connection->prepare("INSERT INTO Yummy (duration, price, restaurant, eventId) VALUES (:duration, :price, :restaurant, :eventId);");
        $stmt->execute([
            "duration" => $event->duration,
            "price" => $event->reservationPrice,
            "restaurant" => $event->restaurant,
            "eventId" => $lastId
        ]);
    }

    //Get events by id

    public function getDanceEventById(mixed $id)
    {
        $stmt = $this->connection->prepare("SELECT SE.eventId, name, date, price, quantity, location, artist, session FROM Events AS EV JOIN Dance AS SE WHERE EV.eventId = SE.eventId AND EV.eventId = :eventId;");
        $stmt->execute([
            "eventId" => $id
        ]);

        return $stmt->fetch();

    }

    public function getHistoryEventById(mixed $id)
    {
        $stmt = $this->connection->prepare("SELECT SE.eventId, name, date, price, quantity, location, guide, language, familyprice FROM Events AS EV JOIN History AS SE WHERE EV.eventId = SE.eventId AND EV.eventId = :eventId;");
        $stmt->execute([
            "eventId" => $id
        ]);

        return $stmt->fetch();
    }

    public function getJazzEventById(mixed $id)
    {
        $stmt = $this->connection->prepare("SELECT SE.eventId, name, date, price, quantity, location, hall, endTime, artistId FROM Events AS EV JOIN Jazz AS SE WHERE EV.eventId = SE.eventId AND EV.eventId = :eventId;");
        $stmt->execute([
            "eventId" => $id
        ]);

        return $stmt->fetch();
    }

    public function getYummyEventById(mixed $id)
    {
        $stmt = $this->connection->prepare("SELECT SE.eventId, name, date, SE.price as rprice, quantity, duration, restaurant, EV.price FROM `Events` as SE JOIN Yummy as EV WHERE EV.eventId = SE.eventId AND SE.eventId = :eventId;");
        $stmt->execute([
            "eventId" => $id
        ]);

        return $stmt->fetch();
    }

    //Update events

    public function updateDanceEvent(mixed $id, mixed $name, mixed $date, mixed $price, mixed $quantity, mixed $location, mixed $artist, mixed $session)
    {
        $stmt = $this->connection->prepare("UPDATE Events SET name = :name, date = :date, price = :price, quantity = :quantity WHERE eventId = :eventId;");
        $stmt->execute([
            "name" => $name,
            "date" => $date,
            "price" => $price,
            "quantity" => $quantity,
            "eventId" => $id
        ]);

        $stmt = $this->connection->prepare("UPDATE Dance SET location = :location, artist = :artist, session = :session WHERE eventId = :eventId;");
        $stmt->execute([
            "location" => $location,
            "artist" => $artist,
            "session" => $session,
            "eventId" => $id
        ]);
    }

    public function updateHistoryEvent(HistoryEvent $event)
    {
        $stmt = $this->connection->prepare("UPDATE Events SET name = :name, date = :date, price = :price, quantity = :quantity WHERE eventId = :eventId;");
        $stmt->execute([
            "name" => $event->name,
            "date" => $event->date,
            "price" => $event->price,
            "quantity" => $event->quantity,
            "eventId" => $event->eventId
        ]);

        $stmt = $this->connection->prepare("UPDATE History SET location = :location, guide = :guide, language = :language, familyprice = :familyPrice WHERE eventId = :eventId;");
        $stmt->execute([
            "location" => $event->location,
            "guide" => $event->guide,
            "language" => $event->language,
            "familyPrice" => $event->familyPrice,
            "eventId" => $event->eventId
        ]);
    }

    public function updateJazzEvent(mixed $data)
    {
        $stmt = $this->connection->prepare("UPDATE Events SET name = :name, date = :date, price = :price, quantity = :quantity WHERE eventId = :eventId;");
        $stmt->execute([
            "name" => $data['name'],
            "date" => $data['date'],
            "price" => $data['price'],
            "quantity" => $data['quantity'],
            "eventId" => $data['eventId']
        ]);

        $stmt = $this->connection->prepare("UPDATE Jazz SET location = :location, hall = :hall, endTime = :endTime, artistId = :artistId WHERE eventId = :eventId;");
        $stmt->execute([
            "location" => $data['location'],
            "hall" => $data['hall'],
            "endTime" => $data['endTime'],
            "artistId" => $data['artist'],
            "eventId" => $data['eventId']
        ]);
    }

    public function updateYummyEvent(mixed $data, $rprice)
    {
        $stmt = $this->connection->prepare("UPDATE Events SET name = :name, date = :date, price = :price, quantity = :quantity WHERE eventId = :eventId;");
        $stmt->execute([
            "name" => $data['name'],
            "date" => $data['date'],
            "price" => $data['price'],
            "quantity" => $data['quantity'],
            "eventId" => $data['eventId']
        ]);

        $stmt = $this->connection->prepare("UPDATE Yummy SET duration = :duration, price = :price, restaurant = :restaurant WHERE eventId = :eventId;");
        $stmt->execute([
            "duration" => $data['duration'],
            "price" => $rprice,
            "restaurant" => $data['restaurant'],
            "eventId" => $data['eventId']
        ]);
    }

    //delete events

    public function deleteRow($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM Events WHERE eventId = :eventId");
        $stmt->execute([
            "eventId" => $id
        ]);
    }

    public function deleteDanceEvent(mixed $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM Dance WHERE eventId = :eventId");
        $stmt->execute([
            "eventId" => $id
        ]);
        $this->deleteRow($id);
    }

    public function deleteHistoryEvent(mixed $eventId)
    {
        $stmt = $this->connection->prepare("DELETE FROM History WHERE eventId = :eventId");
        $stmt->execute([
            "eventId" => $eventId
        ]);
        $this->deleteRow($eventId);
    }

    public function deleteJazzEvent(mixed $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM Jazz WHERE eventId = :eventId");
        $stmt->execute([
            "eventId" => $id
        ]);
        $this->deleteRow($id);
    }

    public function deleteYummyEvent(mixed $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM Yummy WHERE eventId = :eventId");
        $stmt->execute([
            "eventId" => $id
        ]);
        $this->deleteRow($id);
    }
}