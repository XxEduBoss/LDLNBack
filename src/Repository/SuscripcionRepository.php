<?php

namespace App\Repository;

use App\Entity\Suscripcion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @extends ServiceEntityRepository<Suscripcion>
 *
 * @method Suscripcion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suscripcion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suscripcion[]    findAll()
 * @method Suscripcion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuscripcionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suscripcion::class);
    }
    public function getSuscripcionByIdUsuarioRepository(array $params): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT s.id, s.id_usuario, s.id_canal, s.activo FROM apollo.suscripcion s WHERE s.id_usuario = :id_usuario AND s.id_canal = :id_canal';

        $resultSet = $conn->executeQuery($sql, $params);
        return $resultSet->fetchAllAssociative();
    }

    public function getSuscriptoresPorCanal(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idCanal = $id["id"];
        $sql = 'select u.* from apollo.usuario u 
                join apollo.suscripcion s on u.id = s.id_usuario
                where s.id_canal = :id';

        $resultSet = $conn->executeQuery($sql, ['id' => $idCanal]);
        return $resultSet->fetchAllAssociative();
    }



}
