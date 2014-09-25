<?php

namespace Minsal\SeguimientoBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Minsal\Metodos\Funciones;

class SecEmergenciaAdminController extends Controller {

   
    //AGREGANDO LA RUTA RESUMEN AL CONTROLADOR
    public function resumenEmergenciaAction() {
        
        return $this->render($this->admin->getTemplate('resumen_emergencia'), array());
    }

}

?>
