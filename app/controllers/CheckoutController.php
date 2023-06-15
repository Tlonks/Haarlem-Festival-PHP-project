<?php

use Mollie\Api\MollieApiClient;

require_once __DIR__ . "/../services/OrderService.php";
require_once __DIR__ . "/../services/TicketService.php";
require_once __DIR__ . "/../services/ShoppingCartService.php";
require_once __DIR__ . "/../services/CreatePdfService.php";
require_once __DIR__ . "/../services/MailService.php";
require_once __DIR__ . "/../controllers/ShoppingCartInfoController.php";
require_once __DIR__ . "/../services/reservationService.php";
require_once __DIR__ . "/../controllers/ShoppingCartInfoController.php";
require_once __DIR__ . "/../services/checkoutService.php";

class CheckoutController extends ShoppingCartInfoController
{
    private $ticketService;
    private $orderService;
    private $reservationService;

    private $checkoutService;
    private $mailService;
    private $shoppingCartService;

    private $orderId;
    private $mollie;


    public function __construct()
    {
        $this->ticketService = new TicketService();
        $this->orderService = new OrderService();
        $this->reservationService = new reservationService();
        $this->checkoutService = new checkoutService();
        $this->mailService = new MailService();
        $this->shoppingCartService = new ShoppingCartService();
        $this->mollie = new MollieApiClient();
    }

    public function index()
    {

        $this->mollie->setApiKey("test_K2nq2xy53vmbRhQpqS4fhyVudpNTSs");

        $Repository = new ShoppingCartRepository;
        $cartInfo = $this->shoppingCartService->getShoppingCartById($_SESSION["user"]['cartId']);
        $infoShoppingCart = $this->shoppingCartService->getShoppingCart($_SESSION["user"]['userId']);
        $shoppingCartItems = $this->shoppingCartService->getShoppingCartItems($infoShoppingCart[0]['cartId']);
        $eventInfo = $this->extraEventInfo($infoShoppingCart, $this->shoppingCartService);
        $price = $this->checkFamilyTicket($infoShoppingCart, $this->shoppingCartService);

        $totalPrice = $this->checkoutService->calculateTotal($infoShoppingCart);
        $this->checkoutService->setRevervationNull($infoShoppingCart, $this->reservationService);



        if (isset($_POST['placeOrder'])) {



            $name = $_POST['name'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['number'];
            $address = $_POST['street-address'];
            $postalCode = $_POST['postal-code'];
            $birthdate = $_POST['birthdate'];
            $city = $_POST['city'];
            $country = $_POST['country'];


            //order aanmaken
            $id = $this->orderService->newOrder($cartInfo, $_SESSION["user"]['userId'], $totalPrice);
            $this->orderId = $id;
            $this->payment($totalPrice);



            for ($i = 0; $i < count($shoppingCartItems); $i++) {
                $this->orderService->newOrderItems($shoppingCartItems[$i], $id);
            }
            //orders en orderitems ophalen
            $order = $this->orderService->getSingleOrder($id);
            $orderItems = $this->orderService->getOrderItemInfo($id);

            //Ticket aanmaken en qr genereren
            //qrcodeArray bevat alle qr codes gekoppeld aan de orderItems id
            $qrCodeArray = $this->checkoutService->generateQrCodes($orderItems, $this->ticketService);


            //shoppingcart leegmaken
            $this->shoppingCartService->deleteShoppingCartItems($infoShoppingCart[0]['cartId']);
            $this->shoppingCartService->deleteShoppingCart($infoShoppingCart[0]['cartId']);

            //mail versturen

            $this->mailService->mailPDF($qrCodeArray, $email, $name, $order, $orderItems, $phoneNumber, $address, $postalCode, $birthdate, $city, $country);


        } else {
            require __DIR__ . '/../views/Checkout/CheckoutPage.php';
        }
    }

    public function payment($totalPrice)
    {
        $totalPriceString = number_format($totalPrice, 2, '.', '');


        $paymentOption = $_POST['paymentOption'];

        //initializing payment system

        $payment = $this->mollie->payments->create(
            [
                "amount" =>
                [
                    "currency" => "EUR",
                    "value" => "$totalPriceString"
                ],
                "method" => "$paymentOption",
                "description" => "Order for the Haarlem Festival",
                "redirectUrl" => "http://localhost/Checkout/confirmation",
                "cancelUrl" => "http://localhost/Checkout/paymentFailed",
                "webhookUrl" => "https://d1b1-81-59-60-118.ngrok-free.app/checkout/webhook",
                "metadata" => [
                    "order_id" => $this->orderId,
                ]

            ]
        );

        header("Location: " . $payment->getCheckoutUrl());
        $_POST['payment_id'] = $payment->id;


    }



    public function confirmation()
    {


        require __DIR__ . '/../views/Checkout/ConfirmationPage.php';



    }

    public function paymentFailed()
    {
        require __DIR__ . '/../views/Checkout/PaymentFailed.php';
    }

    public function webhook()
    {
        require __DIR__ . '/WebhookController.php';
    }
}