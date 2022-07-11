<?php

class Sync_L {

	public static function obtenerPorId($p_Id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_Id = (integer) $p_Id;

		$row = $cnn->Select_Fila("SELECT * FROM sync WHERE syn_Id = ? ORDER BY syn_Id", array($p_Id));
		$object = null;

		if (!empty($row)) {
			$object = new Sync_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	
	/**
	 * Mostrar todo paginado
	 * 
	 * @param int $p_Total_Registros	Total de registros de la tabla
	 * @param int $p_Pagina_Actual		Pagina en donde estoy
	 * @param int $p_Cant_Listar		Cantidad de registros a listar
	 * @return Sync_O			Listado de objetos
	 */
	public static function obtenerTodos($p_Pagina_Actual, $p_Cant_Listar, $p_Total_Registros, $p_condicion = '') {
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
		//echo "SELECT * FROM sync {$p_condicion} ORDER BY syn_Id DESC LIMIT " . ($p_Pagina_Actual - 1) * $p_Cant_Listar . " , {$p_Cant_Listar}";
		$rows = $cnn->Select_Lista("SELECT * FROM sync {$p_condicion} ORDER BY syn_Id DESC LIMIT " . ($p_Pagina_Actual - 1) * $p_Cant_Listar . " , {$p_Cant_Listar}");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Sync_O();
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

    public static function obtenerTodos_C($p_condicion, $p_Order = 'ASC') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;


		if ($p_condicion != '') {
			$p_condicion = 'WHERE ' . $p_condicion;
		}

		$rows = $cnn->Select_Lista("SELECT * FROM sync {$p_condicion} ORDER BY syn_Id {$p_Order}");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Sync_O();
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


	/* public static function obtenerTodos() {
		/* @var $cnn mySQL */
	/*	$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM sync ORDER BY syn_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Sync_O();
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
	}*/
	
	/**
	 * 
	 * Devuelve una lista registros que hay para sincornisar de un Equipo determinado 
	 *
	 * @param type $p_Id_Gat
	 * @return Sync_O 
	 */
	public static function RegSyncPorEquipo($p_Id_Gat, $p_Tipo = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		if ($p_Tipo != 0) {
			$p_Tipo = ' AND syn_Tipo = ' . $p_Tipo;
		} else {
			$p_Tipo = '';
		}

		$rows = $cnn->Select_Lista("SELECT * FROM sync WHERE syn_Eq_Id = ? AND syn_Status = 1{$p_Tipo} ORDER BY syn_Id ASC", array($p_Id_Gat));
		
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Sync_O();
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
	
	
	
	public static function obtenerCountRegSinSync($p_per_Id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_per_Id = (integer) $p_per_Id;

		$row = $cnn->Select_Fila("SELECT COUNT(syn_Id) FROM sync WHERE syn_Per_Id = ? AND (syn_Status=2 OR syn_Status=1)  ORDER BY syn_Id", array($p_per_Id));

		if (!empty($row)) {
				return $row['COUNT(syn_Id)'];
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
	}

}
