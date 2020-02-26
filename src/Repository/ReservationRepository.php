<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\AST\Join;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

     /**
      * Les plongées en fonction du user
      *
     * @return Reservation[] Returns an array of Reservation objects
     */

    public function findByUser($id)
    {
        return $this->createQueryBuilder('r')
            ->select('r.id', 'rc.location', 'rc.description', 'rc.date', 'rc.levelMin', 'rc.id as idD', 'rd.id as idM')
            ->Where('rd.id='.$id)
            ->innerJoin('r.fkIdDiving', 'rc', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdDiving = rc.id' )
            ->innerJoin('r.fkIdMember', 'rd', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdMember = rd.id' )
            ->orderBy('rc.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * Les participants à une plongée définie
     *
     * @return Reservation[] Returns an array of Reservation objects
     */

    public function  findDivMember($id)
    {
        return $this->createQueryBuilder('r')
            ->select('r.id', 'rc.name', 'rc.pseudo','rd.places', 'rc.firstName', 'rc.levelDive', 'rd.id as idD','rc.id as idM', 'rd.location', 'rd.date', 'rc.mail', 'r.regulator', 'r.wetSuit', 'r.sizeSuit', 'rc.ticketDive',
                'r.needCar', 'r.driverCar', 'r.placeCar', 'rc.phone1')
            ->Where('rd.id ='.$id)
            ->innerJoin('r.fkIdMember', 'rc', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdMember = rc.id' )
            ->innerJoin('r.fkIdDiving', 'rd', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdDiving = rd.id' )
            ->getQuery()
            ->getResult()
        ;

    }

    /**
     * Les participants à une plongée définie recherche ticket (pas de select = return un tableau d'objets)
     *
     * @return Reservation[] Returns an array of Reservation objects
     */

    public function  findDivMemberTicket($id)
    {
        return $this->createQueryBuilder('r')
            ->Where('rd.id ='.$id)
            ->innerJoin('r.fkIdMember', 'rc', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdMember = rc.id' )
            ->innerJoin('r.fkIdDiving', 'rd', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdDiving = rd.id' )
            ->getQuery()
            ->execute()
            ;

    }
    /**
     * Mail des participants à une plongée définie
     *
     * @return Reservation[] Returns an array of Reservation objects
     */

    public function  findMailMemberDiv($id)
    {
        return $this->createQueryBuilder('r')
            ->select('rc.mail')
            ->Where('rd.id ='.$id)
            ->innerJoin('r.fkIdMember', 'rc', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdMember = rc.id' )
            ->innerJoin('r.fkIdDiving', 'rd', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdDiving = rd.id' )
            ->getQuery()
            ->getResult()
            ;

    }

    public function  findTicketMemberDiv($id)
    {
        return $this->createQueryBuilder('r')
            ->select( 'rc.ticketDive')
            ->Where('rd.id ='.$id)
            ->innerJoin('r.fkIdMember', 'rc', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdMember = rc.id' )
            ->innerJoin('r.fkIdDiving', 'rd', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.fkIdDiving = rd.id' )
            ->getQuery()
            ->getResult()
            ;

    }
    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
