<?php

require_once __DIR__ . "/../services/loginService.php";
require_once __DIR__ . "/../repositories/PictureRepository.php";
require_once __DIR__ . "/../services/PictureService.php";

class LoginController
{
    private $loginService;
    private $pictureService;

    function __construct()
    {
        $this->loginService = new loginService();
        $this->pictureService = new PictureService();
    }
    
    public function index()
    {
        $this->checkForUser();
    }
    //Haalt gebruiker op en controleert of het goed is
    //Als het goed is wordt de gebruiker ingelogd
    private function checkForUser()
    {
        
        if (isset($_POST["loginButton"])) {
            $username = htmlspecialchars($_POST["uname"]);
            $password = htmlspecialchars($_POST["psw"]);

            try {
                $user = $this->getUser($username);
                $this->login($user, $password);

            } catch (Throwable $ex) {
                $error = "Wrong password";
            }
        } else {
            require __DIR__ . "/../views/Login/login.php";
        }
    }

    private function GetUser($username)
    {
        return $this->loginService->getUser($username);
    }
    //Controleert of het wachtwoord klopt
    //Als het klopt wordt de gebruiker ingelogd
    //Als het niet klopt wordt de gebruiker terug gestuurd naar de login pagina
    private function login($user, $password)
    {
        $error = "Wrong username or password";
        $path = "/../views/Login/login.php";
        
        try {
            if (empty($user)) {
                require __DIR__ . $path;
            } else {
                if (password_verify($password, $user["hashedPassword"])) {
                    
                    $_SESSION["user"] = $user;
                    $userPicture = $this->pictureService->getPicture($user["userId"]);
                    $_SESSION["userPicture"] = "data:image/jpeg;base64," . base64_encode($userPicture["picture"]);
                    $_SESSION["Role"] = $user["role"];
                    
                    header("Location: /home");
                    
                } else {
                    require __DIR__ . $path;
                }
            }

        } catch (Throwable $ex) {
            require __DIR__ . $path;
        }
    }

}
?>