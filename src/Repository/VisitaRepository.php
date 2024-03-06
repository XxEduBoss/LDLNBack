<?php

namespace App\Repository;

use App\Entity\Visita;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visita>
 *
 * @method Visita|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visita|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visita[]    findAll()
 * @method Visita[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visita::class);
    }

    //Las visitas de un video
    public function getVisitasPorVideo(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $id_video = $id["id"];
        $sql = 'select v.* from apollo.visita v
                    join apollo.video v2 on v2.id = v.id_video
                    where v2.id = :id';

        $resultSet = $conn->executeQuery($sql, ['id' => $id_video]);
        return $resultSet->fetchAllAssociative();
    }

    public function getHistorialUsuario(array $id_usuario): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $id_usuario = $id_usuario["id_usuario"];
        $sql = 'select v2.*, max(v.fecha_visita) as fecha_visita, c.nombre_canal as nombre_canal
                        from apollo.visita v
                        join apollo.video v2 on v2.id = v.id_video
                        join apollo.canal c on c.id = v2.id_canal
                        where v.id_usuario = :id_usuario
                        group by v.id_video, v.id_usuario, v2.id, c.nombre_canal 
                        order by max(v.fecha_visita) desc';

        $resultSet = $conn->executeQuery($sql, ['id_usuario' => $id_usuario]);
        return $resultSet->fetchAllAssociative();
    }

}
