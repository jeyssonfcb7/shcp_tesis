<?php

namespace Minsal\SeguimientoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Minsal\Metodos\Funciones;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;

class SecIngresoAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('idProcedenciaIngreso', 'entity', array(
                    'required' => true,
                    'label' => 'Procedencia de ingreso',
                    'class' => 'MinsalSeguimientoBundle:SecProcedenciaIngreso',
                    'query_builder' => function(EntityRepository $repositorio) {
                return $repositorio
                        ->createQueryBuilder('spi')
                        ->where('spi.habilitado = true');
            }))
                ->add('idCircunstanciaIngreso', 'entity', array(
                    'required' => true,
                    'label' => 'Circunstancia de ingreso',
                    'class' => 'MinsalSeguimientoBundle:SecCircunstanciaIngreso',
                    'query_builder' => function(EntityRepository $repositorio) {
                return $repositorio
                        ->createQueryBuilder('sci')
                        ->where('sci.habilitado = true');
            }))
                ->add('fecha', 'date', array(
                    'required' => true,
                    'label' => 'Fecha del Ingreso',
                    'widget' => 'single_text', 'format' => 'dd-MM-yyyy'
                ))
                ->add('hora', 'time', array('required' => true, 'label' => 'Hora del Ingreso'))
                ->add('idAtenAreaModEstab', 'entity', array('label' => 'Especialidad',
                    'class' => 'MinsalSiapsBundle:MntAtenAreaModEstab'))
                ->add('idAmbienteIngreso', 'entity', array('label' => 'Servicio de Ingreso',
                    'class' => 'MinsalSiapsBundle:MntAtenAreaModEstab'))
                ->add('embarazada', null, array('label' => 'Embarazada', 'required' => false,))
                ->add('semanasAmenorrea', 'number', array('required' => false, 'label' => 'Semanas de amenorrea'))
                ->add('fechaProbableParto', 'date', array('required' => false,
                    'label' => 'Fecha Probable de Parto',
                    'widget' => 'single_text', 'format' => 'dd-MM-yyyy'))
                ->add('diagnostico', 'textarea', array('required' => true, 'label' => 'Diagnóstico de Ingreso'))
                //->add('idCie10', null, array('label' => 'Código CIE-10'))
                ->add('idTipoAccidente', 'entity', array('label' => 'Tipo de Accidente',
                    'class' => 'MinsalSeguimientoBundle:SecTipoAccidente', 'required' => false,
                    'query_builder' => function(EntityRepository $repositorio) {
                return $repositorio
                        ->createQueryBuilder('spi')
                        ->where('spi.habilitado = true');
            }))
                ->add('idEmpleado', 'entity', array('required' => false, 'label' => 'Nombre del médico que indico el ingreso',
                    'class' => 'MinsalSiapsBundle:MntEmpleado',
                    'query_builder' => function(EntityRepository $repositorio) {
                return $repositorio
                        ->createQueryBuilder('me')
                        ->where('me.idTipoEmpleado = 4');
            }))
                ->add('idEstablecimientoReferencia', null, array('label' => 'Nombre del Establecimiento (REFERIDO DE:)', 'required' => false,
                    'class' => 'MinsalSiapsBundle:CtlEstablecimiento',
                    'query_builder' => function(EntityRepository $repositorio) {
                return $repositorio
                        ->createQueryBuilder('e')
                        ->where('e.idTipoEstablecimiento NOT IN (12,13)');
            }))
                ->add('motivoReferencia', 'textarea', array('required' => false, 'label' => 'Motivo de la Referencia'))
                ->add('responsableTarjeta', 'textarea', array('required' => false, 'label' => 'Persona a quién se le entregan las tarjetas',
                    'constraints'=>array(new Length(array('min'=>10,'max'=>75)))))
                ->add('tarjetasEntregadas', 'integer', array('required' => false, 'label' => 'Cantidad de Tarjetas a entregar',
                    'constraints' => array(
                        new Range(array('min' => 1,'max'=>2,
                                        'minMessage'=> "Debe de entregar al menos una tarjeta",
                                        'maxMessage'=> "No puede entregar más de dos tarjetas")),
            )))
        ;
    }

    public function validate(ErrorElement $errorElement, $ingreso) {
        //  var_dump($ingreso->getIdAtenAreaModEstab());

        $fechaActual = new \DateTime();
        list($hora, $minutos) = explode(":", $ingreso->getHora()->format('H:i'));
        if ($ingreso->getFecha()->diff($fechaActual)->d == 0 && $ingreso->getFecha()->diff($fechaActual)->m == 0 && $ingreso->getFecha()->diff($fechaActual)->y == 0) {
            if ($fechaActual->format('H') < $hora)
                $errorElement->with('hora1')
                        ->addViolation('La hora del ingreso no puede ser mayor que la hora actual')
                        ->end();
            elseif ($fechaActual->format('H') == $hora) {
                if ($fechaActual->format('i') < ($minutos - 1))
                    $errorElement->with('hora2')
                            ->addViolation('La hora del ingreso no puede ser mayor que la hora actual')
                            ->end();
            }
        } elseif ($ingreso->getFecha()->diff($fechaActual)->invert == 1) {
            $errorElement->with('fecha')
                    ->addViolation('La fecha del ingreso no puede ser mayor que la fecha actual')
                    ->end();
        }

        if (is_null($ingreso->getId())) {
            $posiblePaciente = $this->getModelManager()
                    ->getEntityManager('MinsalSeguimientoBundle:SecIngreso')
                    ->createQuery("
                    SELECT p.id
                    FROM MinsalSeguimientoBundle:SecIngreso i
                    JOIN i.idExpediente e
                    JOIN e.idPaciente p
                    WHERE p.id= :id AND i.fecha = :actual")
                    ->setParameter('id', $ingreso->getIdExpediente()->getIdPaciente()->getId())
                    ->setParameter('actual', $fechaActual->format('d-m-Y'))
                    ->getResult();
            foreach ($posiblePaciente as $paciente) {
                $errorElement->with('error')
                        ->addViolation('No se puede ingresar a este paciente porque ha sido ingresado anteriormente')
                        ->end();
            }
        }

        if (is_null($ingreso->getIdProcedenciaIngreso()))
            $errorElement->with('idProcedenciaIngreso')
                    ->addViolation('Debe de seleccionar la procedencia del ingreso')
                    ->end();

        if (is_null($ingreso->getIdCircunstanciaIngreso()))
            $errorElement->with('idCircunstanciaIngreso')
                    ->addViolation('Debe de seleccionar la circunstancia del ingreso')
                    ->end();
    }

    public function getTemplate($name) {
        switch ($name) {
            case 'edit':
                return 'MinsalSeguimientoBundle:SecIngreso:edit.html.twig';
                break;
            case 'list':
                return 'MinsalSeguimientoBundle:SecIngreso:list.html.twig';
                break;
            case 'resumen':
                return 'MinsalSeguimientoBundle:SecIngreso:resumen.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    public function preUpdate($ingreso) {
        $ingreso->setIdUsuarioModifica($this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser());
        $ingreso->setFechaModificacion(new \DateTime());
    }

    public function prePersist($ingreso) {
        $estado = $this->getModelManager()
                ->find('MinsalSeguimientoBundle:SecEstadoPaciente', 2);
        $ingreso->setIdEstado($estado);
        $ingreso->setIdUsuarioRegistra($this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser());
        $ingreso->setFechaRegistro(new \DateTime());
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->add('create', 'create/id_paciente'); //POR SI SE ENVIA PARAMETROS
        $collection->add('resumen', 'resumen/');
    }

}

?>
