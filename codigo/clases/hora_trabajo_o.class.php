<?php

//días = ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"];
// $semanaArray = array( "Mon" => "Lun.", "Tue" => "Mar.", "Wed" => "Mié.", "Thu" => "Jue.", "Fri" => "Vie.", "Sat" => "Sáb.", "Sun" => "Dom.")
/**
 * Hora Trabajo (Object)
 *
 */
class Hora_Trabajo_O
{

    private $_id;
    private $_detalle;

    private $_lun_inicio;
    private $_lun_fin;
    private $_mar_inicio;
    private $_mar_fin;
    private $_mie_inicio;
    private $_mie_fin;
    private $_jue_inicio;
    private $_jue_fin;
    private $_vie_inicio;
    private $_vie_fin;
    private $_sab_inicio;
    private $_sab_fin;
    private $_dom_inicio;
    private $_dom_fin;
    private $_errores;
    private $_eliminado;
    private $_fecha_mod;

    public function __construct() {
        $this->_id = 0;
        $this->_detalle = ''; // varchar(255)


        $this->_lun_inicio = strtotime('00:00:00'); //time
        $this->_lun_fin = strtotime('00:00:00'); //time

        $this->_mar_inicio = strtotime('00:00:00'); //time
        $this->_mar_fin = strtotime('00:00:00'); //time

        $this->_mie_inicio = strtotime('00:00:00'); //time
        $this->_mie_fin = strtotime('00:00:00'); //time

        $this->_jue_inicio = strtotime('00:00:00'); //time
        $this->_jue_fin = strtotime('00:00:00'); //time

        $this->_vie_inicio = strtotime('00:00:00'); //time
        $this->_vie_fin = strtotime('00:00:00'); //time

        $this->_sab_inicio = strtotime('00:00:00'); //time
        $this->_sab_fin = strtotime('00:00:00'); //time

        $this->_dom_inicio = strtotime('00:00:00'); //time
        $this->_dom_fin = strtotime('00:00:00'); //time

        $this->_errores = array();

        $this->_fecha_mod = 0;
    }

    public function getId() {
        return $this->_id;
    }

    public function getDetalle() {
        return $this->_detalle;
    }

    public function setDetalle($p_Detalle) {
        $p_Detalle = trim($p_Detalle);
        $this->_detalle = $p_Detalle;

        $o_Detalle_Existente = Hora_Trabajo_L::obtenerPorDetalle($this->_detalle, $this->_id);
        if ($this->_detalle == '') {
            $this->_errores['detalle'] = _('Debe proporcionar el detalle del horario de trabajo.');
        } elseif (strlen($this->_detalle) < 4) {
            $this->_errores['detalle'] = _('El detalle del horario de trabajo es demasiado corto.');
        } elseif (strlen($this->_detalle) > 255) {
            $this->_errores['detalle'] = _('El detalle del horario de trabajo no debe superar los 255 caracteres.');
        } elseif (!is_null($o_Detalle_Existente)) {
            $this->_errores['detalle'] = _('El Horario') . ' \'' . $this->_detalle . '\' ' . _('ya existe.');
        }
    }


