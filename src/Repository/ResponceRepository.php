<?php

namespace App\Repository;

use App\Entity\Responce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Responce>
 *
 * @method Responce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Responce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Responce[]    findAll()
 * @method Responce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Responce::class);
    }

    //    /**
    //     * @return Responce[] Returns an array of Responce objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Responce
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
