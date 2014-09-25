<?php

namespace Minsal\SiapsBundle\Repositorio;

use Doctrine\ORM\EntityRepository;

/**
 * MntAtenAreaModEstabRepository
 *
 */
class MntAtenAreaModEstabRepository extends EntityRepository {

    public function obtenerModalidadesUtilizada() {
        $consulta = $this->getEntityManager()
                ->createQuery('
                  SELECT distinct(mod.id) id,mod.nombre 
                  FROM MinsalSiapsBundle:MntAtenAreaModEstab atenAreaModEstab
                  JOIN atenAreaModEstab.idAreaModEstab areaModEstab
                  JOIN areaModEstab.idModalidadEstab modEstab
                  JOIN modEstab.idModalidad mod
                  '
                )
                ;

        return $consulta->getResult();
    }
    
    public function obtenerAreaAtencionUtilizada($modalidad) {
        $consulta = $this->getEntityManager()
                ->createQuery('
                  SELECT distinct(areaAten.id) id,areaAten.nombre
                  FROM MinsalSiapsBundle:MntAtenAreaModEstab atenAreaModEstab
                  JOIN atenAreaModEstab.idAreaModEstab areaModEstab
                  JOIN areaModEstab.idModalidadEstab modEstab
                  JOIN areaModEstab.idAreaAtencion areaAten
                  WHERE modEstab.idModalidad =:modalidad
                  '
                )
                ->setParameter('modalidad', $modalidad)
                ;

        return $consulta->getResult();
    }
    
    public function obtenerAtencionesPadresModalidad($modalidad,$areaAten) {
        $consulta = $this->getEntityManager()
                ->createQuery('
                  SELECT aten.id,aten.nombre,tipoAten.id tipo
                  FROM MinsalSiapsBundle:MntAtenAreaModEstab atenAreaModEstab
                  JOIN atenAreaModEstab.idAreaModEstab areaModEstab
                  JOIN areaModEstab.idModalidadEstab modEstab
                  JOIN areaModEstab.idAreaAtencion areaAten
                  JOIN atenAreaModEstab.idAtencion aten
                  JOIN aten.idTipoAtencion tipoAten
                  WHERE modEstab.idModalidad =:modalidad 
                        AND areaModEstab.idAreaAtencion =:areaAtencion 
                        AND aten.idAtencionPadre IS NULL
                  ORDER BY tipoAten.id
                  '
                )
                ->setParameters(array('modalidad'=> $modalidad,'areaAtencion'=>$areaAten))
                ;

        return $consulta->getResult();
    }
    
    public function obtenerAtencionesHijasModalidad($modalidad,$areaAten,$idPadre) {
        $consulta = $this->getEntityManager()
                ->createQuery('
                  SELECT aten.id,aten.nombre
                  FROM MinsalSiapsBundle:MntAtenAreaModEstab atenAreaModEstab
                  JOIN atenAreaModEstab.idAreaModEstab areaModEstab
                  JOIN areaModEstab.idModalidadEstab modEstab
                  JOIN areaModEstab.idAreaAtencion areaAten
                  JOIN atenAreaModEstab.idAtencion aten                  
                  WHERE modEstab.idModalidad =:modalidad 
                        AND areaModEstab.idAreaAtencion =:areaAtencion 
                        AND aten.idAtencionPadre = :idPadre
                  '
                )
                ->setParameters(array('modalidad'=> $modalidad,'areaAtencion'=>$areaAten,'idPadre'=>$idPadre))
                ;

        return $consulta->getResult();
    }
    
}

?>
