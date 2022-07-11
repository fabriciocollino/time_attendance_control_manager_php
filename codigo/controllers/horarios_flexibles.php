<?php

/*
 * 
 * 
 * 
  [
  {
  "sec_id", 
  "orden": "1",
  "horario_id": 5,
  "duracion": 3
  }
  ]
 */


require_once dirname(__FILE__) . '/../../_ruta.php';

if ($o_Plan->getId() < PLAN_PLUS)die('nop'); //plan free no pasa;

$T_Titulo = _('Horarios Flexibles');
$T_Titulo_Singular = _('Horario');
$T_Titulo_Pre = _('el');
$T_Script = 'horarios_flexibles';
$Item_Name = "horarios_flexible";
$T_Link = '';
$T_Mensaje = '';



$T_Id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 0;
$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';


$T_Horarios = isset($_POST['horarios']) ? (string) $_POST['horarios'] : '';
$T_Detalle = isset($_REQUEST['detalle']) ? (string) $_REQUEST['detalle'] : '';


switch ($T_Tipo) {
    case 'add':
    case 'edit':
        SeguridadHelper::Pasar(50);

        $o_Horario_Flexible = Horario_Flexible_L::obtenerPorId($T_Id);
        if (is_null($o_Horario_Flexible)) {
            $o_Horario_Flexible = new Horario_Flexible_O();
        }
        
        $o_Horario_Flexible->setDetalle($T_Detalle);
        $T_Horarios = str_replace('\"', '"', $T_Horarios); 
        $o_Horario_Flexible->setHorarios($T_Horarios);

        $nuevo_horario = 0;
        if ($o_Horario_Flexible->getId() == 0) $nuevo_horario = 1;//esta variable me permite saber si fue un insert o un edit

        if (!$o_Horario_Flexible->save(Registry::getInstance()->general['debug'])) {
            $T_Error = $o_Horario_Flexible->getErrores();
        } else {
            if($nuevo_horario)
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_FLEXIBLE_CREAR, $a_Logs_Tipos[LOG_HORARIO_FLEXIBLE_CREAR], '<b>Id:</b> ' . $o_Horario_Flexible->getId() . ' <b>Horario:</b> ' . $o_Horario_Flexible->getDetalle() , $o_Horario_Flexible->getId());
            else
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_FLEXIBLE_EDITAR, $a_Logs_Tipos[LOG_HORARIO_FLEXIBLE_EDITAR], '<b>Id:</b> ' . $o_Horario_Flexible->getId() . ' <b>Horario:</b> ' . $o_Horario_Flexible->getDetalle() , $o_Horario_Flexible->getId());

            $T_Mensaje = _('Horario flexible guardado con éxito.');
        }

        goto defaultLabel;
        break;

    case 'view':
        $o_Horario_Flexible = Horario_Flexible_L::obtenerPorId($T_Id);

        if (is_null($o_Horario_Flexible)) {
            $o_Horario_Flexible = new Horario_Flexible_O();
        } else {
            
        }
        break;
    
    case 'delete':

        $o_Horario_Flexible = Horario_Flexible_L::obtenerPorId($T_Id);

        if (is_null($o_Horario_Flexible)) {
            $T_Error = _('Lo sentimos, el horario flexible que desea eliminar no existe.');
        } else {
            $cantidad_personas = Persona_L::obtenerPorHorariodeTrabajoCOUNT($T_Id,HORARIO_FLEXIBLE);
            if ($cantidad_personas == 0) {
                if (!$o_Horario_Flexible->delete(Registry::getInstance()->general['debug'])) {
                    $T_Error = $o_Horario_Flexible->getErrores();
                } else {
                    SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_FLEXIBLE_ELIMINAR, $a_Logs_Tipos[LOG_HORARIO_FLEXIBLE_ELIMINAR], '<b>Id:</b> ' . $o_Horario_Flexible->getId() . ' <b>Horario:</b> ' . $o_Horario_Flexible->getDetalle() , $o_Horario_Flexible->getId());
                    $T_Mensaje = _('El horario flexible fue eliminado con éxito.');
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

        $o_Listado = Horario_Flexible_L::obtenerTodos();
}
