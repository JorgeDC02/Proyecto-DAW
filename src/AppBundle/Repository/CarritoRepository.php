<?php

namespace AppBundle\Repository;

/**
 * CarritoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CarritoRepository extends \Doctrine\ORM\EntityRepository
{
    public function queryPedidoByUserId($id)
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
        return $this->queryPedidoByUserId($id)->execute();
    }

    public function queryListaProductoByUserId($id)
    {
        return $this->createQueryBuilder('p')
            ->select('producto.tipoProducto','producto.precio', 'marcas.nMarca','producto.modelo', 'p.id AS carrito_id','urlImagen.imageName')
            ->leftJoin('p.producto','producto')
            ->leftJoin('p.usuario','usuario')
            ->leftJoin('producto.marcas','marcas')
            ->leftJoin('producto.urlImagen', 'urlImagen')
            ->andWhere('usuario.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->execute()
            ;
    }

    public function listaProductoByUserId($id)
    {
        return $this->queryListaProductoByUserId($id)->execute();
    }
}