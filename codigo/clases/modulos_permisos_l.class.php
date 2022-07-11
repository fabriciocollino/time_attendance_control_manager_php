<?php

class Modulos_Permisos_L {

	public static function obtenerPorId($p_id){

		$cnn = Registry::getInstance() -> DbConnMGR;

		$p_id = (integer)$p_id;

		$row = $cnn -> Select_Fila("SELECT * FROM modulos_permisos WHERE mod_id = ? ORDER BY mod_id", array($p_id));

		$object = null;
		if (!empty($row)) {
			$object = new Modulos_Permisos_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}


	public static function obtenerTodos($p_Condicion = '', $p_Tablas = ''){

		$cnn = Registry::getInstance() -> DbConnMGR;

		if ($p_Condicion != '') {
			$p_Condicion = 'WHERE ' . $p_Condicion;
		}

		if ($p_Tablas != '') {
			$p_Tablas = ', ' . $p_Tablas;
		}

		$rows = $cnn -> Select_Lista("SELECT * FROM modulos_permisos {$p_Tablas} {$p_Condicion} ORDER BY mod_id");

		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Modulos_Permisos_O();
				$object -> loadArray($row);
				$list[$object->get_mod_id()] = $object;
			}
		}
        else {
			$list = $object;
		}
		if ($rows === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $list;
	}

    public static function obtenerTodosArray(){

        $cnn = Registry::getInstance() -> DbConnMGR;

        $rows = $cnn -> Select_Lista("SELECT * FROM modulos_permisos  ORDER BY mod_id");

        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $list[$row['mod_id']] = $row;
            }
        } else {
            $list = $object;
        }
        if ($rows === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return $list;
    }


    //TODO: obtener por tipo, obtener por referencia

}