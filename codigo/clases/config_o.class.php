<?php

class Config_O
{

    private $_id;
    private $_detalle;
    private $_valor;
    private $_tipo;
    private $_seccion;
    private $_equipo;
    private $_parametro;
    private $_notas;
    private $_visible;
    private $_fecha_mod;

    private $_errores;

    public function __construct() {
        $this->_id = 0;
        $this->_detalle = ''; //varchar(100)
        $this->_valor = ''; // varchar(100))
        $this->_tipo = ''; // varchar(50)
        $this->_seccion = ''; // varchar(150)
        $this->_parametro = ''; // varchar(100)
        $this->_visible = 0; // int
        $this->_equipo = 0; // int
        $this->_notas; //text
        $this->_fecha_mod = 0;

        $this->_errores = array();
    }

    public function getId() {
        return $this->_id;
    }

    public function getDetalle() {
        return $this->_detalle;
    }

    public function getValor() {
        return $this->_valor;
    }

    public function setValor($p_valor) {
        $p_valor = trim($p_valor);
        $this->_valor = $p_valor;
    }

    public function getNotas() {
        return $this->_notas;
    }

    public function setNotas($p_notas) {
        $p_notas = trim($p_notas);
        $this->_notas = $p_notas;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getSeccion() {
        return $this->_seccion;
    }

    public function setSeccion($p_seccion) {
        $p_seccion = (string)$p_seccion;
        $this->_seccion = $p_seccion;
    }


    public function getParametro() {
        return $this->_parametro;
    }

    public function setParametro($p_parametro) {
        $p_parametro = (string)$p_parametro;
        $this->_parametro = $p_parametro;
    }

    public function getVisible() {
        return $this->_visible;
    }

    public function setVisible($p_visible) {
        $p_visible = (integer)$p_visible;
        $this->_visible = $p_visible;
    }

    public function getEquipo() {
        return $this->_equipo;
    }

    public function setEquipo($p_Equipo) {
        $p_Equipo = (integer)$p_Equipo;
        $this->_equipo = $p_Equipo;
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
        $this->_errores = '';

        //Validaciones del detalle

        switch ($this->_tipo) {
            case 'si_no':
            case 'si_no_invertido': //0 o 1 - booleano
                if (preg_match('/[a-z]/', $this->_valor) || preg_match('/[A-Z]/', $this->_valor)) {
                    $this->_errores = _("Se deben ingresar valores numéricos únicamente.");
                } elseif ($this->_valor == 0 || $this->_valor == 1) {
                    // valor corecto
                } else {
                    $this->_errores = _("Valor ingresado incorrecto");
                }
                break;
            case 'numerico': // del 0 al n - numerico
                if (preg_match('/[a-z]/', $this->_valor) || preg_match('/[A-Z]/', $this->_valor)) {
                    $this->_errores = _("Se deben ingresar valores numéricos únicamente.");
                }
                break;

            default: //error
        }

        //--
        //Si el array errores no tiene elementos entonces el objeto es valido.
        return $this->_errores == '';
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos) {

        $this->_id = (integer)$p_Datos["con_Id"];
        $this->_detalle = (string)$p_Datos["con_Detalle"];
        $this->_valor = (string)$p_Datos["con_Valor"];
        $this->_tipo = (string)$p_Datos["con_Tipo"];
        $this->_seccion = (string)$p_Datos["con_Seccion"];
        $this->_parametro = (string)$p_Datos["con_Parametro"];
        $this->_visible = (integer)$p_Datos["con_Visible"];
        $this->_equipo = (integer)$p_Datos["con_Equipo"];
        $this->_fecha_mod = (string)$p_Datos["con_Fecha_Mod"];
        $this->_notas = (string)$p_Datos["con_Notas"];
    }

    public function save($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");
        

        $datos = array(
            'con_Detalle' => $this->_detalle,
            'con_Valor' => $this->_valor,
            'con_Seccion' => $this->_seccion,
            'con_Parametro' => $this->_parametro,
            'con_Visible' => $this->_visible,
            'con_Equipo' => $this->_equipo,
            'con_Fecha_Mod' => $this->_fecha_mod,
            'con_Notas' => $this->_notas
        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('configuracion', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('configuracion', $datos, "con_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }

    public function delete($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($cnn->Delete('configuracion', "con_Id = {$this->_id}")) {
            return true;
        } else {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
    }

}
