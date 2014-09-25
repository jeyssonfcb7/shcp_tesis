<?php

namespace Minsal\SiapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL as DBAL;
use FOS\UserBundle\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Util\TokenGenerator;

class GeneralesController extends Controller {
    /*
     * DESCRIPCIÓN: Función para que el FosUserBundle pueda imprimir el mensaje
     * de cambiar contraseña con éxito.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/", name="sonata_user_profile_show")
     */
    public function raiz() {
        $this->get('session')->getFlashBag()->add(
                'notice', 'change_password.flash.success'
        );

        return $this->redirect($this->generateUrl('_inicio'));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve un JSON con los departamentos de acuerdo
     * al idPais que se envia.
     * ANALISTA PROGRAMADOR: Victoria López
     */

    /**
     * @Route("/departamentos/get", name="get_departamentos", options={"expose"=true})
     * @Method("GET")
     */
    public function getDepartamentosAction() {

        $request = $this->getRequest();
        $idPais = $request->get('idPais');
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT d FROM MinsalSiapsBundle:CtlDepartamento d
                    WHERE d.idPais = :idPais ";
        $departamentos['deptos'] = $em->createQuery($dql)
                ->setParameter('idPais', $idPais)
                ->getArrayResult();

        return new Response(json_encode($departamentos));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve un JSON con los municipios de acuerdo
     * al idDepartamento que se envia.
     * ANALISTA PROGRAMADOR: Victoria López
     */

    /**
     * @Route("/municipios/get", name="get_municipios", options={"expose"=true})
     * @Method("GET")
     */
    public function getMunicipiosAction() {

        $request = $this->getRequest();
        $idDepartamento = $request->get('idDepartamento');
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT m FROM MinsalSiapsBundle:CtlMunicipio m
                    WHERE m.idDepartamento = :idDepartamento ";
        $municipios['municipios'] = $em->createQuery($dql)
                ->setParameter('idDepartamento', $idDepartamento)
                ->getArrayResult();

        return new Response(json_encode($municipios));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve un JSON con los cantones de acuerdo
     * al idMunicipio que se envia.
     * ANALISTA PROGRAMADOR: Victoria López
     */

    /**
     * @Route("/cantones/get", name="get_cantones", options={"expose"=true})
     * @Method("GET")
     */
    public function getCantonesAction() {

        $request = $this->getRequest();
        $idMunicipio = $request->get('idMunicipio');
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT c FROM MinsalSiapsBundle:CtlCanton c
                    WHERE c.idMunicipio = :idMunicipio ";
        $cantones['cantones'] = $em->createQuery($dql)
                ->setParameter('idMunicipio', $idMunicipio)
                ->getArrayResult();

        return new Response(json_encode($cantones));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve un JSON de los paises
     * habilitados.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/paises/get", name="get_paises", options={"expose"=true})
     */
    public function getPaisesHabilitadosAction() {
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT p
                FROM MinsalSiapsBundle:CtlPais p
                WHERE p.activo = TRUE
                ORDER BY p.nombre";
        $paises['paises'] = $em->createQuery($dql)
                ->getArrayResult();

        return new Response(json_encode($paises));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve un JSON de los paises
     * habilitados.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/pais/depto/get", name="get_pais_depto", options={"expose"=true})
     */
    public function obtenerPaisPorDeptoAction() {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $dql = "SELECT p.id
                FROM MinsalSiapsBundle:CtlDepartamento d
                JOIN d.idPais p
                WHERE d.id= :departamento";
        $aux = $em->createQuery($dql)
                ->setParameter('departamento', $request->get('idDepartamento'))
                ->getArrayResult();
        $pais['pais'] = $aux[0]['id'];
        return new Response(json_encode($pais));
    }

    /*
     * DESCRIPCIÓN: Método que devuelve un JSON con los usuarios de archivo.
     * ANALISTA PROGRAMADOR: Karen Peñate
     */

    /**
     * @Route("/usuarios/archivos/get", name="obtener_usuarios_archivo", options={"expose"=true})
     */
    public function getUsuariosArchivosAction() {

        $em = $this->getDoctrine()->getManager();
        $establecimiento = $em->getRepository("MinsalSiapsBundle:CtlEstablecimiento")->obtenerEstablecimientoConfigurado();
        if ($establecimiento->getIdTipoEstablecimiento()->getId() == 1)
            $restriccion = 'Hos';
        else
            $restriccion = 'Us';

        $dql = "SELECT u
                FROM ApplicationSonataUserBundle:User u
                JOIN u.groups g
                WHERE g.name LIKE '%$restriccion%' AND u.id !=3";

        $usuarios['usuarios'] = $em->createQuery($dql)
                ->getArrayResult();

        return new Response(json_encode($usuarios));
    }

    /*
     * DESCRIPCIÓN:
     *      Método que verifica si el empleado posee servicios a brindar
     *      dentro del establecimiento
     * ANALISTA PROGRAMADOR: Caleb Rodríguez
     */

    /**
     * @Route("/siaps/verify/medicservice", name="verify_medic_service", options={"expose"=true})
     *
     * @return Response
     */
    public function verifyMedicServiceAction() {
        $user           = $this->container->get('security.context')->getToken()->getUser();
        $session        = $this->container->get('session');
        $request        = $this->container->get('request');
        $em             = $this->getDoctrine()->getManager();
        $response       = new RedirectResponse($this->generateUrl('sonata_admin_dashboard'));
        $codigoEmpleado = $user->getIdEmpleado() ? $user->getIdEmpleado()->getIdTipoEmpleado()->getCodigo() : 'N/A';

        if( ( ($session->get('_moduleSelection') !== null && (null === $session->get('_idEmpEspecialidadEstab') || null === $session->get('_idEmpEspecialidadEstab')) ) ||
              ($session->get('_secured_token') === $request->query->get('_provided_token') && null !== $session->get('_idEmpEspecialidadEstab') && null !== $session->get('_idEmpEspecialidadEstab') )
            ) && $codigoEmpleado == 'MED') {

            $idEmpleado        = $user->getIdEmpleado()->getId();
            $idEstablecimiento = $user->getIdEmpleado()->getIdEstablecimiento()->getId();

            $dql = "SELECT t02
                    FROM MinsalSiapsBundle:MntEmpleadoEspecialidadEstab      t01
                    INNER JOIN MinsalSiapsBundle:MntAtenAreaModEstab         t02 WITH (t02.id = t01.idAtenAreaModEstab)
                    INNER JOIN MinsalSiapsBundle:CtlAtencion                 t03 WITH (t03.id = t02.idAtencion)
                    INNER JOIN MinsalSiapsBundle:MntAreaModEstab             t04 WITH (t04.id = t02.idAreaModEstab)
                    INNER JOIN MinsalSiapsBundle:CtlAreaAtencion             t05 WITH (t05.id = t04.idAreaAtencion)
                    INNER JOIN MinsalSiapsBundle:MntModalidadEstablecimiento t06 WITH (t06.id = t04.idModalidadEstab)
                    INNER JOIN MinsalSiapsBundle:CtlModalidad                t07 WITH (t07.id = t06.idModalidad)
                    INNER JOIN MinsalSiapsBundle:MntEmpleado                 t08 WITH (t08.id = t01.idEmpleado)
                    INNER JOIN MinsalSiapsBundle:MntTipoEmpleado             t09 WITH (t09.id = t08.idTipoEmpleado)
                    WHERE t01.idEmpleado = :idEmpleado
                        AND t02.idEstablecimiento = :idEstablecimiento
                        AND LOWER(t05.nombre) = :nomAreaAtencion
                        AND LOWER(t07.nombre) = :nomModalidad
                        AND UPPER(t09.codigo) = :codEmpleado";

            $query = $em->createQuery($dql);
            $query->setParameters(array(
                ':idEmpleado'        => $idEmpleado,
                ':codEmpleado'       => 'MED',
                ':idEstablecimiento' => $idEstablecimiento,
                ':nomAreaAtencion'   => 'consulta externa',
                ':nomModalidad'      => 'minsal'));
            $empEspecialidades = $query->getResult();
            if($empEspecialidades) {
                if(count($empEspecialidades) > 1) {
                    $response =  $this->render(
                                                'MinsalSiapsBundle::ServicioMedicoEstablecimiento.html.twig', array(
                                                    'user'              => $user,
                                                    'empEspecialidades' => $empEspecialidades,
                                                    'admin_pool'        => $this->container->get('sonata.admin.pool'),
                                                    'previous_url'      => $session->get('_secured_token') ? $request->server->get('HTTP_REFERER') : null,
                                        ));
                } else {
                    $session->set('_idEmpEspecialidadEstab', $empEspecialidades[0]->getId());
                    $session->set('_nombreEmpEspecialidadEstab', $empEspecialidades[0]->getNombreConsulta());
                }
            }
        }

        return $response;
    }

    /*
     * DESCRIPCIÓN:
     *      Método que setea la especialidad seleccionada por el empleado
     *      y redirecciona a la página principal
     * ANALISTA PROGRAMADOR: Caleb Rodríguez
     */

    /**
     * @Route("/siaps/set/empespecialidad/estab", name="set_emp_especialidad_estab", options={"expose"=true})
     * @Method("POST")
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return Response
     */
    public function setEmpEspecialidadEstabAction() {
        $user     = $this->container->get('security.context')->getToken()->getUser();
        $request  = $this->container->get('request');
        $session  = $this->container->get('session');
        $response = new RedirectResponse($this->generateUrl('sonata_admin_dashboard'));
        $codigoEmpleado = $user->getIdEmpleado()->getIdTipoEmpleado()->getCodigo();

        if( ( ($session->get('_moduleSelection') !== null && (null === $session->get('_idEmpEspecialidadEstab') || null === $session->get('_idEmpEspecialidadEstab')) ) ||
              ($session->get('_secured_token') === $request->get('_provided_token') && null !== $session->get('_idEmpEspecialidadEstab') && null !== $session->get('_idEmpEspecialidadEstab') )
            ) &&  $request->isMethod('POST') && $codigoEmpleado === 'MED') {

            if($session->get('_secured_token') === null) {
                $tokenGenerator = new TokenGenerator();
                $session->set('_secured_token', $tokenGenerator->generateToken());
            } else {
                if($request->get('previous_url') != '')
                    $response = new RedirectResponse($request->get('previous_url'));
            }

            $session->set('_idEmpEspecialidadEstab', $request->get('_id-especialidad'));
            $session->set('_nombreEmpEspecialidadEstab', $request->get('_nombre-especialidad'));

            return $response;
        } else {
            throw new AccessDeniedException();
        }
    }
}
