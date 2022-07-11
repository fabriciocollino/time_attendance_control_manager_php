<?php
require_once dirname(__FILE__) . '/../../_ruta.php'; 
SeguridadHelper::Pasar(90);



$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 0;
$T_Cmd = (isset($_REQUEST['cmd'])) ? $_REQUEST['cmd'] : '';
$T_Data = (isset($_REQUEST['data'])) ? $_REQUEST['data'] : '';

$T_Key = (isset($_REQUEST['key'])) ? $_REQUEST['key'] : '';

$T_Detalle = (isset($_REQUEST['detalle'])) ? $_REQUEST['detalle'] : '';

$Item_Name="equipo";
$T_Titulo = "Equipos";
$T_Script = "Equipos";
$T_Titulo_Singular = _('Equipo');
$T_Titulo_Pre = _('el');


switch ($T_Tipo) {

	case 'verify-add':


		$o_Equipo = Equipo_L::obtenerPorCodigoDeVerificacion(str_replace(' ', '', $T_Key));

		if (is_null($o_Equipo)) {
			$T_Error = _('Equipo no encontrado. Asegúrate de copiar los 6 dígitos del código verificador');
		}else{
            $T_Mensaje = _('Equipo verificado correctamente!');

            $T_IngreseNombre=true;
        }
		break;
    case 'add':


        $o_Equipo = Equipo_L::obtenerPorCodigoDeVerificacion(str_replace(' ', '', $T_Key));

        if (is_null($o_Equipo)) {
            $T_Error = _('Equipo no encontrado. Asegúrate de copiar los 6 dígitos del código verificador');
        }else{


            $o_Equipo->setDetalle($T_Detalle);
            $o_Equipo->setPassword('');

            if(Equipo_L::moverACliente($o_Equipo)){

                $temp_subdominio=$subdominio;
                $subdominio = 'manager';
                PubSubHelper::sendMessage(CMD_FIRST_START_CONFIG, json_encode(array('client_id'=>$o_Cliente->getId(),'sub_dom'=>$o_Cliente->getSubdominio())), $o_Equipo->getUUID());
                $subdominio = $temp_subdominio;

                $T_Mensaje = _('Equipo guardado correctamente!');
                header('Location: ' . WEB_ROOT . '/#equipos');

            }else{
                $T_Error = _('No se pudo mover el equipo');
            }

        }

        break;

}





