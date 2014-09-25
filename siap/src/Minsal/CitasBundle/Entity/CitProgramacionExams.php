<?php

namespace Minsal\CitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CitProgramacionExams
 *
 * @ORM\Table(name="cit_programacion_exams", indexes={@ORM\Index(name="fki_fos_user_user_cit_programacion_exams", columns={"idusuarioreg"}), @ORM\Index(name="fki_lab_examen_establecimiento_cit_programacion_examen", columns={"id_examen_establecimiento"}), @ORM\Index(name="fki_mnt_aten_area_mod_estab_cit_programacion_exams", columns={"id_aten_area_mod_estab"})})
 * @ORM\Entity
 */
class CitProgramacionExams
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cit_programacion_exams_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="rangotiempoprev", type="integer", nullable=true)
     */
    private $rangotiempoprev;

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
     * @var \Minsal\SiapsBundle\CtlEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="Minsal\SiapsBundle\Entity\CtlEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_establecimiento", referencedColumnName="id")
     * })
     */
    private $idEstablecimiento;

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
     * @var \LabExamenesxestablecimiento
     *
     * @ORM\ManyToOne(targetEntity="LabExamenesxestablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_examen_establecimiento", referencedColumnName="id")
     * })
     */
    private $idExamenEstablecimiento;



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
     * Set rangotiempoprev
     *
     * @param integer $rangotiempoprev
     * @return CitProgramacionExams
     */
    public function setRangotiempoprev($rangotiempoprev)
    {
        $this->rangotiempoprev = $rangotiempoprev;

        return $this;
    }

    /**
     * Get rangotiempoprev
     *
     * @return integer
     */
    public function getRangotiempoprev()
    {
        return $this->rangotiempoprev;
    }

    /**
     * Set fechahorareg
     *
     * @param \DateTime $fechahorareg
     * @return CitProgramacionExams
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
     * Set idAtenAreaModEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntAtenAreaModEstab $idAtenAreaModEstab
     * @return CitProgramacionExams
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
     * Set idEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento
     * @return CitProgramacionExams
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
     * Set idusuarioreg
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuarioreg
     * @return CitProgramacionExams
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
     * Set idExamenEstablecimiento
     *
     * @param \Minsal\CitasBundle\Entity\LabExamenesxestablecimiento $idExamenEstablecimiento
     * @return CitProgramacionExams
     */
    public function setIdExamenEstablecimiento(\Minsal\CitasBundle\Entity\LabExamenesxestablecimiento $idExamenEstablecimiento = null)
    {
        $this->idExamenEstablecimiento = $idExamenEstablecimiento;

        return $this;
    }

    /**
     * Get idExamenEstablecimiento
     *
     * @return \Minsal\CitasBundle\Entity\LabExamenesxestablecimiento
     */
    public function getIdExamenEstablecimiento()
    {
        return $this->idExamenEstablecimiento;
    }
}
