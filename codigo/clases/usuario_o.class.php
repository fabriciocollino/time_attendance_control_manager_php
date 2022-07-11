<?php

/*
 * Usuario (Object)
 */

class Usuario_O
{

    private $_id;
    //vinculos
    private $_client_id;
    private $_tus_id;
    //datos
    private $_nombre;
    private $_apellido;
    private $_te_celular;
    private $_te_personal;
    private $_email;
    private $_dni;
    private $_imagen;
    private $_imagen_url;
    //login
    //private $_usuario;
    private $_clave;
    private $_resetToken;
    private $_resetTokenDate;
    //control
    private $_creado_el;
    private $_eliminado_el;
    //objects
    private $_tipo_usuario_object;
    //error
    private $_errores;

    public function __construct() {
        $this->_id = 0; //int(11)
        //vinculos
        $this->_client_id = 0; //int(11)
        $this->_tus_id = 0; //int(11)
        //datos
        $this->_nombre = ''; //varchar(50)
        $this->_apellido = ''; //varchar(50)
        $this->_te_celular = ''; //varchar(15)
        $this->_te_personal = ''; //varchar(15)
        $this->_email = ''; //varchar(255)
        $this->_dni = ''; //varchar(8)
        $this->_imagen = ''; //varchar 200
        $this->_imagen_url = '';
        //login
        //$this->_usuario = ''; //varchar(50)
        $this->_clave = ''; //varchar(50)
        $this->_resetToken = '';//vaarchar 100
        $this->_resetTokenDate = null;
        //control
        $this->_creado_el = null;
        $this->_eliminado_el = null;
        //objects
        $this->_tipo_usuario_object = null;
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

    public function getId() {
        return $this->_id;
    }

    public function getTusId() {
        return $this->_tus_id;
    }

    public function setTusId($p_TusId) {
        $p_TusId = (integer)$p_TusId;
        $this->seleccionado($p_TusId, _('Tipo Usuario'));
        $this->_tus_id = $p_TusId;
    }

    public function getClientId() {
        return $this->_client_id;
    }

    public function setClientId($p_CId) {
        $p_CId = (integer)$p_CId;
        $this->_client_id = $p_CId;
    }

    public function getNombre() {
        return $this->_nombre;
    }

    public function getNombreCompleto() {
        return $this->_nombre . " " . $this->_apellido;
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

    public function getTeCelular() {
        return $this->_te_celular;
    }

    public function setTeCelurar($p_Te_Cel) {
        $p_Te_Cel = trim($p_Te_Cel);
        //$this->control($p_Te_Cel, _('Te Celular'), 5, 15);
        $this->_te_celular = $p_Te_Cel;
    }

    public function getTePersonal() {
        return $this->_te_personal;
    }

    public function setTePersonal($p_Te_per) {
        $p_Te_per = trim($p_Te_per);
        //$this->control($p_Te_per, _('Te Personal'), 5, 15);
        $this->_te_personal = $p_Te_per;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail($p_Email) {
        $p_Email = trim($p_Email);
        $this->control($p_Email, _('E-Mail'), 4, 255);
        $this->_email = $p_Email;
        if (!ValidateHelper::ValidateEmail($p_Email) && $p_Email != '') {
            $this->_errores['email'] = _('El E-mail') . ' \'' . $this->_email . '\' ' . _('no es valido.');
        }
        $o_usuario = Usuario_L::obtenerPorNombreUsuario($this->_email);
        if (!is_null($o_usuario) && $o_usuario->getId()!=$this->_id) {
            $this->_errores['usuario'] = _('El usuario') . ' \'' . $this->_email . '\' ' . _('ya existe.');
        }
    }

    public function getDni() {
        return $this->_dni;
    }

    public function setDni($p_Valor) {
        $p_Valor = trim($p_Valor);
        $this->_dni = $p_Valor;

        //$this->control($this->_dni, _('DNI'), 8, 8);
        //if (!is_null(Usuario_L::obtenerPorDni($this->_dni, $this->_id))) {
        //    $this->_errores['dni'] = _('El DNI') . ' \'' . $this->_dni . '\' ' . _('ya existe.');
        //}
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

    // public function getUsuario()
    // {
    //     return $this->_usuario;
    // }

    //  public function setUsuario($p_Usuario)
    // {
    //    if ($this->_id > 0 && $this->_usuario == $p_Usuario) {
    //        return;
    //     }
    //    $this->_usuario = $p_Usuario;

    //    $this->control($this->_usuario, _('Usuario'), 4, 50);
    //   if (!is_null(Usuario_L::obtenerPorNombreUsuario($this->_usuario))) {
    //       $this->_errores['usuario'] = _('El usuario') . ' \'' . $this->_usuario . '\' ' . _('ya existe.');
    //   }
    //  }

    public function setResetToken($p_Token) {
        $this->_resetToken = $p_Token;
        $this->_resetTokenDate = date('Y-m-d H:i:s', time());
    }

    public function getResetToken() {
        return $this->_resetToken;
    }

    public function clearResetToken() {
        $this->_resetToken = '';
        $this->_resetTokenDate = null;
    }

    public function setClaveActual($p_Clave) {
        if ($p_Clave == '' || sha1($p_Clave) != $this->_clave) {
            $this->_errores['contrasena_a'] = _('La Contraseña actual es incorrecta.');
        }
    }

    public function setClave($p_Clave) {
        $this->_clave = $p_Clave;
        if ($this->_clave == '' && $this->_id > 0) {
            //Significa que el usuario no desea cambiar la clave.
            //No es necesario validar.
        } else {
            $this->control($p_Clave, _('Contraseña'), 6, 50, _('La'), 'a');
        }
    }

    public function setConfirmacionClave($p_Confirmacion) {
        $this->_confirmacion_clave = $p_Confirmacion;
        if ($this->_clave == '') {
            //Significa que el usuario no desea cambiar la clave.
            //No es necesario validar.
            //	} elseif (!preg_match('/[0-9]/', $this->_clave) || !preg_match('/[a-z]/', $this->_clave) || !preg_match('/[A-Z]/', $this->_clave)) {
            //		$this->_errores['conf_contrasena'] = _('La Contraseña debe contener minúsculas, mayúsculas y números.');
        } elseif ($this->_clave != $this->_confirmacion_clave) {
            $this->_errores['conf_contrasena'] = _('La Contraseña no coincide con su confirmación, intente de nuevo.');
        }
    }

    public function getResetTokenDate($pFormat = null) {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_resetTokenDate)) {
                return '';
            } else {
                return date($pFormat, $this->_resetTokenDate);
            }
        }
        return $this->_resetTokenDate;
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

    public function getEliminadoEl($pFormat = null) {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_eliminado_el)) {
                return '';
            } else {
                return date($pFormat, $this->_eliminado_el);
            }
        }
        return $this->_eliminado_el;
    }

    public function getTipoUsuarioObject() {
        if (is_null($this->_tipo_usuario_object) && $this->_tus_id > 0) {
            $this->_tipo_usuario_object = UsuarioTipo_L::obtenerPorId($this->_tus_id);
        }
        return $this->_tipo_usuario_object;
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


    public function setErrores($p_Nombre, $p_Error) {
        $this->_errores[$p_Nombre] = trim($p_Error);
    }

    public function getErrores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos) {
        $this->_id = (integer)$p_Datos["usu_Id"];
        //vinculos
        $this->_client_id = (integer)$p_Datos["usu_Cli_Id"];
        $this->_tus_id = (integer)$p_Datos["usu_Tus_Id"];
        //datos
        $this->_nombre = (string)$p_Datos["usu_Nombre"];
        $this->_apellido = (string)$p_Datos["usu_Apellido"];
        $this->_te_celular = (string)$p_Datos["usu_Te_Celular"];
        $this->_te_personal = (string)$p_Datos["usu_Te_Personal"];
        $this->_email = (string)$p_Datos["usu_Email"];
        $this->_dni = (string)$p_Datos["usu_Dni"];
        $this->_imagen = (string)$p_Datos["usu_Imagen"];
        $this->_imagen_url = (string)$p_Datos["usu_Imagen_URL"];
        //$this->_usuario = (string)$p_Datos["usu_Usuario"];
        $this->_clave = (string)$p_Datos["usu_Clave"];
        $this->_resetToken = (string)$p_Datos["usu_Reset_Token"];
        $this->_resetTokenDate = strtotime($p_Datos["usu_Reset_Token_Date"]);
        //control
        $this->_creado_el = strtotime($p_Datos["usu_Creado"]);
        $this->_eliminado_el = (is_null($p_Datos["usu_Enable"])) ? null : strtotime($p_Datos["usu_Enable"]);
    }

    public function save($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if (!$this->esValido()) {
            return false;
        }

        $this->_creado_el = time();

        $datos = array(
            //vinculos
            'usu_Cli_Id' => $this->_client_id,
            'usu_Tus_Id' => $this->_tus_id,
            //datos
            'usu_Nombre' => $this->_nombre,
            'usu_Apellido' => $this->_apellido,
            'usu_Te_Celular' => $this->_te_celular,
            'usu_Te_Personal' => $this->_te_personal,
            'usu_Email' => $this->_email,
            'usu_Imagen' => $this->_imagen,
            'usu_Imagen_URL' => $this->_imagen_url,
            'usu_Dni' => $this->_dni,
            //'usu_Usuario' => $this->_usuario,
            'usu_Reset_Token' => $this->_resetToken,
            'usu_Reset_Token_Date' => $this->_resetTokenDate
            //control
            //'usu_Creado' => $this->_creado_el,
            //usu_Enable' => $this->_eliminado_el
        );

        if ($this->_clave != '') {
            $datos['usu_Clave'] = sha1($this->_clave);
        }
        /* 		if($this->_clave != '') {
          $salt = substr(sha1(time()), 0, 20);
          $claveSha1 = sha1($this->_clave.$salt);
          $datos['clave'] = $claveSha1;
          $datos['salt']  = $salt;
          }
         */
        if ($this->_id == 0) {
            $datos['usu_Creado'] = date('Y-m-d H:i:s', $this->_creado_el);

            $resultado = $cnn->Insert('usuario', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('usuario', $datos, "usu_Id = {$this->_id}");
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

        $this->_eliminado_el = time();

        $datos['usu_Enable'] = date('Y-m-d H:i:s', $this->_eliminado_el);

        $resultado = $cnn->Update('usuario', $datos, "usu_Id = {$this->_id}");

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
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

        $datos['usu_Enable'] = $this->_eliminado_el;

        $resultado = $cnn->Update('usuario', $datos, "usu_Id = {$this->_id}");

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
        $array['dni'] = $this->_dni;
        $array['apellido'] = $this->_apellido;
        $array['nombre'] = $this->_nombre;
        $array['telefono_celular'] = $this->_te_celular;
        $array['telefono_fijo'] = $this->_te_personal;
        $array['email'] = $this->_email;
        if($incluir_imagen) {
            $array['imagen_url'] = $this->_imagen_url;
            if($this->_imagen!='')
                $array['imagen_data'] = $fileContents = base64_encode(file_get_contents($this->_imagen));
        }
        $array['tipo'] = $this->_tus_id;

        return $array;
    }

}
