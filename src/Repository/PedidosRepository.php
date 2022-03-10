<?php

namespace App\Repository;

use App\Entity\Pedidos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

/**
 * @method Pedidos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pedidos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pedidos[]    findAll()
 * @method Pedidos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pedidos::class);
    }

    public function buscarPedidos(){

    $sql = "
        SELECT a.id,a.cliente_seccion, count(a.cantidad_pedido) as cantidad_pedido, b.name, 
        b.precio, b.imagen,c.desc_tallas, d.desc_color
        FROM pedidos a
        INNER JOIN product b on a.product_pedido = b.id
        INNER JOIN tallas c on a.talla_pedido = c.id
        INNER JOIN color d on a.color_pedido = d.id
        GROUP BY a.cliente_seccion, a.product_pedido, a.talla_pedido, a.color_pedido
        ";
    
    $conn = $this->getEntityManager()->getConnection();
    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery();

    return $resultSet->fetchAllAssociative();

    }

    // /**
    //  * @return Pedidos[] Returns an array of Pedidos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pedidos
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
