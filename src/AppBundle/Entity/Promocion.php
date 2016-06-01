<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Producto;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Promocion
 *
 * @ORM\Table(name="promocion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromocionRepository")
 */
class Promocion
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
     * Entidad creada para relacionar Promocion - Producto
     * @ORM\OneToOne(targetEntity="Producto")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     * @var
     */
    private $product;

    /**
     * @var int
     *
     * @ORM\Column(name="descuento_porc", type="integer")
     */
    private $descuentoPorc;

    /**
     * @var datetime
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime
     * @ORM\Column(name="fecha_actulaizacion", type="datetime")
     */
    private $updatedAt;

    private $precio = Producto::class;

    /**
     * Promocion constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;

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
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getDescuentoPorc()
    {
        return $this->descuentoPorc;
    }

    /**
     * @param int $descuentoPorc
     */
    public function setDescuentoPorc($descuentoPorc)
    {
        $this->descuentoPorc = $descuentoPorc;
    }

}

