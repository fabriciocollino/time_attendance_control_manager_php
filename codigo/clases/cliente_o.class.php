<?php

/*
 * Usuario (Object)
 */


class Cliente_O
{

    private $_id;
    private $_empresa;
    private $_nombre;
    private $_apellido;
    private $_db_user;
    private $_db_pass;
    private $_db_name;
    private $_db_host;
    private $_db_port;
    private $_subdominio;
    private $_suscripcion;
    private $_enabled;
    private $_creado_el;
    private $_createToken;
    private $_createTokenDate;
    private $_email;
    private $_eliminado_usu_id;
    private $_eliminado_el;
    private $_eliminado;

    private $_errores;

    public function __construct()
    {
        $this->_id                  = 0;  //int(11)

        $this->_nombre              = ''; //varchar(50)
        $this->_apellido            = ''; //varchar(50)
        $this->_email               = ''; //varchar(255)

        $this->_empresa             = ''; //varchar(50)
        $this->_subdominio          = ''; //varchar(8)
        $this->_suscripcion         = 0; //varchar(8)
        $this->_enabled             = 1; //varchar(8)

        $this->_db_user             = ''; //varchar(15)
        $this->_db_pass             = ''; //varchar(15)
        $this->_db_name             = ''; //varchar(255)
        $this->_db_host             = ''; //varchar(8)
        $this->_db_port             = ''; //varchar(8)

        $this->_createToken         = ''; //vaarchar 100
        $this->_createTokenDate     = null;
        $this->_creado_el           = null;

        $this->_eliminado           = 0;
        $this->_eliminado_usu_id    = 0;
        $this->_eliminado_el        = null;

        $this->_errores             = array();
    }

    /*
     * Controla vacio, contidad de caracteres max y min
     */

