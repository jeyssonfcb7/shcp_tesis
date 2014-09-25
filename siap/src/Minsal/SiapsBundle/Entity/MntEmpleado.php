<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MntEmpleado
 *
 * @ORM\Table(name="mnt_empleado")
 * @ORM\Entity
 */
class MntEmpleado {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="mnt_empleado_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100, nullable=false)
     */
    private $apellido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="dui", type="string", length=12, nullable=true)
     */
    private $dui;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_junta_vigilancia", type="string", length=20, nullable=true)
     */
    private $numeroJuntaVigilancia;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_celular", type="string", length=10, nullable=true)
     */
    private $numeroCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="correo_electronico", type="string", length=50, nullable=true)
     */
    private $correoElectronico;

    /**
     * @var integer
     *
     * @ORM\Column(name="correlativo", type="smallint", nullable=true)
     */
    private $correlativo;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_farmacia", type="string", length=6, nullable=true)
     */
    private $codigoFarmacia;

    /**
     * @var string
     *
     * @ORM\Column(name="habilitado_farmacia", type="string", nullable=true)
     */
    private $habilitadoFarmacia;

    /**
     * @var string
     *
     * @ORM\Column(name="firma_digital", type="text", nullable=true)
     */
    private $firmaDigital;

    /**
     * @var \MntCargoEmpleado
     *
     * @ORM\ManyToOne(targetEntity="MntCargoEmpleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cargo_empleado", referencedColumnName="id")
     * })
     */
    private $idCargoEmpleado;

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
     * @var \MntTipoEmpleado
     *
     * @ORM\ManyToOne(targetEntity="MntTipoEmpleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_empleado", referencedColumnName="id")
     * })
     */
    private $idTipoEmpleado;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuarioreg", referencedColumnName="id")
     * })
     */
    private $idusuarioreg;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
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
     * @ORM\Column(name="fechahorareg", type="datetime")
     */
    private $fechahorareg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahoramod", type="datetime")
     */
    private $fechahoramod;

     /**
     * @var string
     *
     * @ORM\Column(name="nombreempleado", type="string", length=200)
     */
    private $nombreempleado;


    /**
     * @ORM\ManyToMany(targetEntity="MntAtenAreaModEstab")
     * @ORM\JoinTable(name="mnt_empleado_especialidad_estab",
     *      joinColumns={@ORM\JoinColumn(name="id_empleado", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_aten_area_mod_estab", referencedColumnName="id")}
     *      )
     */
    private $especialidadesEstab;

     /**
     * @ORM\ManyToMany(targetEntity="CtlAtencion")
     * @ORM\JoinTable(name="mnt_empleado_especialidad",
     *      joinColumns={@ORM\JoinColumn(name="id_empleado", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_atencion", referencedColumnName="id")}
     *      )
     */
    private $especialidadesMedico;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="habilitado", type="boolean", nullable=false)
     */
    private $habilitado;

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
     * @return MntEmpleado
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
     * Set apellido
     *
     * @param string $apellido
     * @return MntEmpleado
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return MntEmpleado
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set dui
     *
     * @param string $dui
     * @return MntEmpleado
     */
    public function setDui($dui)
    {
        $this->dui = $dui;

        return $this;
    }

    /**
     * Get dui
     *
     * @return string
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * Set numeroJuntaVigilancia
     *
     * @param string $numeroJuntaVigilancia
     * @return MntEmpleado
     */
    public function setNumeroJuntaVigilancia($numeroJuntaVigilancia)
    {
        $this->numeroJuntaVigilancia = $numeroJuntaVigilancia;

        return $this;
    }

    /**
     * Get numeroJuntaVigilancia
     *
     * @return string
     */
    public function getNumeroJuntaVigilancia()
    {
        return $this->numeroJuntaVigilancia;
    }

    /**
     * Set numeroCelular
     *
     * @param string $numeroCelular
     * @return MntEmpleado
     */
    public function setNumeroCelular($numeroCelular)
    {
        $this->numeroCelular = $numeroCelular;

        return $this;
    }

    /**
     * Get numeroCelular
     *
     * @return string
     */
    public function getNumeroCelular()
    {
        return $this->numeroCelular;
    }

    /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     * @return MntEmpleado
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    /**
     * Set correlativo
     *
     * @param integer $correlativo
     * @return MntEmpleado
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * Get correlativo
     *
     * @return integer
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    /**
     * Set codigoFarmacia
     *
     * @param string $codigoFarmacia
     * @return MntEmpleado
     */
    public function setCodigoFarmacia($codigoFarmacia)
    {
        $this->codigoFarmacia = $codigoFarmacia;

        return $this;
    }

    /**
     * Get codigoFarmacia
     *
     * @return string
     */
    public function getCodigoFarmacia()
    {
        return $this->codigoFarmacia;
    }

    /**
     * Set habilitadoFarmacia
     *
     * @param string $habilitadoFarmacia
     * @return MntEmpleado
     */
    public function setHabilitadoFarmacia($habilitadoFarmacia)
    {
        $this->habilitadoFarmacia = $habilitadoFarmacia;

        return $this;
    }

    /**
     * Get habilitadoFarmacia
     *
     * @return string
     */
    public function getHabilitadoFarmacia()
    {
        return $this->habilitadoFarmacia;
    }

    /**
     * Set firmaDigital
     *
     * @param string $firmaDigital
     * @return MntEmpleado
     */
    public function setFirmaDigital($firmaDigital)
    {
        $this->firmaDigital = $firmaDigital;

        return $this;
    }

    /**
     * Get firmaDigital
     *
     * @return string
     */
    public function getFirmaDigital()
    {
        return $this->firmaDigital;
    }

    /**
     * Set fechahorareg
     *
     * @param \DateTime $fechahorareg
     * @return MntEmpleado
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
     * @return MntEmpleado
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
     * Set nombreempleado
     *
     * @param string $nombreempleado
     * @return MntEmpleado
     */
    public function setNombreempleado($nombreempleado)
    {
        $this->nombreempleado = $nombreempleado;

        return $this;
    }

    /**
     * Get nombreempleado
     *
     * @return string
     */
    public function getNombreempleado()
    {
        return $this->nombreempleado;
    }

    /**
     * Set idCargoEmpleado
     *
     * @param \Minsal\SiapsBundle\Entity\MntCargoEmpleado $idCargoEmpleado
     * @return MntEmpleado
     */
    public function setIdCargoEmpleado(\Minsal\SiapsBundle\Entity\MntCargoEmpleado $idCargoEmpleado = null)
    {
        $this->idCargoEmpleado = $idCargoEmpleado;

        return $this;
    }

    /**
     * Get idCargoEmpleado
     *
     * @return \Minsal\SiapsBundle\Entity\MntCargoEmpleado
     */
    public function getIdCargoEmpleado()
    {
        return $this->idCargoEmpleado;
    }

    /**
     * Set idEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento
     * @return MntEmpleado
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
     * Set idTipoEmpleado
     *
     * @param \Minsal\SiapsBundle\Entity\MntTipoEmpleado $idTipoEmpleado
     * @return MntEmpleado
     */
    public function setIdTipoEmpleado(\Minsal\SiapsBundle\Entity\MntTipoEmpleado $idTipoEmpleado = null)
    {
        $this->idTipoEmpleado = $idTipoEmpleado;

        return $this;
    }

    /**
     * Get idTipoEmpleado
     *
     * @return \Minsal\SiapsBundle\Entity\MntTipoEmpleado
     */
    public function getIdTipoEmpleado()
    {
        return $this->idTipoEmpleado;
    }

    /**
     * Set idusuarioreg
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuarioreg
     * @return MntEmpleado
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
     * Set idusuariomod
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuariomod
     * @return MntEmpleado
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

    public function __toString() {
        return $this->nombreempleado?:'';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->especialidadesEstab = new \Doctrine\Common\Collections\ArrayCollection();
        $this->especialidadesMedico = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add especialidadesEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $especialidadesEstab
     * @return MntEmpleado
     */
    public function addEspecialidadesEstab(\Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $especialidadesEstab)
    {
        $this->especialidadesEstab[] = $especialidadesEstab;

        return $this;
    }

    /**
     * Remove especialidadesEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $especialidadesEstab
     */
    public function removeEspecialidadesEstab(\Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $especialidadesEstab)
    {
        $this->especialidadesEstab->removeElement($especialidadesEstab);
    }

    /**
     * Get especialidadesEstab
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEspecialidadesEstab()
    {
        return $this->especialidadesEstab;
    }

    /**
     * Add especialidadesMedico
     *
     * @param \Minsal\SiapsBundle\Entity\CtlAtencion $especialidadesMedico
     * @return MntEmpleado
     */
    public function addEspecialidadesMedico(\Minsal\SiapsBundle\Entity\CtlAtencion $especialidadesMedico)
    {
        $this->especialidadesMedico[] = $especialidadesMedico;

        return $this;
    }

    /**
     * Remove especialidadesMedico
     *
     * @param \Minsal\SiapsBundle\Entity\CtlAtencion $especialidadesMedico
     */
    public function removeEspecialidadesMedico(\Minsal\SiapsBundle\Entity\CtlAtencion $especialidadesMedico)
    {
        $this->especialidadesMedico->removeElement($especialidadesMedico);
    }

    /**
     * Get especialidadesMedico
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEspecialidadesMedico()
    {
        return $this->especialidadesMedico;
    }

    /**
     * Set habilitado
     *
     * @param boolean $habilitado
     * @return MntEmpleado
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;

        return $this;
    }

    /**
     * Get habilitado
     *
     * @return boolean 
     */
    public function getHabilitado()
    {
        return $this->habilitado;
    }
}
