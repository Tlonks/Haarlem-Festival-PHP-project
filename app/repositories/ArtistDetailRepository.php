<?php
require_once __DIR__ . "/../models/danceArtistDetailPage.php";
require_once __DIR__ . "/../models/ArtistDetailPage.php";
require_once __DIR__ . "/repository.php";

class ArtistDetailRepository extends Repository
{

    public function getArtistDetail($name)
    {
        $stmt = $this->connection->prepare("SELECT * FROM `InformationPages` WHERE `title` = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        $artist = new artistsDetailPage();
        $artist->setTitle($result['title']);
        $artist->setHeadText($result['headText']);


        $firstImage = $result['firstImage'];
        $secondImage = $result['secondImage'];
        $thirdImage = $result['thirdImage'];

        $artist->setFirstImage($this->getImageBase64($firstImage));
        $artist->setSecondImage($this->getImageBase64($secondImage));
        $artist->setThirdImage($this->getImageBase64($thirdImage));

        return $artist;
    }

    public function getDanceArtistDetail($name)
    {
        $stmt = $this->connection->prepare("SELECT Artists.name, danceInformationPages.firstImage, danceInformationPages.secondImage, danceInformationPages.bodyText FROM Artists INNER JOIN danceInformationPages ON Artists.id = danceInformationPages.Artist WHERE `name` = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        $artist = new danceArtistsDetailPage();
        $artist->setName($result['name']);
        $artist->setBodyText($result['bodyText']);


        $firstImage = $result['firstImage'];
        $secondImage = $result['secondImage'];

        $artist->setFirstImage($this->getImageBase64($firstImage));
        $artist->setSecondImage($this->getImageBase64($secondImage));

        return $artist;
    }

    private function getImageBase64($imageData)
    {
        return 'data:image/png;base64,' . base64_encode($imageData);
    }

}