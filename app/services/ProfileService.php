<?php

require_once __DIR__ . "/../repositories/PictureRepository.php";
require_once __DIR__ . "/../repositories/LoginRepository.php";
require_once __DIR__."/../services/MailService.php";



class ProfileService{
    
        private $pictureRepository;
        private $loginRepository;

        private $mailService;
    
        function __construct()
        {
            $this->pictureRepository = new PictureRepository();
            $this->loginRepository = new LoginRepository();
            $this->mailService = new MailService();
        }
        //Nieuwe foto uploaden
        public function uploadUserPicture($userId, $image)
        {
            $this->pictureRepository->updatePicture($userId, $image);
            unset($_SESSION["userPicture"]);
            $_SESSION["userPicture"] = "data:image/jpeg;base64," . base64_encode($image);
            
        }
        //User opnieuw inladen
        public function editUser($userMail, $firstName, $lastName, $email, $password)
        {
            $this->loginRepository->updateUser($userMail, $firstName, $lastName, $email, $password);
            unset($_SESSION["user"]);
            $_SESSION["user"] = $this->loginRepository->getUser($email);
            $this->mailService->sendConfirmation($email, "Your account information has been changed including your password, if you did not do this, please contact us.");
        }

        public function updateUser($userId, $firstName, $lastName, $email, $phoneNumber, $role)
        {
            $this->loginRepository->updateUserAdmin($userId,$firstName, $lastName, $email, $phoneNumber, $role,null);
        }
        //Wanneer er geen wachtwoord wordt aangepast wordt deze functie gebruikt
        public function editUserWithoutPassword($userMail, $firstName, $lastName, $email)
        {
            $this->loginRepository->updateUserWithoutPassword($userMail, $firstName, $lastName, $email);
            unset($_SESSION["user"]);
            $_SESSION["user"] = $this->loginRepository->getUser($email);
            $this->mailService->sendConfirmation($email, "Your account information has been changed, if you did not do this, please contact us.");
        }
    
        public function deleterUser($id)
        {
            $this->loginRepository->deleteUser($id);
        }
}