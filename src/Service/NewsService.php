<?php
namespace App\Service;

use App\Service\DateService;
use App\Entity\News;
use App\Entity\Dates;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


class NewsService  {

    private $entityManager;

    public function __construct($em)  {
        $this->entityManager = $em;
    }

    public function getAllNewsByCategoryAndDate($page, $category) {
        
        $newsRepository = $this->entityManager->getRepository(News::class);
        $dateService = new DateService($this->entityManager);
        $dates = $dateService->getAllDates();
        $len = count($dates);

        if($page > $len-1) {
            $page = $len-1;
        }
        
        echo "getting for the date of ".$dates[$page];

        $news = $newsRepository->findByCategoryAndDate($category, $dates[$page]);
         
        return $news;
    }
    


    public function getAllNewsByDescriptionQuery($page,$query) {
        $newsRepository = $this->entityManager->getRepository(News::class);
        $news = $newsRepository->findAllNewsByDescriptionQuery($page,$query);
        
        return $news;
    }

    public function getNewsByIdTitle($id, $date){
        $newsRepository = $this->entityManager->getRepository(News::class);
        $news = $newsRepository->findNewsByIdTitle($id,$date);
        return $news;
    }
}


?>