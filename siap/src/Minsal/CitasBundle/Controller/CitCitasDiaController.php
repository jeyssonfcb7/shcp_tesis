<?php
//src/Minsal/CitasBundle/Controller/CitCitasDiaController.php
namespace Minsal\CitasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL as DBAL;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Model\User;
use  Doctrine\DBAL\Types\Type;

class CitCitasDiaController extends Controller  {

	/**
     * @Route("/citas/dia/medico/get", name="citasdiaxmedico", options={"expose"=true})
     * @Method("GET")
     */
    public function getCitCitasDiaxMedicoAction() {
        $em             = $this->getDoctrine()->getManager();
        $request        = $this->getRequest();
        $session        = $request->getSession();
        $calendarDate   = new \DateTime($request->get('calendarDate'));
        $lowerLimit     = date('Y-m-01', $calendarDate->getTimestamp());
        $upperLimit     = date('Y-m-t',  $calendarDate->getTimestamp());
        $idEmpleado     = $request->get('idEmpleado');
        $especialidad   = $request->get('idEmpleadoEspecialidadEstab');
        $idAreaModEstab = $em->getRepository('MinsalSiapsBundle:MntAtenAreaModEstab')->findOneById($especialidad)->getIdAreaModEstab()->getId();

        /*****************************************************************************************
         * SQL que determina la cantidad de citas por primera vez, subsecuentes, agregados, aten-
         * didos y total de citas para cada dia de un mes determinado por usuario y especialidad
         ****************************************************************************************/
        $sql = "SELECT TO_CHAR(t05.date, 'YYYY/MM/DD') AS date, COALESCE(t06.primeraVez,0) AS primera_vez, COALESCE(t06.subsecuentes,0) AS subsecuentes,
                       COALESCE(t06.agregados,0) AS agregados, COALESCE(t06.totalCitas,0) AS total_citas,
                       COALESCE(t06.atendidos,0) AS atendidos
                FROM (
                      SELECT serie::date AS date
                      FROM generate_series ('$lowerLimit'::timestamp, '$upperLimit'::timestamp, '1 day'::interval) serie) t05
                LEFT OUTER JOIN (
                      SELECT DISTINCT t01.fecha as date,
                             SUM((CASE WHEN t01.id_tipocita = 1 THEN 1 ELSE 0 END) * (CASE WHEN t01.id_estado <> 6 THEN 1 ELSE 0 END)) as primeraVez,
                             SUM((CASE WHEN t01.id_tipocita = 2 THEN 1 ELSE 0 END) * (CASE WHEN t01.id_estado <> 6 THEN 1 ELSE 0 END)) as subsecuentes,
                             SUM(CASE WHEN t01.id_estado = 6 THEN 1 ELSE 0 END) as agregados,
                             COUNT(t01.id_tipocita) as totalCitas,
                             SUM((CASE WHEN t01.id_estado = 5 THEN 1 ELSE 0 END) + (CASE WHEN t01.id_estado = 7 THEN 1 ELSE 0 END)) atendidos
                      FROM cit_citas_dia t01
                      INNER JOIN mnt_expediente 		       t02 ON (t01.id_expediente = t02.id)
                      INNER JOIN mnt_empleado 			 t03 ON (t01.id_empleado   = t03.id)
                      WHERE t01.fecha >= '$lowerLimit' AND t01.fecha<= '$upperLimit'
                            AND t01.id_empleado = :idEmpleado AND t01.id_aten_area_mod_estab = :especialidad
                      GROUP BY t01.fecha) t06 ON (t05.date = t06.date) ORDER BY date";

        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->bindValue(':idEmpleado',   $idEmpleado);
        $stm->bindValue(':especialidad', $especialidad);
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data1'] = $result;

        /*****************************************************************************************
         * SQL que determina los eventos que un empleado tiene para un mes en especifico, asi como
         * tambien las fechas festivas o no laborables
         ****************************************************************************************/
        $sql = "SELECT TO_CHAR(t01.date, 'YYYY/MM/DD') AS date,
                       CASE WHEN t01.date BETWEEN t02.fechaini AND t02.fechafin THEN 'true'
                                                                                ELSE 'false'
                       END AS bloqueado,
                       COALESCE(t02.tipo_evento, 'N/A') AS tipo_evento,
                       COALESCE(t03.citas_programadas, 0) AS citas_programadas
                FROM (
                      SELECT serie::date AS date
                      FROM generate_series ('$lowerLimit'::timestamp, '$upperLimit'::timestamp, '1 day'::interval) serie) t01
                LEFT OUTER JOIN (
                      SELECT fechaini, fechafin,
                             CASE WHEN idempleado = :idEmpleado THEN 'personal'
                                                                ELSE 'festivo'
                             END AS tipo_evento
                      FROM cit_evento
                      WHERE idempleado = :idEmpleado OR idempleado IS NULL) t02 ON (t01.date BETWEEN t02.fechaini AND t02.fechafin)
                LEFT OUTER JOIN (
                      SELECT fecha, COUNT(*) AS citas_programadas
                      FROM cit_citas_dia
                      WHERE id_empleado = :idEmpleado AND (id_estado = 1 OR id_estado = 6)
                      GROUP BY fecha) t03 ON (t01.date = t03.fecha) ORDER BY date";

        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->bindValue(':idEmpleado',   $idEmpleado);
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data2'] = $result;

        /*****************************************************************************************
         * SQL que determina la distribucion de un médico, para un mes especifico
         ****************************************************************************************/
        $sql = "SELECT TO_CHAR(t01.date, 'YYYY/MM/DD') AS date,
                       COALESCE(t02.distribucion, 0) AS distribucion
                FROM (
                      SELECT serie::date AS date, EXTRACT(DOW FROM serie)+1 AS DOW
                      FROM generate_series ('$lowerLimit'::timestamp, '$upperLimit'::timestamp, '1 day'::interval) serie) t01
                LEFT OUTER JOIN (
                      SELECT yrs, mes, dia, COUNT(*) AS distribucion FROM  cit_distribucion
                      WHERE id_empleado = :idEmpleado
                            AND id_aten_area_mod_estab = :especialidad
                            AND id_area_mod_estab = :idAreaModEstab
                      GROUP BY yrs, mes, dia) t02 ON (t02.yrs = EXTRACT(YEAR FROM t01.date::timestamp)
                                  AND t02.mes = EXTRACT(MONTH FROM t01.date::timestamp)
                                  AND t02.dia = EXTRACT(DOW FROM t01.date::timestamp)+1) ORDER BY date";

        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->bindValue(':idEmpleado',   $idEmpleado);
        $stm->bindValue(':especialidad', $especialidad);
        $stm->bindValue(':idAreaModEstab', $idAreaModEstab);
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data3'] = $result;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/horario/medico/get", name="citashorariomedico", options={"expose"=true})
     * @Method("GET")
     */
    public function getHorarioMedicoAction() {
        $em             = $this->getDoctrine()->getManager();
        $request        = $this->getRequest();
        $session        = $request->getSession();
        $date           = new \DateTime($request->get('date'));
        $idEmpleado     = $request->get('idEmpleado');
        $especialidad   = $request->get('idEmpleadoEspecialidadEstab');
        $idAreaModEstab = $em->getRepository('MinsalSiapsBundle:MntAtenAreaModEstab')->findOneById($especialidad)->getIdAreaModEstab()->getId();

        /*****************************************************************************************
         * SQL que determina el horario de atencion de pacientes de un medico para una fecha de-
         * terminada
         ****************************************************************************************/
        $sql = "SELECT t02.id, t02.hora_ini::text || ' ' || UPPER(t02.meridianoini) AS hora_ini
                FROM cit_distribucion t01
                INNER JOIN mnt_rangohora t02 ON (t02.id = t01.id_rangohora)
                WHERE t01.id_empleado = :idEmpleado
                      AND t01.id_aten_area_mod_estab = :idAtenAreaModEstab
                      AND t01.id_area_mod_estab      = :idAreaModEstab
                      AND t01.dia                    = :dia
                      AND t01.mes                    = :mes
                      AND t01.yrs                    = :yrs
                GROUP BY t02.id, t02.hora_ini
                ORDER BY t02.hora_ini::text";

        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->bindValue(':idEmpleado', $idEmpleado);
        $stm->bindValue(':idAtenAreaModEstab', $especialidad);
        $stm->bindValue(':idAreaModEstab', $idAreaModEstab);
        $stm->bindValue(':dia', date( "w", $date->getTimestamp())+1);
        $stm->bindValue(':mes', date( "n", $date->getTimestamp()));
        $stm->bindValue(':yrs', date( "Y", $date->getTimestamp()));
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data1'] = $result;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/verificar/evento/get", name="citasverificarevento", options={"expose"=true})
     * @Method("GET")
     */
    public function verifyMedicEventAction() {
        $em         = $this->getDoctrine()->getManager();
        $request    = $this->getRequest();
        $date       = new \DateTime($request->get('date'));
        $idEmpleado = $request->get('idEmpleado');
        $hora       = date("H:i:s", strtotime($request->get('hora')));
        $fecha      = date('Y-m-d', $date->getTimestamp());

        /*****************************************************************************************
         * SQL que verifica que el medico no tenga evento en la hora seleccionada
         ****************************************************************************************/
        $sql = "SELECT t01.id
                FROM cit_evento t01
                WHERE t01.idempleado = :idEmpleado
                    AND '$fecha' BETWEEN t01.fechaini AND t01.fechafin
                    AND '$hora'  BETWEEN t01.horaini AND t01.horafin";

        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->bindValue(':idEmpleado', $idEmpleado);
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data1'] = $result;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/detalle/hora/get", name="citasdetallehora", options={"expose"=true})
     * @Method("GET")
     */
    public function getDetalleCitaHoraAction() {
        $em           = $this->getDoctrine()->getManager();
        $request      = $this->getRequest();
        $session      = $request->getSession();
        $date         = new \DateTime($request->get('date'));
        $idEmpleado   = $request->get('idEmpleado');
        $especialidad = $request->get('idEmpleadoEspecialidadEstab');
        $idRangohora  = $request->get('hora');

        /*****************************************************************************************
         * SQL que determina el detalle de la cita por hora
         ****************************************************************************************/

        $dql = "SELECT IDENTITY(t01.idExpediente) AS idExpediente,
                       t02.numero AS codExpediente,
                       CONCAT(COALESCE(CONCAT(t03.primerApellido, ' '), ''),
                       CONCAT(COALESCE(CONCAT(t03.segundoApellido, ', '), ''),
                       CONCAT(COALESCE(CONCAT(t03.primerNombre,' '), ''),
                       CONCAT(COALESCE(CONCAT(t03.segundoNombre,' '), ''),
                       COALESCE(t03.tercerNombre, ''))))) AS nombrePaciente,
                       IDENTITY(t01.idEstado) AS idEstado, t05.estado AS nombreEstado
                      FROM MinsalCitasBundle:CitCitasDia t01
                      INNER JOIN MinsalSiapsBundle:MntExpediente t02 WITH (t02.id = t01.idExpediente)
                      INNER JOIN MinsalSiapsBundle:MntPaciente   t03 WITH (t03.id = t02.idPaciente)
                      INNER JOIN MinsalSiapsBundle:MntEmpleado   t04 WITH (t04.id = t01.idEmpleado)
                      INNER JOIN MinsalCitasBundle:CitEstadoCita t05 WITH (t05.id = t01.idEstado)";

        $where = " WHERE t01.fecha = :fecha
                        AND t01.idEmpleado = :idEmpleado
                        AND t01.idTipocita = :idTipocita
                        AND t01.idAtenAreaModEstab = :especialidad
                        AND t01.idRangohora = :hora
                        AND t01.idMotivo IS NULL
                   ORDER BY t05.estado DESC";

        $result = $em->createQuery($dql."".$where)
                     ->setParameter(':fecha', date('Y-m-d', $date->getTimestamp()))
                     ->setParameter(':idEmpleado', $idEmpleado)
                     ->setParameter(':idTipocita', 1)
                     ->setParameter(':especialidad', $especialidad)
                     ->setParameter(':hora', $idRangohora)
                     ->getArrayResult();

        $citcita['data1'] = $result;

        $result = $em->createQuery($dql.$where)
                     ->setParameter(':fecha', date('Y-m-d', $date->getTimestamp()))
                     ->setParameter(':idEmpleado', $idEmpleado)
                     ->setParameter(':idTipocita', 2)
                     ->setParameter(':especialidad', $especialidad)
                     ->setParameter(':hora', $idRangohora)
                     ->getArrayResult();

        $citcita['data2'] = $result;

        $where = " WHERE t01.fecha = :fecha
                        AND t01.idEmpleado = :idEmpleado
                        AND t01.idAtenAreaModEstab = :especialidad
                        AND t01.idRangohora = :hora
                        AND t01.idMotivo >= 1
                   ORDER BY t05.estado DESC";

        $result = $em->createQuery($dql.$where)
                     ->setParameter(':fecha', date('Y-m-d', $date->getTimestamp()))
                     ->setParameter(':idEmpleado', $idEmpleado)
                     ->setParameter(':especialidad', $especialidad)
                     ->setParameter(':hora', $idRangohora)
                     ->getArrayResult();

        $citcita['data3'] = $result;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/expediente/paciente/get", name="citasexpedientepaciente", options={"expose"=true})
     * @Method("GET")
     */
    public function getExpedientePacienteAction() {
        $em      = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $clue    = ltrim(strtolower($request->get('clue')), '0');
        $limit   = $request->get('page_limit');
        $page    = $request->get('page') - 1;
		
        /*****************************************************************************************
         * SQL que obtiene el numero de expediente y nombre del paciente para asignar la cita
         ****************************************************************************************/

        $sql = "SELECT t01.id,
                       CONCAT_WS(' ', CONCAT(COALESCE(t01.numero, ''), ' - '), t02.primer_apellido, t02.segundo_apellido, t02.apellido_casada) || ', ' || CONCAT_WS(' ', t02.primer_nombre, t02.segundo_nombre, t02.tercer_nombre) AS text,
                       count(*) OVER() AS total
                FROM mnt_expediente     t01
                INNER JOIN mnt_paciente t02 ON (t02.id = t01.id_paciente AND t01.habilitado = true)
                WHERE t01.numero LIKE '$clue%'
                      OR CONCAT_WS(' ', t02.primer_apellido, t02.segundo_apellido, t02.apellido_casada) || ', ' || CONCAT_WS(' ', t02.primer_nombre, t02.segundo_nombre, t02.tercer_nombre) ILIKE '%$clue%'
                GROUP BY t01.id,
                       CONCAT_WS(' ', CONCAT(COALESCE(t01.numero, ''), ' - '), t02.primer_apellido, t02.segundo_apellido, t02.apellido_casada) || ', ' || CONCAT_WS(' ', t02.primer_nombre, t02.segundo_nombre, t02.tercer_nombre)
                ORDER BY text
                LIMIT $limit OFFSET $page";

        $stm  = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data1'] = $result;
        $citcita['data2'] = count($result) > 0 ? $result[0]['total'] : 0;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/medicos/get", name="citasgetmedico", options={"expose"=true})
     * @Method("GET")
     */
    public function getMedicoAction() {
        $em  = $this->getDoctrine()->getManager();

        $dql = "SELECT t01.id,
                       COALESCE(t01.nombreempleado,'') AS nombre,
                       IDENTITY(t01.idEstablecimiento) AS idEstablecimiento
                FROM MinsalSiapsBundle:MntEmpleado              t01
                INNER JOIN MinsalSiapsBundle:MntTipoEmpleado    t02 WITH (t02.id = t01.idTipoEmpleado)
                INNER JOIN MinsalSiapsBundle:CtlEstablecimiento t03 WITH (t03.id = t01.idEstablecimiento)
                WHERE t02.codigo = 'MED'";

        $result = $em->createQuery($dql)
                    ->getArrayResult();

        $citcita['data1'] = $result;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/medicos/especilidad/estab/get", name="citasgetmedicoespecilidadestab", options={"expose"=true})
     * @Method("GET")
     */
    public function getMedicoEspecilidadEstabAction() {
        $em         = $this->getDoctrine()->getManager();
        $request    = $this->getRequest();
        $idEmpleado = $request->get('idEmpleado');

        /*****************************************************************************************
         * SQL que obtiene todas las especialidades del medico
         ****************************************************************************************/
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
                    AND LOWER(t05.nombre) = :nomAreaAtencion
                    AND LOWER(t07.nombre) = :nomModalidad
                    AND UPPER(t09.codigo) = :codEmpleado";

        $result = $em->createQuery($dql)
                     ->setParameters(array(
                            ':idEmpleado'        => $idEmpleado,
                            ':codEmpleado'       => 'MED',
                            ':nomAreaAtencion'   => 'consulta externa',
                            ':nomModalidad'      => 'minsal'))
                     ->getResult();

        $new_result = array();
        foreach ($result as $key => $value) {
          $new_result[$key]['id']     = $value->getId();
          $new_result[$key]['nombre'] = $value->getNombreConsulta();
        }

        $citcita['data1'] = $new_result;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/paciente/poseecita/get", name="citaspacienteposeecita", options={"expose"=true})
     * @Method("GET")
     */
    public function pacientePoseeCitaAction() {
        $em           = $this->getDoctrine()->getManager();
        $request      = $this->getRequest();
        $idEmpleado   = $request->get('idEmpleado');
        $idExpediente = $request->get('idExpediente');
        $especialidad = $request->get('especialidad');
        $date         = new \DateTime($request->get('date'));
        $fecha        = date('Y-m-d', $date->getTimestamp());
        $today        = new \DateTime();
        $hoy          = date('Y-m-d', $today->getTimestamp());
        $user         = $this->getUser();

        /*****************************************************************************************
         * SQL que verifica y obtiene si un paciente tiene cita previa con el medico
         ****************************************************************************************/
        $sql = "SELECT t01.id AS id_cita,
                       'citas_dia'::text AS clase_cita,
                       t01.id_empleado AS id_emp_ciq_estab,
                       t02.hora_ini,
                       t02.meridianoini,
                       t04.nombre AS nombre_atencion_procedimiento
                FROM cit_citas_dia                 t01
                INNER JOIN mnt_rangohora           t02 ON (t02.id = t01.id_rangohora)
                INNER JOIN mnt_aten_area_mod_estab t03 ON (t03.id = t01.id_aten_area_mod_estab)
                INNER JOIN ctl_atencion            t04 ON (t04.id = t03.id_atencion)
                INNER JOIN mnt_expediente          t05 ON (t05.id = t01.id_expediente)
                WHERE t01.fecha='$fecha' AND t05.id=:idExpediente

                UNION

                SELECT t07.id AS id_cita,
                       'citas_procedimiento'::text AS clase_cita,
                       t07.id_ciq_establecimiento,
                       t10.hora_ini,
                       t10.meridianoini,
                       t09.procedimiento
                FROM cit_citasprocedimientos                 t07
                INNER JOIN mnt_procedimiento_establecimiento t08 ON (t08.id = t07.id_ciq_establecimiento)
                INNER JOIN mnt_ciq                           t09 ON (t09.id = t08.id_ciq)
                INNER JOIN mnt_rangohora                     t10 ON (t10.id = t07.id_rangohora)
                INNER JOIN mnt_expediente                    t11 ON (t11.id = t07.id_expediente)
                WHERE t07.fecha='$fecha' AND t11.id=:idExpediente";

        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->bindValue(':idExpediente', $idExpediente);
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data1'] = $result;

        /*****************************************************************************************
         * SQL que verifica y obtiene si un paciente tiene cita previa con el medico
         ****************************************************************************************/

        $sql = "SELECT t04.nombre AS nombre_atencion,
                       t01.id_empleado,
                       t02.hora_ini,
                       t02.meridianoini
                FROM cit_citas_dia t01
                INNER JOIN mnt_rangohora           t02 ON (t02.id = t01.id_rangohora)
                INNER JOIN mnt_aten_area_mod_estab t03 ON (t03.id = t01.id_aten_area_mod_estab)
                INNER JOIN ctl_atencion            t04 ON (t04.id = t03.id_atencion)
                WHERE t01.fecha = '$fecha'
                    AND t01.id_expediente          = :idExpediente
                    AND t01.idusuarioreg           = :idUsuarioReg
                    AND t01.id_aten_area_mod_estab = :idAtenAreaModEstab
                    AND DATE(t01.fechahorareg)     = '$hoy'";

        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->bindValue(':idExpediente', $idExpediente);
        $stm->bindValue(':idUsuarioReg',   $user->getId());
        $stm->bindValue(':idAtenAreaModEstab', $especialidad);
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data2'] = $result;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/comprobar/disponibilidad", name="citascomprobardisponibilidad", options={"expose"=true})
     * @Method("GET")
     *
     */
    public function comprobarDisponibilidadAction() {
        $em                  = $this->getDoctrine()->getManager();
        $request             = $this->getRequest();
        $date                = new \DateTime($request->get('date'));
        $idEmpleado          = $request->get('idEmpleado');
        $especialidad        = $request->get('especialidad');
        $idRangohora         = $request->get('idRangohora');
        $mntAtenAreaModEstab = $em->getRepository('MinsalSiapsBundle:MntAtenAreaModEstab')->findOneById($especialidad);
        $idAreaModEstab      = $mntAtenAreaModEstab->getIdAreaModEstab()->getId();
        $idEstablecimiento   = $mntAtenAreaModEstab->getIdEstablecimiento()->getId();
        $tipoCita            = 2;

        /*****************************************************************************************
         * SQL que determina el numero maximo de citas agregadas que puede brindar un medico en un
         * horario determinado
         ****************************************************************************************/
        $sql = "SELECT t01.max_citas_agregadas
                FROM cit_distribucion t01
                WHERE t01.id_empleado = :idEmpleado
                      AND t01.id_aten_area_mod_estab = :idAtenAreaModEstab
                      AND t01.id_area_mod_estab      = :idAreaModEstab
                      AND t01.id_rangohora           = :idRangohora
                      AND t01.dia                    = :dia
                      AND t01.mes                    = :mes
                      AND t01.yrs                    = :yrs";

        $stm = $this->container->get('database_connection')->prepare($sql);
        $stm->bindValue(':idEmpleado', $idEmpleado);
        $stm->bindValue(':idAtenAreaModEstab', $especialidad);
        $stm->bindValue(':idAreaModEstab', $idAreaModEstab);
        $stm->bindValue(':idRangohora', $idRangohora);
        $stm->bindValue(':dia', date( "w", $date->getTimestamp())+1);
        $stm->bindValue(':mes', date( "n", $date->getTimestamp()));
        $stm->bindValue(':yrs', date( "Y", $date->getTimestamp()));
        $stm->execute();
        $result = $stm->fetchAll();

        $citcita['data1'] = $result[0];

        /*****************************************************************************************
         * SQL que determina el numero de pacientes agregados que tiene un medico en para una
         * especialidad y horario determinado
         ****************************************************************************************/
        $dql = "SELECT COUNT(t01.id)
                FROM MinsalCitasBundle:CitCitasDia t01
                WHERE t01.idAtenAreaModEstab  = :idAtenAreaModEstab
                    AND t01.idEstado          = :idEstado
                    AND t01.fecha             = :fecha
                    AND t01.idEmpleado        = :idEmpleado
                    AND t01.idEstablecimiento = :idEstablecimiento
                    AND t01.idRangohora       = :idRangohora
                    AND t01.idAreaModEstab    = :idAreaModEstab";

        $result = $em->createQuery($dql)
                    ->setParameter(':idAtenAreaModEstab', $especialidad)
                    ->setParameter(':idEstado', '6')
                    ->setParameter(':fecha', date( "Y-m-d", $date->getTimestamp()))
                    ->setParameter(':idEmpleado', $idEmpleado)
                    ->setParameter(':idEstablecimiento', $idEstablecimiento)
                    ->setParameter(':idRangohora', $idRangohora)
                    ->setParameter(':idAreaModEstab', $idAreaModEstab)
                    ->getSingleScalarResult();

        $citcita['data2'] = $result;

        /*****************************************************************************************
         * SQL que determina el numero de pacientes agregados que tiene un medico en para una
         * especialidad y horario determinado
         ****************************************************************************************/
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

        if($totalCitas >= $subsecuentes ) {
            $result = 'true';
        } else {
            $result = 'false';
        }

        $citcita['data3'] = $result;

        return new Response(json_encode($citcita));
    }

    /**
     * @Route("/citas/comprobante/get/{report_format}", name="citasgetcomprobante", options={"expose"=true})
     * @Method("POST")
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     *
     */
    public function getComprobanteCitaAction($report_format = "HTML") {
        $request     = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $id = $request->get('id');

            return $this->render('MinsalCitasBundle:Reports:comprobante_cita.html.twig', array('id'=> $id));
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * @Route("/citas/buildcomprobante/get/{id}/{report_format}", name="citasbuildcomprobante", options={"expose"=true})
     * @Method("GET")
     *
     */
    public function buildComprobanteCitaAction($id, $report_format = "HTML") {
        $report_name = "comprobante_citas";
        $jasperReport = $this->container->get('jasper.build.reports');
        $jasperReport->setReportName($report_name);
        $jasperReport->setReportFormat($report_format);
        $jasperReport->setReportPath("/reports/siaps/seguimiento/");
        $jasperReport->setReportParams(array('id' => $id));

        return $jasperReport->buildReport();
    }
}
