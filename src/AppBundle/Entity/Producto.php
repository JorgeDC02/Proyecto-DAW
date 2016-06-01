<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
 */
class Producto
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
     * Propiedad creada para relacionar tablas Producto-Marca
     * @var string
     * @ORM\ManyToOne(targetEntity="Marca", inversedBy="productos")
     * @ORM\JoinColumn(name="marcas_id", referencedColumnName="id")
     */
    private $marcas;

    /**
     * Propiedad creada para relacionar Producto-Departamento
     * @var string
     * @ORM\ManyToOne(targetEntity="Departamento", inversedBy="products")
     * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     */
    private $depts;

    /**
     * Propiedad creada para relacionar con la entidad Promocion
     * @ORM\OneToOne(targetEntity="Promocion")
     */
    //private $promo;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Comentario" , mappedBy="producto")
     */
    private $comentario;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=45, unique=true)
     */
    private $ref;

    /**
     * @var decimal
     *
     * @ORM\Column(name="precio", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $precio;

    /**
     * @var int
     *
     * @ORM\Column(name="valoracion", type="integer")
     */
    private $valoracion = 0;


    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=45)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_producto", type="string", length=45)
     */
    private $tipoProducto;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=200)
     */
    private $descripcion;


    /**
     * @var boolean
     *
     * @ORM\Column(name="novedad", type="boolean")
     */
    private $novedad;

    /**
     * Propiedad creada para relacionar con la entidad Image
     *
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="imagen_id", referencedColumnName="id")
     */
    private $urlImagen;

    /**
     * @var string
     *
     * @ORM\Column(name="urlImagen2", type="string", length=255, nullable=true, unique=true)
     */
    //private $urlImagen2;

    /**
     * @var string
     *
     * @ORM\Column(name="urlImagen3", type="string", length=255, nullable=true, unique=true)
     */
    //private $urlImagen3;

    /**
     * @var \DateTime
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * Propiedad creada para relacionar la entidad Producto con Producto_pedido
     * @ORM\OneToMany(targetEntity="Carrito", mappedBy="producto")
     */
    private $carrito;

    /**
     * Propiedad creada para relacionar la entidad Producto con Producto_pedido
     * @ORM\OneToMany(targetEntity="CarritoCopia", mappedBy="producto")
     */
    private $carritoCopia;

    /**
     * @var int
     */
    private $puntosMax = 0;


    /**
     *
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
        $this->carrito = new ArrayCollection();
        $this->carritoCopia = new ArrayCollection();
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
     * Set ref
     *
     * @param string $ref
     *
     * @return Producto
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return Producto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @return int
     */
   /* public function getPuntosMax()
    {
        return $this->puntosMax;
    }*/

    /**
     * @param int $puntosMax
     */
    /*public function setPuntosMax($puntosMax)
    {
        $this->puntosMax = $this->puntosMax+$puntosMax;
    }*/

    /**
     * Set valoracion
     *
     * @param integer $valoracion
     *
     * @return Producto
     */
    public function setValoracion($valoracion)
    {
        $this->valoracion = $this->valoracion+$valoracion;
        //$this->valoracion = ($this->valoracion+$valoracion)/$this->puntosMax*10;
        //$this->valoracion = $this->puntosMax;
        //$this->puntosMax = $this->puntosMax+5;
        //return ($this->valoracion/$this->puntosMax)*10;
        //return (($this->valoracion)/($this->puntosMax))*10;
        return $this;
    }

    /**
     * Get valoracion
     *
     * @return int
     */
    public function getValoracion()
    {
        return $this->valoracion;
    }

    /**
     * @return string
     */
    public function getMarcas()
    {
        return $this->marcas;
    }

    /**
     * @param string $marcas
     */
    public function setMarcas($marcas)
    {
        $this->marcas = $marcas;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     *
     * @return Producto
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set tipoProducto
     *
     * @param string $tipoProducto
     *
     * @return Producto
     */
    public function setTipoProducto($tipoProducto)
    {
        $this->tipoProducto = $tipoProducto;
        return $this;
    }

    /**
     * Get tipoProducto
     *
     * @return string
     */
    public function getTipoProducto()
    {
        return $this->tipoProducto;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @return boolean
     */
    public function isnovedad()
    {
        return $this->novedad;
    }

    /**
     * @param boolean $novedad
     */
    public function setnovedad($novedad)
    {
        $this->novedad = $novedad;
    }

    /**
     * @return string
     */
    public function getDepts()
    {
        return $this->depts;
    }

    /**
     * @param string $depts
     */
    public function setDepts($depts)
    {
        $this->depts = $depts;
    }

    /**
     * @return mixed
     */
    public function getUrlImagen()
    {
        return $this->urlImagen;
    }

    /**
     * @param mixed $urlImagen
     */
    public function setUrlImagen($urlImagen)
    {
        $this->urlImagen = $urlImagen;
    }

    /**
     * Set urlImagen2
     *
     * @param string $urlImagen2
     *
     * @return Producto
     */
    public function setUrlImagen2($urlImagen2)
    {
        $this->urlImagen2 = $urlImagen2;

        return $this;
    }

    /**
     * Get urlImagen2
     *
     * @return string
     */
    public function getUrlImagen2()
    {
        return $this->urlImagen2;
    }

    /**
     * Set urlImagen3
     *
     * @param string $urlImagen3
     *
     * @return Producto
     */
    public function setUrlImagen3($urlImagen3)
    {
        $this->urlImagen3 = $urlImagen3;

        return $this;
    }

    /**
     * Get urlImagen3
     *
     * @return string
     */
    public function getUrlImagen3()
    {
        return $this->urlImagen3;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getId();
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

}

