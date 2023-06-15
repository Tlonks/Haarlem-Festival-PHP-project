<?php
require_once __DIR__ . "/../models/artists.php";
require_once __DIR__ . "/repository.php";

class ArtistRepository extends Repository
{

    public function getArtistByName($name)
    {
        $stmt = $this->connection->prepare("SELECT * FROM `Artists` WHERE `name` = ?");
        $stmt->execute([$name]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        $artist = new artists();
        $artist->setName($result['name']);

        // Read the longblob data and encode it in base64 format
        $picture = base64_encode($result['picture']);
        $artist->setPicture($picture);

        return $artist;
    }

    public function getAllArtists()
    {
        $stmt = $this->connection->prepare("SELECT id, name, picture FROM `Artists`");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function addArtist(artists $artist)
    {
        $stmt = $this->connection->prepare("INSERT INTO `Artists` (`name`, `picture`) VALUES (:name, :picture)");
        $stmt->execute([
            'name' => $artist->getName(),
            'picture' => $artist->getPicture()
        ]);
    }

    public function getArtistById(mixed $id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM `Artists` WHERE `id` = ?");
        $stmt->execute([$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        $artist = new artists();
        $artist->setName($result['name']);

        // Read the longblob data and encode it in base64 format
        $picture = base64_encode($result['picture']);
        $artist->setPicture($picture);

        return $artist;
    }

    public function updateArtist(artists $artist)
    {
        $stmt = $this->connection->prepare("UPDATE `Artists` SET `name` = :name, `picture` = :picture WHERE `id` = :id");
        $stmt->execute([
            'name' => $artist->getName(),
            'picture' => $artist->getPicture(),
            'id' => $artist->getId()
        ]);
    }

    public function deleteArtist(mixed $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM `Artists` WHERE `id` = :id");
        $stmt->execute([
            'id' => $id
        ]);
    }

    public function getAllAppearancesOfArtist($artist)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Dance AS DA JOIN Events AS EV ON DA.eventId = EV.eventId  WHERE `artist` = :name");
        $stmt->bindParam(':name', $artist);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'danceEvent');

        return $stmt->fetchAll();
    }

}