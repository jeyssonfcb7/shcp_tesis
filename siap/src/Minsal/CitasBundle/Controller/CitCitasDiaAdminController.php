<?php
//src/Minsal/CitasBundle/Controller/CitCitasDiaAdminController.php

namespace Minsal\CitasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL as DBAL;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CitCitasDiaAdminController extends CRUDController {

    /**
     * return the Response object associated to the action
	 *
	 * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
	 * @return Response
	 */
	public function listAction() {

	if (false === $this->admin->isGranted('LIST')) {
		throw new AccessDeniedException();
	}

    $request = $this->get('request');

	$datagrid = $this->admin->getDatagrid();
	$formView = $datagrid->getForm()->createView();

	// set the theme for the current Admin Form
	$this->get('twig')->getExtension('form')->renderer->setTheme($formView,
	$this->admin->getFilterTheme());

	return

	$this->render('MinsalCitasBundle:Custom:index.html.twig',
		array(
			'action' => 'list',
			'form'   => $formView,
            'query'  => $request->query,
		));
	}

    /**
     * return the Response object associated to the create action
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return Response
     */
    public function createAction() {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        if ($this->getRestMethod()== 'POST') {
            $em      = $this->getDoctrine()->getManager();
            $request = $this->get('request');

            $idEmpleado   = $request->get('idEmpleado');
            $especialidad = $request->get('idEmpleadoEspecialidadEstab');
            $date         = new \DateTime($request->get('date'));
            $idRangohora  = $request->get('horarioMedico');
            $idExpediente = $request->get('numExpNomPac');
            $tipoCita     = 2;
            $today        = new \DateTime();
            $usuario      = $this->getUser();
            $ipcita       = $request->server->get('REMOTE_ADDR');

            try {
                $citDistribucion = $em->getRepository('MinsalCitasBundle:CitDistribucion')->findOneBy(
                    array(
                        'idEmpleado'         => $idEmpleado,
                        'dia'                => date( "w", $date->getTimestamp())+1,
                        'mes'                => date( "n", $date->getTimestamp()),
                        'yrs'                => date( "Y", $date->getTimestamp()),
                        'idAtenAreaModEstab' => $especialidad,
                        'idRangohora'        => $idRangohora
                        )
                    );

                /*Limite de subsecuentes que pueden ser asignados en el dia y hora al medico*/
                $subsecuentes = $citDistribucion->getSubsecuente();

                /*Preparando los campos para insersion o actualizacion*/
                $mntEmpleado = $em->getRepository('MinsalSiapsBundle:MntEmpleado')->findOneById($idEmpleado);
                $mntAtenAreaModEstab = $em->getRepository('MinsalSiapsBundle:MntAtenAreaModEstab')->findOneById($especialidad);

                /*Obteniendo el total de citas que posee el medico*/
                $qb = $em->createQueryBuilder();
                $totalCitas = $qb->select($qb->expr()->count('t01.id'))
                        ->from('MinsalCitasBundle:CitCitasDia', 't01')
                        ->where('t01.fecha = :fecha')
                        ->andWhere('t01.idEmpleado = :idEmpleado')
                        ->andWhere('t01.idTipocita = :idTipocita')
                        ->andWhere('t01.idAtenAreaModEstab = :especialidad')
                        ->andWhere('t01.idRangohora = :idRangohora')
                        ->setParameters(array(
                                ':fecha' => date('Y-m-d', $date->getTimestamp()),
                                ':idEmpleado'   => $idEmpleado,
                                ':idTipocita'   => $tipoCita,
                                ':especialidad' => $especialidad,
                                ':idRangohora'  => $idRangohora))
                        ->getQuery()
                        ->getSingleScalarResult();

                if($subsecuentes > $totalCitas) {
                    $idEstadoInsr = 1;
                    $idMotivoInsr = NULL;
                } else {
                    $idEstadoInsr = 6;
                    $idMotivoInsr = 2;
                }

                /*Obteniendo el total de citas asignadas*/
                $qb = $em->createQueryBuilder();
                $totalCitasAsignadas = $qb->select($qb->expr()->count('t01.id'))
                        ->from('MinsalCitasBundle:CitCitasDia', 't01')
                        ->where('t01.fecha = :fecha')
                        ->andWhere('t01.idEmpleado = :idEmpleado')
                        ->andWhere('t01.idTipocita = :idTipocita')
                        ->andWhere('t01.idAreaModEstab = :idAreaModEstab')
                        ->andWhere('t01.idRangohora = :idRangohora')
                        ->setParameters(array(
                                ':fecha' => date('Y-m-d', $date->getTimestamp()),
                                ':idEmpleado'     => $idEmpleado,
                                ':idTipocita'     => $tipoCita,
                                ':idAreaModEstab' => $mntAtenAreaModEstab->getIdAreaModEstab()->getId(),
                                ':idRangohora'    => $idRangohora))
                        ->getQuery()
                        ->getSingleScalarResult();

                if($subsecuentes > $totalCitasAsignadas) {
                    $idEstadoAct = 1;
                    $idMotivoAct = NULL;
                } else {
                    $idEstadoAct = 6;
                    $idMotivoAct = 2;
                }

                $parameters = array(
                        'idTipocita'         => $em->getRepository('MinsalCitasBundle:CitTipocita')->findOneById($tipoCita),
                        'idAtenAreaModEstab' => $mntAtenAreaModEstab,
                        'idEstadoInsr'       => $em->getRepository('MinsalCitasBundle:CitEstadoCita')->findOneById($idEstadoInsr),
                        'idMotivoInsr'       => $idMotivoInsr != NULL ? $em->getRepository('MinsalCitasBundle:CitMotivoagregados')->findOneById($idMotivoInsr) : $idMotivoInsr,
                        'idEstadoAct'        => $em->getRepository('MinsalCitasBundle:CitEstadoCita')->findOneById($idEstadoAct),
                        'idMotivoAct'        => $idMotivoAct != NULL ? $em->getRepository('MinsalCitasBundle:CitMotivoagregados')->findOneById($idMotivoAct) : $idMotivoAct,
                        'fecha'              => $date,
                        'idusuarioreg'       => $usuario,
                        'fechahorareg'       => $today,
                        'ipcita'             => $ipcita,
                        'idEmpleado'         => $mntEmpleado,
                        'idExpediente'       => $em->getRepository('MinsalSiapsBundle:MntExpediente')->findOneById($idExpediente),
                        'idEstablecimiento'  => $mntEmpleado->getIdEstablecimiento(),
                        'idRangohora'        => $em->getRepository('MinsalSiapsBundle:MntRangohora')->findOneById($idRangohora),
                        'idAreaModEstab'     => $mntAtenAreaModEstab->getIdAreaModEstab()
                    );
                //var_dump($parameters);exit();
                $qb = $em->createQueryBuilder();
                $citaPrevia = $qb->select('t01')
                        ->from('MinsalCitasBundle:CitCitasDia', 't01')
                        ->where('t01.fecha > :today')
                        ->andWhere('t01.idEmpleado = :idEmpleado')
                        ->andWhere('t01.idExpediente = :idExpediente')
                        ->andWhere('t01.idAtenAreaModEstab = :especialidad')
                        ->andWhere('t01.idEstado = 1 OR t01.idEstado = 6')
                        ->setParameters(array(
                            ':today' => date('Y-m-d', $today->getTimestamp()),
                            ':idEmpleado'   => $mntEmpleado->getId(),
                            ':idExpediente' => $idExpediente,
                            ':especialidad' => $especialidad))
                    ->getQuery()
                    ->getResult();

                if($citaPrevia) {
                    $this->updateCita($citaPrevia[0]->getId(), $parameters);
                    $id = $citaPrevia[0]->getId();
                } else {
                    $id = $this->insertCita($parameters);
                }

                $url = $this->generateUrl('citasgetcomprobante');
                $comprobante = '<form id="_comprobante-form" method="POST" action="'.$url.'" target="_blank" style="margin:0;">
                                    <input type="hidden" name="id" value="'.$id.'" /><br />
                                    <a href="javascript:void(0);" onclick="document.getElementById(\'_comprobante-form\').submit();">
                                        <span class="label label-success mouse-pointer" style="margin-top:5px;">Ver comprobante</span>
                                    </a>
                                </form>';
                $this->addFlash('sonata_flash_success', 'Cita creada exitosamente '.$comprobante);

            } catch(\Exception $e) {
                $this->addFlash('sonata_flash_error', 'Eror en la generacion de la cita... Detalle del Erro: '.$e);
            }

            return new RedirectResponse($this->admin->generateUrl('list', array('idEmpleado' => $idEmpleado, 'idEspecialidad' => $especialidad, 'month' => date( "n", $date->getTimestamp())-1, 'year' => date( "Y", $date->getTimestamp()) )));
        } else {
            throw new AccessDeniedException();
        }
    }

