<?php
/**
 * (c) Ismael Tienda <i.trascastro@gmail.com>
 *
 * @link        http://www.ismaeltrascastro.com
 * @copyright   Copyright (c) Ismael Tienda. (http://www.ismaeltrascastro.com)
 * @license     MIT License - http://en.wikipedia.org/wiki/MIT_License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tienda\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="Tienda\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="upated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Propiedad creada para relacionar la entidad Usuario con Comentario
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comentario", mappedBy="usuario", cascade={"remove"} )
     */
    private $comentario;

    /**
     * Propiedad creada para relacionar la entidad User con Pedido
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Carrito", mappedBy="usuario", cascade={"remove"})
     */
    private $carrito;

    /**
     * Propiedad creada para relacionar la entidad User con Pedido
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CarritoCopia", mappedBy="usuario", cascade={"remove"})
     */
    private $carritoCopia;

    public function __construct()
    {
        parent::__construct();

        $this->createdAt    = new \DateTime();
        $this->updatedAt    = $this->createdAt;
        $this->carrito = new ArrayCollection();
        $this->carritoCopia = new ArrayCollection();
    }

    public function setCreatedAt()
    {
        // never used
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
     * Set updatedAt
     *
     * @ORM\PreUpdate()
     *
     * @return User
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function __toString()
    {
        return $this->username;
    }


}