<?php

require_once __DIR__."/../repositories/MainTeylersRepository.php";
class MainTeylerPageService
{
    private $mainTeylersRepository;

    function __construct()
    {
        $this->mainTeylersRepository = new MainTeylersRepository();
    }
    public function getAllContent()
    {
        return $this->mainTeylersRepository->getAllContent();
    }

    public function getHeaderPicture()
    {
        return $this->mainTeylersRepository->getHeaderPicture();
    }

    public function editHeader($header)
    {
        $this->mainTeylersRepository->editHeader($header);
    }

    public function editHeaderText($headerText)
    {
        $this->mainTeylersRepository->editHeaderText($headerText);
    }

    public function editMainText($mainText)
    {
        $this->mainTeylersRepository->editMainText($mainText);
    }

    public function editHeaderPicture($headerPicture)
    {
        $this->mainTeylersRepository->editHeaderPicture($headerPicture);
    }

    

}

?>