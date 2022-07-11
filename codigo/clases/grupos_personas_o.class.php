<?php

class Grupos_Personas_O
{

    private $_id;
    private $_grupo;
    private $_persona;
    private $_fecha_mod;


    private $_errores;

    public function __construct() {
        $this->_id = 0;
        $this->_grupo = 0;
        $this->_persona = 0;
        $this->_fecha_mod = 0;

        $this->_errores = array();
    }

    public function getId() {
        return $this->_id;
    }


    public function getGrupo() {
        return $this->_grupo;
    }

    public function setGrupo($p_grupo) {
        $p_grupo = (integer)$p_grupo;
        $this->_grupo = $p_grupo;
    }

    public function getPersona() {
        return $this->_persona;
    }

    public function setPersona($p_persona) {
        $p_persona = (integer)$p_persona;
        $this->_persona = $p_persona;
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


        //Si el array errores no tiene elementos entonces el objeto es valido.
        return count($this->_errores) == 0;
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos) {

        $this->_id = (integer)$p_Datos["gpe_Id"];
        $this->_grupo = (integer)$p_Datos["gpe_Grupo_Id"];
        $this->_persona = (integer)$p_Datos["gpe_Per_Id"];
        $this->_fecha_mod = (string)$p_Datos["gpe_Fecha_Mod"];

    }

    public function save($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $datos = array(
            'gpe_Grupo_Id' => $this->_grupo,
            'gpe_Per_Id' => $this->_persona,
            'gpe_Fecha_Mod' => $this->_fecha_mod
        );

        if (is_null(Grupos_Personas_L::obtenerPorPerIdyGrupo($this->_persona, $this->_grupo))) {
//guardo solo si no existe un registro
            if ($this->_id == 0) {
                $resultado = $cnn->Insert('grupos_personas', $datos);
                if ($resultado !== false) {
                    $this->_id = $cnn->Devolver_Insert_Id();
                }
            } else {
                $resultado = $cnn->Update('notificaciones_personas', $datos, "gpe_Id = {$this->_id}");
            }

            if ($resultado === false) {
                $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            }
        } else {
            $resultado = "el registro ya existe";
        }


        return $resultado;
    }

    public function delete($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($cnn->Delete('grupos_personas', "gpe_Id = {$this->_id}")) {
            return true;
        } else {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
    }

}
