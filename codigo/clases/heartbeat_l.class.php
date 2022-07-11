<?php /**
 * equipo (List)
 *
 */
class Heartbeat_L {

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

		$row = $cnn -> Select_Fila("SELECT * FROM logs_heartbeat WHERE loh_Id = ? ORDER BY loh_Id", array($p_Id));

		$object = null;
		if (!empty($row)) {
			$object = new Heartbeat_O();
			$object -> loadArray($row);
		}

		if ($row === false) {// devuelve el error si algo fallo con MySql
			echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
		}

		return $object;
	}

	public static function obtenerPorEquipo($p_Equipo) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;
    


		$rows = $cnn -> Select_Lista("SELECT * FROM logs_heartbeat WHERE loh_Eq_Id = ? ORDER BY loh_Id ", array($p_Equipo));
    $object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Heartbeat_O();
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

		$rows = $cnn -> Select_Lista("SELECT * FROM logs_heartbeat {$p_Tablas} {$p_Condicion} ORDER BY loh_Id");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Heartbeat_O();
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
	 * Permite obtener un listado de objetos Equipo_O.
	 *
	 */
	public static function obtenerUltimos($p_Equipo,$p_Cantidad = 10) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance() -> DbConn;
    
    $p_Cantidad=(integer)$p_Cantidad;
    $p_Equipo=(integer)$p_Equipo;
    
		$rows = $cnn -> Select_Lista("SELECT * FROM logs_heartbeat WHERE loh_Eq_Id={$p_Equipo} ORDER BY loh_Id DESC LIMIT {$p_Cantidad}");
		$object = null;
		$list = array();

		if (!is_null($rows)) {
			foreach ($rows as $row) {
				$object = new Heartbeat_O();
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
	 * Permite obtener un listado de objetos Equipo_O.
	 *
	 */
	public static function getChartData($p_Equipo, $p_Cantidad = 10) {
      
      $o_Listado = self::obtenerUltimos($p_Equipo,$p_Cantidad);

        $salida='';
        
        if(count($o_Listado)!=0){
            $o_Listado=array_reverse($o_Listado);
            for($i=0;$i<count($o_Listado)-1;$i++){

                $dif=$o_Listado[$i+1]->getHeartbeat('U')-$o_Listado[$i]->getHeartbeat('U');
                if($dif>30)
										$dif='0,null';
								if(substr($salida, -5)=='null,')
										$dif='0,'.$dif;
                $salida.= $dif.",";            
            }
            
        }else{
            for($i=0;$i<$p_Cantidad;$i++){

                $dif='null';
                $salida.=$dif.",";            
            }
        }
        
        
        
      return substr($salida, 0, -1);
	}

	

}
