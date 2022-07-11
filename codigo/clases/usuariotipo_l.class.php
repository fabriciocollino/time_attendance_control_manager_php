<?php

/**
 * Usuario Tipo (List)
 * 
 */
class UsuarioTipo_L {

	/**
	 * Obtiene un Tipo de Usuario por ID.
	 *
	 * @param integer $p_Id
	 * @return UsuarioTipo_O
	 */
	public static function obtenerPorId($p_Id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_Id = (integer) $p_Id;



		$row = $cnn->Select_Fila("SELECT * FROM usuario_tipo WHERE tus_Id = ? ORDER BY tus_Id", array($p_Id));
		$object = null;

		if (!empty($row)) {
			$object = new UsuarioTipo_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	/**
	 * Permite obtener un UsuarioTipo_O que tiene un Detalle especifico.
	 *
	 * Si el detalle no existe entonces la función devuelve NULL.
	 *
	 * @param string $p_Detalle
	 * @return UsuarioTipo_O
	 */
	public static function obtenerPorDetalle($p_Detalle) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$row = $cnn->Select_Fila("SELECT * FROM usuario_tipo WHERE tus_Detalle = ? ORDER BY tus_Id", array($p_Detalle));
		$object = null;

		if (!empty($row)) {
			$object = new UsuarioTipo_O();
			$object->loadArray($row);
		}
		
		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	/**
	 * Permite obtener un UsuarioTipo_O que tiene un Codigo especifico.
	 *
	 * Si la codigo no existe entonces la función devuelve NULL.
	 *
	 * @param string $p_Codigo
	 * @return UsuarioTipo_O
	 */
	public static function obtenerPorCodigo($p_Codigo) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$row = $cnn->Select_Fila("SELECT * FROM usuario_tipo WHERE tus_Codigo = ? ORDER BY tus_Id", array($p_Codigo));
		$object = null;

		if (!empty($row)) {
			$object = new UsuarioTipo_O();
			$object->loadArray($row);
		}
		
		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	/**
	 * Permite obtener un listado de objetos UsuarioTipo_O.
	 *
	 */
	public static function obtenerTodos($p_condicion = '') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_condicion != '') {
			$p_condicion = 'WHERE ' . $p_condicion. ' AND tus_Visible=1';
		}else{
			$p_condicion = 'WHERE tus_Visible=1 ';
		}

		$rows = $cnn->Select_Lista("SELECT * FROM usuario_tipo {$p_condicion} ORDER BY tus_Id");
		$object = null;
		$list = array();
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new UsuarioTipo_O();
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
