<?php

class Notificaciones_Personas_L {

	public static function obtenerPorId($pId) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$pId = (integer) $pId;

		$row = $cnn->Select_Fila("SELECT * FROM notificaciones_personas WHERE npe_Id = ? ORDER BY npe_Id", array($pId));
		$object = null;

		if (!empty($row)) {
			$object = new Notificaciones_Personas_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}
	
	public static function obtenerPorPerIdyGrupo($perId,$Grupo) {
	
		$cnn = Registry::getInstance()->DbConn;

		$perId = (integer) $perId;
		$Grupo = (integer) $Grupo;

		$row = $cnn->Select_Fila("SELECT * FROM notificaciones_personas WHERE npe_Persona =".$perId." AND npe_Grupo=".$Grupo." ORDER BY npe_Id");
		
		$object = null;

		if (!empty($row)) {
			$object = new Notificaciones_Personas_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}
	
	public static function obtenerPorEmailyGrupo($email,$Grupo) {
	
		$cnn = Registry::getInstance()->DbConn;

		$email = trim((string) $email);
		$Grupo = (integer) $Grupo;

		$row = $cnn->Select_Fila("SELECT * FROM notificaciones_personas WHERE npe_Email ='".$email."' AND npe_Grupo=".$Grupo." AND npe_Persona=0 ORDER BY npe_Id");
		
		$object = null;

		if (!empty($row)) {
			$object = new Notificaciones_Personas_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	public static function obtenerTodos() {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM notificaciones_personas ORDER BY npe_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Notificaciones_Personas_O();
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
	
	public static function obtenerListaPorGrupo($grupo) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM notificaciones_personas WHERE npe_Grupo=".$grupo." ORDER BY npe_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Notificaciones_Personas_O();
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

}
