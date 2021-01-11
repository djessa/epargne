<?php

namespace App\Repository;

use App\Entity\Funds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Funds|null find($id, $lockMode = null, $lockVersion = null)
 * @method Funds|null findOneBy(array $criteria, array $orderBy = null)
 * @method Funds[]    findAll()
 * @method Funds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FundsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Funds::class);
    }

    // /**
    //  * @return Funds[] Returns an array of Funds objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Funds
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
