<?php

namespace Minsal\SeguimientoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Minsal\Metodos\Funciones;

class SecEmergenciaAdmin extends Admin {

    public function getTemplate($name) {
        switch ($name) {
            case 'list':
                return 'MinsalSeguimientoBundle:SecEmergencia:list.html.twig';
                break;
            case 'resumen_emergencia':
                return 'MinsalSeguimientoBundle:SecEmergencia:resumen_emergencia.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

   protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('create'); //POR SI SE ENVIA PARAMETROS
        $collection->remove('edit');
        $collection->remove('delete');
        $collection->remove('view');
        $collection->add('resumen_emergencia', 'resumen/emergencia');
    }

}

?>
