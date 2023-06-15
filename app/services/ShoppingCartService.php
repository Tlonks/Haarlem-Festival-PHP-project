<?php
include_once __DIR__ . '/../repositories/ShoppingCartRepository.php';

class ShoppingCartService
{
    private ShoppingCartRepository $shoppingCartRepository;

    public function __construct()
    {
        $this->shoppingCartRepository = new ShoppingCartRepository();
    }

    public function getFamilyPriceOnUserId($userId, $eventId)
    {
        return $this->shoppingCartRepository->getFamilyPriceOnUserId($userId, $eventId);
    }
    public function updateQuantityOfItems($id, $quantityOrder, $subTotal)
    {
        return $this->shoppingCartRepository->updateQuantityOfItems($id, $quantityOrder, $subTotal);
    }
    public function UpdateAmountTickets($eventId, $amount)
    {
        return $this->shoppingCartRepository->UpdateAmountTickets($eventId, $amount);
    }

    public function getShoppingCart($userId)
    {
        return $this->shoppingCartRepository->getShoppingCart($userId);
    }

    public function getShoppingCartById($cartId){
        return $this->shoppingCartRepository->getShoppingCartById($cartId);
    }
    public function getHistoryEventsOnEventId($eventId)
    {
        return $this->shoppingCartRepository->getHistoryEventsOnEventId($eventId);
    }
    public function getYummyEventsOnEventId($eventId)
    {
        return $this->shoppingCartRepository->getYummyEventsOnEventId($eventId);
    }
    public function getJazzEventsOnEventId($eventId)
    {
        return $this->shoppingCartRepository->getJazzEventsOnEventId($eventId);
    }
    public function getDanceEventsOnEventId($eventId)
    {
        return $this->shoppingCartRepository->getDanceEventsOnEventId($eventId);
    }

    public function getAll()
    {
        return $this->shoppingCartRepository->getAll();
    }

    public function deleteShoppingCart($id)
    {
        $this->shoppingCartRepository->deleteShoppingCart($id);
    }

    public function deleteShoppingCartItems($id)
    {
        $this->shoppingCartRepository->deleteShoppingCartItems($id);
    }
    public function getShoppingCartItems($cartId)
    {
        return $this->shoppingCartRepository->getShoppingCartItems($cartId);
    }

    public function deleteShoppingCartItem($id)
    {
        $this->shoppingCartRepository->deleteShoppingCartItem($id);
    }

    public function getTotalPrice($cartId)
    {
        return $this->shoppingCartRepository->getTotalPrice($cartId);
    }
   

    public function updateShoppingCartItemById($shoppingCartId, $quantityAmount, $subTotal){
        return $this->shoppingCartRepository->updateShoppingCartItemById($shoppingCartId, $quantityAmount, $subTotal);
    }

    public function getYummyEvent($userId, $datetime){
        return $this->shoppingCartRepository->getYummyEvent($userId, $datetime);
    }
    public function getEventIdYummy($restaurantName, $datetime){
        return $this->shoppingCartRepository->getEventIdYummy($restaurantName, $datetime);
    }
   
    public function addItemToShoppingCart($cartId, $eventId, $quantityOrder, $subTotal, $typeOfTicketId){
     $this->shoppingCartRepository->addItemToShoppingCart($cartId, $eventId, $quantityOrder, $subTotal, $typeOfTicketId);
    }

    public function checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket)
    {
        return $this->shoppingCartRepository->checkIfShoppingCartItemExist($cartId, $eventId, $typeOfTicket);
    }

    public function createShoppingCart()
    {
        return $this->shoppingCartRepository->createShoppingCart();
    }

}