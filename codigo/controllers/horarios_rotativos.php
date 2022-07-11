<?php


require_once dirname(__FILE__) . '/../../_ruta.php';

if ($o_Plan->getId() < PLAN_PREMIUM)die('nop'); //plan plus no pasa;

$T_Titulo = _('Horarios Rotativos');
$T_Titulo_Singular = _('Horario');
$T_Titulo_Pre = _('el');
$T_Script = 'horarios_rotativos';
$Item_Name = "horarios_rotativo";
$T_Link = '';
$T_Mensaje = '';



$T_Id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 0;
$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';


$T_Horarios = isset($_POST['horarios']) ? (string) $_POST['horarios'] : '';
$T_Detalle = isset($_REQUEST['detalle']) ? (string) $_REQUEST['detalle'] : '';
$T_FechaInicio = isset($_REQUEST['fecha_inicio']) ? (string) $_REQUEST['fecha_inicio'] : '';

switch ($T_Tipo) {
    case 'add':
    case 'edit':
        SeguridadHelper::Pasar(50);

        $o_Horario_Rotativo = Horario_Rotativo_L::obtenerPorId($T_Id);
        if (is_null($o_Horario_Rotativo)) {
            $o_Horario_Rotativo = new Horario_Rotativo_O();
        }
        
        $o_Horario_Rotativo->setDetalle($T_Detalle);
        $T_Horarios = str_replace('\"', '"', $T_Horarios); 
        $o_Horario_Rotativo->setHorarios($T_Horarios);
        $o_Horario_Rotativo->setFechaInicio($T_FechaInicio,'Y-m-d H:i:s');

        $nuevo_horario = 0;
        if ($o_Horario_Rotativo->getId() == 0) $nuevo_horario = 1;//esta variable me permite saber si fue un insert o un edit

        if (!$o_Horario_Rotativo->save(Registry::getInstance()->general['debug'])) {
            $T_Error = $o_Horario_Rotativo->getErrores();
        } else {
            if($nuevo_horario)
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_ROTATIVO_ELIMINAR, $a_Logs_Tipos[LOG_HORARIO_ROTATIVO_CREAR], '<b>Id:</b> ' . $o_Horario_Rotativo->getId() . ' <b>Horario:</b> ' . $o_Horario_Rotativo->getDetalle() , $o_Horario_Rotativo->getId());
            else
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_ROTATIVO_ELIMINAR, $a_Logs_Tipos[LOG_HORARIO_ROTATIVO_EDITAR], '<b>Id:</b> ' . $o_Horario_Rotativo->getId() . ' <b>Horario:</b> ' . $o_Horario_Rotativo->getDetalle() , $o_Horario_Rotativo->getId());
            $T_Mensaje = _('Horario rotativo guardado con éxito.');
        }

        goto defaultLabel;
        break;

    case 'view':
        $o_Horario_Rotativo = Horario_Rotativo_L::obtenerPorId($T_Id);

        if (is_null($o_Horario_Rotativo)) {
            $o_Horario_Rotativo = new Horario_Rotativo_O();
        } else {
            
        }
        break;
    
    case 'delete':

        $o_Horario_Rotativo = Horario_Rotativo_L::obtenerPorId($T_Id);

        if (is_null($o_Horario_Rotativo)) {
            $T_Error = _('Lo sentimos, el horario rotativo que desea eliminar no existe.');
        } else {
            $cantidad_personas = Persona_L::obtenerPorHorariodeTrabajoCOUNT($T_Id,HORARIO_ROTATIVO);
            if ($cantidad_personas == 0) {
                if (!$o_Horario_Rotativo->delete(Registry::getInstance()->general['debug'])) {
                    $T_Error = $o_Hora_Trabajo->getErrores();
                } else {
                    SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_ROTATIVO_ELIMINAR, $a_Logs_Tipos[LOG_HORARIO_ROTATIVO_ELIMINAR], '<b>Id:</b> ' . $T_Id . ' <b>Horario:</b> ' . $o_Horario_Rotativo->getDetalle() , $T_Id);
                    $T_Mensaje = _('El horario rotativo fue eliminado con éxito.');
                }
            } else {
                $T_Eliminado = false;
                $T_Error = _('El horario no se puede eliminar, porque está asignado a una o más personas.');
                goto defaultLabel;
            }
        }

        goto defaultLabel;
        break;


    default:
        defaultLabel:
        SeguridadHelper::Pasar(20);

        $o_Listado = Horario_Rotativo_L::obtenerTodos();
}
