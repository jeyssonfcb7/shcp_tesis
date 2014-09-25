<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Minsal\SiapsBundle\Entity\MntEmpleado;

class UserAdmin extends BaseUserAdmin {

    public function configureFormFields(FormMapper $formMapper) {
        $usuario = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        if ($usuario->getId() != 1) {
            $grupos = $usuario->getGroups();
            if ($grupos[0]->getId() != 1) {
                if ($grupos[0]->getName() != 'Modulo1regempleado') {
                    list($nombre) = explode('Admin', $grupos[0]->getName());
                    $query = $this
                            ->modelManager
                            ->getEntityManager('ApplicationSonataUserBundle:Group')
                            ->createQuery("
                            SELECT g
                            FROM ApplicationSonataUserBundle:Group g
                            WHERE g.name LIKE '%$nombre%'");
                } else {
                    $query = $this
                            ->modelManager
                            ->getEntityManager('ApplicationSonataUserBundle:Group')
                            ->createQuery("
                            SELECT g
                            FROM ApplicationSonataUserBundle:Group g
                            WHERE g.name LIKE 'Modulo6%'");
                }
            } else {
                $establecimiento = $this->getModelManager()
                        ->findOneBy('MinsalSiapsBundle:CtlEstablecimiento', array('configurado' => true));
                if ($establecimiento->getIdTipoEstablecimiento()->getId() == 1)
                    $nombre = 'Hos';
                else
                    $nombre = 'Us';
                $query = $this
                        ->modelManager
                        ->getEntityManager('ApplicationSonataUserBundle:Group')
                        ->createQuery("
                            SELECT g
                            FROM ApplicationSonataUserBundle:Group g
                            WHERE g.name LIKE '%$nombre%' OR g.name LIKE 'Modulo1r%'");
            }
        }else {
            $query = $this
                    ->modelManager
                    ->getEntityManager('ApplicationSonataUserBundle:Group')
                    ->createQuery("
                            SELECT g
                            FROM ApplicationSonataUserBundle:Group g");
        }
        $formMapper
                ->with('Datos Usuario')
                ->add('firstname', null, array('required' => true))
                ->add('lastname', null, array('required' => true))
                ->add('username')
                ->add('email', null, array('required' => false))
                ->add('plainPassword', 'repeated', array(
                    'required' => true,
                    'type' => 'password',
                    'label' => 'Contraseña del usuario',
                    'second_options' => array('label' => 'Confirmación de contraseña'),
                    'invalid_message' => 'Las contraseñas deben coincidir, vuelva a digitarla',
                ))
                ->add('idEstablecimiento', 'entity', array(
                    'read_only' => true,
                    'label' => 'Establecimiento',
                    'class' => 'MinsalSiapsBundle:CtlEstablecimiento',
                    'query_builder' => function($repositorio) {
                return $repositorio->obtenerEstabConfigurado();
            }))
                ->add('enabled', null, array('required' => true))
                ->add('groups', 'sonata_type_model', array('required' => true, 'expanded' => true,
                    'multiple' => true,
                    'by_reference' => true,
                    'query' => $query))
                ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('username')
                ->add('groups')
                ->add('enabled', null, array('editable' => true))
                ->add('createdAt')
        ;
    }

    public function getTemplate($name) {
        switch ($name) {
            case 'edit':
                return 'MinsalSiapsBundle:UserAdmin:edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $usuario = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        if ($usuario->getId() != 1) {
            $grupos = $usuario->getGroups();
            if ($grupos[0]->getId() != 1) {
                if ($grupos[0]->getName() != 'Modulo1regempleado') {
                    list($nombre) = explode('Admin', $grupos[0]->getName());

                    return new ProxyQuery(
                            $query
                                    ->where("s_groups.name LIKE '$nombre%'")
                    );
                } else {
                    return new ProxyQuery(
                            $query
                                    ->where("s_groups.name LIKE 'Modulo6%' OR s_groups.name LIKE 'Modulo1r%'")
                    );
                }
            } else {

                $establecimiento = $this->getModelManager()
                        ->findOneBy('MinsalSiapsBundle:CtlEstablecimiento', array('configurado' => true));
                if (!is_null($establecimiento)) {
                    if ($establecimiento->getIdTipoEstablecimiento()->getId() == 1)
                        $nombre = 'Hos';
                    else
                        $nombre = 'Us';
                    return new ProxyQuery(
                            $query
                                    ->where("s_groups.name LIKE '%$nombre%' OR s_groups.name LIKE 'Modulo6%' OR s_groups.name LIKE 'Modulo1r%'")
                    );
                } else
                    return $query;
            }//FIN DEL ELSE DE USUARIOS NO ADMINISTRADORES
        } else {
            return $query;
        }
    }

    /*
     * DESCRIPCIÓN: Función que se realiza despues de ingresar el usuario. Si es
     * un usuario del módulo 1 creara un empleado y se lo agregara al usuario.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    public function postPersist($usuario) {

        if ($usuario->hasGroup('Modulo1Hos') || $usuario->hasGroup('Modulo1HosAdmin') || $usuario->hasGroup('Modulo1Us') || $usuario->hasGroup('Modulo1UsAdmin')) {
            $empleado = new MntEmpleado();
            $empleado->setApellido($usuario->getLastName());
            $empleado->setNombre($usuario->getFirstName());
            $empleado->setNombreempleado($usuario->getFirstName() . ' ' . $usuario->getLastName());
            $idTipoEmpleado = $this->getModelManager()
                    ->findOneBy('MinsalSiapsBundle:MntTipoEmpleado', array('codigo' => 'ARC'));
            $empleado->setIdTipoEmpleado($idTipoEmpleado);
            $empleado->setIdEstablecimiento($usuario->getIdEstablecimiento());
            $this->getModelManager()->create($empleado);
            $usuario->setIdEmpleado($empleado);
        }
    }

}
