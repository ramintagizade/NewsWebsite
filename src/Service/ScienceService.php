<?php
namespace App\Service;



use App\Service\NewsService;
use App\Service\DateService;

class ScienceService {

    private $entityManager;

    public function __construct($em){
        $this->entityManager = $em;
    }

    public function getScienceNews($page) {
       $newsService = new NewsService($this->entityManager);
       $scienceNews = $newsService->getAllNewsByCategoryAndDate("science","2020-04-04");
       return $scienceNews;
    }

}



?>