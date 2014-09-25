<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MntProgramaEstablecimiento
 *
 * @ORM\Table(name="mnt_programa_establecimiento")
 * @ORM\Entity
 */
class MntProgramaEstablecimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="mnt_programa_establecimiento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \CtlPrograma
     *
     * @ORM\ManyToOne(targetEntity="CtlPrograma")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_programa", referencedColumnName="id")
     * })
     */
    private $idPrograma;



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
     * Set idEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento
     * @return MntProgramaEstablecimiento
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
     * Set idPrograma
     *
     * @param \Minsal\SiapsBundle\Entity\CtlPrograma $idPrograma
     * @return MntProgramaEstablecimiento
     */
    public function setIdPrograma(\Minsal\SiapsBundle\Entity\CtlPrograma $idPrograma = null)
    {
        $this->idPrograma = $idPrograma;
    
        return $this;
    }

    /**
     * Get idPrograma
     *
     * @return \Minsal\SiapsBundle\Entity\CtlPrograma 
     */
    public function getIdPrograma()
    {
        return $this->idPrograma;
    }
}