<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MntCiq
 *
 * @ORM\Table(name="mnt_ciq")
 * @ORM\Entity
 */
class MntCiq
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ctl_ciq_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

      /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=6, nullable=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="procedimiento", type="string", length=250, nullable=false)
     */
    private $procedimiento;

   /**
     * @var \MntTipoProcedimiento
     *
     * @ORM\ManyToOne(targetEntity="MntTipoProcedimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_procedimiento", referencedColumnName="id",nullable=false)
     * })
     */
    private $idTipoProcedimiento;

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
     * Set codigo
     *
     * @param string $codigo
     * @return MntCiq
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set procedimiento
     *
     * @param string $procedimiento
     * @return MntCiq
     */
    public function setProcedimiento($procedimiento)
    {
        $this->procedimiento = $procedimiento;

        return $this;
    }

    /**
     * Get procedimiento
     *
     * @return string 
     */
    public function getProcedimiento()
    {
        return $this->procedimiento;
    }

    /**
     * Set idTipoProcedimiento
     *
     * @param \Minsal\SiapsBundle\Entity\MntTipoProcedimiento $idTipoProcedimiento
     * @return MntCiq
     */
    public function setIdTipoProcedimiento(\Minsal\SiapsBundle\Entity\MntTipoProcedimiento $idTipoProcedimiento)
    {
        $this->idTipoProcedimiento = $idTipoProcedimiento;

        return $this;
    }

    /**
     * Get idTipoProcedimiento
     *
     * @return \Minsal\SiapsBundle\Entity\MntTipoProcedimiento 
     */
    public function getIdTipoProcedimiento()
    {
        return $this->idTipoProcedimiento;
    }
}
