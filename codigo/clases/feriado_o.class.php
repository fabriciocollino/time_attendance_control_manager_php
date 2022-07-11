<?php
//licencias de personas
//
class Feriado_O
{

    private $_id;
    private $_per_id;
    private $_gru_id;
    private $_tipo;
    private $_fecha_inicio;
    private $_fecha_fin;
    private $_descripcion;
    private $_enabled;
    private $_fecha_mod;


    public function __construct() {
        $this->_id = 0;
        $this->_per_id = 0;
        $this->_gru_id = 0;
        $this->_tipo = 0;
        $this->_fecha_inicio = '';
        $this->_fecha_fin = '';
        $this->_descripcion = '';
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

    public function getDetalle() {  //para compatibilidad con el array2htmloptions
        return $this->_descripcion;
    }

    public function getDescripcion() {
        return $this->_descripcion;
    }

    public function setDescripcion($p_descripcion) {
        $p_descripcion = trim($p_descripcion);
        $this->control($p_descripcion, _('Descripcion'), 4, 100);
        $this->_descripcion = $p_descripcion;
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
        $p_grupo_id = (integer)$p_grupo_id;
        $this->_gru_id = $p_grupo_id;
    }

    public function getPersonaOGrupo() {
        if ($this->_per_id == 0 && $this->_gru_id == 0) {
            return 'Todas las Personas';
        } else if ($this->_per_id == 0) {
            return 'grupo';
        } else if ($this->_gru_id == 0) {
            return 'persona';
        }
    }

    public function getPersonaOGrupoParaelSELECT() {
        if ($this->_per_id == 0 && $this->_gru_id == 0) {
            return '';
        } else if ($this->_per_id == 0) {
            return 0;
        } else if ($this->_gru_id == 0) {
            return $this->_per_id;
        }
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function setTipo($tipo) {
        $tipo = (integer)$tipo;
        $this->_tipo = $tipo;
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

    public function checkPasado() {

        $now = new DateTime();
        $Fecha_Fin = new DateTime($this->_fecha_fin);

        switch ($this->_tipo) {
            case FERIADO_DIA_COMPLETO:
                $Fecha_Fin->add(new DateInterval('P1D'));
                if ($Fecha_Fin < $now)
                    return true;
                break;

            case FERIADO_PERIODO:
                if ($Fecha_Fin < $now)
                    return true;
                break;
        }

        return false;
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

        /*  esto es valido para los feriados, porque ambos en cero significa, todas las personas
        if($this->_gru_id==0 && $this->_per_id==0){
                $this->_errores['personas'] = _("Debe seleccionar una persona o un grupo para la licencia");
        }
    */
        //Si el array errores no tiene elementos entonces el objeto es valido.
        return count($this->_errores) == 0;
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos) {

        $this->_id = (integer)$p_Datos["fer_Id"];
        $this->_per_id = (integer)$p_Datos["fer_Per_Id"];
        $this->_gru_id = (integer)$p_Datos["fer_Gru_Id"];
        $this->_tipo = (integer)$p_Datos["fer_Tipo"];
        $this->_fecha_inicio = (string)$p_Datos["fer_Fecha_Inicio"];
        $this->_fecha_fin = (string)$p_Datos["fer_Fecha_Fin"];
        $this->_descripcion = (string)$p_Datos["fer_Descripcion"];
        $this->_enabled = (integer)$p_Datos["fer_Enabled"];
        $this->_fecha_mod = (string)$p_Datos["fer_Fecha_Mod"];


    }

    public function save($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $datos = array(
            'fer_Per_Id' => $this->_per_id,
            'fer_Gru_Id' => $this->_gru_id,
            'fer_Tipo' => $this->_tipo,
            'fer_Fecha_Inicio' => $this->_fecha_inicio,
            'fer_Fecha_Fin' => $this->_fecha_fin,
            'fer_Descripcion' => $this->_descripcion,
            'fer_Enabled' => $this->_enabled,
            'fer_Fecha_Mod' => $this->_fecha_mod

        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('feriados', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('feriados', $datos, "fer_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }


    public function delete($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($cnn->Delete('feriados', "fer_Id = {$this->_id}")) {
            return true;
        } else {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
    }

}
