<?php
//licencias de personas
//
class Licencias_L {

	public static function obtenerPorId($pId) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$pId = (integer) $pId;

		$row = $cnn->Select_Fila("SELECT * FROM licencias WHERE lic_Id = ? ORDER BY lic_Id", array($pId));
		$object = null;

		if (!empty($row)) {
			$object = new Licencias_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	
	public static function obtenerTodasActivas() {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM licencias WHERE lic_Enabled = 1 ORDER BY lic_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Licencias_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		}else{
			$list = $object;
		}

		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}
	
	public static function obtenerPorPersona($p_Persona) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		$p_Persona = (integer) $p_Persona;

		$rows = $cnn->Select_Lista("SELECT * FROM licencias WHERE lic_Per_Id = ".$p_Persona." ORDER BY lic_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Licencias_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		}else{
			$list = $object;
		}

		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}
	
	public static function obtenerPorGrupo($p_Grupo) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		$p_Grupo = (integer) $p_Grupo;

		$rows = $cnn->Select_Lista("SELECT * FROM licencias WHERE lic_Gru_Id = ".$p_Grupo." ORDER BY lic_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Licencias_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		}else{
			$list = $object;
		}

		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}




	public static function obtenerPorDiaCompletoyPersona($p_Fecha,$p_persona_id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_Fecha = (string) $p_Fecha . ' 00:00:00';

		$rows = $cnn->Select_Lista("SELECT * FROM licencias WHERE (lic_Tipo=".LICENCIA_DIA_COMPLETO." OR lic_Tipo=".LICENCIA_PERSONALIZADA.") AND lic_Fecha_Inicio <= '".$p_Fecha."' AND lic_Fecha_Fin >= '".$p_Fecha."'  ORDER BY lic_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Licencias_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		}else{
			$list = $object;
		}

		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		if($list!=array()){
			foreach($list as $index => $licencia){
				switch ($licencia->getPersonaOGrupo()){
					case 'grupo'://si es un grupo, me fijo si la persona pertenece al grupo
						if(is_null(Grupos_Personas_L::obtenerPorPerIdyGrupo($p_persona_id,$licencia->getGrupoId()))) {
							unset($list[$index]);
						}
						break;
					case 'persona':
						if($licencia->getPerId()!=$p_persona_id) {
							unset($list[$index]);
						}
						break;
				}
			}
		}

		return $list;
	}




	public static function obtenerPorLlegadaTardeyPersona($p_Fecha_Inicio,$p_persona_id,$p_Fecha) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_Fecha = (string) $p_Fecha;
		$p_Fecha_Inicio = (string) $p_Fecha_Inicio;

		$fecha_sql= new DateTime($p_Fecha_Inicio);
		$fecha_sql = $fecha_sql->format('Y-m-d 00:00:00');

		$rows = $cnn->Select_Lista("SELECT * FROM licencias WHERE (lic_Tipo=".LICENCIA_LLEGADA_TARDE." OR lic_Tipo=".LICENCIA_PERSONALIZADA." OR lic_Tipo=".LICENCIA_DIA_COMPLETO.") AND lic_Fecha_Inicio <= '".$fecha_sql."' AND lic_Fecha_Fin >= '".$fecha_sql."'  ORDER BY lic_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Licencias_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		}else{
			$list = $object;
		}

		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}


		if($list!=array()){
			foreach($list as $index => $licencia){
				switch ($licencia->getPersonaOGrupo()){
					case 'grupo'://si es un grupo, me fijo si la persona pertenece al grupo
						if(is_null(Grupos_Personas_L::obtenerPorPerIdyGrupo($p_persona_id,$licencia->getGrupoId()))) {
							unset($list[$index]);
						}
						break;
					case 'persona':
						if($licencia->getPerId()!=$p_persona_id) {
							unset($list[$index]);
						}
						break;
				}
			}
			foreach($list as $index => $licencia){
				if($licencia->getTipo()==LICENCIA_LLEGADA_TARDE) {//solo me fijo para las llegadas tarde, si es personalizada o dia completo, y esta en el rango de tiempo, esta OK
					if ($licencia->checkDuracionValidaLlegadaTarde($p_Fecha_Inicio, $p_Fecha) == false)
						unset($list[$index]);
				}
			}
		}

		return $list;
	}



	public static function obtenerPorSalidaTempranoyPersona($p_Fecha_Fin,$p_persona_id,$p_Fecha) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_Fecha = (string) $p_Fecha;
		$p_Fecha_Fin = (string) $p_Fecha_Fin;

		$fecha_sql= new DateTime($p_Fecha_Fin);
		$fecha_sql = $fecha_sql->format('Y-m-d 00:00:00');

		$rows = $cnn->Select_Lista("SELECT * FROM licencias WHERE (lic_Tipo=".LICENCIA_SALIDA_TEMPRANO." OR lic_Tipo=".LICENCIA_PERSONALIZADA." OR lic_Tipo=".LICENCIA_DIA_COMPLETO.") AND lic_Fecha_Inicio <= '".$fecha_sql."' AND lic_Fecha_Fin >= '".$fecha_sql."'  ORDER BY lic_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Licencias_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		}else{
			$list = $object;
		}

		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}


		if($list!=array()){
			foreach($list as $index => $licencia){
				switch ($licencia->getPersonaOGrupo()){
					case 'grupo'://si es un grupo, me fijo si la persona pertenece al grupo
						if(is_null(Grupos_Personas_L::obtenerPorPerIdyGrupo($p_persona_id,$licencia->getGrupoId()))) {
							unset($list[$index]);
						}
						break;
					case 'persona':
						if($licencia->getPerId()!=$p_persona_id) {
							unset($list[$index]);
						}
						break;
				}
			}
			foreach($list as $index => $licencia){
				if($licencia->getTipo()==LICENCIA_SALIDA_TEMPRANO) {//solo me fijo para las salidas temprano, si es personalizada o dia completo, y esta en el rango de tiempo, esta OK
					if ($licencia->checkDuracionValidaSalidaTemprano($p_Fecha_Fin, $p_Fecha) == false)
						unset($list[$index]);
				}
			}
		}

		return $list;
	}
	

	public static function obtenerTodos($p_Condicion='') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Condicion != '') {
			$p_Condicion = 'WHERE ' . $p_Condicion;
		}

		$rows = $cnn->Select_Lista("SELECT * FROM licencias {$p_Condicion} ORDER BY lic_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Licencias_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		}else{
			$list = $object;
		}
		
		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}

	public static function obtenerTodosSinPasadas($p_Condicion='') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Condicion != '') {
			$p_Condicion = 'WHERE ' . $p_Condicion;
		}

		$rows = $cnn->Select_Lista("SELECT * FROM licencias {$p_Condicion} ORDER BY lic_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Licencias_O();
				$object->loadArray($row);
				if(!$object->checkPasada())
					$list[] = $object;
			}
		}else{
			$list = $object;
		}

		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $list;
	}

}
