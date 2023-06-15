<?php
require_once __DIR__."/../models/MainTeylerContent.php";
require_once __DIR__."/../models/MainTeylerPicture.php";
require_once __DIR__."/repository.php";

class MainTeylersRepository extends Repository
{

    public function getAllContent()
    {
        $stmt = $this->connection->prepare("SELECT * FROM MainTeylersPage");
        $stmt->execute();
        
        $stmt->setFetchMode(PDO::FETCH_CLASS,'MainTeylerContent');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getHeaderPicture()
    {
        $stmt = $this->connection->prepare("SELECT * FROM MainTeylerPicture");
        $stmt->execute();
        
        $stmt->setFetchMode(PDO::FETCH_CLASS,'MainTeylerPicture');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function editHeader($header)
    {
        $stmt = $this->connection->prepare("UPDATE MainTeylersPage SET text = :header WHERE name = 'Header'");
        $stmt->bindParam(":header",$header);
        $stmt->execute();
    }

    public function editHeaderText($headerText)
    {
        $stmt = $this->connection->prepare("UPDATE MainTeylersPage SET text = :headerText WHERE name = 'HeaderText'");
        $stmt->bindParam(":headerText",$headerText);
        $stmt->execute();
    }

    public function editMainText($mainText)
    {
        $stmt = $this->connection->prepare("UPDATE MainTeylersPage SET text = :mainText WHERE name = 'MainText'");
        $stmt->bindParam(":mainText",$mainText);
        $stmt->execute();
    }

    public function editHeaderPicture($headerPicture)
    {
        $stmt = $this->connection->prepare("UPDATE MainTeylerPicture SET picture = :headerPicture WHERE name = 'Header'");
        $stmt->bindParam(":headerPicture",$headerPicture);
        $stmt->execute();
    }

    
}