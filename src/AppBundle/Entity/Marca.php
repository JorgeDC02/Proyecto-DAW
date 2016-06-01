<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Marca
 *
 * @ORM\Table(name="marca")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarcaRepository")
 */
class Marca
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
     * Entidad creada para relacionar tablas Marca-Producto
     * @var
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="marcas")
     */
    private $productos;

    /**
     * @var string
     *
     * @ORM\Column(name="nMarca", type="string", length=45, unique=true)
     */
    private $nMarca;

    /**
     * Marca constructor.
     * @param $productos
     */
    public function __construct()
    {
        $this->productos = new ArrayCollection();
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
     * @return string
     */
    public function getNMarca()
    {
        return $this->nMarca;
    }

    /**
     * @param string $nMarca
     */
    public function setNMarca($nMarca)
    {
        $this->nMarca = $nMarca;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNMarca();
    }

}

