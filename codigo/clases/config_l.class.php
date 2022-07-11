<?php

class Config_L {

	public static function obtenerPorId($pId) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$pId = (integer) $pId;

		$row = $cnn->Select_Fila("SELECT * FROM configuracion WHERE con_Id = ? ORDER BY con_Id", array($pId));
		$object = null;

		if (!empty($row)) {
			$object = new Config_O();
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

		$row = $cnn->Select_Fila("SELECT * FROM configuracion WHERE con_Detalle = ? ORDER BY con_Id", array($p_Detalle));
		$object = null;

		if (!empty($row)) {
			$object = new Config_O();
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

		$rows = $cnn->Select_Lista("SELECT * FROM configuracion ORDER BY con_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Config_O();
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
	
	public static function obtenerSecciones() {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM configuracion WHERE con_Seccion<>'' AND con_Visible=1 GROUP BY con_Seccion ORDER BY con_Id ");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Config_O();
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
	
	public static function obtenerTodosPorSeccion($p_seccion) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM configuracion WHERE con_Seccion='$p_seccion' ORDER BY con_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Config_O();
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
	
	public static function obtenerPorParametro($p_Parametro) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$row = $cnn->Select_Fila("SELECT * FROM configuracion WHERE con_Parametro = ? ORDER BY con_Id", array($p_Parametro));
		$object = null;

		if (!empty($row)) {
			$object = new Config_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}
	
	
	//esta funcion es para hacer la llamada mas corta.
	//ejemplo: $language = Config_L::p("lenguaje");
	public static function p($p_Parametro) {
		return self::obtenerPorParametro($p_Parametro)->getValor();
	}
        
        //esta funcion es para hacer la llamada mas corta.
	//ejemplo: $language = Config_L::p("lenguaje");
	public static function email($p_Parametro) {
		return self::obtenerPorParametro($p_Parametro)->getNotas();
	}

    //esta funcion es para hacer la llamada mas corta.
    //hace un set del valor del objeto
    public static function s($p_Parametro,$p_Value) {
        $o_config = self::obtenerPorParametro($p_Parametro);
        $o_config->setValor($p_Value);
        $o_config->save();
    }
        
        

}
