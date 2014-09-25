<?php

namespace Minsal\CitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LabExamenesxestablecimiento
 *
 * @ORM\Table(name="lab_examenesxestablecimiento")
 * @ORM\Entity
 */
class LabExamenesxestablecimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="lab_examenesxestablecimiento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="idexam", type="string", length=8, nullable=true)
     */
    private $idexam;

    /**
     * @var \Minsal\SiapsBundle\CtlEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\CtlEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idestablecimiento", referencedColumnName="id")
     * })
     */
    private $idestablecimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="condicion", type="string", length=255, nullable=true)
     */
    private $condicion;

    /**
     * @var integer
     *
     * @ORM\Column(name="idformulario", type="integer", nullable=true)
     */
    private $idformulario;

    /**
     * @var integer
     *
     * @ORM\Column(name="idestandarrep", type="integer", nullable=true)
     */
    private $idestandarrep;

    /**
     * @var integer
     *
     * @ORM\Column(name="urgente", type="integer", nullable=true)
     */
    private $urgente;

    /**
     * @var string
     *
     * @ORM\Column(name="idplanilla", type="string", length=1, nullable=true)
     */
    private $idplanilla;

    /**
     * @var string
     *
     * @ORM\Column(name="impresion", type="string", length=1, nullable=true)
     */
    private $impresion;

    /**
     * @var integer
     *
     * @ORM\Column(name="ubicacion", type="integer", nullable=true)
     */
    private $ubicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigosumi", type="string", length=8, nullable=true)
     */
    private $codigosumi;

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
     * @var boolean
     *
     * @ORM\Column(name="habilitado", type="boolean", nullable=true)
     */
    private $habilitado;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_examen", type="integer", nullable=true)
     */
    private $idExamen;

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
     * Set idexam
     *
     * @param string $idexam
     * @return LabExamenesxestablecimiento
     */
    public function setIdexam($idexam)
    {
        $this->idexam = $idexam;

        return $this;
    }

    /**
     * Get idexam
     *
     * @return string
     */
    public function getIdexam()
    {
        return $this->idexam;
    }

    /**
     * Set condicion
     *
     * @param string $condicion
     * @return LabExamenesxestablecimiento
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return string
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * Set idformulario
     *
     * @param integer $idformulario
     * @return LabExamenesxestablecimiento
     */
    public function setIdformulario($idformulario)
    {
        $this->idformulario = $idformulario;

        return $this;
    }

    /**
     * Get idformulario
     *
     * @return integer
     */
    public function getIdformulario()
    {
        return $this->idformulario;
    }

    /**
     * Set idestandarrep
     *
     * @param integer $idestandarrep
     * @return LabExamenesxestablecimiento
     */
    public function setIdestandarrep($idestandarrep)
    {
        $this->idestandarrep = $idestandarrep;

        return $this;
    }

    /**
     * Get idestandarrep
     *
     * @return integer
     */
    public function getIdestandarrep()
    {
        return $this->idestandarrep;
    }

    /**
     * Set urgente
     *
     * @param integer $urgente
     * @return LabExamenesxestablecimiento
     */
    public function setUrgente($urgente)
    {
        $this->urgente = $urgente;

        return $this;
    }

    /**
     * Get urgente
     *
     * @return integer
     */
    public function getUrgente()
    {
        return $this->urgente;
    }

    /**
     * Set idplanilla
     *
     * @param string $idplanilla
     * @return LabExamenesxestablecimiento
     */
    public function setIdplanilla($idplanilla)
    {
        $this->idplanilla = $idplanilla;

        return $this;
    }

    /**
     * Get idplanilla
     *
     * @return string
     */
    public function getIdplanilla()
    {
        return $this->idplanilla;
    }

    /**
     * Set impresion
     *
     * @param string $impresion
     * @return LabExamenesxestablecimiento
     */
    public function setImpresion($impresion)
    {
        $this->impresion = $impresion;

        return $this;
    }

    /**
     * Get impresion
     *
     * @return string
     */
    public function getImpresion()
    {
        return $this->impresion;
    }

    /**
     * Set ubicacion
     *
     * @param integer $ubicacion
     * @return LabExamenesxestablecimiento
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return integer
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set codigosumi
     *
     * @param string $codigosumi
     * @return LabExamenesxestablecimiento
     */
    public function setCodigosumi($codigosumi)
    {
        $this->codigosumi = $codigosumi;

        return $this;
    }

    /**
     * Get codigosumi
     *
     * @return string
     */
    public function getCodigosumi()
    {
        return $this->codigosumi;
    }

    /**
     * Set fechahorareg
     *
     * @param \DateTime $fechahorareg
     * @return LabExamenesxestablecimiento
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
     * @return LabExamenesxestablecimiento
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
     * Set habilitado
     *
     * @param boolean $habilitado
     * @return LabExamenesxestablecimiento
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

    /**
     * Set idExamen
     *
     * @param integer $idExamen
     * @return LabExamenesxestablecimiento
     */
    public function setIdExamen($idExamen)
    {
        $this->idExamen = $idExamen;

        return $this;
    }

    /**
     * Get idExamen
     *
     * @return integer
     */
    public function getIdExamen()
    {
        return $this->idExamen;
    }

    /**
     * Set idestablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idestablecimiento
     * @return LabExamenesxestablecimiento
     */
    public function setIdestablecimiento(\Minsal\SiapsBundle\Entity\CtlEstablecimiento $idestablecimiento = null)
    {
        $this->idestablecimiento = $idestablecimiento;

        return $this;
    }

    /**
     * Get idestablecimiento
     *
     * @return \Minsal\SiapsBundle\Entity\CtlEstablecimiento
     */
    public function getIdestablecimiento()
    {
        return $this->idestablecimiento;
    }

    /**
     * Set idusuarioreg
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuarioreg
     * @return LabExamenesxestablecimiento
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
     * @return LabExamenesxestablecimiento
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
}
