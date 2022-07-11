<?php

class Transaccion_L {

	public static function obtenerPorId($p_Id){

		$cnn = Registry::getInstance() -> DbConnMGR;
        $o_Cliente = Registry::getInstance()->Cliente;

		$p_Id = (integer)$p_Id;

		$row = $cnn -> Select_Fila("SELECT * FROM transacciones WHERE trans_Id = ? AND trans_Cliente=".$o_Cliente->getId()." ORDER BY trans_Id", array($p_Id));

		$object = null;
		if (!empty($row)) {
			$object = new Transaccion_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}




	public static function obtenerTodos(){

		$cnn = Registry::getInstance() -> DbConnMGR;

		$rows = $cnn -> Select_Lista("SELECT * FROM transacciones ORDER BY trans_Id DESC");

		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Transaccion_O();
				$object -> loadArray($row);
				$list[$object->getId()] = $object;
			}
		} else {
			$list = $object;
		}
		if ($rows === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $list;

	}



    public static function obtenerTodosArray(){

        $cnn = Registry::getInstance() -> DbConnMGR;

        $rows = $cnn -> Select_Lista("SELECT * FROM transacciones ORDER BY trans_Id DESC");

        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $list[$row['trans_Id']] = $row;
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