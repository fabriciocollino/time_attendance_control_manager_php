<?php

class Logs_Web_L {

	public static function obtenerPorUsuarioId($pUsuId) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$pUsuId = (integer) $pUsuId;

		$rows = $cnn->Select_Lista("SELECT * FROM logs_web WHERE log_Usu_Id = ? ORDER BY log_Id", array($pUsuId));
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Logs_Web_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		} else {
			$list = $object;
		}
		
		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}
	
	/**
	 * Mostrar todo paginado
	 * 
	 * 
	 * @param int $p_Total_Registros	Total de registros de la tabla
	 * @param int $p_Pagina_Actual		Pagina en donde estoy
	 * @param int $p_Cant_Listar		Cantidad de registros a listar
	 * @return Logs_Web_O			Listado de objetos
	 */
	public static function obtenerTodos($p_Pagina_Actual, $p_Cant_Listar, $p_Total_Registros, $p_condicion = '', $p_order='DESC') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		//Para el paginado		
		if ($p_Pagina_Actual <= 1) {//Controla que no sea menor de 0 ya que no se puede paginar pode valores negativos ej:-1
			$p_Pagina_Actual = 1;
		} elseif ($p_Pagina_Actual >= ceil($p_Total_Registros / $p_Cant_Listar)) {//Controla que no sean valores que superen los que tenemos ej:9999
			//ceil — Redondear fracciones hacia arriba
			$p_Pagina_Actual = ceil($p_Total_Registros / $p_Cant_Listar);
		}
		/* Fin paginado */
		
		if ($p_condicion != '') {
			$p_condicion = 'WHERE ' . $p_condicion;
		}

		$rows = $cnn->Select_Lista("SELECT * FROM logs_web {$p_condicion} ORDER BY log_Id {$p_order} LIMIT " . ($p_Pagina_Actual - 1) * $p_Cant_Listar . " , {$p_Cant_Listar}");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Logs_Web_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		} else {
			$list = $object;
		}
		
		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}
	
	
	
	/**
	 * Mostrar todo sin paginado
	 * 
	 * 
	 * @param int $p_Total_Registros	Total de registros de la tabla
	 * @param int $p_Pagina_Actual		Pagina en donde estoy
	 * @param int $p_Cant_Listar		Cantidad de registros a listar
	 * @return Logs_Web_O			Listado de objetos
	 */
	public static function obtenerTodosSP($p_condicion = '', $p_order='DESC') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
	
		if ($p_condicion != '') {
			$p_condicion = 'WHERE ' . $p_condicion;
		}

		$rows = $cnn->Select_Lista("SELECT * FROM logs_web {$p_condicion} ORDER BY log_Id {$p_order}");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Logs_Web_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		} else {
			$list = $object;
		}
		
		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}
        
        /**
	 * Obtener Por IP y Tiempo
	 * 
	 * 
	 * @param string ip
         * @param int tiempo
         * @param string motivo
	 * @return Logs_Web_O			Listado de objetos
	 */
	public static function obtenerPorIpMotivoyTiempo($p_Ip,$p_Motivo='', $p_Tiempo=30) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
                if ($p_Motivo != '') {
			$p_Motivo = ' AND log_Accion="' . $p_Motivo.'" ';
		}

		$rows = $cnn->Select_Lista("SELECT * FROM logs_web WHERE log_Ip='{$p_Ip}' {$p_Motivo} AND log_Fecha_Hora >= DATE_SUB(NOW(),INTERVAL {$p_Tiempo} MINUTE)  ORDER BY log_Id ");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Logs_Web_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		} else {
			$list = $object;
		}
		
		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $list;
	}

}
