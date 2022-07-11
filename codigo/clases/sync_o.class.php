<?php

class Sync_O {

	private $_id;
	private $_eq_id;
	private $_persona_id;
	private $_tipo;
	private $_fecha_hora;
	private $_start_time;
	private $_cadena_sync;
	private $_status;
	private $_count;
	private $_answer;
	private $_errores;

	//objects
	private $_equipo_object;

	public function __construct() {
		$this->_id = 0; // int(11)
		$this->_eq_id = 0; // int(11)
		$this->_persona_id=0;
		$this->_tipo = 0; // int(11)
		$this->_fecha_hora = null; // datetime
		$this->_start_time; //timestamp
		$this->_cadena_sync = ''; // varchar(100)
		$this->_status = 0; // int(11)
		$this->_count = 0; // int(11)
		$this->_answer = null; // varchar(100)



		$this->_errores = array();
	}

	/*
	 * Controla vacio, contidad de caracteres max y min
	 */

	private function control($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero='o') {
		if ($p_valor == '') {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar")." " . strtolower($p_articulo) . " {$p_texto}.";
		} elseif (strlen($p_valor) < $p_min) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} "._("especificad")."{$p_genero} "._("es demasiado corto.");
		} elseif (strlen($p_valor) > $p_max) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} "._("especificad")."{$p_genero} "._("no debe superar los")." {$p_max} "._("caracteres.");
		}
	}

	private function seleccionado($p_valor, $p_texto) {
		if (is_int($p_valor)) {
			if ($p_valor == 0) {
				$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un")." {$p_texto}.";
			}
		} else {
			if ($p_valor == '') {
				$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un")." {$p_texto}.";
			}
		}
	}

	public function getId() {
		return $this->_id;
	}

	public function getEqId() {
		return $this->_eq_id;
	}

	public function setEqId($p_EqId) {
		$p_EqId = (integer) $p_EqId;
		$this->seleccionado($p_EqId, _('Equipo'));
		$this->_eq_id = $p_EqId;
	}
	
	public function getPersonaId() {
		return $this->_persona_id;
	}

	public function setPersonaId($p_PerId) {
		$p_PerId = (integer) $p_PerId;
		$this->seleccionado($p_PerId, _('Persona'));
		$this->_persona_id = $p_PerId;
	}

	public function getTipo() {
		return $this->_tipo;
	}

	public function setTipo($p_Tipo) {
		$p_Tipo = (integer) $p_Tipo;
		$this->seleccionado($p_Tipo, _('Tipo'));
		$this->_tipo = $p_Tipo;
	}

	public function getFechaHora($p_Format = null) {
		if (!is_null($p_Format) && is_string($p_Format)) {
			if (is_null($this->_fecha_hora)) {
				return '';
			} else {
				return date($p_Format, $this->_fecha_hora);
			}
		}
		return $this->_fecha_hora;
	}

	public function setFechaHora($p_Fecha, $p_Format) {
		//Es necesario el DateTimeHelper
		$this->_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
		if ($this->_fecha_hora === false) {
			$this->_fecha_hora = null;
		}
	}

	public function getStartTime($pFormat = null) {
		if (!is_null($pFormat) && is_string($pFormat)) {
			if (is_null($this->_start_time)) {
				return '';
			} else {
				return date($pFormat, $this->_start_time);
			}
		}
		return $this->_start_time;
	}

	public function getCadenaSync() {
		return $this->_cadena_sync;
	}

	public function setCadenaSync($p_Cadena) {
		$p_Cadena = trim($p_Cadena);
		$this->control($p_Cadena, 'Cadena Sync', 6, 100, 'La', 'a');
		$this->_cadena_sync = $p_Cadena;
	}

	public function getStatus() {

		return $this->_status;
	}

	public function setStatus($p_Status) {
		$p_Status = (integer) $p_Status;
		$this->seleccionado($p_Status, _('Status'));
		$this->_status = $p_Status;
	}

	public function getAnswer() {

		return $this->_answer;
	}

	public function setAnswer($p_Answer) {
		$p_Answer = trim($p_Answer);
		$this->control($p_Answer, _('Answer'), 1, 100);
		$this->_answer = $p_Answer;
	}


	public function getTipo_String() {
		if($this->_tipo=='1')return _("ADD USER");
		if($this->_tipo=='2')return _("UPDATE USER");
		if($this->_tipo=='3')return _("UPDATE OUTPUTS");
		if($this->_tipo=='4')return _("UPDATE LECTORES");
		if($this->_tipo=='5')return _("UPDATE PULSADORES");
		if($this->_tipo=='6')return _("UPDATE ALARMAS");
		if($this->_tipo=='7')return _("UPDATE COMMAND");

	}

	public function getEstado_String() {
		if($this->_status=='1')return _("ESPERANDO");
		if($this->_status=='2')return _("ENVIADO");
		if($this->_status=='3')return _("COMPLETADO");
		if($this->_status=='4')return _("ERROR");
	}


	public function getEquipoObject() {
		if (is_null($this->_equipo_object) && $this->_eq_id > 0) {
			$this->_equipo_object = Equipo_L::obtenerPorId($this->_eq_id);
		}
		return $this->_equipo_object;
	}

	public function getIntentos() {
		return $this->_count;
	}
	public function setIntentos($p_Intentos) {
		$p_Intentos = (integer) $p_Intentos;
		//$this->seleccionado($p_Intentos, 'Intentos');
		$this->_count = $p_Intentos;

	}


	public function esValido() {
		$this->_errores = array();

		//Validaciones del detalle
		/* 	$o_Existente = Rol_L::obtenerPorDetalle($this->_detalle);
		  if ($this->_detalle == '') {
		  $this->_errores['detalle'] = 'Debe proporcionar el detalle.';
		  } elseif (strlen($this->_detalle) < 4) {
		  $this->_errores['detalle'] = 'El detalle es demasiado corto.';
		  } elseif (strlen($this->_detalle) > 50) {
		  $this->_errores['detalle'] = 'El detalle no debe superar los 50 caracteres.';
		  } elseif (!is_null($o_Existente)) {
		  $this->_errores['detalle'] = 'El detalle \'' . $this->_detalle . '\' ya existe.';
		  } */
		//--
		//Si el array errores no tiene elementos entonces el objeto es valido.
		return count($this->_errores) == 0;
	}

	public function getErrores() {
		return $this->_errores;
	}

	public function loadArray($p_Datos) {

		$this->_id = (integer) $p_Datos["syn_Id"];
		$this->_eq_id = (integer) $p_Datos["syn_Eq_Id"];
		$this->_persona_id = (integer) $p_Datos["syn_Per_Id"];
		$this->_tipo = (integer) $p_Datos["syn_Tipo"];
		$this->_fecha_hora = strtotime($p_Datos["syn_Fecha_Hora"]);
		$this->_start_time = (is_null($p_Datos["sny_Start_Time"])) ? null : strtotime($p_Datos["sny_Start_Time"]);
		$this->_cadena_sync = (string) $p_Datos["syn_Cadena_Sync"];
		$this->_status = (integer) $p_Datos["syn_Status"];
		$this->_count = (string) $p_Datos["syn_Count"];
		$this->_answer = (string) $p_Datos["syn_Answer"];
	}

	public function save($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if (!$this->esValido()) {
			return false;
		}

		$this->_fecha_hora = time();
		$datos = array(
		    'syn_Eq_Id' => $this->_eq_id,
		    'syn_Per_Id' => $this->_persona_id,
		    'syn_Tipo' => $this->_tipo,
		    'syn_Cadena_Sync' => $this->_cadena_sync,
		    //'syn_Recibida' => (is_null($this->_recibida)) ? null : date('Y-m-d H:i:s', $this->_recibida),
		    'syn_Status' => $this->_status,
		    'syn_Count' => $this->_count,
		    'syn_Answer' => $this->_answer
		);

		if ($this->_id == 0) {
			$datos['syn_Fecha_Hora'] = date('Y-m-d H:i:s', $this->_fecha_hora);
			//$datos['syn_Start_Time'] = time();
			$resultado = $cnn->Insert('sync', $datos);
			if ($resultado !== false) {
				$this->_id = $cnn->Devolver_Insert_Id();
			}
		} else {
			$resultado = $cnn->Update('sync', $datos, "syn_Id = {$this->_id}");
		}

		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}

	public function delete($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($cnn->Delete('sync', "syn_Id = {$this->_id}")) {
			return true;
		} else {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
			return false;
		}
	}

}
