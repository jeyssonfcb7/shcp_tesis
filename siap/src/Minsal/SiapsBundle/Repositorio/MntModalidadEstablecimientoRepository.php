<?php

namespace Minsal\SiapsBundle\Repositorio;

use Doctrine\ORM\EntityRepository;

/**
 * MntModalidadEstablecimientoRepository
 *
 */
class MntModalidadEstablecimientoRepository extends EntityRepository {

    public function obtenerIdModalidadUtilizada($establecimiento) {
        $consulta = $this->getEntityManager()
                ->createQuery('
                  SELECT mod.id
                  FROM MinsalSiapsBundle:MntModalidadEstablecimiento m
                  JOIN m.idModalidad mod
                  WHERE m.idEstablecimiento = :establecimiento'
                )
                ->setParameter(':establecimiento', $establecimiento);

        return $consulta->getResult();
    }

    public function obtenerModalidadesEstablecimiento() {
        $establecimiento = $this->getEntityManager()
                ->getRepository('MinsalSiapsBundle:CtlEstablecimiento')
                ->obtenerEstablecimientoConfigurado();

        return $this->getEntityManager()
                        ->createQueryBuilder()
                        ->select('mod')
                        ->from('MinsalSiapsBundle:MntModalidadEstablecimiento', 'm')
                        ->join('m.idModalidad', 'mod')
                        ->where('m.idEstablecimiento = :establecimiento')
                        ->setParameter(':establecimiento', $establecimiento);
        ;
    }
}

?>
