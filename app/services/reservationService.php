<?php
require_once __DIR__."/../repositories/ReservationRepository.php";
class reservationService
{
    private $repo; 

    public function __construct()
    {
        $this->repo = new ReservationRepository();
    }
    public function getAllReservations(){
        return $this->repo->getAllReservations();
    }
   
    public function updateReservation(mixed $id, mixed $isCanceled)
    {
        $this->repo->updateReservation($id, $isCanceled);
    }

    public function setReservationNull($cartITemId)
    {
        return $this->repo->setReservationNull($cartITemId);
    }

    public function reservationCanceled($cartItemId)
    {
        return $this->repo->reservationCanceled($cartItemId);
    }
    public function setReservation($restaurantName, $dateTime, $specialRequests, $amountOfPeople)
    {
        return $this->repo->setReservation($restaurantName, $dateTime, $specialRequests, $amountOfPeople);
    }
    public function updateQuantityOfReservation($cartItemId, $amountOfPeople)
    {
        $this->repo->updateQuantityOfReservation($cartItemId, $amountOfPeople);
    }
    public function updateSeats($seats, $restaurantName, $dateTime)
    {
        return $this->repo->updateSeats($seats, $restaurantName, $dateTime);
    }

}