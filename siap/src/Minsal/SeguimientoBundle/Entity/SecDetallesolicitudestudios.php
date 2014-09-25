<?php

namespace Minsal\SeguimientoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SecDetallesolicitudestudios
 *
 * @ORM\Table(name="sec_detallesolicitudestudios")
 * @ORM\Entity
 */
class SecDetallesolicitudestudios {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sec_detallesolicitudestudios_iddetallesolicitud_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \SecSolicitudestudios
     *
     * @ORM\ManyToOne(targetEntity="SecSolicitudestudios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_solicitudestudios", referencedColumnName="id")
     * })
     */
    private $idSolicitudestudios;

    /**
     * @var string
     *
     * @ORM\Column(name="id_examenes", type="string", length=8, nullable=true)
     */
    private $idExamenes;

    /**
     * @var string
     *
     * @ORM\Column(name="indicacion", type="string", length=250, nullable=true)
     */
    private $indicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_detalle", type="string", length=2, nullable=true)
     */
    private $estadoDetalle;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipomuestra", type="integer", nullable=true)
     */
    private $idTipomuestra;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_origenmuestra", type="integer", nullable=true)
     */
    private $idOrigenmuestra;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=250, nullable=true)
     */
    private $observacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_examenxestablecimiento", type="integer", nullable=true)
     */
    private $idExamenxestablecimiento;

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
     * Set idExamenes
     *
     * @param string $idExamenes
     * @return SecDetallesolicitudestudios
     */
    public function setIdExamenes($idExamenes)
    {
        $this->idExamenes = $idExamenes;

        return $this;
    }

    /**
     * Get idExamenes
     *
     * @return string 
     */
    public function getIdExamenes()
    {
        return $this->idExamenes;
    }

    /**
     * Set indicacion
     *
     * @param string $indicacion
     * @return SecDetallesolicitudestudios
     */
    public function setIndicacion($indicacion)
    {
        $this->indicacion = $indicacion;

        return $this;
    }

    /**
     * Get indicacion
     *
     * @return string 
     */
    public function getIndicacion()
    {
        return $this->indicacion;
    }

    /**
     * Set estadoDetalle
     *
     * @param string $estadoDetalle
     * @return SecDetallesolicitudestudios
     */
    public function setEstadoDetalle($estadoDetalle)
    {
        $this->estadoDetalle = $estadoDetalle;

        return $this;
    }

    /**
     * Get estadoDetalle
     *
     * @return string 
     */
    public function getEstadoDetalle()
    {
        return $this->estadoDetalle;
    }

    /**
     * Set idTipomuestra
     *
     * @param integer $idTipomuestra
     * @return SecDetallesolicitudestudios
     */
    public function setIdTipomuestra($idTipomuestra)
    {
        $this->idTipomuestra = $idTipomuestra;

        return $this;
    }

    /**
     * Get idTipomuestra
     *
     * @return integer 
     */
    public function getIdTipomuestra()
    {
        return $this->idTipomuestra;
    }

    /**
     * Set idOrigenmuestra
     *
     * @param integer $idOrigenmuestra
     * @return SecDetallesolicitudestudios
     */
    public function setIdOrigenmuestra($idOrigenmuestra)
    {
        $this->idOrigenmuestra = $idOrigenmuestra;

        return $this;
    }

    /**
     * Get idOrigenmuestra
     *
     * @return integer 
     */
    public function getIdOrigenmuestra()
    {
        return $this->idOrigenmuestra;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return SecDetallesolicitudestudios
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set idExamenxestablecimiento
     *
     * @param integer $idExamenxestablecimiento
     * @return SecDetallesolicitudestudios
     */
    public function setIdExamenxestablecimiento($idExamenxestablecimiento)
    {
        $this->idExamenxestablecimiento = $idExamenxestablecimiento;

        return $this;
    }

    /**
     * Get idExamenxestablecimiento
     *
     * @return integer 
     */
    public function getIdExamenxestablecimiento()
    {
        return $this->idExamenxestablecimiento;
    }

    /**
     * Set idSolicitudestudios
     *
     * @param \Minsal\SeguimientoBundle\Entity\SecSolicitudestudios $idSolicitudestudios
     * @return SecDetallesolicitudestudios
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
}
