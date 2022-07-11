<?php

class Notificaciones_Grupos_L {

	public static function obtenerPorId($pId) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$pId = (integer) $pId;

		$row = $cnn->Select_Fila("SELECT * FROM notificaciones_grupos WHERE ngr_Id = ? ORDER BY ngr_Id", array($pId));
		$object = null;

		if (!empty($row)) {
			$object = new Notificaciones_Grupos_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	public static function obtenerPorDetalle($p_Detalle) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$row = $cnn->Select_Fila("SELECT * FROM notificaciones_grupos WHERE ngr_Detalle = ? ORDER BY ngr_Id", array($p_Detalle));
		$object = null;

		if (!empty($row)) {
			$object = new Notificaciones_Grupos_O();
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

		$rows = $cnn->Select_Lista("SELECT * FROM notificaciones_grupos ORDER BY ngr_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Notificaciones_Grupos_O();
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
	
	
	
	public static function obtenerListaEmailsPorId($p_Id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		
		$o_grupo=Notificaciones_Grupos_L::obtenerPorId($p_Id);
		
		$rows = $cnn->Select_Lista("SELECT npe_Persona,npe_Email FROM notificaciones_personas WHERE npe_Grupo=".$o_grupo->getId()." ORDER BY npe_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				if($row['npe_Persona']!=0){
					$o_persona=Persona_L::obtenerPorId($row['npe_Persona']);
					if($o_persona->getEmail()!='')$list[]=$o_persona->getEmail();
				}else{
					$list[]=$row['npe_Email'];
				}
			}
		}else{
			$list = $object;
		}
		
		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}
	
	public static function obtenerListaPersonasPorId($p_Id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		
		$o_grupo=Notificaciones_Grupos_L::obtenerPorId($p_Id);
		
		$rows = $cnn->Select_Lista("SELECT npe_Persona,npe_Email FROM notificaciones_personas WHERE npe_Grupo=".$o_grupo->getId()." ORDER BY npe_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				if($row['npe_Persona']!=0){
					$o_persona=Persona_L::obtenerPorId($row['npe_Persona'],1);
					$list[]=$o_persona->getApellido().", ".$o_persona->getNombre();
				}else{
					$list[]=$row['npe_Email'];
				}
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
