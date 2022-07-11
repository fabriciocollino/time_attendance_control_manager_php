<?php

class Tarjetas_L {

	public static function obtenerPorId($p_Id){

		$cnn = Registry::getInstance() -> DbConnMGR;

		$p_Id = (integer)$p_Id;

		$row = $cnn -> Select_Fila("SELECT * FROM tarjetas WHERE tar_Id = ? ORDER BY tar_Id", array($p_Id));

		$object = null;
		if (!empty($row)) {
			$object = new Tarjetas_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}

    public static function obtenerPorToken($p_Token){

        $cnn = Registry::getInstance() -> DbConnMGR;

        $p_Token = (string)$p_Token;

        $row = $cnn -> Select_Fila("SELECT * FROM tarjetas WHERE tar_CC_Token = ? ORDER BY tar_Id", array($p_Token));

        $object = null;
        if (!empty($row)) {
            $object = new Tarjetas_O();
            $object -> loadArray($row);
        }

        if ($row === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return $object;
    }

    public static function obtenerDefaultCliente($p_Cliente_Id){

        $cnn = Registry::getInstance() -> DbConnMGR;

        $p_Cliente_Id = (integer)$p_Cliente_Id;

        $row = $cnn -> Select_Fila("SELECT * FROM tarjetas WHERE tar_Cliente = ? AND tar_Default=1 ORDER BY tar_Id", array($p_Cliente_Id));

        $object = null;
        if (!empty($row)) {
            $object = new Tarjetas_O();
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

		$rows = $cnn -> Select_Lista("SELECT * FROM trajetas {$p_Tablas} {$p_Condicion} ORDER BY tar_Id");

		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Tarjetas_O();
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




}