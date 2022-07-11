<?php
//licencias de personas
//
class Feriado_L {

	public static function obtenerPorId($pId) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$pId = (integer) $pId;

		$row = $cnn->Select_Fila("SELECT * FROM feriados WHERE fer_Id = ? ORDER BY fer_Id", array($pId));
		$object = null;

		if (!empty($row)) {
			$object = new Feriado_O();
			$object->loadArray($row);
		}

		if($row === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}
		
		return $object;
	}

	
	public static function obtenerTodasActivas() {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$rows = $cnn->Select_Lista("SELECT * FROM feriados WHERE fer_Enabled = 1 ORDER BY fer_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Feriado_O();
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
	
	public static function obtenerPorPersona($p_Persona) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		$p_Persona = (integer) $p_Persona;

		$rows = $cnn->Select_Lista("SELECT * FROM feriados WHERE fer_Per_Id = ".$p_Persona." ORDER BY fer_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Feriado_O();
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



	public static function obtenerPorDiayPersona($p_Fecha,$p_persona_id) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		$p_Fecha = (string) $p_Fecha . ' 00:00:00';
		$p_persona_id = (integer) $p_persona_id;

		$rows = $cnn->Select_Lista("SELECT * FROM feriados WHERE fer_Fecha_Inicio <= '".$p_Fecha."' AND fer_Fecha_Fin >= '".$p_Fecha."'  ORDER BY fer_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Feriado_O();
				$object->loadArray($row);
				$list[] = $object;
			}
		}else{
			$list = $object;
		}

		if($rows === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		if($list!=array()){
			foreach($list as $index => $feriado){
				switch ($feriado->getPersonaOGrupo()){
					case 'Todas las Personas'://si es para todas las personas, devuelvo la lista que encontre
						break;
					case 'grupo'://si es un grupo, me fijo si la persona pertenece al grupo
						if(is_null(Grupos_Personas_L::obtenerPorPerIdyGrupo($p_persona_id,$feriado->getGrupoId()))) {
							unset($list[$index]);
						}
						break;
					case 'persona':
						if($feriado->getPerId()!=$p_persona_id) {
							unset($list[$index]);
						}
						break;
				}
			}
		}

		return $list;
	}
	
	public static function obtenerPorGrupo($p_Grupo) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
		
		$p_Grupo = (integer) $p_Grupo;

		$rows = $cnn->Select_Lista("SELECT * FROM feriados WHERE fer_Gru_Id = ".$p_Grupo." ORDER BY fer_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Feriado_O();
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
	

	public static function obtenerTodos($p_Condicion='') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Condicion != '') {
			$p_Condicion = 'WHERE ' . $p_Condicion;
		}

		$rows = $cnn->Select_Lista("SELECT * FROM feriados {$p_Condicion} ORDER BY fer_Id");
		$object = null;
		$list = array();
		
		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Feriado_O();
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


	public static function obtenerTodosSinPasados($p_Condicion='') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_Condicion != '') {
			$p_Condicion = 'WHERE ' . $p_Condicion;
		}

		$rows = $cnn->Select_Lista("SELECT * FROM feriados {$p_Condicion} ORDER BY fer_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Feriado_O(); 
				$object->loadArray($row);
				if(!$object->checkPasado())
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

    public static function obtenerTodosEntreDosFechas($p_f_desde,$p_f_hasta) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $p_Condicion = 'WHERE fer_Fecha_Inicio >= "'.$p_f_desde.'" AND fer_Fecha_Fin <= "'.$p_f_hasta.'"';

        $rows = $cnn->Select_Lista("SELECT * FROM feriados {$p_Condicion} ORDER BY fer_Id");
        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Feriado_O();
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

}
