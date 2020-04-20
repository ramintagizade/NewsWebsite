<?php
namespace App\Service;



use App\Service\NewsService;
use App\Service\DateService;

class BusinessService {

    private $entityManager;

    public function __construct($em){
        $this->entityManager = $em;
    }

    public function getBusinessNews($page) {
       $newsService = new NewsService($this->entityManager);
       $businessNews = $newsService->getAllNewsByCategoryAndDate("business","2020-04-06");
       return $businessNews;
    }

}



?>