<?php

/*
 * Usuario (Object)
 */

class Persona_O
{

    private $_id;
//vinculos
    private $_hor_tipo;
    private $_hor_id;

//datos
    private $_legajo;
    private $_nombre;
    private $_apellido;
    private $_te_celular;
    private $_te_personal;
    private $_email;
    private $_dni;
    private $_tag;
    private $_equipos;
    private $_excluir;
    private $_imagen;
    private $_imagen_url;
//control
    private $_creado_usu_id;
    private $_creado_el;
    private $_bloqueado_usu_id;
    private $_bloqueado_el;
    private $_fecha_mod;
    private $_empresa;
    private $_eliminada;
    private $_eliminada_usu_id;
    private $_eliminada_el;
//objects
    private $_hora_trabajo_object;
    private $_creado_usu_object;
    private $_eliminado_usu_object;
//error
    private $_errores;

    public function __construct() {
        $this->_id = 0; //int(11)
//vinculos
        $this->_hor_tipo = 0;
        $this->_hor_id = 0; //int(11)
//datos
        $this->_legajo = ''; //varchar(20)
        $this->_nombre = ''; //varchar(50)
        $this->_apellido = ''; //varchar(50)
        $this->_te_celular = ''; //varchar(20)
        $this->_te_fijo = ''; //varchar(20)
        $this->_email = ''; //varchar(255)
        $this->_dni = ''; //varchar(8)
        $this->_tag = ''; //varchar(10)
        $this->_excluir = 0; //int
        $this->_equipos = ''; //varchar(200)
        $this->_imagen = ''; //varchar 200
        $this->_imagen_url = ''; //varchar 300
//control
        $this->_creado_usu_id = 0; //int(11)
        $this->_creado_el = null;
        $this->_bloqueado_usu_id = 0; //int(11)
        $this->_bloqueado_el = null;
        $this->_fecha_mod = 0;
        $this->_empresa = 1;
        $this->_eliminada = 0;
        $this->_eliminada_usu_id = 0;
        $this->_eliminada_el = null;
        $this->_enabled = 1;

//objects
        $this->_hora_trabajo_object = null;

        $this->_creado_usu_object = null;
        $this->_eliminado_usu_object = null;
//error
        $this->_errores = array();
    }

    /*
     * Controla vacio, contidad de caracteres max y min
     */

