<?php

/**
 * Cliente (List)
 *
 *
 *
 *
 *
 * +-----------------------+--------------+------+-----+---------+----------------+
| Field                 | Type         | Null | Key | Default | Extra          |
+-----------------------+--------------+------+-----+---------+----------------+
| cli_Id                | int(11)      | NO   | PRI | NULL    | auto_increment |
| cli_Empresa           | varchar(150) | NO   |     | NULL    |                |
| cli_Nombre            | varchar(110) | NO   |     | NULL    |                |
| cli_Apellido          | varchar(110) | NO   |     | NULL    |                |
| cli_DB_User           | varchar(20)  | NO   |     | NULL    |                |
| cli_DB_Pass           | varchar(50)  | NO   |     | NULL    |                |
| cli_DB_Name           | varchar(25)  | NO   |     | NULL    |                |
| cli_DB_Host           | varchar(255) | NO   |     | NULL    |                |
| cli_DB_Port           | varchar(15)  | NO   |     | NULL    |                |
| cli_Subdominio        | varchar(150) | NO   | MUL | NULL    |                |
| cli_Suscripcion       | int(11)      | NO   |     | NULL    |                |
| cli_Enabled           | int(11)      | NO   |     | NULL    |                |
| cli_Creado            | datetime     | NO   |     | NULL    |                |
| cli_Create_Token      | varchar(100) | YES  |     | NULL    |                |
| cli_Create_Token_Date | datetime     | YES  |     | NULL    |                |
| cli_Email             | varchar(255) | NO   |     | NULL    |                |
| cli_Eliminado_Usu_Id  | int(11)      | NO   |     | NULL    |                |
| cli_Eliminado_Date    | datetime     | YES  |     | NULL    |                |
| cli_Eliminado         | tinyint(4)   | NO   |     | NULL    |                |
 *
 */
class Cliente_L {

	/**
	 * Permite obtener un Cliente_O utilizando el $cliente y $clave.
	 * 
	 * Si el cliente no existe, o si la clave proporcionada no es valida,
	 * entonces la función devuelve NULL.
	 *
	 * @param string $p_Cliente
	 * @param string $p_Clave
	 * @return Cliente_O
	 */
	public static function obtenerPorClientID($p_Cid) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConnMGR;

		$row = $cnn->Select_Fila("SELECT * FROM clientes WHERE cli_Id = ? ORDER BY cli_Id", array($p_Cid));

		$object = null;

		if (!empty($row)) {

				$object = new Cliente_O();
				$object->loadArray($row);
			
		}
		
		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	/**
	 * Obtiene un Cliente por ID.
	 * 
	 * @param integer $p_Id
	 * @return Cliente_O
	 */
	public static function obtenerPorId($p_Id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConnMGR;

		$p_Id = (integer) $p_Id;


		$row = $cnn->Select_Fila("SELECT * FROM clientes WHERE cli_Id = ? ORDER BY cli_Id", array($p_Id));
		
		$object = null;
		if (!empty($row)) {
			$object = new Cliente_O();
			$object->loadArray($row);
		} 
		
		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	/**
	 * Permite obtener un Cliente_O utilizando el $cliente.
	 *
	 * Si el cliente no existe, o si la clave proporcionada no es valida,
	 * entonces la función devuelve NULL.
	 *
	 * @param string $p_Cliente
	 * @return Cliente_O
	 */
	public static function obtenerPorNombreCliente($p_Cliente, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConnMGR;

		if ($p_Id != 0) {
			$p_Id = ' AND cli_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn->Select_Fila("SELECT * FROM clientes WHERE cli_Cliente = ?{$p_Id} ORDER BY cli_Id", array($p_Cliente));
		$object = null;

		if (!empty($row)) {
			$object = new Cliente_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	public static function obtenerPorDni($p_Dni, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConnMGR;

		if ($p_Id != 0) {
			$p_Id = ' AND cli_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn->Select_Fila("SELECT * FROM clientes WHERE cli_Dni = ?{$p_Id} ORDER BY cli_Id", array($p_Dni));
		$object = null;

		if (!empty($row)) {
			$object = new Cliente_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}


	public static function obtenerPorSubdominio($p_Subdominio) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConnMGR;

		$row = $cnn->Select_Fila("SELECT * FROM clientes WHERE cli_Subdominio = ? ORDER BY cli_Id", array($p_Subdominio));
		$object = null;

		if (!empty($row)) {
			$object = new Cliente_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}



    public static function obtenerTodosEnabled() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM clientes WHERE cli_Enabled=1 ORDER BY cli_Id");
        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Cliente_O();
                $object->loadArray($row);
                $list[$object->getId()] = $object;
            }
        }else{
            $list = null;
        }

        if($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $list;
    }


    public static function obtenerTodos() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM clientes ORDER BY cli_Id");

        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Cliente_O();
                $object->loadArray($row);
                $list[$object->getId()] = $object;
            }
        }else{
            $list = null;
        }

        if($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $list;
    }

    public static function obtenerTodosArray() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM clientes ORDER BY cli_Id");

        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $list[$row['cli_Id']] = $row;
            }
        }else{
            $list = null;
        }

        if($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $list;
    }



}
