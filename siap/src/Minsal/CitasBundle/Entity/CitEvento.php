<?php

namespace Minsal\CitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CitEvento
 *
 * @ORM\Table(name="cit_evento", indexes={@ORM\Index(name="fki_cit_tipoevento_cit_evento", columns={"id_tipoevento"}), @ORM\Index(name="fki_ctl_establecimiento_cit_evento", columns={"id_establecimiento"}), @ORM\Index(name="fki_fos_user_user_reg_cit_evento", columns={"idusuarioreg"}), @ORM\Index(name="fki_mnt_area_mod_estab_cit_evento", columns={"id_area_mod_estab"}), @ORM\Index(name="fki_mnt_ciq_cit_eventos", columns={"id_ciq_establecimiento"}), @ORM\Index(name="fki_mnt_rango_hora_cit_evento", columns={"id_rangohora"})})
 * @ORM\Entity
 */
class CitEvento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cit_evento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Minsal\SiapsBundle\MntEmpleado
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntEmpleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idempleado", referencedColumnName="id")
     * })
     */
    private $idempleado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaini", type="date", nullable=true)
     */
    private $fechaini;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaini", type="time", nullable=true)
     */
    private $horaini;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafin", type="date", nullable=true)
     */
    private $fechafin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horafin", type="time", nullable=true)
     */
    private $horafin;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=750, nullable=true)
     */
    private $descripcion;

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
     * @var \Minsal\SiapsBundle\MntProcedimientoEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntProcedimientoEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ciq_establecimiento", referencedColumnName="id")
     * })
     */
    private $idCiqEstablecimiento;

    /**
     * @var \Minsal\SiapsBundle\MntRangohora
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntRangohora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rangohora", referencedColumnName="id")
     * })
     */
    private $idRangohora;

    /**
     * @var integer
     *
     * @ORM\Column(name="dia_semana", type="smallint", nullable=true)
     */
    private $diaSemana;

    /**
     * @var \Minsal\SiapsBundle\MntAreaModEstab
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntAreaModEstab")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_area_mod_estab", referencedColumnName="id")
     * })
     */
    private $idAreaModEstab;

    /**
     * @var \Minsal\SiapsBundle\CtlEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\CtlEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_establecimiento", referencedColumnName="id")
     * })
     */
    private $idEstablecimiento;

    /**
     * @var \CitTipoevento
     *
     * @ORM\ManyToOne(targetEntity="CitTipoevento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipoevento", referencedColumnName="id")
     * })
     */
    private $idTipoevento;



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
     * Set fechaini
     *
     * @param \DateTime $fechaini
     * @return CitEvento
     */
    public function setFechaini($fechaini)
    {
        $this->fechaini = $fechaini;

        return $this;
    }

    /**
     * Get fechaini
     *
     * @return \DateTime
     */
    public function getFechaini()
    {
        return $this->fechaini;
    }

    /**
     * Set horaini
     *
     * @param \DateTime $horaini
     * @return CitEvento
     */
    public function setHoraini($horaini)
    {
        $this->horaini = $horaini;

        return $this;
    }

    /**
     * Get horaini
     *
     * @return \DateTime
     */
    public function getHoraini()
    {
        return $this->horaini;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     * @return CitEvento
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set horafin
     *
     * @param \DateTime $horafin
     * @return CitEvento
     */
    public function setHorafin($horafin)
    {
        $this->horafin = $horafin;

        return $this;
    }

    /**
     * Get horafin
     *
     * @return \DateTime
     */
    public function getHorafin()
    {
        return $this->horafin;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return CitEvento
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
     * Set fechahorareg
     *
     * @param \DateTime $fechahorareg
     * @return CitEvento
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
     * Set diaSemana
     *
     * @param integer $diaSemana
     * @return CitEvento
     */
    public function setDiaSemana($diaSemana)
    {
        $this->diaSemana = $diaSemana;

        return $this;
    }

    /**
     * Get diaSemana
     *
     * @return integer
     */
    public function getDiaSemana()
    {
        return $this->diaSemana;
    }

    /**
     * Set idempleado
     *
     * @param \Minsal\SiapsBundle\Entity\MntEmpleado $idempleado
     * @return CitEvento
     */
    public function setIdempleado(\Minsal\SiapsBundle\Entity\MntEmpleado $idempleado = null)
    {
        $this->idempleado = $idempleado;

        return $this;
    }

    /**
     * Get idempleado
     *
     * @return \Minsal\SiapsBundle\Entity\MntEmpleado
     */
    public function getIdempleado()
    {
        return $this->idempleado;
    }

    /**
     * Set idusuarioreg
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuarioreg
     * @return CitEvento
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
     * Set idCiqEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\MntProcedimientoEstablecimiento $idCiqEstablecimiento
     * @return CitEvento
     */
    public function setIdCiqEstablecimiento(\Minsal\SiapsBundle\Entity\MntProcedimientoEstablecimiento $idCiqEstablecimiento = null)
    {
        $this->idCiqEstablecimiento = $idCiqEstablecimiento;

        return $this;
    }

    /**
     * Get idCiqEstablecimiento
     *
     * @return \Minsal\SiapsBundle\Entity\MntProcedimientoEstablecimiento
     */
    public function getIdCiqEstablecimiento()
    {
        return $this->idCiqEstablecimiento;
    }

    /**
     * Set idRangohora
     *
     * @param \Minsal\SiapsBundle\Entity\MntRangohora $idRangohora
     * @return CitEvento
     */
    public function setIdRangohora(\Minsal\SiapsBundle\Entity\MntRangohora $idRangohora = null)
    {
        $this->idRangohora = $idRangohora;

        return $this;
    }

    /**
     * Get idRangohora
     *
     * @return \Minsal\SiapsBundle\Entity\MntRangohora
     */
    public function getIdRangohora()
    {
        return $this->idRangohora;
    }

    /**
     * Set idAreaModEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntAreaModEstab $idAreaModEstab
     * @return CitEvento
     */
    public function setIdAreaModEstab(\Minsal\SiapsBundle\Entity\MntAreaModEstab $idAreaModEstab = null)
    {
        $this->idAreaModEstab = $idAreaModEstab;

        return $this;
    }

    /**
     * Get idAreaModEstab
     *
     * @return \Minsal\SiapsBundle\Entity\MntAreaModEstab
     */
    public function getIdAreaModEstab()
    {
        return $this->idAreaModEstab;
    }

    /**
     * Set idEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento
     * @return CitEvento
     */
    public function setIdEstablecimiento(\Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento = null)
    {
        $this->idEstablecimiento = $idEstablecimiento;

        return $this;
    }

    /**
     * Get idEstablecimiento
     *
     * @return \Minsal\SiapsBundle\Entity\CtlEstablecimiento
     */
    public function getIdEstablecimiento()
    {
        return $this->idEstablecimiento;
    }

    /**
     * Set idTipoevento
     *
     * @param \Minsal\CitasBundle\Entity\CitTipoevento $idTipoevento
     * @return CitEvento
     */
    public function setIdTipoevento(\Minsal\CitasBundle\Entity\CitTipoevento $idTipoevento = null)
    {
        $this->idTipoevento = $idTipoevento;

        return $this;
    }

    /**
     * Get idTipoevento
     *
     * @return \Minsal\CitasBundle\Entity\CitTipoevento
     */
    public function getIdTipoevento()
    {
        return $this->idTipoevento;
    }
}
