<?php

namespace Minsal\CitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CitTipoevento
 *
 * @ORM\Table(name="cit_tipoevento")
 * @ORM\Entity
 */
class CitTipoevento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cit_tipoevento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombretipo", type="string", nullable=true)
     */
    private $nombretipo;



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
     * Set nombretipo
     *
     * @param string $nombretipo
     * @return CitTipoevento
     */
    public function setNombretipo($nombretipo)
    {
        $this->nombretipo = $nombretipo;

        return $this;
    }

    /**
     * Get nombretipo
     *
     * @return string 
     */
    public function getNombretipo()
    {
        return $this->nombretipo;
    }
}
