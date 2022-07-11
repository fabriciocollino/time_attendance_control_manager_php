<?php

require_once dirname(__FILE__) . '/../../_ruta.php';


$T_Titulo = _('Mensajes');
$Item_Name = "mensaje";
$T_Titulo_Singular = "mensaje";
$T_Titulo_Pre = "un";
$T_Script = 'mensaje';
$T_Mensaje = '';
$T_sync_checker = '';
$T_sync_js_start = '';


$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;
$T_Cmd = (isset($_REQUEST['cmd'])) ? $_REQUEST['cmd'] : '';


switch ($T_Tipo) {
    case 'accion':

        if($T_Cmd=='mark_as_read') {
            $o_Mensaje = Mensaje_L::obtenerPorId($T_Id);
            if (!is_null($o_Mensaje)) {
                $o_Mensaje->setVisto(1);
                $o_Mensaje->setFechaVisto(date('Y-m-d H:i:s'), 'Y-m-d H:i:s');
                $o_Mensaje->save('Off');
            } else {
                die("El mensaje no existe");
            }
            die();
        }
        break;
    //default:
       // defaultLabel:


}

