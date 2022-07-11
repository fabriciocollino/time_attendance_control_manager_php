<?php

/*
 * Usuario (Object)
 */

class Huella_O
{

    private $_id;
//datos
    private $_per_id;
    private $_dedo;
    private $_datos;
    private $_datos_size;
    private $_enabled;
    private $_empresa;
    private $_fecha_mod;
//error
    private $_errores;

    public function __construct() {
        $this->_id = 0; //int(11)
//datos
        $this->_per_id = 0; //int(11)
        $this->_dedo = 0; //int(11)
        $this->_datos = ''; //BLOB
        $this->_datos_size = 0;
        $this->_enabled = 0;
        $this->_empresa = 1;
        $this->_eliminada = 0;
        $this->_fecha_mod = 0;
//error
        $this->_errores = array();
    }


    public function getId() {
        return $this->_id;
    }


    public function getPerId() {
        return $this->_per_id;
    }

    public function setPerId($p_PerId) {
        $p_PerId = (integer)$p_PerId;
        $this->_per_id = $p_PerId;
    }

    public function getDatosSize() {
        return $this->_datos_size;
    }

    public function getDatos() {
        return $this->_datos;
    }

    public function setDatos($p_Datos) {
        $this->_datos = $p_Datos;
        $this->_datos_size = 1;  //hago esto para engañar el sistema sync.  despues la variable esta se carga desde el sql.
    }


    public function getDedo() {
        return $this->_dedo;
    }

    public function setDedo($p_Dedo) {
        $this->_dedo = (integer)$p_Dedo;
    }

    public function getEmpresa() {
        return $this->_empresa;
    }

    public function setEmpresa($p_Empresa) {
        $p_Empresa = (integer)$p_Empresa;
        $this->_empresa = $p_Empresa;
    }

    public function getEnabled() {
        return $this->_enabled;
    }

    public function setEnabled($p_Parm) {
        $p_Parm = (integer)$p_Parm;
        $this->_enabled = $p_Parm;
    }

    public function getEliminada() {
        return $this->_eliminada;
    }

