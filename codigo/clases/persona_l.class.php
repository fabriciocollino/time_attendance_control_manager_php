<?php

/**
 * persona (List)
 * 
 */
class Persona_L {
 
	/**
	 * Obtiene un persona por ID.
	 * 
	 * @param integer $p_Id
	 * @param boolean $p_IncluirEliminado TRUE por defecto
	 * @return Persona_O
	 */
	public static function obtenerPorId($p_Id, $p_IncluirEliminado = true) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_Id = (integer) $p_Id;

		$condiciones = array();
		if ($p_IncluirEliminado == false) {
			$condiciones[] = "per_Enable=1";
		}

		$addWhere = '';
		if (count($condiciones) > 0) {
			$addWhere = ' AND ' . implode(' AND ', $condiciones);
		}
		


		$row = $cnn->Select_Fila("SELECT * FROM personas WHERE per_Id = ? {$addWhere} ORDER BY per_Id", array($p_Id));
		//echo "SELECT {$campo} FROM personas WHERE per_Id = {$p_Id} {$addWhere} ORDER BY per_Id";
		$object = null;

		if (!empty($row)) {
			$object = new Persona_O();
			$object->loadArray($row);
		}

		if ($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}
	

	/**
	 * Permite obtener un Persona_O utilizando el $persona.
	 *
	 * Si el persona no existe, o si la clave proporcionada no es valida,
	 * entonces la función devuelve NULL.
	 *
	 * @param string $p_Persona
	 * @return Persona_O
	 */
	public static function obtenerPorNombrePersona($p_Persona, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND per_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn->Select_Fila("SELECT * FROM personas WHERE per_Persona = ?{$p_Id} ORDER BY per_Id", array($p_Persona));
		$object = null;

		if (!empty($row)) {
			$object = new Persona_O();
			$object->loadArray($row);
		}

		if ($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	public static function obtenerPorLegajo($p_Legajo, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND per_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn->Select_Fila("SELECT * FROM personas WHERE per_Legajo = ?{$p_Id} ORDER BY per_Id", array($p_Legajo));
		$object = null;

		if (!empty($row)) {
			$object = new Persona_O();
			$object->loadArray($row);
		}

		if ($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}
	
	public static function obtenerPorDni($p_Dni, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND per_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn->Select_Fila("SELECT * FROM personas WHERE per_Dni = ?{$p_Id} ORDER BY per_Id", array($p_Dni));
		$object = null;

		if (!empty($row)) {
			$object = new Persona_O();
			$object->loadArray($row);
		}

		if ($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	public static function obtenerPorTag($p_Tag, $p_Id = 0) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Id != 0) {
			$p_Id = ' AND per_Id <> ' . $p_Id;
		} else {
			$p_Id = '';
		}

		$row = $cnn->Select_Fila("SELECT * FROM personas WHERE per_Tag = ?{$p_Id} ORDER BY per_Id", array($p_Tag));
		$object = null;

		if (!empty($row)) {
			$object = new Persona_O();
			$object->loadArray($row);
		}

		if ($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}
	
	

	/**
	 * Permite obtener un listado de objetos Persona_O.
	 *
	 */
	public static function obtenerTodos($p_Pagina_Actual = 0, $p_Cant_Listar = 0, $p_Total_Registros = 0, $p_condicion = '', $imagen = false, $tabla = '') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		
		if ($p_Cant_Listar != 0) {
			//Para el paginado		
			if ($p_Total_Registros <= 0) {//sino hay registros que no tiere error
				$p_Pagina_Actual = 1;
			} else {
				if ($p_Pagina_Actual <= 0) {//Controla que no sea menor de 0 ya que no se puede paginar pode valores negativos ej:-1
					$p_Pagina_Actual = 1;
				} elseif ($p_Pagina_Actual >= ceil($p_Total_Registros / $p_Cant_Listar)) {//Controla que no sean valores que superen los que tenemos ej:9999
					//ceil — Redondear fracciones hacia arriba
					$p_Pagina_Actual = ceil($p_Total_Registros / $p_Cant_Listar);
				}
			}
			/* Fin paginado */
			$limite = "LIMIT " . ($p_Pagina_Actual - 1) * $p_Cant_Listar . " , {$p_Cant_Listar}";
		} else {
			$limite = '';
		}

		if ($p_condicion != '') {
			$p_condicion = 'WHERE ' . $p_condicion;
		}
		//echo "SELECT * FROM persona {$p_condicion} ORDER BY per_Id DESC {$limite}";
		
		if(Config_L::p('ordenar_personas_alfabeticamente'))
			$orden=' per_Apellido ASC ';
		else 
			$orden=' per_Id DESC ';

		//echo "SELECT {$campo} FROM persona {$p_condicion} ORDER BY {$orden} {$limite}";
		$rows = $cnn->Select_Lista("SELECT * FROM personas{$tabla} {$p_condicion} ORDER BY {$orden} {$limite}");
		$object = null;
		$list = array();

		//echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Persona_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		} else {
			$list = $object;
		}

		if ($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $list;
	}

	/**
	 *
	 * Devuelve un array con las objetos de las personas que tiene un tipo de permiso dado
	 * 
	 * @param integer $p_Id_permiso
	 * @return array Persona_O 
	 */
	public static function obtenerPorPermiso($p_Id_Permiso) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM personas WHERE per_Prm_Id = ? ORDER BY per_Id", array($p_Id_Permiso));
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Persona_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		} else {
			$list = $object;
		}

		if ($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $list;
	}

	/**
	 * @param $p_Id_Horario_Trabajo
	 * @param $p_Horario_Trabajo_Tipo
	 * @param bool $imagen
	 * @return array|null
	 */
	public static function obtenerPorHorariodeTrabajo($p_Id_Horario_Trabajo, $p_Horario_Trabajo_Tipo, $imagen = false) {/* @var $cnn mySQL */
		$p_Id_Horario_Trabajo = (integer) $p_Id_Horario_Trabajo;
		$p_Horario_Trabajo_Tipo = (integer) $p_Horario_Trabajo_Tipo;

		return Persona_L::obtenerTodos(0,0,0,'per_Hor_Id='.$p_Id_Horario_Trabajo.' AND per_Hor_Tipo='.$p_Horario_Trabajo_Tipo,$imagen);
		
	}

	/**
	 * @param $p_Id_Horario_Trabajo
	 * @param $p_Horario_Trabajo_Tipo
	 * @return null
	 */
	public static function obtenerPorHorariodeTrabajoCOUNT($p_Id_Horario_Trabajo, $p_Horario_Trabajo_Tipo) {
		$p_Id_Horario_Trabajo = (integer) $p_Id_Horario_Trabajo;
		$p_Horario_Trabajo_Tipo = (integer) $p_Horario_Trabajo_Tipo;

		$cnn = Registry::getInstance()->DbConn;

		$row = $cnn->Select_Fila("SELECT COUNT(per_Id) FROM personas WHERE per_Hor_Id = ".$p_Id_Horario_Trabajo." AND per_Hor_Tipo = ".$p_Horario_Trabajo_Tipo." ORDER BY per_Id", array());
		$object = null;

		if (!empty($row)) {
			$object=$row['COUNT(per_Id)'];
		}

		if ($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}

	/**
	 *
	 * Devuelve un array con las objetos de las personas que tiene un tipo de permiso dado
	 * 
	 * @param integer $p_Id_permiso
	 * @return array Persona_O 
	 */
	/*
	public static function obtenerPorRol($p_Id_Grupo) {
		/* @var $cnn mySQL */
		/*$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM personas WHERE per_Grupo_Id = ? ORDER BY per_Id", array($p_Id_Grupo));
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Persona_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		} else {
			$list = $object;
		}

		if ($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $list;
		 * 
		$this->obtenerPorGrupo($p_Id_Grupo);
	}
	*/
		/**
	 *
	 * Devuelve un array con las objetos de las personas que tiene un grupo
	 * 
	 * @param integer $p_Id_permiso
	 * @return array Persona_O 
	 */
	public static function obtenerPorGrupo($p_Id_Grupo) {
		/* @var $cnn mySQL */
		$a_personas = array();	
		$a_personas = Grupos_Personas_L::obtenerPersonasPorGrupo($p_Id_Grupo);
		

		

		return $a_personas;
		
	}
	
	/**
	 *
	 * Devuelve un entero con la cantidad de personas de un grupo
	 * 
	 * @param integer $p_Id_permiso
	 * @return integer cantidad 
	 */
	public static function obtenerCantidadPorGrupo($p_Id_Grupo) {
	

		return Grupos_Personas_L::obtenerCantidadPersonasPorGrupo($p_Id_Grupo);;
		
	}

	/**
	 *
	 * Devuelve un entero con la cantidad de personas de una empresa
	 *
	 * @param integer $p_Id_Empresa
	 * @return integer cantidad
	 */
	public static function obtenerCantidadPorEmpresa($p_Id_Empresa) {

		//TODO hacer esto

		//return Grupos_Personas_L::obtenerCantidadPersonasPorGrupo($p_Id_Grupo);;

	}
	
	
	/**
	 *
	 * Devuelve un array con las objetos de las personas que tiene un tipo de permiso dado
	 *  
	 * @param integer $p_Id_Grupo
	 * @return array Persona_O 
	 */
	public static function obtenerPorIdyRol($p_Id,$p_Id_Grupo,$imagen=true) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		


		$row = $cnn->Select_Fila("SELECT * FROM personas WHERE per_Grupo_Id = ".$p_Id_Grupo." AND per_Id = ".$p_Id." ORDER BY per_Id");
		$object = null;

		if (!empty($row)) {
			$object = new Persona_O();
			$object->loadArray($row);
		}

		if ($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return $object;
	}


    /**
     *
     * Devuelve una lista con las personas que tienen una fecha de modificacion mayor a la especificada
     *
     * @param integer $p_FechaMod  (timestamp)
     * @param string $p_Limit
     * @return array Persona_O
     */
    public static function obtenerPorFechaMod($p_FechaMod, $p_Limit='') {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $limit='';
        if($p_Limit!=''){
            $p_Limit = (string)$p_Limit;
            $limit = " LIMIT ". $p_Limit." ";
        }


        $rows = $cnn->Select_Lista("SELECT * FROM personas WHERE per_Fecha_Mod > FROM_UNIXTIME('".$p_FechaMod."') ORDER BY per_Fecha_Mod ASC ".$limit);
        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Persona_O();
                $object->loadArray($row);
                $list[] = $object;
            }
        } else {
            $list = $object;
        }


        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $list;
    }

    /**
     *
     * Devuelve un integer con la cantidad de personas que tienen una fecha de modificacion mayor a la especificada
     *
     * @param integer $p_FechaMod  (timestamp)
     * @param string $p_Limit
     * @return array Persona_O
     */
    public static function obtenerCOUNTPorFechaMod($p_FechaMod, $p_Limit='') {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $limit='';
        if($p_Limit!=''){
            $p_Limit = (string)$p_Limit;
            $limit = " LIMIT ". $p_Limit." ";
        }


        $row = $cnn->Select_Fila("SELECT COUNT(per_Id) as Cantidad FROM personas WHERE per_Fecha_Mod > FROM_UNIXTIME('".$p_FechaMod."') ORDER BY per_Fecha_Mod ASC ".$limit);

        if ($row === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return 	$row['Cantidad'];
    }
	

  
    public static function obtenerCantidad() {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;

		$row = $cnn -> Select_Fila("SELECT COUNT(per_Id) as Cantidad FROM personas");

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return 	$row['Cantidad'];
	}

    public static function obtenerCantidadBloqueadas() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance() -> DbConn;

        $row = $cnn -> Select_Fila("SELECT COUNT(per_Id) as Cantidad FROM personas WHERE per_Enable=0");

        if ($row === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return 	$row['Cantidad'];
    }




    public static function obtenerUltimoRegistro() {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		return $cnn->Devolver_Ultimo_Id('personas', 'per_Id');
	}



    public static function obtenerTodosArray() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM personas ORDER BY per_Legajo ASC ");

        $list = null;

        if ($rows) {
            $list = array();

            foreach ($rows as $row) {
                $list[] = $row;
            }
        }

        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }
        return $list;
    }



}
