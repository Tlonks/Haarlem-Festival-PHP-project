<?php
require_once __DIR__ . '/../repositories/orderRepository.php';
class orderService
{
    private $orderRepository;

    public function __construct()
    {
        $this->orderRepository = new orderRepository();
    }

    public function getOrder($orderId)
    {
        return $this->orderRepository->getOrder($orderId);
    }

    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders();
    }

    public function newOrder($cartInfo, $userId, $totalPrice)
    {
        $addedVAT = $this->calculateVAT($totalPrice);
        return $this->orderRepository->newOrder($cartInfo, $userId, $totalPrice, $addedVAT);
    }
    private function calculateVAT($totalPrice)
    {
        return $totalPrice * 0.09;
    }

    public function newOrderItems($item, $orderId)
    {
        $this->orderRepository->newOrderItems($item, $orderId);
    }

    public function getOrderItems($orderId)
    {
        return $this->orderRepository->getOrderItems($orderId);
    }

    public function getOrderItemInfo($orderId)
    {
        return $this->orderRepository->getOrderItemInfo($orderId);
    }

    public function getSingleOrder($orderId)
    {
        return $this->orderRepository->getSingleOrder($orderId);
    }

    public function getAllOrderItems()
    {
        return $this->orderRepository->getAllOrderItems();
    }

    public function getAllOrderItemsAPI()
    {
        return $this->orderRepository->getAllOrderItemsAPI();
    }

    public function getAllOrdersAPI()
    {
        return $this->orderRepository->getAllOrdersAPI();
    }

    public function setOrderPaid($orderId, $status)
    {
        $this->orderRepository->setOrderPaid($orderId, $status);
    }

    public function getOrderPaid($userId)
    {
        return $this->orderRepository->getOrderPaid($userId);
    }

}