<?php
require_once __DIR__ . "/../repositories/YummyRepository.php";

class YummyService
{
    private $yummyRepository;
    public function __construct()
    {
        $this->yummyRepository = new YummyRepository();
    }

    public function getMoreInformationOfRestaurants($restaurantInformation)
    {
        return $this->yummyRepository->getMoreInformationOfRestaurants($restaurantInformation);
    }
    public function getEvent($restaurantName)
    {
        return $this->yummyRepository->getEvent($restaurantName);
    }
    public function updateSeats($seats, $restaurantName, $dateTime)
    {
        return $this->yummyRepository->updateSeats($seats, $restaurantName, $dateTime);
    }

    public function setReservation($restaurantName, $dateTime, $specialRequests, $amountOfPeople)
    {
        return $this->yummyRepository->setReservation($restaurantName, $dateTime, $specialRequests, $amountOfPeople);
    }
    public function getAllContentOfRestaurants()
    {
        return $this->yummyRepository->getAllContentOfRestaurants();
    }
    public function reservationCanceled($cartItemId)
    {
        return $this->yummyRepository->reservationCanceled($cartItemId);
    }
    public function updateQuantityOfReservation($cartItemId, $amountOfPeople)
    {
        $this->yummyRepository->updateQuantityOfReservation($cartItemId, $amountOfPeople);
    }

    public function addRestaurant(YummyContentCards $restaurant)
    {
        $this->yummyRepository->addContentCards($restaurant);
    }

    public function getContentCardById(mixed $id)
    {
        return $this->yummyRepository->getContentCardById($id);
    }

    public function deleteRestaurant(mixed $id)
    {
        $this->yummyRepository->deleteContentCards($id);
    }

    public function updateRestaurant(YummyContentCards $restaurant)
    {
        $this->yummyRepository->updateRestaurant($restaurant);
    }
}
