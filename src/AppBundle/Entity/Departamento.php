<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints As Assert;

/**
 * Departamento
 *
 * @ORM\Table(name="departamento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartamentoRepository")
 *@UniqueEntity(fields={"nDepartamento"}, message="This reference is taken")
 */
class Departamento
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
     * Entidad creada para relacionar tablas Departamento-Producto
     * @var
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="depts")
     */
    private $products;

    /**
     * @var string
     * @Assert\NotBlank(message="nDepartamento no puede ser nulo")
     * @ORM\Column(name="nDepartamento", type="string", length=45, unique=true)
     */
    private $nDepartamento;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=50, unique=true)
     */
    private $nombre;

    /**
     * Contructor para la propiedad relacionda
     * @param $products
     */
    public function __construct()
    {
       $this->products = new ArrayCollection();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set nDepartamento
     *
     * @param string $nDepartamento
     *
     * @return Departamento
     */
    public function setNDepartamento($nDepartamento)
    {
        $this->nDepartamento = $nDepartamento;

        return $this;
    }

    /**
     * Get nDepartamento
     *
     * @return string
     */
    public function getNDepartamento()
    {
        return $this->nDepartamento;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre();
    }


}

