<?php
require_once __DIR__."/../services/MainTeylerPageService.php";
require_once __DIR__."/../models/MainTeylerContent.php";
require_once __DIR__."/../services/IntroInformationService.php";
class MainTeylersController
{
    private $contentService;

    function __construct()
    {
        $this->contentService = new MainTeylerPageService();
    }
    //Haalt alle content op en zet het in de juiste variabelen
    public function index()
    {
        $pageService = new IntroInformationService();
        $teylersPage = $pageService->getPageById(4);

        require __DIR__ . '/../views/ScavengerHunt/mainTeylers.php';
    }
}