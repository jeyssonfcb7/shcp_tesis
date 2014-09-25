<?php
// src/Application/Sonata/UserBundle/Controller/AdminSecurityController.php
namespace Application\Sonata\UserBundle\Controller;

use Sonata\UserBundle\Controller\AdminSecurityController as BaseController;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminSecurityController extends BaseController {

    /**
     * {@inheritdoc}
     */
    public function loginAction() {

        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($user instanceof UserInterface) {
            $this->container->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');
            $url = $this->container->get('router')->generate('sonata_user_profile_show');

            return new RedirectResponse($url);
        }

        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session */

        if( ($request->query->get('_moduleSelection') === null) && $session->has(SecurityContext::AUTHENTICATION_ERROR) == false ) {	//verificacion de seleccion de modulo

            //Definiendo los parametros de la url de cada modulo a cargar
            $urlModule['module1'] = $this->container->getParameter('module1_url');
            $urlModule['module2'] = $this->container->getParameter('module2_url');
            $urlModule['module3'] = $this->container->getParameter('module3_url');
            $urlModule['module4'] = $this->container->getParameter('module4_url');
            $urlModule['module5'] = $this->container->getParameter('module5_url');
            $urlModule['module6'] = $this->container->getParameter('module6_url');

            // redireccionar a la pagina de seleccion de modulo
            return $this->container->get('templating')->renderResponse('ApplicationCoreBundle::index.html.twig', array('urlModule' => $urlModule));
        } else {

            // get the error if any (works with forward and redirect -- see below)
            if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
            } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
                $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                $session->remove(SecurityContext::AUTHENTICATION_ERROR);
            } else {
                $error = '';
            }

            if ($error) {
                // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
                $error = $error->getMessage();
            }
            // last username entered by the user
            $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

            $csrfToken = $this->container->has('form.csrf_provider')
                ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
                : null;

            if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
                $refererUri = $request->server->get('HTTP_REFERER');

                return new RedirectResponse($refererUri && $refererUri != $request->getUri() ? $refererUri : $this->container->get('router')->generate('sonata_admin_dashboard'));
            }

            return $this->container->get('templating')->renderResponse('SonataUserBundle:Admin:Security/login.html.'.$this->container->getParameter('fos_user.template.engine'), array(
                    'last_username' => $lastUsername,
                    'error'         => $error,
                    'csrf_token'    => $csrfToken,
                    'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                    'admin_pool'    => $this->container->get('sonata.admin.pool'),
                    'module'		=> $request->query->get('_moduleSelection') ? '_moduleSelection='.$request->query->get('_moduleSelection') : strstr($request->server->get('HTTP_REFERER'), '_moduleSelection')
                ));
        }
    }
}
