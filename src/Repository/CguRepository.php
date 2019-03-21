<?php

namespace App\Repository;

use App\Entity\Cgu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cgu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cgu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cgu[]    findAll()
 * @method Cgu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CguRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cgu::class);
    }

    // /**
    //  * @return Cgu[] Returns an array of Cgu objects
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
    public function findOneBySomeField($value): ?Cgu
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
