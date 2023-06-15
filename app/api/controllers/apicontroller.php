<?php
require_once __DIR__ . "/../../services/apiKeyService.php";

class apicontroller
{
    public apiKeyService $apiKeyService;


    function __construct()
    {
        $this->apiKeyService = new apiKeyService();
    }

    function checkKey(){
        if (!isset($_SESSION['user']['apiKey']) || !isset($_SESSION['user']['userId'])) {
            $this->respondWithError(401, "Unauthorized");
            return true;
        }
        else if (!$this->apiKeyService->checkApiKey($_SESSION['user']['apiKey'], $_SESSION['user']['userId'])){
            $this->respondWithError(401, "Unauthorized");
            return true;
        }
        else{
            return false;
        }
    }

    function respondWithError($httpcode, $message)
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpcode, $data);
    }

    private function respondWithCode($httpcode, $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpcode);
        echo json_encode($data);
    }
}