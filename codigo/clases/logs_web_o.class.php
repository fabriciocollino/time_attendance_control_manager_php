<?php

class Logs_Web_O
{

    private $_id;
    private $_usu_id;
    private $_ip;
    private $_fecha_hora;
    private $_accion;
    private $_detalle;
    private $_useragent;
    private $_adicional;
    private $_tipo;
    private $_errores;

    public function __construct($p_usu_id = 0, $p_accion = '', $p_detalle = '', $p_tipo = 0, $p_adicional = 0)
    {
        $this->_id = 0;
        $this->_usu_id = $p_usu_id;
        $this->_ip = $_SERVER['REMOTE_ADDR'];
        $this->_fecha_hora = date('Y-m-d H:i:s', time());
        $this->_accion = $p_accion;
        $this->_detalle = $p_detalle;
        $this->_tipo = $p_tipo;
        $this->_adicional = $p_adicional;

        if(isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->_useragent = $_SERVER['HTTP_USER_AGENT'];
        }else{
            $this->_useragent = '';
        }

        $this->_errores = array();
    }

    private function Control($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero = 'o')
    {
        if ($p_valor == '') {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar") . " " . strtolower($p_articulo) . " {$p_texto}.";
        } elseif (strlen($p_valor) < $p_min) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("es demasiado corto.");
        } elseif (strlen($p_valor) > $p_max) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("no debe superar los") . " {$p_max} " . _("caracteres.");
        }
        return $p_valor;
    }

    private function Seleccionado($p_valor, $p_texto)
    {
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

    public function Fecha($p_Fecha, $p_Format, $p_texto)
    {
        $_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
        if ($_fecha_hora === false) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = _("La") . " {$p_texto} " . _("es incorrecta.");
            return $p_Fecha;
        }
        return $_fecha_hora;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getUsuId()
    {
        return $this->_usu_id;
    }

    public function setUsuId($p_UsuId)
    {
        $p_UsuId = (integer)$p_UsuId;
        //$this->_usu_id = $this->Seleccionado($p_UsuId, _('Usuario'));
    }

    public function getIp()
    {
        return $this->_ip;
    }

    public function getFechaHora($p_Format = null)
    {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_int($this->_fecha_hora)) {
                return date($p_Format, $this->_fecha_hora);
            } else {
                return $this->_fecha_hora;
            }
        }
        return $this->_fecha_hora;
    }

    public function setFechaHora($p_Fecha, $p_Format)
    {
        $this->_fecha_hora = $this->Fecha($p_Fecha, $p_Format, _('Fecha Inicio'));
    }

    public function getAccion()
    {
        return $this->_accion;
    }

    public function setAccion($p_Estado)
    {
        $p_Estado = trim($p_Estado);
        $this->_accion = $this->Control($p_Estado, _('Estado'), 3, 255);
    }

    public function getDetalle()
    {
        return $this->_detalle;
    }

    public function setDetalle($p_Pagina)
    {
        $p_Pagina = trim($p_Pagina);
        $this->_detalle = $this->Control($p_Pagina, _('Pagina'), 0, 255);
    }


    public function getTipo()
    {
        return $this->_tipo;
    }

    public function setTipo($p_Tipo)
    {
        $p_Tipo = (integer)$p_Tipo;
        $this->_tipo = $p_Tipo;
    }

    public function getUserAgent()
    {
        return $this->_useragent;
    }

    public function getAdicional()
    {
        return $this->_detalle;
    }

    public function setAdicional($p_Adicional)
    {
        $p_Adicional = (integer)$p_Adicional;
        $this->_adicional = $p_Adicional;
    }

    public function esValido()
    {
        //--
        //Si el array errores no tiene elementos entonces el objeto es valido.
        return count($this->_errores) == 0;
    }

    public function getErrores()
    {
        return $this->_errores;
    }

    public function loadArray($p_Datos)
    {

        $this->_id = (integer)$p_Datos["log_Id"];
        $this->_usu_id = (integer)$p_Datos["log_Usu_Id"];
        $this->_ip = (string)$p_Datos["log_Ip"];
        $this->_fecha_hora = (is_null($p_Datos["log_Fecha_Hora"])) ? null : strtotime($p_Datos["log_Fecha_Hora"]);
        $this->_accion = (string)$p_Datos["log_Accion"];
        $this->_detalle = (string)$p_Datos["log_Detalle"];
        $this->_useragent = (string)$p_Datos["log_User_Agent"];
        $this->_tipo = (string)$p_Datos["log_Tipo"];
        $this->_adicional = (string)$p_Datos["log_Adicional"];
    }

    public function save($p_Debug)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $datos = array(
            'log_Usu_Id' => $this->_usu_id,
            'log_Ip' => $this->_ip,
            'log_Fecha_Hora' => $this->_fecha_hora,
            'log_Accion' => $this->_accion,
            'log_Detalle' => $this->_detalle,
            'log_User_Agent' => $this->_useragent,
            'log_Tipo' => $this->_tipo,
            'log_Adicional' => $this->_adicional
        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('logs_web', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('logs_web', $datos, "log_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }

}
