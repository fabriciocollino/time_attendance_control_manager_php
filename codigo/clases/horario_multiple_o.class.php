<?php

/**
 *
 *
 *
 *
 */
class Horario_Multiple_O
{

    private $_id;
    private $_detalle;
    private $_horarios;
    private $_fecha_mod;
    private $_eliminado;
    private $_empresa;


    public function __construct() {
        $this->_id = 0;
        $this->_detalle = ''; // varchar(255)
        $this->_horarios = '';
        $this->_fecha_mod = 0;
        $this->_eliminado = 0;
        $this->_empresa = 1;

        $this->_errores = array();
    }

    public function getId() {
        return $this->_id;
    }

    public function getDetalle() {
        return $this->_detalle;
    }

    public function getDetalleHorarios() {
        $horarios = json_decode($this->_horarios, true);
        $salida = '';

        if (!is_null($horarios) && $horarios != '') {

            foreach ($horarios as $secuencia) {
                $salida .= Hora_Trabajo_L::obtenerPorId($secuencia['horario_id'])->getDetalle() . '<br/>';
            }
        }

        return $salida;
    }

    public function setDetalle($p_Detalle) {
        $p_Detalle = trim($p_Detalle);
        $this->_detalle = $p_Detalle;

        $o_Detalle_Existente = Horario_Rotativo_L::obtenerPorDetalle($this->_detalle, $this->_id);
        if ($this->_detalle == '') {
            $this->_errores['detalle'] = _('Debe proporcionar la descripción del horario de trabajo.');
        } elseif (strlen($this->_detalle) < 4) {
            $this->_errores['detalle'] = _('La descripción del horario de trabajo es demasiado corta.');
        } elseif (strlen($this->_detalle) > 255) {
            $this->_errores['detalle'] = _('La descripción del horario de trabajo no debe superar los 255 caracteres.');
        } elseif (!is_null($o_Detalle_Existente)) {
            $this->_errores['detalle'] = _('La descripción') . ' \'' . $this->_detalle . '\' ' . _('ya existe.');
        }
    }


    public function getHorarios() {
        return $this->_horarios;
    }

    public function setHorarios($p_Horarios) {
        $p_Horarios = trim($p_Horarios);
        $this->_horarios = $p_Horarios;
    }


    public function getArrayDias() {

        $horarios = json_decode($this->_horarios, true);

        $salida = array();

        if (!is_null($horarios) && $horarios != '') {

            foreach ($horarios as $secuencia) {
                $horario = Hora_Trabajo_L::obtenerPorId($secuencia['horario_id']);
                $salida[] = $horario->getArrayDias();
            }
        }

        return $salida;
    }


    public function getArrayDiasString() {

        $horarios = json_decode($this->_horarios, true);

        $salida = array();

        if (!is_null($horarios) && $horarios != '') {

            foreach ($horarios as $secuencia) {
                $horario = Hora_Trabajo_L::obtenerPorId($secuencia['horario_id']);
                $salida[] = $horario->getArrayDiasString();
            }
        }

        return $salida;
    }


