<?php
namespace App\Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News;
use App\Entity\Dates;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


class NewsService {


    public function getAllNewsByCategoryAndDate($category, $date) {
        $this->entityManager = $this->getDoctrine()->getManager();
        $newsRepository = $this->entityManager->getRepository(News::class);
        $news = $newsRepository->findByCategoryAndDate($category, $date);
        
    }
}


?>