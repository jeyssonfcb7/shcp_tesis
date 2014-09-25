<?php

namespace Minsal\SiapsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;
use Minsal\SiapsBundle\Entity\MntAuditoriaPaciente;
use Minsal\SeguimientoBundle\Entity\SecEmergencia;
use Minsal\Metodos\Funciones;
use Doctrine\DBAL as DBAL;

class MntPacienteAdmin extends Admin {

    protected $datagridValues = array(
        '_page' => 1, // Display the first page (default = 1)
        '_sort_order' => 'ASC', // Descendant ordering (default = 'ASC')
        '_sort_by' => 'configurado' // name of the ordered field (default = the model id field, if any)
    );

    protected function configureFormFields(FormMapper $formMapper) {
        $elSalvador = $this->getModelManager()
                ->findOneBy('MinsalSiapsBundle:CtlPais', array('id' => 68));

        $formMapper
                ->add('primerApellido', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('segundoApellido', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('apellidoCasada', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('primerNombre', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('segundoNombre', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('tercerNombre', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('fechaNacimiento', 'birthday', array(
                    'widget' => 'single_text', 'format' => 'dd-MM-yyyy'
                /* 'empty_value' => array('year' => 'Año', 'month' => 'Mes', 'day' => 'Día') */                ))
                ->add('horaNacimiento', null, array('required' => false))
                ->add('idSexo', null, array('label' => 'Sexo *', 'required' => false))
                ->add('numeroDocIdePaciente', null, array('label' => $this->getTranslator()->trans('numeroDocIdePaciente')))
                ->add('direccion', null, array('required' => true, 'attr' => array('class' => 'span5 mayuscula')))
                ->add('telefonoCasa', null, array('label' => $this->getTranslator()->trans('telefonoCasa'), 'attr' => array('class' => 'span5 telefono')))
                ->add('lugarTrabajo', null, array('attr' => array('class' => 'span5 mayuscula')))
                ->add('telefonoTrabajo', null, array('label' => 'Telefono Trabajo', 'attr' => array('class' => 'span5 telefono')))
                ->add('idAreaCotizacion', null, array('label' => $this->getTranslator()->trans('idAreaCotizacion'), 'required' => false, 'attr' => array('class' => 'span5 deshabilitados')))
                ->add('asegurado')
                ->add('cotizante', null, array('attr' => array('class' => 'deshabilitados')))
                ->add('numeroAfiliacion', null, array('attr' => array('class' => 'span5 deshabilitados')))
                ->add('nombrePadre', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('nombreMadre', null, array('required' => true, 'attr' => array('class' => 'span5 limpiar')))
                ->add('nombreConyuge', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('nombreResponsable', null, array('required' => true, 'attr' => array('class' => 'span5 limpiar')))
                ->add('direccionResponsable', null, array('attr' => array('class' => 'span5 mayuscula')))
                ->add('telefonoResponsable', null, array('label' => $this->getTranslator()->trans('telefonoResponsable'), 'attr' => array('class' => 'span5 telefono')))
                ->add('numeroDocIdeResponsable', null, array('label' => $this->getTranslator()->trans('numeroDocIdeResponsable')))
                ->add('nombreProporcionoDatos', null, array('required' => true, 'label' => $this->getTranslator()->trans('nombreProporcionoDatos'), 'attr' => array('class' => 'span5 limpiar')))
                ->add('numeroDocIdeProporDatos', null, array('label' => $this->getTranslator()->trans('numeroDocIdeProporDatos')))
                ->add('observacion', null, array('attr' => array('class' => 'span5 mayuscula')))
                ->add('conocidoPor', null, array('attr' => array('class' => 'span5 limpiar')))
                ->add('areaGeograficaDomicilio', null, array('required' => false))
                ->add('idCantonDomicilio', null, array('required' => false, 'label' => $this->getTranslator()->trans('idCantonDomicilio'), 'attr' => array('class' => 'span5 deshabilitados')))
                ->add('idDepartamentoDomicilio', null, array(
                    'required' => false, 'label' => $this->getTranslator()->trans('idDepartamentoDomicilio')))
                ->add('idDocPaciente', null, array('required' => false, 'label' => $this->getTranslator()->trans('idDocPaciente')))
                ->add('idDocProporcionoDatos', null, array('required' => false, 'label' => $this->getTranslator()->trans('idDocProporcionoDatos')))
                ->add('idDocResponsable', null, array('required' => false, 'label' => $this->getTranslator()->trans('idDocResponsable')))
                ->add('idEstadoCivil', null, array('required' => false, 'label' => $this->getTranslator()->trans('idEstadoCivil')))
                ->add('idMunicipioDomicilio', null, array('required' => false, 'label' => $this->getTranslator()->trans('idMunicipioDomicilio'), 'attr' => array('class' => 'span5 deshabilitados')))
                ->add('idDepartamentoNacimiento', null, array('required' => false, 'label' => $this->getTranslator()->trans('idDepartamentoNacimiento'), 'attr' => array('class' => 'span5 deshabilitados')))
                ->add('idMunicipioNacimiento', null, array('required' => false, 'label' => $this->getTranslator()->trans('idMunicipioNacimiento'), 'attr' => array('class' => 'span5 deshabilitados')))
                ->add('idNacionalidad', null, array(
                    'label' => $this->getTranslator()->trans('idNacionalidad'),
                    'required' => false
                ))
                ->add('idOcupacion', null, array('required' => false, 'label' => $this->getTranslator()->trans('idOcupacion')))
                ->add('idPaisNacimiento', 'entity', array('required' => false, 'label' => $this->getTranslator()->trans('idPaisNacimiento'),
                    'class' => 'MinsalSiapsBundle:CtlPais',
                    'preferred_choices' => array($elSalvador)
                ))
                ->add('idParentescoResponsable', null, array('required' => false, 'label' => $this->getTranslator()->trans('idParentescoResponsable')))
                ->add('idParentescoProporDatos', null, array('required' => false, 'label' => $this->getTranslator()->trans('idParentescoProporDatos')))
        ;
        //var_dump($this->getRequest()->get('procedencia'));exit();
        if ($this->getRequest()->get('procedencia') != 'e')
            $formMapper->add('expedientes', 'sonata_type_collection', array(
                'label' => 'Expedientes Clínicos',
                'required' => true), array(
                'edit' => 'inline',
                'inline' => 'table',
                'limit' => 1
            ));
    }

    public function getTemplate($name) {
        switch ($name) {
            case 'list':
                return 'MinsalSiapsBundle:MntPacienteAdmin:list.html.twig';
                break;
            case 'edit':
                return 'MinsalSiapsBundle:MntPacienteAdmin:edit.html.twig';
                break;
            case 'view':
                return 'MinsalSiapsBundle:MntPacienteAdmin:view.html.twig';
                break;
            case 'buscaremergencia':
                return 'MinsalSiapsBundle:MntPacienteAdmin:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    public function prePersist($paciente) {
        $paciente->setPrimerNombre(chop(ltrim($paciente->getPrimerNombre())));
        $paciente->setSegundoNombre(chop(ltrim($paciente->getSegundoNombre())));
        $paciente->setTercerNombre(chop(ltrim($paciente->getTercerNombre())));
        $paciente->setPrimerApellido(chop(ltrim($paciente->getPrimerApellido())));
        $paciente->setSegundoApellido(chop(ltrim($paciente->getSegundoApellido())));
        $paciente->setApellidoCasada(chop(ltrim($paciente->getApellidoCasada())));

        $establecimiento = $this->getModelManager()
                ->findOneBy('MinsalSiapsBundle:CtlEstablecimiento', array('configurado' => true));
        $fecha_actual = new \DateTime();
        $paciente->setFechaRegistro($fecha_actual);
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $paciente->setIdUser($user);
        if ($this->getRequest()->get('procedencia') != 'e') {
            foreach ($paciente->getExpedientes() as $expediente) {
                $expediente->setIdEstablecimiento($establecimiento);
                $expediente->setIdPaciente($paciente);
                $expediente->setFechaCreacion($fecha_actual);
                $expediente->setHoraCreacion($fecha_actual);
            }
        } else {
            $emergencia = new SecEmergencia();
            $anio = date("Y");
            $emergencia->setAnioEmergencia($anio);
            $sql = "SELECT COALESCE(MAX(CAST(numero_emergencia AS integer))+1,1) AS numero FROM sec_emergencia WHERE anio_emergencia=" . $anio;
            $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
            $con = $em->getConnection();
            $query = $con->query($sql);
            $query = $query->fetch();
            $emergencia->setNumeroEmergencia($query['numero']);
            $emergencia->setIdPaciente($paciente);
            $emergencia->setIdUsuarioRegistra($user);
            $emergencia->setFechaRegistra($fecha_actual);
            $this->getModelManager()->create($emergencia);
        }
    }

    public function preUpdate($paciente) {
        $establecimiento = $this->getModelManager()
                ->findOneBy('MinsalSiapsBundle:CtlEstablecimiento', array('configurado' => true));
        $fecha_actual = new \DateTime();
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        foreach ($paciente->getExpedientes() as $expediente) {
            $expediente->setIdEstablecimiento($establecimiento);
            $expediente->setIdPaciente($paciente);
            $expediente->setFechaCreacion($fecha_actual);
            $expediente->setHoraCreacion($fecha_actual);
        }

        $paciente->setPrimerNombre(chop(ltrim($paciente->getPrimerNombre())));
        $paciente->setSegundoNombre(chop(ltrim($paciente->getSegundoNombre())));
        $paciente->setTercerNombre(chop(ltrim($paciente->getTercerNombre())));
        $paciente->setPrimerApellido(chop(ltrim($paciente->getPrimerApellido())));
        $paciente->setSegundoApellido(chop(ltrim($paciente->getSegundoApellido())));
        $paciente->setApellidoCasada(chop(ltrim($paciente->getApellidoCasada())));

        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $con = $em->getConnection();
        $query = "SELECT * FROM mnt_paciente where id=" . $paciente->getId();
        $resultado = $con->query($query);
        $pacienteBase = $resultado->fetch();

        $auditoria = new MntAuditoriaPaciente();

        $cambio = false;

        if ($paciente->getPrimerNombre() != $pacienteBase['primer_nombre']) {
            $auditoria->setPrimerNombre($paciente->getPrimerNombre());
            $cambio = TRUE;
        }
        if ($paciente->getSegundoNombre() != $pacienteBase['segundo_nombre']) {
            $auditoria->setSegundoNombre($paciente->getSegundoNombre());
            $cambio = TRUE;
        }
        if ($paciente->getTercerNombre() != $pacienteBase['tercer_nombre']) {
            $auditoria->setTercerNombre($paciente->getTercerNombre());
            $cambio = TRUE;
        }
        if ($paciente->getPrimerApellido() != $pacienteBase['primer_apellido']) {
            $auditoria->setPrimerApellido($paciente->getPrimerApellido());
            $cambio = TRUE;
        }
        if ($paciente->getSegundoApellido() != $pacienteBase['segundo_apellido']) {
            $auditoria->setSegundoApellido($paciente->getSegundoApellido());
            $cambio = TRUE;
        }
        if ($paciente->getApellidoCasada() != $pacienteBase['apellido_casada']) {
            $auditoria->setApellidoCasada($paciente->getApellidoCasada());
            $cambio = TRUE;
        }
        if ($paciente->getNombrePadre() != $pacienteBase['nombre_padre']) {
            $auditoria->setNombrePadre($paciente->getNombrePadre());
            $cambio = TRUE;
        }
        if ($paciente->getNombreMadre() != $pacienteBase['nombre_madre']) {
            $auditoria->setNombreMadre($paciente->getNombreMadre());
            $cambio = TRUE;
        }
        if ($paciente->getNombreResponsable() != $pacienteBase['nombre_responsable']) {
            $auditoria->setNombreResponsable($paciente->getNombreResponsable());
            $cambio = TRUE;
        }
        if ($paciente->getObservacion() != $pacienteBase['observacion']) {
            $auditoria->setObservacion($paciente->getObservacion());
            $cambio = TRUE;
        }
        if ($paciente->getDireccion() != $pacienteBase['direccion']) {
            $auditoria->setDireccion($paciente->getDireccion());
            $cambio = TRUE;
        }
        if (!is_null($paciente->getIdDepartamentoDomicilio())) {
            if ($paciente->getIdDepartamentoDomicilio()->getId() != $pacienteBase['id_departamento_domicilio']) {
                $auditoria->setIdDepartamentoDomicilio($paciente->getIdDepartamentoDomicilio());
                $cambio = TRUE;
            }
        }
        if (!is_null($paciente->getIdMunicipioDomicilio())) {
            if ($paciente->getIdMunicipioDomicilio()->getId() != $pacienteBase['id_municipio_domicilio']) {
                $auditoria->setIdMunicipioDomicilio($paciente->getIdMunicipioDomicilio());
                $cambio = TRUE;
            }
        }
        if (($paciente->getIdCantonDomicilio()) != NULL) {
            if ($paciente->getIdCantonDomicilio()->getId() != $pacienteBase['id_canton_domicilio']) {
                $auditoria->setIdCantonDomicilio($paciente->getIdCantonDomicilio());
                $cambio = TRUE;
            }
        }

        if ($paciente->getAreaGeograficaDomicilio()->getId() != $pacienteBase['area_geografica_domicilio']) {
            $auditoria->setAreaGeograficaDomicilio($paciente->getAreaGeograficaDomicilio());
            $cambio = TRUE;
        }
        if ($paciente->getIdSexo()->getId() != $pacienteBase['id_sexo']) {
            $auditoria->setIdSexo($paciente->getIdSexo());
            $cambio = TRUE;
        }
//Para verificar si la fecha o la hora de nacimiento ha cambiado las convertimos en una marca de tiempo
        $fecha_form = $paciente->getFechaNacimiento();
        foreach ($fecha_form as $valor) {
            $datos[] = $valor;
        }
        if (strtotime($datos[0]) != strtotime($pacienteBase['fecha_nacimiento'])) {
            $auditoria->setFechaNacimiento($paciente->getFechaNacimiento());
            $cambio = TRUE;
        }
        if ($paciente->getHoraNacimiento() != NULL) {
            $hora_form = $paciente->getHoraNacimiento();
            foreach ($hora_form as $valor_hora) {
                $datos_hora[] = $valor_hora;
            }
            $hora = explode(' ', $datos_hora[0]);
            if ($pacienteBase['hora_nacimiento'] != null) {
                if (strtotime($hora[1]) != strtotime($pacienteBase['hora_nacimiento'])) {
                    $auditoria->setHoraNacimiento($paciente->getHoraNacimiento());
                    $cambio = TRUE;
                }
            } else {
                $auditoria->setHoraNacimiento($paciente->getHoraNacimiento());
                $cambio = TRUE;
            }
        }


//si alguno de los valores ha cambiado se guarda en la tabla auditoría paciente
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $fecha_actual = new \DateTime();
        if ($cambio == TRUE) {
            $establecimiento = $this->getModelManager()
                    ->findOneBy('MinsalSiapsBundle:CtlEstablecimiento', array('configurado' => true));
            $auditoria->setIdEstablecimiento($establecimiento);
            $auditoria->setFechaModificacion($fecha_actual);
            $auditoria->setIdUser($user);
            $auditoria->setIdPaciente($paciente);
            $this->getModelManager()->create($auditoria);
        }
        $paciente->setIdUserMod($user);
        $paciente->setFechaMod($fecha_actual);
    }

    public function validate(ErrorElement $errorElement, $paciente) {
        /* ESTA VALIDACIÓN SE REALIZARA SOLO CUANDO EL PACIENTE VENGA POR ARCHIVO NO DE EMERGENCIA */
        if ($this->getRequest()->get('procedencia') != 'e') {
            //Verificando que haya ingresado número de expediente
            if (count($paciente->getExpedientes()) == 0) {
                $errorElement->with('expedientes')
                        ->addViolation('Debe agregar un número de expediente')
                        ->end();
            } else {
                $establecimiento = $this->getModelManager()
                        ->findOneBy('MinsalSiapsBundle:CtlEstablecimiento', array('configurado' => true));
                $formatoExpediente = $establecimiento->getTipoExpediente();
                if ($formatoExpediente == 'G') {
                    foreach ($paciente->getExpedientes() as $expediente) {
                        if (preg_match('/^\d{1,}-\d{2}$/', $expediente->getNumero()) == 0) {
                            $errorElement->with('numero')
                                    ->addViolation('El formato del número de expediente es incorrecto o contiene letras')
                                    ->end();
                        } else {
                            list($entero, $anio) = explode('-', $expediente->getNumero());
                            $entero = (int) $entero;
                            if ($entero == 0)
                                $errorElement->with('numero')
                                        ->addViolation('El numero de expediente no puede ser 0')
                                        ->end();
                            else
                                $expediente->setNumero((string) $entero . '-' . $anio);
                        }
                    }
                } else {
                    foreach ($paciente->getExpedientes() as $expediente) {
                        if (preg_match('/^\d{1,}$/', $expediente->getNumero()) == 0) {
                            $errorElement->with('numero')
                                    ->addViolation('El formato del número de expediente es incorrecto o contiene letras')
                                    ->end();
                        } else {
                            $numero = (int) $expediente->getNumero();
                            if ($numero == 0)
                                $errorElement->with('numero')
                                        ->addViolation('El numero de expediente no puede ser 0')
                                        ->end();
                            else
                                $expediente->setNumero((string) $numero);
                        }
                    }
                }
                foreach ($paciente->getExpedientes() as $expediente) {
                    if (is_null($paciente->getId())) {
                        $dql = "SELECT count(e) as resul
                  FROM MinsalSiapsBundle:MntExpediente e
                  JOIN e.idPaciente p
                  WHERE e.numero LIKE :variable";
                        $repuesta = $this->getModelManager()
                                ->getEntityManager('MinsalSiapsBundle:MntExpediente')
                                ->createQuery($dql)
                                ->setParameter('variable', $expediente->getNumero())
                                ->getArrayResult();
                    } else {
                        $dql = "SELECT count(e) as resul
                  FROM MinsalSiapsBundle:MntExpediente e
                  JOIN e.idPaciente p
                  WHERE e.numero LIKE :variable AND p.id != :paciente";
                        $repuesta = $this->getModelManager()
                                ->getEntityManager('MinsalSiapsBundle:MntExpediente')
                                ->createQuery($dql)
                                ->setParameter('variable', $expediente->getNumero())
                                ->setParameter('paciente', $paciente->getId())
                                ->getArrayResult();
                    }
                }
                if ($repuesta[0]['resul'] == 1) {
                    $errorElement->with('numero')
                            ->addViolation('Este expediente ya existe digite otro')
                            ->end();
                }
            }
        }
        /* VALIDACIÓN DE QUE EL PACIENTE NO EXISTA */
        if (is_null($paciente->getId())) {
            $dql = "SELECT count(p) as resul
                  FROM MinsalSiapsBundle:MntPaciente p
                  WHERE p.primerNombre = :primer_nombre AND p.segundoNombre = :segundo_nombre AND
                        p.primerApellido = :primer_apellido AND p.segundoApellido = :segundo_apellido AND
                        p.fechaNacimiento = :fecha_nacimiento";
            $repuesta = $this->getModelManager()
                    ->getEntityManager('MinsalSiapsBundle:MntExpediente')
                    ->createQuery($dql)
                    ->setParameters(array(
                        'primer_nombre' => (chop(ltrim($paciente->getPrimerNombre()))),
                        'segundo_nombre' => (chop(ltrim($paciente->getSegundoNombre()))),
                        'primer_apellido' => (chop(ltrim($paciente->getPrimerApellido()))),
                        'segundo_apellido' => (chop(ltrim($paciente->getSegundoApellido()))),
                        'fecha_nacimiento' => $paciente->getFechaNacimiento()
                    ))
                    ->getArrayResult();
            if ($repuesta[0]['resul'] == 1)
                $errorElement->with('primerNombre')
                        ->addViolation('Ya existe esta persona, debe buscarla para saber su número de expediente')
                        ->end();
        }

        //Verificando los formatos de acuerdo el documento seleccionado
        if ($paciente->getIdDocPaciente() == 'DUI') {
            $numero_doc = $paciente->getNumeroDocIdePaciente();
            if (preg_match('/[0-9]{8}-[0-9]{1}/', $numero_doc) == 0) {
                $errorElement->with('numeroDocIdePaciente')
                        ->addViolation('El formato del número de DUI es incorrecto')
                        ->end();
            }
        } elseif ($paciente->getIdDocPaciente() == 'NIT') {
            $numero_doc = $paciente->getNumeroDocIdePaciente();
            if (preg_match('/[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}/', $numero_doc) == 0) {
                $errorElement->with('numeroDocIdePaciente')
                        ->addViolation('El formato del número de NIT es incorrecto')
                        ->end();
            }
        } else {
            if ($paciente->getIdDocPaciente() == 'Carné ISSS') {
                $numero_doc = $paciente->getNumeroDocIdePaciente();
                if (preg_match('/[0-9]{9}/', $numero_doc) == 0) {
                    $errorElement->with('numeroDocIdePaciente')
                            ->addViolation('El formato del número de documento es incorrecto')
                            ->end();
                }
            }
        }
        //Validando número de documento para el responsable  
        if ($paciente->getIdDocResponsable() == 'DUI') {
            $numero_doc = $paciente->getNumeroDocIdeResponsable();
            if (preg_match('/[0-9]{8}-[0-9]{1}/', $numero_doc) == 0) {
                $errorElement->with('numeroDocIdeResponsable')
                        ->addViolation('El formato del número de DUI es incorrecto')
                        ->end();
            }
        } elseif ($paciente->getIdDocResponsable() == 'NIT') {
            $numero_doc = $paciente->getNumeroDocIdeResponsable();
            if (preg_match('/[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}/', $numero_doc) == 0) {
                $errorElement->with('numeroDocIdeResponsable')
                        ->addViolation('El formato del número de NIT es incorrecto')
                        ->end();
            }
        } else {
            if ($paciente->getIdDocResponsable() == 'Carné ISSS') {
                $numero_doc = $paciente->getNumeroDocIdeResponsable();
                if (preg_match('/[0-9]{9}/', $numero_doc) == 0) {
                    $errorElement->with('numeroDocIdeResponsable')
                            ->addViolation('El formato del número de documento es incorrecto')
                            ->end();
                }
            }
        }
        //Validando número de documento para la persona que proporcionó datos
        if ($paciente->getIdDocProporcionoDatos() == 'DUI') {
            $numero_doc = $paciente->getNumeroDocIdeProporDatos();
            if (preg_match('/[0-9]{8}-[0-9]{1}/', $numero_doc) == 0) {
                $errorElement->with('numeroDocIdeProporDatos')
                        ->addViolation('El formato del número de DUI es incorrecto')
                        ->end();
            }
        } elseif ($paciente->getIdDocProporcionoDatos() == 'NIT') {
            $numero_doc = $paciente->getNumeroDocIdeProporDatos();
            if (preg_match('/[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}/', $numero_doc) == 0) {
                $errorElement->with('numeroDocIdeProporDatos')
                        ->addViolation('El formato del número de NIT es incorrecto')
                        ->end();
            }
        } else {
            if ($paciente->getIdDocProporcionoDatos() == 'Carné ISSS') {
                $numero_doc = $paciente->getNumeroDocIdeProporDatos();
                if (preg_match('/[0-9]{9}/', $numero_doc) == 0) {
                    $errorElement->with('numeroDocIdeProporDatos')
                            ->addViolation('El formato del número de documento es incorrecto')
                            ->end();
                }
            }
        }
        //VALIDACIÓN DE QUE EL SEXO EXISTA
        if (is_null($paciente->getIdSexo())) {
            $errorElement->with('idSexo')
                    ->addViolation('El Sexo es obligatorio')
                    ->end();
        } else {
            $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
            $conn = $em->getConnection();
            $calcular = new Funciones();
            if ($paciente->getHoraNacimiento())
                $edad = $calcular->calcularEdad($conn, $paciente->getFechaNacimiento()->format('d-m-Y'), $paciente->getHoraNacimiento()->format('H:i'));
            else
                $edad = $calcular->calcularEdad($conn, $paciente->getFechaNacimiento()->format('d-m-Y'));
            $aux = explode(' ', $edad);
            if (count($aux) > 1) {
                if (strstr($aux[1], 'año')) {
                    if ($paciente->getIdSexo()->getId() == 3) {
                        $errorElement->with('idSexo')
                                ->addViolation('No se puede elegir el sexo indeterminado para alguien mayor de 6 meses')
                                ->end();
                    }
                } elseif (strstr($aux[1], 'meses')) {
                    if ($aux[0] > 6) {
                        if ($paciente->getIdSexo()->getId() == 3) {
                            $errorElement->with('idSexo')
                                    ->addViolation('No se puede elegir el sexo indeterminado para alguien mayor de 6 meses')
                                    ->end();
                        }
                    }
                }
            } else {
                if (is_null($paciente->getHoraNacimiento())) {
                    $errorElement->with('horaNacimiento')
                            ->addViolation('Debe de elegir una hora para la persona si es que ha nacido el día de hoy')
                            ->end();
                }
            }
        }

        if (is_null($paciente->getPrimerNombre())) {
            $errorElement->with('primerNombre')
                    ->addViolation('El Primer nombre es obligatorio')
                    ->end();
        }

        if (is_null($paciente->getPrimerApellido())) {
            $errorElement->with('primerApellido')
                    ->addViolation('El Primer Apellido es Obligatorio')
                    ->end();
        }
        if (is_null($paciente->getPrimerApellido())) {
            $errorElement->with('primerApellido')
                    ->addViolation('El Primer Apellido es Obligatorio')
                    ->end();
        }

        if (is_null($paciente->getIdNacionalidad()))
            $errorElement->with('idNacionalidad')
                    ->addViolation('Debe de seleccionar la nacionalidad del paciente')
                    ->end();
        if (is_null($paciente->getIdDocPaciente()))
            $errorElement->with('idDocPaciente')
                    ->addViolation('Debe de seleccionar el tipo de documento del paciente')
                    ->end();
        if (is_null($paciente->getIdDocResponsable()))
            $errorElement->with('idDocResponsable')
                    ->addViolation('Debe de seleccionar el tipo de documento del responsable')
                    ->end();
        if (is_null($paciente->getIdDocProporcionoDatos()))
            $errorElement->with('idDocProporcionoDatos')
                    ->addViolation('Debe de seleccionar el tipo de documento de la persona que proporcionó datos')
                    ->end();
        if (is_null($paciente->getIdParentescoProporDatos()))
            $errorElement->with('idParentescoProporDatos')
                    ->addViolation('Debe de seleccionar el parentesco del que proporcionó datos')
                    ->end();
        if (is_null($paciente->getIdParentescoResponsable()))
            $errorElement->with('idParentescoResponsable')
                    ->addViolation('Debe de seleccionar el parentesco del responsable')
                    ->end();
        if (is_null($paciente->getAreaGeograficaDomicilio()))
            $errorElement->with('areaGeograficaDomicilio')
                    ->addViolation('Debe de seleccionar el área geografica del domicilio')
                    ->end();
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->add('view', $this->getRouterIdParameter() . '/view');
        $collection->add('buscaremergencia', 'consulta/emergencia');
    }

//PARA LIMITAR EL NUMERO DE EXPEDIENTES A AGREGAR LA PRIMERA VEZ
    public function getFormTheme() {
        return array_merge(
                parent::getFormTheme(), array('MinsalSiapsBundle:Form:form_admin_fields.html.twig')
        );
    }

}

?>
