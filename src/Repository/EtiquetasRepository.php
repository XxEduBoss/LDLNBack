<?php

namespace App\Repository;

use App\Entity\Etiquetas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etiquetas>
 *
 * @method Etiquetas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etiquetas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etiquetas[]    findAll()
 * @method Etiquetas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtiquetasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etiquetas::class);
    }

    //Las Etiquetas por Video
    public function getEtiquetasPorVideo(array $video): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idvideo = $video["id"];
        $sql = 'select e.* from apollo.etiquetas e
                    join apollo.etiquetas_video ev on ev.id_etiqueta = e.id
                    where ev.id_video = :idvideo';

        $resultSet = $conn->executeQuery($sql, ['idvideo' => $idvideo]);
        return $resultSet->fetchAllAssociative();
    }

}
