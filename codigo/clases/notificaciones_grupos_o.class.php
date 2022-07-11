<?php

class Notificaciones_Grupos_O {

	private $_id;
	private $_detalle;
	private $_errores;

	public function __construct() {
		$this->_id = 0;
		$this->_detalle = ''; //varchar(255)

		$this->_errores = array();
	}

	public function getId() {
		return $this->_id;
	}

	public function getDetalle() {
		return $this->_detalle;
	}

	public function setDetalle($p_detalle) {
		$p_detalle = trim($p_detalle);
		$this->_detalle = $p_detalle;
	}
	
	
	public function getPersonasCount() {
		
		$a_personas=Notificaciones_Grupos_L::obtenerListaPersonasPorId($this->_id);
		return count($a_personas);
	}

	public function esValido() {
		$this->_errores = array();

		//Validaciones del detalle
		$o_Existente = Notificaciones_Grupos_L::obtenerPorDetalle($this->_detalle);
		if ($this->_detalle == '') {
			$this->_errores['detalle'] = _('Debe proporcionar el detalle.');
		} elseif (strlen($this->_detalle) < 2) {
			$this->_errores['detalle'] = _('El detalle es demasiado corto.');
		} elseif (strlen($this->_detalle) > 255) {
			$this->_errores['detalle'] = _('El detalle no debe superar los 255 caracteres.');
		} elseif (!is_null($o_Existente)) {
			$this->_errores['detalle'] = _('El detalle').' \'' . $this->_detalle . '\' '._('ya existe.');
		}
		//--
		
		//Si el array errores no tiene elementos entonces el objeto es valido.
		return count($this->_errores) == 0;
	}

	public function getErrores() {
		return $this->_errores;
	}

	public function loadArray($p_Datos) {

		$this->_id = (integer) $p_Datos["ngr_Id"];
		$this->_detalle = (string) $p_Datos["ngr_Detalle"];
	}

	public function save($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if (!$this->esValido()) {
			return false;
		}

		$datos = array(
		    'ngr_detalle' => $this->_detalle
		);

		if ($this->_id == 0) {
			$resultado = $cnn->Insert('notificaciones_grupos', $datos);
			if ($resultado !== false) {
				$this->_id = $cnn->Devolver_Insert_Id();
			}
		} else {
			$resultado = $cnn->Update('notificaciones_grupos', $datos, "ngr_Id = {$this->_id}");
		}

		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}

	public function delete($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($cnn->Delete('notificaciones_grupos', "ngr_Id = {$this->_id}")) {
			return true;
		} else {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
			return false;
		}
	}

}
