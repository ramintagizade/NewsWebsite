<?php
namespace App\Service;


use App\Entity\News;
use App\Entity\Dates;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsService  {

    private $entityManager;

    public function __construct($em)  {
        $this->entityManager = $em;
    }

    public function getAllNewsByCategoryAndDate($category, $date) {
        $newsRepository = $this->entityManager->getRepository(News::class);
        $news = $newsRepository->findByCategoryAndDate($category, $date);
        
        return $news;
    }

    public function getAllNewsByDescriptionQuery($query) {
        $newsRepository = $this->entityManager->getRepository(News::class);
        $news = $newsRepository->findAllNewsByDescriptionQuery($query);

        return $news;
    }

    public function getNewsByIdTitle($id, $title){
        $newsRepository = $this->entityManager->getRepository(News::class);
        $news = $newsRepository->findNewsByIdTitle($id,$title);
        return $news;
    }
}


?>