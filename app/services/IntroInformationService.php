<?php
require_once __DIR__ . '/../repositories/IntroInformationRepository.php';

class IntroInformationService{
    private $pageRepo;

    public function __construct(){
        $this->pageRepo = new IntroInformationRepository();
    }

    public function getAllPages(){
        return $this->pageRepo->getAllPages();
    }
    public function getAllExtraPages(){
        return $this->pageRepo->getAllExtraPages();
    }
    public function getPageById($id){
        return $this->pageRepo->getPageById($id);
    }

    public function addPage($title, $category){
        $this->pageRepo->addPage($title, $category);
    }

    public function updatePage($id, $htmlData){
        $this->pageRepo->updatePage($id, $htmlData);
    }

    public function deletePage($id){
        $this->pageRepo->deletePage($id);
    }

    public function getIntroInformation($page)
    {
        return $this->pageRepo->getIntroInformation($page);
    }
}