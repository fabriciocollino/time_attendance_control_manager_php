<?php
require_once dirname(__FILE__) . '/../../_ruta.php'; 
SeguridadHelper::Pasar(90);



$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 0;
$T_Cmd = (isset($_REQUEST['cmd'])) ? $_REQUEST['cmd'] : '';
$T_Data = (isset($_REQUEST['data'])) ? $_REQUEST['data'] : '';

$Item_Name="equipo";
$T_Titulo = "Equipos";
$T_Script = "Equipos";
$T_Titulo_Singular = _('Equipo');
$T_Titulo_Pre = _('el');


switch ($T_Tipo) {
	case 'add':
	case 'edit':

		$o_Equipo = Equipo_L::obtenerPorId($T_Id);

		$nuevo=false;
		if (is_null($o_Equipo)) {
			$o_Equipo = new Equipo_O();
			$nuevo=true;
		} 

		$o_Equipo->setDetalle(isset($_POST['detalle']) ? $_POST['detalle'] : '');

		if (!$o_Equipo->save(Registry::getInstance()->general['debug'])) {
			$T_Error = $o_Equipo->getErrores();
		} else {
		    if($nuevo)
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_EQUIPO_CREAR, $a_Logs_Tipos[LOG_EQUIPO_CREAR], '<b>Id:</b> ' . $o_Equipo->getId() . ' <b>Detalle:</b> ' . $o_Equipo->getDetalle(), $o_Equipo->getId());
            else
		        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_EQUIPO_EDITAR, $a_Logs_Tipos[LOG_EQUIPO_EDITAR], '<b>Id:</b> ' . $o_Equipo->getId() . ' <b>Detalle:</b> ' . $o_Equipo->getDetalle(), $o_Equipo->getId());

			$T_Mensaje = _('El equipo fue modificado con éxito.');
			if($T_Tipo=='add'){
					SyncHelper::SyncTodasLasPersonas();//si se agrega un nuevo equipo re-sincronizo todas las personas.
			}
		}
		
		

		goto defaultlabel;
		break;
	case 'enable':
		$T_Script = "Habilitar";

		$o_Equipo = Equipo_L::obtenerPorId($T_Id);

		if (is_null($o_Equipo)) {
			$T_Error = _('Lo sentimos, el equipo que desea habilitar no existe.');
		}


		if (!$o_Equipo->desBloqueado(Registry::getInstance()->general['debug'])) {
			//$T_Error = 'Lo sentimos, el equipo que desea habilitar no puede ser modificado.';
			$T_Error = $o_Equipo->getErrores();
		} else {
            SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_EQUIPO_BLOQUEAR, $a_Logs_Tipos[LOG_EQUIPO_BLOQUEAR], '<b>Id:</b> ' . $o_Equipo->getId() . ' <b>Detalle:</b> ' . $o_Equipo->getDetalle(), $o_Equipo->getId());
			//SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[2], 'Tabla - ' . $T_Script . ' Id - ' . $o_Equipo->getId());
            PubSubHelper::sendMessage(CMD_UNBLOCK,'',$o_Equipo->getUUID());
			$T_Mensaje = _('El equipo fue habilitado con éxito.');
		}


		$T_Habilitando = true;
		goto defaultlabel;
		break;
	case 'disable':
		$T_Script = "Bloquear";

		$o_Equipo = Equipo_L::obtenerPorId($T_Id);

		if (is_null($o_Equipo)) {
			$T_Error = _('Lo sentimos, el equipo que desea bloquear no existe.');
		}

		if (!$o_Equipo->bloqueado(Registry::getInstance()->general['debug'])) {
			//$T_Error = 'Lo sentimos, el equipo  que desea eliminar no puede ser eliminado.';
			$T_Error = $o_Equipo->getErrores();
		} else {
			//SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[3], 'Tabla - ' . $T_Script . ' Id - ' . $o_Equipo->getId());
            SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_EQUIPO_DESBLOQUEAR, $a_Logs_Tipos[LOG_EQUIPO_DESBLOQUEAR], '<b>Id:</b> ' . $o_Equipo->getId() . ' <b>Detalle:</b> ' . $o_Equipo->getDetalle(), $o_Equipo->getId());
            PubSubHelper::sendMessage(CMD_BLOCK,'',$o_Equipo->getUUID());
			$T_Mensaje = _('El Equipo fue bloquado con éxito.');
		}
		

		$T_Bloqueado = true;
		goto defaultlabel;
		break;
	case 'testsync':
        SeguridadHelper::Pasar(999);
		$T_Script = "Test Sync";

		$o_Equipo = Equipo_L::obtenerPorId($T_Id);

		if (is_null($o_Equipo)) {
			$T_Error = _('Lo sentimos, el equipo no existe.');
		}

		MQTTHelper::sendMessage('equipo', $o_Equipo, 'sync');

		goto defaultlabel;
		break;
	case 'sendsync':
		$o_Equipo = Equipo_L::obtenerPorId($T_Id);
		if (is_null($o_Equipo)) {
			die('Lo sentimos, el equipo no existe.');
		}
		$o_Equipo->setHeartbeat(0,1,1);
		$o_Equipo->save('Off');


        PubSubHelper::sendMessage(CMD_PING,'Hola',$o_Equipo->getUUID());

		die();
		break;
    case 'reboot':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_REBOOT,'',$o_Equipo->getUUID());
        goto defaultlabel;
        break;
    case 'restart_app':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_RESTART_APP,'',$o_Equipo->getUUID());
        goto defaultlabel;
        break;
    case 'reset_reader':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_RESET_READER,json_encode(array('time'=>2000)),$o_Equipo->getUUID());
        goto defaultlabel;
        break;
    case 'force_ping':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_FORCE_PING,'',$o_Equipo->getUUID());
        goto defaultlabel;
        break;
    case 'blink':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_BLINK,'',$o_Equipo->getUUID());
        goto defaultlabel;
        break;
    case 'clear_network_info':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_CLEAR_NETWORK_INFO,'',$o_Equipo->getUUID());
        goto defaultlabel;
        break;
    case 'purge_database':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_PURGE_DATABASE,'',$o_Equipo->getUUID());
        goto defaultlabel;
        break;
    case 'block_sync':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        if($o_Equipo->getBloquearSync())
            $o_Equipo->setBloquearSync(0);
        else
            $o_Equipo->setBloquearSync(1);
        $o_Equipo->save();

        goto defaultlabel;
        break;
    case 'block_updates':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        if($o_Equipo->getLockUpdates()) {
            $o_Equipo->setLockUpdates(0);
            PubSubHelper::sendMessage(CMD_UNLOCK_UPDATES,'',$o_Equipo->getUUID());
        }
        else {
            $o_Equipo->setLockUpdates(1);
            PubSubHelper::sendMessage(CMD_LOCK_UPDATES,'',$o_Equipo->getUUID());
        }
        $o_Equipo->save();

        goto defaultlabel;
        break;
    case 'maintenance_mode':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        if($o_Equipo->getMaintenanceMode()) {
            $o_Equipo->setMaintenanceMode(0);
            PubSubHelper::sendMessage(CMD_MAINTENANCE_DISABLE,'',$o_Equipo->getUUID());
        }
        else {
            $o_Equipo->setMaintenanceMode(1);
            PubSubHelper::sendMessage(CMD_MAINTENANCE_ENABLE,'',$o_Equipo->getUUID());
        }
        $o_Equipo->save();

        goto defaultlabel;
        break;
    case 'reset_wireless':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_RESET_WIRELESS_NETWORK,'',$o_Equipo->getUUID());

        goto defaultlabel;
        break;
    case 'debug_info':
        SeguridadHelper::Pasar(999);
        $o_Equipo = Equipo_L::obtenerPorId($T_Id);
        if (is_null($o_Equipo)) {
            die('Lo sentimos, el equipo no existe.');
        }
        PubSubHelper::sendMessage(CMD_DEBUG_INFO,'',$o_Equipo->getUUID());

        goto defaultlabel;
        break;
	case 'delete':
        SeguridadHelper::Pasar(999);
		$T_Script = "Eliminar";

		$o_Equipo = Equipo_L::obtenerPorId($T_Id);

		if (is_null($o_Equipo)) {
			$T_Error = _('Lo sentimos, el equipo que desea eliminar no existe.');
		} else {
				if (!$o_Equipo->delete(Registry::getInstance()->general['debug'])) {
					//$T_Error = 'Lo sentimos, el equipo que desea eliminar no puede ser eliminado.';
					$T_Error = $o_Equipo->getErrores();
				} else {
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[6], 'Tabla - ' . $T_Script . ' - Id : ' . $o_Equipo->getId() . ' - Hostname : ' . $o_Equipo->getHost() . ' - Detalle : ' . $o_Equipo->getDetalle() . 'y todos los datos relacionados (en las tablas zona, Logs_usos, logs_alama, logs_equipo y sync) fueron eliminado');
					$T_Mensaje = _('El equipo fue eliminado con éxito.');
					$_SESSION['confirmar'] = array();
				}
		}
		
		$T_Eliminado = true;
		goto defaultlabel;
		break;
	case 'view':
		
		$o_Equipo = Equipo_L::obtenerPorId($T_Id, true);

		if (is_null($o_Equipo)) {
			$T_Error = _('Lo sentimos, el equipo no existe.');
			$o_Equipo= new Equipo_O();
		}

		break;
	default:
	defaultlabel:
        $o_Listado = array();

        $a_Clientes = Cliente_L::obtenerTodosEnabled();
        if (!is_null($a_Clientes)) {
            foreach ($a_Clientes as $o_Cliente) {
                /* @var $o_Cliente Cliente_O */

                $subdominio = $o_Cliente->getSubdominio();

                $o_Suscripcion = Suscripcion_L::obtenerPorId($o_Cliente->getSuscripcion());
                $o_Plan = Planes_L::obtenerPorId($o_Suscripcion->getPlan());
                $G_DbConn1 = new mySQL(
                    $o_Cliente->getDBname(),
                    $o_Cliente->getDBuser(),
                    $o_Cliente->getDBpass(),
                    $o_Cliente->getDBhost(),
                    $o_Cliente->getDBport()
                );


                if (!$G_DbConn1->ConectarSocket()) {
                    die($G_DbConnMGR->get_Error($Registry->general['debug']));
                }

                Registry::getInstance()->DbConn = $G_DbConn1;



                $equipos = Equipo_L::obtenerTodos();

                if(!isset($equipos) || count($equipos)==0)continue;


                $o_Listado = array_merge($o_Listado, $equipos);
                //printear($o_Listado);
            }
        }

		$T_Link = '';
}





