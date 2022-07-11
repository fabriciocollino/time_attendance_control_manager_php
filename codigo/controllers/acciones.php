<?php

SeguridadHelper::Pasar(90);

$T_Titulo = _('Acciones');
$T_Script = 'acciones';
$Item_Name = 'acciones';
$T_Link = '';
$T_Error = array();
$T_Mensaje = '';
$T_Pregunta = (isset($_POST['pregunta'])) ? $_POST['pregunta'] : array();

/*
$a_Archivos = array();
if (Config_L::p('backup') != '' && Config_L::p('backup_usuario') != '' && Config_L::p('backup_password') != '') {
	if (file_exists($rutaBackup . '/no_borrar.aux')) {
		$resultado = SOHelper::mountRed(Config_L::p('backup_usuario'), Config_L::p('backup_password'), Config_L::p('backup'), $rutaBackup);
		if ($resultado != array()) {
			$T_Error = implode(' ', $resultado);
		}
	}
}

$_SESSION['confirmar']['archivo'] = (integer) (!isset($_POST['archivo'])) ? (isset($_SESSION['confirmar']['archivo'])) ? $_SESSION['confirmar']['archivo'] : 0  : $_POST['archivo'];
$a_Archivos = SOHelper::file_array($rutaBackup);
if (!is_array($a_Archivos)) {
	$T_Error = $a_Archivos;
}
 */

if (isset($_POST['btnResetBD'])) {
	$_SESSION['confirmar']['boton'] = 'btnResetBD';
	$_SESSION['confirmar']['texo'] = _('Atención esta por borrar completamente la base de datos del sistema. Esta operación es irreversible.') . '<br />' . _('¿Esta seguro que desea continuar?.');
}
if (isset($_POST['btnRe-Sincronizar'])) {
	$_SESSION['confirmar']['boton'] = 'btnRe-Sincronizar';
	$_SESSION['confirmar']['texo'] = _('Está por re-sincronizar todas las personas del sistema, este proceso puede demorar un minutos hasta que todos los Equipo del sistema reciban la nueva configuración.') . '<br />' . _('¿Esta seguro que desea realizar esta operación en este instante?');
}
if (isset($_POST['btnBloqueoGat'])) {
	$_SESSION['confirmar']['boton'] = 'btnBloqueoGat';
	$_SESSION['confirmar']['texo'] = _('Bloqueo de Emergencia') . ' <br />' . _('Se bloquearan todos los equipos.') . ' <br /> ' . _('Esto hará que todas las puertas no se puedan abrir.');
}
if (isset($_POST['btnDesBloqueoGat'])) {
	$_SESSION['confirmar']['boton'] = 'btnDesBloqueoGat';
	$_SESSION['confirmar']['texo'] = _('Bloqueo de Emergencia') . ' <br />' . _('Se Des-bloquearan todos los equipos.');
}
if (isset($_POST['btnBackupGat'])) {
	if ($T_Error == array()) {
		$_SESSION['confirmar']['boton'] = 'btnBackupGat';
		$_SESSION['confirmar']['texo'] = _('Copias de Seguridad') . ' <br />' . _('Se realizara una copia de seguridad de la Base de datos del ACSM.');
	}
}
if (isset($_POST['btnBackupImportGat'])) {
	if ($_SESSION['confirmar']['archivo'] != 0) {
		$_SESSION['confirmar']['boton'] = 'btnBackupImportGat';
		$_SESSION['confirmar']['texo'] = _('Copias de Seguridad') . ' <br />' . _('Se restaurar una copia de seguridad del ACSM. El archivo seleccionado es:') . '[' . $a_Archivos[$_SESSION['confirmar']['archivo']] . ']';
	} else {
		$T_Error = _('Debe seleccionar un archivo');
	}
}
if (isset($_POST['btnDescargarBackup'])) {
	if ($_SESSION['confirmar']['archivo'] != 0) {
		$_SESSION['confirmar']['boton'] = 'btnDescargarBackup';
		$_SESSION['confirmar']['texo'] = _('Copias de Seguridad') . ' <br />' . _('Va a descargar un copia de seguridad del ACSM. El archivo seleccionado es:') . '[' . $a_Archivos[$_SESSION['confirmar']['archivo']] . ']';
	} else {
		$T_Error = _('Debe seleccionar un archivo');
	}
}

