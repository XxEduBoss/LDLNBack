<?php

namespace App\Repository;

use App\Entity\TipoVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoVideo>
 *
 * @method TipoVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoVideo[]    findAll()
 * @method TipoVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoVideo::class);
    }

//    /**
//     * @return TipoVideo[] Returns an array of TipoVideo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TipoVideo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
