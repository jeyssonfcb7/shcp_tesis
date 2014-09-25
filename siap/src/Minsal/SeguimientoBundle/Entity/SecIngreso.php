<?php

namespace Minsal\SeguimientoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SecIngreso
 *
 * @ORM\Table(name="sec_ingreso")
 * @ORM\Entity
 */
class SecIngreso {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sec_ingreso_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Minsal\SiapsBundle\MntExpediente
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntExpediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_expediente", referencedColumnName="id")
     * })
     */
    private $idExpediente;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var \Time
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntAtenAreaModEstab")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_aten_are_mod_estab", referencedColumnName="id")
     * })
     */
    private $idAtenAreaModEstab;

    /**
     * @var \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntAtenAreaModEstab")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ambiente_ingreso", referencedColumnName="id")
     * })
     */
    private $idAmbienteIngreso;

    /**
     * @var string
     *
     * @ORM\Column(name="diagnostico", type="text")
     */
    private $diagnostico;

    /**
     * @var \Minsal\SiapsBundle\Entity\MntCie10
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\MntCie10")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cie10", referencedColumnName="id")
     * })
     */
    private $idCie10;

    /**
     * @var \'Minsal\SeguimientoBundle\Entity\'SecEstadoPaciente
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SeguimientoBundle\Entity\SecEstadoPaciente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado", referencedColumnName="id")
     * })
     */
    private $idEstado;

    /**
     * @var \Minsal\SeguimientoBundle\Entity\SecProcedenciaIngreso
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SeguimientoBundle\Entity\SecProcedenciaIngreso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_procedencia_ingreso", referencedColumnName="id")
     * })
     */
    private $idProcedenciaIngreso;

    /**
     * @var \Minsal\SeguimientoBundle\Entity\SecCircunstanciaIngreso
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SeguimientoBundle\Entity\SecCircunstanciaIngreso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_circunstancia_ingreso", referencedColumnName="id")
     * })
     */
    private $idCircunstanciaIngreso;

    /**
     * @var \Minsal\SeguimientoBundle\Entity\SecTipoAccidente
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SeguimientoBundle\Entity\SecTipoAccidente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_accidente", referencedColumnName="id")
     * })
     */
    private $idTipoAccidente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="embarazada", type="boolean")
     */
    private $embarazada;

    /**
     * @var integer
     *
     * @ORM\Column(name="semanas_amenorrea", type="integer")
     */
    private $semanasAmenorrea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_probable_parto", type="date", nullable=false)
     */
    private $fechaProbableParto;

    /**
     * @var \Minsal\SiapsBundle\Entity\CtlEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\CtlEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_establecimiento_referencia", referencedColumnName="id")
     * })
     */
    private $idEstablecimientoReferencia;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo_referencia", type="text")
     */
    private $motivoReferencia;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario_registra", referencedColumnName="id",nullable=false)
     * })
     */
    private $idUsuarioRegistra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario_modifica", referencedColumnName="id",nullable=false)
     * })
     */
    private $idUsuarioModifica;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime")
     */
    private $fechaModificacion;

    /**
     * @var \\Minsal\SiapsBundle\Entity\MntEmpleado
     *
     * @ORM\ManyToOne(targetEntity="\Minsal\SiapsBundle\Entity\MntEmpleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_empleado", referencedColumnName="id",nullable=true)
     * })
     */
    private $idEmpleado;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable_tarjeta", type="string", length=80, nullable=false)
     */
    private $responsableTarjeta;

    /**
     * @var integer
     *
     * @ORM\Column(name="tarjetas_entregadas", type="integer", nullable=false)
     */
    private $tarjetasEntregadas;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return SecIngreso
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     * @return SecIngreso
     */
    public function setHora($hora) {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * Set diagnostico
     *
     * @param string $diagnostico
     * @return SecIngreso
     */
    public function setDiagnostico($diagnostico) {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return string
     */
    public function getDiagnostico() {
        return $this->diagnostico;
    }

    /**
     * Set embarazada
     *
     * @param boolean $embarazada
     * @return SecIngreso
     */
    public function setEmbarazada($embarazada) {
        $this->embarazada = $embarazada;

        return $this;
    }

    /**
     * Get embarazada
     *
     * @return boolean
     */
    public function getEmbarazada() {
        return $this->embarazada;
    }

    /**
     * Set semanasAmenorrea
     *
     * @param integer $semanasAmenorrea
     * @return SecIngreso
     */
    public function setSemanasAmenorrea($semanasAmenorrea) {
        $this->semanasAmenorrea = $semanasAmenorrea;

        return $this;
    }

    /**
     * Get semanasAmenorrea
     *
     * @return integer
     */
    public function getSemanasAmenorrea() {
        return $this->semanasAmenorrea;
    }

    /**
     * Set fechaProbableParto
     *
     * @param \DateTime $fechaProbableParto
     * @return SecIngreso
     */
    public function setFechaProbableParto($fechaProbableParto) {
        $this->fechaProbableParto = $fechaProbableParto;

        return $this;
    }

    /**
     * Get fechaProbableParto
     *
     * @return \DateTime
     */
    public function getFechaProbableParto() {
        return $this->fechaProbableParto;
    }

    /**
     * Set motivoReferencia
     *
     * @param string $motivoReferencia
     * @return SecIngreso
     */
    public function setMotivoReferencia($motivoReferencia) {
        $this->motivoReferencia = $motivoReferencia;

        return $this;
    }

    /**
     * Get motivoReferencia
     *
     * @return string
     */
    public function getMotivoReferencia() {
        return $this->motivoReferencia;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return SecIngreso
     */
    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return SecIngreso
     */
    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    /**
     * Set idExpediente
     *
     * @param \Minsal\SiapsBundle\Entity\MntExpediente $idExpediente
     * @return SecIngreso
     */
    public function setIdExpediente(\Minsal\SiapsBundle\Entity\MntExpediente $idExpediente = null) {
        $this->idExpediente = $idExpediente;

        return $this;
    }

    /**
     * Get idExpediente
     *
     * @return \Minsal\SiapsBundle\Entity\MntExpediente
     */
    public function getIdExpediente() {
        return $this->idExpediente;
    }

    /**
     * Set idAtenAreaModEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $idAtenAreaModEstab
     * @return SecIngreso
     */
    public function setIdAtenAreaModEstab(\Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $idAtenAreaModEstab = null) {
        $this->idAtenAreaModEstab = $idAtenAreaModEstab;

        return $this;
    }

    /**
     * Get idAtenAreaModEstab
     *
     * @return \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab
     */
    public function getIdAtenAreaModEstab() {
        return $this->idAtenAreaModEstab;
    }

    /**
     * Set idAmbienteIngreso
     *
     * @param \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $idAmbienteIngreso
     * @return SecIngreso
     */
    public function setIdAmbienteIngreso(\Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $idAmbienteIngreso = null) {
        $this->idAmbienteIngreso = $idAmbienteIngreso;

        return $this;
    }

    /**
     * Get idAmbienteIngreso
     *
     * @return \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab
     */
    public function getIdAmbienteIngreso() {
        return $this->idAmbienteIngreso;
    }

    /**
     * Set idCie10
     *
     * @param \Minsal\SiapsBundle\Entity\MntCie10 $idCie10
     * @return SecIngreso
     */
    public function setIdCie10(\Minsal\SiapsBundle\Entity\MntCie10 $idCie10 = null) {
        $this->idCie10 = $idCie10;

        return $this;
    }

    /**
     * Get idCie10
     *
     * @return \Minsal\SiapsBundle\Entity\MntCie10
     */
    public function getIdCie10() {
        return $this->idCie10;
    }

    /**
     * Set idEstado
     *
     * @param \Minsal\SeguimientoBundle\Entity\SecEstadoPaciente $idEstado
     * @return SecIngreso
     */
    public function setIdEstado(\Minsal\SeguimientoBundle\Entity\SecEstadoPaciente $idEstado = null) {
        $this->idEstado = $idEstado;

        return $this;
    }

    /**
     * Get idEstado
     *
     * @return \Minsal\SeguimientoBundle\Entity\SecEstadoPaciente
     */
    public function getIdEstado() {
        return $this->idEstado;
    }

    /**
     * Set idProcedenciaIngreso
     *
     * @param \Minsal\SeguimientoBundle\Entity\SecProcedenciaIngreso $idProcedenciaIngreso
     * @return SecIngreso
     */
    public function setIdProcedenciaIngreso(\Minsal\SeguimientoBundle\Entity\SecProcedenciaIngreso $idProcedenciaIngreso = null) {
        $this->idProcedenciaIngreso = $idProcedenciaIngreso;

        return $this;
    }

    /**
     * Get idProcedenciaIngreso
     *
     * @return \Minsal\SeguimientoBundle\Entity\SecProcedenciaIngreso
     */
    public function getIdProcedenciaIngreso() {
        return $this->idProcedenciaIngreso;
    }

    /**
     * Set idCircunstanciaIngreso
     *
     * @param \Minsal\SeguimientoBundle\Entity\SecCircunstanciaIngreso $idCircunstanciaIngreso
     * @return SecIngreso
     */
    public function setIdCircunstanciaIngreso(\Minsal\SeguimientoBundle\Entity\SecCircunstanciaIngreso $idCircunstanciaIngreso = null) {
        $this->idCircunstanciaIngreso = $idCircunstanciaIngreso;

        return $this;
    }

    /**
     * Get idCircunstanciaIngreso
     *
     * @return \Minsal\SeguimientoBundle\Entity\SecCircunstanciaIngreso
     */
    public function getIdCircunstanciaIngreso() {
        return $this->idCircunstanciaIngreso;
    }

    /**
     * Set idTipoAccidente
     *
     * @param \Minsal\SeguimientoBundle\Entity\SecTipoAccidente $idTipoAccidente
     * @return SecIngreso
     */
    public function setIdTipoAccidente(\Minsal\SeguimientoBundle\Entity\SecTipoAccidente $idTipoAccidente = null) {
        $this->idTipoAccidente = $idTipoAccidente;

        return $this;
    }

    /**
     * Get idTipoAccidente
     *
     * @return \Minsal\SeguimientoBundle\SecTipoAccidente
     */
    public function getIdTipoAccidente() {
        return $this->idTipoAccidente;
    }

    /**
     * Set idEstablecimientoReferencia
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimientoReferencia
     * @return SecIngreso
     */
    public function setIdEstablecimientoReferencia(\Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimientoReferencia = null) {
        $this->idEstablecimientoReferencia = $idEstablecimientoReferencia;

        return $this;
    }

    /**
     * Get idEstablecimientoReferencia
     *
     * @return \Minsal\SiapsBundle\Entity\CtlEstablecimiento
     */
    public function getIdEstablecimientoReferencia() {
        return $this->idEstablecimientoReferencia;
    }

    /**
     * Set idUsuarioRegistra
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idUsuarioRegistra
     * @return SecIngreso
     */
    public function setIdUsuarioRegistra(\Application\Sonata\UserBundle\Entity\User $idUsuarioRegistra) {
        $this->idUsuarioRegistra = $idUsuarioRegistra;

        return $this;
    }

    /**
     * Get idUsuarioRegistra
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdUsuarioRegistra() {
        return $this->idUsuarioRegistra;
    }

    /**
     * Set idUsuarioModifica
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idUsuarioModifica
     * @return SecIngreso
     */
    public function setIdUsuarioModifica(\Application\Sonata\UserBundle\Entity\User $idUsuarioModifica) {
        $this->idUsuarioModifica = $idUsuarioModifica;

        return $this;
    }

    /**
     * Get idUsuarioModifica
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdUsuarioModifica() {
        return $this->idUsuarioModifica;
    }

    public function __toString() {
        return (string) $this->idExpediente->getIdPaciente()? : '';
    }

    /**
     * Set idEmpleado
     *
     * @param \Minsal\SiapsBundle\Entity\MntEmpleado $idEmpleado
     * @return SecIngreso
     */
    public function setIdEmpleado(\Minsal\SiapsBundle\Entity\MntEmpleado $idEmpleado) {
        $this->idEmpleado = $idEmpleado;

        return $this;
    }

    /**
     * Get idEmpleado
     *
     * @return \Minsal\SiapsBundle\Entity\MntEmpleado
     */
    public function getIdEmpleado() {
        return $this->idEmpleado;
    }


    /**
     * Set responsableTarjeta
     *
     * @param string $responsableTarjeta
     * @return SecIngreso
     */
    public function setResponsableTarjeta($responsableTarjeta)
    {
        $this->responsableTarjeta = $responsableTarjeta;

        return $this;
    }

    /**
     * Get responsableTarjeta
     *
     * @return string 
     */
    public function getResponsableTarjeta()
    {
        return $this->responsableTarjeta;
    }

    /**
     * Set tarjetasEntregadas
     *
     * @param integer $tarjetasEntregadas
     * @return SecIngreso
     */
    public function setTarjetasEntregadas($tarjetasEntregadas)
    {
        $this->tarjetasEntregadas = $tarjetasEntregadas;

        return $this;
    }

    /**
     * Get tarjetasEntregadas
     *
     * @return integer 
     */
    public function getTarjetasEntregadas()
    {
        return $this->tarjetasEntregadas;
    }
}