    private function control($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero = 'o') {
        if ($p_valor == '') {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar") . " " . strtolower($p_articulo) . " {$p_texto}.";
        } elseif (strlen($p_valor) < $p_min) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("es demasiado corto.");
        } elseif (strlen($p_valor) > $p_max) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("no debe superar los") . " {$p_max} " . _("caracteres.");
        } elseif (strpos($p_valor, ':') !== false) {
            $this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} " . _("especificad") . "{$p_genero} " . _("no debe contener el carácter dos puntos (:).");
        }
    }

    private function seleccionado($p_valor, $p_texto) {
        if (is_int($p_valor)) {
            if ($p_valor == 0) {
                $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un") . " {$p_texto}.";
            }
        } else {
            if ($p_valor == '') {
                $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un") . " {$p_texto}.";
            }
        }
    }

    private function control_numero($p_valor, $p_texto, $p_Tipo) {
        if (!empty($p_valor)) {
            if (is_numeric($p_valor)) {
                switch ($p_Tipo) {
                    case 'int':
                        $p_valor = (integer)$p_valor;
                        break;
                    case 'float':
                        $p_valor = (float)$p_valor;
                        break;
                }
                if (is_int($p_valor)) {
                    /* if ($p_valor == 0) {
                      $this->_errores[ValidateHelper::Cadena($p_texto)] = "Debe proporcionar {$p_texto} valido.";
                      } */
                } elseif (is_float($p_valor)) {
                    /* if ($p_valor == 0) {
                      $this->_errores[ValidateHelper::Cadena($p_texto)] = "Debe proporcionar {$p_texto} valido.";
                      } */
                }
            } else {
                $this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar") . " {$p_texto} " . _("valido.");
            }
        }
    }

    public function getId() {
        return $this->_id;
    }


    public function getHorId() {
        return $this->_hor_id;
    }

    public function setHorId($p_HorId) {
        $p_HorId = (integer)$p_HorId;
        $this->seleccionado($p_HorId, _('Horario de Trabajo'));
        $this->_hor_id = $p_HorId;
        switch ($this->_hor_tipo) {
            case HORARIO_NORMAL:
                if (is_null(Hora_Trabajo_L::obtenerPorId($this->_hor_id))) {
                    $this->_errores['horario_id'] = 'El Horario Normal ID ' . ' \'' . $this->_hor_id . '\' ' . 'no existe';
                }
                break;
            case HORARIO_FLEXIBLE:
                if (is_null(Horario_Flexible_L::obtenerPorId($this->_hor_id))) {
                    $this->_errores['horario_id'] = 'El Horario Flexible ID ' . ' \'' . $this->_hor_id . '\' ' . 'no existe';
                }
                break;
            case HORARIO_ROTATIVO:
                if (is_null(Horario_Rotativo_L::obtenerPorId($this->_hor_id))) {
                    $this->_errores['horario_id'] = 'El Horario Rotativo ID ' . ' \'' . $this->_hor_id . '\' ' . 'no existe';
                }
                break;
        }
    }

    public function getHorTipo() {
        return $this->_hor_tipo;
    }

    public function setHorTipo($p_HorTipo) {
        $p_HorTipo = (integer)$p_HorTipo;
        //$this->seleccionado($p_HorTipo, _('Tipo de Horario'));
        $this->_hor_tipo = $p_HorTipo;
    }


    public function getLegajo() {
        return $this->_legajo;
    }

    public function setLegajo($p_Legajo) {
        $p_Legajo = trim($p_Legajo);
        $this->_legajo = $p_Legajo;
        //$this->control($this->_legajo, _('Legajo'), 2, 20);
        if (!is_null(Persona_L::obtenerPorLegajo($this->_legajo, $this->_id))) {
            $this->_errores['legajo'] = _('El Legajo') . ' \'' . $this->_legajo . '\' ' . _('ya existe.');
        }
    }

    public function getNombre() {
        return $this->_nombre;
    }

    public function setNombre($p_Nombre) {
        $p_Nombre = trim($p_Nombre);
        $this->control($p_Nombre, _('Nombre'), 2, 50);
        $this->_nombre = $p_Nombre;
    }

    public function getApellido() {
        return $this->_apellido;
    }

    public function setApellido($p_Apellido) {
        $p_Apellido = trim($p_Apellido);
        $this->control($p_Apellido, _('Apellido'), 2, 50);
        $this->_apellido = $p_Apellido;
    }

    public function getNombreCompleto() {
        return $this->_nombre . " " . $this->_apellido;
    }

    public function getNombreCompletoINV() {
        return $this->_apellido . ", " . $this->_nombre;
    }

    public function getHuellasId() {
        //echo "id".$this->_id;
        $a_o_Huellas = Huella_L::obtenerPorPersona($this->_id);
        $string_huellas = '';
        if (!empty($a_o_Huellas)) {
            foreach ($a_o_Huellas as $o_Huella) {
                $string_huellas .= $o_Huella->getId() . "_";
            }
            $string_huellas = rtrim($string_huellas, '_');
        }
        //echo "string".$string_huellas;
        return $string_huellas;
    }

    public function getTeCelular() {
        return $this->_te_celular;
    }

    public function setTeCelurar($p_Te_Cel) {
        $p_Te_Cel = trim($p_Te_Cel);
        if ($p_Te_Cel != '') {
            $this->control($p_Te_Cel, _('Teléfono Celular'), 5, 15);
        }
        $this->_te_celular = $p_Te_Cel;
    }

    public function getTeFijo() {
        return $this->_te_fijo;
    }

    public function setTeFijo($p_Te_per) {
        $p_Te_per = trim($p_Te_per);
        if ($p_Te_per != '') {
            $this->control($p_Te_per, _('Teléfono Fijo'), 5, 15);
        }
        $this->_te_fijo = $p_Te_per;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail($p_Email) {
        $p_Email = trim($p_Email);
        if ($p_Email != '') {
            $this->control($p_Email, _('E-Mail'), 4, 255);
            if (!ValidateHelper::ValidateEmail($p_Email) && $p_Email != '') {
                $this->_errores['e-mail'] = _('El E-mail') . ' \'' . $this->_email . '\' ' . ('no es valido.');
            }
        }
        $this->_email = $p_Email;
    }

    public function getDni() {
        return $this->_dni;
    }

    public function setDni($p_Valor) {
        $p_Valor = trim($p_Valor);
        $this->_dni = $p_Valor;

        $this->control($this->_dni, _('DNI'), 8, 8);
        if (!is_null(Persona_L::obtenerPorDni($this->_dni, $this->_id))) {
            $this->_errores['dni'] = _('El DNI') . ' \'' . $this->_dni . '\' ' . _('ya existe.');
        }
    }

    public function getTag() {
        return $this->_tag;
    }

    public function setTag($p_Valor) {
        $p_Valor = trim($p_Valor);

        if ($p_Valor != '' || $p_Valor != 0) {
            $this->_tag = $p_Valor;

            $this->control($this->_tag, _('TAG'), 10, 10);
            if (!ctype_xdigit($this->_tag)) {
                $this->_errores['tag'] = _('El TAG') . ' \'' . $this->_tag . '\' ' . _('debe ser hexadecimal.');
                return;
            }
            if (!is_null(Persona_L::obtenerPorTag($this->_tag, $this->_id))) {
                $this->_errores['tag'] = _('El TAG') . ' \'' . $this->_tag . '\' ' . _('ya existe.');
            }
        }
    }

    public function removeTag() {
        $this->_tag = '';
    }

    public function getExcluir() {
        return $this->_excluir;
    }

    public function setExcluir($p_Excluir) {
        $this->_excluir = (int)$p_Excluir;
    }

    public function getEquipos() {
        return $this->_equipos;
    }

    public function setEquipos($p_Equipos) {
        $p_Equipos = trim($p_Equipos);
        //$this->control($p_Cadena_Sync, 'Cadena Sync', 5, 100);
        $this->_equipos = $p_Equipos;
    }

    public function getImagen() {
        return $this->_imagen;
    }

    public function setImagen($p_Imagen) {
        $p_Imagen = (string)$p_Imagen;
        $this->_imagen = $p_Imagen;
    }

    public function getImagenURL() {
        return $this->_imagen_url;
    }

    public function setImagenURL($p_Imagen) {
        $p_Imagen = (string)$p_Imagen;
        $this->_imagen_url = $p_Imagen;
    }

    public function getEnabled() {
        return $this->_enabled;
    }

    public function setEnabled($p_Enabled) {
        $p_Enabled = (integer)$p_Enabled;
        $this->_enabled = $p_Enabled;
    }

    public function getCreadoUsuarioId() {
        return $this->_creado_usu_id;
    }

    public function setCreadoUsuarioId($p_Id) {
        $p_Id = (integer)$p_Id;
        $this->seleccionado($p_Id, _('Creado por el Usuario'));
        $this->_creado_usu_id = $p_Id;
    }

    public function getCreadoEl($pFormat = null) {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_creado_el)) {
                return '';
            } else {
                return date($pFormat, $this->_creado_el);
            }
        }
        return $this->_creado_el;
    }

    public function getBloqueadoUsuarioId() {
        return $this->_bloqueado_usu_id;
    }

    public function setBloqueadoUsuarioId($p_Id) {
        $p_Id = (integer)$p_Id;
        $this->_bloqueado_usu_id = $p_Id;
    }

    public function getEliminadoUsuarioId() {
        return $this->_eliminada_usu_id;
    }

    public function setEliminadoUsuarioId($p_Id) {
        $p_Id = (integer)$p_Id;
        $this->seleccionado($p_Id, _('Eliminado por el Usuario'));
        $this->_eliminada_usu_id = $p_Id;
    }

    public function getBloqueadoEl($pFormat = null) {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_bloqueado_el)) {
                return '';
            } else {
                return date($pFormat, $this->_bloqueado_el);
            }
        }
        return $this->_bloqueado_el;
    }

    public function getEliminadoEl($pFormat = null) {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_eliminada_el)) {
                return '';
            } else {
                return date($pFormat, $this->_eliminada_el);
            }
        }
        return $this->_eliminada_el;
    }

    // Vinculos con otros Objetos

    public function getHoraTrabajoObject() {
        if (is_null($this->_hora_trabajo_object) && $this->_hor_id > 0) {
            switch ($this->_hor_tipo) {
                case HORARIO_NORMAL:
                    $this->_hora_trabajo_object = Hora_Trabajo_L::obtenerPorId($this->_hor_id);
                    break;
                case HORARIO_FLEXIBLE:
                    $this->_hora_trabajo_object = Horario_Flexible_L::obtenerPorId($this->_hor_id);
                    break;
                case HORARIO_ROTATIVO:
                    $this->_hora_trabajo_object = Horario_Rotativo_L::obtenerPorId($this->_hor_id);
                    break;
            }

        }
        return $this->_hora_trabajo_object;
    }


    public function getCreadoUsuarioObject() {
        if (is_null($this->_creado_usu_object) && $this->_creado_usu_id > 0) {
            $this->_creado_usu_object = Usuario_L::obtenerPorId($this->_creado_usu_id);
        }
        return $this->_creado_usu_object;
    }

    public function getEliminadoUsuarioObject() {
        if (is_null($this->_eliminado_usu_object) && $this->_bloqueado_usu_id > 0) {
            $this->_eliminado_usu_object = Usuario_L::obtenerPorId($this->_bloqueado_usu_id);
        }
        return $this->_eliminado_usu_object;
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

    public function getEmpresa() {
        return $this->_empresa;
    }

    public function setEmpresa($p_Empresa) {
        $this->_empresa = (int)$p_Empresa;
    }

    public function getEliminada() {
        return $this->_eliminada;
    }

    public function setEliminada($p_Eliminada) {
        $this->_eliminada = (int)$p_Eliminada;
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
        $this->_id = (integer)$p_Datos["per_Id"];
        //vinculos
        $this->_hor_tipo = (integer)$p_Datos["per_Hor_Tipo"];
        $this->_hor_id = (integer)$p_Datos["per_Hor_Id"];
        //datos
        $this->_legajo = (string)$p_Datos["per_Legajo"];
        $this->_nombre = (string)$p_Datos["per_Nombre"];
        $this->_apellido = (string)$p_Datos["per_Apellido"];
        $this->_te_celular = (string)$p_Datos["per_Te_Celular"];
        $this->_te_fijo = (string)$p_Datos["per_Te_Fijo"];
        $this->_email = (string)$p_Datos["per_E_Mail"];
        $this->_dni = (string)$p_Datos["per_Dni"];
        $this->_tag = (string)$p_Datos["per_Tag"];
        $this->_excluir = (int)$p_Datos["per_Excluir"];
        $this->_equipos = (string)$p_Datos["per_Equipos"];
        $this->_imagen = (string)$p_Datos["per_Imagen"];
        $this->_imagen_url = (string)$p_Datos["per_Imagen_URL"];
        //control
        $this->_creado_usu_id = (integer)$p_Datos["per_Creado_Usu_Id"];
        $this->_creado_el = strtotime($p_Datos["per_Creado"]);
        $this->_bloqueado_usu_id = (integer)$p_Datos["per_Enable_Usu_Id"];
        $this->_bloqueado_el = (is_null($p_Datos["per_Enable_Date"])) ? null : strtotime($p_Datos["per_Enable_Date"]);
        $this->_enabled = (integer)$p_Datos["per_Enable"];
        $this->_fecha_mod = (string)$p_Datos["per_Fecha_Mod"];
        $this->_empresa = (integer)$p_Datos["per_Empresa"];
        $this->_eliminada = (integer)$p_Datos["per_Eliminada"];
        $this->_eliminada_usu_id = (integer)$p_Datos["per_Eliminada_Usu_Id"];
        $this->_eliminada_el = (is_null($p_Datos["per_Eliminada_Date"])) ? null : strtotime($p_Datos["per_Eliminada_Date"]);
    }

    public function save($p_Debug=false, $p_Max_Persona = 0) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }


        $cantidad_personas = $cnn->Devolver_Count_Id('personas', 'per_Id');

        if (!is_null($cantidad_personas) && $cantidad_personas != 0) {


            if ($cantidad_personas >= Config_L::p('max_personas')) {
                $this->_errores['mysql'] = _('Limite máximo de Personas alcanzado');
                return false;
            }
        }

        $this->_fecha_mod = date("Y-m-d H:i:s");

        $this->_creado_el = time();

        $datos = array(
            //vinculos
            'per_Hor_Tipo' => $this->_hor_tipo,
            'per_Hor_Id' => $this->_hor_id,
            //datos
            'per_Legajo' => $this->_legajo,
            'per_Nombre' => $this->_nombre,
            'per_Apellido' => $this->_apellido,
            'per_Te_Celular' => $this->_te_celular,
            'per_Te_Fijo' => $this->_te_fijo,
            'per_E_Mail' => $this->_email,
            'per_Dni' => $this->_dni,
            'per_Tag' => $this->_tag,
            'per_Excluir' => $this->_excluir,
            'per_Equipos' => $this->_equipos,
            'per_Imagen' => $this->_imagen,
            'per_Imagen_URL' => $this->_imagen_url,
            'per_Fecha_Mod' => $this->_fecha_mod,
            'per_Empresa' => $this->_empresa,
            'per_Eliminada' => $this->_eliminada,
            'per_Enable' => $this->_enabled
        );

        if ($this->_id == 0) {

            $datos['per_Creado_Usu_Id'] = $this->_creado_usu_id;
            $datos['per_Creado'] = date('Y-m-d H:i:s', $this->_creado_el);


            $resultado = $cnn->Insert('personas', $datos);

            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            //print_r($datos);
            $resultado = $cnn->Update('personas', $datos, "per_Id = {$this->_id}");
        }
        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;
    }

    public function bloquear($p_Debug=false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        if ($this->_id == 0) {
            return false;
        }

        $this->_bloqueado_el = time();

        $datos['per_Enable_Usu_Id'] = $this->_bloqueado_usu_id;
        $datos['per_Enable'] = 0;
        $datos['per_Enable_Date'] = date('Y-m-d H:i:s', $this->_bloqueado_el);

        $resultado = $cnn->Update('personas', $datos, "per_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }

    public function desbloquear($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }

        $this->_bloqueado_el = null;

        $datos['per_Enable_Usu_Id'] = 0;
        $datos['per_Enable'] = 1;
        $datos['per_Enable_Date'] =  $this->_bloqueado_el;

        $resultado = $cnn->Update('personas', $datos, "per_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
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


        $this->_eliminada_el = time();

        $datos['per_Eliminada_Usu_Id'] = $this->_eliminada_usu_id;
        $datos['per_Eliminada'] = 1;
        $datos['per_Eliminada_Date'] = date('Y-m-d H:i:s', $this->_eliminada_el);

        if(trim($this->_equipos) == ''){  //la persona ya no esta sincronizada con ningun equipo, la puedo borrar.
            $resultado = $cnn->Delete('personas', "per_Id = " . $this->_id);
        }else{
            $resultado = $cnn->Update('personas', $datos, "per_Id = {$this->_id}");   //sino, pongo el elmiinado en 1
        }



        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }

    /*
     * esta funcion se llama desde el sync. le va sacando de a un equipo a la persona y cuando no tiene mas la purgea.
     */
    public function deleteEquipo($equipoID) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        if ($this->_id == 0) {
            return false;
        }


        $array_equipos = explode(':', $this->getEquipos());

        $array_equipos_nuevo = array_diff($array_equipos, array($equipoID));

        $datos['per_Equipos'] = implode(':',$array_equipos_nuevo);
        $this->_equipos = $datos['per_Equipos'];


        if(trim($this->_equipos) == ''){  //la persona ya no esta sincronizada con ningun equipo, la puedo borrar.
            $resultado = $cnn->Delete('personas', "per_Id = " . $this->_id);
        }else{
            $resultado = $cnn->Update('personas', $datos, "per_Id = {$this->_id}");   //sino, pongo el elmiinado en 1
        }



        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error(false);
            return false;
        }

        return true;
    }

    public function undelete($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }

        $this->_eliminado_el = null;

        $datos['per_Eliminada_Usu_Id'] = 0;
        $datos['per_Eliminada'] = 0;
        $datos['per_Eliminada_Date'] = $this->_eliminada_el;

        $resultado = $cnn->Update('personas', $datos, "per_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }

    public function Purge($p_Debug) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;
        $resultado = '';

        if ($this->_id == 0) {
            return false;
        }

        $resultado .= $cnn->Delete('personas', "per_Id = " . $this->_id);

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }

        return true;
    }




    /**
     * Devuelve un array con algunos datos de la persona
     * Se utiliza en la API
     *
     * @param $incluir_imagen Bool incluye la url y datos de la imagen
     *
     * @return array()
     */
    public function toArray($incluir_imagen = false) {
        $array = array();
        $array['id'] = $this->_id;
        $array['legajo'] = $this->_legajo;
        $array['dni'] = $this->_dni;
        $array['tag'] = $this->_tag;
        $array['horario_tipo'] = $this->_hor_tipo;
        $array['horario_id'] = $this->_hor_id;
        $array['apellido'] = $this->_apellido;
        $array['nombre'] = $this->_nombre;
        $array['telefono_celular'] = $this->_te_celular;
        $array['telefono_fijo'] = $this->_te_fijo;
        $array['email'] = $this->_email;
        if($incluir_imagen) {
            $array['imagen_url'] = $this->_imagen_url;
            if($this->_imagen!='')
                $array['imagen_data'] = $fileContents = base64_encode(file_get_contents($this->_imagen));
        }
        $array['exluir'] = $this->_excluir;
        $array['equipos'] = $this->_equipos;
        $array['empresa'] = $this->_empresa;
        $array['enabled'] = $this->_enabled;

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


        if(array_key_exists('legajo',$p_Datos))$this::setLegajo((string)$p_Datos["legajo"]);
        if(array_key_exists('dni',$p_Datos))$this::setDni((string)$p_Datos["dni"]);
        if(array_key_exists('tag',$p_Datos))$this::setTag((string)$p_Datos["tag"]);
        if(array_key_exists('horario_tipo',$p_Datos))$this::setHorTipo((integer)$p_Datos["horario_tipo"]);
        if(array_key_exists('horario_id',$p_Datos))$this::setHorId((integer)$p_Datos["horario_id"]);
        if(array_key_exists('apellido',$p_Datos))$this::setApellido((string)$p_Datos["apellido"]);
        if(array_key_exists('nombre',$p_Datos))$this::setNombre((string)$p_Datos["nombre"]);
        if(array_key_exists('telefono_celular',$p_Datos))$this::setTeCelurar((string)$p_Datos["telefono_celular"]);
        if(array_key_exists('telefono_fijo',$p_Datos))$this::setTeFijo((string)$p_Datos["telefono_fijo"]);
        if(array_key_exists('email',$p_Datos))$this::setEmail((string)$p_Datos["email"]);
        if(array_key_exists('exluir',$p_Datos))$this::setExcluir((integer)$p_Datos["exluir"]);
        if(array_key_exists('equipos',$p_Datos))$this::setEquipos((string)$p_Datos["equipos"]);
        if(array_key_exists('empresa',$p_Datos))$this::setEmpresa((integer)$p_Datos["empresa"]);
        if(array_key_exists('enabled',$p_Datos))$this::setEnabled((integer)$p_Datos["enabled"]);


    }


    /**
     * Devuelve un array con los datos de la persona para sync
     * Se utiliza en el proceso de sincronizacion
     *
     * @return array()
     */
    public function toSyncArray() {
        $array = array();
        $array['per_Id'] = $this->_id;
        $array['per_Legajo'] = $this->_legajo;
        $array['per_Dni'] = $this->_dni;
        $array['per_Tag'] = $this->_tag;
        $array['per_Hor_Tipo'] = $this->_hor_tipo;
        $array['per_Hor_Id'] = $this->_hor_id;
        $array['per_Apellido'] = $this->_apellido;
        $array['per_Nombre'] = $this->_nombre;
        if($this->getImagen()!='')
            $array['per_Imagen'] = base64_encode(file_get_contents($this->_imagen));
        else
            $array['per_Imagen'] = '';
        $array['per_Fecha_Mod'] = strtotime($this->_fecha_mod);
        $array['per_Enabled'] = $this->_enabled;
        $array['per_Eliminada'] = $this->_eliminada;

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


        if(array_key_exists('per_Legajo',$p_Datos))$this::setLegajo((string)$p_Datos["per_Legajo"]);
        if(array_key_exists('per_Dni',$p_Datos))$this::setDni((string)$p_Datos["per_Dni"]);
        if(array_key_exists('per_Tag',$p_Datos))$this::setTag((string)$p_Datos["per_Tag"]);
        if(array_key_exists('per_Hor_Tipo',$p_Datos))$this::setHorTipo((integer)$p_Datos["per_Hor_Tipo"]);
        if(array_key_exists('per_Hor_Id',$p_Datos))$this::setHorId((integer)$p_Datos["per_Hor_Id"]);
        if(array_key_exists('per_Apellido',$p_Datos))$this::setApellido((string)$p_Datos["per_Apellido"]);
        if(array_key_exists('per_Nombre',$p_Datos))$this::setNombre((string)$p_Datos["per_Nombre"]);
        if(array_key_exists('per_Imagen',$p_Datos))$this::setImagen(base64_decode($p_Datos["per_Imagen"]));
        if(array_key_exists('per_Fecha_Mod',$p_Datos))$this::setFechaMod((integer)$p_Datos["per_Fecha_Mod"]);
        if(array_key_exists('per_Enabled',$p_Datos))$this::setEnabled((integer)$p_Datos["per_Enabled"]);


    }

}
