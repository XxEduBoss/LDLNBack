<?php

namespace App\Repository;

use App\Entity\Notificacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notificacion>
 *
 * @method Notificacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notificacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notificacion[]    findAll()
 * @method Notificacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notificacion::class);
    }


    public function getNotificacionesPorUsuario(array $id_usuario): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idUsuario = $id_usuario["id_usuario"];
        $sql = 'select n.* from apollo.notificacion n
                    where n.id_usuario = :idUsuario';

        $resultSet = $conn->executeQuery($sql, ['idUsuario' => $idUsuario]);
        return $resultSet->fetchAllAssociative();
    }

    public function getNotificacionesNuevas(array $id_usuario): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idUsuario = $id_usuario["id_usuario"];
        $sql = 'select count(n.*) from apollo.notificacion n
                    where n.id_usuario = :idUsuario 
                    and activo = true';

        $resultSet = $conn->executeQuery($sql, ['idUsuario' => $idUsuario]);
        return $resultSet->fetchAllAssociative();
    }

}
