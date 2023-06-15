<?php
include_once __DIR__ . '/../repositories/eventRepository.php';
class eventService
{
    private $eventRepository;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
    }

    //get all events

    public function getAllEvents()
    {
        return $this->eventRepository->getAllEvents();
    }

    public function getAllDanceEvents()
    {
        return $this->eventRepository->getAllDanceEvents();
    }

    public function getAllHistoryEvents()
    {
        return $this->eventRepository->getAllHistoryEvents();
    }

    public function getAllJazzEvents()
    {
        return $this->eventRepository->getAllJazzEvents();
    }

    public function getAllYummyEvents()
    {
        return $this->eventRepository->getAllYummyEvents();
    }

    //Adding events

    public function addTypeOfEvent($event, $typeOfEvent)
    {
        $this->eventRepository->addTypeOfEvent($event, $typeOfEvent);
    }

    //get event by id

    public function getDanceEventById(mixed $id)
    {
        return $this->eventRepository->getDanceEventById($id);
    }

    public function getHistoryEventById(mixed $id)
    {
        return $this->eventRepository->getHistoryEventById($id);
    }

    public function getJazzEventById(mixed $id)
    {
        return $this->eventRepository->getJazzEventById($id);
    }

    public function getYummyEventById(mixed $id)
    {
        return $this->eventRepository->getYummyEventById($id);
    }

    //update events

    public function updateDanceEvent(mixed $id, mixed $name, mixed $date, mixed $price, mixed $quantity, mixed $location, mixed $artist, mixed $session)
    {
        $this->eventRepository->updateDanceEvent($id, $name, $date, $price, $quantity, $location, $artist, $session);
    }

    public function updateHistoryEvent(HistoryEvent $event)
    {
        $this->eventRepository->updateHistoryEvent($event);
    }

    public function updateJazzEvent(mixed $data)
    {
        $this->eventRepository->updateJazzEvent($data);
    }

    public function updateYummyEvent(mixed $data, $rprice)
    {
        $this->eventRepository->updateYummyEvent($data, $rprice);
    }

    //deleting events

    public function deleteDanceEvent(mixed $id)
    {
        $this->eventRepository->deleteDanceEvent($id);
    }

    public function deleteHistoryEvent(mixed $eventId)
    {
        $this->eventRepository->deleteHistoryEvent($eventId);
    }

    public function deleteJazzEvent(mixed $id)
    {
        $this->eventRepository->deleteJazzEvent($id);
    }

    public function deleteYummyEvent(mixed $id)
    {
        $this->eventRepository->deleteYummyEvent($id);
    }
}