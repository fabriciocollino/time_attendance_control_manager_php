<?php

/**
 * Usuario Tipo (Object)
 *
 */
class UsuarioTipo_O {

	private $_id;
	private $_detalle;
	private $_codigo;
	private $_errores;

	public function __construct() {
		$this->_id = 0;
		$this->_detalle = '';
		$this->_codigo = 0;

		$this->_errores = array();
	}

	public function getId() {
		return $this->_id;
	}

	public function getDetalle() {
		return $this->_detalle;
	}

	public function setDetalle($p_Detalle) {
		$p_Detalle = trim($p_Detalle);
		$this->_detalle = $p_Detalle;
	}

	public function getCodigo() {
		return $this->_codigo;
	}

	public function setCodigo($p_Codigo) {
		$p_Codigo = (integer) $p_Codigo;
		$this->_codigo = $p_Codigo;
	}

	/**
	 * Devuelve TRUE/FALSE dependiendo de si el objeto es valido o no.
	 *
	 * @return boolean
	 */
	public function esValido() {
		$this->_errores = array();

		//Validaciones del detalle
		$o_Detalle_Usuaruio_Existente = UsuarioTipo_L::obtenerPorDetalle($this->_detalle);
		if ($this->_detalle == '') {
			$this->_errores['detalle'] = _('Debe proporcionar el detalle del Tipo Usuario.');
		} elseif (strlen($this->_detalle) < 4) {
			$this->_errores['detalle'] = _('El detalle del Tipo Usuario es demasiado corto.');
		} elseif (strlen($this->_detalle) > 255) {
			$this->_errores['detalle'] = _('El detalle del Tipo Usuario no debe superar los 255 caracteres.');
		} elseif (!is_null($o_Detalle_Usuaruio_Existente)) {
			$this->_errores['detalle'] = _('El Tipo Usuario').' \'' . $this->_detalle . '\' '._('ya existe.');
		}
		//--
		//Validaciones del Codigo
		$o_Codigo_Usuaruio_Existente = UsuarioTipo_L::obtenerPorCodigo($this->_codigo);
		if ($this->_detalle == '') {
			$this->_errores['codigo'] = _('Debe proporcionar un código de Tipo Usuario.');
		} elseif (!is_null($o_Codigo_Usuaruio_Existente)) {
			$this->_errores['detalle'] = _('El código').' \'' . $this->_codigo . '\' '._('ya existe.');
		}
		//--
		//Si el array errores no tiene elementos entonces el objeto es valido.
		return count($this->_errores) == 0;
	}

	public function getErrores() {
		return $this->_errores;
	}

	public function loadArray($p_Datos) {

		$this->_id = (integer) $p_Datos["tus_Id"];
		$this->_detalle = (string) $p_Datos["tus_Detalle"];
		$this->_codigo = (integer) $p_Datos["tus_Codigo"];
	}

	public function save($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if (!$this->esValido()) {
			return false;
		}

		$datos = array(
			'tus_Detalle' => $this->_detalle,
			'tus_Codigo' => $this->_codigo
		);

		if ($this->_id == 0) {
			$resultado = $cnn->Insert('usuario_tipo', $datos);
		} else {
			$resultado = $cnn->Update('usuario_tipo', $datos, "tus_Id = {$this->_id}");
		}
		
		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}

}
