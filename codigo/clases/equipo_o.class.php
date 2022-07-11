<?php

/*
 * equipo (Object)
 */

class Equipo_O
{

    private $_id;
    private $_uuid;
    //datos
    private $_detalle;
    private $_ip;
    private $_password;  //password es para el setup inicial
    private $_ubicacion;
    private $_switch;
    private $_puerto;
    private $_bloquear_sync;
    private $_bloquear_updates;
    private $_modo_mantenimiento;
    private $_tipo_red;
    private $_wifi_signal;

    private $_heartbeat;
    //control
    private $_creado_el;
    private $_bloqueado_el;
    private $_eliminado_el;
    //objects
    private $_alaram1_object;
    //error
    private $_errores;

    public function __construct()
    {
        $this->_id = 0; //int(11)
        $this->_uuid = 0; //int(11)
        //datos
        $this->_host = ''; //varchar(20)
        $this->_version = ''; //varchar(30)
        $this->_modelo = 0; //int
        $this->_detalle = ''; //varchar(255)
        $this->_ip = ''; //varchar(39)
        $this->_ubicacion = ''; //varchar(255)
        $this->_switch = ''; //varchar(255)
        $this->_puerto = ''; //varchar(255)
        $this->_bloquear_sync = 0; //int
        $this->_bloquear_updates = 0; //int
        $this->_modo_mantenimiento = 0; //int
        $this->_tipo_red = '';
        $this->_wifi_signal = 0;

        $this->_heartbeat = null;
        //control
        $this->_creado_el = null;
        $this->_bloqueado_el = null;
        $this->_eliminado_el = null;
        //objects
        $this->_alaram1_object = null;
        //error
        $this->_errores = array();
    }

    /*
     * Controla vacio, contidad de caracteres max y min
     */

