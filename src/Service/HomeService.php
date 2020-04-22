<?php
namespace App\Service;


use App\Entity\News;
use App\Entity\Dates;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Service\NewsService;
use App\Service\DateService;


class HomeService {

    private $entityManager;

    public function __construct($em){
        $this->entityManager = $em;
    }

    public function getHomeNews($page) {
       $newsService = new NewsService($this->entityManager);
       $homeNews = $newsService->getAllNewsByCategoryAndDate($page, "general");
       return $homeNews;
    }
}


?>
