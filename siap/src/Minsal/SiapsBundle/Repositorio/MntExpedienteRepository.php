<?php

namespace Minsal\SiapsBundle\Repositorio;

use Doctrine\ORM\EntityRepository;

/**
 * MntExpedienteRepository
 *
 */
class MntExpedienteRepository extends EntityRepository {
    /*
     * Devuelve el ultimo valor de un expediente en un determinado establecimiento
     */

    public function obtenerExpedienteSugerido() {
        $formato = $this->getEntityManager()
                        ->createQuery(
                                'SELECT e.tipoExpediente
                         FROM MinsalSiapsBundle:CtlEstablecimiento e
                         WHERE e.configurado=true'
                        )->getSingleResult();
        $conn = $this->getEntityManager()->getConnection();
        if ($formato['tipoExpediente'] == 'G') {
            $anio = date("y");
            $sql = "SELECT max(cast(split_part(numero,'-',1) as integer))+1 as numero from mnt_expediente WHERE numero like '%-$anio'";
            $query = $conn->query($sql);
            $query = $query->fetch();
            if (!is_null($query['numero']))
                return $query['numero'] . '-' . $anio;
            else
                return '1-' . $anio;
        } else {
            $sql = "SELECT max(cast(numero as integer))+1 as numero from mnt_expediente";
            $query = $conn->query($sql);
            $query = $query->fetch();
            if (!is_null($query['numero']))
                return $query['numero'];
            else
                return 1;
        }
    }

}

?>
