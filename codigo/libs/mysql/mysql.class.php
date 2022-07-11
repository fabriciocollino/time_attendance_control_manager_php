<?php

/**
 * mySQL
 *
 * @copyright 09-08-2011 
 */
class mySQL {

	private $_servidor;
	private $_puerto;
	private $_usuario;
	private $_password;
	private $_base_dato;
	private $_db_link;
	private $_error_sql;
	private $_error_mysql;

	public function __construct($p_base_dato='BaseDatos', $p_usuario='root', $p_password='', $p_server='localhost', $p_puerto='3306') {
		$this->_servidor = $p_server;
		$this->_puerto = $p_puerto;
		$this->_usuario = $p_usuario;
		$this->_password = $p_password;
		$this->_base_dato = $p_base_dato;
		$this->_db_link = NULL;
		

		$this->_error_sql = NULL;
		$this->_error_mysql = NULL;
	}

	public function Conectar() {
		$this->_db_link = mysqli_connect($this->_servidor, $this->_usuario, $this->_password,'',(integer)$this->_puerto);
		if (!$this->_db_link) {
			$this->_error_sql = _("-.Error Crítico: Ha ocurrido un problema de conexión a los datos.- Error MySql - 00.00 - ");
			$this->_error_mysql = _('No pudo conectarse: ' . " Error MySql - 00.00 - ");
			return FALSE;
		} elseif (!mysqli_select_db($this->_db_link ,$this->_base_dato)) {
			$this->_error_sql = _("-.Error Crítico: No se pude acceder a la Base Datos.- Error MySql - 00.01 - ");
			$this->_error_mysql = _('No pudo conectarse:').' ' . mysqli_error($this->_db_link) . " ".("Error MySql - 00.01 - ");
			return FALSE;
		}
		mysqli_set_charset($this->_db_link, 'utf8');
		return TRUE;
	}
        
        public function ConectarSocket() {
		$this->_db_link = mysqli_connect(null, $this->_usuario, $this->_password,'',null,$this->_servidor);
		if (!$this->_db_link) {
			$this->_error_sql = ("-.Error Crítico: Ha ocurrido un problema de conexión a los datos.- Error MySql - 00.00 - ");
			$this->_error_mysql = ('No pudo conectarse: ' . " Error MySql - 00.00 - ");
			return FALSE;
		} elseif (!mysqli_select_db($this->_db_link ,$this->_base_dato)) {
			$this->_error_sql = ("-.Error Crítico: No se pude acceder a la Base Datos.- Error MySql - 00.01 - ");
			$this->_error_mysql = ('No pudo conectarse:').' ' . mysqli_error($this->_db_link) . " ".("Error MySql - 00.01 - ");
			return FALSE;
		}
		mysqli_set_charset($this->_db_link, 'utf8');
		return TRUE;
	}

	public function get_Error_Sql() {
		return $this->_error_sql;
	}

	public function get_Error_MySQL() {
		return $this->_error_mysql;
	}

	public function get_Error($p_debug = FALSE) {
		if ($p_debug) {
			return $this->_error_mysql;
		} else {
			return $this->_error_sql;
		}
	}

