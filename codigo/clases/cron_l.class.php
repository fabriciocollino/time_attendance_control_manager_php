<?php

class Cron_L {

	public static function obtenerPorId($pId) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$pId = (integer) $pId;

		$row = $cnn->Select_Fila("SELECT * FROM cron WHERE cron_Id = ? ORDER BY cron_Id", array($pId));
		$object = null;

		if (!empty($row)) {
			$object = new Cron_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	public static function obtenerPorNombre($p_Nombre) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$row = $cnn->Select_Fila("SELECT * FROM cron WHERE cron_Nombre = ? ORDER BY cron_Id", array($p_Nombre));
		$object = null;

		if (!empty($row)) {
			$object = new Cron_O();
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

		$rows = $cnn->Select_Lista("SELECT * FROM cron ORDER BY cron_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Cron_O();
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
