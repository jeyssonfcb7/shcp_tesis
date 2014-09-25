<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MntPaciente
 *
 * @ORM\Table(name="mnt_paciente")
 * @ORM\Entity(repositoryClass="Minsal\SiapsBundle\Repositorio\MntPacienteRepository")
 */
class MntPaciente {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="mnt_paciente_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_nombre", type="string", length=25, nullable=false)
     * @Assert\Length(min = "3")
     */
    private $primerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_nombre", type="string", length=25, nullable=true)
     * @Assert\Length(min = "3")
     */
    private $segundoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="tercer_nombre", type="string", length=25, nullable=true)
     * @Assert\Length(min = "3")
     */
    private $tercerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_apellido", type="string", length=25, nullable=false)
     * @Assert\Length(min = "3")
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_apellido", type="string", length=25, nullable=true)
     * @Assert\Length(min = "3")
     */
    private $segundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_casada", type="string", length=25, nullable=true)
     * @Assert\Length(min = "3")
     */
    private $apellidoCasada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=false)
     */
    private $fechaNacimiento;

    /**
     * @var \Time
     *
     * @ORM\Column(name="hora_nacimiento", type="time", nullable=true)
     */
    private $horaNacimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_doc_ide_paciente", type="string", length=20, nullable=true)
     */
    private $numeroDocIdePaciente;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=200, nullable=true)
     * @Assert\Length(min = "10")
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_casa", type="string", length=10, nullable=true)
     * @Assert\Length(min = "9")
     */
    private $telefonoCasa;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar_trabajo", type="string", length=50, nullable=true)
     * @Assert\Length(min = "3")
     */
    private $lugarTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_trabajo", type="string", length=10, nullable=true)
     * @Assert\Length(min = "9")
     */
    private $telefonoTrabajo;

    /**
     * @var \CtlAreaCotizante
     *
     * @ORM\ManyToOne(targetEntity="CtlAreaCotizante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_area_cotizacion", referencedColumnName="id")
     * })
     *
     */
    private $idAreaCotizacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="asegurado", type="boolean", nullable=true)
     */
    private $asegurado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cotizante", type="boolean", nullable=true)
     */
    private $cotizante;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_afiliacion", type="string", length=12, nullable=true)
     */
    private $numeroAfiliacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_padre", type="string", length=80, nullable=true)
     * @Assert\Length(min = "6")
     */
    private $nombrePadre;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_madre", type="string", length=80, nullable=true)
     * @Assert\Length(min = "6")
     */
    private $nombreMadre;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_conyuge", type="string", length=80, nullable=true)
     * @Assert\Length(min = "6")
     */
    private $nombreConyuge;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_responsable", type="string", length=80, nullable=true)
     * @Assert\Length(min = "6")
     */
    private $nombreResponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_responsable", type="string", length=100, nullable=true)
     * @Assert\Length(min = "6")
     */
    private $direccionResponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_responsable", type="string", length=10, nullable=true)
     * @Assert\Length(min = "9")
     */
    private $telefonoResponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_doc_ide_responsable", type="string", length=20, nullable=true)
     */
    private $numeroDocIdeResponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_proporciono_datos", type="string", length=80, nullable=true)
     * @Assert\Length(min = "6")
     */
    private $nombreProporcionoDatos;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_doc_ide_propor_datos", type="string", length=20, nullable=true)
     */
    private $numeroDocIdeProporDatos;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="conocido_por", type="string", length=20, nullable=true)
     * @Assert\Length(min = "3")
     */
    private $conocidoPor;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_siff", type="integer", nullable=true)
     */
    private $idSiff;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="dispensarizacion_individual", type="integer", nullable=true)
     */
    private $dispensarizacionIndividual;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_paciente_inicial", type="bigint", nullable=true)
     */
    private $idPacienteInicial;

    /**
     * @var \CtlAreaGeografica
     *
     * @ORM\ManyToOne(targetEntity="CtlAreaGeografica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="area_geografica_domicilio", referencedColumnName="id",nullable=false)
     * })
     */
    private $areaGeograficaDomicilio;

    /**
     * @var \CtlCanton
     *
     * @ORM\ManyToOne(targetEntity="CtlCanton")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_canton_domicilio", referencedColumnName="id")
     * })
     */
    private $idCantonDomicilio;

    /**
     * @var \CtlDepartamento
     *
     * @ORM\ManyToOne(targetEntity="CtlDepartamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_departamento_domicilio", referencedColumnName="id")
     * })
     */
    private $idDepartamentoDomicilio;

    /**
     * @var \CtlDocumentoIdentidad
     *
     * @ORM\ManyToOne(targetEntity="CtlDocumentoIdentidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_doc_ide_paciente", referencedColumnName="id")
     * })
     */
    private $idDocPaciente;

    /**
     * @var \CtlDocumentoIdentidad
     *
     * @ORM\ManyToOne(targetEntity="CtlDocumentoIdentidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_doc_ide_proporciono_datos", referencedColumnName="id")
     * })
     */
    private $idDocProporcionoDatos;

    /**
     * @var \CtlDocumentoIdentidad
     *
     * @ORM\ManyToOne(targetEntity="CtlDocumentoIdentidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_doc_ide_responsable", referencedColumnName="id")
     * })
     */
    private $idDocResponsable;

    /**
     * @var \CtlEstadoCivil
     *
     * @ORM\ManyToOne(targetEntity="CtlEstadoCivil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado_civil", referencedColumnName="id")
     * })
     */
    private $idEstadoCivil;

    /**
     * @var \CtlMunicipio
     *
     * @ORM\ManyToOne(targetEntity="CtlMunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_municipio_domicilio", referencedColumnName="id", nullable=false)
     * })
     */
    private $idMunicipioDomicilio;

    /**
     * @var \CtlMunicipio
     *
     * @ORM\ManyToOne(targetEntity="CtlMunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_municipio_nacimiento", referencedColumnName="id")
     * })
     */
    private $idMunicipioNacimiento;
