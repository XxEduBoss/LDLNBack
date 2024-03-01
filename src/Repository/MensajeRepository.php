<?php

namespace App\Repository;

use App\Entity\Mensaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mensaje>
 *
 * @method Mensaje|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mensaje|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mensaje[]    findAll()
 * @method Mensaje[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MensajeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mensaje::class);
    }

    public function getMensajesEntreUsuarios(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idCanal2 = $id["id_canal2"];
        $idCanal1= $id["id_canal1"];
        $sql = 'select m.* from apollo.mensaje m
                join apollo.canal c on m.id_canal_receptor = c.id
                    where m.id_canal_emisor = :idCanal1 and m.id_canal_receptor = :idCanal2
                       or m.id_canal_receptor = :idCanal1 and m.id_canal_emisor = :idCanal2
                    order by m.fecha_envio asc';

        $resultSet = $conn->executeQuery($sql, ['idCanal2' => $idCanal2, 'idCanal1' => $idCanal1]);
        return $resultSet->fetchAllAssociative();
    }
}
