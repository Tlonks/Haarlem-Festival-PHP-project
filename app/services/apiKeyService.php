<?php

require_once __DIR__."/../repositories/LoginRepository.php";

class apiKeyService{

    private $loginRepository;

    public function __construct()
    {
        $this->loginRepository = new LoginRepository();
    }

    //Willekeurige code aanmaken
    public function generateApiKey(){
        return $apiKey = bin2hex(random_bytes(32));
    }

    //Checken of de api key overeenkomt met de api key in de database
    public function checkApiKey($key,$id){
        $apiToken = $this->loginRepository->getApiToken($id);
        if($key == $apiToken){return true;}
    }

    //Maakt nieuwe code aan en zat dat in de database
    public function updateApiKey($userId){
        $key = $this->generateApiKey();
        $this->loginRepository->updateToken($userId,$key);
    }

    public function deleteKey($userId){
        $this->loginRepository->deleteToken($userId);
    }
}