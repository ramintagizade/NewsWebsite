<?php
namespace App\Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Dates;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class DateService {

    private $entityManager;

    public function __construct($em)  {
        $this->entityManager = $em;
    }

    public function getAllDates() {
        
        $dateRepository = $this->entityManager->getRepository(Dates::class);
        $dates = $dateRepository->findAllDates();
        return $dates;
    }

    public function sortStrArray($arr) {

        usort($arr, function ($a, $b) {
            return strtotime($b) - strtotime($a);
        });
        
        return $arr;
    }


}




?>