<?php

namespace Minsal\CitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CitDistribucion
 *
 * @ORM\Table(name="cit_distribucion", indexes={@ORM\Index(name="fki_fos_user_user_cit_distribucion", columns={"idusuarioreg"}), @ORM\Index(name="fki_fos_user_user_mod_cit_distribucion", columns={"idusuariomod"}), @ORM\Index(name="fki_mnt_area_mod_estab_cit_distribucion", columns={"id_area_mod_estab"}), @ORM\Index(name="fki_mnt_consultorios_cit_distribucion", columns={"id_consultorio"}), @ORM\Index(name="fki_mnt_empleados_cit_distribucion", columns={"id_empleado"}), @ORM\Index(name="fki_mnt_rangohoras_cit_distribucion", columns={"id_rangohora"})})
 * @ORM\Entity
 */
class CitDistribucion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cit_distribucion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \Minsal\SiapsBundle\MntEmpleado
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntEmpleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_empleado", referencedColumnName="id")
     * })
     */
    private $idEmpleado;

    /**
     * @var integer
     *
     * @ORM\Column(name="primera", type="integer", nullable=true)
     */
    private $primera;

    /**
     * @var integer
     *
     * @ORM\Column(name="subsecuente", type="integer", nullable=true)
     */
    private $subsecuente;

    /**
     * @var integer
     *
     * @ORM\Column(name="mes", type="integer", nullable=true)
     */
    private $mes;

    /**
     * @var integer
     *
     * @ORM\Column(name="yrs", type="integer", nullable=true)
     */
    private $yrs;

    /**
     * @var integer
     *
     * @ORM\Column(name="dia", type="integer", nullable=true)
     */
    private $dia;

    /**
     * @var \Minsal\SiapsBundle\MntConsultorio
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntConsultorio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_consultorio", referencedColumnName="id")
     * })
     */
    private $idConsultorio = '0';

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
     * @var \Minsal\SiapsBundle\MntAtenAreaModEstab
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntAtenAreaModEstab")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_aten_area_mod_estab", referencedColumnName="id")
     * })
     */
    private $idAtenAreaModEstab;

    /**
     * @var \Minsal\SiapsBundle\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuariomod", referencedColumnName="id")
     * })
     */
    private $idusuariomod;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahoramod", type="datetime", nullable=true)
     */
    private $fechahoramod;

    /**
     * @var string
     *
     * @ORM\Column(name="tipocon", type="string", length=5, nullable=true)
     */
    private $tipocon;

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
     * @var string
     *
     * @ORM\Column(name="distribucionmed", type="string", length=6, nullable=true)
     */
    private $distribucionmed;



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
     * Set primera
     *
     * @param integer $primera
     * @return CitDistribucion
     */
    public function setPrimera($primera)
    {
        $this->primera = $primera;

        return $this;
    }

    /**
     * Get primera
     *
     * @return integer
     */
    public function getPrimera()
    {
        return $this->primera;
    }

    /**
     * Set subsecuente
     *
     * @param integer $subsecuente
     * @return CitDistribucion
     */
    public function setSubsecuente($subsecuente)
    {
        $this->subsecuente = $subsecuente;

        return $this;
    }

    /**
     * Get subsecuente
     *
     * @return integer
     */
    public function getSubsecuente()
    {
        return $this->subsecuente;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     * @return CitDistribucion
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set yrs
     *
     * @param integer $yrs
     * @return CitDistribucion
     */
    public function setYrs($yrs)
    {
        $this->yrs = $yrs;

        return $this;
    }

    /**
     * Get yrs
     *
     * @return integer
     */
    public function getYrs()
    {
        return $this->yrs;
    }

    /**
     * Set dia
     *
     * @param integer $dia
     * @return CitDistribucion
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return integer
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set fechahorareg
     *
     * @param \DateTime $fechahorareg
     * @return CitDistribucion
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
     * Set fechahoramod
     *
     * @param \DateTime $fechahoramod
     * @return CitDistribucion
     */
    public function setFechahoramod($fechahoramod)
    {
        $this->fechahoramod = $fechahoramod;

        return $this;
    }

    /**
     * Get fechahoramod
     *
     * @return \DateTime
     */
    public function getFechahoramod()
    {
        return $this->fechahoramod;
    }

    /**
     * Set tipocon
     *
     * @param string $tipocon
     * @return CitDistribucion
     */
    public function setTipocon($tipocon)
    {
        $this->tipocon = $tipocon;

        return $this;
    }

    /**
     * Get tipocon
     *
     * @return string
     */
    public function getTipocon()
    {
        return $this->tipocon;
    }

    /**
     * Set distribucionmed
     *
     * @param string $distribucionmed
     * @return CitDistribucion
     */
    public function setDistribucionmed($distribucionmed)
    {
        $this->distribucionmed = $distribucionmed;

        return $this;
    }

    /**
     * Get distribucionmed
     *
     * @return string
     */
    public function getDistribucionmed()
    {
        return $this->distribucionmed;
    }

    /**
     * Set idRangohora
     *
     * @param \Minsal\SiapsBundle\Entity\MntRangohora $idRangohora
     * @return CitDistribucion
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
     * Set idEmpleado
     *
     * @param \Minsal\SiapsBundle\Entity\MntEmpleado $idEmpleado
     * @return CitDistribucion
     */
    public function setIdEmpleado(\Minsal\SiapsBundle\Entity\MntEmpleado $idEmpleado = null)
    {
        $this->idEmpleado = $idEmpleado;

        return $this;
    }

    /**
     * Get idEmpleado
     *
     * @return \Minsal\SiapsBundle\Entity\MntEmpleado
     */
    public function getIdEmpleado()
    {
        return $this->idEmpleado;
    }

    /**
     * Set idConsultorio
     *
     * @param \Minsal\SiapsBundle\Entity\MntConsultorio $idConsultorio
     * @return CitDistribucion
     */
    public function setIdConsultorio(\Minsal\SiapsBundle\Entity\MntConsultorio $idConsultorio = null)
    {
        $this->idConsultorio = $idConsultorio;

        return $this;
    }

    /**
     * Get idConsultorio
     *
     * @return \Minsal\SiapsBundle\Entity\MntConsultorio
     */
    public function getIdConsultorio()
    {
        return $this->idConsultorio;
    }

    /**
     * Set idusuarioreg
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuarioreg
     * @return CitDistribucion
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
     * Set idAtenAreaModEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $idAtenAreaModEstab
     * @return CitDistribucion
     */
    public function setIdAtenAreaModEstab(\Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $idAtenAreaModEstab = null)
    {
        $this->idAtenAreaModEstab = $idAtenAreaModEstab;

        return $this;
    }

    /**
     * Get idAtenAreaModEstab
     *
     * @return \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab
     */
    public function getIdAtenAreaModEstab()
    {
        return $this->idAtenAreaModEstab;
    }

    /**
     * Set idusuariomod
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuariomod
     * @return CitDistribucion
     */
    public function setIdusuariomod(\Application\Sonata\UserBundle\Entity\User $idusuariomod = null)
    {
        $this->idusuariomod = $idusuariomod;

        return $this;
    }

    /**
     * Get idusuariomod
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdusuariomod()
    {
        return $this->idusuariomod;
    }

    /**
     * Set idAreaModEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntAreaModEstab $idAreaModEstab
     * @return CitDistribucion
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
}
