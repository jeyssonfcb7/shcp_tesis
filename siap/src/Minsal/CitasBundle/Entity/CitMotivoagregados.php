<?php

namespace Minsal\CitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CitMotivoagregados
 *
 * @ORM\Table(name="cit_motivoagregados", indexes={@ORM\Index(name="IDX_BF66A4D442E04C4F", columns={"idestado"})})
 * @ORM\Entity
 */
class CitMotivoagregados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cit_motivoagregados_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo", type="string", length=500, nullable=true)
     */
    private $motivo;

    /**
     * @var \CitEstadoCita
     *
     * @ORM\ManyToOne(targetEntity="CitEstadoCita")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idestado", referencedColumnName="id")
     * })
     */
    private $idestado;



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
     * Set motivo
     *
     * @param string $motivo
     * @return CitMotivoagregados
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string 
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set idestado
     *
     * @param \Minsal\CitasBundle\Entity\CitEstadoCita $idestado
     * @return CitMotivoagregados
     */
    public function setIdestado(\Minsal\CitasBundle\Entity\CitEstadoCita $idestado = null)
    {
        $this->idestado = $idestado;

        return $this;
    }

    /**
     * Get idestado
     *
     * @return \Minsal\CitasBundle\Entity\CitEstadoCita 
     */
    public function getIdestado()
    {
        return $this->idestado;
    }
}
