<?php

require_once __DIR__."/../services/teylersAnswerService.php";

class FirstChallengeController
{
    private $answerService;

    function __construct()
    {
        $this->answerService = new teylersAnswerService();
    }

    public function index()
    {
        require __DIR__."/../views/scavengerHunt/firstChallenge.php";
    }

    public function firstActive()
    {
        require __DIR__."/../views/scavengerHunt/FirstActiveChallenge.php";
    }

    //Haalt antwoord op en controleert of het goed is
    public function firstAnswer()
    {
        if (isset($_POST["answerSubmitButton"])) {
            $answer = htmlspecialchars($_POST["answer"]);
            if($this->answerService->checkAnswerAssignment1($answer))
            {
                require __DIR__."/../views/scavengerHunt/RightPageFirst.php";
            }
            else
            {
                require __DIR__."/../views/scavengerHunt/WrongPageFirst.php";
            }

            
        } else {
            require __DIR__."/../views/scavengerHunt/FirstAnswerPage.php";
        }
        
    }

    //Haalt code op en controleert of het goed is
    public function firstRight()
    {
        if (isset($_POST["codeEnterButton"])) {
            $answer = htmlspecialchars($_POST["code"]);
            $secretCode = "7722";

            if($answer == $secretCode)
            {
                require __DIR__."/../views/scavengerHunt/firstFactPage.php";
            }
            else{
                require __DIR__."/../views/scavengerHunt/RightPageFirst.php";
            }
            
        } else {
            require __DIR__."/../views/scavengerHunt/RightPageFirst.php";
        }
        
        
    }

    public function firstWrong()
    {
        require __DIR__."/../views/scavengerHunt/WrongPageFirst.php";
    }


}