<?php

namespace App\Repository;

use App\Entity\Comentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comentario>
 *
 * @method Comentario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comentario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comentario[]    findAll()
 * @method Comentario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentario::class);
    }

    //Los comentarios por video
    public function getComentariosPorVideo(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idVideo = $id["id"];
        $sql = 'select c.* from apollo.comentario c
                    where c.id_video = :id 
                    order by c.fecha_publicacion desc';

        $resultSet = $conn->executeQuery($sql, ['id' => $idVideo]);
        return $resultSet->fetchAllAssociative();
    }

}
