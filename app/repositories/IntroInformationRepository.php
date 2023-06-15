<?php
require_once __DIR__ . "/repository.php";
require_once __DIR__ . "/../models/IntroInformation.php";

class IntroInformationRepository extends Repository
{
    public function getAllPages()
    {
        $statement = $this->connection->prepare('
            SELECT * FROM IntroInformation;');
        $statement->execute();
        $pages = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $pages;
    }

    public function getPageById($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM IntroInformation WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'IntroInformation');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function addPage($title, $category)
    {
        $statement = $this->connection->prepare('
            INSERT INTO `IntroInformation`(`htmlData`, `category`, `title`) VALUES (:htmlData, :category, :title)
        ');
        $statement->execute([
            ':htmlData' => '<h1>New Page</h1>',
            ':category' => $category,
            ':title' => $title
        ]);
    }

    public function updatePage($id, $htmlData)
    {
        $statement = $this->connection->prepare('
            UPDATE `IntroInformation` SET `htmlData`=:htmlData WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':htmlData', $htmlData, PDO::PARAM_STR);

        $statement->execute();
    }

    public function deletePage($id)
    {
        $statement = $this->connection->prepare('DELETE FROM IntroInformation WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function getIntroInformation($page){
        $stmt = $this->connection->prepare("SELECT * FROM IntroInformation WHERE category = :page");
        $stmt->bindParam(':page', $page);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'IntroInformation');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getAllExtraPages()
    {
        $stmt = $this->connection->prepare("SELECT * FROM IntroInformation WHERE id > 6");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'IntroInformation');
        $result = $stmt->fetchAll();
        return $result;
    }

}