<?php

namespace App\Repository;

use App\Entity\TimeRegister;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TimeRegister|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeRegister|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeRegister[]    findAll()
 * @method TimeRegister[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeRegisterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeRegister::class);
    }

     /**
      * @return TimeRegister[] Returns an array of TimeRegister objects
      */

    public function getTotalHoursGroupedByInvoiceableAndDate(): array
    {
        return $this->createQueryBuilder('t')
            ->select('DATE(t.date) as date, t.invoiceable, SUM(t.totalHours) as totalHours')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
            ->groupBy('t.date')
            ->addGroupBy('t.invoiceable')
            ->orderBy('t.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?TimeRegister
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