if (isset($_POST['btnBorrarBackup'])) {
	if ($_SESSION['confirmar']['archivo'] != 0) {
		$_SESSION['confirmar']['boton'] = 'btnBorrarBackup';
		$_SESSION['confirmar']['texo'] = _('Copias de Seguridad') . ' <br />' . _('Va a borrar un copia de seguridad del ACSM. El archivo seleccionado es:') . '[' . $a_Archivos[$_SESSION['confirmar']['archivo']] . ']';
	} else {
		$T_Error = _('Debe seleccionar un archivo');
	}
}


if(isset($_POST['tipo']) && $_POST['tipo']=='accion') {
	switch ($_POST['id']) {
		case 'resetear':
			SeguridadHelper::Pasar(90);
			$cnn = Registry::getInstance()->DbConn;
			$cnn->Query("TRUNCATE TABLE logs_equipo");
			$cnn->Query("TRUNCATE TABLE logs_heartbeat");
			$cnn->Query("TRUNCATE TABLE logs_web");
			$cnn->Query("TRUNCATE TABLE grupos_personas");
			$cnn->Query("TRUNCATE TABLE mensajes");
			$cnn->Query("TRUNCATE TABLE personas");
			$cnn->Query("TRUNCATE TABLE huellas");
			$cnn->Query("TRUNCATE TABLE sync");
			$cnn->Query("TRUNCATE TABLE email");
			break;
	}
}


