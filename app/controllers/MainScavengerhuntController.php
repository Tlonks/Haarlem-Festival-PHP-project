<?php


class MainScavengerhuntController
{
    //Haalt code op en controleert of het goed is
    public function index()
    {
        $path = __DIR__ . "/../views/ScavengerHunt/mainScavengerhunt.php";

        

        if (isset($_POST["codeEnterButton"])) {
            $code = htmlspecialchars($_POST["code"]);
            $secretCode = "5368";
            

            try {
                if ($code == $secretCode) {
                    require __DIR__ . "/../views/scavengerHunt/openingscreen.php";
                } else {
                    $error = "Wrong code";
                    require $path;
                }

            } catch (Throwable $ex) {
                $error = "Wrong code";
                require $path;
            }
        } else {
            require $path;
        }

    }

    public function codePage()
    {
        require __DIR__ . "/../views/scavengerHunt/CodePage.php";

    }

    public function endPage()
    {
        require __DIR__ . "/../views/scavengerHunt/LastPage.php";

    }

    public function secretPage()
    {
        require __DIR__ . "/../views/scavengerHunt/SecretPage.php";

    }

    public function teylersFinish()
    {
        require __DIR__ . "/../views/scavengerHunt/FinishPage.php";

    }



}