<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Usuario>
 *
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function findOneByEmail(string $email): ?Usuario
    {
        return $this->findOneBy(['email' => $email]);
    }

    //Los videos de tu canal
    public function getUsuarioPorCanal(array $id_canal): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $idcanal = $id_canal["id_canal"];
        $sql = 'select u.* from apollo.usuario u
                    join apollo.canal c on c.id_usuario = u.id
                    where c.id = :id_canal';

        $resultSet = $conn->executeQuery($sql, ['id_canal' => $idcanal]);
        return $resultSet->fetchAllAssociative();
    }

}
