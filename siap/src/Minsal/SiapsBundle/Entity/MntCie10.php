<?php

namespace Minsal\SiapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MntCie10
 *
 * @ORM\Table(name="mnt_cie10")
 * @ORM\Entity
 */
class MntCie10
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ctl_cie10_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=5, nullable=false)
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="codgrupo", type="integer", nullable=false)
     */
    private $codigoGrupo = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="grupom", type="integer", nullable=false)
     */
    private $grupoM = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="diagnostico", type="string", length=130, nullable=false)
     */
    private $diagnostico = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="alarma", type="integer", nullable=true)
     */
    private $alarma = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="sexo_cie10", type="integer", nullable=true)
     */
    private $sexo = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="c_salida", type="integer", nullable=true)
     */
    private $salida;

    /**
     * @var integer
     *
     * @ORM\Column(name="mayor", type="integer", nullable=true)
     */
    private $mayor;

    /**
     * @var integer
     *
     * @ORM\Column(name="menor", type="integer", nullable=true)
     */
    private $menor;

    /**
     * @var integer
     *
     * @ORM\Column(name="critico", type="integer", nullable=true)
     */
    private $critico = '0';



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
     * @return MntCie10
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
     * Set codigoGrupo
     *
     * @param integer $codigoGrupo
     * @return MntCie10
     */
    public function setCodigoGrupo($codigoGrupo)
    {
        $this->codigoGrupo = $codigoGrupo;

        return $this;
    }

    /**
     * Get codigoGrupo
     *
     * @return integer 
     */
    public function getCodigoGrupo()
    {
        return $this->codigoGrupo;
    }

    /**
     * Set grupoM
     *
     * @param integer $grupoM
     * @return MntCie10
     */
    public function setGrupoM($grupoM)
    {
        $this->grupoM = $grupoM;

        return $this;
    }

    /**
     * Get grupoM
     *
     * @return integer 
     */
    public function getGrupoM()
    {
        return $this->grupoM;
    }

    /**
     * Set diagnostico
     *
     * @param string $diagnostico
     * @return MntCie10
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return string 
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * Set alarma
     *
     * @param integer $alarma
     * @return MntCie10
     */
    public function setAlarma($alarma)
    {
        $this->alarma = $alarma;

        return $this;
    }

    /**
     * Get alarma
     *
     * @return integer 
     */
    public function getAlarma()
    {
        return $this->alarma;
    }

    /**
     * Set sexo
     *
     * @param integer $sexo
     * @return MntCie10
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return integer 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set salida
     *
     * @param integer $salida
     * @return MntCie10
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;

        return $this;
    }

    /**
     * Get salida
     *
     * @return integer 
     */
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * Set mayor
     *
     * @param integer $mayor
     * @return MntCie10
     */
    public function setMayor($mayor)
    {
        $this->mayor = $mayor;

        return $this;
    }

    /**
     * Get mayor
     *
     * @return integer 
     */
    public function getMayor()
    {
        return $this->mayor;
    }

    /**
     * Set menor
     *
     * @param integer $menor
     * @return MntCie10
     */
    public function setMenor($menor)
    {
        $this->menor = $menor;

        return $this;
    }

    /**
     * Get menor
     *
     * @return integer 
     */
    public function getMenor()
    {
        return $this->menor;
    }

    /**
     * Set critico
     *
     * @param integer $critico
     * @return MntCie10
     */
    public function setCritico($critico)
    {
        $this->critico = $critico;

        return $this;
    }

    /**
     * Get critico
     *
     * @return integer 
     */
    public function getCritico()
    {
        return $this->critico;
    }
}
