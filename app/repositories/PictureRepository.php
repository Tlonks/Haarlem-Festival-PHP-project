<?php
require_once __DIR__."/../models/user.php";
require_once __DIR__."/repository.php";

class PictureRepository extends Repository
{
    public function uploadNewPicture($userId,$picture)
    {
        $stmt = $this->connection->prepare("INSERT INTO Pictures (pictureId, picture, userId) VALUES(null, :Picture,:UserId) ");

        $stmt->bindParam(':UserId', $userId);
        $stmt->bindParam(':Picture', $picture);
        $stmt->execute();

    }

    public function getPicture($userId)
    {
        $stmt = $this->connection->prepare("SELECT picture FROM Pictures WHERE userId = :UserId");
        $stmt->bindParam(':UserId', $userId);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function updatePicture($userId,$picture)
    {
        $stmt = $this->connection->prepare("UPDATE Pictures SET picture = :Picture WHERE userId = :UserId");
        $stmt->bindParam(':UserId', $userId);
        $stmt->bindParam(':Picture', $picture);
        $stmt->execute();
    }

}