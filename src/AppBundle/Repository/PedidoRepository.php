<?php

namespace AppBundle\Repository;

/**
 * PedidoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PedidoRepository extends \Doctrine\ORM\EntityRepository
{
    public function queryPedidoById($id)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id) id')
            //->select('p.createdAt')
            ->leftJoin('p.usuario', 'usuario')
            ->andWhere('usuario.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->execute()
            ;
    }

    public function pedidoById($id)
    {
        return $this->queryPedidoById($id)->execute();
    }

    public function queryAllPedidoByUserId($id)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id AS id', 'p.createdAt', 'usuario.username')
            ->leftJoin('p.usuario','usuario')
            ->andWhere('usuario.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->execute()
            ;
    }

    public function allQueryPedidoByUserId($id)
    {
        return $this->queryAllPedidoByUserId($id)->execute();
    }
}
