<?php

class Mensaje_O
{

    private $_id;
    private $_eq_id;
    private $_tipo;
    private $_titulo;
    private $_mensaje;
    private $_visto;
    private $_fecha;
    private $_fecha_visto;
    private $_errores;

    //tipos
    //0 message
    //1 warning
    //2 error

    public function __construct($p_eq_id = 0, $p_tipo = 0, $p_titulo = '', $p_mensaje = '', $p_visto = 0)
    {
        $this->_id = 0;
        $this->_eq_id = $p_eq_id;
        $this->_tipo = $p_tipo;
        $this->_titulo = $p_titulo;
        $this->_mensaje = $p_mensaje;
        $this->_visto = $p_visto;
        $this->_fecha = '';
        $this->_fecha_visto = '';
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($p_id)
    {
        $p_id = (integer)$p_id;
        $this->_id = $p_id;
    }

    public function getEqId()
    {
        return $this->_eq_id;
    }

    public function setEqId($p_eq_id)
    {
        $p_eq_id = (integer)$p_eq_id;
        $this->_eq_id = $p_eq_id;
    }

    public function getTipo()
    {
        return $this->_tipo;
    }

    public function getTipo_S()
    {
        $salida = '';
        switch ($this->_tipo) {
            case 0:
                $salida = '';
                break;
            case 1:
                $salida = 'Warning';
                break;
            case 2:
                $salida = 'Error';
                break;
        }
        return $salida;
    }

    public function setTipo($p_tipo)
    {
        $p_tipo = (integer)$p_tipo;
        $this->_tipo = $p_tipo;
    }

    public function getMensaje($p_max = '')
    {

        $salida = trim($this->_mensaje);

        $append = "&hellip;";

        if ($p_max != '') {
            $p_max = (integer)$p_max;
            if (strlen($salida) > $p_max) {
                $salida = wordwrap($salida, $p_max);
                $salida = explode("\n", $salida);
                $salida = array_shift($salida) . $append;
            }
        }


        return $salida;
    }

    public function setMensaje($p_mensaje)
    {
        $p_mensaje = (string)$p_mensaje;
        $this->_mensaje = $p_mensaje;
    }

    public function getTitulo()
    {
        return $this->_titulo;
    }

    public function setTitulo($p_titulo)
    {
        $p_titulo = (string)$p_titulo;
        $this->_titulo = $p_titulo;
    }

    public function getVisto()
    {
        return $this->_visto;
    }

    public function setVisto($p_visto)
    {
        $p_visto = (integer)$p_visto;
        $this->_visto = $p_visto;
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


    public function getFecha($p_Format = null)
    {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_int($this->_fecha)) {
                return date($p_Format, $this->_fecha);
            } else {
                return $this->_fecha;
            }
        }
        return $this->_fecha;
    }

    public function setFecha($p_Hora, $p_Format, $p_Ignore = false)
    {
        if (!$p_Ignore) {
            $this->_fecha = $this->Fecha($p_Hora, $p_Format, 'Fecha Creacion');
            $this->_fecha = $p_Hora;
        } else {
            $this->_fecha = 0;
        }
    }


    public function getFechaFormatoGmail()
    {
        $fecha=strtotime($this->_fecha);
        if (date('Ymd') == date('Ymd',$fecha )) {//si es de hoy
            return date('H:i a', $fecha);
        } else {
            return date('M t', $fecha);
        }


    }


    public function getFechaVisto($p_Format = null)
    {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_int($this->_fecha_visto)) {
                return date($p_Format, $this->_fecha_visto);
            } else {
                return $this->_fecha_visto;
            }
        }
        return $this->_fecha_visto;
    }

    public function setFechaVisto($p_Hora, $p_Format, $p_Ignore = false)
    {
        if (!$p_Ignore) {
            $this->_fecha_visto = $this->Fecha($p_Hora, $p_Format, 'Fecha Visto');
            $this->_fecha_visto = $p_Hora;
        } else {
            $this->_fecha_visto = 0;
        }
    }


    public function loadArray($p_Datos)
    {
        $this->_id = (integer)$p_Datos["men_Id"];
        $this->_eq_id = (integer)$p_Datos["men_Eq_Id"];
        $this->_tipo = (integer)$p_Datos["men_Tipo"];
        $this->_mensaje = (string)$p_Datos["men_Mensaje"];
        $this->_titulo = (string)$p_Datos["men_Titulo"];
        $this->_visto = (integer)$p_Datos["men_Visto"];
        $this->_fecha = (string)$p_Datos["men_Fecha"];
        $this->_fecha_visto = (string)$p_Datos["men_Fecha_Visto"];
    }

    public function save($p_Debug)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $datos = array(
            'men_Id' => $this->_id,
            'men_Eq_Id' => $this->_eq_id,
            'men_Tipo' => $this->_tipo,
            'men_Mensaje' => $this->_mensaje,
            'men_Titulo' => $this->_titulo,
            'men_Visto' => $this->_visto,
            'men_Fecha' => $this->_fecha,
            'men_Fecha_Visto' => $this->_fecha_visto
        );

        if ($this->_id == 0)
            $datos['men_Fecha'] = date('Y-m-d H:i:s');

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('mensajes', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('mensajes', $datos, "men_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }

}
