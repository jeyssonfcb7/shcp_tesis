<?php

namespace Minsal\SiapsBundle\Repositorio;

use Doctrine\ORM\EntityRepository;
use Minsal\SiapsBundle\Entity\CtlEstablecimiento;

/**
 * CtlEstablecimientoRepository
 *
 */
class CtlEstablecimientoRepository extends EntityRepository {

    public function obtenerEstablecimientoConfigurado() {
        $establecimiento = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('e')
                ->from('MinsalSiapsBundle:CtlEstablecimiento', 'e')
                ->where('e.configurado = true')
                ->getQuery();

        try {
            return $establecimiento->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return new CtlEstablecimiento();
        }
    }

    public function obtenerEstabConfigurado() {

        return $this->getEntityManager()
                        ->createQueryBuilder()
                        ->select('e')
                        ->from('MinsalSiapsBundle:CtlEstablecimiento', 'e')
                        ->where('e.configurado = true');
    }

    public function obtenerEstablecimientosCoexion($ruta, $valor) {

        $regiones = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('e.id')
                ->from('MinsalSiapsBundle:MntConexion', 'c')
                ->join('c.idEstablecimiento', 'e')
                ->getQuery()
                ->getResult()
        ;

        if ($ruta == 'create')
            return $this->getEntityManager()
                            ->createQueryBuilder()
                            ->select('e')
                            ->from('MinsalSiapsBundle:CtlEstablecimiento', 'e')
                            ->join('e.idTipoEstablecimiento', 'te')
                            ->where('e.id NOT IN (:id)')
                            ->andWhere('te.id=12')
                            ->setParameter(':id', $regiones ? : '0' );

        else if ($ruta == 'edit')
            return $this->getEntityManager()
                            ->createQueryBuilder()
                            ->select('e')
                            ->from('MinsalSiapsBundle:CtlEstablecimiento', 'e')
                            ->where('e.id =:valor')
                            ->setParameter(':valor', $valor)
            ;
        else
            return $this->getEntityManager()
                            ->createQueryBuilder()
                            ->select('e')
                            ->from('MinsalSiapsBundle:CtlEstablecimiento', 'e')
                            ->join('e.idTipoEstablecimiento', 'te')
                            ->where('te.id=12')
            ;
    }

}
