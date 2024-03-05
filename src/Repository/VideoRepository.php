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
        $sql = 'select v.*, c.nombre_canal from apollo.video v
                      join apollo.etiquetas_video ev on v.id = ev.id_video
                      join apollo.etiquetas e on ev.id_etiqueta = e.id
                      join apollo.canal c on v.id_canal = c.id
                                     where e.descripcion = :etiqueta
                                     group by v.id, c.id' ;

        $resultSet = $conn->executeQuery($sql, ['etiqueta' => $etiqueta]);
        return $resultSet->fetchAllAssociative();
    }

    //Los videos en funcion de las etiquetas del video y del usuario
    public function getVideosEtiquetasUsuarios(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idTipoCategoria = $id["id"];
        $sql = 'select v.*, c.nombre_canal from apollo.usuario u
                    join apollo.canal c on u.id = c.id_usuario
                    join apollo.video v on c.id = v.id_canal
                    join apollo.etiquetas_video ev on v.id = ev.id_video
                    join apollo.etiquetas e on ev.id_etiqueta = e.id
                    join apollo.etiquetas_usuario eu on u.id = eu.id_usuario
                    where ev.id_etiqueta in (select e.id from apollo.etiquetas e
                                             join apollo.etiquetas_usuario eu on eu.id_etiqueta = e.id
                                             where eu.id_usuario = :id)
                    group by v.id, c.id';

        $resultSet = $conn->executeQuery($sql, ['id' => $idTipoCategoria]);
        return $resultSet->fetchAllAssociative();
    }

    //Los videos de tu canal
    public function getVideosPorCanal(array $id_canal): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idcanal = $id_canal["id_canal"];
        $sql = 'select v.* from apollo.canal c
                    join apollo.video v on c.id = v.id_canal
                    where v.id_canal = :id_canal
                    and v.activo = true';

        $resultSet = $conn->executeQuery($sql, ['id_canal' => $idcanal]);
        return $resultSet->fetchAllAssociative();
    }


    //Nos saca los videos en función de una etiqueta y el id_canal
    public function getVideosTematicaCanal(array $datos): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $id_canal = $datos["idCanal"];
        $etiqueta = $datos["etiqueta"];
        $sql = 'select v.*, c.nombre_canal, count(v2.*) as visitas from apollo.canal c
                                   join apollo.video v on c.id = v.id_canal
                                   join apollo.etiquetas_video ev on v.id = ev.id_video
                                   join apollo.etiquetas e on e.id = ev.id_etiqueta
                                   left join apollo.visita v2 on v2.id_video = v.id
                                   where v.id_canal = :id and e.descripcion = :etiqueta
                                   group by v.id, c.nombre_canal';

        $resultSet = $conn->executeQuery($sql, ['id' => $id_canal, 'etiqueta'=>$etiqueta]);
        return $resultSet->fetchAllAssociative();
    }

    public function getVideosBuscador(array $datos): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $text = '%'.$datos["texto"].'%';
        $sql = 'select v.*from apollo.video v 
                where v.titulo ilike :texto';


        $resultSet = $conn->executeQuery($sql, ['texto' => $text]);
        return $resultSet->fetchAllAssociative();
    }

    public function getVideosVirales()
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql = 'select v2.*, count(v.id) as total_visitas from apollo.visita v
                join apollo.video v2 on v.id_video = v2.id
                            where v.fecha_visita >= current_date - interval  \'1 month\'
                            group by v2.id
                            order by total_visitas desc
                            limit 5';

        $resultSet = $conn->executeQuery($sql);
        return $resultSet->fetchAllAssociative();
    }


}
