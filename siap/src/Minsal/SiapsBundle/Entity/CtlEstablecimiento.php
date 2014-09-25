<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CtlEstablecimiento
 *
 * @ORM\Table(name="ctl_establecimiento")
 * @ORM\Entity(repositoryClass="Minsal\SiapsBundle\Repositorio\CtlEstablecimientoRepository")
 */
class CtlEstablecimiento {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ctl_establecimiento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=150, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=250, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=15, nullable=true)
     */
    private $fax;

    /**
     * @var float
     *
     * @ORM\Column(name="latitud", type="decimal", nullable=true)
     */
    private $latitud;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="decimal", nullable=true)
     */
    private $longitud;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_nivel_minsal", type="integer", nullable=true)
     */
    private $idNivelMinsal;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_ucsf", type="integer", nullable=true)
     */
    private $codUcsf;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_expediente", type="string", nullable=true)
     */
    private $tipoExpediente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tipo_farmacia", type="boolean", nullable=true)
     */
    private $tipoFarmacia;

    /**
     * @var boolean
     *
     * @ORM\Column(name="configurado", type="boolean", nullable=true)
     */
    private $configurado;

    /**
     * @var \CtlEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="CtlEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_establecimiento_padre", referencedColumnName="id")
     * })
     */
    private $idEstablecimientoPadre;

    /**
     * @var \CtlMunicipio
     *
     * @ORM\ManyToOne(targetEntity="CtlMunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_municipio", referencedColumnName="id")
     * })
     */
    private $idMunicipio;

    /**
     * @var \CtlTipoEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="CtlTipoEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_establecimiento", referencedColumnName="id")
     * })
     */
    private $idTipoEstablecimiento;

    /**
     * 
     * @var \programas
     * 
     * @ORM\ManyToMany(targetEntity="Minsal\SiapsBundle\Entity\CtlPrograma")
     * @ORM\JoinTable(name="mnt_programa_establecimiento",
     *       joinColumns={
     *           @ORM\JoinColumn(name="id_establecimiento", referencedColumnName="id")},
     *       inverseJoinColumns={
     *           @ORM\JoinColumn(name="id_programa", referencedColumnName="id")}
     * )
     */
    private $programas;

    /**
     * 
     * @var \servicioExternos
     * 
     * @ORM\ManyToMany(targetEntity="Minsal\SiapsBundle\Entity\MntServicioExterno")
     * @ORM\JoinTable(name="mnt_servicio_externo_establecimiento",
     *       joinColumns={
     *           @ORM\JoinColumn(name="id_establecimiento", referencedColumnName="id")},
     *       inverseJoinColumns={
     *           @ORM\JoinColumn(name="id_servicio_externo", referencedColumnName="id")}
     * )
     */
    private $serviciosExterno;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return CtlEstablecimiento
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return CtlEstablecimiento
     */
    public function setDireccion($direccion) {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion() {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return CtlEstablecimiento
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return CtlEstablecimiento
     */
    public function setFax($fax) {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax() {
        return $this->fax;
    }

    /**
     * Set latitud
     *
     * @param float $latitud
     * @return CtlEstablecimiento
     */
    public function setLatitud($latitud) {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud
     *
     * @return float 
     */
    public function getLatitud() {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param float $longitud
     * @return CtlEstablecimiento
     */
    public function setLongitud($longitud) {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud
     *
     * @return float 
     */
    public function getLongitud() {
        return $this->longitud;
    }

    /**
     * Set idNivelMinsal
     *
     * @param integer $idNivelMinsal
     * @return CtlEstablecimiento
     */
    public function setIdNivelMinsal($idNivelMinsal) {
        $this->idNivelMinsal = $idNivelMinsal;

        return $this;
    }

    /**
     * Get idNivelMinsal
     *
     * @return integer 
     */
    public function getIdNivelMinsal() {
        return $this->idNivelMinsal;
    }

    /**
     * Set codUcsf
     *
     * @param integer $codUcsf
     * @return CtlEstablecimiento
     */
    public function setCodUcsf($codUcsf) {
        $this->codUcsf = $codUcsf;

        return $this;
    }

    /**
     * Get codUcsf
     *
     * @return integer 
     */
    public function getCodUcsf() {
        return $this->codUcsf;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return CtlEstablecimiento
     */
    public function setActivo($activo) {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo() {
        return $this->activo;
    }

    /**
     * Set tipoExpediente
     *
     * @param string $tipoExpediente
     * @return CtlEstablecimiento
     */
    public function setTipoExpediente($tipoExpediente) {
        $this->tipoExpediente = $tipoExpediente;

        return $this;
    }

    /**
     * Get tipoExpediente
     *
     * @return string 
     */
    public function getTipoExpediente() {
        return $this->tipoExpediente;
    }

    /**
     * Set configurado
     *
     * @param boolean $configurado
     * @return CtlEstablecimiento
     */
    public function setConfigurado($configurado) {
        $this->configurado = $configurado;

        return $this;
    }

    /**
     * Get configurado
     *
     * @return boolean 
     */
    public function getConfigurado() {
        return $this->configurado;
    }

    /**
     * Set idEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento
     * @return CtlEstablecimiento
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

    /**
     * Set idMunicipio
     *
     * @param \Minsal\SiapsBundle\Entity\CtlMunicipio $idMunicipio
     * @return CtlEstablecimiento
     */
    public function setIdMunicipio(\Minsal\SiapsBundle\Entity\CtlMunicipio $idMunicipio = null) {
        $this->idMunicipio = $idMunicipio;

        return $this;
    }

    /**
     * Get idMunicipio
     *
     * @return \Minsal\SiapsBundle\Entity\CtlMunicipio 
     */
    public function getIdMunicipio() {
        return $this->idMunicipio;
    }

    /**
     * Set idTipoEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlTipoEstablecimiento $idTipoEstablecimiento
     * @return CtlEstablecimiento
     */
    public function setIdTipoEstablecimiento(\Minsal\SiapsBundle\Entity\CtlTipoEstablecimiento $idTipoEstablecimiento = null) {
        $this->idTipoEstablecimiento = $idTipoEstablecimiento;

        return $this;
    }

    /**
     * Get idTipoEstablecimiento
     *
     * @return \Minsal\SiapsBundle\Entity\CtlTipoEstablecimiento 
     */
    public function getIdTipoEstablecimiento() {
        return $this->idTipoEstablecimiento;
    }

    public function __toString() {
        return $this->nombre ? : '';
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->programas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->serviciosExterno = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add programas
     *
     * @param \Minsal\SiapsBundle\Entity\CtlPrograma $programas
     * @return CtlEstablecimiento
     */
    public function addPrograma(\Minsal\SiapsBundle\Entity\CtlPrograma $programas) {
        $this->programas[] = $programas;

        return $this;
    }

    /**
     * Remove programas
     *
     * @param \Minsal\SiapsBundle\Entity\CtlPrograma $programas
     */
    public function removePrograma(\Minsal\SiapsBundle\Entity\CtlPrograma $programas) {
        $this->programas->removeElement($programas);
    }

    /**
     * Get programas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProgramas() {
        return $this->programas;
    }

    /**
     * Add serviciosExterno
     *
     * @param \Minsal\SiapsBundle\Entity\MntServicioExterno $serviciosExterno
     * @return CtlEstablecimiento
     */
    public function addServiciosExterno(\Minsal\SiapsBundle\Entity\MntServicioExterno $serviciosExterno) {
        $this->serviciosExterno[] = $serviciosExterno;

        return $this;
    }

    /**
     * Remove serviciosExterno
     *
     * @param \Minsal\SiapsBundle\Entity\MntServicioExterno $serviciosExterno
     */
    public function removeServiciosExterno(\Minsal\SiapsBundle\Entity\MntServicioExterno $serviciosExterno) {
        $this->serviciosExterno->removeElement($serviciosExterno);
    }

    /**
     * Get serviciosExterno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getServiciosExterno() {
        return $this->serviciosExterno;
    }


    /**
     * Set tipoFarmacia
     *
     * @param boolean $tipoFarmacia
     * @return CtlEstablecimiento
     */
    public function setTipoFarmacia($tipoFarmacia)
    {
        $this->tipoFarmacia = $tipoFarmacia;
    
        return $this;
    }

    /**
     * Get tipoFarmacia
     *
     * @return boolean 
     */
    public function getTipoFarmacia()
    {
        return $this->tipoFarmacia;
    }

    /**
     * Set idEstablecimientoPadre
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimientoPadre
     * @return CtlEstablecimiento
     */
    public function setIdEstablecimientoPadre(\Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimientoPadre = null)
    {
        $this->idEstablecimientoPadre = $idEstablecimientoPadre;
    
        return $this;
    }

    /**
     * Get idEstablecimientoPadre
     *
     * @return \Minsal\SiapsBundle\Entity\CtlEstablecimiento 
     */
    public function getIdEstablecimientoPadre()
    {
        return $this->idEstablecimientoPadre;
    }
}