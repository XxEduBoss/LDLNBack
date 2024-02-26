<?php

namespace App\Repository;

use App\Entity\Canal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Canal>
 *
 * @method Canal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Canal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Canal[]    findAll()
 * @method Canal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CanalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Canal::class);
    }

    //Los canales en funcion de su nombre
    public function getCanalesPorNombre($canal) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
            ->from($this->getEntityName(), 'c')
            ->where("UPPER(c.nombre_canal) LIKE '%$canal%'")
            ->orWhere("LOWER(c.nombre_canal) LIKE '%$canal%'");

        return $qb->getQuery()->getResult();
    }


    //Número de suscriptores por canal
    public function getNumSuscriptoresPorCanal(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idTipoCategoria = $id["id"];
        $sql = 'select count(s.id_usuario) as suscriptores from apollo.suscripcion s where s.id_canal = :id';

        $resultSet = $conn->executeQuery($sql, ['id' => $idTipoCategoria]);
        return $resultSet->fetchAllAssociative();
    }

    //Etiquetas de cada canal
    public function getEtiquetasPorCanal(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idTipoCategoria = $id["id"];
        $sql = 'select e.descripcion from apollo.canal c
                join apollo.etiquetas_canal ec on c.id = ec.id_canal
                join apollo.etiquetas e on ec.id_etiqueta = e.id
                     where c.id = :id';

        $resultSet = $conn->executeQuery($sql, ['id' => $idTipoCategoria]);
        return $resultSet->fetchAllAssociative();
    }

    //Videos por canal
    public function getVideosPorCanal(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idTipoCategoria = $id["id"];
        $sql = 'select v.* from apollo.video v
                join apollo.canal c on v.id_canal = c.id
                    where c.id = :id
                    group by v.id';

        $resultSet = $conn->executeQuery($sql, ['id' => $idTipoCategoria]);
        return $resultSet->fetchAllAssociative();
    }

    //Sucriptores por canal
    public function getSuscriptoresPorCanal(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idTipoCategoria = $id["id"];
        $sql = 'select u.username as Usuario from apollo.usuario u
                join apollo.suscripcion s on u.id = s.id_usuario
                join apollo.canal c on s.id_canal = c.id
                    where c.id = :id';

        $resultSet = $conn->executeQuery($sql, ['id' => $idTipoCategoria]);
        return $resultSet->fetchAllAssociative();
    }

    public function getCanalPorUsuario(array $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'select c.* from apollo.canal c
                    where c.id_usuario = :id';

        $resultSet = $conn->executeQuery($sql, $id);
        return $resultSet->fetchAllAssociative();
    }

    public function getCanalPorUsername(array $username): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'select c.* from apollo.canal c
                join apollo.usuario u on u.id = c.id_usuario
                    where u.username = :username';

        $resultSet = $conn->executeQuery($sql, $username);
        return $resultSet->fetchAllAssociative();
    }

    public function getSubcriptoresCanal(array $id_canal): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idCanal = $id_canal["id_canal"];
        $sql = 'select s.id_usuario from apollo.suscripcion s
                    where s.id_canal = :idCanal';

        $resultSet = $conn->executeQuery($sql, ['idCanal' => $idCanal]);
        return $resultSet->fetchAllAssociative();
    }

    public function getCanalBuscador(array $datos): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $text = '%'.$datos["texto"].'%';
        $sql = 'select c.*from apollo.canal c 
                where c.nombre_canal ilike :texto group by c.id;';

        $resultSet = $conn->executeQuery($sql, ['texto' => $text]);
        return $resultSet->fetchAllAssociative();
    }

}
