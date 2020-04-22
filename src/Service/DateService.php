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
        /*$new_dates = array();
        print_r($dates);    
        $len = count($dates);
        for($i=0;$i<$len;$i++) {
            array_push($new_dates, $dates[$i]["date"]);    
        }
        $dates = $new_dates;
        $dates = $this->sortStrArray($dates);
        */
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