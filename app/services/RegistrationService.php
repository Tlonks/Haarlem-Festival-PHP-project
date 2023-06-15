<?php
require_once __DIR__."/../repositories/LoginRepository.php";

require_once __DIR__."/../repositories/PictureRepository.php";
class RegistrationService
{
    private $loginRepository;
    private $pictureRepository;

    public function __construct()
    {
        $this->loginRepository = new LoginRepository();
        $this->pictureRepository = new PictureRepository();
    }
    //Nieuwe gebruiker registreren en foto uploaden
    public function uploadNewUser($user)
    {
        $this->loginRepository->uploadUser($user);
        $newUser = $this->getUser($user->email);
        $this->uploadPicture($newUser["userId"], $user->pictureId);
    }

    private function getUser($username)
    {
        $user = $this->loginRepository->getUser($username);
        return $user;
    }

    private function uploadPicture($userId,$picture)
    {
        $this->pictureRepository->uploadNewPicture($userId,$picture);
    }

    public function checkExistingEmail($email)
    {
        return $this->loginRepository->checkExistingEmail($email);
    }

    

    

   

    
    

    

}

?>