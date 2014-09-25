<?php

namespace Minsal\SiapsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class MntCie10Admin extends Admin {

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('codigo',null,array('label'=>'Código CIE10'))
                ->add('diagnostico',null,array('label'=>'Diágnostico'))
            ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('codigo',null,array('label'=>'Código CIE10'))
                ->add('diagnostico',null,array('label'=>'Diágnostico'))
        ;
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('create');
        $collection->remove('edit');
        $collection->remove('delete');
        $collection->remove('view');
    }

}

?>