	/**
	 * Permite obtener un array de tipo mysqli_fetch_assoc() de una consulta dada.
	 *
	 * Si no se pudo realizar la consulta el metodo devuelve FALSE
	 * si la consulta no retorna ningun registro devuelve NULL
	 *
	 * @param string $p_sql Pasamos la sentencia Select del SQL completa. <br />
	 * Eje: "SELECT * FROM usuarios WHERE usuario = ? AND clave = ? ORDER BY id"
	 * @param array $p_valor Pasamos los valores de los campos que reemplazaran los sigunos de ? en la consulta. <br />
	 * Eje: array ('Usuario','Clave')
	 * @return array de mysqli_fetch_assoc().
	 */
	public function Select_Fila($p_sql, $p_valor = '') {
		$sql = '';
		if ($p_valor != '') {
			if (!is_array($p_valor)) {
				$this->_error_sql = _("Parametros de la clase mal pasados!. - Error MySql - 00.02 -");
				$this->_error_mysql = _("MySQL Sin Error: Problemas con los parametros de la clase! - Error MySql - 00.02 -");
				return FALSE;
			}

			$sql_partes = explode('?', $p_sql);
			$sql = $sql_partes[0];
			foreach ($p_valor as $indice => $valor) {
				$sql .= "'" . mysqli_real_escape_string($this->_db_link,$valor) . "'" . $sql_partes[$indice + 1];
			}
		} else {
			$sql = $p_sql;
		}

		$resultado = mysqli_query($this->_db_link,$sql);
		if (!$resultado) {
			$this->_error_sql = _("No es posible ejecutar la consulta!. - Error MySql - 00.03 -");
			$this->_error_mysql = _('MySQL Error: ' . mysqli_error($this->_db_link) . "<br />[{$sql}] - Error MySql - 00.03 -");
			return FALSE;
		} elseif (mysqli_num_rows($resultado) == 0) {
			$this->_error_sql = _("La consulta no devolvio registros! - Error MySql - 00.04 -");
			$this->_error_mysql = _("MySQL Sin Error: La consulta no devolvio registros! <br />[{$sql}] - Error MySql - 00.04 -");
			return NULL;
		}

		return mysqli_fetch_assoc($resultado);
	}

	/**
	 * Permite obtener un array de tipo mysqli_fetch_assoc() de una consulta dada.
	 *
	 * Si no se pudo realizar la consulta el metodo devuelve FALSE
	 * si la consulta no retorna ningun registro devuelve NULL
	 *
	 * @param string $p_sql Pasamos la sentencia Select del SQL completa. <br />
	 * Eje: "SELECT * FROM usuarios WHERE usuario = ? AND clave = ? ORDER BY id"
	 * @param array $p_valor Pasamos los valores de los campos que reemplazaran los sigunos de ? en la consulta. <br />
	 * Eje: array ('Usuario','Clave')
	 * @return array de mysqli_fetch_assoc().
	 */
	public function Select_Lista($p_sql, $p_valor = '') {
			//echo $p_sql;die();
		$sql = '';
		$devuelve = array();
		if ($p_valor != '') {
			if (!is_array($p_valor)) {
				$this->_error_sql = _("Parametros de la clase mal pasados!. - Error MySql - 00.05 -");
				$this->_error_mysql = _("MySQL Sin Error: Problemas con los parametros de la clase! - Error MySql - 00.05 -");
				return FALSE;
			}

			$sql_partes = explode('?', $p_sql);
			$sql = $sql_partes[0];
			foreach ($p_valor as $indice => $valor) {
				$sql .= "'" . mysqli_real_escape_string($this->_db_link,$valor) . "'" . $sql_partes[$indice + 1];
			}
		} else {
			$sql = $p_sql;
		}

		$resultado = mysqli_query($this->_db_link,$sql);
		if (!$resultado) {
			$this->_error_sql = _("No es posible ejecutar la consulta!. - Error MySql - 00.06 -");
			$this->_error_mysql = _('MySQL Error: ' . mysqli_error($this->_db_link) . "<br />[{$sql}] - Error MySql - 00.06 -");
			return FALSE;
		} elseif (mysqli_num_rows($resultado) == 0) {
			$this->_error_sql = _("La consulta no devolvie registros! - Error MySql - 00.07 -");
			$this->_error_mysql = _("MySQL Sin Error: La consulta no devolvie registros! <br />[{$sql}] - Error MySql - 00.07 -");
			return NULL;
		}

		while ($row = mysqli_fetch_assoc($resultado)) {
			$devuelve[] = $row;
		}

		return $devuelve;
	}

