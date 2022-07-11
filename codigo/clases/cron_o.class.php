<?php

class Cron_O {

	private $_id;
	private $_nombre;
	private $_timestamp;

	public function __construct() {
		$this->_id = 0;
		$this->_nombre = ''; //varchar(50)

		$this->_timestamp = 0;
	}

	public function getId() {
		return $this->_id;
	}

	public function getNombre() {
		return $this->_nombre;
	}

	public function setNombre($p_nombre) {
		$p_nombre = trim($p_nombre);
		$this->_nombre = $p_nombre;
	}

	public function getTimestamp() {
		return $this->_timestamp;
	}

	public function setTimestamp($p_time) {
		$p_time = (integer) $p_time;
		$this->_timestamp = $p_time;
	}
	
		public function getFechaHora($p_Format = 'Y-m-d H:i:s') {
		if (!is_null($p_Format) && is_string($p_Format)) {
			if (is_int($this->_timestamp)) {
				return date($p_Format, $this->_timestamp);
			} else {
				return $this->_timestamp;
			}
		}
		return $this->_timestamp;
	}

	public function loadArray($p_Datos) {

		$this->_id = (integer) $p_Datos["cron_Id"];
		$this->_nombre = (string) $p_Datos["cron_Nombre"];
		$this->_timestamp = (integer) $p_Datos["cron_Ultimo_Timestamp"];
	}

	public function save($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;
	

		$datos = array(
		    'cron_Nombre' => $this->_nombre,
		    'cron_Ultimo_Timestamp' => $this->_timestamp
		);

		if ($this->_id == 0) {
			$resultado = $cnn->Insert('cron', $datos);
			if ($resultado !== false) {
				$this->_id = $cnn->Devolver_Insert_Id();
			}
		} else {
			$resultado = $cnn->Update('cron', $datos, "cron_Id = {$this->_id}");
		}

		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}

	public function delete($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($cnn->Delete('cron', "cron_Id = {$this->_id}")) {
			return true;
		} else {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
			return false;
		}
	}

}
