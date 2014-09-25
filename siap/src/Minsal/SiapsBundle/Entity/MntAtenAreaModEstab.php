<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MntAtenAreaModEstab
 *
 * @ORM\Table(name="mnt_aten_area_mod_estab")
 * @ORM\Entity(repositoryClass="Minsal\SiapsBundle\Repositorio\MntAtenAreaModEstabRepository")
 */
class MntAtenAreaModEstab {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="mnt_aten_area_mod_estab_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \MntAreaModEstab
     *
     * @ORM\ManyToOne(targetEntity="MntAreaModEstab")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_area_mod_estab", referencedColumnName="id")
     * })
     */
    private $idAreaModEstab;

    /**
     * @var \CtlAtencion
     *
     * @ORM\ManyToOne(targetEntity="CtlAtencion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_atencion", referencedColumnName="id")
     * })
     */
    private $idAtencion;

    /**
     * @var \CtlEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="CtlEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_establecimiento", referencedColumnName="id")
     * })
     */
    private $idEstablecimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_ambiente", type="string", length=80)
     */
    private $nombreAmbiente;

    /**
     * @var \MntAmbienteIndependiente
     *
     * @ORM\ManyToOne(targetEntity="MntAmbienteIndependiente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ambiente_independiente", referencedColumnName="id")
     * })
     */
    private $idAmbienteIndependiente;

    /**
     * @var string
     *
     * @ORM\Column(name="condicion", type="string", length=1)
     * 
     */
    private $condicion;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set idAreaModEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntAreaModEstab $idAreaModEstab
     * @return MntAtenAreaModEstab
     */
    public function setIdAreaModEstab(\Minsal\SiapsBundle\Entity\MntAreaModEstab $idAreaModEstab = null) {
        $this->idAreaModEstab = $idAreaModEstab;

        return $this;
    }

    /**
     * Get idAreaModEstab
     *
     * @return \Minsal\SiapsBundle\Entity\MntAreaModEstab 
     */
    public function getIdAreaModEstab() {
        return $this->idAreaModEstab;
    }

    /**
     * Set idAtencion
     *
     * @param \Minsal\SiapsBundle\Entity\CtlAtencion $idAtencion
     * @return MntAtenAreaModEstab
     */
    public function setIdAtencion(\Minsal\SiapsBundle\Entity\CtlAtencion $idAtencion = null) {
        $this->idAtencion = $idAtencion;

        return $this;
    }

    /**
     * Get idAtencion
     *
     * @return \Minsal\SiapsBundle\Entity\CtlAtencion 
     */
    public function getIdAtencion() {
        return $this->idAtencion;
    }

    /**
     * Set idEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento
     * @return MntAtenAreaModEstab
     */
    public function setIdEstablecimiento(\Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento = null) {
        $this->idEstablecimiento = $idEstablecimiento;

        return $this;
    }

    /**
     * Get idEstablecimiento
     *
     * @return \Minsal\SiapsBundle\Entity\CtlEstablecimiento 
     */
    public function getIdEstablecimiento() {
        return $this->idEstablecimiento;
    }

    /* Método __toString */

    public function __toString() {
        return $this->nombreAmbiente ? : '';
    }

    /* Método __toString */

    public function getNombreConsulta() {
        if (($this->idAreaModEstab->getIdServicioExternoEstab()))
            return $this->idAtencion->getNombre() . "-" . $this->idAreaModEstab->getIdServicioExternoEstab()->getIdServicioExterno()->getAbreviatura(). "-".$this->idAreaModEstab->getIdModalidadEstab()->getIdModalidad() ? : '';
        else
            return $this->idAtencion->getNombre() . "-".$this->idAreaModEstab->getIdModalidadEstab()->getIdModalidad() ? : '';
        
    }

    /**
     * Set nombreAmbiente
     *
     * @param string $nombreAmbiente
     * @return MntAtenAreaModEstab
     */
    public function setNombreAmbiente($nombreAmbiente) {
        $this->nombreAmbiente = $nombreAmbiente;

        return $this;
    }

    /**
     * Get nombreAmbiente
     *
     * @return string 
     */
    public function getNombreAmbiente() {
        return $this->nombreAmbiente;
    }

    /**
     * Set condicion
     *
     * @param string $condicion
     * @return MntAtenAreaModEstab
     */
    public function setCondicion($condicion) {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return string 
     */
    public function getCondicion() {
        return $this->condicion;
    }

    /**
     * Set idAmbienteIndependiente
     *
     * @param \Minsal\SiapsBundle\Entity\MntAmbienteIndependiente $idAmbienteIndependiente
     * @return MntAtenAreaModEstab
     */
    public function setIdAmbienteIndependiente(\Minsal\SiapsBundle\Entity\MntAmbienteIndependiente $idAmbienteIndependiente = null) {
        $this->idAmbienteIndependiente = $idAmbienteIndependiente;

        return $this;
    }

    /**
     * Get idAmbienteIndependiente
     *
     * @return \Minsal\SiapsBundle\Entity\MntAmbienteIndependiente 
     */
    public function getIdAmbienteIndependiente() {
        return $this->idAmbienteIndependiente;
    }

}
