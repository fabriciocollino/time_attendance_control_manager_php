<?php

class Logs_Equipo_O {

	private $_id;
	private $_eq_id;
	private $_lector;
	private $_pulsador;
	private $_fecha_hora;
	private $_per_id;
	private $_accion;
    private $_dedo;
	//objects
	private $_equipo_object;
	private $_persona_object;
	private $_errores;

	public function __construct($p_eq_id = 0, $p_fecha_hora = '', $p_per_id = 0, $p_accion = '', $p_lector = 0, $p_pulsador=0, $p_dedo=0) {
		$this->_id = 0;
		$this->_eq_id = $p_eq_id;
		$this->_fecha_hora = ($p_fecha_hora == '') ? null : $p_fecha_hora;
		$this->_per_id = $p_per_id;
		$this->_accion = $p_accion;
		$this->_lector = $p_lector;
		$this->_pulsador = $p_pulsador;
        $this->_dedo = $p_dedo;

		$this->_equipo_object = null;
		$this->_persona_object = null;

		$this->_errores = array();
	}

	private function Control($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero='o') {
		if ($p_valor == '') {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar") . " " . strtolower($p_articulo) . " {$p_texto}.";
		} elseif (strlen($p_valor) < $p_min) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("es demasiado corto.");
		} elseif (strlen($p_valor) > $p_max) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("no debe superar los") . " {$p_max} " . _("caracteres.");
		}
		return $p_valor;
	}

	private function Seleccionado($p_valor, $p_texto) {
		if (is_int($p_valor)) {
			if ($p_valor == 0) {
				$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un") . " {$p_texto}.";
			}
		} else {
			if ($p_valor == '') {
				$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un") . " {$p_texto}.";
			}
		}
		return $p_valor;
	}

	public function Fecha($p_Fecha, $p_Format, $p_texto) {
		$_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
		if ($_fecha_hora === false) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = _("La") . " {$p_texto} " . _("es incorrecta.");
			return $p_Fecha;
		}
		return $_fecha_hora;
	}

	public function getId() {
		return $this->_id;
	}

	public function getEqId() {
		return $this->_eq_id;
	}

	public function setEqId($p_EqId) {
		$p_EqId = (integer) $p_EqId;
		$this->_eq_id = $this->Seleccionado($p_EqId, 'Equipo');
	}

	public function getFechaHora($p_Format = null) {
		if (!is_null($p_Format) && is_string($p_Format)) {
			if (is_int($this->_fecha_hora)) {
				return date($p_Format, $this->_fecha_hora);
			} else {
				return $this->_fecha_hora;
			}
		}
		return $this->_fecha_hora;
	}

	public function setFechaHora($p_Fecha, $p_Format) {
		$this->_fecha_hora = date('Y-m-d H:i:s', $this->Fecha($p_Fecha, $p_Format, _('Fecha Inicio')));

	}

	public function getPerId() {
		return $this->_per_id;
	}

	public function setPerId($p_PerId) {
		$p_PerId = (integer) $p_PerId;
		$this->_per_id = $this->Seleccionado($p_PerId, _('Persona'));
	}

	public function getAccion() {
		return $this->_accion;
	}

	public function setAccion($p_Accion) {
		$p_Accion = trim($p_Accion);
		$this->_accion = $this->Control($p_Accion, _('Accion'), 0, 100);
	}

	public function getLector() {
		return $this->_lector;
	}

	public function setLector($p_Lector) {
		$p_Lector = (integer) $p_Lector;
		$this->_lector = $this->Seleccionado($p_Lector, _('Lector'));
	}

	public function getPulsador() {
		return $this->_pulsador;
	}

	public function setPulsador($p_Pulsador) {
		$p_Pulsador = (integer) $p_Pulsador;
		$this->_pulsador = $this->Seleccionado($p_Pulsador, _('Pulsador'));
	}

    public function getDedo() {
        return $this->_dedo;
    }

    public function getDedo_S() {
        switch ($this->_dedo){
            case LEFT_THUMB: return "Pulgar Izquierdo";
            case LEFT_INDEX: return "Índice Izquierdo";
            case LEFT_MIDDLE: return "Medio Izquierdo";
            case LEFT_RING: return "Anular Izquierdo";
            case LEFT_LITTLE: return "Meñique Izquierdo";
            case RIGHT_THUMB: return "Pulgar Derecho";
            case RIGHT_INDEX: return "Índice Derecho";
            case RIGHT_MIDDLE: return "Medio Derecho";
            case RIGHT_RING: return "Anular Derecho";
            case RIGHT_LITTLE: return "Meñique Derecho";
        }
        return "";
    }

    public function setDedo($p_Dedo) {
        $p_Dedo = (integer) $p_Dedo;
        $this->_dedo = $this->Seleccionado($p_Dedo, _('Dedo'));
    }

	public function getEquipoObject() {
		if (is_null($this->_equipo_object) && $this->_eq_id > 0) {
			$this->_equipo_object = Equipo_L::obtenerPorId($this->_eq_id);
		}
		return $this->_equipo_object;
	}

	public function getPersonaObject() {
		if (is_null($this->_persona_object) && $this->_per_id > 0) {
			$this->_persona_object = Persona_L::obtenerPorId($this->_per_id, true);
		}
		return $this->_persona_object;
	}

	public function esValido() {
		//--
		//Si el array errores no tiene elementos entonces el objeto es valido.
		return count($this->_errores) == 0;
	}

	public function getErrores() {
		return $this->_errores;
	}

	public function loadArray($p_Datos) {

		$this->_id = (integer) $p_Datos["leq_Id"];
		$this->_eq_id = (integer) $p_Datos["leq_Eq_Id"];
		$this->_fecha_hora = (is_null($p_Datos["leq_Fecha_Hora"])) ? null : strtotime($p_Datos["leq_Fecha_Hora"]);
		$this->_per_id = (integer) $p_Datos["leq_Per_Id"];
		$this->_accion = (string) $p_Datos["leq_Accion"];
		$this->_lector = (integer) $p_Datos["leq_Lector"];
		$this->_pulsador = (integer) $p_Datos["leq_Pulsador"];
        $this->_dedo = (integer) $p_Datos["leq_Dedo"];
	}

    public function loadArrayV2($p_Datos) {

        $this->_id = (integer) $p_Datos["leq_Id"];
        $this->_eq_id = (integer) $p_Datos["leq_Eq_Id"];
        $this->_fecha_hora = $p_Datos["leq_Fecha_Hora"];
        $this->_per_id = (integer) $p_Datos["leq_Per_Id"];
        $this->_accion = (string) $p_Datos["leq_Accion"];
        $this->_lector = (integer) $p_Datos["leq_Lector"];
        $this->_pulsador = (integer) $p_Datos["leq_Pulsador"];
        $this->_dedo = (integer) $p_Datos["leq_Dedo"];
    }

	public function save($p_Debug = 'Off') {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if (!$this->esValido()) {
			return false;
		}

		$datos = array(
		    'leq_Eq_Id' => $this->_eq_id,
		    'leq_Fecha_Hora' => $this->_fecha_hora,
		    'leq_Per_Id' => $this->_per_id,
		    'leq_Accion' => $this->_accion,
		    'leq_Lector' => $this->_lector,
		    'leq_Pulsador' => $this->_pulsador,
            'leq_Dedo' => $this->_dedo
		);

		if ($this->_id == 0) {
			$resultado = $cnn->Insert('logs_equipo', $datos);
			if ($resultado !== false) {
				$this->_id = $cnn->Devolver_Insert_Id();
			}
		} else {
			$resultado = $cnn->Update('logs_equipo', $datos, "leq_Id = {$this->_id}");
		}

		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}

    public function delete($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }

        // elimino el registo del equipo
        $resultado = $cnn->Delete('logs_equipo', "leq_Id = " . $this->_id);

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
        return true;
    }

}
