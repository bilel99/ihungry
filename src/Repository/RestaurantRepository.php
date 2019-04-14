<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }


    /**
     * Return All elements is table Restaurant - relations
     */
    public function getAll()
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.user', 'u')
            ->leftJoin('r.ville', 'v')
            ->leftJoin('r.categories', 'c')
            ->leftJoin('r.tag', 't')
            ->leftJoin('r.media', 'm')
            ->leftJoin('r.comments', 'comment')
            ->leftJoin('r.note', 'n')
            ->addSelect('r', 'u', 'v', 'c', 't', 'm', 'comment', 'n')
            ->orderBy('r.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * return average of note
     * @return mixed
     */
    public function averageNote()
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.note', 'n')
            ->select('avg(n.note) as avg_note')
            ->where('r.id = n.restaurant')
            ->getQuery()
            ->getResult();
    }

    /**
     * return number in comments
     * @return mixed
     */
    public function countComments()
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.comments', 'c')
            ->select('count(c.id) as nbr_comment')
            ->where('r.id = c.restaurant')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Restaurant[] Returns an array of Restaurant objects
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
    public function findOneBySomeField($value): ?Restaurant
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
