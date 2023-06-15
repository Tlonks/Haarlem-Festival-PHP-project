<?php

require_once __DIR__ . "/../services/ProfileService.php";

class ProfileController{

    private $profileService;

    function __construct()
    {
        $this->profileService = new ProfileService();
    }
    //Kijkt of er is ingelogd en laat de profiel pagina zien
    public function index(){
        $this->uploadPicture();
        if(isset($_SESSION["user"])){
            require __DIR__ . "/../views/User/profile.php";
        }
        else{
            header("Location: /Login");
        }
       
    }
    //Kijkt of de gebruiker iets wil aanpassen en stuurt de gebruiker terug naar de profiel pagina
    public function editProfile(){
        if(isset($_POST["changeButton"])){
            $firstName = htmlspecialchars($_POST["firstname"]);
            $lastName = htmlspecialchars($_POST["lastname"]);
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            $passwordConfirm = htmlspecialchars($_POST["passwordConfirm"]);

            if(empty($password))
            {
                $this->profileService->editUserWithoutPassword($_SESSION["user"]["email"], $firstName, $lastName, $email);
                header("Location: /Profile");
            }
            elseif($password == $passwordConfirm)
            {
                $this->profileService->editUser($_SESSION["user"]["email"], $firstName, $lastName, $email, $password);
                header("Location: /Profile");
            }
            else{
                require __DIR__ . "/../views/User/EditProfile.php";
            }
        }
        else
        {
            require __DIR__ . "/../views/User/EditProfile.php";
        }
        
    }
    //Kijkt of de gebruiker een foto wil uploaden en stuurt de gebruiker terug naar de profiel pagina
    private function uploadPicture()
    {
        if (isset($_POST["submit"])) {
            $fileName = basename($_FILES["image"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            if (!empty($_FILES["image"]["name"])) {
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {

                    $image = $_FILES['image']['tmp_name'];
                    $img = file_get_contents($image);

                    $this->profileService->uploadUserPicture($_SESSION["user"]["userId"], $img);
                }

            }
        }
    }
}