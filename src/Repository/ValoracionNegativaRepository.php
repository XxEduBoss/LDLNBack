<?php

namespace App\Repository;

use App\Entity\ValoracionNegativa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ValoracionNegativa>
 *
 * @method ValoracionNegativa|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValoracionNegativa|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValoracionNegativa[]    findAll()
 * @method ValoracionNegativa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValoracionNegativaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValoracionNegativa::class);
    }

//    /**
//     * @return ValoracionNegativa[] Returns an array of ValoracionNegativa objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ValoracionNegativa
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
