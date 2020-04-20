<?php
namespace App\Service;



use App\Service\NewsService;
use App\Service\DateService;

class SearchService {

    private $entityManager;

    public function __construct($em){
        $this->entityManager = $em;
    }

    public function getSearchNews($page, $query) {
       $newsService = new NewsService($this->entityManager);
       $searchNews = $newsService->getAllNewsByDescriptionQuery($query);
       return $searchNews;
    }

}



?>