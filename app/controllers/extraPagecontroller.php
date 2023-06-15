<?php
require_once __DIR__ . "/../services/IntroInformationService.php";

class extraPagecontroller
{
    private IntroInformationService $pageService;

    public function __construct()
    {
        $this->pageService = new IntroInformationService();
    }

    public function index()
    {
        $extraPage = $this->pageService->getPageById($_GET['id']);
        include_once __DIR__ . "/../views/extraPages/extraPage.php";
    }
}