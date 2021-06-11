<?php

namespace App\Repository;

use App\Entity\CoursLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoursLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoursLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoursLike[]    findAll()
 * @method CoursLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursLike::class);
    }

    // /**
    //  * @return CoursLike[] Returns an array of CoursLike objects
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
    public function findOneBySomeField($value): ?CoursLike
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
