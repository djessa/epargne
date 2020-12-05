<?php

namespace App\Repository;

use App\Entity\Depots;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Depots|null find($id, $lockMode = null, $lockVersion = null)
 * @method Depots|null findOneBy(array $criteria, array $orderBy = null)
 * @method Depots[]    findAll()
 * @method Depots[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepotsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Depots::class);
    }

    // /**
    //  * @return Depots[] Returns an array of Depots objects
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
    public function findOneBySomeField($value): ?Depots
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
