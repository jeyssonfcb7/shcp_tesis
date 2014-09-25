<?php

namespace Minsal\SiapsBundle\Repositorio;

use Doctrine\ORM\EntityRepository;

/**
 * CtlPaisRepository
 *
 */
class CtlPaisRepository extends EntityRepository {

    public function obtenerPaisHabilitado() {

        return $this->getEntityManager()
                        ->createQueryBuilder()
                        ->select('p')
                        ->from('MinsalSiapsBundle:CtlPais', 'p')
                        ->where('p.activo = true');
    }

}