    public function getHsInicioLun($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_lun_inicio)) {
                return '';
            } else {
                return date($p_Format, $this->_lun_inicio);
            }
        }
        return $this->_lun_inicio;
    }

    public function setHsInicioLun($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_lun_inicio = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_lun_inicio === false) {
                $this->_errores['hs_inicio_lun'] = _('La Hora Inicio es incorrecta.');
                $this->_lun_inicio = null;
            }
        } else {
            $this->_lun_inicio = '00:00:00';
        }
    }

    public function getHsFinLun($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_lun_fin)) {
                return '';
            } else {
                return date($p_Format, $this->_lun_fin);
            }
        }
        return $this->_lun_fin;
    }

    public function setHsFinLun($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_lun_fin = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_lun_fin === false) {
                $this->_errores['hs_fin_lun'] = _('La Hora Fin es incorrecta.');
                $this->_lun_fin = null;
            }
        } else {
            $this->_lun_fin = '00:00:00';
        }
    }

    public function getHsInicioMar($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_mar_inicio)) {
                return '';
            } else {
                return date($p_Format, $this->_mar_inicio);
            }
        }
        return $this->_mar_inicio;
    }

    public function setHsInicioMar($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_mar_inicio = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_mar_inicio === false) {
                $this->_errores['hs_inicio_mar'] = _('La Hora Inicio es incorrecta.');
                $this->_mar_inicio = null;
            }
        } else {
            $this->_mar_inicio = '00:00:00';
        }
    }

    public function getHsFinMar($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_mar_fin)) {
                return '';
            } else {
                return date($p_Format, $this->_mar_fin);
            }
        }
        return $this->_mar_fin;
    }

    public function setHsFinMar($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_mar_fin = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_mar_fin === false) {
                $this->_errores['hs_fin_mar'] = _('La Hora Fin es incorrecta.');
                $this->_mar_fin = null;
            }
        } else {
            $this->_mar_fin = '00:00:00';
        }
    }

    public function getHsInicioMie($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_mie_inicio)) {
                return '';
            } else {
                return date($p_Format, $this->_mie_inicio);
            }
        }
        return $this->_mie_inicio;
    }

    public function setHsInicioMie($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_mie_inicio = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_mie_inicio === false) {
                $this->_errores['hs_inicio_mie'] = _('La Hora Inicio es incorrecta.');
                $this->_mie_inicio = null;
            }
        } else {
            $this->_mie_inicio = '00:00:00';
        }
    }

    public function getHsFinMie($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_mie_fin)) {
                return '';
            } else {
                return date($p_Format, $this->_mie_fin);
            }
        }
        return $this->_mie_fin;
    }

    public function setHsFinMie($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_mie_fin = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_mie_fin === false) {
                $this->_errores['hs_fin_mie'] = _('La Hora Fin es incorrecta.');
                $this->_mie_fin = null;
            }
        } else {
            $this->_mie_fin = '00:00:00';
        }
    }

    public function getHsInicioJue($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_jue_inicio)) {
                return '';
            } else {
                return date($p_Format, $this->_jue_inicio);
            }
        }
        return $this->_jue_inicio;
    }

    public function setHsInicioJue($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_jue_inicio = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_jue_inicio === false) {
                $this->_errores['hs_inicio_jue'] = _('La Hora Inicio es incorrecta.');
                $this->_jue_inicio = null;
            }
        } else {
            $this->_jue_inicio = '00:00:00';
        }
    }

    public function getHsFinJue($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_jue_fin)) {
                return '';
            } else {
                return date($p_Format, $this->_jue_fin);
            }
        }
        return $this->_jue_fin;
    }

    public function setHsFinJue($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_jue_fin = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_jue_fin === false) {
                $this->_errores['hs_fin_jue'] = _('La Hora Fin es incorrecta.');
                $this->_jue_fin = null;
            }
        } else {
            $this->_jue_fin = '00:00:00';
        }
    }

    public function getHsInicioVie($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_vie_inicio)) {
                return '';
            } else {
                return date($p_Format, $this->_vie_inicio);
            }
        }
        return $this->_vie_inicio;
    }

    public function setHsInicioVie($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_vie_inicio = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_vie_inicio === false) {
                $this->_errores['hs_inicio_vie'] = _('La Hora Inicio es incorrecta.');
                $this->_vie_inicio = null;
            }
        } else {
            $this->_vie_inicio = '00:00:00';
        }
    }

    public function getHsFinVie($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_vie_fin)) {
                return '';
            } else {
                return date($p_Format, $this->_vie_fin);
            }
        }
        return $this->_vie_fin;
    }

    public function setHsFinVie($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_vie_fin = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_vie_fin === false) {
                $this->_errores['hs_fin_vie'] = _('La Hora Fin es incorrecta.');
                $this->_vie_fin = null;
            }
        } else {
            $this->_vie_fin = '00:00:00';
        }
    }

    public function getHsInicioSab($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_sab_inicio)) {
                return '';
            } else {
                return date($p_Format, $this->_sab_inicio);
            }
        }
        return $this->_sab_inicio;
    }

    public function setHsInicioSab($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_sab_inicio = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_sab_inicio === false) {
                $this->_errores['hs_inicio_sab'] = _('La Hora Inicio es incorrecta.');
                $this->_sab_inicio = null;
            }
        } else {
            $this->_sab_inicio = '00:00:00';
        }
    }

    public function getHsFinSab($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_sab_fin)) {
                return '';
            } else {
                return date($p_Format, $this->_sab_fin);
            }
        }
        return $this->_sab_fin;
    }

    public function setHsFinSab($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_sab_fin = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_sab_fin === false) {
                $this->_errores['hs_fin_sab'] = _('La Hora Fin es incorrecta.');
                $this->_sab_fin = null;
            }
        } else {
            $this->_sab_fin = '00:00:00';
        }
    }

    public function getHsInicioDom($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_dom_inicio)) {
                return '';
            } else {
                return date($p_Format, $this->_dom_inicio);
            }
        }
        return $this->_dom_inicio;
    }

    public function setHsInicioDom($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_dom_inicio = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_dom_inicio === false) {
                $this->_errores['hs_inicio_dom'] = _('La Hora Inicio es incorrecta.');
                $this->_dom_inicio = null;
            }
        } else {
            $this->_dom_inicio = '00:00:00';
        }
    }

    public function getHsFinDom($p_Format = null) {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_null($this->_dom_fin)) {
                return '';
            } else {
                return date($p_Format, $this->_dom_fin);
            }
        }
        return $this->_dom_fin;
    }

    public function setHsFinDom($p_Hora, $p_Format) {
        if ($p_Hora != '00:00:00') {
            $this->_dom_fin = DateTimeHelper::ValidarHora($p_Hora, $p_Format);
            if ($this->_dom_fin === false) {
                $this->_errores['hs_fin_dom'] = _('La Hora Inicio es incorrecta.');
                $this->_dom_fin = null;
            }
        } else {
            $this->_dom_fin = '00:00:00';
        }
    }

    public function getHsInicioHoy($p_format = null) {
        $hoy = date('w');
        switch ($hoy) {
            case 0:
                return $this->getHsInicioDom($p_format);
                break;
            case 1:
                return $this->getHsInicioLun($p_format);
                break;
            case 2:
                return $this->getHsInicioMar($p_format);
                break;
            case 3:
                return $this->getHsInicioMie($p_format);
                break;
            case 4:
                return $this->getHsInicioJue($p_format);
                break;
            case 5:
                return $this->getHsInicioVie($p_format);
                break;
            case 6:
                return $this->getHsInicioSab($p_format);
                break;
        }
    }

    public function getHsFinHoy($p_format = null) {
        $hoy = date('w');
        switch ($hoy) {
            case 0:
                return $this->getHsFinDom($p_format);
                break;
            case 1:
                return $this->getHsFinLun($p_format);
                break;
            case 2:
                return $this->getHsFinMar($p_format);
                break;
            case 3:
                return $this->getHsFinMie($p_format);
                break;
            case 4:
                return $this->getHsFinJue($p_format);
                break;
            case 5:
                return $this->getHsFinVie($p_format);
                break;
            case 6:
                return $this->getHsFinSab($p_format);
                break;
        }
    }

    public function getArrayDias() {
        $a_dias = array(
            1 => array($this->_dom_inicio, $this->_dom_fin),
            2 => array($this->_lun_inicio, $this->_lun_fin),
            3 => array($this->_mar_inicio, $this->_mar_fin),
            4 => array($this->_mie_inicio, $this->_mie_fin),
            5 => array($this->_jue_inicio, $this->_jue_fin),
            6 => array($this->_vie_inicio, $this->_vie_fin),
            7 => array($this->_sab_inicio, $this->_sab_fin)
        );
        return $a_dias;
    }

    public function getArrayDiasString() {
        $a_dias = array(
            0 => array(date('H:i:s', $this->_dom_inicio), date('H:i:s', $this->_dom_fin)),
            1 => array(date('H:i:s', $this->_lun_inicio), date('H:i:s', $this->_lun_fin)),
            2 => array(date('H:i:s', $this->_mar_inicio), date('H:i:s', $this->_mar_fin)),
            3 => array(date('H:i:s', $this->_mie_inicio), date('H:i:s', $this->_mie_fin)),
            4 => array(date('H:i:s', $this->_jue_inicio), date('H:i:s', $this->_jue_fin)),
            5 => array(date('H:i:s', $this->_vie_inicio), date('H:i:s', $this->_vie_fin)),
            6 => array(date('H:i:s', $this->_sab_inicio), date('H:i:s', $this->_sab_fin))
        );
        return $a_dias;
    }

    public function getTextoDias($a_texto_dias, $p_Format = null) {
        $texto = '';
        foreach ($this->getArrayDias() as $key => $value) {
            if (!is_null($value[0]) && !is_null($value[1])) {
                $texto .= $a_texto_dias[$key] . ': ' . date('H:i', $value[0]) . ' - ' . date('H:i', $value[1]) . ' <br /> ';
            }
        }
        return $texto;
    }

    public function getTextoDiasResumido($a_texto_dias) {
        $texto = '';
        $a_temp = array();
        foreach ($this->getArrayDias() as $key => $value) {
            if (!is_null($value[0]) && date('H:i', $value[0]) != '00:00' || !is_null($value[1]) && date('H:i', $value[1]) != '00:00') {
                $inidice = date('H:i', $value[0]) . '.' . date('H:i', $value[1]);
                if (!isset($a_temp[$inidice]['dias'])) {
                    $a_temp[$inidice]['dias'] = $a_texto_dias[$key] . ', ';
                } else {
                    $a_temp[$inidice]['dias'] .= $a_texto_dias[$key] . ', ';
                }
                $a_temp[$inidice]['hora_inicio'] = $value[0];
                $a_temp[$inidice]['hora_fin'] = $value[1];
            }
        }
        foreach ($a_temp as $value) {
            $texto .= rtrim($value['dias'], ', ') . ' - ' . date('H:i', $value['hora_inicio']) . ' - ' . date('H:i', $value['hora_fin']) . '<br />';
        }
        return $texto;
    }

    public function getCantPersonas() {
        return Persona_L::obtenerPorHorariodeTrabajoCOUNT($this->_id);
    }

    public function getCantPersonasHoy() {
        if ($this->getHsInicioHoy('H:i') != '00:00' && $this->getHsFinHoy('H:i') != '00:00')
            return Persona_L::obtenerPorHorariodeTrabajoCOUNT($this->_id);
        else
            return 0;
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

        if ($this->_lun_inicio != '' && $this->_lun_fin != '' || $this->_lun_inicio == '' && $this->_lun_fin == '') {
            // fecha bien
        } elseif ($this->_lun_inicio == '') {
            $this->_errores['hs_inicio_lun'] = _('Falta Hora Inicio.');
        } else {
            $this->_errores['hs_fin_lun'] = _('Falta Hora Fin.');
        }

        if ($this->_mar_inicio != '' && $this->_mar_fin != '' || $this->_mar_inicio == '' && $this->_mar_fin == '') {
            // fecha bien
        } elseif ($this->_mar_inicio == '') {
            $this->_errores['hs_inicio_mar'] = _('Falta Hora Inicio.');
        } else {
            $this->_errores['hs_fin_mar'] = _('Falta Hora Fin.');
        }

        if ($this->_mie_inicio != '' && $this->_mie_fin != '' || $this->_mie_inicio == '' && $this->_mie_fin == '') {
            // fecha bien
        } elseif ($this->_mie_inicio == '') {
            $this->_errores['hs_inicio_mie'] = _('Falta Hora Inicio.');
        } else {
            $this->_errores['hs_fin_mie'] = _('Falta Hora Fin.');
        }

        if ($this->_jue_inicio != '' && $this->_jue_fin != '' || $this->_jue_inicio == '' && $this->_jue_fin == '') {
            // fecha bien
        } elseif ($this->_jue_inicio == '') {
            $this->_errores['hs_inicio_jue'] = _('Falta Hora Inicio.');
        } else {
            $this->_errores['hs_fin_jue'] = _('Falta Hora Fin.');
        }

        if ($this->_vie_inicio != '' && $this->_vie_fin != '' || $this->_vie_inicio == '' && $this->_vie_fin == '') {
            // fecha bien
        } elseif ($this->_vie_inicio == '') {
            $this->_errores['hs_inicio_vie'] = _('Falta Hora Inicio.');
        } else {
            $this->_errores['hs_fin_vie'] = _('Falta Hora Fin.');
        }

        if ($this->_sab_inicio != '' && $this->_sab_fin != '' || $this->_sab_inicio == '' && $this->_sab_fin == '') {
            // fecha bien
        } elseif ($this->_sab_inicio == '') {
            $this->_errores['hs_inicio_sab'] = _('Falta Hora Inicio.');
        } else {
            $this->_errores['hs_fin_sab'] = _('Falta Hora Fin.');
        }

        if ($this->_dom_inicio != '' && $this->_dom_fin != '' || $this->_dom_inicio == '' && $this->_dom_fin == '') {
            // fecha bien
        } elseif ($this->_dom_inicio == '') {
            $this->_errores['hs_inicio_dom'] = _('Falta Hora Inicio.');
        } else {
            $this->_errores['hs_fin_dom'] = _('Falta Hora Fin.');
        }

        return count($this->_errores) == 0;
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos) {

        $this->_id = (integer)$p_Datos["hor_Id"];
        $this->_detalle = (string)$p_Datos["hor_Detalle"];


        //	$this->_inicio = strtotime($p_Datos["hor_Inicio"]);
        //	$this->_fin = strtotime($p_Datos["hor_Fin"]);

        $this->_lun_inicio = (is_null($p_Datos["hor_Inicio_Lun"])) ? null : strtotime($p_Datos["hor_Inicio_Lun"]);
        $this->_lun_fin = (is_null($p_Datos["hor_Fin_Lun"])) ? null : strtotime($p_Datos["hor_Fin_Lun"]);

        $this->_mar_inicio = (is_null($p_Datos["hor_Inicio_Mar"])) ? null : strtotime($p_Datos["hor_Inicio_Mar"]);
        $this->_mar_fin = (is_null($p_Datos["hor_Fin_Mar"])) ? null : strtotime($p_Datos["hor_Fin_Mar"]);

        $this->_mie_inicio = (is_null($p_Datos["hor_Inicio_Mie"])) ? null : strtotime($p_Datos["hor_Inicio_Mie"]);
        $this->_mie_fin = (is_null($p_Datos["hor_Fin_Mie"])) ? null : strtotime($p_Datos["hor_Fin_Mie"]);

        $this->_jue_inicio = (is_null($p_Datos["hor_Inicio_Jue"])) ? null : strtotime($p_Datos["hor_Inicio_Jue"]);
        $this->_jue_fin = (is_null($p_Datos["hor_Fin_Jue"])) ? null : strtotime($p_Datos["hor_Fin_Jue"]);

        $this->_vie_inicio = (is_null($p_Datos["hor_Inicio_Vie"])) ? null : strtotime($p_Datos["hor_Inicio_Vie"]);
        $this->_vie_fin = (is_null($p_Datos["hor_Fin_Vie"])) ? null : strtotime($p_Datos["hor_Fin_Vie"]);

        $this->_sab_inicio = (is_null($p_Datos["hor_Inicio_Sab"])) ? null : strtotime($p_Datos["hor_Inicio_Sab"]);
        $this->_sab_fin = (is_null($p_Datos["hor_Fin_Sab"])) ? null : strtotime($p_Datos["hor_Fin_Sab"]);

        $this->_dom_inicio = (is_null($p_Datos["hor_Inicio_Dom"])) ? null : strtotime($p_Datos["hor_Inicio_Dom"]);
        $this->_dom_fin = (is_null($p_Datos["hor_Fin_Dom"])) ? null : strtotime($p_Datos["hor_Fin_Dom"]);

        $this->_fecha_mod = (string) $p_Datos["hor_Fecha_Mod"];
    }

    public function save($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $datos = array(
            'hor_Detalle' => $this->_detalle,

            'hor_Inicio_Lun' => (is_null($this->_lun_inicio)) ? strtotime('00:00:00') : date('H:i', $this->_lun_inicio),
            'hor_Fin_Lun' => (is_null($this->_lun_fin)) ? strtotime('00:00:00') : date('H:i', $this->_lun_fin),
            'hor_Inicio_Mar' => (is_null($this->_mar_inicio)) ? strtotime('00:00:00') : date('H:i', $this->_mar_inicio),
            'hor_Fin_Mar' => (is_null($this->_mar_fin)) ? strtotime('00:00:00') : date('H:i', $this->_mar_fin),
            'hor_Inicio_Mie' => (is_null($this->_mie_inicio)) ? strtotime('00:00:00') : date('H:i', $this->_mie_inicio),
            'hor_Fin_Mie' => (is_null($this->_mie_fin)) ? strtotime('00:00:00') : date('H:i', $this->_mie_fin),
            'hor_Inicio_Jue' => (is_null($this->_jue_inicio)) ? strtotime('00:00:00') : date('H:i', $this->_jue_inicio),
            'hor_Fin_Jue' => (is_null($this->_jue_fin)) ? strtotime('00:00:00') : date('H:i', $this->_jue_fin),
            'hor_Inicio_Vie' => (is_null($this->_vie_inicio)) ? strtotime('00:00:00') : date('H:i', $this->_vie_inicio),
            'hor_Fin_Vie' => (is_null($this->_vie_fin)) ? strtotime('00:00:00') : date('H:i', $this->_vie_fin),
            'hor_Inicio_Sab' => (is_null($this->_sab_inicio)) ? strtotime('00:00:00') : date('H:i', $this->_sab_inicio),
            'hor_Fin_Sab' => (is_null($this->_sab_fin)) ? strtotime('00:00:00') : date('H:i', $this->_sab_fin),
            'hor_Inicio_Dom' => (is_null($this->_dom_inicio)) ? strtotime('00:00:00') : date('H:i', $this->_dom_inicio),
            'hor_Fin_Dom' => (is_null($this->_dom_fin)) ? strtotime('00:00:00') : date('H:i', $this->_dom_fin),
            'hor_Fecha_Mod' => $this->_fecha_mod
        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('hora_trabajo', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('hora_trabajo', $datos, "hor_Id = {$this->_id}");
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
        $resultado = '';

        $cantidad_personas = Persona_L::obtenerPorHorariodeTrabajoCOUNT($this->_id, HORARIO_NORMAL);

        if ($cantidad_personas == 0) {
            $cantidad_hor_flexibles = Horario_Flexible_L::obtenerCantidadHorarioNormal($this->_id);
            if ($cantidad_hor_flexibles == 0) {
                $cantidad_hor_rotativos = Horario_Rotativo_L::obtenerCantidadHorarioNormal($this->_id);
                if ($cantidad_hor_rotativos == 0) {
                    // elimino el registo de un hora_trabajo
                    $resultado = $cnn->Delete('hora_trabajo', "hor_Id = " . $this->_id);
                } else {
                    $this->_errores['horarios'] = _('Hay uno o más horarios Rotativos que tienen asignado este horario.');
                    return false;
                }
            } else {
                $this->_errores['horarios'] = _('Hay uno o más horarios Flexibles que tienen asignado este horario.');
                return false;
            }

        } else {
            $this->_errores['personas'] = _('Hay una o más personas asignadas a este horario de trabajo, no se puede borrar hasta que todas las personas sean reasignadas.');
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
        $array['inicio_lunes'] = $this->_lun_inicio;
        $array['fin_lunes'] = $this->_lun_fin;
        $array['inicio_martes'] = $this->_mar_inicio;
        $array['fin_martes'] = $this->_mar_fin;
        $array['inicio_miercoles'] = $this->_mie_inicio;
        $array['fin_miercoles'] = $this->_mie_fin;
        $array['inicio_jueves'] = $this->_jue_inicio;
        $array['fin_jueves'] = $this->_jue_fin;
        $array['inicio_viernes'] = $this->_vie_inicio;
        $array['fin_viernes'] = $this->_vie_fin;
        $array['inicio_sabado'] = $this->_sab_inicio;
        $array['fin_sabado'] = $this->_sab_fin;
        $array['inicio_domingo'] = $this->_dom_inicio;
        $array['fin_domingo'] = $this->_dom_fin;

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
        if(array_key_exists('inicio_lunes',$p_Datos))$this::setHsInicioLun((string)$p_Datos["inicio_lunes"],"H:i:s");
        if(array_key_exists('fin_lunes',$p_Datos))$this::setHsFinLun((string)$p_Datos["fin_lunes"],"H:i:s");
        if(array_key_exists('inicio_martes',$p_Datos))$this::setHsInicioMar((string)$p_Datos["inicio_martes"],"H:i:s");
        if(array_key_exists('fin_martes',$p_Datos))$this::setHsFinMar((string)$p_Datos["fin_martes"],"H:i:s");
        if(array_key_exists('inicio_miercoles',$p_Datos))$this::setHsInicioMie((string)$p_Datos["inicio_miercoles"],"H:i:s");
        if(array_key_exists('fin_miercoles',$p_Datos))$this::setHsFinMie((string)$p_Datos["fin_miercoles"],"H:i:s");
        if(array_key_exists('inicio_jueves',$p_Datos))$this::setHsInicioJue((string)$p_Datos["inicio_jueves"],"H:i:s");
        if(array_key_exists('fin_jueves',$p_Datos))$this::setHsFinJue((string)$p_Datos["fin_jueves"],"H:i:s");
        if(array_key_exists('inicio_viernes',$p_Datos))$this::setHsInicioVie((string)$p_Datos["inicio_viernes"],"H:i:s");
        if(array_key_exists('fin_viernes',$p_Datos))$this::setHsFinVie((string)$p_Datos["fin_viernes"],"H:i:s");
        if(array_key_exists('inicio_sabado',$p_Datos))$this::setHsInicioSab((string)$p_Datos["inicio_sabado"],"H:i:s");
        if(array_key_exists('fin_sabado',$p_Datos))$this::setHsFinSab((string)$p_Datos["fin_sabado"],"H:i:s");
        if(array_key_exists('inicio_domingo',$p_Datos))$this::setHsInicioDom((string)$p_Datos["inicio_domingo"],"H:i:s");
        if(array_key_exists('fin_domingo',$p_Datos))$this::setHsFinDom((string)$p_Datos["fin_domingo"],"H:i:s");


    }


    /**
     * Devuelve un array con los datos del horario para sync
     * Se utiliza en el proceso de sincronizacion
     *
     * @return array()
     */
    public function toSyncArray() {
        $array = array();

        $array['hor_Id'] = $this->_id;
        $array['hor_Detalle'] = $this->_detalle;
        $array['hor_Inicio_Lun'] = $this->_lun_inicio;
        $array['hor_Fin_Lun'] = $this->_lun_fin;
        $array['hor_Inicio_Mar'] = $this->_mar_inicio;
        $array['hor_Fin_Mar'] = $this->_mar_fin;
        $array['hor_Inicio_Mie'] = $this->_mie_inicio;
        $array['hor_Fin_Mie'] = $this->_mie_fin;
        $array['hor_Inicio_Jue'] = $this->_jue_inicio;
        $array['hor_Fin_Jue'] = $this->_jue_fin;
        $array['hor_Inicio_Vie'] = $this->_vie_inicio;
        $array['hor_Fin_Vie'] = $this->_vie_fin;
        $array['hor_Inicio_Sab'] = $this->_sab_inicio;
        $array['hor_Fin_Sab'] = $this->_sab_fin;
        $array['hor_Inicio_Dom'] = $this->_dom_inicio;
        $array['hor_Fin_Dom'] = $this->_dom_fin;
        $array['hor_Fecha_Mod'] = strtotime($this->_fecha_mod);
        $array['hor_Eliminado'] = $this->_eliminado;

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


        if(array_key_exists('hor_Detalle',$p_Datos))$this::setDetalle((string)$p_Datos["hor_Detalle"]);
        if(array_key_exists('hor_Inicio_Lun',$p_Datos))$this::setHsInicioLun((string)$p_Datos["hor_Inicio_Lun"],"H:i:s");
        if(array_key_exists('hor_Fin_Lun',$p_Datos))$this::setHsFinLun((string)$p_Datos["hor_Fin_Lun"],"H:i:s");
        if(array_key_exists('hor_Inicio_Mar',$p_Datos))$this::setHsInicioMar((string)$p_Datos["hor_Inicio_Mar"],"H:i:s");
        if(array_key_exists('hor_Fin_Mar',$p_Datos))$this::setHsFinMar((string)$p_Datos["hor_Fin_Mar"],"H:i:s");
        if(array_key_exists('hor_Inicio_Mie',$p_Datos))$this::setHsInicioMie((string)$p_Datos["hor_Inicio_Mie"],"H:i:s");
        if(array_key_exists('hor_Fin_Mie',$p_Datos))$this::setHsFinMie((string)$p_Datos["hor_Fin_Mie"],"H:i:s");
        if(array_key_exists('hor_Inicio_Jue',$p_Datos))$this::setHsInicioJue((string)$p_Datos["hor_Inicio_Jue"],"H:i:s");
        if(array_key_exists('hor_Fin_Jue',$p_Datos))$this::setHsFinJue((string)$p_Datos["hor_Fin_Jue"],"H:i:s");
        if(array_key_exists('hor_Inicio_Vie',$p_Datos))$this::setHsInicioVie((string)$p_Datos["hor_Inicio_Vie"],"H:i:s");
        if(array_key_exists('hor_Fin_Vie',$p_Datos))$this::setHsFinVie((string)$p_Datos["hor_Fin_Vie"],"H:i:s");
        if(array_key_exists('hor_Inicio_Sab',$p_Datos))$this::setHsInicioSab((string)$p_Datos["hor_Inicio_Sab"],"H:i:s");
        if(array_key_exists('hor_Fin_Sab',$p_Datos))$this::setHsFinSab((string)$p_Datos["hor_Fin_Sab"],"H:i:s");
        if(array_key_exists('hor_Inicio_Dom',$p_Datos))$this::setHsInicioDom((string)$p_Datos["hor_Inicio_Dom"],"H:i:s");
        if(array_key_exists('hor_Fin_Dom',$p_Datos))$this::setHsFinDom((string)$p_Datos["hor_Fin_Dom"],"H:i:s");


    }




}