/**
     * @var \CtlDepartamento
     *
     * @ORM\ManyToOne(targetEntity="CtlDepartamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_departamento_nacimiento", referencedColumnName="id")
     * })
     */
    private $idDepartamentoNacimiento;
    /**
     * @var \CtlNacionalidad
     *
     * @ORM\ManyToOne(targetEntity="CtlNacionalidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_nacionalidad", referencedColumnName="id")
     * })
     */
    private $idNacionalidad;

    /**
     * @var \CtlOcupacion
     *
     * @ORM\ManyToOne(targetEntity="CtlOcupacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ocupacion", referencedColumnName="id",nullable=false)
     * })
     */
    private $idOcupacion;

    /**
     * @var \CtlPais
     *
     * @ORM\ManyToOne(targetEntity="CtlPais")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pais_nacimiento", referencedColumnName="id")
     * })
     */
    private $idPaisNacimiento;

    /**
     * @var \CtlParentesco
     *
     * @ORM\ManyToOne(targetEntity="CtlParentesco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_parentesco_responsable", referencedColumnName="id")
     * })
     */
    private $idParentescoResponsable;

        /**
     * @var \CtlParentesco
     *
     * @ORM\ManyToOne(targetEntity="CtlParentesco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_parentesco_propor_datos", referencedColumnName="id")
     * })
     */
    private $idParentescoProporDatos;

    /**
     * @var \CtlSexo
     *
     * @ORM\ManyToOne(targetEntity="CtlSexo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sexo", referencedColumnName="id",nullable=false)
     * })
     */
    private $idSexo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="MntExpediente", mappedBy="idPaciente", cascade={"all"}, orphanRemoval=true)
     * @Assert\NotBlank()
     *
     */
    private $expedientes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=false)
     */
    private $fechaRegistro;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id",nullable=false)
     * })
     */
    private $idUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_mod", type="datetime", nullable=false)
     */
    private $fechaMod;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_mod", referencedColumnName="id",nullable=false)
     * })
     */
    private $idUserMod;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set primerNombre
     *
     * @param string $primerNombre
     * @return MntPaciente
     */
    public function setPrimerNombre($primerNombre) {
        $this->primerNombre = $primerNombre;

        return $this;
    }

    /**
     * Get primerNombre
     *
     * @return string
     */
    public function getPrimerNombre() {
        return $this->primerNombre;
    }

    /**
     * Set segundoNombre
     *
     * @param string $segundoNombre
     * @return MntPaciente
     */
    public function setSegundoNombre($segundoNombre) {
        $this->segundoNombre = $segundoNombre;

        return $this;
    }

    /**
     * Get segundoNombre
     *
     * @return string
     */
    public function getSegundoNombre() {
        return $this->segundoNombre;
    }

    /**
     * Set tercerNombre
     *
     * @param string $tercerNombre
     * @return MntPaciente
     */
    public function setTercerNombre($tercerNombre) {
        $this->tercerNombre = $tercerNombre;

        return $this;
    }

    /**
     * Get tercerNombre
     *
     * @return string
     */
    public function getTercerNombre() {
        return $this->tercerNombre;
    }

    /**
     * Set primerApellido
     *
     * @param string $primerApellido
     * @return MntPaciente
     */
    public function setPrimerApellido($primerApellido) {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string
     */
    public function getPrimerApellido() {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     * @return MntPaciente
     */
    public function setSegundoApellido($segundoApellido) {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundoApellido
     *
     * @return string
     */
    public function getSegundoApellido() {
        return $this->segundoApellido;
    }

    /**
     * Set apellidoCasada
     *
     * @param string $apellidoCasada
     * @return MntPaciente
     */
    public function setApellidoCasada($apellidoCasada) {
        $this->apellidoCasada = $apellidoCasada;

        return $this;
    }

    /**
     * Get apellidoCasada
     *
     * @return string
     */
    public function getApellidoCasada() {
        return $this->apellidoCasada;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return MntPaciente
     */
    public function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    /**
     * Set horaNacimiento
     *
     * @param \Time $horaNacimiento
     * @return MntPaciente
     */
    public function setHoraNacimiento($horaNacimiento) {
        $this->horaNacimiento = $horaNacimiento;

        return $this;
    }

    /**
     * Get horaNacimiento
     *
     * @return \Time
     */
    public function getHoraNacimiento() {
        return $this->horaNacimiento;
    }

    /**
     * Set numeroDocIdePaciente
     *
     * @param integer $numeroDocIdePaciente
     * @return MntPaciente
     */
    public function setNumeroDocIdePaciente($numeroDocIdePaciente) {
        $this->numeroDocIdePaciente = $numeroDocIdePaciente;

        return $this;
    }

    /**
     * Get numeroDocIdePaciente
     *
     * @return integer
     */
    public function getNumeroDocIdePaciente() {
        return $this->numeroDocIdePaciente;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return MntPaciente
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
     * Set telefonoCasa
     *
     * @param string $telefonoCasa
     * @return MntPaciente
     */
    public function setTelefonoCasa($telefonoCasa) {
        $this->telefonoCasa = $telefonoCasa;

        return $this;
    }

    /**
     * Get telefonoCasa
     *
     * @return string
     */
    public function getTelefonoCasa() {
        return $this->telefonoCasa;
    }

    /**
     * Set lugarTrabajo
     *
     * @param string $lugarTrabajo
     * @return MntPaciente
     */
    public function setLugarTrabajo($lugarTrabajo) {
        $this->lugarTrabajo = $lugarTrabajo;

        return $this;
    }

    /**
     * Get lugarTrabajo
     *
     * @return string
     */
    public function getLugarTrabajo() {
        return $this->lugarTrabajo;
    }

    /**
     * Set telefonoTrabajo
     *
     * @param string $telefonoTrabajo
     * @return MntPaciente
     */
    public function setTelefonoTrabajo($telefonoTrabajo) {
        $this->telefonoTrabajo = $telefonoTrabajo;

        return $this;
    }

    /**
     * Get telefonoTrabajo
     *
     * @return string
     */
    public function getTelefonoTrabajo() {
        return $this->telefonoTrabajo;
    }


    /**
     * Set asegurado
     *
     * @param boolean $asegurado
     * @return MntPaciente
     */
    public function setAsegurado($asegurado) {
        $this->asegurado = $asegurado;

        return $this;
    }

    /**
     * Get asegurado
     *
     * @return boolean
     */
    public function getAsegurado() {
        return $this->asegurado;
    }

    /**
     * Set numeroAfiliacion
     *
     * @param string $numeroAfiliacion
     * @return MntPaciente
     */
    public function setNumeroAfiliacion($numeroAfiliacion) {
        $this->numeroAfiliacion = $numeroAfiliacion;

        return $this;
    }

    /**
     * Get numeroAfiliacion
     *
     * @return string
     */
    public function getNumeroAfiliacion() {
        return $this->numeroAfiliacion;
    }

    /**
     * Set nombrePadre
     *
     * @param string $nombrePadre
     * @return MntPaciente
     */
    public function setNombrePadre($nombrePadre) {
        $this->nombrePadre = $nombrePadre;

        return $this;
    }

    /**
     * Get nombrePadre
     *
     * @return string
     */
    public function getNombrePadre() {
        return $this->nombrePadre;
    }

    /**
     * Set nombreMadre
     *
     * @param string $nombreMadre
     * @return MntPaciente
     */
    public function setNombreMadre($nombreMadre) {
        $this->nombreMadre = $nombreMadre;

        return $this;
    }

    /**
     * Get nombreMadre
     *
     * @return string
     */
    public function getNombreMadre() {
        return $this->nombreMadre;
    }

    /**
     * Set nombreConyuge
     *
     * @param string $nombreConyuge
     * @return MntPaciente
     */
    public function setNombreConyuge($nombreConyuge) {
        $this->nombreConyuge = $nombreConyuge;

        return $this;
    }

    /**
     * Get nombreConyuge
     *
     * @return string
     */
    public function getNombreConyuge() {
        return $this->nombreConyuge;
    }

    /**
     * Set nombreResponsable
     *
     * @param string $nombreResponsable
     * @return MntPaciente
     */
    public function setNombreResponsable($nombreResponsable) {
        $this->nombreResponsable = $nombreResponsable;

        return $this;
    }

    /**
     * Get nombreResponsable
     *
     * @return string
     */
    public function getNombreResponsable() {
        return $this->nombreResponsable;
    }

    /**
     * Set direccionResponsable
     *
     * @param string $direccionResponsable
     * @return MntPaciente
     */
    public function setDireccionResponsable($direccionResponsable) {
        $this->direccionResponsable = $direccionResponsable;

        return $this;
    }

    /**
     * Get direccionResponsable
     *
     * @return string
     */
    public function getDireccionResponsable() {
        return $this->direccionResponsable;
    }

    /**
     * Set telefonoResponsable
     *
     * @param string $telefonoResponsable
     * @return MntPaciente
     */
    public function setTelefonoResponsable($telefonoResponsable) {
        $this->telefonoResponsable = $telefonoResponsable;

        return $this;
    }

    /**
     * Get telefonoResponsable
     *
     * @return string
     */
    public function getTelefonoResponsable() {
        return $this->telefonoResponsable;
    }

    /**
     * Set numeroDocIdeResponsable
     *
     * @param string $numeroDocIdeResponsable
     * @return MntPaciente
     */
    public function setNumeroDocIdeResponsable($numeroDocIdeResponsable) {
        $this->numeroDocIdeResponsable = $numeroDocIdeResponsable;

        return $this;
    }

    /**
     * Get numeroDocIdeResponsable
     *
     * @return string
     */
    public function getNumeroDocIdeResponsable() {
        return $this->numeroDocIdeResponsable;
    }

    /**
     * Set nombreProporcionoDatos
     *
     * @param string $nombreProporcionoDatos
     * @return MntPaciente
     */
    public function setNombreProporcionoDatos($nombreProporcionoDatos) {
        $this->nombreProporcionoDatos = $nombreProporcionoDatos;

        return $this;
    }

    /**
     * Get nombreProporcionoDatos
     *
     * @return string
     */
    public function getNombreProporcionoDatos() {
        return $this->nombreProporcionoDatos;
    }

    /**
     * Set numeroDocIdeProporDatos
     *
     * @param string $numeroDocIdeProporDatos
     * @return MntPaciente
     */
    public function setNumeroDocIdeProporDatos($numeroDocIdeProporDatos) {
        $this->numeroDocIdeProporDatos = $numeroDocIdeProporDatos;

        return $this;
    }

    /**
     * Get numeroDocIdeProporDatos
     *
     * @return string
     */
    public function getNumeroDocIdeProporDatos() {
        return $this->numeroDocIdeProporDatos;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return MntPaciente
     */
    public function setObservacion($observacion) {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion() {
        return $this->observacion;
    }

    /**
     * Set conocidoPor
     *
     * @param string $conocidoPor
     * @return MntPaciente
     */
    public function setConocidoPor($conocidoPor) {
        $this->conocidoPor = $conocidoPor;

        return $this;
    }

    /**
     * Get conocidoPor
     *
     * @return string
     */
    public function getConocidoPor() {
        return $this->conocidoPor;
    }

    /**
     * Set idSiff
     *
     * @param integer $idSiff
     * @return MntPaciente
     */
    public function setIdSiff($idSiff) {
        $this->idSiff = $idSiff;

        return $this;
    }

    /**
     * Get idSiff
     *
     * @return integer
     */
    public function getIdSiff() {
        return $this->idSiff;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return MntPaciente
     */
    public function setEstado($estado) {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set dispensarizacionIndividual
     *
     * @param integer $dispensarizacionIndividual
     * @return MntPaciente
     */
    public function setDispensarizacionIndividual($dispensarizacionIndividual) {
        $this->dispensarizacionIndividual = $dispensarizacionIndividual;

        return $this;
    }

    /**
     * Get dispensarizacionIndividual
     *
     * @return integer
     */
    public function getDispensarizacionIndividual() {
        return $this->dispensarizacionIndividual;
    }

    /**
     * Set idPacienteInicial
     *
     * @param integer $idPacienteInicial
     * @return MntPaciente
     */
    public function setIdPacienteInicial($idPacienteInicial) {
        $this->idPacienteInicial = $idPacienteInicial;

        return $this;
    }

    /**
     * Get idPacienteInicial
     *
     * @return integer
     */
    public function getIdPacienteInicial() {
        return $this->idPacienteInicial;
    }

    /**
     * Set areaGeograficaDomicilio
     *
     * @param \Minsal\SiapsBundle\Entity\CtlAreaGeografica $areaGeograficaDomicilio
     * @return MntPaciente
     */
    public function setAreaGeograficaDomicilio(\Minsal\SiapsBundle\Entity\CtlAreaGeografica $areaGeograficaDomicilio = null) {
        $this->areaGeograficaDomicilio = $areaGeograficaDomicilio;

        return $this;
    }

    /**
     * Get areaGeograficaDomicilio
     *
     * @return \Minsal\SiapsBundle\Entity\CtlAreaGeografica
     */
    public function getAreaGeograficaDomicilio() {
        return $this->areaGeograficaDomicilio;
    }

    /**
     * Set idCantonDomicilio
     *
     * @param \Minsal\SiapsBundle\Entity\CtlCanton $idCantonDomicilio
     * @return MntPaciente
     */
    public function setIdCantonDomicilio(\Minsal\SiapsBundle\Entity\CtlCanton $idCantonDomicilio = null) {
        $this->idCantonDomicilio = $idCantonDomicilio;

        return $this;
    }

    /**
     * Get idCantonDomicilio
     *
     * @return \Minsal\SiapsBundle\Entity\CtlCanton
     */
    public function getIdCantonDomicilio() {
        return $this->idCantonDomicilio;
    }

    /**
     * Set idDepartamentoDomicilio
     *
     * @param \Minsal\SiapsBundle\Entity\CtlDepartamento $idDepartamentoDomicilio
     * @return MntPaciente
     */
    public function setIdDepartamentoDomicilio(\Minsal\SiapsBundle\Entity\CtlDepartamento $idDepartamentoDomicilio = null) {
        $this->idDepartamentoDomicilio = $idDepartamentoDomicilio;

        return $this;
    }

    /**
     * Get idDepartamentoDomicilio
     *
     * @return \Minsal\SiapsBundle\Entity\CtlDepartamento
     */
    public function getIdDepartamentoDomicilio() {
        return $this->idDepartamentoDomicilio;
    }

    /**
     * Set idDocPaciente
     *
     * @param \Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad $idDocPaciente
     * @return MntPaciente
     */
    public function setIdDocPaciente(\Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad $idDocPaciente = null) {
        $this->idDocPaciente = $idDocPaciente;

        return $this;
    }

    /**
     * Get idDocPaciente
     *
     * @return \Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad
     */
    public function getIdDocPaciente() {
        return $this->idDocPaciente;
    }

    /**
     * Set idDocProporcionoDatos
     *
     * @param \Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad $idDocProporcionoDatos
     * @return MntPaciente
     */
    public function setIdDocProporcionoDatos(\Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad $idDocProporcionoDatos = null) {
        $this->idDocProporcionoDatos = $idDocProporcionoDatos;

        return $this;
    }

    /**
     * Get idDocProporcionoDatos
     *
     * @return \Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad
     */
    public function getIdDocProporcionoDatos() {
        return $this->idDocProporcionoDatos;
    }

    /**
     * Set idDocResponsable
     *
     * @param \Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad $idDocResponsable
     * @return MntPaciente
     */
    public function setIdDocResponsable(\Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad $idDocResponsable = null) {
        $this->idDocResponsable = $idDocResponsable;

        return $this;
    }

    /**
     * Get idDocResponsable
     *
     * @return \Minsal\SiapsBundle\Entity\CtlDocumentoIdentidad
     */
    public function getIdDocResponsable() {
        return $this->idDocResponsable;
    }

    /**
     * Set idEstadoCivil
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstadoCivil $idEstadoCivil
     * @return MntPaciente
     */
    public function setIdEstadoCivil(\Minsal\SiapsBundle\Entity\CtlEstadoCivil $idEstadoCivil = null) {
        $this->idEstadoCivil = $idEstadoCivil;

        return $this;
    }

    /**
     * Get idEstadoCivil
     *
     * @return \Minsal\SiapsBundle\Entity\CtlEstadoCivil
     */
    public function getIdEstadoCivil() {
        return $this->idEstadoCivil;
    }

    /**
     * Set idMunicipioDomicilio
     *
     * @param \Minsal\SiapsBundle\Entity\CtlMunicipio $idMunicipioDomicilio
     * @return MntPaciente
     */
    public function setIdMunicipioDomicilio(\Minsal\SiapsBundle\Entity\CtlMunicipio $idMunicipioDomicilio = null) {
        $this->idMunicipioDomicilio = $idMunicipioDomicilio;

        return $this;
    }

    /**
     * Get idMunicipioDomicilio
     *
     * @return \Minsal\SiapsBundle\Entity\CtlMunicipio
     */
    public function getIdMunicipioDomicilio() {
        return $this->idMunicipioDomicilio;
    }

    /**
     * Set idMunicipioNacimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlMunicipio $idMunicipioNacimiento
     * @return MntPaciente
     */
    public function setIdMunicipioNacimiento(\Minsal\SiapsBundle\Entity\CtlMunicipio $idMunicipioNacimiento = null) {
        $this->idMunicipioNacimiento = $idMunicipioNacimiento;

        return $this;
    }

    /**
     * Get idMunicipioNacimiento
     *
     * @return \Minsal\SiapsBundle\Entity\CtlMunicipio
     */
    public function getIdMunicipioNacimiento() {
        return $this->idMunicipioNacimiento;
    }

    /**
     * Set idNacionalidad
     *
     * @param \Minsal\SiapsBundle\Entity\CtlNacionalidad $idNacionalidad
     * @return MntPaciente
     */
    public function setIdNacionalidad(\Minsal\SiapsBundle\Entity\CtlNacionalidad $idNacionalidad = null) {
        $this->idNacionalidad = $idNacionalidad;

        return $this;
    }

    /**
     * Get idNacionalidad
     *
     * @return \Minsal\SiapsBundle\Entity\CtlNacionalidad
     */
    public function getIdNacionalidad() {
        return $this->idNacionalidad;
    }

    /**
     * Set idOcupacion
     *
     * @param \Minsal\SiapsBundle\Entity\CtlOcupacion $idOcupacion
     * @return MntPaciente
     */
    public function setIdOcupacion(\Minsal\SiapsBundle\Entity\CtlOcupacion $idOcupacion = null) {
        $this->idOcupacion = $idOcupacion;

        return $this;
    }

    /**
     * Get idOcupacion
     *
     * @return \Minsal\SiapsBundle\Entity\CtlOcupacion
     */
    public function getIdOcupacion() {
        return $this->idOcupacion;
    }

    /**
     * Set idPaisNacimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlPais $idPaisNacimiento
     * @return MntPaciente
     */
    public function setIdPaisNacimiento(\Minsal\SiapsBundle\Entity\CtlPais $idPaisNacimiento = null) {
        $this->idPaisNacimiento = $idPaisNacimiento;

        return $this;
    }

    /**
     * Get idPaisNacimiento
     *
     * @return \Minsal\SiapsBundle\Entity\CtlPais
     */
    public function getIdPaisNacimiento() {
        return $this->idPaisNacimiento;
    }

    /**
     * Set idParentescoResponsable
     *
     * @param \Minsal\SiapsBundle\Entity\CtlParentesco $idParentescoResponsable
     * @return MntPaciente
     */
    public function setIdParentescoResponsable(\Minsal\SiapsBundle\Entity\CtlParentesco $idParentescoResponsable = null) {
        $this->idParentescoResponsable = $idParentescoResponsable;

        return $this;
    }

    /**
     * Get idParentescoResponsable
     *
     * @return \Minsal\SiapsBundle\Entity\CtlParentesco
     */
    public function getIdParentescoResponsable() {
        return $this->idParentescoResponsable;
    }

    /**
     * Set idSexo
     *
     * @param \Minsal\SiapsBundle\Entity\CtlSexo $idSexo
     * @return MntPaciente
     */
    public function setIdSexo(\Minsal\SiapsBundle\Entity\CtlSexo $idSexo = null) {
        $this->idSexo = $idSexo;

        return $this;
    }

    /**
     * Get idSexo
     *
     * @return \Minsal\SiapsBundle\Entity\CtlSexo
     */
    public function getIdSexo() {
        return $this->idSexo;
    }

    public function __toString() {
        return $this->primerApellido.' '.$this->segundoApellido.' '.$this->apellidoCasada . ',' . $this->primerNombre.' '.$this->segundoNombre ? : '';
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->expedientes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->estado=true;
    }

    /**
     * Add expedientes
     *
     * @param \Minsal\SiapsBundle\Entity\MntExpediente $expedientes
     * @return MntPaciente
     */
    public function addExpediente(\Minsal\SiapsBundle\Entity\MntExpediente $expedientes) {
        $this->expedientes[] = $expedientes;

        return $this;
    }

    /**
     * Remove expedientes
     *
     * @param \Minsal\SiapsBundle\Entity\MntExpediente $expedientes
     */
    public function removeExpediente(\Minsal\SiapsBundle\Entity\MntExpediente $expedientes) {
        $this->expedientes->removeElement($expedientes);
    }

    /**
     * Get expedientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExpedientes() {
        return $this->expedientes;
    }


    /**
     * Set cotizante
     *
     * @param boolean $cotizante
     * @return MntPaciente
     */
    public function setCotizante($cotizante)
    {
        $this->cotizante = $cotizante;

        return $this;
    }

    /**
     * Get cotizante
     *
     * @return boolean
     */
    public function getCotizante()
    {
        return $this->cotizante;
    }

    /**
     * Set idDepartamentoNacimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlDepartamento $idDepartamentoNacimiento
     * @return MntPaciente
     */
    public function setIdDepartamentoNacimiento(\Minsal\SiapsBundle\Entity\CtlDepartamento $idDepartamentoNacimiento = null)
    {
        $this->idDepartamentoNacimiento = $idDepartamentoNacimiento;

        return $this;
    }

    /**
     * Get idDepartamentoNacimiento
     *
     * @return \Minsal\SiapsBundle\Entity\CtlDepartamento
     */
    public function getIdDepartamentoNacimiento()
    {
        return $this->idDepartamentoNacimiento;
    }

    /**
     * Set idAreaCotizacion
     *
     * @param \Minsal\SiapsBundle\Entity\CtlAreaCotizante $idAreaCotizacion
     * @return MntPaciente
     */
    public function setIdAreaCotizacion(\Minsal\SiapsBundle\Entity\CtlAreaCotizante $idAreaCotizacion = null)
    {
        $this->idAreaCotizacion = $idAreaCotizacion;

        return $this;
    }

    /**
     * Get idAreaCotizacion
     *
     * @return \Minsal\SiapsBundle\Entity\CtlAreaCotizante
     */
    public function getIdAreaCotizacion()
    {
        return $this->idAreaCotizacion;
    }


    /**
     * Set idParentescoProporDatos
     *
     * @param \Minsal\SiapsBundle\Entity\CtlParentesco $idParentescoProporDatos
     * @return MntPaciente
     */
    public function setIdParentescoProporDatos(\Minsal\SiapsBundle\Entity\CtlParentesco $idParentescoProporDatos = null)
    {
        $this->idParentescoProporDatos = $idParentescoProporDatos;

        return $this;
    }

    /**
     * Get idParentescoProporDatos
     *
     * @return \Minsal\SiapsBundle\Entity\CtlParentesco
     */
    public function getIdParentescoProporDatos()
    {
        return $this->idParentescoProporDatos;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return MntPaciente
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set idUser
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idUser
     * @return MntPaciente
     */
    public function setIdUser(\Application\Sonata\UserBundle\Entity\User $idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set fechaMod
     *
     * @param \DateTime $fechaMod
     * @return MntPaciente
     */
    public function setFechaMod($fechaMod)
    {
        $this->fechaMod = $fechaMod;

        return $this;
    }

    /**
     * Get fechaMod
     *
     * @return \DateTime
     */
    public function getFechaMod()
    {
        return $this->fechaMod;
    }

    /**
     * Set idUserMod
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idUserMod
     * @return MntPaciente
     */
    public function setIdUserMod(\Application\Sonata\UserBundle\Entity\User $idUserMod)
    {
        $this->idUserMod = $idUserMod;

        return $this;
    }

    /**
     * Get idUserMod
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdUserMod()
    {
        return $this->idUserMod;
    }
}
