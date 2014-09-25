<?php

namespace Minsal\SeguimientoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SecIngreso
 *
 * @ORM\Table(name="sec_emergencia")
 * @ORM\Entity
 */
class SecEmergencia {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sec_emergencia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_emergencia", type="string", length=15, nullable=false)
     * @Assert\NotBlank()
     */
    private $numeroEmergencia;

    /**
     * @var \Minsal\SiapsBundle\MntPaciente
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntPaciente",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_paciente", referencedColumnName="id")
     * })
     */
    private $idPaciente;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio_emergencia", type="integer")
     */
    private $anioEmergencia;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario_registra", referencedColumnName="id",nullable=false)
     * })
     */
    private $idUsuarioRegistra;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario_modifica", referencedColumnName="id",nullable=false)
     * })
     */
    private $idUsuarioModifica;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registra", type="datetime")
     */
    private $fechaRegistra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modifica", type="datetime")
     */
    private $fechaModifica;


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
     * Set numeroEmergencia
     *
     * @param string $numeroEmergencia
     * @return SecEmergencia
     */
    public function setNumeroEmergencia($numeroEmergencia)
    {
        $this->numeroEmergencia = $numeroEmergencia;

        return $this;
    }

    /**
     * Get numeroEmergencia
     *
     * @return string 
     */
    public function getNumeroEmergencia()
    {
        return $this->numeroEmergencia;
    }

    /**
     * Set anioEmergencia
     *
     * @param integer $anioEmergencia
     * @return SecEmergencia
     */
    public function setAnioEmergencia($anioEmergencia)
    {
        $this->anioEmergencia = $anioEmergencia;

        return $this;
    }

    /**
     * Get anioEmergencia
     *
     * @return integer 
     */
    public function getAnioEmergencia()
    {
        return $this->anioEmergencia;
    }

    /**
     * Set fechaRegistra
     *
     * @param \DateTime $fechaRegistra
     * @return SecEmergencia
     */
    public function setFechaRegistra($fechaRegistra)
    {
        $this->fechaRegistra = $fechaRegistra;

        return $this;
    }

    /**
     * Get fechaRegistra
     *
     * @return \DateTime 
     */
    public function getFechaRegistra()
    {
        return $this->fechaRegistra;
    }

    /**
     * Set fechaModifica
     *
     * @param \DateTime $fechaModifica
     * @return SecEmergencia
     */
    public function setFechaModifica($fechaModifica)
    {
        $this->fechaModifica = $fechaModifica;

        return $this;
    }

    /**
     * Get fechaModifica
     *
     * @return \DateTime 
     */
    public function getFechaModifica()
    {
        return $this->fechaModifica;
    }

    /**
     * Set idPaciente
     *
     * @param \Minsal\SiapsBundle\Entity\MntPaciente $idPaciente
     * @return SecEmergencia
     */
    public function setIdPaciente(\Minsal\SiapsBundle\Entity\MntPaciente $idPaciente = null)
    {
        $this->idPaciente = $idPaciente;

        return $this;
    }

    /**
     * Get idPaciente
     *
     * @return \Minsal\SiapsBundle\Entity\MntPaciente 
     */
    public function getIdPaciente()
    {
        return $this->idPaciente;
    }

    /**
     * Set idUsuarioRegistra
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idUsuarioRegistra
     * @return SecEmergencia
     */
    public function setIdUsuarioRegistra(\Application\Sonata\UserBundle\Entity\User $idUsuarioRegistra)
    {
        $this->idUsuarioRegistra = $idUsuarioRegistra;

        return $this;
    }

    /**
     * Get idUsuarioRegistra
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getIdUsuarioRegistra()
    {
        return $this->idUsuarioRegistra;
    }

    /**
     * Set idUsuarioModifica
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idUsuarioModifica
     * @return SecEmergencia
     */
    public function setIdUsuarioModifica(\Application\Sonata\UserBundle\Entity\User $idUsuarioModifica)
    {
        $this->idUsuarioModifica = $idUsuarioModifica;

        return $this;
    }

    /**
     * Get idUsuarioModifica
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getIdUsuarioModifica()
    {
        return $this->idUsuarioModifica;
    }
}
