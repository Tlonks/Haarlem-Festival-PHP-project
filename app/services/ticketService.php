<?php

require_once __DIR__ . "/../repositories/TicketRepository.php";
require_once __DIR__ . "/QrCodeService.php";
class ticketService{
    private $ticketRepository;
    private $qrCodeService;
    public function __construct(){
        $this->ticketRepository = new ticketRepository();
        $this->qrCodeService = new QrCodeService();
    }

    public function updateQR($orderId, $qrCode){
        $this->ticketRepository->updateQR($orderId, $qrCode);
    }

    public function scanTicket($key){
        return $this->ticketRepository->scanTicket($key);
    }

    public function checkTicket($key){
        return $this->ticketRepository->checkTicket($key);
    }

    //Maakt een nieuw ticket aan en geeft de qrcode terug
    public function newTicket($orderItem,$userId){
        
        $key = $this->generateKey();
        
        $qrcode = $this->qrCodeService->generateQR($key);
        
        $eventCount = 1;
        
        $this->ticketRepository->newTicket($orderItem['orderId'],$userId,$key,$eventCount,$orderItem['0']);
        return $qrcode;
    }
    //Maakt een nieuw ticket aan en geeft de qrcode terug maar dan als pass voor een dag of weekend
    public function newPassTicket($orderItem,$userId){
        
        $key = $this->generateKey();
        
        $qrcode = $this->qrCodeService->generateQR($key);
        
        $eventCount = null;
        
        $this->ticketRepository->newTicket($orderItem['orderId'],$userId,$key,$eventCount,$orderItem['0']);
        return $qrcode;
    }

    //Random code aanmaken
    private function generateKey(){
        return bin2hex(random_bytes(32));
    }

    

    
}