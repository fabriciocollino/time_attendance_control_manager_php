<?php

/**
 *
 *
 *
 *
 */
class Horario_Rotativo_O
{

    private $_id;
    private $_detalle;
    private $_horarios;
    private $_fecha_inicio;
    private $_fecha_mod;
    private $_eliminado;


    public function __construct() {
        $this->_id = 0;
        $this->_detalle = ''; // varchar(255)
        $this->_horarios = '';
        $this->_fecha_inicio = 0;
        $this->_fecha_mod = 0;
        $this->_eliminado = 0;

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


    public function getFechaInicio($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_int($this->_fecha_inicio)) {
                if ($this->_fecha_inicio == 0) return '';
                return date($p_Format, $this->_fecha_inicio);
            } else {
                return $this->_fecha_inicio;
            }
        }
        return $this->_fecha_inicio;
    }

    public function setFechaInicio($p_Hora, $p_Format) {
        $this->_fecha_inicio = $this->Fecha($p_Hora, $p_Format, 'Hora'); //creo q esto esta al pedo. algun dia me voy a tener que poner a revisar todas las fechas
        $this->_fecha_inicio = $p_Hora;


    }


    public function Fecha($p_Fecha, $p_Format, $p_texto) {
        $_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
        if ($_fecha_hora === false) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = _("La") . " {$p_texto} " . _("es incorrecta.");
            return $p_Fecha;
        }
        return $_fecha_hora;
    }

    /***
     *
     * @param $desde_inicio Bool
     * si esta seteado devuelve UN SOLO array de dias, que es el que corresponde.  SINO, devuelve todos los que contiene el horario.
     * @param $hora_del_log  integer horario del log.
     *
     * @return array dias
     */

    public function getArrayDias($desde_inicio=false, $hora_del_log=0) {

        /**
         *
         * Aca hay magia.
         *
         * Esta funcion devuelve el horario que corresponda segun la fecha del log, teniendo en cuenta la fecha de inicio del horario rotativo.
         *
         */

        $horarios = json_decode($this->_horarios, true);

        $salida = array();

        if($desde_inicio==false){
            if (!is_null($horarios) && $horarios != '') {

                foreach ($horarios as $secuencia) {
                    $horario = Hora_Trabajo_L::obtenerPorId($secuencia['horario_id']);
                    $salida[] = $horario->getArrayDias();
                }
            }
        }else{
            if (!is_null($horarios) && $horarios != '') {


                $date1 = new DateTime($this->getFechaInicio());
                $date2 = new DateTime($hora_del_log);

                $diff = $date2->diff($date1)->format("%a");

                $diff = $diff + 1;

                $duracion_total_del_horario = 0;
                foreach ($horarios as $secuencia) {
                    $duracion_total_del_horario+=$secuencia['duracion'];
                }

                $dia_en_el_horario = $diff % $duracion_total_del_horario;//el resultado del mod, es el dia en el que estoy, en el total del horario

                $secuencia_a_usar = 0;
                $horario_a_usar = 0;
                $acumulador_de_duraciones = 0;
                foreach ($horarios as $key => $secuencia) {
                    if($dia_en_el_horario>$acumulador_de_duraciones){
                        $acumulador_de_duraciones += $secuencia['duracion'];
                        if($dia_en_el_horario>$acumulador_de_duraciones){//si despues de sumar la secuencia, todavia no llego a la cantidad de dias
                            continue;
                        }else{
                            $secuencia_a_usar = $key;
                            $horario_a_usar = $secuencia['horario_id'];
                            break;
                        }
                    }else{
                        $secuencia_a_usar = $key;
                        $horario_a_usar = $secuencia['horario_id'];
                        break;
                    }
                }

                $horario = Hora_Trabajo_L::obtenerPorId($horario_a_usar);
                $salida[] = $horario->getArrayDias();
                /*
                //if($debug) {
                    if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) {
                        echo "<span style=\"width:200px;\">Fecha Inicio Horario: " . $this->getFechaInicio();echo "<br>";
                        echo "<span style=\"width:200px;\">Fecha del Log: " . $hora_del_log;echo "<br>";
                        echo "<span style=\"width:200px;\">Dias desde el inicio del horario: " . $diff;echo "<br>";
                        echo "<span style=\"width:200px;\">Duracion total del horario: " . $duracion_total_del_horario;echo "<br>";
                        echo "<span style=\"width:200px;\">diff % duracion: " . $dia_en_el_horario; echo "<br>";
                        echo "<span style=\"width:200px;\">Secuencia a usar: " . $secuencia_a_usar;echo "<br>";
                        echo "<span style=\"width:200px;\">HorarioID a usar: " . $horario_a_usar; echo "<br>";
                    }
                //}
                */
            }
        }

        return $salida;
    }


    public function getArrayDiasString($desde_inicio=false, $hora_del_log=0) {

        $horarios = json_decode($this->_horarios, true);

        $salida = array();

        if($desde_inicio==false) {

            if (!is_null($horarios) && $horarios != '') {

                foreach ($horarios as $secuencia) {
                    $horario = Hora_Trabajo_L::obtenerPorId($secuencia['horario_id']);
                    $salida[] = $horario->getArrayDiasString();
                }
            }
        }else{
            if (!is_null($horarios) && $horarios != '') {


                $date1 = new DateTime($this->getFechaInicio());
                $date2 = new DateTime($hora_del_log);

                $diff = $date2->diff($date1)->format("%a");

                $diff = $diff + 1;

                $duracion_total_del_horario = 0;
                foreach ($horarios as $secuencia) {
                    $duracion_total_del_horario+=$secuencia['duracion'];
                }

                $dia_en_el_horario = $diff % $duracion_total_del_horario;//el resultado del mod, es el dia en el que estoy, en el total del horario

                $secuencia_a_usar = 0;
                $horario_a_usar = 0;
                $acumulador_de_duraciones = 0;
                foreach ($horarios as $key => $secuencia) {
                    if($dia_en_el_horario>$acumulador_de_duraciones){
                        $acumulador_de_duraciones += $secuencia['duracion'];
                        if($dia_en_el_horario>$acumulador_de_duraciones){//si despues de sumar la secuencia, todavia no llego a la cantidad de dias
                            continue;
                        }else{
                            $secuencia_a_usar = $key;
                            $horario_a_usar = $secuencia['horario_id'];
                            break;
                        }
                    }else{
                        $secuencia_a_usar = $key;
                        $horario_a_usar = $secuencia['horario_id'];
                        break;
                    }
                }

                $horario = Hora_Trabajo_L::obtenerPorId($horario_a_usar);
                $salida[] = $horario->getArrayDiasString();
                /*
                                echo "<span style=\"width:200px;\">Fecha Inicio Horario: ".$this->getFechaInicio();echo "<br>";
                                echo "<span style=\"width:200px;\">Fecha del Log: ".$hora_del_log;echo "<br>";
                                echo "<span style=\"width:200px;\">Dias desde el inicio del horario: ".$diff;echo "<br>";
                                echo "<span style=\"width:200px;\">Duracion total del horario: ".$duracion_total_del_horario;echo "<br>";
                                echo "<span style=\"width:200px;\">diff % duracion: ".$dia_en_el_horario;echo "<br>";
                                echo "<span style=\"width:200px;\">Secuencia a usar: ".$secuencia_a_usar;echo "<br>";
                                echo "<span style=\"width:200px;\">HorarioID a usar: ".$horario_a_usar;echo "<br>";
                */
            }
        }

        return $salida;
    }


    public function getDuracionTotal() {

        $horarios = json_decode($this->_horarios, true);

        $salida = 0;


        if (!is_null($horarios) && $horarios != '') {

            foreach ($horarios as $secuencia) {
                $salida += $secuencia['duracion'];
            }
        }


        return $salida;
    }


    public function getHorarioByDay($p_Time) {

/*
        echo "<br/><br/>fecha inicio: ".$this->_fecha_inicio."<br />";
        echo "fecha log: ".$p_Time."<br />";
*/


        $inicio = strtotime($this->_fecha_inicio);
        $fecha = strtotime($p_Time);

        $datediff = $fecha - $inicio;
        $dias_dif = floor($datediff / (60 * 60 * 24));   //porque no le puse comentario a esto me cago en la mierda

        $duracion_total = $this::getDuracionTotal();
/*
        echo "diferencia: ".$dias_dif."<br />";
        echo "duracion total: ".$duracion_total."<br />";
        echo "mod: ".$dias_dif%$duracion_total."<br />";
*/


        $horarios = json_decode($this->_horarios, true);
        //echo "<pre>";print_r($horarios);echo "</pre>";

        if (!is_null($horarios) && $horarios != '') {
            $array_horarios = array();
            $array_horarios_fin = array();
            $i = 0;
            $x = 0;
            $contador = 0;
            foreach ($horarios as $secuencia) {
                $horario = Hora_Trabajo_L::obtenerPorId($secuencia['horario_id'])->getArrayDiasString();
                $duracion = $secuencia['duracion'];

                for ($i = $contador; $i < ($contador + $duracion); $i++) {
                    if ($x % 7 == 0 & $x > 0) $x = 0;
                    $array_horarios[] = $horario[$x][0];  //0 es el horario de inicio
                    $array_horarios_fin[] = $horario[$x][1];  //1 es el horario de fin
                    $x++;
                }
            }
            //echo "<pre>";print_r($array_horarios);echo "</pre>";
            //echo "<pre>";print_r($array_horarios_fin);echo "</pre>";

            if ($dias_dif > $duracion_total) {

                $dias_dif = $dias_dif % $duracion_total;
                if(($dias_dif + 1)>=$duracion_total)$dias_dif=0;  //TODO: esto arregla el problema a veces se pasa 1,  (porque abajo esta +1 )
            }

            //echo "hora inicio: ".$array_horarios[$dias_dif+1]." hora fin: ".$array_horarios_fin[$dias_dif+1];
            return array($array_horarios[$dias_dif + 1], $array_horarios_fin[$dias_dif + 1]);
            //el +1 es porque array_horarios empieza en 0
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

        $this->_id = (integer)$p_Datos["hrot_Id"];
        $this->_detalle = (string)$p_Datos["hrot_Detalle"];
        $this->_horarios = (string)$p_Datos["hrot_Horarios"];
        $this->_fecha_inicio = (string)$p_Datos["hrot_Fecha_Inicio"];
        $this->_fecha_mod = (string) $p_Datos["hrot_Fecha_Mod"];

    }

    public function save($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $datos = array(
            'hrot_Detalle' => $this->_detalle,
            'hrot_Horarios' => $this->_horarios,
            'hrot_Fecha_Inicio' => $this->_fecha_inicio,
            'hrot_Fecha_Mod' => $this->_fecha_mod

        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('horarios_rotativos', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('horarios_rotativos', $datos, "hrot_Id = {$this->_id}");
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

        $cantidad_personas = Persona_L::obtenerPorHorariodeTrabajoCOUNT($this->_id, HORARIO_ROTATIVO);
        if ($cantidad_personas == 0) {
            // elimino el registo de un hora_trabajo
            $resultado = $cnn->Delete('horarios_rotativos', "hrot_Id = " . $this->_id);
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
        $array['fecha_inicio'] = $this->_fecha_inicio;

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
        if(array_key_exists('fecha_inicio',$p_Datos))$this::setFechaInicio((string)$p_Datos["fecha_inicio"],"Y-m-d H:i:s");

    }



}
