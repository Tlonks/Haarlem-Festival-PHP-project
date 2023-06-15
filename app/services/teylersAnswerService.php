<?php

class teylersAnswerService
{
    private $correctAnswers = array("submersing","float","sink","oxygen","shell");
    private $numbers = array(2,5,10,40,41);
    private $correctAnswer2 = 0;
    //Loopt door de array heen en kijkt of het antwoord erin zit
    public function checkAnswerAssignment1($answer)
    {
        $delimiter = ' ';
        $words = explode($delimiter,$answer);
        $test = false;
        foreach($words as $word){
            foreach($this->correctAnswers as $subAnswer)
            {
                if($word == $subAnswer){
                    $test = true;
                }

            }
        }

        return $test;

    }

    public function checkAnswerAssignment2($answer)
    {
        if($answer == $this->correctAnswer2){
            return true;
        }

    }

    

}

?>