    private function control($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero = 'o')
    {
        if ($p_valor == '') {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar") . " " . strtolower($p_articulo) . " {$p_texto}.";
        }
        elseif (strlen($p_valor) < $p_min) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("es demasiado cort") . "{$p_genero}" . _(".");
        }
        elseif (strlen($p_valor) > $p_max) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("no debe superar los") . " {$p_max} " . _("caracteres.");
        }
    }

    private function seleccionado($p_valor, $p_texto)
    {
        if (is_int($p_valor)) {
            if ($p_valor == 0) {
                $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un") . " {$p_texto}.";
            }
        }
        else {
            if ($p_valor == '') {
                $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un") . " {$p_texto}.";
            }
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getNombre()
    {
        return $this->_nombre;
    }
    public function setNombre($p_Nombre)
    {
        $p_Nombre = trim($p_Nombre);
        $this->control($p_Nombre, _('Nombre'), 4, 50);
        $this->_nombre = $p_Nombre;
    }

    public function getEmpresa()
    {
        return $this->_empresa;
    }
    public function setEmpresa($p_Empresa)
    {
        $p_Empresa = trim($p_Empresa);
        $this->control($p_Empresa, _('Empresa'), 4, 50,'La','a');
        $this->_empresa = $p_Empresa;
    }

    public function getApellido()
    {
        return $this->_apellido;
    }
    public function setApellido($p_Apellido)
    {
        $p_Apellido = trim($p_Apellido);
        $this->control($p_Apellido, _('Apellido'), 4, 50);
        $this->_apellido = $p_Apellido;
    }

    public function getSubdominio()
    {
        return $this->_subdominio;
    }
    public function setSubdominio($p_Subdominio)
    {
        $p_Subdominio      = trim($p_Subdominio);
        $this->_subdominio = $p_Subdominio;
    }

    public function getDBuser()
    {
        return $this->_db_user;
    }
    public function setDBuser($p_DB_User)
    {
        $p_DB_User = trim($p_DB_User);
        $this->control($p_DB_User, _('DB User'), 5, 15);
        $this->_db_user = $p_DB_User;
    }

    public function getDBhost()
    {
        return $this->_db_host;
    }
    public function setDBhost($p_Host)
    {
        $p_Host = trim($p_Host);
        //$this->control($p_Host, _('DB Host'), 5, 15);
        $this->_db_host = $p_Host;
    }

    public function getDBpass()
    {
        return $this->_db_pass;
    }
    public function setDBpass($p_Pass)
    {
        $p_Pass = trim($p_Pass);
        $this->control($p_Pass, _('DB Pass'), 4, 255);
        $this->_db_pass = $p_Pass;

    }

    public function getDBname()
    {
        return $this->_db_name;
    }
    public function setDBname($p_Name)
    {
        $p_Name         = trim($p_Name);
        $this->_db_name = $p_Name;
        $this->control($p_Name, _('DB Name'), 4, 255);
    }

    public function getDBport()
    {
        return $this->_db_name;
    }
    public function setDBport($p_Port)
    {
        $p_Port         = trim($p_Port);
        $this->_db_port = $p_Port;
        $this->control($p_Port, _('DB Port'), 4, 255);

    }

    public function getSuscripcion()
    {
        return $this->_suscripcion;
    }
    public function setSuscripcion($p_suscripcion)
    {
        $p_suscripcion      = (integer)$p_suscripcion;
        $this->_suscripcion = $p_suscripcion;
    }


    /**
     * Devuelve TRUE/FALSE dependiendo de si el objeto es valido o no.
     *
     * @return boolean
     */
    public function esValido()
    {
        //Si el array errores no tiene elementos entonces el objeto es valido.
        return count($this->_errores) == 0;
    }

    /*
        public function setErrores($p_Nombre_Error, $p_Error) {
            $this->_errores['$p_Nombre_Error'] = $p_Error;
        }*/

    public function getErrores()
    {
        return $this->_errores;
    }

    public function loadArray($p_Datos)
    {
        $this->_id = (integer)$p_Datos["cli_Id"];
        //vinculos
        //datos
        $this->_nombre      = (string)$p_Datos["cli_Nombre"];
        $this->_apellido    = (string)$p_Datos["cli_Apellido"];
        $this->_empresa     = (string)$p_Datos["cli_Empresa"];
        $this->_db_host     = (string)$p_Datos["cli_DB_Host"];
        $this->_db_name     = (string)$p_Datos["cli_DB_Name"];
        $this->_db_pass     = (string)$p_Datos["cli_DB_Pass"];
        $this->_db_user     = (string)$p_Datos["cli_DB_User"];
        $this->_db_port     = (string)$p_Datos["cli_DB_Port"];
        $this->_suscripcion = (integer)$p_Datos["cli_Suscripcion"];
        $this->_subdominio  = (string)$p_Datos["cli_Subdominio"];
        $this->_enabled     = (integer)$p_Datos["cli_Enabled"];
        // new account
        $this->_email           = (string)$p_Datos["cli_Email"];
        $this->_createToken     = (string)$p_Datos["cli_Create_Token"];
        $this->_createTokenDate = (is_null($p_Datos["cli_Create_Token_Date"])) ? null : strtotime($p_Datos["cli_Create_Token_Date"]);

        $this->_creado_el = (is_null($p_Datos["cli_Creado"])) ? null : strtotime($p_Datos["cli_Creado"]);

        // eliminar
        $this->_eliminado_usu_id = (integer)$p_Datos["cli_Eliminado_Usu_Id"];
        $this->_eliminado        = (integer)$p_Datos["cli_Eliminado"];
        $this->_eliminado_el     = strtotime($p_Datos["cli_Eliminado_Date"]);
    }

    //TODO: TO ARRAY

    public function save($p_Debug=false)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }


        $datos = array(
            //datos
            'cli_Nombre' => $this->_nombre, 'cli_Apellido' => $this->_apellido, 'cli_Empresa' => $this->_empresa,
            'cli_DB_Host' => $this->_db_host, 'cli_DB_Name' => $this->_db_name, 'cli_DB_Pass' => $this->_db_pass,
            'cli_DB_User' => $this->_db_user, 'cli_DB_Port' => $this->_db_port, 'cli_Suscripcion' => $this->_suscripcion,
            'cli_Subdominio' => $this->_subdominio, 'cli_Enabled' => $this->_enabled,

            // new account
            'cli_Email'              => $this->_email,               'cli_Create_Token'  => $this->_createToken,

            // eliminar
            'cli_Eliminado_Usu_Id'   => $this->_eliminado_usu_id,        'cli_Eliminado' => $this->_eliminado
        );


        $datos['cli_Create_Token_Date'] = !is_null($this->_createTokenDate)     ?   date('Y-m-d H:i:s', strtotime($this->_createTokenDate))    : null ;
        $datos['cli_Eliminado_Date']    = !is_null($this->_eliminado_el)        ?   date('Y-m-d H:i:s', $this->_eliminado_el)       : null ;



        if ($this->_id == 0) {

            $this->_creado_el = time();
            $datos['cli_Creado'] = date('Y-m-d H:i:s', $this->_creado_el);

            $resultado = $cnn->Insert('clientes', $datos);

            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        }
        else {
            $resultado = $cnn->Update('clientes', $datos, "cli_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }



// new account added functions

    /**********************************************************************
     * EMAIL
     ***********************************************************************/

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail($p_Email)
    {
        $p_Email = trim($p_Email);
        $this->control($p_Email, _('E-Mail'), 4, 255);
        $this->_email = $p_Email;

        if (!ValidateHelper::ValidateEmail($p_Email) && $p_Email != '') {
            $this->_errores['email'] = _('El E-mail') . ' \'' . $this->_email . '\' ' . _('no es valido.');
        }
    }

    /**********************************************************************
     * ELIMINAR
     ***********************************************************************/

    public function delete($p_Debug=false)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        if ($this->_id == 0) {
            return false;
        }


        $this->_eliminado_el = time();

        $datos['cli_Eliminado_Usu_Id'] = $this->_eliminado_usu_id;
        $datos['cli_Eliminado']        = 1;
        $datos['cli_Eliminado_Date']   = date('Y-m-d H:i:s', $this->_eliminado_el);
        $datos["cli_Email"]            = 'Eliminado_' . $this->_email;


        $resultado = $cnn->Update('clientes', $datos, "cli_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }


    public function undelete($p_Debug = false)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }

        $this->_eliminado_el = null;

        $datos['cli_Eliminado_Usu_Id'] = 0;
        $datos['cli_Eliminado']        = 0;
        $datos['cli_Eliminado_Date']   = $this->_eliminado_el;


        $resultado = $cnn->Update('usuario', $datos, "usu_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }

    public function getEliminado()
    {
        return $this->_eliminado;
    }

    public function getEliminadoEl($pFormat = null)
    {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_eliminado_el)) {
                return '';
            }
            else {
                return date($pFormat, $this->_eliminado_el);
            }
        }
        return $this->_eliminado_el;
    }


    /**********************************************************************
     * CREADO FECHA
     ***********************************************************************/

    public function getCreadoEl($pFormat = null)
    {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_creado_el)) {
                return '';
            }
            else {
                return date($pFormat, $this->_creado_el);
            }
        }
        return $this->_creado_el;
    }


    /**********************************************************************
     * TOKEN
     ***********************************************************************/

    public function setcreateToken($p_Token)
    {
        $this->_createToken     = $p_Token;
        $this->_createTokenDate = date('Y-m-d H:i:s', time());
    }

    public function getcreateToken()
    {
        return $this->_createToken;
    }

    public function clearcreateToken()
    {
        $this->_createToken     = '';
        $this->_createTokenDate = null;
    }

    public function getcreateTokenDate($pFormat = null)
    {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_createTokenDate)) {
                return null;
            }
            else {
                return date($pFormat, $this->_createTokenDate);
            }
        }
        return $this->_createTokenDate;
    }


    /**********************************************************************
     * HABILITAR
     ***********************************************************************/

    public function getEnabled()
    {
        return $this->_enabled;
    }

    public function setEnabled($p_Enabled)
    {
        $p_Enabled      = (integer)$p_Enabled;
        $this->_enabled = $p_Enabled;
    }





    /**********************************************************************
     * NEW DB
     ***********************************************************************/

    public function Create_clientDB($p_dataBase=null,$p_dataBasepassword=null, $p_dataBase_usr=null,$p_Debug=false){

        $p_dataBase          =       is_null($p_dataBase)           ?   $this->_db_name    : $p_dataBase;
        $p_dataBase_usr      =       is_null($p_dataBase_usr)       ?   $this->_db_user    : $p_dataBase_usr;
        $p_dataBasepassword  =       is_null($p_dataBasepassword)   ?   $this->_db_pass    : $p_dataBasepassword;

        $cnn = Registry::getInstance()->DbConnMGR;

        $p_dataBase = " ".$p_dataBase;

        $_query[] = "CREATE DATABASE ".$p_dataBase.";";

        $_query[] = "CREATE USER '".$p_dataBase_usr."'@'%';";
        $_query[] = "GRANT ALL ON ".$p_dataBase.".* TO '".$p_dataBase_usr."'@'%';";
        $_query[] = "ALTER USER '".$p_dataBase_usr."' IDENTIFIED BY  '".$p_dataBasepassword."';";
        $_query[] = "FLUSH PRIVILEGES;";


        $_query[] = "CREATE TABLE".$p_dataBase.".configuracion LIKE tasm_db.configuracion;";
        $_query[] = "CREATE TABLE".$p_dataBase.".cron LIKE tasm_db.cron;";
        $_query[] = "CREATE TABLE".$p_dataBase.".email LIKE tasm_db.email;";
        $_query[] = "CREATE TABLE".$p_dataBase.".equipos LIKE tasm_db.equipos;";
        $_query[] = "CREATE TABLE".$p_dataBase.".empresas LIKE tasm_db.empresas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".feriados LIKE tasm_db.feriados;";
        $_query[] = "CREATE TABLE".$p_dataBase.".grupos LIKE tasm_db.grupos;";
        $_query[] = "CREATE TABLE".$p_dataBase.".grupos_personas LIKE tasm_db.grupos_personas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".hora_trabajo LIKE tasm_db.hora_trabajo;";
        $_query[] = "CREATE TABLE".$p_dataBase.".horarios_flexibles LIKE tasm_db.horarios_flexibles;";
        $_query[] = "CREATE TABLE".$p_dataBase.".horarios_multiples LIKE tasm_db.horarios_multiples;";
        $_query[] = "CREATE TABLE".$p_dataBase.".horarios_rotativos LIKE tasm_db.horarios_rotativos;";
        $_query[] = "CREATE TABLE".$p_dataBase.".huellas LIKE tasm_db.huellas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".licencias LIKE tasm_db.licencias;";
        $_query[] = "CREATE TABLE".$p_dataBase.".logs_alert_mensaje LIKE tasm_db.logs_alert_mensaje;";
        $_query[] = "CREATE TABLE".$p_dataBase.".logs_web LIKE tasm_db.logs_web;";
        $_query[] = "CREATE TABLE".$p_dataBase.".logs_equipo  LIKE tasm_db.logs_equipo;";
        $_query[] = "CREATE TABLE".$p_dataBase.".logs_heartbeat LIKE tasm_db.logs_heartbeat;";
        $_query[] = "CREATE TABLE".$p_dataBase.".mensajes LIKE tasm_db.mensajes;";
        $_query[] = "CREATE TABLE".$p_dataBase.".notificaciones LIKE tasm_db.notificaciones;";
        $_query[] = "CREATE TABLE".$p_dataBase.".personas LIKE tasm_db.personas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".usuario LIKE tasm_db.usuario;";
        $_query[] = "CREATE TABLE".$p_dataBase.".usuario_tipo LIKE tasm_db.usuario_tipo;";
        $_query[] = "CREATE TABLE".$p_dataBase.".message LIKE tasm_db.message;";
        $_query[] = "CREATE TABLE".$p_dataBase.".notas LIKE tasm_db.notas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".suspensions LIKE tasm_db.suspensions;";
        $_query[] = "CREATE TABLE".$p_dataBase.".permisos LIKE tasm_db.permisos;";

        $_query[] = "INSERT INTO".$p_dataBase.".configuracion SELECT * FROM tasm_db.configuracion;";
        $_query[] = "INSERT INTO".$p_dataBase.".cron SELECT * FROM tasm_db.cron;";
        $_query[] = "INSERT INTO".$p_dataBase.".email SELECT * FROM tasm_db.email;";
        $_query[] = "INSERT INTO".$p_dataBase.".equipos SELECT * FROM tasm_db.equipos;";
        $_query[] = "INSERT INTO".$p_dataBase.".empresas SELECT * FROM tasm_db.empresas ;";
        $_query[] = "INSERT INTO".$p_dataBase.".feriados SELECT * FROM tasm_db.feriados;";
        $_query[] = "INSERT INTO".$p_dataBase.".grupos SELECT * FROM tasm_db.grupos;";
        $_query[] = "INSERT INTO".$p_dataBase.".grupos_personas SELECT * FROM tasm_db.grupos_personas;";
        $_query[] = "INSERT INTO".$p_dataBase.".hora_trabajo SELECT * FROM tasm_db.hora_trabajo;";
        $_query[] = "INSERT INTO".$p_dataBase.".horarios_flexibles SELECT * FROM tasm_db.horarios_flexibles;";
        $_query[] = "INSERT INTO".$p_dataBase.".horarios_multiples SELECT * FROM tasm_db.horarios_multiples;";
        $_query[] = "INSERT INTO".$p_dataBase.".horarios_rotativos SELECT * FROM tasm_db.horarios_rotativos;";
        $_query[] = "INSERT INTO".$p_dataBase.".huellas SELECT * FROM tasm_db.huellas;";
        $_query[] = "INSERT INTO".$p_dataBase.".licencias SELECT * FROM tasm_db.licencias;";
        $_query[] = "INSERT INTO".$p_dataBase.".logs_alert_mensaje SELECT * FROM tasm_db.logs_alert_mensaje;";
        $_query[] = "INSERT INTO".$p_dataBase.".logs_web SELECT * FROM tasm_db.logs_web;";
        $_query[] = "INSERT INTO".$p_dataBase.".logs_equipo SELECT * FROM tasm_db.logs_equipo;";
        $_query[] = "INSERT INTO".$p_dataBase.".logs_heartbeat SELECT * FROM tasm_db.logs_heartbeat;";
        $_query[] = "INSERT INTO".$p_dataBase.".mensajes SELECT * FROM tasm_db.mensajes;";
        $_query[] = "INSERT INTO".$p_dataBase.".notificaciones SELECT * FROM tasm_db.notificaciones;";
        $_query[] = "INSERT INTO".$p_dataBase.".personas SELECT * FROM tasm_db.personas;";
        $_query[] = "INSERT INTO".$p_dataBase.".usuario SELECT * FROM tasm_db.usuario;";
        $_query[] = "INSERT INTO".$p_dataBase.".usuario_tipo SELECT * FROM tasm_db.usuario_tipo;";
        $_query[] = "INSERT INTO".$p_dataBase.".message SELECT * FROM tasm_db.message;";
        $_query[] = "INSERT INTO".$p_dataBase.".notas SELECT * FROM tasm_db.notas;";
        $_query[] = "INSERT INTO".$p_dataBase.".suspensions SELECT * FROM tasm_db.suspensions;";
        $_query[] = "INSERT INTO".$p_dataBase.".permisos SELECT * FROM tasm_db.permisos;";

        foreach ($_query as $_quKey =>$_q){


            $resultado = $cnn->Query($_q);

            if ($resultado === false) {

                $this->_errores['mysql'] = $cnn->get_Error($p_Debug); //hacer

            }
        }

        if ($resultado === false) {
            return false;
        }
        else{
            return $resultado;//$this->_id = $cnn->Devolver_Insert_Id(); //hacer
        }


    }


    public function Create_clientDBCopy($p_dataBase=null,$p_dataBasepassword=null, $p_dataBase_usr=null,$p_Debug=false){

        $p_dataBase          =       is_null($p_dataBase)           ?   $this->_db_name    : $p_dataBase;
        $p_dataBase_usr      =       is_null($p_dataBase_usr)       ?   $this->_db_user    : $p_dataBase_usr;
        $p_dataBasepassword  =       is_null($p_dataBasepassword)   ?   $this->_db_pass    : $p_dataBasepassword;

        $cnn = Registry::getInstance()->DbConnMGR;

        $p_dataBase = " ".$p_dataBase;

        $_query[] = "CREATE DATABASE ".$p_dataBase.";";

        $_query[] = "CREATE USER '".$p_dataBase_usr."'@'%';";
        $_query[] = "GRANT ALL ON ".$p_dataBase.".* TO '".$p_dataBase_usr."'@'%';";
        $_query[] = "ALTER USER '".$p_dataBase_usr."' IDENTIFIED BY  '".$p_dataBasepassword."';";
        $_query[] = "FLUSH PRIVILEGES;";


        $_query[] = "CREATE TABLE".$p_dataBase.".configuracion LIKE tasm_tomax.configuracion;";
        $_query[] = "CREATE TABLE".$p_dataBase.".cron LIKE tasm_tomax.cron;";
        $_query[] = "CREATE TABLE".$p_dataBase.".email LIKE tasm_tomax.email;";
        $_query[] = "CREATE TABLE".$p_dataBase.".equipos LIKE tasm_tomax.equipos;";
        $_query[] = "CREATE TABLE".$p_dataBase.".empresas LIKE tasm_tomax.empresas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".feriados LIKE tasm_tomax.feriados;";
        $_query[] = "CREATE TABLE".$p_dataBase.".grupos LIKE tasm_tomax.grupos;";
        $_query[] = "CREATE TABLE".$p_dataBase.".grupos_personas LIKE tasm_tomax.grupos_personas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".hora_trabajo LIKE tasm_tomax.hora_trabajo;";
        $_query[] = "CREATE TABLE".$p_dataBase.".horarios_flexibles LIKE tasm_tomax.horarios_flexibles;";
        $_query[] = "CREATE TABLE".$p_dataBase.".horarios_multiples LIKE tasm_tomax.horarios_multiples;";
        $_query[] = "CREATE TABLE".$p_dataBase.".horarios_rotativos LIKE tasm_tomax.horarios_rotativos;";
        $_query[] = "CREATE TABLE".$p_dataBase.".huellas LIKE tasm_tomax.huellas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".licencias LIKE tasm_tomax.licencias;";
        $_query[] = "CREATE TABLE".$p_dataBase.".logs_alert_mensaje LIKE tasm_tomax.logs_alert_mensaje;";
        $_query[] = "CREATE TABLE".$p_dataBase.".logs_web LIKE tasm_tomax.logs_web;";
        $_query[] = "CREATE TABLE".$p_dataBase.".logs_equipo  LIKE tasm_tomax.logs_equipo;";
        $_query[] = "CREATE TABLE".$p_dataBase.".logs_heartbeat LIKE tasm_tomax.logs_heartbeat;";
        $_query[] = "CREATE TABLE".$p_dataBase.".mensajes LIKE tasm_tomax.mensajes;";
        $_query[] = "CREATE TABLE".$p_dataBase.".notificaciones LIKE tasm_tomax.notificaciones;";
        $_query[] = "CREATE TABLE".$p_dataBase.".personas LIKE tasm_tomax.personas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".usuario LIKE tasm_tomax.usuario;";
        $_query[] = "CREATE TABLE".$p_dataBase.".usuario_tipo LIKE tasm_tomax.usuario_tipo;";
        $_query[] = "CREATE TABLE".$p_dataBase.".message LIKE tasm_tomax.message;";
        $_query[] = "CREATE TABLE".$p_dataBase.".notas LIKE tasm_tomax.notas;";
        $_query[] = "CREATE TABLE".$p_dataBase.".suspensions LIKE tasm_tomax.suspensions;";
        $_query[] = "CREATE TABLE".$p_dataBase.".permisos LIKE tasm_tomax.permisos;";

        $_query[] = "INSERT INTO".$p_dataBase.".configuracion SELECT * FROM tasm_tomax.configuracion;";
        $_query[] = "INSERT INTO".$p_dataBase.".cron SELECT * FROM tasm_tomax.cron;";
        $_query[] = "INSERT INTO".$p_dataBase.".email SELECT * FROM tasm_tomax.email;";
        $_query[] = "INSERT INTO".$p_dataBase.".equipos SELECT * FROM tasm_tomax.equipos;";
        $_query[] = "INSERT INTO".$p_dataBase.".empresas SELECT * FROM tasm_tomax.empresas ;";
        $_query[] = "INSERT INTO".$p_dataBase.".feriados SELECT * FROM tasm_tomax.feriados;";
        $_query[] = "INSERT INTO".$p_dataBase.".grupos SELECT * FROM tasm_tomax.grupos;";
        $_query[] = "INSERT INTO".$p_dataBase.".grupos_personas SELECT * FROM tasm_tomax.grupos_personas;";
        $_query[] = "INSERT INTO".$p_dataBase.".hora_trabajo SELECT * FROM tasm_tomax.hora_trabajo;";
        $_query[] = "INSERT INTO".$p_dataBase.".horarios_flexibles SELECT * FROM tasm_tomax.horarios_flexibles;";
        $_query[] = "INSERT INTO".$p_dataBase.".horarios_multiples SELECT * FROM tasm_tomax.horarios_multiples;";
        $_query[] = "INSERT INTO".$p_dataBase.".horarios_rotativos SELECT * FROM tasm_tomax.horarios_rotativos;";
        $_query[] = "INSERT INTO".$p_dataBase.".huellas SELECT * FROM tasm_tomax.huellas;";
        $_query[] = "INSERT INTO".$p_dataBase.".licencias SELECT * FROM tasm_tomax.licencias;";
        $_query[] = "INSERT INTO".$p_dataBase.".logs_alert_mensaje SELECT * FROM tasm_tomax.logs_alert_mensaje;";
        $_query[] = "INSERT INTO".$p_dataBase.".logs_web SELECT * FROM tasm_tomax.logs_web;";
        $_query[] = "INSERT INTO".$p_dataBase.".logs_equipo SELECT * FROM tasm_tomax.logs_equipo;";
        $_query[] = "INSERT INTO".$p_dataBase.".logs_heartbeat SELECT * FROM tasm_tomax.logs_heartbeat;";
        $_query[] = "INSERT INTO".$p_dataBase.".mensajes SELECT * FROM tasm_tomax.mensajes;";
        $_query[] = "INSERT INTO".$p_dataBase.".notificaciones SELECT * FROM tasm_tomax.notificaciones;";
        $_query[] = "INSERT INTO".$p_dataBase.".personas SELECT * FROM tasm_tomax.personas;";
        $_query[] = "INSERT INTO".$p_dataBase.".usuario SELECT * FROM tasm_tomax.usuario;";
        $_query[] = "INSERT INTO".$p_dataBase.".usuario_tipo SELECT * FROM tasm_tomax.usuario_tipo;";
        $_query[] = "INSERT INTO".$p_dataBase.".message SELECT * FROM tasm_tomax.message;";
        $_query[] = "INSERT INTO".$p_dataBase.".notas SELECT * FROM tasm_tomax.notas;";
        $_query[] = "INSERT INTO".$p_dataBase.".suspensions SELECT * FROM tasm_tomax.suspensions;";
        $_query[] = "INSERT INTO".$p_dataBase.".permisos SELECT * FROM tasm_tomax.permisos;";

        foreach ($_query as $_quKey =>$_q){


            $resultado = $cnn->Query($_q);

            if ($resultado === false) {

                $this->_errores['mysql'] = $cnn->get_Error($p_Debug); //hacer

            }
        }

        if ($resultado === false) {
            return false;
        }
        else{
            return $resultado;//$this->_id = $cnn->Devolver_Insert_Id(); //hacer
        }


    }

    public function delete_db($p_Debug = true)
    {

        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }

        $resultado = $cnn->Delete('clientes', "cli_Id = " . $this->_id);


        // ERROR
        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        printear('cliente eliminado de la tabla clientes');


        // DELETE DB
        $_query = "SHOW DATABASES LIKE " . $this->getDBname() . ";";
        $_db_existe = $cnn->Query($_query);

        printear('$_db_existe');
        printear($_db_existe);

        if ($_db_existe === false) {
            printear('llego a delete db');
            $_query = "DROP DATABASE ". $this->getDBname() . ";";
            $_db_existe = $cnn->Query($_query);

            //$this->_errores['mysql'] = $cnn->get_Error($p_Debug); //hacer
        }

        return true;
    }



    /**********************************************************************
     * NEW User
     ***********************************************************************/

    public function Create_clientUser($p_clave=null, $p_Debug = false){

        if(is_null($p_clave))
            return false;

        $G_DbConn1 = new mySQL(
            $this->getDBname(),
            $this->getDBuser(),
            $this->getDBpass(),
            $this->getDBhost(),
            $this->getDBport()
        );


        if ($G_DbConn1->ConectarSocket()) {
            Registry::getInstance()->DbConn = $G_DbConn1;
        }


        $o_usuario = new Usuario_O();

        $o_usuario->setClientId     ($this->_id);
        $o_usuario->setNombre       ($this->_nombre);
        $o_usuario->setApellido     ($this->_apellido);
        $o_usuario->setEmail        ($this->_email);

        $o_usuario->setClave                ($p_clave);
        $o_usuario->setConfirmacionClave    ($p_clave);
        $o_usuario->setTusId        (2);

        $resultado = $o_usuario->save($p_Debug);

        if($resultado === false) {
            $this->_errores = $o_usuario->getErrores();
        }

        return $resultado;

    }






}
