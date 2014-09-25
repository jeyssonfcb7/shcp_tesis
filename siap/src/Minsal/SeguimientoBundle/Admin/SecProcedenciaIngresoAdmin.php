<?php

namespace Minsal\SeguimientoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Route\RouteCollection;

class SecProcedenciaIngresoAdmin extends Admin {

    public function getTemplate($name) {
        switch ($name) {
            case 'list':
                return 'MinsalSeguimientoBundle:SecIngreso:reporte_list.html.twig';
                break;

            default:
                return parent::getTemplate($name);
                break;
        }
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('create');
        $collection->remove('edit');
        $collection->remove('delete');
        $collection->remove('view');
    }

}

?>
