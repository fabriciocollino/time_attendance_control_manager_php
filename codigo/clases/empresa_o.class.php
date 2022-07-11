<?php

class Empresa_O {

	private $_id;
	private $_nombre;
	private $_errores;
	private $_fecha_mod;

	public function __construct() {
		$this->_id = 0;
		$this->_nombre = ''; //varchar(50)
		$this->_fecha_mod = 0;

		$this->_errores = array();
	}

	public function getId() {
		return $this->_id;
	}

	public function getDetalle() {
		return $this->_nombre;
	}

	public function setDetalle($p_nombre) {
		$p_nombre = trim($p_nombre);
		$this->_nombre = $p_nombre;
	}

	public function getNombre() {
		return $this->_nombre;
	}

	public function setNombree($p_nombre) {
		$p_nombre = trim($p_nombre);
		$this->_nombre = $p_nombre;
	}


	public function getFechaMod($p_Format = null) {
		if (!is_null($p_Format) && is_string($p_Format)) {
			if (is_int($this->_fecha_mod)) {
				if ($this->_fecha_mod == 0) return '';
				return date($p_Format, $this->_fecha_mod);
			} else {
				return $this->_fecha_mod;
			}
		}
		return $this->_fecha_mod;
	}

	public function setFechaModFormat($p_Fecha, $p_Format) {
		$_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
		if ($_fecha_hora === false) {
			$this->_errores['fecha_mod'] = 'La fecha de modificación tiene un formato incorrecto';
		} else {
			$this->_fecha_mod = $_fecha_hora;
		}
	}

	public function setFechaMod($p_Timestamp) {
		$this->_fecha_mod = (integer)$p_Timestamp;
	}


	public function esValido() {
		$this->_errores = array();

		//Validaciones del detalle
		$o_Existente = Empresa_L::obtenerPorDetalle($this->_nombre,$this->_id);
		if ($this->_nombre == '') {
			$this->_errores['detalle'] = _('Debe proporcionar el nombre.');
		} elseif (strlen($this->_nombre) < 2) {
			$this->_errores['detalle'] = _('El nombre es demasiado corto.');
		} elseif (strlen($this->_nombre) > 50) {
			$this->_errores['detalle'] = _('El nombre no debe superar los 50 caracteres.');
		} elseif (!is_null($o_Existente)) {
			$this->_errores['detalle'] = _('El nombre').' \'' . $this->_nombre . '\' '._('ya existe.');
		}
		//--
		//Si el array errores no tiene elementos entonces el objeto es valido.
		return count($this->_errores) == 0;
	}

	public function getErrores() {
		return $this->_errores;
	}

	public function loadArray($p_Datos) {

		$this->_id = (integer) $p_Datos["emp_Id"];
		$this->_nombre = (string) $p_Datos["emp_Nombre"];
		$this->_fecha_mod = (string) $p_Datos["emp_Fecha_Mod"];
	}
	
	public function getPersonasCount() {

		return Persona_L::obtenerCantidadPorEmpresa($this->_id);
	}

	public function save($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if (!$this->esValido()) {
			return false;
		}

		$this->_fecha_mod = date("Y-m-d H:i:s");

		$datos = array(
		    'emp_Nombre' => $this->_nombre,
			'emp_Fecha_Mod' => $this->_fecha_mod
		);

		if ($this->_id == 0) {
			$resultado = $cnn->Insert('empresas', $datos);
			if ($resultado !== false) {
				$this->_id = $cnn->Devolver_Insert_Id();
			}
		} else {
			$resultado = $cnn->Update('empresas', $datos, "emp_Id = {$this->_id}");
		}

		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}

	public function delete($p_Debug) {
		/* @var $cnn mySQL */ 
		$cnn = Registry::getInstance()->DbConn;

		if($this->_id==1)return false;//la empresa 1 no se puede eliminar

		if ($cnn->Delete('empresas', "emp_Id = {$this->_id}")) {
			return true;
		} else {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
			return false;
		}
	}

}
