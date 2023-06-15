<?php
require_once __DIR__ . "/../repositories/timeTableRepository.php";

class TimeTableService
{
    private $timeTableRepository;
    public function __construct()
    {
        $this->timeTableRepository = new TimeTableRepository();
    }

    public function getDateOfAllHistoricEvents()
    {
        return $this->timeTableRepository->getDateOfAllHistoricEvents();
    }
    
    public function getDateOfAllDanceEvents()
    {
        return $this->timeTableRepository->getDateOfAllDanceEvents();
    }

    public function getDateOfAllJazzEvents()
    {
        return $this->timeTableRepository->getDateOfAllJazzEvents();
    }

    public function getDateOfAllDanceAndJazzEvents()
    {
        return $this->timeTableRepository->getDateOfAllDanceAndJazzEvents();
    }

    public function getAllHistoricEventsByDate($date)
    {
        return $this->timeTableRepository->getAllHistoricEventsByDate($date);
    }
    public function getAllDanceEventsByDate($date)
    {
        return $this->timeTableRepository->getAllDanceEventsByDate($date);
    }
    public function getAllJazzEventsByDate($date)
    {
        return $this->timeTableRepository->getAllJazzEventsByDate($date);
    }

    public function getEventById($eventId)
    {
        return $this->timeTableRepository->getEventById($eventId);
    }

    public function getTypeOfTicketByType($TypeOFTicket){
        return $this->timeTableRepository->getTypeOfTicketByType($TypeOFTicket);
    }

    public function getHistoryEventById($eventId)
    {
        return $this->timeTableRepository->getHistoryEventById($eventId);
    }

    public function addItemToShoppingCart($cartId, $eventId, $quantityOrder, $subTotal, $typeOfTicket)
    {
        return $this->timeTableRepository->addItemToShoppingCart($cartId, $eventId, $quantityOrder, $subTotal, $typeOfTicket);
    }

    public function UpdateAvailableTickets($amountTotal, $eventId)
    {
        return $this->timeTableRepository->UpdateAvailableTickets($amountTotal, $eventId);
    }

    public function checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket)
    {
        return $this->timeTableRepository->checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket);
    }

    public function updateShoppingCartItemById($shoppingCartId, $quantityAmount, $subTotal){
        return $this->timeTableRepository->updateShoppingCartItemById($shoppingCartId, $quantityAmount, $subTotal);
    }
}