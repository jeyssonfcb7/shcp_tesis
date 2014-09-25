<?php

namespace Minsal\SiapsBundle\Repositorio;

use Doctrine\ORM\EntityRepository;
use Minsal\SiapsBundle\Entity\MntPaciente;
/**
 * MntPacienteRepository
 *
 */
class MntPacienteRepository extends EntityRepository {

    public function obtenerdatosPaciente($valor) {

        $dql="SELECT p,u,e
              FROM MinsalSiapsBundle:MntPaciente p
              LEFT JOIN p.expedientes e
              LEFT JOIN p.idUser u
              WHERE p.id =:valor";
        $paciente = $this->getEntityManager()
                ->getRepository('MinsalSiapsBundle:MntPaciente')
                ->find($valor);
      
        if(count($paciente->getExpedientes())>0)
                $dql.=" AND e.habilitado=true";
        $consulta = $this->getEntityManager()
                ->createQuery($dql)
                ->setParameter(':valor', $valor);
        
        try {
            return $consulta->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return new MntPaciente();
        }
    }

}

?>