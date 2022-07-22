<?php

namespace App\Repository;

use App\Entity\TimeRegister;
use App\Entity\User;
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

    /**
    * @return TimeRegister[] Returns an array of TimeRegister objects
    */
    public function getTotalHoursInvoiceableGroupedByWeek(): array
    {
        return $this->createQueryBuilder('t')
            ->select('YEARWEEK(t.date, 1) as yearWeek, MIN(t.date) as firstDayOfWeek, SUM(t.totalHours) as totalHours')
            ->andWhere('t.invoiceable = :invoiceable')
            ->setParameter('invoiceable', true)
            ->groupBy('yearWeek')
            ->orderBy('yearWeek', 'DESC')
            ->getQuery()
            ->setMaxResults(8)
            ->getResult()
        ;
    }

    /**
    * @return TimeRegister[] Returns an array of TimeRegister objects
    */
    public function getTotalHoursInvoiceableGroupedByMonthAndUser(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->select('MONTH(t.date) as month, SUM(t.totalHours) as totalHours')
            ->andWhere('t.invoiceable = :invoiceable')
            ->andWhere('t.user = :user')
            ->setParameter('invoiceable', true)
            ->setParameter('user', $user)
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getTotalHoursGroupedByMonthAndProject(): array
    {
        return $this->createQueryBuilder('t')
            ->select('MONTH(t.date) as month, p.name, SUM(t.totalHours) as totalHours')
            ->join('t.project', 'p')
            ->andWhere('t.invoiceable = true')
            ->groupBy('month')
            ->addGroupBy('p.name')
            ->orderBy('month', 'ASC')
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
