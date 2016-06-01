<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carrito
 *
 * @ORM\Table(name="carrito")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarritoRepository")
 */
class Carrito
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Tienda\UserBundle\Entity\User", inversedBy="carrito")
     */
    private $usuario;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="carrito")
     */
    private $producto;

    /**
     * Carrito constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();

    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Carrito
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param mixed $producto
     */
    /*public function setProducto($producto)
    {
        $this->producto = $producto;
    }*/

    /**
     * @param Producto $producto
     */
    public function setProducto(\AppBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;
    }

}

