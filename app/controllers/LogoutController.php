<?php
//Haalt alles uit de session en stuurt de gebruiker terug naar de home pagina
class LogoutController{
    public function index(){
        
        unset($_SESSION["user"]);
        unset($_SESSION["userPicture"]);
        unset($_SESSION["Role"]);
        header("Location: /");
        
    }
}