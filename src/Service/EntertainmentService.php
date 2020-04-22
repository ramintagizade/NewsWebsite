<?php
namespace App\Service;



use App\Service\NewsService;
use App\Service\DateService;

class EntertainmentService {

    private $entityManager;

    public function __construct($em){
        $this->entityManager = $em;
    }

    public function getEntertainmentNews($page) {
       $newsService = new NewsService($this->entityManager);
       $entertainmentNews = $newsService->getAllNewsByCategoryAndDate($page,"entertainment");
       return $entertainmentNews;
    }

}



?>