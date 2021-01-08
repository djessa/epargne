<?php

namespace App\Repository;

use App\Entity\Persons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Persons|null find($id, $lockMode = null, $lockVersion = null)
 * @method Persons|null findOneBy(array $criteria, array $orderBy = null)
 * @method Persons[]    findAll()
 * @method Persons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Persons::class);
    }

    // /**
    //  * @return Persons[] Returns an array of Persons objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Persons
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
