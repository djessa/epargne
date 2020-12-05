<?php

namespace App\Repository;

use App\Entity\Retraits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Retraits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Retraits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Retraits[]    findAll()
 * @method Retraits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetraitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Retraits::class);
    }

    // /**
    //  * @return Retraits[] Returns an array of Retraits objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Retraits
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
