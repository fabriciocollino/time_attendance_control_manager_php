<?php

class Grupo_O
{

    private $_id;
    private $_detalle;
    private $_envivo;
    private $_fecha_mod;
    private $_errores;

    public function __construct() {
        $this->_id = 0;
        $this->_detalle = ''; //varchar(50)
        $this->_envivo = 0;
        $this->_fecha_mod = 0;

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

    public function getEnVivo() {
        return $this->_envivo;
    }

    public function setEnVivo($p_envivo) {
        $p_envivo = (integer)$p_envivo;
        $this->_envivo = $p_envivo;
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
        $o_Existente = Grupo_L::obtenerPorDetalle($this->_detalle, $this->_id);
        if ($this->_detalle == '') {
            $this->_errores['detalle'] = _('Debe proporcionar el detalle.');
        } elseif (strlen($this->_detalle) < 2) {
            $this->_errores['detalle'] = _('El detalle es demasiado corto.');
        } elseif (strlen($this->_detalle) > 50) {
            $this->_errores['detalle'] = _('El detalle no debe superar los 50 caracteres.');
        } elseif (!is_null($o_Existente)) {
            $this->_errores['detalle'] = _('El detalle') . ' \'' . $this->_detalle . '\' ' . _('ya existe.');
        }
        //--
        //Si el array errores no tiene elementos entonces el objeto es valido.
        return count($this->_errores) == 0;
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos) {

        $this->_id = (integer)$p_Datos["gru_Id"];
        $this->_detalle = (string)$p_Datos["gru_Detalle"];
        $this->_envivo = (string)$p_Datos["gru_En_Vivo"];
        $this->_fecha_mod = (string)$p_Datos["gru_Fecha_Mod"];
    }

    public function getPersonasCount() {

        return Persona_L::obtenerCantidadPorGrupo($this->_id);
    }

    public function save($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $datos = array(
            'gru_Detalle' => $this->_detalle,
            'gru_En_Vivo' => $this->_envivo,
            'gru_Fecha_Mod' => $this->_fecha_mod
        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('grupos', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('grupos', $datos, "gru_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }

    public function delete($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($cnn->Delete('grupos', "gru_Id = {$this->_id}")) {
            return true;
        } else {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
    }

}
