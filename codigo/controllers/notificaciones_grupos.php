<?php



SeguridadHelper::Pasar(50);

$T_Titulo = _('Grupos');
$T_Titulo_Singular = _('Grupo');
$T_Titulo_Pre = _('el');
$T_Script = 'not_grupos';
$Item_Name="notificaciones_grupos";
$T_Link = '';
$T_Mensaje = '';

$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 0;

switch ($T_Tipo) {
	case 'add':
			SeguridadHelper::Pasar(50);
		$o_Grupo = new Notificaciones_Grupos_O();

			
		$o_Grupo->setDetalle(isset($_REQUEST['detalle']) ? (string) $_REQUEST['detalle'] : 0);

		if (!$o_Grupo->save(Registry::getInstance()->general['debug'])) {
				$T_Error = $o_Grupo->getErrores();	
		}else{
			$T_Mensaje = _('El Grupo fue guardado con éxito');
			goto defaultlabel;
		}
			
			
		
		break;
	case 'view':	
			SeguridadHelper::Pasar(50);
				$o_Grupo = Notificaciones_Grupos_L::obtenerPorId($T_Id);
			
				if (is_null($o_Grupo)){
					$o_Grupo = new Notificaciones_Grupos_O();
				}else{

				}
		break;
	case 'edit':
			SeguridadHelper::Pasar(50);
		$o_Grupo = Notificaciones_Grupos_L::obtenerPorId($T_Id);
			
		if (is_null($o_Grupo)){
			$o_Grupo = new Notificaciones_Grupos_O();
		}else{



					$o_Grupo->setDetalle(isset($_REQUEST['detalle']) ? (string) $_REQUEST['detalle'] : 0);

					if (!$o_Grupo->save(Registry::getInstance()->general['debug'])) {
							$T_Error = $o_Grupo->getErrores();	
					}else{
						$T_Mensaje = _('El Grupo fue modificado con éxito');
					} 


				$T_Modificar = true;
		}
		
		goto defaultlabel;
		break;
	case 'personas':
			SeguridadHelper::Pasar(50);
		$o_Grupo = Notificaciones_Grupos_L::obtenerPorId($T_Id);



		$a_Personas = HtmlHelper::array2htmloptions(Persona_L::obtenerTodos(),null,false,true,'Persona-NOTIFICACIONES');
		
		$a_PersonasGrupo = HtmlHelper::array2htmloptions(Notificaciones_Personas_L::obtenerListaPorGrupo($T_Id),null,false,true,'Not_Persona');
		
		$T_Add = true;
		break;
		
	case 'insert':
			SeguridadHelper::Pasar(50);
		$o_Grupo = Notificaciones_Grupos_L::obtenerPorId($T_Id);
		
		$o_Persona = new Notificaciones_Personas_O();
		
		$o_personaCheck=Notificaciones_Personas_L::obtenerPorPerIDyGrupo(isset($_REQUEST['persona']) ? (integer) $_REQUEST['persona'] : 0,$T_Id);
		if($o_personaCheck!=null)die("error_persona_ya_existe");

		$o_Persona->setPersona(isset($_REQUEST['persona']) ? (integer) $_REQUEST['persona'] : 0);
		$o_Persona->setGrupo($T_Id);
		
		$o_Persona->save('Off');
		
		$a_PersonasGrupo = HtmlHelper::array2htmloptions(Notificaciones_Personas_L::obtenerListaPorGrupo($T_Id),null,false,true,'Not_Persona');
		echo $a_PersonasGrupo;
		
		$T_Add = true;
		$T_Link = '_add';
		die();
		break;
	case 'insertemail':
		SeguridadHelper::Pasar(50);
		$o_Persona = new Notificaciones_Personas_O();
		
		$o_personaCheck=Notificaciones_Personas_L::obtenerPorEmailyGrupo(isset($_REQUEST['email']) ? (string) $_REQUEST['email'] : '',$T_Id);
		if($o_personaCheck!=null)die("error_email_ya_existe");

		$o_Persona->setPersona(0);
		$o_Persona->setGrupo($T_Id);
		$o_Persona->setEmail(isset($_REQUEST['email']) ? (string) $_REQUEST['email'] : '');
		
		$o_Persona->save('Off');
		
		$a_PersonasGrupo = HtmlHelper::array2htmloptions(Notificaciones_Personas_L::obtenerListaPorGrupo($T_Id),null,false,true,'Not_Persona');
		echo $a_PersonasGrupo;
		
		$T_Add = true;
		$T_Link = '_add';
		die();
		break;		
	case 'remove':
SeguridadHelper::Pasar(50);
		if(isset($_REQUEST['GpersonaID'])){
			$o_Persona = Notificaciones_Personas_L::obtenerPorId(isset($_REQUEST['GpersonaID']) ? (integer) $_REQUEST['GpersonaID'] : 0);
			$o_Persona->delete('Off');
		}
		$a_PersonasGrupo = HtmlHelper::array2htmloptions(Notificaciones_Personas_L::obtenerListaPorGrupo($T_Id),null,false,true,'Not_Persona');
		echo $a_PersonasGrupo;
		
		$T_Add = true;
		die();
		break;
	case 'delete':
			SeguridadHelper::Pasar(50);
		$o_Grupo = Notificaciones_Grupos_L::obtenerPorId($T_Id);
		
		$a_notificaciones=Notificaciones_L::obtenerPorGrupo($T_Id);
		if($a_notificaciones==null){					
			if (!$o_Grupo->delete(Registry::getInstance()->general['debug'])) {
				$T_Error = $o_Notificacion->getErrores();
			} else {
				$ref_url="";
				$T_Eliminado = true;
				$T_Mensaje = _('El Grupo ha sido eliminado con éxito.'); goto defaultlabel;
			}
		}else{
			$T_Eliminado = false;
			$T_Error = _('El Grupo no se puede eliminar, porque está asignado a una o más notificaciones.'); goto defaultlabel;
		}
		$ref_url="";
		
		break;
	default :
	defaultlabel:
SeguridadHelper::Pasar(50);
		$o_Listado = Notificaciones_Grupos_L::obtenerTodos();
		$T_Link = '';
}

