<?php

namespace App\Repository;

use App\Entity\Dates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Dates|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dates|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dates[]    findAll()
 * @method Dates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dates::class);
    }

    public function findDate($date) {
       
        $result = (boolean) $this->getEntityManager()->createQueryBuilder('n')->select('n.date')
        ->from("App\Entity\Dates","n")->where("n.date=:date")
        ->setParameters(array("date"=>$date))->getQuery()->getOneOrNullResult();

        if ($result) {
            return true;
        }
        return false;
    }

    public function findAllDates() {
        $results =  $this->getEntityManager()->createQueryBuilder('d')->select('d.date')
        ->from("App\Entity\Dates","d")->getQuery()->getResult();

        return $results;
    }



    // /**
    //  * @return Dates[] Returns an array of Dates objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dates
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
