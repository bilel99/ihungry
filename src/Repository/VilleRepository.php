<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    /**
     * DEFAULT PAYS (FRANCE) ID = 75
     */
    private const DEFAULT_PAYS = 75;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    /**
     * Search libelle ville
     * @param $value
     * @return mixed
     */
    public function searchByField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.pays_id = '.self::DEFAULT_PAYS)
            ->andWhere('v.libelle LIKE :val')
            ->setParameter('val', $value.'%')
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Ville[] Returns an array of Ville objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ville
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
