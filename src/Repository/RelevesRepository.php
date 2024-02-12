<?php

namespace App\Repository;

use App\Entity\Releves;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Releves>
 *
 * @method Releves|null find($id, $lockMode = null, $lockVersion = null)
 * @method Releves|null findOneBy(array $criteria, array $orderBy = null)
 * @method Releves[]    findAll()
 * @method Releves[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelevesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Releves::class);
    }

//    /**
//     * @return Releves[] Returns an array of Releves objects
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

//    public function findOneBySomeField($value): ?Releves
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
