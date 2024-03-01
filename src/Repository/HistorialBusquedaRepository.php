<?php

namespace App\Repository;

use App\Entity\HistorialBusqueda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistorialBusqueda>
 *
 * @method HistorialBusqueda|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistorialBusqueda|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistorialBusqueda[]    findAll()
 * @method HistorialBusqueda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class HistorialBusquedaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistorialBusqueda::class);
    }

    //Listar busquedas por id_usuario
    public function getHistorialPorId(array $id): array{
        $conn = $this->getEntityManager()->getConnection();
        $idTipoCategoria = $id["id"];
        $sql = 'select h.* from apollo.historial_busqueda h where h.id_usuario = :id;';

        $resultSet = $conn->executeQuery($sql, ['id' => $idTipoCategoria]);
        return $resultSet->fetchAllAssociative();
    }


}
