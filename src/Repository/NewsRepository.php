<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Service\DateFormatFunction;
/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }
    /**
     * @return News[] returns an array of News objects 
     */

    public function findByTitleDateCategory($title, $publishedAt, $category) {
       
        $result = $this->getEntityManager()->createQueryBuilder('n')->select('n.title')
        ->from("App\Entity\News","n")->where("n.title=:title")->andWhere("n.publishedAt=:publishedAt")
        ->andWhere("n.category=:category")->setParameters(array("title"=>$title,"publishedAt"=>$publishedAt,"category"=>$category))
        ->getQuery()->getResult();
    }

    public function findByCategoryAndDate($category, $date) {
        
        $results = $this->getEntityManager()->createQueryBuilder('n')->select('n.title,n.description,n.urlToImage')
        ->from("App\Entity\News","n")->where("n.category=:category")->andWhere("DATE_FORMAT(n.publishedAt, '%Y-%m-%d')=:date")
        ->setParameters(array("category"=>$category,"date"=>$date))
        ->getQuery()->getResult();

        $len = count($results);
        //echo "len array" . $len;
        return $results;
    }


    public function findAll() {
        return [];
    }

    
    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
