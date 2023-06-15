<?php
require_once __DIR__ . "/../models/venue.php";
require_once __DIR__ . "/repository.php";

class VenueRepository extends Repository
{
    public function getAllVenueEvents()
    {
        $stmt = $this->connection->prepare("SELECT id, name, description, location, picture FROM Venues;");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function addVenue(Venue $venue)
    {
        if (isset($venue->picture)) {
            $stmt = $this->connection->prepare("INSERT INTO Venues (name, description, location, picture) VALUES (:name, :description, :location, :picture);");
            $stmt->execute([
                "name" => $venue->name,
                "description" => $venue->description,
                "location" => $venue->location,
                "picture" => $venue->picture
            ]);
        } else {
            $stmt = $this->connection->prepare("INSERT INTO Venues (name, description, location) VALUES (:name, :description, :location);");
            $stmt->execute([
                "name" => $venue->name,
                "description" => $venue->description,
                "location" => $venue->location
            ]);
        }
    }

    public function deleteVenue(mixed $param)
    {
        $stmt = $this->connection->prepare("DELETE FROM Venues WHERE id = :venueId");
        $stmt->execute([
            "venueId" => $param
        ]);
    }

    public function updateVenue(Venue $venue)
    {
        $stmt = $this->connection->prepare("UPDATE Venues SET name = :name, description = :description, location = :location, picture = :picture WHERE id = :venueId");
        $stmt->execute([
            "name" => $venue->name,
            "description" => $venue->description,
            "location" => $venue->location,
            "picture" => $venue->picture,
            "venueId" => $venue->id
        ]);
    }


    public function getVenueById(mixed $id)
    {
        require_once __DIR__ . "/../models/venue.php";

        $stmt = $this->connection->prepare("SELECT name, description, location, picture FROM Venues WHERE id = :venueId");
        $stmt->execute([
            "venueId" => $id
        ]);

        $res = $stmt->fetch();

        $venue = new venue();
        $venue->name = $res["name"];
        $venue->description = $res["description"];
        $venue->location = $res["location"];


        return $venue;
    }
}