    public function getHorarioByClosestTime($p_Time) {
        $horarios = json_decode($this->_horarios, true);
        $dia_n = date('w', strtotime($p_Time));
        $hora = date('H:i:s', strtotime($p_Time));

        if (!is_null($horarios) && $horarios != '') {
            $array_horarios = array();
            $array_horarios_fin = array();
            foreach ($horarios as $secuencia) {
                $horario = Hora_Trabajo_L::obtenerPorId($secuencia['horario_id'])->getArrayDiasString();
                $array_horarios[] = $horario[$dia_n][0];  //0 es el horario de inicio
                $array_horarios_fin[] = $horario[$dia_n][1];  //1 es el horario de fin
            }
            $closest = '00:00:00';
            $fin = '';
            $diferencia_inicio = 28800; //8hs de diferencia minima
            //aca tengo un array de todos los horarios de inicio del dia de la semana w
            foreach ($array_horarios as $index => $horario) {
                $dif = abs(DateTimeHelper::time_to_sec($horario) - DateTimeHelper::time_to_sec($hora));
                if ($dif < $diferencia_inicio) {
                    $closest = $horario;
                    $diferencia_inicio = $dif;
                    $fin = $array_horarios_fin[$index];
                }
            }
            $closest_inicio = $closest;
            //echo "<br>detectado horario inicio ".$closest_inicio." con diferencia: ".$diferencia_inicio;

            //hago lo mismo pero con los horarios de salida
            $closest = '00:00:00';
            $diferencia_fin = 28800; //8hs de diferencia minima
            $inicio = '';
            foreach ($array_horarios_fin as $index => $horario) {
                $dif = abs(DateTimeHelper::time_to_sec($horario) - DateTimeHelper::time_to_sec($hora));
                if ($dif < $diferencia_fin) {
                    $closest = $horario;
                    $diferencia_fin = $dif;
                    $inicio = $array_horarios[$index];
                }
            }
            $closest_fin = $closest;
            //echo "<br>detectado horario fin ".$closest." con diferencia: ".$diferencia_fin;

            if($diferencia_inicio < $diferencia_fin){
                //echo "</br>Usando el horario de inicio como referencia.";
                return array($closest_inicio, $fin);
            }else{
                //echo "</br>Usando el horario de fin como referencia.";
                return array($inicio, $closest_fin);
            }

        }

        return '';
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

    /**
     * Devuelve TRUE/FALSE dependiendo de si el objeto es valido o no.
     *
     * @return boolean
     */
    public function esValido() {
        //$this->_errores = array();
        //Si el array errores no tiene elementos entonces el objeto es valido.


        return count($this->_errores) == 0;
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos) {

        $this->_id = (integer)$p_Datos["hmu_Id"];
        $this->_detalle = (string)$p_Datos["hmu_Detalle"];
        $this->_horarios = (string)$p_Datos["hmu_Horarios"];
        $this->_fecha_mod = (string) $p_Datos["hmu_Fecha_Mod"];

    }

    public function save($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $datos = array(
            'hmu_Detalle' => $this->_detalle,
            'hmu_Horarios' => $this->_horarios,
            'hmu_Fecha_Mod' => $this->_fecha_mod


        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('horarios_multiples', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('horarios_multiples', $datos, "hmu_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }

    public function delete($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }
        $resultado = '';

        $cantidad_personas = Persona_L::obtenerPorHorariodeTrabajoCOUNT($this->_id, HORARIO_MULTIPLE);
        if ($cantidad_personas == 0) {
            // elimino el registo de un hora_trabajo
            $resultado = $cnn->Delete('horarios_multiples', "hmu_Id = " . $this->_id);
        } else {
            $this->_errores['mysql'] = _('Hay una o más personas asignadas a este horario de trabajo, no se puede borrar hasta que todas las personas sean reasignadas.');
            return false;
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
        return true;
    }


    /**
     * Devuelve un array con algunos datos del horario
     * Se utiliza en la API
     *
     * @return array()
     */
    public function toArray() {
        $array = array();
        $array['id'] = $this->_id;
        $array['nombre'] = $this->_detalle;
        $array['horarios'] = $this->_horarios;

        return $array;
    }

    /**
     * Actualiza algunos datos del horario desde un array
     * Se utiliza en la API
     *
     * @param $p_Datos array()
     *
     * @return array()
     */
    public function fromArray($p_Datos) {

        if(array_key_exists('nombre',$p_Datos))$this::setDetalle((string)$p_Datos["nombre"]);
        if(array_key_exists('horarios',$p_Datos))$this::setHorarios((string)$p_Datos["horarios"]);

    }

    /**
     * Devuelve un array con los datos del horario para sync
     * Se utiliza en el proceso de sincronizacion
     *
     * @return array()
     */
    public function toSyncArray() {
        $array = array();

        $array['hmu_Id'] = $this->_id;
        $array['hmu_Detalle'] = $this->_detalle;
        $array['hmu_Horarios'] = $this->_horarios;
        $array['hmu_Eliminado'] = $this->_eliminado;


        return $array;
    }

    /**
     * Actualiza los datos del horario desde un array
     * Se utiliza en el proceso de sincronizacion
     *
     * @param $p_Datos array()
     *
     * @return array()
     */
    public function fromSyncArray($p_Datos) {


        if(array_key_exists('hmu_Detalle',$p_Datos))$this::setDetalle((string)$p_Datos["hmu_Detalle"]);
        if(array_key_exists('hmu_Horarios',$p_Datos))$this::setHorarios((string)$p_Datos["hmu_Horarios"]);

    }

}
