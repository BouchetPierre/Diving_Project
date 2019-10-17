<?php

namespace App\Repository;

use App\Entity\Diving;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Diving|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diving|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diving[]    findAll()
 * @method Diving[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DivingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diving::class);
    }

    public function findById($id)
    {
        return $this->createQueryBuilder('r')
            ->select( 'r.location', 'r.description', 'r.date', 'r.levelMin')
            ->Where('r.id='.$id)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Diving[] Returns an array of Diving objects
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
    public function findOneBySomeField($value): ?Diving
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
