<?php

namespace Minsal\CitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CitCitasServiciodeapoyo
 *
 * @ORM\Table(name="cit_citas_serviciodeapoyo", indexes={@ORM\Index(name="fki_fos_user_user_reg_cit_citas_serviciodeapoyo", columns={"idusuarioreg"})})
 * @ORM\Entity
 */
class CitCitasServiciodeapoyo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cit_citas_serviciodeapoyo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var \Minsal\SeguimientoBundle\SecSolicitudestudios
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SeguimientoBundle\Entity\SecSolicitudestudios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_solicitudestudios", referencedColumnName="id")
     * })
     */
    private $idSolicitudestudios;

    /**
     * @var \Minsal\SiapsBundle\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuarioreg", referencedColumnName="id")
     * })
     */
    private $idusuarioreg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahorareg", type="datetime", nullable=true)
     */
    private $fechahorareg;

    /**
     * @var \Minsal\SeguimientoBundle\SecDetallesolicitudestudios
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SeguimientoBundle\Entity\SecDetallesolicitudestudios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_detallesolicitudestudios", referencedColumnName="id")
     * })
     */
    private $idDetallesolicitudestudios;



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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return CitCitasServiciodeapoyo
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set fechahorareg
     *
     * @param \DateTime $fechahorareg
     * @return CitCitasServiciodeapoyo
     */
    public function setFechahorareg($fechahorareg)
    {
        $this->fechahorareg = $fechahorareg;

        return $this;
    }

    /**
     * Get fechahorareg
     *
     * @return \DateTime
     */
    public function getFechahorareg()
    {
        return $this->fechahorareg;
    }

    /**
     * Set idSolicitudestudios
     *
     * @param \Minsal\SeguimientoBundle\Entity\SecSolicitudestudios $idSolicitudestudios
     * @return CitCitasServiciodeapoyo
     */
    public function setIdSolicitudestudios(\Minsal\SeguimientoBundle\Entity\SecSolicitudestudios $idSolicitudestudios = null)
    {
        $this->idSolicitudestudios = $idSolicitudestudios;

        return $this;
    }

    /**
     * Get idSolicitudestudios
     *
     * @return \Minsal\SeguimientoBundle\Entity\SecSolicitudestudios
     */
    public function getIdSolicitudestudios()
    {
        return $this->idSolicitudestudios;
    }

    /**
     * Set idusuarioreg
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuarioreg
     * @return CitCitasServiciodeapoyo
     */
    public function setIdusuarioreg(\Application\Sonata\UserBundle\Entity\User $idusuarioreg = null)
    {
        $this->idusuarioreg = $idusuarioreg;

        return $this;
    }

    /**
     * Get idusuarioreg
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdusuarioreg()
    {
        return $this->idusuarioreg;
    }

    /**
     * Set idDetallesolicitudestudios
     *
     * @param \Minsal\SeguimientoBundle\Entity\SecDetallesolicitudestudios $idDetallesolicitudestudios
     * @return CitCitasServiciodeapoyo
     */
    public function setIdDetallesolicitudestudios(\Minsal\SeguimientoBundle\Entity\SecDetallesolicitudestudios $idDetallesolicitudestudios = null)
    {
        $this->idDetallesolicitudestudios = $idDetallesolicitudestudios;

        return $this;
    }

    /**
     * Get idDetallesolicitudestudios
     *
     * @return \Minsal\SeguimientoBundle\Entity\SecDetallesolicitudestudios
     */
    public function getIdDetallesolicitudestudios()
    {
        return $this->idDetallesolicitudestudios;
    }
}
