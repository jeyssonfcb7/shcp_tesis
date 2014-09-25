<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MntAreaModEstab
 *
 * @ORM\Table(name="mnt_area_mod_estab")
 * @ORM\Entity
 */
class MntAreaModEstab
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="mnt_area_mod_estab_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \CtlAreaAtencion
     *
     * @ORM\ManyToOne(targetEntity="CtlAreaAtencion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_area_atencion", referencedColumnName="id")
     * })
     */
    private $idAreaAtencion;

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
     * @var \MntModalidadEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="MntModalidadEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_modalidad_estab", referencedColumnName="id")
     * })
     */
    private $idModalidadEstab;

    /**
     * @ORM\ManyToMany(targetEntity="CtlAtencion")
     * @ORM\JoinTable(name="mnt_aten_area_mod_estab",
     *      joinColumns={@ORM\JoinColumn(name="id_area_mod_estab", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_atencion", referencedColumnName="id")}
     *      )
     */
    private $atenciones;
    
    /**
     * @var \idServicioExternoEstab
     *
     * @ORM\ManyToOne(targetEntity="MntServicioExternoEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_servicio_externo_estab", referencedColumnName="id")
     * })
     */
    private $idServicioExternoEstab;

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
     * Set idAreaAtencion
     *
     * @param \Minsal\SiapsBundle\Entity\CtlAreaAtencion $idAreaAtencion
     * @return MntAreaModEstab
     */
    public function setIdAreaAtencion(\Minsal\SiapsBundle\Entity\CtlAreaAtencion $idAreaAtencion = null)
    {
        $this->idAreaAtencion = $idAreaAtencion;
    
        return $this;
    }

    /**
     * Get idAreaAtencion
     *
     * @return \Minsal\SiapsBundle\Entity\CtlAreaAtencion 
     */
    public function getIdAreaAtencion()
    {
        return $this->idAreaAtencion;
    }

    /**
     * Set idEstablecimiento
     *
     * @param \Minsal\SiapsBundle\Entity\CtlEstablecimiento $idEstablecimiento
     * @return MntAreaModEstab
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
     * Set idModalidadEstab
     *
     * @param \Minsal\SiapsBundle\Entity\MntModalidadEstablecimiento $idModalidadEstab
     * @return MntAreaModEstab
     */
    public function setIdModalidadEstab(\Minsal\SiapsBundle\Entity\MntModalidadEstablecimiento $idModalidadEstab = null)
    {
        $this->idModalidadEstab = $idModalidadEstab;
    
        return $this;
    }

    /**
     * Get idModalidadEstab
     *
     * @return \Minsal\SiapsBundle\Entity\MntModalidadEstablecimiento 
     */
    public function getIdModalidadEstab()
    {
        return $this->idModalidadEstab;
    }
    
    /*Método __toString*/
    public function __toString() {
        return (string)  $this->idModalidadEstab.' - '.$this->idAreaAtencion . ' - ' . $this->idServicioExternoEstab ? : '';
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->atenciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add atenciones
     *
     * @param \Minsal\SiapsBundle\Entity\CtlAtencion $atenciones
     * @return MntAreaModEstab
     */
    public function addAtencione(\Minsal\SiapsBundle\Entity\CtlAtencion $atenciones)
    {
        $this->atenciones[] = $atenciones;
    
        return $this;
    }

    /**
     * Remove atenciones
     *
     * @param \Minsal\SiapsBundle\Entity\CtlAtencion $atenciones
     */
    public function removeAtencione(\Minsal\SiapsBundle\Entity\CtlAtencion $atenciones)
    {
        $this->atenciones->removeElement($atenciones);
    }

    /**
     * Get atenciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAtenciones()
    {
        return $this->atenciones;
    }

    /**
     * Set idServicioExternoEstab
     *
     * @param \Minsal\SiapsBundle\Entity\idServicioExternoEstablecimiento $idServicioExternoEstab
     * @return MntAreaModEstab
     */
    public function setIdServicioExternoEstab(\Minsal\SiapsBundle\Entity\MntServicioExternoEstablecimiento $idServicioExternoEstab = null)
    {
        $this->idServicioExternoEstab = $idServicioExternoEstab;

        return $this;
    }

    /**
     * Get idServicioExternoEstab
     *
     * @return \Minsal\SiapsBundle\Entity\MntServicioExternoEstablecimiento 
     */
    public function getIdServicioExternoEstab()
    {
        return $this->idServicioExternoEstab;
    }
}
