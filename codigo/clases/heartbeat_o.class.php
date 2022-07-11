<?php

/*
 * equipo (Object)
 */

class Heartbeat_O {

	private $_id;
	//datos
	private $_eq_id;
	private $_heartbeat;
	//error
	private $_errores;

	public function __construct($p_eq_id=0,$p_heartbeat=null) {
		$this->_id = 0; //int(11)
		//datos
		$this->_eq_id = 0; //int(11)
		$this->_heartbeat = null;
		//error
		$this->_errores = array();
	}

	public function getId() {
		return $this->_id;
	}

	public function getEqId() {
		return $this->_eq_id;
	}

	public function setEqId($p_Valor) {
		$p_Valor = (integer) $p_Valor;
		$this->_eq_id = $p_Valor;
	}

	public function getHeartbeat($pFormat = null) {
		if (!is_null($pFormat) && is_string($pFormat)) {
			if (is_null($this->_heartbeat)) {
				return '';
			} else {
				return date($pFormat, $this->_heartbeat);
			}
		}
		return $this->_heartbeat;
	}

	public function setHeartbeat($pFecha, $pFormat) {
		//Es necesario el DateTimeHelper
		$this->_heartbeat = DateTimeHelper::getTimestampFromFormat($pFecha, $pFormat);
		if ($this->_heartbeat === false) {
			$this->_heartbeat = null;
		}
	}

	public function getErrores() {
		return $this->_errores;
	}

	public function loadArray($p_Datos) {
		$this->_id = (integer) $p_Datos["loh_Id"];
		//datos
		$this->_eq_id = (integer) $p_Datos["loh_Eq_Id"];
		$this->_heartbeat = (is_null($p_Datos["loh_Heartbeat"])) ? null : strtotime($p_Datos["loh_Heartbeat"]);
	}

	public function save($p_Debug='Off') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

	

		$datos = array(
		    //datos
		    'loh_Eq_Id' => $this->_eq_id,
		    'loh_Heartbeat' => (is_null($this->_heartbeat)) ? null : date('Y-m-d H:i:s', $this->_heartbeat)
		);
    
		if ($this->_id == 0) {			

			$resultado = $cnn->Insert('logs_heartbeat', $datos);
      
			if ($resultado !== false) {
				$this->_id = $cnn->Devolver_Insert_Id();
			}
		} else {
			$resultado = $cnn->Update('logs_heartbeat', $datos, "loh_Id = {$this->_id}");
		}
		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}


}
