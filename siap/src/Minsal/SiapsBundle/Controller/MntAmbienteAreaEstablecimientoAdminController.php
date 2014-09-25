<?php

namespace Minsal\SiapsBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Minsal\SiapsBundle\Entity\MntAmbienteAreaEstablecimiento;

class MntAmbienteAreaEstablecimientoAdminController extends Controller {

    /**
     * REESCRITO PARA QUE CUANDO SEA LA BUSQUEDA DE LA REGIONAL LE CARGUE POR DEFECTO LOS VALORES QUE POSEE
     * EL PACIENTE Y ASÍ SOLO LLENE LOS CAMPOS QUE HAGAN FALTA
     * 
     * return the Response object associated to the create action
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return Response
     */
    public function createAction() {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            return $this->render('MinsalSiapsBundle::Accesso_denegado.html.twig', array('admin_pool' => $this->container->get('sonata.admin.pool'),
                        'layout' => $this->container->get('sonata.admin.pool')->getTemplate('layout')
            ));
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->bind($this->get('request'));
            $request = $this->get('request');
            $em = $this->getDoctrine()->getManager();

            $establecimiento = $em->getRepository('MinsalSiapsBundle:CtlEstablecimiento')
                    ->findOneBy(array('configurado' => true));

            if ($request->get('numero_ambientes') == '') {
                if ($request->get('por_sexo') == 'on') {
                    $ambiente = new MntAmbienteAreaEstablecimiento();
                    $ambiente->setIdAtenAreaModEstab($object->getIdAtenAreaModEstab());
                    $ambiente->setIdEstablecimiento($establecimiento);
                    $ambiente->setNombre($request->get('muj_nombre'));
                    $this->admin->create($ambiente);
                    $ambiente = new MntAmbienteAreaEstablecimiento();
                    $ambiente->setIdAtenAreaModEstab($object->getIdAtenAreaModEstab());
                    $ambiente->setIdEstablecimiento($establecimiento);
                    $ambiente->setNombre($request->get('hom_nombre'));
                    $this->admin->create($ambiente);
                } else {
                    $ambiente = new MntAmbienteAreaEstablecimiento();
                    $ambiente->setIdAtenAreaModEstab($object->getIdAtenAreaModEstab());
                    $ambiente->setIdEstablecimiento($establecimiento);
                    $ambiente->setNombre($request->get('nombre'));
                    $this->admin->create($ambiente);
                }
            } else {
                if ($request->get('por_sexo') == 'on') {
                    for ($i = 1; $i <= $request->get('numero_ambientes'); $i++) {
                        $ambiente = new MntAmbienteAreaEstablecimiento();
                        $ambiente->setIdAtenAreaModEstab($object->getIdAtenAreaModEstab());
                        $ambiente->setIdEstablecimiento($establecimiento);
                        $ambiente->setNombre($request->get($i . '_muj_nombre'));
                        $this->admin->create($ambiente);
                        $ambiente = new MntAmbienteAreaEstablecimiento();
                        $ambiente->setIdAtenAreaModEstab($object->getIdAtenAreaModEstab());
                        $ambiente->setIdEstablecimiento($establecimiento);
                        $ambiente->setNombre($request->get($i . '_hom_nombre'));
                        $this->admin->create($ambiente);
                    }
                } else {
                    for ($i = 1; $i <= $request->get('numero_ambientes'); $i++) {
                        $ambiente = new MntAmbienteAreaEstablecimiento();
                        $ambiente->setIdAtenAreaModEstab($object->getIdAtenAreaModEstab());
                        $ambiente->setIdEstablecimiento($establecimiento);
                        $ambiente->setNombre($request->get($i . '_nombre'));
                        $this->admin->create($ambiente);
                    }
                }
            }
            // redirect to edit mode

            $this->addFlash('sonata_flash_success', 'flash_create_success');
            return $this->redirectTo($object);
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
        ));
    }

    /**
     * return the Response object associated to the edit action
     *
     *
     * @param mixed $id
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return Response
     */
    public function editAction($id = null) {
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            return $this->render('MinsalSiapsBundle::Accesso_denegado.html.twig', array('admin_pool' => $this->container->get('sonata.admin.pool'),
                        'layout' => $this->container->get('sonata.admin.pool')->getTemplate('layout')
            ));
        }
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->bind($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

                $this->admin->update($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                                'result' => 'ok',
                                'objectId' => $this->admin->getNormalizedIdentifier($object)
                    ));
                }

                $this->addFlash('sonata_flash_success', 'flash_edit_success');

                // redirect to edit mode
                return $this->redirectTo($object);
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', 'flash_edit_error');
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render(
                        'MinsalSiapsBundle:MntAmbienteAreaEstablecimiento:editar.html.twig', array(
                    'action' => 'edit',
                    'form' => $view,
                    'object' => $object,
        ));
    }

    /**
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException|\Symfony\Component\Security\Core\Exception\AccessDeniedException
     *
     * @param mixed $id
     *
     * @return Response|RedirectResponse
     */
    public function deleteAction($id) {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('DELETE', $object)) {
            return $this->render('MinsalSiapsBundle::Accesso_denegado.html.twig', array('admin_pool' => $this->container->get('sonata.admin.pool'),
                        'layout' => $this->container->get('sonata.admin.pool')->getTemplate('layout')
            ));
        }

        if ($this->getRestMethod() == 'DELETE') {
            // check the csrf token
            $this->validateCsrfToken('sonata.delete');

            try {
                $this->admin->delete($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'ok'));
                }

                $this->addFlash('sonata_flash_success', 'flash_delete_success');
            } catch (ModelManagerException $e) {

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'error'));
                }

                $this->addFlash('sonata_flash_error', 'flash_delete_error');
            }

            return new RedirectResponse($this->admin->generateUrl('list'));
        }

        return $this->render($this->admin->getTemplate('delete'), array(
                    'object' => $object,
                    'action' => 'delete',
                    'csrf_token' => $this->getCsrfToken('sonata.delete')
        ));
    }

}

?>
