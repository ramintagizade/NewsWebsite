<?php
namespace App\Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Dates;


class DateService {

    public function __construct() {
        
    }

    public function getAllDates() {
        $this->entityManager = $this->getDoctrine()->getManager();
        $dateRepository = $this->entityManager->getRepository(Dates::class);
        $dates = $dateRepository->findAllDates();
        $new_dates = array();
        $len = count($dates);
        for($i=0;$i<$len;$i++) {
            array_push($new_dates, $dates[$i]["date"]);    
        }
        $dates = $new_dates;
        $dates = $this->sortStrArray($dates);
        print_r($dates);

        return $dates;
    }


}




?>