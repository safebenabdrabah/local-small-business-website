<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\SmallBusiness;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SmallBusiness>
 *
 * @method SmallBusiness|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmallBusiness|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmallBusiness[]    findAll()
 * @method SmallBusiness[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmallBusinessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SmallBusiness::class);
    }

//    /**
//     * @return SmallBusiness[] Returns an array of SmallBusiness objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SmallBusiness
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}