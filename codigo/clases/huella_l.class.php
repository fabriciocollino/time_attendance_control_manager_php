<?php

/**
 * persona (List)
 * 
 */
class Huella_L {
		
		public static function obtenerPorId($p_Id){

		$cnn = Registry::getInstance() -> DbConn;

		$p_Id = (integer)$p_Id;

		$row = $cnn -> Select_Fila("SELECT * ,LENGTH(hue_Datos) FROM huellas WHERE hue_Id = ? ORDER BY hue_Id", array($p_Id));

		$object = null;
		if (!empty($row)) {
			$object = new Huella_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}


	public static function obtenerTodos($p_Condicion = '', $datos = false){

		$cnn = Registry::getInstance() -> DbConn;

		if ($p_Condicion != '') {
			$p_Condicion = 'WHERE ' . $p_Condicion;
		}

		
		if($datos){
				$campo = '*';
			}else{
				$campo = 'hue_Id, hue_Per_Id, hue_Dedo, hue_Enabled, hue_Eliminada, hue_Fecha_Mod';
		}

		$rows = $cnn -> Select_Lista("SELECT {$campo} ,LENGTH(hue_Datos) FROM huellas {$p_Condicion} ORDER BY hue_Id");

		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Huella_O();
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

    /**
     *
     * Devuelve una lista con las huellas que tienen una fecha de modificacion mayor a la especificada
     *
     * @param string $p_FechaMod
     * @param string $p_Limit
     * @param bool $solo_con_datos
     * @return array Persona_O
     */
    public static function obtenerPorFechaMod($p_FechaMod, $p_Limit='', $solo_con_datos=false){

        $cnn = Registry::getInstance() -> DbConn;


        $limit='';
        if($p_Limit!=''){
            $p_Limit = (string)$p_Limit;
            $limit = " LIMIT ". $p_Limit." ";
        }

        if($solo_con_datos!=''){
            $solo_con_datos = " AND LENGTH(hue_Datos)>0 ";
        }


        $rows = $cnn -> Select_Lista("SELECT * ,LENGTH(hue_Datos) FROM huellas WHERE hue_Fecha_Mod > FROM_UNIXTIME('".$p_FechaMod."') ". $solo_con_datos ." ORDER BY hue_Fecha_Mod ASC ".$limit);

        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Huella_O();
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

    /**
     *
     * Devuelve un integer con la cantidad de huellas que tienen una fecha de modificacion mayor a la especificada
     *
     * @param string $p_FechaMod
     * @param string $p_Limit
     * @return array Persona_O
     */
    public static function obtenerCOUNTPorFechaMod($p_FechaMod, $p_Limit=''){

        $cnn = Registry::getInstance() -> DbConn;


        $limit='';
        if($p_Limit!=''){
            $p_Limit = (string)$p_Limit;
            $limit = " LIMIT ". $p_Limit." ";
        }

        $row= $cnn -> Select_Fila("SELECT COUNT(hue_Id) as Cantidad FROM huellas WHERE hue_Fecha_Mod > FROM_UNIXTIME('".$p_FechaMod."') ORDER BY hue_Fecha_Mod ASC ".$limit);

        if ($row === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return 	$row['Cantidad'];

    }

	
	
	public static function obtenerPorPersona($p_Per_Id, $datos = false, $incluir_eliminadas = false){

		$cnn = Registry::getInstance() -> DbConn;

		if($datos){
				$campo = '*';
			}else{
				$campo = 'hue_Id, hue_Per_Id, hue_Dedo, hue_Enabled, hue_Eliminada, hue_Fecha_Mod';
		}

        if($incluir_eliminadas){
            $incluir_eliminadas = ' ';
        }else{
            $incluir_eliminadas = ' AND hue_Eliminada = 0 ';
        }

		$rows = $cnn -> Select_Lista("SELECT {$campo} ,LENGTH(hue_Datos) FROM huellas WHERE hue_Per_Id=".$p_Per_Id."  " . $incluir_eliminadas . "ORDER BY hue_Id");

		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Huella_O();
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
	
	public static function obtenerPorPersonayDedo($p_Id,$p_Dedo){

		$cnn = Registry::getInstance() -> DbConn;

		$p_Id = (integer)$p_Id;

		$row = $cnn -> Select_Fila("SELECT * ,LENGTH(hue_Datos) FROM huellas WHERE hue_Per_Id = ".$p_Id."  AND hue_Dedo = ".$p_Dedo." AND hue_Eliminada=0 ORDER BY hue_Id");

		$object = null;
		if (!empty($row)) {
			$object = new Huella_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}

    public static function obtenerTodosArray() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM huellas ORDER BY hue_Id");

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