    private function control($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero = 'o')
    {
        if ($p_valor == '') {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar") . " " . strtolower($p_articulo) . " {$p_texto}.";
        } elseif (strlen($p_valor) < $p_min) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("es demasiado corto.");
        } elseif (strlen($p_valor) > $p_max) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("no debe superar los {$p_max} caracteres.");
        }
    }

    private function control_2($p_valor, $p_nombre, $p_texto, $p_min, $p_max)
    {
        if ($p_valor !== '') {
            if (strlen($p_valor) < $p_min) {
                $this->_errores[ValidateHelper::Cadena($p_nombre)] = "El {$p_texto} " . _("especificado es demasiado corto.");
            } elseif (strlen($p_valor) > $p_max) {
                $this->_errores[ValidateHelper::Cadena($p_nombre)] = "El {$p_texto} " . _("especificado no debe superar los") . " {$p_max} " . _("caracteres.");
            }
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function resetId()   //usado para mover los equipos, resetea la ID para que cuando se guarde en la otra DB se guarde con la ID q corresponde
    {
        $this->_id=0;
    }

    public function getUUID()
    {
        return $this->_uuid;
    }

    public function setUUID($p_UUID)
    {
        $p_UUID = (integer)$p_UUID;
        $this->_uuid = $p_UUID;
    }


    public function getIp()
    {
        return $this->_ip;
    }

    public function setIp($p_Ip)
    {
        $p_Ip = trim($p_Ip);
        if (Config_L::obtenerPorParametro("equipo_auto_ip")->getValor() == 1) {
            $this->control($p_Ip, 'Ip', 4, 39);
            if (Config_L::obtenerPorParametro("equipo_auto_ip_duplicate_check")->getValor() == 1) {
                if ($p_Ip != '' && !is_null(Equipo_L::obtenerPorIp($p_Ip, $this->_id))) {
                    $this->_errores['ip'] = _('El IP') . ' \'' . $p_Ip . '\' ' . _('ya existe.');
                }
            }
        }
        $this->_ip = $p_Ip;
    }


    public function getVersion()
    {
        return $this->_version;
    }

    public function setVersion($p_Version)
    {
        $p_Version = trim($p_Version);
        $this->control($p_Version, 'Version', 4, 30);
        /* 	if (!is_null(Equipo_L::obtenerPorVersion($p_Version, $this->_id))) {
          $this->_errores['Version'] = 'El número de versión \'' . $p_Version . '\' ya existe.';
          } */
        $this->_version = $p_Version;
    }

    public function getDetalle()
    {
        return $this->_detalle;
    }

    public function setDetalle($p_Detalle)
    {
        $p_Detalle = trim($p_Detalle);
        $this->control($p_Detalle, _('Detalle'), 4, 255);
        if (!is_null(Equipo_L::obtenerPorDetalle($p_Detalle, $this->_id))) {
            $this->_errores['detalle'] = _('El Detalle') . ' \'' . $p_Detalle . '\' ' . _('ya existe.');
        }
        $this->_detalle = $p_Detalle;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function setPassword($p_Password)
    {
        $p_Password = (string)$p_Password;
        $this->_password = $p_Password;
    }

    public function getUbicacion()
    {
        return $this->_ubicacion;
    }

    public function setUbicacion($p_Valor)
    {
        $p_Valor = trim($p_Valor);
        //$this->control_2($p_Valor, 'ubicacion', _('Valor'), 4, 255);
        $this->_ubicacion = $p_Valor;
    }

    public function getSwitch()
    {
        return $this->_switch;
    }

    public function setSwitch($p_Valor)
    {
        $p_Valor = trim($p_Valor);
        //$this->control_2($p_Valor, 'switch', _('Valor'), 4, 255);
        $this->_switch = $p_Valor;
    }

    public function getPuerto()
    {
        return $this->_puerto;
    }

    public function setPuerto($p_Valor)
    {
        $p_Valor = trim($p_Valor);
        //$this->control_2($p_Valor, 'puerto', _('Valor'), 4, 255);
        $this->_puerto = $p_Valor;
    }

    public function getBloquearSync()
    {
        return $this->_bloquear_sync;
    }

    public function setBloquearSync($p_Valor)
    {
        $p_Valor = (integer)$p_Valor;
        $this->_bloquear_sync = $p_Valor;
    }

    public function getLockUpdates()
    {
        return $this->_bloquear_updates;
    }

    public function setLockUpdates($p_Valor)
    {
        $p_Valor = (integer)$p_Valor;
        $this->_bloquear_updates = $p_Valor;
    }

    public function getMaintenanceMode()
    {
        return $this->_modo_mantenimiento;
    }

    public function setMaintenanceMode($p_Valor)
    {
        $p_Valor = (integer)$p_Valor;
        $this->_modo_mantenimiento = $p_Valor;
    }

    public function getHeartbeat($pFormat = null)
    {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_heartbeat)) {
                return '';
            } else {
                return date($pFormat, $this->_heartbeat);
            }
        }
        return $this->_heartbeat;
    }

    public function setHeartbeat($pFecha, $pFormat,$pIgnoreFormat=0)
    {
        if(!$pIgnoreFormat) {
            //Es necesario el DateTimeHelper
            $this->_heartbeat = DateTimeHelper::getTimestampFromFormat($pFecha, $pFormat);
            if ($this->_heartbeat === false) {
                $this->_heartbeat = null;
            }
        }else{
            $this->_heartbeat=$pFecha;
        }
    }

    public function getCreadoEl($pFormat = null)
    {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_creado_el)) {
                return '';
            } else {
                return date($pFormat, $this->_creado_el);
            }
        }
        return $this->_creado_el;
    }

    public function getBloqueadoEl($pFormat = null)
    {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_bloqueado_el)) {
                return '';
            } else {
                return date($pFormat, $this->_bloqueado_el);
            }
        }
        return $this->_bloqueado_el;
    }

    public function getEliminadoEl($pFormat = null)
    {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_eliminado_el)) {
                return '';
            } else {
                return date($pFormat, $this->_eliminado_el);
            }
        }
        return $this->_eliminado_el;
    }

    public function getAlarma1Object()
    {
        if (is_null($this->_alaram1_object) && $this->_alarma1 > 0) {
            $this->_alaram1_object = Alarma_L::obtenerPorId($this->_alarma1);
        }
        return $this->_alaram1_object;
    }

    public function getTipoRed()
    {
        return $this->_tipo_red;
    }

    public function getTipoRed_S()
    {
        switch ($this->_tipo_red) {
            case 'wlan':
                return 'Wifi';
            case 'eth':
                return 'Ethernet';
        }
    }

    public function setTipoRed($p_TipoRed)
    {
        $p_TipoRed = trim($p_TipoRed);
        $this->_tipo_red = $p_TipoRed;
    }

    public function getWifiSignal()
    {
        return $this->_wifi_signal;
    }

    public function setWifiSignal($p_Wifi)
    {
        $p_Wifi = (integer)trim($p_Wifi);
        $this->_wifi_signal = $p_Wifi;
    }

    public function isOnline(){
        $g_temp = (integer)time() - (integer)$this->getHeartbeat('U');
        if ($g_temp < HEARTBEAT_OFFLINE_MARGIN) {
            return true;
        }
        return false;
    }

    public function isOffline(){
        return !$this->isOnline();
    }


    /**
     * Devuelve TRUE/FALSE dependiendo de si el objeto es valido o no.
     *
     * @return boolean
     */
    public function esValido()
    {
        if ($this->_id == 0 || empty($this->_alarma1)) {
            //no pasa nada
        } else {

            // Validadacion alamas


        }
        //Si el array errores no tiene elementos entonces el objeto es valido.
        return count($this->_errores) == 0;
    }

    public function getErrores()
    {
        return $this->_errores;
    }

    public function loadArray($p_Datos)
    {
        $this->_id = (integer)$p_Datos["eq_Id"];
        $this->_uuid = (string)$p_Datos["eq_UUID"];
        //datos
        $this->_detalle = (string)$p_Datos["eq_Detalle"];
        $this->_ip = (string)$p_Datos["eq_Ip"];
        $this->_password = (string)$p_Datos["eq_Password"];
        $this->_heartbeat = (is_null($p_Datos["eq_Heartbeat"])) ? null : strtotime($p_Datos["eq_Heartbeat"]);
        $this->_bloquear_sync = (integer)$p_Datos["eq_Bloquear_Sync"];
        $this->_bloquear_updates = (integer)$p_Datos["eq_Bloquear_Updates"];
        $this->_modo_mantenimiento = (integer)$p_Datos["eq_Modo_Mantenimiento"];
        $this->_tipo_red = (string)$p_Datos["eq_Tipo_Red"];
        $this->_wifi_signal = (integer)$p_Datos["eq_Wifi_Signal"];
        //control
        $this->_creado_el = strtotime($p_Datos["eq_Creado"]);
        $this->_bloqueado_el = (is_null($p_Datos["eq_Bloqueado"])) ? null : strtotime($p_Datos["eq_Bloqueado"]);
    }

    public function save($p_Debug = false)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_creado_el = time();

        $datos = array(
            //datos
            'eq_UUID' => $this->_uuid,
            'eq_Detalle' => $this->_detalle,
            'eq_Ip' => $this->_ip,
            'eq_Password' => $this->_password,
            'eq_Heartbeat' => (is_null($this->_heartbeat)) ? null : date('Y-m-d H:i:s', $this->_heartbeat),
            'eq_Bloquear_Sync' => $this->_bloquear_sync,
            'eq_Bloquear_Updates' => $this->_bloquear_updates,
            'eq_Modo_Mantenimiento' => $this->_modo_mantenimiento,
            'eq_Tipo_Red' => $this->_tipo_red,
            'eq_Wifi_Signal' => $this->_wifi_signal
        );

        if ($this->_id == 0) {
            $datos['eq_Creado'] = date('Y-m-d H:i:s', $this->_creado_el);

            $resultado = $cnn->Insert('equipos', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('equipos', $datos, "eq_Id = {$this->_id}");
        }
        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }

    public function bloqueado($p_Debug)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }

        $this->_bloqueado_el = time();

        $datos['eq_Bloqueado'] = date('Y-m-d H:i:s', $this->_bloqueado_el);

        $resultado = $cnn->Update('equipos', $datos, "eq_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }

    public function desBloqueado($p_Debug)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }

        $this->_bloqueado_el = null;

        $datos['eq_Bloqueado'] = $this->_bloqueado_el;

        $resultado = $cnn->Update('equipos', $datos, "eq_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }

    public function delete($p_Debug)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }
        $resultado = '';
        /*
                // Eliminar dispositivos
                $o_Dispositivos = Dispositivo_L::obtenerSalida($this->_id);
                if (!is_null($o_Dispositivos)) {
                    foreach ($o_Dispositivos as $o_Dispotivo) {
                        // eliminar logs_usos del los dispositivos del equipo
                        $resultado = $cnn->Delete('zonas', "lus_Dis_Id = " . $o_Dispotivo->getId());

                        // eliminar zona asiciadas a los dispositivos del equipo
                        $resultado = $cnn->Delete('zonas', "zon_Dis_Id = " . $o_Dispotivo->getId());
                    }
                }
                // eliminar dispositivos del equipo
                $resultado = $cnn->Delete('dispositivos', "dis_Eq_Id = " . $this->_id);
                // fin dispositivos
            */
        // eliminar sync
        $resultado = $cnn->Delete('sync', "syn_Eq_Id = " . $this->_id);

        // eliminar logs_alarmas
        $resultado = $cnn->Delete('logs_alarmas', "lal_Eq_Id = " . $this->_id);

        // elimino el registo del logs_equipo
        $resultado = $cnn->Delete('logs_equipos', "lga_Eq_Id = " . $this->_id);

        // elimino el registo del equipo
        $resultado = $cnn->Delete('equipos', "eq_Id = " . $this->_id);

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
        $array['heartbeat'] = $this->_heartbeat;
        $array['uuid'] = $this->_uuid;

        return $array;
    }




}
