<?php

namespace App\Repository;

use App\Entity\Corporations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Corporations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Corporations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Corporations[]    findAll()
 * @method Corporations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorporationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Corporations::class);
    }

    // /**
    //  * @return Corporations[] Returns an array of Corporations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Corporations
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
