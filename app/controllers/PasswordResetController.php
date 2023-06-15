<?php

require_once __DIR__ . '/../services/PasswordResetService.php';

class PasswordResetController
{
    private $resetService;

    function __construct()
    {
        $this->resetService = new passwordResetService();
    }
    //Controleert of de gebruiker een email heeft ingevuld
    //Als dit zo is wordt er een code gegenereerd en naar de gebruiker gestuurd
    public function index()
    {
        if (isset($_POST["resetButton"])) {
            $email = htmlspecialchars($_POST["email"]);
            $_SESSION["email"] = $email;
            $code = $this->resetService->randomCode();
            try {
                $this->resetService->sendCode($email,$code);
                unset($_SESSION["code"]);
                $_SESSION["code"] = $code;
                
                header("Location: /PasswordReset/code");
            } catch (Throwable $ex) {
                $error = "Wrong email";
            }
        } else {
            require __DIR__ . '/../views/Login/PasswordReset.php';
        }
        
    }
    //Controleert of de gebruiker de juiste code heeft ingevuld
    public function code()
    {
        $path = __DIR__ . '/../views/Login/NewPassword.php';
        if (isset($_POST["resetCode"])) {
            $code = htmlspecialchars($_POST["code"]);
            
            if ($code == $_SESSION["code"]) {
                require __DIR__ . '/../views/Login/EnterNewPassword.php';
            } else {
                $error = "Wrong code";
                require $path;
            }
        } else {
            require $path;
        }
    }
    //Controleert of de gebruiker 2 keer hetzelfde wachtwoord heeft ingevuld
    //Als dit zo is wordt het wachtwoord veranderd
    public function resetPassword(){
        
        $path = __DIR__ . '/../views/Login/EnterNewPassword.php';
        if (isset($_POST["resetPassword"])) {
            $password = htmlspecialchars($_POST["password"]);
            $passwordRepeat = htmlspecialchars($_POST["passwordRepeat"]);
            
            try
            {
                if ($password == $passwordRepeat) {
                    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
                    
                    $this->resetService->resetPassword($passwordHashed,$_SESSION["email"]);
                    $succes = "Password changed";
                    require __DIR__ . '/../views/Login/login.php';
                } else {
                    $error = "Passwords don't match";
                    require $path;
                }
            }
            catch (Throwable $ex)
            {
                $error = "Something went wrong";
                require $path;
            }
            
        } else {
            require $path;
        }
    }

}