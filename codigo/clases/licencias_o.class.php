<?php
//licencias de personas
//
class Licencias_O
{

    private $_id;
    private $_per_id;
    private $_gru_id;
    private $_fecha_inicio;
    private $_fecha_fin;
    private $_duracion;
    private $_motivo;
    private $_tipo;
    private $_enabled;
    private $_fecha_mod;


    public function __construct() {
        $this->_id = 0;
        $this->_per_id = 0;
        $this->_gru_id = 0;
        $this->_tipo;
        $this->_fecha_inicio = '';
        $this->_fecha_fin = '';
        $this->_duracion = '';
        $this->_motivo = '';
        $this->_enabled = 0;
        $this->_fecha_mod = 0;

        $this->_errores = array();
    }


    private function seleccionado($p_valor, $p_texto) {
        if (is_int($p_valor)) {
            if ($p_valor == '') {
                $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un") . " {$p_texto}.";
            }
        } else {
            if ($p_valor == '') {
                $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un") . " {$p_texto}.";
            }
        }
    }

    private function control($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero = 'o') {
        if ($p_valor == '') {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar") . " " . strtolower($p_articulo) . " {$p_texto}.";
        } elseif (strlen($p_valor) < $p_min) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("es demasiado corto.");
        } elseif (strlen($p_valor) > $p_max) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("no debe superar los") . " {$p_max} " . _("caracteres.");
        } elseif (strpos($p_valor, ':') !== false) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("no debe contener dos puntos (:).");
        }
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

    public function getMotivo() {
        return $this->_motivo;
    }

    public function setMotivo($p_motivo) {
        $p_motivo = trim($p_motivo);
        $this->control($p_motivo, _('Motivo'), 4, 100);
        $this->_motivo = $p_motivo;
    }


    public function getPerId() {
        return $this->_per_id;
    }

    public function setPerId($p_persona_id) {
        //$this->seleccionado($p_persona_id, _('Persona'));
        $this->_per_id = $p_persona_id;
    }

    public function getGrupoId() {
        return $this->_gru_id;
    }

    public function setGrupoId($p_grupo_id) {
        //$this->seleccionado($p_grupo_id, _('Grupo'));
        $this->_gru_id = $p_grupo_id;
    }

    public function getPersonaOGrupo() {
        if ($this->_per_id == 0) {
            return 'grupo';
        } else if ($this->_gru_id == 0) {
            return 'persona';
        }
    }


    public function getTipo() {
        return $this->_tipo;
    }


    public function setTipo($p_Tipo) {
        $p_Tipo = (integer)$p_Tipo;
        $this->_tipo = $p_Tipo;
    }


    public function getDuracion() {
        return $this->_duracion;
    }

    public function getDuracionNumber() {
        $dur = explode(',', $this->_duracion);
        return $dur[0];
    }

    public function getDuracionMH() {
        $dur = explode(',', $this->_duracion);
        return $dur[1];
    }

    public function getDuracionMHString() {
        $dur = explode(',', $this->_duracion);
        switch ($dur[1]) {
            case 'm':
                if ($this->getDuracionNumber() == 1)
                    return 'Minuto';
                else
                    return 'Minutos';
            case 'h':
                if ($this->getDuracionNumber() == 1)
                    return 'Hora';
                else
                    return 'Horas';
        }
        return 'ERROR';
    }

    public function getDuracionMHFilterString() {
        $dur = explode(',', $this->_duracion);
        if(array_key_exists(1,$dur)) {
            switch ($dur[1]) {
                case 'm':
                    return 'F_Minutos';
                case 'h':
                    return 'F_Horas';
            }
        }
        return 'F_ERROR';
    }

    public function getDuracionFilterString() {
        switch ($this->_duracion) {
            case '':
            case '15,m':
                return 'F_15';
            case '30,m':
                return 'F_30';
            case '1,h':
                return 'F_1';
            case '2,h':
                return 'F_2';
        }
        //si todavia estoy aca, es porque es un intervalo personalizado
        return 'F_Personalizado';
    }


    public function checkDuracionValidaLlegadaTarde($p_Fecha_Inicio, $p_Fecha) {
        $p_Fecha_Inicio = (string)$p_Fecha_Inicio;
        $p_Fecha = (string)$p_Fecha;
        $numero = $this::getDuracionNumber();
        $HM = $this::getDuracionMH();


        $p_Fecha_Inicio = new DateTime($p_Fecha_Inicio);
        $p_Fecha_Inicio->add(new DateInterval('PT' . $numero . strtoupper($HM)));

        $p_Fecha = new DateTime($p_Fecha);

        if ($p_Fecha < $p_Fecha_Inicio)
            return true;
        else
            return false;


    }

    public function checkDuracionValidaSalidaTemprano($p_Fecha_Fin, $p_Fecha) {
        $p_Fecha_Fin = (string)$p_Fecha_Fin;
        $p_Fecha = (string)$p_Fecha;
        $numero = $this::getDuracionNumber();
        $HM = $this::getDuracionMH();


        $p_Fecha_Fin = new DateTime($p_Fecha_Fin);
        $p_Fecha_Fin->sub(new DateInterval('PT' . $numero . strtoupper($HM)));

        $p_Fecha = new DateTime($p_Fecha);

        if ($p_Fecha > $p_Fecha_Fin)
            return true;
        else
            return false;


    }

    public function checkPasada() {

        $now = new DateTime();
        $Fecha_Fin = new DateTime($this->_fecha_fin);

        switch ($this->_tipo) {
            case LICENCIA_DIA_COMPLETO:
            case LICENCIA_LLEGADA_TARDE:
            case LICENCIA_SALIDA_TEMPRANO:
                $Fecha_Fin->add(new DateInterval('P1D'));
                if ($Fecha_Fin < $now)
                    return true;
                break;

            case LICENCIA_PERSONALIZADA:
                if ($Fecha_Fin < $now)
                    return true;
                break;
        }

        return false;
    }


    public function setDuracion($duracion) {
        $duracion = (string)$duracion;
        $this->_duracion = trim($duracion);
    }


    public function getFechaInicio($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_int($this->_fecha_inicio)) {
                return date($p_Format, $this->_fecha_inicio);
            } else {
                return $this->_fecha_inicio;
            }
        }
        return $this->_fecha_inicio;
    }

    public function setFechaInicio($p_Hora, $p_Format, $p_Ignore = false) {
        if (!$p_Ignore) {
            $this->_fecha_inicio = $this->Fecha($p_Hora, $p_Format, 'Fecha Inicio');
            $this->_fecha_inicio = $p_Hora;
        } else {
            $this->_fecha_inicio = 0;
        }
    }


    public function getFechaFin($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_int($this->_fecha_fin)) {
                return date($p_Format, $this->_fecha_fin);
            } else {
                return $this->_fecha_fin;
            }
        }
        return $this->_fecha_fin;
    }

    public function setFechaFin($p_Hora, $p_Format, $p_Ignore = false) {
        if (!$p_Ignore) {
            $this->_fecha_fin = $this->Fecha($p_Hora, $p_Format, 'Fecha Inicio');
            $this->_fecha_fin = $p_Hora;
        } else {
            $this->_fecha_fin = 0;
        }
    }

    public function getEnabled() {
        return $this->_enabled;
    }

    public function setEnabled($p_Enabled) {
        $p_Enabled = (integer)$p_Enabled;
        $this->_enabled = $p_Enabled;

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

        if ($this->_gru_id > 0 && $this->_per_id > 0) {
            $this->_errores['personas'] = _("La licencia no puede ser asignada a una persona Y a un grupo al mismo tiempo");
        }

        if ($this->_gru_id == 0 && $this->_per_id == 0) {
            $this->_errores['personas'] = _("Debe seleccionar una persona o un grupo para la licencia");
        }

        if ($this->_tipo == LICENCIA_LLEGADA_TARDE || $this->_tipo == LICENCIA_SALIDA_TEMPRANO) {
            if ($this->_duracion == '') $this->_errores['duracion'] = _("Debe seleccionar la duración de la licencia");
        }

        //Si el array errores no tiene elementos entonces el objeto es valido.
        return count($this->_errores) == 0;
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos) {

        $this->_id = (integer)$p_Datos["lic_Id"];
        $this->_per_id = (integer)$p_Datos["lic_Per_Id"];
        $this->_gru_id = (integer)$p_Datos["lic_Gru_Id"];
        $this->_tipo = (integer)$p_Datos["lic_Tipo"];
        $this->_fecha_inicio = (string)$p_Datos["lic_Fecha_Inicio"];
        $this->_fecha_fin = (string)$p_Datos["lic_Fecha_Fin"];
        $this->_duracion = (string)$p_Datos["lic_Duracion"];
        $this->_motivo = (string)$p_Datos["lic_Motivo"];
        $this->_enabled = (integer)$p_Datos["lic_Enabled"];
        $this->_fecha_mod = (string)$p_Datos["lic_Fecha_Mod"];


    }

    public function save($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $datos = array(
            'lic_Per_Id' => $this->_per_id,
            'lic_Gru_Id' => $this->_gru_id,
            'lic_Tipo' => $this->_tipo,
            'lic_Fecha_Inicio' => $this->_fecha_inicio,
            'lic_Fecha_Fin' => $this->_fecha_fin,
            'lic_Duracion' => $this->_duracion,
            'lic_Motivo' => $this->_motivo,
            'lic_Enabled' => $this->_enabled,
            'lic_Fecha_Mod' => $this->_fecha_mod

        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('licencias', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('licencias', $datos, "lic_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }


    public function delete($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($cnn->Delete('licencias', "lic_Id = {$this->_id}")) {
            return true;
        } else {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
    }

}
