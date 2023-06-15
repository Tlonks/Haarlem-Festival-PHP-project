<?php

require_once __DIR__ . "/../services/teylersAnswerService.php";

class SecondChallengeController
{
    private $answerService;

    function __construct()
    {
        $this->answerService = new teylersAnswerService();
    }

    public function index()
    {
        require __DIR__."/../views/scavengerHunt/SecondChallenge.php";
    }

    public function secondActive()
    {
        require __DIR__."/../views/scavengerHunt/SecondActiveChallenge.php";
    }
    //Haalt antwoord op en controleert of het goed is
    public function secondAnswer()
    {
        if (isset($_POST["answerSubmitButton"])) {
            $answer = htmlspecialchars($_POST["answer"]);
            if($this->answerService->checkAnswerAssignment2($answer))
            {
                require __DIR__."/../views/scavengerHunt/RightSecondPage.php";
            }
            else
            {
                require __DIR__."/../views/scavengerHunt/WrongPageSecond.php";
            }

            
        } else {
            require __DIR__."/../views/scavengerHunt/SecondAnswerPage.php";
        }
        
    }
    //Haalt code op en controleert of het goed is
    public function secondRight()
    {
        if (isset($_POST["codeEnterButton"])) {
            $answer = htmlspecialchars($_POST["code"]);
            $secretCode = "2277";

            if($answer == $secretCode)
            {
                require __DIR__."/../views/scavengerHunt/SecondFactPage.php";
            }
            else{
                require __DIR__."/../views/scavengerHunt/RightPageSecond.php";
            }
            
        } else {
            require __DIR__."/../views/scavengerHunt/RightPageSecond.php";
        }
        
        
    }

    public function secondWrong()
    {
        require __DIR__."/../views/scavengerHunt/WrongPageSecond.php";
    }


}