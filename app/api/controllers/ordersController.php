<?php
require_once __DIR__ . "/../../services/orderService.php";
include_once __DIR__ . '/apicontroller.php';

class ordersController extends apicontroller
{

    private $orderService;


    function __construct()
    {
        parent::__construct();
        $this->orderService = new orderService();
    }
    //Alle orders ophalen en zet het is een array die duidelijk te lezen is
    public function index()
    {
        try {
            if ($this->checkKey()) {
                return;
            }

            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $orderItems = $this->orderService->getAllOrderItemsAPI();
                $orders = $this->orderService->getAllOrdersAPI();

                $data = array();

                for ($i = 0; $i < count($orders); $i++) {
                    $orderItemsArray = array();
                    for ($j = 0; $j < count($orderItems); $j++) {

                        if ($orders[$i]['id'] == $orderItems[$j]['orderId']) {

                            $orderItemsArray[$j]['item'] = $orderItems[$j];
                           
                        }
                    }
                    $data[$orders[$i]['id']]['order'] = $orders[$i];
                    
                    $data[$orders[$i]['id']]['orderItems'] = $orderItemsArray;
                }

                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data);
            } else if ($_SERVER["REQUEST_METHOD"] == 'PUT') {
                try {
                    // Get the raw JSON data from the request body
                    $id = $_GET['id'];
                    $isPaid = $_GET['isPaid'];

                    $this->orderService->setOrderPaid($id, $isPaid);
                } catch (Exception $e) {
                    // Return an error message
                    echo json_encode(["message" => $e->getMessage()]);
                }
                // Return a success message
                echo json_encode(["message" => "Success"]);
            }
        } catch
        (Throwable $e) {
            $this->respondWithError(401, $e->getMessage());
            return;
        }
    }
}
