<?php
namespace App\Service;



use App\Service\NewsService;
use App\Service\DateService;

class HealthService {

    private $entityManager;

    public function __construct($em){
        $this->entityManager = $em;
    }

    public function getHealthNews($page) {
       $newsService = new NewsService($this->entityManager);
       $healthNews = $newsService->getAllNewsByCategoryAndDate("health","2020-04-06");
       return $healthNews;
    }

}



?>