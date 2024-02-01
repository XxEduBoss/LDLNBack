<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Video>
 *
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    //Los videos de tus canales suscritos
    public function getVideosSuscritos(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idTipoCategoria = $id["id"];
        $sql = 'select v.* from apollo.suscripcion s
                    join apollo.canal c on s.id_canal = c.id
                    join apollo.video v on c.id = v.id_canal
                    where s.id_usuario = :id group by v.id';

        $resultSet = $conn->executeQuery($sql, ['id' => $idTipoCategoria]);
        return $resultSet->fetchAllAssociative();
    }

    //Los videos en funcion de la etiqueta que tu quieras
    public function getVideosPorEtiqueta(array $etiqueta): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $etiqueta = $etiqueta["etiqueta"];
        $sql = 'select v.*, c.* from apollo.video v
                      join apollo.etiquetas_video ev on v.id = ev.id_video
                      join apollo.etiquetas e on ev.id_etiqueta = e.id
                      join apollo.canal c on v.id_canal = c.id
                                     where e.descripcion = :etiqueta group by v.id, c.id limit 4';

        $resultSet = $conn->executeQuery($sql, ['etiqueta' => $etiqueta]);
        return $resultSet->fetchAllAssociative();
    }

    //Los videos en funcion de las etiquetas del video y del usuario
    public function getVideosEtiquetasUsuarios(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idTipoCategoria = $id["id"];
        $sql = 'select v.* from apollo.usuario u
                    join apollo.canal c on u.id = c.id_usuario
                    join apollo.video v on c.id = v.id_canal
                    join apollo.etiquetas_video ev on v.id = ev.id_video
                    join apollo.etiquetas e on ev.id_etiqueta = e.id
                    join apollo.etiquetas_usuario eu on u.id = eu.id_usuario
                    where u.id = :id and ev.id_etiqueta = eu.id_etiqueta 
                    group by v.id';

        $resultSet = $conn->executeQuery($sql, ['id' => $idTipoCategoria]);
        return $resultSet->fetchAllAssociative();
    }

    //Los videos de tu canal
    public function getVideosPorCanal(array $canal): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idcanal = $canal["id"];
        $sql = 'select v.* from apollo.canal c
                    join apollo.video v on c.id = v.id_canal
                    where v.id_canal = :idcanal';

        $resultSet = $conn->executeQuery($sql, ['idcanal' => $idcanal]);
        return $resultSet->fetchAllAssociative();
    }

}