if (isset($_POST['btnConf'])) {
	if (isset($_POST['passw']) && $_POST['passw'] != '') {
		if (is_null(Usuario_L::obtenerPorLogin(Registry::getInstance()->Usuario->getUsuario(), $_POST['passw']))) {
			$T_Error['contrasena'] = 'La Contraseña es incorrecta.';
		} else {
			switch ($_SESSION['confirmar']['boton']) {
				case 'btnResetBD':
					SeguridadHelper::Pasar(90);
					$cnn = Registry::getInstance()->DbConn;
					$cnn->Query("TRUNCATE TABLE equipos");
					$cnn->Query("TRUNCATE TABLE grupo");
					$cnn->Query("TRUNCATE TABLE logs_alarma");
					$cnn->Query("TRUNCATE TABLE logs_equipo");
					$cnn->Query("TRUNCATE TABLE email");
					$cnn->Query("TRUNCATE TABLE logs_usos");
					//$cnn->Query("TRUNCATE TABLE logs_web");
					$cnn->Query("TRUNCATE TABLE persona");
					$cnn->Query("TRUNCATE TABLE persona_id");
					$cnn->Query("TRUNCATE TABLE sync");
					$cnn->Query("TRUNCATE TABLE zona");
					$cnn->Query("TRUNCATE TABLE notificaciones");
					//$cnn->Query("TRUNCATE TABLE notificaciones_contenido");
					//$cnn->Query("TRUNCATE TABLE notificaciones_disparadores");
					$cnn->Query("TRUNCATE TABLE notificaciones_grupos");
					$cnn->Query("TRUNCATE TABLE notificaciones_personas");
					$cnn->Query("TRUNCATE TABLE control_personal");
					$cnn->Query("TRUNCATE TABLE zona_tipo");
					//$cnn->Query("TRUNCATE TABLE usuario");
					$cnn->Query("TRUNCATE TABLE usuario_tipo");

					//inserto los valores por defecto
					$cnn->Query("INSERT INTO `zona_tipo`(`tzo_Id`, `tzo_Detalle`) VALUES ('1','" . _('Empresa') . "');");
					$cnn->Query("INSERT INTO `dispositivo_tipo` (`tdi_Id`, `tdi_Detalle`) VALUES
								(1, '" . _('Puerta Simple') . "'),
								(2, '" . _('Máquina de Cafe') . "'),
								(3, '" . _('Timbre') . "'),
								(4, '" . _('Portón levadizo') . "'),
								(5, '" . _('Ascensor') . "'),
								(6, '" . _('Iluminación') . "'),
								(7, '" . _('Reloj Control de Personal') . "'),
								(8, '" . _('Recorrido de Vigilancia') . "');");
					$cnn->Query("INSERT INTO `permiso` (`prm_Id`, `prm_Detalle`, `prm_Dia`, `prm_Hs_Inicio`, `prm_Hs_Fin`) VALUES
								(1, '" . _('Todos los días de 00 a 00') . "', '1234567', '00:00:00', '00:00:00'),
								(2, '" . _('De lunes a viernes 09 a 17') . "', '23456', '09:00:00', '17:00:00'),
								(3, '" . _('De lunes a viernes 17 a 23') . "', '23456', '17:00:00', '23:00:00'),
								(4, '" . _('De lunes a viernes 22 a 06') . "', '1234567', '22:00:00', '06:00:00');");
					$cnn->Query("INSERT INTO `grupo` (`rol_Id`, `rol_Detalle`) VALUES
								(1, '" . _('Administrador') . "'),
								(2, '" . _('Ventas') . "'),
								(3, '" . _('Atención al Cliente') . "'),
								(4, '" . _('Informática') . "'),
								(5, '" . _('Stock') . "'),
								(6, '" . _('Mantenimiento') . "'),
								(7, '" . _('Limpieza') . "'),
								(8, '" . _('Vigilancia') . "'),
								(9, '" . _('Mecánica') . "');");
					//$cnn->Query("INSERT INTO `usuario` (`usu_Id`, `usu_Tus_Id`, `usu_Nombre`, `usu_Apellido`, `usu_Te_Celular`, `usu_Te_Personal`, `usu_E_Mail`, `usu_Dni`, `usu_Usuario`, `usu_Clave`, `usu_Creado`, `usu_Enable`) VALUES
					//			(1, 1, '"._('Administrador')."', '"._('Administrador')."', '', '', '', '', 'admin', 'dd7b7b74ea160e049dd128478e074ce47254bde8', '2012-06-22 12:19:24', NULL);");										
					$cnn->Query("INSERT INTO `usuario_tipo` (`tus_Id`, `tus_Detalle`, `tus_Codigo`) VALUES
								(1, '" . _('Administrador') . "', 99),
								(2, '" . _('Supervisor') . "', 50),
								(3, '" . _('Operador') . "', 20);");

					$T_Mensaje = _('Los combios fueron realizados con éxito.');
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[8], _('Reiniciar todas las Bases de Datos'));
					$_SESSION['confirmar']['boton'] = '';
					break;
				case 'btnResetBD':
					SeguridadHelper::Pasar(90);
					$cnn = Registry::getInstance()->DbConn;
					$cnn->Query("TRUNCATE TABLE personas");
					$cnn->Query("TRUNCATE TABLE sync");
					$cnn->Query("TRUNCATE TABLE huellas");
					$cnn->Query("TRUNCATE TABLE mensajes");
/*					$cnn->Query("TRUNCATE TABLE equipos");
					$cnn->Query("TRUNCATE TABLE grupo");
					$cnn->Query("TRUNCATE TABLE logs_alarma");
					$cnn->Query("TRUNCATE TABLE logs_equipo");
					$cnn->Query("TRUNCATE TABLE email");
					$cnn->Query("TRUNCATE TABLE logs_usos");
					//$cnn->Query("TRUNCATE TABLE logs_web");
					$cnn->Query("TRUNCATE TABLE persona");
					$cnn->Query("TRUNCATE TABLE persona_id");
					$cnn->Query("TRUNCATE TABLE sync");
					$cnn->Query("TRUNCATE TABLE zona");
					$cnn->Query("TRUNCATE TABLE notificaciones");
					//$cnn->Query("TRUNCATE TABLE notificaciones_contenido");
					//$cnn->Query("TRUNCATE TABLE notificaciones_disparadores");
					$cnn->Query("TRUNCATE TABLE notificaciones_grupos");
					$cnn->Query("TRUNCATE TABLE notificaciones_personas");
					$cnn->Query("TRUNCATE TABLE control_personal");
					$cnn->Query("TRUNCATE TABLE zona_tipo");
					//$cnn->Query("TRUNCATE TABLE usuario");
					$cnn->Query("TRUNCATE TABLE usuario_tipo");
/*
					//inserto los valores por defecto
					$cnn->Query("INSERT INTO `zona_tipo`(`tzo_Id`, `tzo_Detalle`) VALUES ('1','" . _('Empresa') . "');");
					$cnn->Query("INSERT INTO `dispositivo_tipo` (`tdi_Id`, `tdi_Detalle`) VALUES
								(1, '" . _('Puerta Simple') . "'),
								(2, '" . _('Máquina de Cafe') . "'),
								(3, '" . _('Timbre') . "'),
								(4, '" . _('Portón levadizo') . "'),
								(5, '" . _('Ascensor') . "'),
								(6, '" . _('Iluminación') . "'),
								(7, '" . _('Reloj Control de Personal') . "'),
								(8, '" . _('Recorrido de Vigilancia') . "');");
					$cnn->Query("INSERT INTO `permiso` (`prm_Id`, `prm_Detalle`, `prm_Dia`, `prm_Hs_Inicio`, `prm_Hs_Fin`) VALUES
								(1, '" . _('Todos los días de 00 a 00') . "', '1234567', '00:00:00', '00:00:00'),
								(2, '" . _('De lunes a viernes 09 a 17') . "', '23456', '09:00:00', '17:00:00'),
								(3, '" . _('De lunes a viernes 17 a 23') . "', '23456', '17:00:00', '23:00:00'),
								(4, '" . _('De lunes a viernes 22 a 06') . "', '1234567', '22:00:00', '06:00:00');");
					$cnn->Query("INSERT INTO `grupo` (`rol_Id`, `rol_Detalle`) VALUES
								(1, '" . _('Administrador') . "'),
								(2, '" . _('Ventas') . "'),
								(3, '" . _('Atención al Cliente') . "'),
								(4, '" . _('Informática') . "'),
								(5, '" . _('Stock') . "'),
								(6, '" . _('Mantenimiento') . "'),
								(7, '" . _('Limpieza') . "'),
								(8, '" . _('Vigilancia') . "'),
								(9, '" . _('Mecánica') . "');");
					//$cnn->Query("INSERT INTO `usuario` (`usu_Id`, `usu_Tus_Id`, `usu_Nombre`, `usu_Apellido`, `usu_Te_Celular`, `usu_Te_Personal`, `usu_E_Mail`, `usu_Dni`, `usu_Usuario`, `usu_Clave`, `usu_Creado`, `usu_Enable`) VALUES
					//			(1, 1, '"._('Administrador')."', '"._('Administrador')."', '', '', '', '', 'admin', 'dd7b7b74ea160e049dd128478e074ce47254bde8', '2012-06-22 12:19:24', NULL);");
					$cnn->Query("INSERT INTO `usuario_tipo` (`tus_Id`, `tus_Detalle`, `tus_Codigo`) VALUES
								(1, '" . _('Administrador') . "', 99),
								(2, '" . _('Supervisor') . "', 50),
								(3, '" . _('Operador') . "', 20);");
*/
					$T_Mensaje = _('Los combios fueron realizados con éxito.');
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[8], _('Reiniciar todas las Bases de Datos'));
					$_SESSION['confirmar']['boton'] = '';
					break;
				case 'btnRe-Sincronizar':
					SeguridadHelper::Pasar(90);
					SyncHelper::SyncTodasLasPersonas();
					$T_Mensaje = _('La Re-sincronizar de personas se a lanzado con éxito...');
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[10], _('Re-sincronizar de personas en todo el sistema'));
					$_SESSION['confirmar']['boton'] = '';
					break;
				case 'btnBloqueoGat':
					SeguridadHelper::Pasar(50);
					$o_Equipo = Equipo_L::obtenerTodos();
					foreach ($o_Equipo as $equipo) {
						$equipo->bloqueado(Registry::getInstance()->general['debug']);
						ConsolaHelper::ejecutarComandoConsola('equipo disable', $equipo);
					}
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[3], _('Bloqueo de emergencia - Bloquea todos los equipos'));
					$_SESSION['confirmar']['boton'] = '';
					break;
				case 'btnDesBloqueoGat':
					SeguridadHelper::Pasar(50);
					$o_Equipo = Equipo_L::obtenerTodos();
					foreach ($o_Equipo as $equipo) {
						$equipo->bloqueado(Registry::getInstance()->general['debug']);
						ConsolaHelper::ejecutarComandoConsola('equipo enable', $equipo);
					}
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[3], _('Bloqueo de emergencia - Desbloquea todos los equipos'));
					$_SESSION['confirmar']['boton'] = '';
					break;
				case 'btnBackupGat':
					SeguridadHelper::Pasar(50);
					$retorno = SOHelper::backupExport(Registry::getInstance()->database['db_user'], Registry::getInstance()->database['db_pass'], Registry::getInstance()->database['db_name'], '', $rutaBackup, Config_L::p('path_mysql'));
					$T_Error['mysql'] = (is_array($retorno)) ? implode(' ', $retorno) : $retorno;
					//print_r($retorno);

					$T_Mensaje = _('Copias de Seguridad del ACSM fueron realizados con éxito...');
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[11], _('Backup - Copias de Seguridad del ACSM ') . $T_Error['mysql']);
					$_SESSION['confirmar']['boton'] = '';
					break;
				case 'btnBackupImportGat':
					SeguridadHelper::Pasar(50);
					$retorno = SOHelper::backupImport(Registry::getInstance()->database['db_user'], Registry::getInstance()->database['db_pass'], Registry::getInstance()->database['db_name'], '', $rutaBackup, Config_L::p('path_mysql'), $a_Archivos[$_SESSION['confirmar']['archivo']]);
					$T_Error['mysql'] = (is_array($retorno)) ? implode(' ', $retorno) : $retorno;
					$T_Mensaje = _('La restauración de la Copia de Seguridad del ACSM fueron realizados con éxito...');
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[11], _('Backup - Restaurar copias de seguridad del ACSM ') . $T_Error['mysql']);
					$_SESSION['confirmar']['boton'] = '';
					break;
				case 'btnDescargarBackup':
					$_SESSION['confirmar']['sql_nombre'] = $a_Archivos[$_SESSION['confirmar']['archivo']];
					$_SESSION['confirmar']['sql_listo_texto'] = _('Descarga la copia de seguridad del ACSM.') . ' <a href="' . $webRutaBackup . '/' . $_SESSION['confirmar']['sql_nombre'] . '">' . _('Haciendo click Aquí') . '</a>';
					$_SESSION['confirmar']['sql_listo'] = 1;
					$_SESSION['confirmar']['sql_error'] = 1;
					$_SESSION['confirmar']['boton'] = '';
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[11], _('Backup - Descarga la copia de seguridad del ACSM. ') . $_SESSION['confirmar']['sql_nombre']);
					break;
				case 'btnBorrarBackup':
					$_SESSION['confirmar']['sql_nombre'] = $a_Archivos[$_SESSION['confirmar']['archivo']];
					//chown($rutaBackup . '/' . $_SESSION['confirmar']['sql_nombre'],777);
					if (unlink($rutaBackup . '/' . $_SESSION['confirmar']['sql_nombre'])) {
						$_SESSION['confirmar']['sql_listo_texto'] = _('La copia de seguridad del ACSM ') . $_SESSION['confirmar']['sql_nombre'] . _(' a sido borrada');
						$_SESSION['confirmar']['sql_error'] = 1;
					} else {
						$_SESSION['confirmar']['sql_listo_texto'] = _('La copia de seguridad del ACSM ') . $_SESSION['confirmar']['sql_nombre'] . _(' NO pudo se borrada');
						$_SESSION['confirmar']['sql_error'] = 0;
					}
					$_SESSION['confirmar']['sql_listo'] = 1;
					$_SESSION['confirmar']['boton'] = '';
					SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . ' - ' . $a_Acciones[11], _('Backup - Borrar la copia de seguridad del ACSM. ') . $_SESSION['confirmar']['sql_nombre']);
					break;
			}
		}
	} else {
		$T_Error['contrasena'] = _('No se ha ingresado la contraseña de usuario');
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///
// NUEVO CODIGO
$T_Tipo     =   isset($_REQUEST['tipo'])        ?       $_REQUEST['tipo']           : '';
$T_Id       =   isset($_REQUEST['id'])          ?       $_REQUEST['id']             : '';



switch ($T_Tipo) {
    case 'resetear':
        break;

    case 'nuevo_campo_tabla':

    default:
        break;
}