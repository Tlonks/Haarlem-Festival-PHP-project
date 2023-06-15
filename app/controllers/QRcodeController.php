<?php

require_once __DIR__ . "/../services/QrCodeService.php";

require_once __DIR__ . "/../services/ticketService.php";
require_once __DIR__."/../services/ticketService.php";

class QRcodeController
{
    private $ticketService;
    public function index()
    {
        require __DIR__ . '/../views/QR/scannerPage.php';
    }

    function __construct()
    {
        $this->ticketService = new ticketService();
    }
    //Haalt de QR code op en controleert of deze al is gescand
    public function scan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try{
                
                $data = file_get_contents("php://input");
                $key = json_decode($data, true);
                $keyString = $key['key'];
                if($this->ticketService->checkTicket($keyString)){
                    echo json_encode(["message" => "Ticket already scanned"]);
                    return;
                }
                $this->ticketService->scanTicket($keyString);
                echo json_encode(["message" => "Successfully scanned"]);
            }
            catch(Exception $e){
                echo json_encode(["message" => $e->getMessage()]);
                return;
            }
            
           
            
        } else {
            http_response_code(404);
        }
    }

}