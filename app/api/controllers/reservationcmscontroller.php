<?php
include_once __DIR__ . "/../../services/reservationService.php";
include_once __DIR__ . '/apicontroller.php';

class reservationcmscontroller extends apicontroller
{
    private reservationService $reservationService;

    function __construct()
    {
        parent::__construct();
        $this->reservationService = new reservationService();
    }

    // router maps this to /api/cms automatically
    public function index()
    {
        if ($this->checkKey()){
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == 'PUT'){
            try {
                // Get the raw JSON data from the request body
                $id = $_GET['id'];
                $isCanceled = $_GET['isCanceled'];

                // Insert the new status into the database
                $this->reservationService->updateReservation($id, $isCanceled);
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }
    }
}