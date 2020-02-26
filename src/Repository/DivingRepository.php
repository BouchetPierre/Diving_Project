<?php

namespace App\Repository;

use App\Entity\Diving;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Diving|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diving|null findOneBy(array $criteria, array $orderBy = null) *
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

    public function findAll()
    {
        return $this->findBy(array(), array('date'=> 'DESC'));

    }


}
