<?php

/**
 * Usuario (List)
 * 
 */
class Usuario_L {

	/**
	 * Permite obtener un Usuario_O utilizando el $usuario y $clave.
	 * 
	 * Si el usuario no existe, o si la clave proporcionada no es valida,
	 * entonces la función devuelve NULL.
	 *
	 * @param string $p_Usuario
	 * @param string $p_Clave
	 * @return Usuario_O
	 */
	public static function obtenerPorLogin($p_Usuario, $p_Clave) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$row = $cnn->Select_Fila("SELECT * FROM usuario WHERE usu_Email = ? ORDER BY usu_Id", array($p_Usuario));

		$object = null;

		if (!empty($row)) {
			//if($row['clave'] == sha1($p_Clave.$row['salt'])) {
			if ($row['usu_Clave'] == sha1($p_Clave)) {
				$object = new Usuario_O();
				$object->loadArray($row);
			}
		}
		
		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	/**
	 * Obtiene un Usuario por ID.
	 * 
	 * @param integer $p_Id 
	 * @param boolean $p_IncluirEliminado FALSE por defecto
	 * @return Usuario_O
	 */
	public static function obtenerPorId($p_Id, $p_IncluirEliminado = false) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_Id = (integer) $p_Id;

		$condiciones = array();
		if ($p_IncluirEliminado == false) {
			$condiciones[] = "usu_Enable IS NULL";
		}

		$addWhere = '';
		if (count($condiciones) > 0) {
			$addWhere = ' AND ' . implode(' AND ', $condiciones);
		}

		$row = $cnn->Select_Fila("SELECT * FROM usuario WHERE usu_Id = ? {$addWhere} ORDER BY usu_Id", array($p_Id));
		
		$object = null;
		if (!empty($row)) {
			$object = new Usuario_O();
			$object->loadArray($row);
		} 
		
		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	/**
	 * Permite obtener un Usuario_O utilizando el $usuario.
	 *
	 * Si el usuario no existe, o si la clave proporcionada no es valida,
	 * entonces la función devuelve NULL.
	 *
	 * @param string $p_Usuario
	 * @return Usuario_O
	 */
	public static function obtenerPorNombreUsuario($p_Usuario, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND usu_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn->Select_Fila("SELECT * FROM usuario WHERE usu_Email = ?{$p_Id} ORDER BY usu_Id", array($p_Usuario));
		$object = null;

		if (!empty($row)) {
			$object = new Usuario_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	public static function obtenerPorDni($p_Dni, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND usu_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn->Select_Fila("SELECT * FROM usuario WHERE usu_Dni = ?{$p_Id} ORDER BY usu_Id", array($p_Dni));
		$object = null;

		if (!empty($row)) {
			$object = new Usuario_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}
        public static function obtenerPorToken($p_Token) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;


		$row = $cnn->Select_Fila("SELECT * FROM usuario WHERE usu_Reset_Token = '{$p_Token}' ORDER BY usu_Id");
		$object = null;

		if (!empty($row)) {
			$object = new Usuario_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}
        public static function obtenerPorEmail($p_Email) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;


		$row = $cnn->Select_Fila("SELECT * FROM usuario WHERE usu_Email = '{$p_Email}' ORDER BY usu_Id");
		$object = null;

		if (!empty($row)) {
			$object = new Usuario_O();
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
	 * 
	 * @param int $p_Total_Registros	Total de registros de la tabla
	 * @param int $p_Pagina_Actual		Pagina en donde estoy
	 * @param int $p_Cant_Listar		Cantidad de registros a listar
	 * @return Logs_Web_O			Listado de objetos
	 */
	public static function obtenerTodos($p_Pagina_Actual, $p_Cant_Listar, $p_Total_Registros, $p_condicion = '', $p_tablas = '') {
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
			$p_condicion = 'WHERE ' . $p_condicion. ' AND usu_Visible=1';
		}else{
			$p_condicion = 'WHERE usu_Visible=1 ';
		}

		$rows = $cnn->Select_Lista("SELECT * FROM usuario {$p_tablas} {$p_condicion} ORDER BY usu_Id DESC LIMIT " . ($p_Pagina_Actual - 1) * $p_Cant_Listar . " , {$p_Cant_Listar}");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Usuario_O();
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
	 * Obtener usuarios sin paginar
	 * 
	 * 
	 * @param string $p_condicion	Filtro de la busqueda
	 * @return Logs_Web_O			Listado de objetos
	 */
	public static function obtenerTodosSP($p_condicion = '', $p_tablas = '', $p_order = 'DESC') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;



		if ($p_condicion != '') {
			$p_condicion = 'WHERE ' . $p_condicion. ' AND usu_Visible=1 ';
		}else{
			$p_condicion = 'WHERE usu_Visible=1 ';
		}

		$rows = $cnn->Select_Lista("SELECT * FROM usuario {$p_tablas} {$p_condicion} ORDER BY usu_Id {$p_order}");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Usuario_O();
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
	 * Obtener usuarios con tokens de reset
	 * 
	 * 
	 * @param string $p_condicion	Filtro de la busqueda
	 * @return Logs_Web_O			Listado de objetos
	 */
	public static function obtenerTodosSPconTokens($p_condicion = '', $p_tablas = '', $p_order = 'DESC') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		
		
		if ($p_condicion != '') {
			$p_condicion = ' AND ' . $p_condicion;
		}

		$rows = $cnn->Select_Lista("SELECT * FROM usuario {$p_tablas} WHERE usu_Reset_Token <> ''  {$p_condicion} AND usu_Visible=1 ORDER BY usu_Id {$p_order}");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Usuario_O();
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