    private function insertCita($parameters) {
        $object  = $this->admin->getNewInstance();

        $object->setIdTipocita($parameters['idTipocita']);
        $object->setIdAtenAreaModEstab($parameters['idAtenAreaModEstab']);
        $object->setIdEstado($parameters['idEstadoInsr']);
        $object->setFecha($parameters['fecha']);
        $object->setIdusuarioreg($parameters['idusuarioreg']);
        $object->setfechahorareg($parameters['fechahorareg']);
        $object->setIdMotivo($parameters['idMotivoInsr']);
        $object->setIpcita($parameters['ipcita']);
        $object->setIdEmpleado($parameters['idEmpleado']);
        $object->setIdExpediente($parameters['idExpediente']);
        $object->setIdEstablecimiento($parameters['idEstablecimiento']);
        $object->setIdRangohora($parameters['idRangohora']);
        $object->setIdAreaModEstab($parameters['idAreaModEstab']);

        $this->admin->create($object);

        return $object->getId();
    }

    private function updateCita($id, $parameters) {
        $em = $this->getDoctrine()->getManager();
        $citCitasDia = $em->getRepository('MinsalCitasBundle:CitCitasDia')->findOneById($id);

        $citCitasDia->setIdEstado($parameters['idEstadoAct']);
        $citCitasDia->setFecha($parameters['fecha']);
        $citCitasDia->setIdMotivo($parameters['idMotivoAct']);
        $citCitasDia->setIdRangohora($parameters['idRangohora']);

        $this->admin->update($citCitasDia);
    }
}
