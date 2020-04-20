<?php
namespace App\Service;



use App\Service\NewsService;
use App\Service\DateService;

class TechnologyService {

    private $entityManager;

    public function __construct($em){
        $this->entityManager = $em;
    }

    public function getTechnologyNews($page) {
       $newsService = new NewsService($this->entityManager);
       $technologyNews = $newsService->getAllNewsByCategoryAndDate("technology","2020-04-06");
       return $technologyNews;
    }

}



?>