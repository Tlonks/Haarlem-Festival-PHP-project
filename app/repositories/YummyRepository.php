<?php
require_once __DIR__ . "/../models/YummyContentCards.php";
require_once __DIR__ . "/../models/YummyRestaurants.php";
require_once __DIR__ . "/../models/YummyEvent.php";
require_once __DIR__ . "/../models/IntroInformation.php";
require_once __DIR__ . "/repository.php";

class YummyRepository extends Repository
{
    public function getAllContentOfRestaurants()
    {
        $stmt = $this->connection->prepare("SELECT CC.id, title, image, page, stars, price, duration, typeOfFood, location FROM ContentCards AS CC JOIN YummyContentCards AS YC WHERE YC.contentCardId = CC.Id AND CC.page = 'Yummy';");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'YummyContentCards');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function addContentCards(YummyContentCards $restaurant)
    {
        if (!isset($restaurant->image)) {
            $stmt = $this->connection->prepare("INSERT INTO ContentCards
        (title, page) VALUES (:title, :page)");
            $stmt->bindParam(':title', $restaurant->title);
            $stmt->bindParam(':page', $restaurant->page);
            $stmt->execute();
        } else {
            $stmt = $this->connection->prepare("INSERT INTO ContentCards
        (title, page, image) VALUES (:title, :page, :image)");

            $stmt->bindParam(':title', $restaurant->title);
            $stmt->bindParam(':page', $restaurant->page);
            $stmt->bindParam(':image', $restaurant->image);
            $stmt->execute();
        }
        $restaurant->contentCardId = $this->connection->lastInsertId();

        $stmt = $this->connection->prepare("INSERT INTO YummyContentCards
        (stars, price, duration, typeOfFood, location, contentCardId) VALUES
        (:stars, :price, :duration, :typeOfFood, :location, :contentCardId)");

        $stmt->bindParam(':stars', $restaurant->stars);
        $stmt->bindParam(':price', $restaurant->price);
        $stmt->bindParam(':duration', $restaurant->duration);
        $stmt->bindParam(':typeOfFood', $restaurant->typeOfFood);
        $stmt->bindParam(':location', $restaurant->location);
        $stmt->bindParam(':contentCardId', $restaurant->contentCardId);
        $stmt->execute();
    }

    public function updateContentCards($stars, $price, $duration, $typeOfFood, $location, $title, $id)
    {
        $stmt = $this->connection->prepare("UPDATE ContentCards AS CC JOIN YummyContentCards AS YC
        SET title = :title, stars = :stars, price = :price, duration = :duration, typeOfFood = :typeOfFood,
        location = :location WHERE YC.contentCardId = CC.id AND CC.id = :id ");

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':stars', $stars);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':typeOfFood', $typeOfFood);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteContentCards($id)
    {
        $stmt = $this->connection->prepare("DELETE ContentCards, YummyContentCards FROM ContentCards, YummyContentCards
        WHERE YummyContentCards.contentCardId = ContentCards.id AND ContentCards.id = :id ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getMoreInformationOfRestaurants($restaurantTitle)
    {
        $stmt = $this->connection->prepare("SELECT * FROM InformationPages AS IP
        JOIN YummyInformationPage AS YU WHERE IP.id = YU.informationPageId AND IP.title = :restaurantTitle");
        $stmt->bindParam(':restaurantTitle', $restaurantTitle);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'YummyRestaurants');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllReservations()
    {
        $stmt = $this->connection->prepare("SELECT * FROM Reservations");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Reservations');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getLastIdOfShoppingCartItems()
    {
        $stmt = $this->connection->query("SELECT MAX(id) as last_id FROM ShoppingCartItems");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $last_id = $row['last_id'];

        $stmt = $this->connection->prepare("SELECT * FROM ShoppingCartItems WHERE id = :id");
        $stmt->bindParam(":id", $last_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result[0]['id'];
    }

    public function setReservation($restaurant, $date, $specialRequests, $amountOfPeople)
    {
        $cartItemId = $this->getLastIdOfShoppingCartItems();
        $stmt = $this->connection->prepare("INSERT INTO Reservations
        (date, specialRequests, amountOfPeople, restaurant, cartItemId) VALUES
        (:date, :specialRequests, :amountOfPeople, :restaurant, :cartItemId)
        ");

        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':specialRequests', $specialRequests);
        $stmt->bindParam(':amountOfPeople', $amountOfPeople);
        $stmt->bindParam(':restaurant', $restaurant);
        $stmt->bindParam(':cartItemId', $cartItemId);
        $stmt->execute();
    }

    public function updateQuantityOfReservation($cartItemId, $amountOfPeople)
    {
        $stmt = $this->connection->prepare("UPDATE Reservations AS RS
        JOIN ShoppingCartItems AS SI ON SI.id = RS.cartItemId
        SET amountOfPeople = :amountOfPeople
        WHERE RS.cartItemId = :cartItemId");
        $stmt->bindParam(':cartItemId', $cartItemId);
        $stmt->bindParam(':amountOfPeople', $amountOfPeople);
        $stmt->execute();
    }

    public function updateSeats($seats, $restaurant, $date)
    {
        $stmt = $this->connection->prepare("UPDATE Yummy AS YY JOIN Events AS ET ON YY.eventId = ET.eventId
        SET ET.quantity = :seats WHERE ET.date = :date AND YY.restaurant = :restaurant");

        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':restaurant', $restaurant);
        $stmt->bindParam(':seats', $seats);
        $stmt->execute();
    }

    public function reservationCanceled($cartItemId)
    {
        $stmt = $this->connection->prepare("UPDATE Reservations AS RS
        JOIN ShoppingCartItems AS SI ON SI.id = RS.cartItemId
        SET RS.canceled = 'true', cartItemId = NULL
        WHERE RS.cartItemId = :cartItemId");

        $stmt->bindParam(':cartItemId', $cartItemId);

        $stmt->execute();
    }

    public function getEvent($restaurant)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Yummy AS YY JOIN Events AS ET ON YY.eventId = ET.eventId
        WHERE ET.category = 'Yummy' AND YY.restaurant = :restaurant GROUP BY DATE(date)");

        $stmt->bindParam(':restaurant', $restaurant);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'YummyEvent');
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getContentCardById(mixed $id)
    {
        $stmt = $this->connection->prepare("SELECT CC.id, title, image, page, stars, price, duration, typeOfFood, location FROM ContentCards AS CC
        JOIN YummyContentCards AS YC ON CC.id = YC.contentCardId
        WHERE CC.id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $card = new YummyContentCards();
        $result = $stmt->fetch();

        $card->id = $result['id'];
        $card->title = $result['title'];
        $card->page = $result['page'];
        $card->stars = $result['stars'];
        $card->price = $result['price'];
        $card->duration = $result['duration'];
        $card->typeOfFood = $result['typeOfFood'];
        $card->location = $result['location'];

        return $card;
    }

    public function updateRestaurant(YummyContentCards $restaurant)
    {
        $stmt = $this->connection->prepare("UPDATE ContentCards AS CC JOIN YummyContentCards AS YC
        SET image = :image, title = :title, stars = :stars, price = :price, duration = :duration, typeOfFood = :typeOfFood,
        location = :location WHERE YC.contentCardId = CC.id AND CC.id = :id ");

        $stmt->bindParam(':image', $restaurant->image);
        $stmt->bindParam(':title', $restaurant->title);
        $stmt->bindParam(':stars', $restaurant->stars);
        $stmt->bindParam(':price', $restaurant->price);
        $stmt->bindParam(':duration', $restaurant->duration);
        $stmt->bindParam(':typeOfFood', $restaurant->typeOfFood);
        $stmt->bindParam(':location', $restaurant->location);
        $stmt->bindParam(':id', $restaurant->id);
        $stmt->execute();
    }
}
