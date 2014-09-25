<?php

namespace Minsal\SiapsBundle\Repositorio;

use Doctrine\ORM\EntityRepository;

/**
 * CtlModalidadRepository
 *
 */
class CtlModalidadRepository extends EntityRepository {

    public function obtenerModalidades($ruta, $valor) {

        $establecimiento = $this->getEntityManager()
                ->getRepository('MinsalSiapsBundle:CtlEstablecimiento')
                ->obtenerEstablecimientoConfigurado();

        $modalidades = $this->getEntityManager()
                ->getRepository('MinsalSiapsBundle:MntModalidadEstablecimiento')
                ->obtenerIdModalidadUtilizada($establecimiento);

        if ($ruta == 'create')
            return $this->getEntityManager()
                            ->createQueryBuilder()
                            ->select('m')
                            ->from('MinsalSiapsBundle:CtlModalidad', 'm')
                            ->where('m.id NOT IN (:id)')
                            ->setParameter(':id', $modalidades ? : '0' );
        
        else if ($ruta=='edit')
            return $this->getEntityManager()
                        ->createQueryBuilder()
                            ->select('m')
                            ->from('MinsalSiapsBundle:CtlModalidad', 'm')
                            ->join('MinsalSiapsBundle:MntModalidadEstablecimiento','mm')
                            ->where('mm.idModalidad = m.id AND mm.id=:valor')
                            ->setParameter(':valor', $valor)
            ;
        
        else
            return $this->getEntityManager()
                        ->createQueryBuilder()
                            ->select('m')
                            ->from('MinsalSiapsBundle:CtlModalidad', 'm')
            ;
    }
}