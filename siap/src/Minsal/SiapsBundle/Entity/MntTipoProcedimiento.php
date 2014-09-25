<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MntTipoEmpleado
 *
 * @ORM\Table(name="mnt_tipo_procedimiento")
 * @ORM\Entity
 */
class MntTipoProcedimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="mnt_tipo_empleado_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=10, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50, nullable=true)
     */
    private $descripción;

   

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return MntTipoProcedimiento
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripción
     *
     * @param string $descripción
     * @return MntTipoProcedimiento
     */
    public function setDescripción($descripción)
    {
        $this->descripción = $descripción;

        return $this;
    }

    /**
     * Get descripción
     *
     * @return string 
     */
    public function getDescripción()
    {
        return $this->descripción;
    }
    
    public function __toString() {
        return $this->nombre?:'';
    }
}