    public function setEliminada($p_Eliminada) {
        $p_Eliminada = (integer)$p_Eliminada;
        $this->_eliminada = $p_Eliminada;
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
        //Si el array errores no tiene elementos entonces el objeto es valido.

        return count($this->_errores) == 0;
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function setErrores($p_Nombre, $p_Error) {
        $this->_errores[$p_Nombre] = trim($p_Error);
    }

    public function loadArray($p_Datos) {
        $this->_id = (integer)$p_Datos["hue_Id"];
//datos
        $this->_per_id = (integer)$p_Datos["hue_Per_Id"];
        $this->_dedo = (integer)$p_Datos["hue_Dedo"];
        $this->_datos = isset ($p_Datos["hue_Datos"]) ? $p_Datos["hue_Datos"] : '';
        $this->_datos_size = isset ($p_Datos["LENGTH(hue_Datos)"]) ? $p_Datos["LENGTH(hue_Datos)"] : '';
//control
        $this->_enabled = (integer)$p_Datos["hue_Enabled"];
        $this->_eliminada = (integer)$p_Datos["hue_Eliminada"];
        $this->_fecha_mod = (string) $p_Datos["hue_Fecha_Mod"];
    }


    public function save($p_Debug = 'Off') {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $datos = array(
            'hue_Id' => $this->_id,
            'hue_Dedo' => $this->_dedo,
            'hue_Per_Id' => $this->_per_id,
            'hue_Datos' => $this->_datos,
            'hue_Enabled' => $this->_enabled,
            'hue_Eliminada' => $this->_eliminada,
            'hue_Fecha_Mod' => $this->_fecha_mod
        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('huellas', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('huellas', $datos, "hue_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;

    }


    public function delete($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        if ($this->_id == 0) {
            return false;
        }

        $this->_eliminada = 1;
        $datos['hue_Eliminada'] = 1;

        $this->_fecha_mod = date("Y-m-d H:i:s");
        $datos['hue_Fecha_Mod'] = $this->_fecha_mod;


        //TODO: purgear

        $resultado = $cnn->Update('huellas', $datos, "hue_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }


    public function purge($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }
        $resultado = '';

        $resultado = $cnn->Delete('huellas', "hue_Id = " . $this->_id);


        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
        return true;
    }



    /**
     * Devuelve un array con algunos datos de la huella
     * Se utiliza en la API
     *
     * @param $incluir_datos Bool incluye o no el capo datos. Si no lo incluye, envia 1 o 0 segun si realmente hay datos o no.
     *
     * @return array()
     */
    public function toArray($incluir_datos = true) {
        $array = array();
        $array['id'] = $this->_id;
        $array['persona'] = $this->_per_id;
        $array['dedo'] = $this->_dedo;
        if($incluir_datos) {
            $array['datos'] = $this->_datos;
        }
        else{
            if($this->_datos_size>0)
                $array['datos'] = 1;
            else
                $array['datos'] = 0;
        }

        $array['enabled'] = $this->_enabled;
        $array['empresa'] = $this->_empresa;
        $array['eliminada'] = $this->_eliminada;


        return $array;
    }

    /**
     * Actualiza algunos datos de la persona desde un array
     * Se utiliza en la API
     *
     * @param $p_Datos array()
     *
     * @return array()
     */
    public function fromArray($p_Datos) {


        if(array_key_exists('persona',$p_Datos))$this::setPerId((integer)$p_Datos["persona"]);
        if(array_key_exists('dedo',$p_Datos))$this::setDedo((integer)$p_Datos["dedo"]);
        if(array_key_exists('datos',$p_Datos))$this::setDatos((string)$p_Datos["datos"]);
        if(array_key_exists('enabled',$p_Datos))$this::setEnabled((integer)$p_Datos["enabled"]);
        if(array_key_exists('empresa',$p_Datos))$this::setEmpresa((integer)$p_Datos["empresa"]);
        if(array_key_exists('eliminada',$p_Datos))$this::setEliminada((integer)$p_Datos["eliminada"]);



    }


    /**
     * Devuelve un array con los datos de la persona para sync
     * Se utiliza en el proceso de sincronizacion
     *
     * @return array()
     */
    public function toSyncArray() {
        $array = array();
        $array['hue_Id'] = $this->_id;
        $array['hue_Per_Id'] = $this->_per_id;
        $array['hue_Dedo'] = $this->_dedo;
        $array['hue_Datos'] = $this->_datos;
        $array['hue_Enabled'] = $this->_enabled;
        $array['hue_Empresa'] = $this->_empresa;
        $array['hue_Eliminada'] = $this->_eliminada;
        $array['hue_Fecha_Mod'] = strtotime($this->_fecha_mod);

        return $array;
    }

    /**
     * Actualiza los datos de la persona desde un array
     * Se utiliza en el proceso de sincronizacion
     *
     * @param $p_Datos array()
     *
     * @return array()
     */
    public function fromSyncArray($p_Datos) {


        if(array_key_exists('hue_Per_Id',$p_Datos))$this::setPerId((integer)$p_Datos["hue_Per_Id"]);
        if(array_key_exists('hue_Dedo',$p_Datos))$this::setDedo((integer)$p_Datos["hue_Dedo"]);
        if(array_key_exists('hue_Datos',$p_Datos))$this::setDatos((string)$p_Datos["hue_Datos"]);
        if(array_key_exists('hue_Enabled',$p_Datos))$this::setEnabled((integer)$p_Datos["hue_Enabled"]);
        if(array_key_exists('hue_Empresa',$p_Datos))$this::setEmpresa((integer)$p_Datos["hue_Empresa"]);
        if(array_key_exists('hue_Eliminada',$p_Datos))$this::setEliminada((integer)$p_Datos["hue_Eliminada"]);
        if(array_key_exists('hue_Fecha_Mod',$p_Datos))$this::setFechaMod((integer)$p_Datos["hue_Fecha_Mod"]);

    }

}
