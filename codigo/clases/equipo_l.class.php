<?php /**
 * equipo (List)
 *
 */
class Equipo_L {

	/**
	 * Obtiene un equipo por ID.
	 *
	 * @param integer $p_Id
	 * @param boolean $p_IncluirEliminado FALSE por defecto
	 * @return Equipo_O
	 */
	public static function obtenerPorId($p_Id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;

		$p_Id = (integer)$p_Id;

		$row = $cnn -> Select_Fila("SELECT * FROM equipos WHERE eq_Id = ? ORDER BY eq_Id", array($p_Id));

		$object = null;
		if (!empty($row)) {
			$object = new Equipo_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}

    /**
     * Obtiene un equipo por Codigo de Verificacion (setup).
     *
     * @param integer $p_Key
     * @return Equipo_O
     */
    public static function obtenerPorCodigoDeVerificacion($p_Key) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance() -> DbConnMGR;

        $p_Key = (string)$p_Key;


        $row = $cnn -> Select_Fila("SELECT * FROM equipos WHERE eq_Password = ? ORDER BY eq_Id", array($p_Key));

        $object = null;
        if (!empty($row)) {
            $object = new Equipo_O();
            $object -> loadArray($row);
        }

        if ($row === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return $object;
    }

    /**
     * Obtiene un equipo por UUID.
     *
     * @param integer $p_Id
     * @return Equipo_O
     */
    public static function obtenerPorUUID($p_UUID) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance() -> DbConn;

        $p_UUID = (string)$p_UUID;

        $row = $cnn -> Select_Fila("SELECT * FROM equipos WHERE eq_UUID = ? ORDER BY eq_Id", array($p_UUID));

        $object = null;
        if (!empty($row)) {
            $object = new Equipo_O();
            $object -> loadArray($row);
        }

        if ($row === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return $object;
    }
  
  public static function obtenerCantidad() {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;


		$row = $cnn -> Select_Fila("SELECT COUNT(eq_Id) as Cantidad FROM equipos");

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return 	$row['Cantidad'];
	}

	public static function obtenerPorHost($p_Host, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND eq_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn -> Select_Fila("SELECT * FROM equipos WHERE eq_Host = ?{$p_Id} ORDER BY eq_Id", array($p_Host));
		$object = null;

		if (!empty($row)) {
			$object = new Equipo_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}

	public static function obtenerPorDetalle($p_Detalle, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND eq_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn -> Select_Fila("SELECT * FROM equipos WHERE eq_Detalle = ?{$p_Id} ORDER BY eq_Id", array($p_Detalle));
		$object = null;

		if (!empty($row)) {
			$object = new Equipo_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}

	public static function obtenerPorIp($p_Ip, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND eq_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn -> Select_Fila("SELECT * FROM equipos WHERE eq_Ip = ?{$p_Id} ORDER BY eq_Id", array($p_Ip));
		$object = null;

		if (!empty($row)) {
			$object = new Equipo_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}

	/**
	 * Permite obtener un listado de objetos Equipo_O.
	 *
	 */
	public static function obtenerTodos($p_Condicion = '', $p_Tablas = '') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;

		if ($p_Condicion != '') {
			$p_Condicion = 'WHERE ' . $p_Condicion;
		}

		if ($p_Tablas != '') {
			$p_Tablas = ', ' . $p_Tablas;
		}

		$rows = $cnn -> Select_Lista("SELECT * FROM equipos {$p_Tablas} {$p_Condicion} ORDER BY eq_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Equipo_O();
				$object -> loadArray($row);
				$list[] = $object;
			}
		} else {
			$list = $object;
		}

		if ($rows === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $list;
	}
	
	public static function obtenerTodosArray($p_Condicion = '', $p_Tablas = '') {
		$lista_o_equipos = self::obtenerTodos($p_Condicion, $p_Tablas);
		
		$lista_equipos=array();
		foreach ($lista_o_equipos as $equipo_o){
				$lista_equipos[]=$equipo_o->getId();
				
		}

		return $lista_equipos;
	}

	public static function loginEquipo($p_Host, $p_Clave, $p_Ip = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;

		if ($p_Host == "" || $p_Clave == "") {
			return -1;
		}
		$row = $cnn -> Select_Fila("SELECT * FROM equipos WHERE eq_Host = ? AND eq_Password = ?", array($p_Host, $p_Clave));

		

		$object = null;

		if (!empty($row)) {
			$object = new Equipo_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}


    /**
     * Mueve un equipo de la base de datos del manager a la bd del cliente
     *
     * @param Equipo_O $p_Equipo
     * @return boolean
     */

	public static function moverACliente($p_Equipo){


        $id_a_eliminar = $p_Equipo->getId();
        $p_Equipo->resetId();


        if(!$p_Equipo->save()) {  //lo guarda en la base de datos del cliente
            echo $p_Equipo->getErrores();
            return false;
        }


        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConnMGR;

        // elimino el registo del equipo
        $resultado = $cnn->Delete('equipos', "eq_Id = " . $id_a_eliminar);

        if ($resultado === false) {
            echo $cnn->get_Error($p_Debug);
            return false;
        }


        return true;



    }

	
	

}
