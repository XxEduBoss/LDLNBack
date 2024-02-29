<?php

namespace App\Repository;

use App\Entity\ValoracionPositiva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ValoracionPositiva>
 *
 * @method ValoracionPositiva|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValoracionPositiva|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValoracionPositiva[]    findAll()
 * @method ValoracionPositiva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValoracionPositivaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValoracionPositiva::class);
    }

//    /**
//     * @return ValoracionPositiva[] Returns an array of ValoracionPositiva objects
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

//    public function findOneBySomeField($value): ?ValoracionPositiva
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function getValoracionPositivaByIdUsuarioRepository(array $params): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT v.id, v.id_usuario, v.id_video FROM apollo.valoracion_positiva v WHERE v.id_usuario = :id_usuario AND v.id_video = :id_video';

        $resultSet = $conn->executeQuery($sql, $params);
        return $resultSet->fetchAllAssociative();
    }

    public function getLikesPorVideo(array $id_video): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT count(v.*) as likes
                FROM apollo.valoracion_positiva v 
                WHERE v.id_video = :id_video';

        $resultSet = $conn->executeQuery($sql, ['id_video' => $id_video["id_video"]]);
        return $resultSet->fetchAllAssociative();
    }

}