	/**
	 * Hace una inserción de datos en un Tabla
	 *
	 * Si no se pudo realizar la incerción devuelve FALSE
	 * Si se pudo realizar inseción devuelve TRUE
	 *
	 * @param string $p_tabla Nombre de la tabla
	 * @param array $p_array Array asociativo donde el indice es el campo de la tabla y el valor lo que queremos guardar. <br />
	 * Eje: array('campo1' => 'val1', 'campo2' => 'val2')
	 * @return boolean.
	 */
	public function Insert($p_tabla, $p_array) {
		$sql = '';
		$campos = '';
		$valores = '';

		if (!is_array($p_array)) {
			$this->_error_sql = _("Parametros de la clase mal pasados!. - Error MySql - 00.08 -");
			$this->_error_mysql = _("MySQL Sin Error: Problmas con los parametros de la clase! - Error MySql - 00.08 -");
			return FALSE;
		}

		foreach ($p_array as $indice => $valor) {
			$campos .= $indice . ',';
			if (is_NULL($valor)) {
				$valores .= ' NULL,';
			} else {
				$valores .= '\'' . mysqli_real_escape_string($this->_db_link,$valor) . '\',';
			}
		}

		$sql = "INSERT INTO {$p_tabla} (" . rtrim($campos, ',') . ") VALUES (" . rtrim($valores, ',') . ")";
		//echo "<pre>";echo $sql; echo "</pre>";
		//echo $sql.";";return TRUE;
		$resultado = mysqli_query($this->_db_link,$sql);
		//echo $resultado;
		if (!$resultado) {
			$this->_error_sql = _("No es posible ejecutar la insercion!. - Error MySql - 00.09 -");
			$this->_error_mysql = _('MySQL Error: ' . mysqli_error($this->_db_link) . "<br />[{$sql}] - Error MySql - 00.09 -");
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Devuelve el identificador generado en la última consulta
	 *
	 * @return integer.
	 */
	public function Devolver_Insert_Id() {
		return mysqli_insert_id($this->_db_link);
	}

	/**
	 * Devuerlve el ultimo valor Id de la tabla deseada
	 * Si ahy problemas devuelve False
	 * 
	 * @param string $p_tabla Nombre de la tabla
	 * @param string $p_Nombre_Id Nombre del campo Id de la tabla
	 * @return integer 
	 */
	public function Devolver_Ultimo_Id($p_tabla, $p_Nombre_Id) {
		$id = 0;
		$sql = "SELECT MAX({$p_Nombre_Id}) AS id FROM {$p_tabla}";
		$resultado = mysqli_query($this->_db_link,$sql);
		$row = mysqli_fetch_assoc($resultado);
		if ($row) {
			$id = trim($row['id']);
		} else {
			return FALSE;
		}
		return $id;
	}

	/**
	 * Devuerlve la cantidad de IDs
	 * Si ahy problemas devuelve False
	 *
	 * @param string $p_tabla Nombre de la tabla
	 * @param string $p_Nombre_Id Nombre del campo Id de la tabla
	 * @return integer
	 */
	public function Devolver_Count_Id($p_tabla, $p_Nombre_Id) {
		$id = 0;
		$sql = "SELECT COUNT({$p_Nombre_Id}) AS id FROM {$p_tabla}";
		$resultado = mysqli_query($this->_db_link,$sql);
		$row = mysqli_fetch_assoc($resultado);
		if ($row) {
			$id = trim($row['id']);
		} else {
			return FALSE;
		}
		return $id;
	}

	/**
	 * Devuerlve el primer valor Id de la tabla deseada
	 * Si ahy problemas devuelve False
	 * 
	 * @param string $p_tabla Nombre de la tabla
	 * @param string $p_Nombre_Id Nombre del campo Id de la tabla
	 * @return integer 
	 */
	public function Devolver_Primer_Id($p_tabla, $p_Nombre_Id) {
		$id = 0;
		$sql = "SELECT MIN({$p_Nombre_Id}) AS id FROM {$p_tabla}";
		$resultado = mysqli_query($this->_db_link,$sql);
		$row = mysqli_fetch_assoc($resultado);
		if ($row) {
			$id = trim($row['id']);
		} else {
			return FALSE;
		}
		return $id;
	}

	/**
	 * Modifica datos de un Tabla
	 *
	 * Si no se pudo realizar la incerción devuelve FALSE
	 * Si se pudo realizar inseción devuelve TRUE
	 *
	 * @param string $p_tabla Nombre de la tabla
	 * @param string $p_campos Campos y valor que toma el campo, separados por coma.<br /> Eje: cap1 = 'val1', cap2 = 'val2', cap3 = 'val3'
	 * @param string p_condicion Condicione/s que debe cumplise para que el registro se modifique.<br /> Eje: cap1 = 1 AND cap3 > 2
	 * @return boolean.
	 */
	public function Update($p_tabla, $p_array, $p_condicion) {
		$sql = '';
		$campos = '';
		$valores = '';

		if (!is_array($p_array)) {
			$this->_error_sql = _("Parametros de la clase mal pasados!. - Error MySql - 00.10 -");
			$this->_error_mysql = _("MySQL Sin Error: Problmas con los parametros de la clase! - Error MySql - 00.10 -");
			return FALSE;
		}

		foreach ($p_array as $indice => $valor) {
			if (is_NULL($valor)) {
				$campos .= $indice . ' = NULL,';
			} else {
				$campos .= $indice . ' = \'' . mysqli_real_escape_string($this->_db_link,$valor) . '\',';
			}
		}

		$sql = "UPDATE {$p_tabla} SET " . rtrim($campos, ',') . " WHERE {$p_condicion}";
		//echo "<pre>";echo $sql; echo "</pre>";
		$resultado = mysqli_query($this->_db_link,$sql);
		if (!$resultado) {
			$this->_error_sql = _("No se han podido modificar los datos. - Error MySql - 00.11 -");
			$this->_error_mysql = _('MySQL Error: ' . mysqli_error($this->_db_link) . "<br />[{$sql}] - Error MySql - 00.11 -");
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Borra registo/s de un tabla
	 *
	 * Si no se pudo realizar la incerción devuelve FALSE
	 * Si se pudo realizar inseción devuelve TRUE
	 *
	 * @param string $p_tabla Nombre de la tabla
	 * @param string p_condicion Condicione/s que debe cumplise para que el/los registros sea Borrados.<br /> Eje: cap1 = 1 AND cap3 > 2
	 * @return boolean.
	 */
	public function Delete($p_tabla, $p_condicion) {
		$sql = '';
		$sql = "DELETE FROM {$p_tabla} WHERE {$p_condicion}";

		$resultado = mysqli_query($this->_db_link,$sql);
		if (!$resultado) {
			$this->_error_sql = _("No puede Borrar - Error MySql - 00.12 -");
			$this->_error_mysql = _('MySQL Error:').' ' . mysqli_error($this->_db_link) . "<br />[{$sql}] - "._("Error MySql - 00.12 -");
			return FALSE;
		}
		return TRUE;
	}

	public function Query($p_sql) {
		$resultado = mysqli_query($this->_db_link,$p_sql);
		if (!$resultado) {
			$this->_error_sql = _("No puede Ejecutar - Error MySql - 00.13 -");
			$this->_error_mysql = _('MySQL Error:').' ' . mysqli_error($this->_db_link) . "<br />[{$p_sql}] - "._("Error MySql - 00.12 -");
			return FALSE;
		}
		return TRUE;
	}

    public function QueryWResult($p_sql) {
        return mysqli_query($this->_db_link,$p_sql);

    }
        
    public function getLink(){
        return $this->_db_link;
    }
	
	public function __destruct() {
		if ($this->_db_link) {// Si se cargo la BD acá la cierro.
			mysqli_close($this->_db_link);
		}
	}

}

