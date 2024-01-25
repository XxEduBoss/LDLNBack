<?php

namespace App\Repository;

use App\Entity\EtiquetasVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtiquetasVideo>
 *
 * @method EtiquetasVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtiquetasVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtiquetasVideo[]    findAll()
 * @method EtiquetasVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtiquetasVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtiquetasVideo::class);
    }

//    /**
//     * @return EtiquetasVideo[] Returns an array of EtiquetasVideo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EtiquetasVideo
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
