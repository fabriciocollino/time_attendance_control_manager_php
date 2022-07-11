<?php

class Empresa_L {

	public static function obtenerPorId($pId) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$pId = (integer) $pId;

		$row = $cnn->Select_Fila("SELECT * FROM empresas WHERE emp_Id = ? ORDER BY emp_Id", array($pId));
		$object = null;

		if (!empty($row)) {
			$object = new Empresa_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	public static function obtenerPorNombre($p_Detalle,$p_Id='') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;


		if($p_Id!=''){
			$p_Id='AND emp_Id <> '.(int)$p_Id;
		}else{
			$p_Id="";
		}

		$row = $cnn->Select_Fila("SELECT * FROM empresas WHERE emp_Nombre = ? {$p_Id} ORDER BY emp_Id", array($p_Detalle));
		$object = null;

		if (!empty($row)) {
			$object = new Empresa_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	public static function obtenerPorDetalle($p_Detalle,$p_Id='') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		

		if($p_Id!=''){
				$p_Id='AND emp_Id <> '.(int)$p_Id;
		}else{
				$p_Id="";
		}

		$row = $cnn->Select_Fila("SELECT * FROM empresas WHERE emp_Nombre = ? {$p_Id} ORDER BY emp_Id", array($p_Detalle));
		$object = null;

		if (!empty($row)) {
			$object = new Empresa_O();
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
		
		$rows = $cnn->Select_Lista("SELECT * FROM empresas ORDER BY emp_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Empresa_O();
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
        
        public static function obtenerTodosARRAY() {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		$rows = $cnn->Select_Lista("SELECT * FROM empresas ORDER BY emp_Id");
		$object = null; 
		$list = array();
		
                $a_salida=array();
                
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Empresa_O();
				$object->loadArray($row);
				$list[] = $object; 
                                $a_salida[]=$object->getId();
			}
		}else{
			$list = $object;
		}
		
		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $a_salida;
	}

}
