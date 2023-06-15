<?php

use Mollie\Api\MollieApiClient;

require_once __DIR__ . "/../services/OrderService.php";

$mollie = new MollieApiClient();
$mollie->setApiKey("test_K2nq2xy53vmbRhQpqS4fhyVudpNTSs");

$orderService = new OrderService();

$paymentId = $_POST['id'];

// Get payment object from Mollie
$payment = $mollie->payments->get($paymentId);

// Get order ID from custom data
$metadata = $payment->metadata;
$orderId = $metadata->order_id;

// Update order status based on payment status


if ($payment->isPaid()) {
    $orderService->setOrderPaid($orderId, "true");
} else {
    $orderService->setOrderPaid($orderId, "false");
}



// Send confirmation to Mollie
http_response_code(200);