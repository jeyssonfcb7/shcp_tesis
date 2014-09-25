<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MntConexion
 *
 * @ORM\Table(name="mnt_conexion")
 * @ORM\Entity(repositoryClass="Minsal\SiapsBundle\Repositorio\MntConexionRepository")
 */
class MntConexion {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="mnt_conexion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="host", type="string", length=20, nullable=false)
     */
    private $host;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=15, nullable=false)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="contrasenia", type="string", length=150, nullable=false)
     */
    private $contrasenia;

    /**
     * @var string
     *
     * @ORM\Column(name="puerto", type="string", nullable=false)
     */
    private $puerto;

    /**
     * @var string
     *
     * @ORM\Column(name="base_de_datos", type="string", length=20, nullable=false)
     */
    private $baseDeDatos;

    /**
     * @var string
     *
     * @ORM\Column(name="gestor_base", type="string", length=10, nullable=false)
     */
    private $gestorBase;

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
     * @return MntConexion
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
     * Set host
     *
     * @param string $host
     * @return MntConexion
     */
    public function setHost($host) {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * @return MntConexion
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Set contrasenia
     *
     * @param string $contrasenia
     * @return MntConexion
     */
    public function setContrasenia($contrasenia) {
        $this->contrasenia = $contrasenia;

        return $this;
    }

    /**
     * Get contrasenia
     *
     * @return string 
     */
    public function getContrasenia() {
        return $this->contrasenia;
    }

    /**
     * Set puerto
     *
     * @param string $puerto
     * @return MntConexion
     */
    public function setPuerto($puerto) {
        $this->puerto = $puerto;

        return $this;
    }

    /**
     * Get puerto
     *
     * @return string 
     */
    public function getPuerto() {
        return $this->puerto;
    }

    /**
     * Set baseDeDatos
     *
     * @param string $baseDeDatos
     * @return MntConexion
     */
    public function setBaseDeDatos($baseDeDatos) {
        $this->baseDeDatos = $baseDeDatos;

        return $this;
    }

    /**
     * Get baseDeDatos
     *
     * @return string 
     */
    public function getBaseDeDatos() {
        return $this->baseDeDatos;
    }

    /**
     * Set gestorBase
     *
     * @param string $gestorBase
     * @return MntConexion
     */
    public function setGestorBase($gestorBase) {
        $this->gestorBase = $gestorBase;

        return $this;
    }

    /**
     * Get gestorBase
     *
     * @return string 
     */
    public function getGestorBase() {
        return $this->gestorBase;
    }

    /**
     * Set idEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento
     * @return MntConexion
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

    //PARA INICIALIZAR UNA CONSTANTE EN LA CONEXIÓN QUE ES LA DE POSTGRESQL
    public function __construct() {
        $this->gestorBase = 'pdo_pgsql';
    }
    
    public function __toString() {
        return (string) $this->nombre ? : '';
    }

}