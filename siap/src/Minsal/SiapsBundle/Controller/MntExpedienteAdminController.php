<?php

namespace Minsal\SiapsBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class MntExpedienteAdminController extends Controller {

    public function listAction() {
        if (false === $this->admin->isGranted('LIST')) {
            return $this->render('MinsalSiapsBundle::Accesso_denegado.html.twig', array('admin_pool' => $this->container->get('sonata.admin.pool'),
                        'layout' => $this->container->get('sonata.admin.pool')->getTemplate('layout')
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $establecimiento = $em->getRepository("MinsalSiapsBundle:CtlEstablecimiento")->obtenerEstablecimientoConfigurado();

        return $this->render($this->admin->getTemplate('list'), array(
                    'action' => 'list',
                    'establecimiento' => $establecimiento
        ));
    }

    public function listarexpedientesAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user->hasRole('ROLE_USER_LISTAREXPEDIENTES') === false && $user->hasRole('ROLE_SUPER_ADMIN') === false) {
            return $this->render('MinsalSiapsBundle::Accesso_denegado.html.twig', array('admin_pool' => $this->container->get('sonata.admin.pool'),
                        'layout' => $this->container->get('sonata.admin.pool')->getTemplate('layout')
            ));
        }
        
        return $this->render($this->admin->getTemplate('listarexpedientes'), array(
                    'action' => 'listarexpedientes'
        ));
    }

}
