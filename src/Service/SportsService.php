<?php
namespace App\Service;



use App\Service\NewsService;
use App\Service\DateService;

class SportsService {

    private $entityManager;

    public function __construct($em){
        $this->entityManager = $em;
    }

    public function getSportsNews($page) {
       $newsService = new NewsService($this->entityManager);
       $sportsNews = $newsService->getAllNewsByCategoryAndDate($page,"sports");
       return $sportsNews;
    }

}



?>