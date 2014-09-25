<?php

namespace Minsal\SiapsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class MntCiqAdmin extends Admin {
 protected $datagridValues = array(
        '_page' => 1, // Display the first page (default = 1)
        '_sort_order' => 'ASC', // Descendant ordering (default = 'ASC')
        '_sort_by' => 'codigo' // name of the ordered field (default = the model id field, if any)
    );
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('codigo',null,array('label'=>'Código CIE9'))
                ->add('procedimiento',null,array('label'=>'Procedimiento'))
                ->add('idTipoProcedimiento',null,array('label'=>'Tipo de Procedimiento'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('codigo',null,array('label'=>'Código CIE9'))
                ->add('procedimiento',null,array('label'=>'Procedimiento'))
                ->add('idTipoProcedimiento',null,array('label'=>'Tipo de Procedimiento'))
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
