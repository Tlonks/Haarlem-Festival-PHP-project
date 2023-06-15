<?php
require_once __DIR__ . "/../repositories/ShoppingCartRepository.php";
require_once __DIR__ . "/../services/RegistrationService.php";
require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../models/roleEnum.php";
require_once __DIR__ . "/../services/ShoppingCartService.php";

class RegistrationController
{
    private $registrationService;
    private $shoppingCartService;

    function __construct()
    {
        $this->registrationService = new RegistrationService();
        $this->shoppingCartService = new ShoppingCartService();
    }

    public function index()
    {
        $this->checkForUser();
    }
    //Kijkt of een nieuwe gebruiker wordt aangemaakt en maakt het aan
    private function checkForUser()
    {        
        $error = "";

        try {
            if (isset($_POST["registerButton"])) {

                $user = new user();
                $user->firstName = htmlspecialchars(($_POST["firstname"]));
                $user->lastName = htmlspecialchars($_POST["lastname"]);
                $user->email = htmlspecialchars($_POST["email"]);
                $user->hashedPassword = htmlspecialchars($_POST["password"]);
                $user->phoneNumber = htmlspecialchars($_POST["number"]);
                $user->role = Role::User->value;
                $user->registrationDate = date("Y-m-d");
                $user->cartId = $this->shoppingCartService->createShoppingCart();


                if (!empty($_FILES["image"]["name"])) {
                    // Get file info 
                    $fileName = basename($_FILES["image"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                    // Allow certain file formats 
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['image']['tmp_name'];
                        $imgContent = file_get_contents($image);

                        $user->pictureId = $imgContent;
                    }
                }
                else{
                    throw new Exception("Please fill in all the fields correctly");
                }

                if ($this->registrationService->checkExistingEmail($user->email)) {
                    $error = "Email already exists";
                    require __DIR__ . "/../views/Login/Registration.php";
                    
                } else {
                    $this->uploadNewUser($user);
                    $succes = "You succesfully registered!";
                    require __DIR__ . "/../views/Login/login.php";
                }

            } else {
                require __DIR__ . "/../views/Login/Registration.php";
            }
        } catch (Throwable $ex) {
            $error = "Please fill in all the fields correctly";
            
            require __DIR__ . "/../views/Login/Registration.php";
        }

    }

    private function uploadNewUser($user)
    {
        $this->registrationService->uploadNewUser($user);
    }




}
?>