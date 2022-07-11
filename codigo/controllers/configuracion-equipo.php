<?php



$T_Titulo = _('Personas');
$Item_Name="persona";
$T_Script = 'persona';
$T_Mensaje = '';


if(isset($_REQUEST['equipo']))$_SESSION["EQUIPO"]=$_REQUEST['equipo'];


$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 0;


switch ($T_Tipo) {
	case 'add':		

		$o_Persona = new Persona_O();

		$o_Persona->setPerm(isset($_POST['permisos']) ? $_POST['permisos'] : '');
		$o_Persona->setEquipoId(isset($_POST['equipo']) ? $_POST['equipo'] : 0);
		$o_Persona->setNombre(isset($_POST['nombre']) ? $_POST['nombre'] : '');
		$o_Persona->setApellido(isset($_POST['apellido']) ? $_POST['apellido'] : '');
		$o_Persona->setDni(isset($_POST['dni']) ? $_POST['dni'] : '');
		$o_Persona->setTag(isset($_POST['tag']) ? $_POST['tag'] : '');
		$o_Persona->setTelefono(isset($_POST['telefono']) ? $_POST['telefono'] : '');		
		$o_Persona->setEmail(isset($_POST['email']) ? $_POST['email'] : '');
		$o_Persona->setCreadoUsuarioId(Registry::getInstance()->Usuario->getId());

		if (!$o_Persona->save(Registry::getInstance()->general['debug'])) {
			$T_Error = $o_Persona->getErrores();
		} else {
			SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[0], _('Tabla') . ' - ' . $T_Script . ' Id - ' . $o_Persona->getId());
			$T_Mensaje = 'La persona fue guardada con éxito';			
				// Sync
				SyncHelper::SyncPersona($o_Persona);
				// Fin Sync
		}
	

		goto defaultLabel;
		break;
	case 'edit':
		SeguridadHelper::Pasar(20);
		$o_Persona = Persona_L::obtenerPorId($T_Id);		

		$o_Persona->setPerm(isset($_POST['permisos']) ? $_POST['permisos'] : '');
		$o_Persona->setEquipoId(isset($_POST['equipo']) ? $_POST['equipo'] : 0);
		$o_Persona->setNombre(isset($_POST['nombre']) ? $_POST['nombre'] : '');
		$o_Persona->setApellido(isset($_POST['apellido']) ? $_POST['apellido'] : '');
		$o_Persona->setDni(isset($_POST['dni']) ? $_POST['dni'] : '');
		$o_Persona->setTag(isset($_POST['tag']) ? $_POST['tag'] : '');
		$o_Persona->setTelefono(isset($_POST['telefono']) ? $_POST['telefono'] : '');		
		$o_Persona->setEmail(isset($_POST['email']) ? $_POST['email'] : '');
		$o_Persona->setCreadoUsuarioId(Registry::getInstance()->Usuario->getId());

		if (!$o_Persona->save(Registry::getInstance()->general['debug'])) {
			$T_Error = $o_Persona->getErrores();
		} else {
			SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[0], _('Tabla') . ' - ' . $T_Script . ' Id - ' . $o_Persona->getId());
			$T_Mensaje = 'La persona fue guardada con éxito';			
				// Sync
				SyncHelper::SyncPersona($o_Persona);
				// Fin Sync
		}
	

		goto defaultLabel;
		
		break;
	case 'enable':
		SeguridadHelper::Pasar(20);
		
		$o_Persona = Persona_L::obtenerPorId($T_Id, true);

		if (is_null($o_Persona)) {
			$T_Error = _('Lo sentimos, la persona que desea habilitar no existe.');
			goto defaultLabel;
			break;
		}


		if (!$o_Persona->undelete(Registry::getInstance()->general['debug'])) {
			//$T_Error = 'Lo sentimos, la persona que desea habilitar no puede ser modificado.';
			$T_Error = $o_Persona->getErrores();
		} else {
			SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[2], _('Tabla') . ' - ' . $T_Script . ' Id - ' . $o_Persona->getId());
			$T_Mensaje = _('La persona fue habilitada con éxito.');
			// Sync
			SyncHelper::SyncPersona($o_Persona);
			// Fin Sync
		}
		

		goto defaultLabel;
		break;
	case 'disable':
		SeguridadHelper::Pasar(20);

		$o_Persona = Persona_L::obtenerPorId($T_Id);

		if (is_null($o_Persona)) {
			$T_Error = _('Lo sentimos, la persona que desea bloquear no existe.');
			goto defaultLabel;
			break;
		}

		$o_Persona->setEliminadoUsuarioId(Registry::getInstance()->Usuario->getId());
		if (!$o_Persona->delete(Registry::getInstance()->general['debug'])) {
			//$T_Error = 'Lo sentimos, la persona que desea eliminar no puede ser eliminado.';
			$T_Error = $o_Persona->getErrores();
		} else {
			SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[3], _('Tabla') . ' - ' . $T_Script . ' Id - ' . $o_Persona->getId());
			$T_Mensaje = _('La persona fue bloqueada con éxito.');
			// Sync
			SyncHelper::SyncPersona($o_Persona);
			// Fin Sync
		}
		
		goto defaultLabel;
		break;
	case 'Eli':
		$T_Menu['persona']['submenu']['persona-listado']['activo'] = true;
		SeguridadHelper::Pasar(20);
		if (isset($_POST['btnCancelar'])) {
			header("Location: " . WEB_ROOT . "/persona.php");
			exit();
		}

		$o_Persona = Persona_L::obtenerPorId($T_Id, true);

		if (is_null($o_Persona)) {
			$T_Error = _('Lo sentimos, la persona que desea eliminar no existe.');
		} else {
			$o_Zona = Zona_L::obtenerZonaDeUnPersonas($T_Id);
		}

		if (isset($_POST['btnEliminar']) && !is_null($o_Persona)) {
			$o_Persona->setEliminadoUsuarioId(Registry::getInstance()->Usuario->getId());
			if (!$o_Persona->Purge(Registry::getInstance()->general['debug'])) {
				//$T_Error = 'Lo sentimos, la persona que desea eliminar no puede ser eliminado.';
				$T_Error = $o_Persona->getErrores();
			} else {
				SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[6], _('Tabla') . ' - ' . $T_Script . ' Id - ' . $o_Persona->getId());
				$T_Mensaje = _('La persona fue eliminada con éxito.');
			}
		}

		$T_Eliminado = true;
		$T_Link = '_mos';
		break;
	case 'view':
		SeguridadHelper::Pasar(20);
		$o_Persona = Persona_L::obtenerPorId($T_Id, true);

		if (is_null($o_Persona))
			$o_Persona = new Persona_O();
			

		break;
	case 'L_Blo':
	case 'L_Hor':
	default:
	defaultLabel:	
		if(isset($_SESSION["EQUIPO"]))
			$o_Listado = Persona_L::obtenerTodos(0, 0, 0, "per_Eq_Id=".$_SESSION["EQUIPO"], true);
		else {
			$o_Listado=null;
		}
				

}

