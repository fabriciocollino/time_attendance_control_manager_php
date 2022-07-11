<?php

require_once(APP_PATH . '/libs/random/random.php');

$T_Titulo = _('Usuarios');
$T_Script = 'usuarios';
$Item_Name = "usuarios";
$T_Link = '';
$T_Mensaje = '';

$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Tipo_Check = (isset($_REQUEST['tipo_check'])) ? $_REQUEST['tipo_check'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;

$T_IMGBorrar = (isset($_POST['inputBorrarImagen'])) ? $_POST['inputBorrarImagen'] : '';
$T_IMGExtension = (isset($_POST['inputImageExtension'])) ? $_POST['inputImageExtension'] : '';
$T_IMG = (isset($_POST['inputIMGsrc'])) ? $_POST['inputIMGsrc'] : '';
$T_IMGx = (isset($_POST['inputIMGx'])) ? $_POST['inputIMGx'] : '';
$T_IMGy = (isset($_POST['inputIMGy'])) ? $_POST['inputIMGy'] : '';
$T_IMGw = (isset($_POST['inputIMGw'])) ? $_POST['inputIMGw'] : '';
$T_IMGh = (isset($_POST['inputIMGh'])) ? $_POST['inputIMGh'] : '';


switch ($T_Tipo) {
    case 'view':
        $o_Usuario = Usuario_L::obtenerPorId($T_Id);
        if (is_null($o_Usuario)) {
            $o_Usuario = new Usuario_O();
        }
        if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 99) {
            $T_UsuarioTipo = HtmlHelper::array2htmloptions(UsuarioTipo_L::obtenerTodos(), $o_Usuario->getTusId(), true, true, '', 'Tipo de Usuario');
        } else {
            $T_UsuarioTipo = HtmlHelper::array2htmloptions(UsuarioTipo_L::obtenerTodos('codigo < ' . Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo()), $o_Usuario->getTusId(), true, true, '', 'Tipo de Usuario');
        }
        break;
    case 'check':
        $o_Usuario = Usuario_L::obtenerPorId($T_Id);
        if (is_null($o_Usuario)) {
            $o_Usuario = new Usuario_O();
        }

        switch ($T_Tipo_Check) {
            case 'c_usuario':
                if ($o_Usuario->getEmail() != $_POST['email'])
                    $o_Usuario->setEmail(isset($_POST['email']) ? $_POST['email'] : '');
                $T_Error = $o_Usuario->getErrores();
                if (!is_null($T_Error) && array_key_exists('usuario', $T_Error)) echo $T_Error['usuario']; else echo "true";
                break;
            case 'c_dni':
                $o_Usuario->setDni(isset($_POST['dni']) ? $_POST['dni'] : '');
                $T_Error = $o_Usuario->getErrores();
                if (!is_null($T_Error) && array_key_exists('dni', $T_Error)) echo $T_Error['dni']; else echo "true";
                break;
        }
        die();
        break;
    case 'add':
    case 'edit':

        SeguridadHelper::Pasar(90);
        $o_Usuario = Usuario_L::obtenerPorId($T_Id);

        if (is_null($o_Usuario)) {
            $o_Usuario = new Usuario_O();
        }

        if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 99) {
            $o_Usuario->setTusId(isset($_POST['usuario_tipo']) ? $_POST['usuario_tipo'] : 0);
            //$o_Usuario->setUsuario(isset($_POST['usuario']) ? $_POST['usuario'] : '');
        }

        //seguridad
        if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() < 999){
            if($o_Usuario->getTusId()==1)die('nop :)');
        }

        if($T_Tipo=='edit')
            $o_Usuario->setClave('');//para que no se cambie la clave

        if(isset($_POST['clave']) && $_POST['clave']!=''){
            if(isset($_POST['re_clave']) && $_POST['re_clave']!=''){
                if($_POST['clave']==$_POST['re_clave']){
                    $o_Usuario->setClave(isset($_POST['clave']) ? $_POST['clave'] : '');
                    $o_Usuario->setConfirmacionClave(isset($_POST['re_clave']) ? $_POST['re_clave'] : '');
                }
            }
        }
        $o_Usuario->setNombre(isset($_POST['nombre']) ? $_POST['nombre'] : '');
        $o_Usuario->setApellido(isset($_POST['apellido']) ? $_POST['apellido'] : '');
        $o_Usuario->setDni(isset($_POST['dni']) ? $_POST['dni'] : '');
        $o_Usuario->setTeCelurar(isset($_POST['te_celular']) ? $_POST['te_celular'] : '');
        $o_Usuario->setTePersonal(isset($_POST['te_personal']) ? $_POST['te_personal'] : '');
        $o_Usuario->setEmail(isset($_POST['email']) ? $_POST['email'] : '');

        if ($T_IMGBorrar != '') {
            $o_Usuario->setImagen('');
        }

        if ($T_IMG != '') {//viene una imagen nueva

            $src = GS_CLIENT_TEMP_FOLDER . $T_IMG;

            if($T_IMGExtension=='image/png')
                $img_r = imagecreatefrompng($src);
            else if($T_IMGExtension=='image/gif')
                $img_r = imagecreatefromgif($src);
            else if($T_IMGExtension=='image/jpg')
                $img_r = imagecreatefromjpeg($src);
            else if($T_IMGExtension=='image/jpeg')
                $img_r = imagecreatefromjpeg($src);
            else
                $o_Usuario->setErrores('imagen','formato no soportado');

            $dst_w = 250;
            $dst_h = 250;
            $dst_r = ImageCreateTrueColor($dst_w, $dst_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $T_IMGx, $T_IMGy, $dst_w, $dst_h, $T_IMGw, $T_IMGh);

            $filename = md5(time().uniqid()).".jpg";
            $path=GS_CLIENT_IMAGES_USUARIOS.$o_Usuario->getId()."/";

            if (!file_exists($path))
                mkdir($path, 0777, true);

            imagejpeg($dst_r, $path.$filename, 100);

            $o_Usuario->setImagen($path.$filename);
            $o_Usuario->setImagenURL('');
        }

        
        $nuevo_usuario = 0;
        if ($o_Usuario->getId() == 0) $nuevo_usuario = 1;//esta variable me permite saber si fue un insert o un edit

        if (!$o_Usuario->save(Registry::getInstance()->general['debug'])) {
            $T_Error = $o_Usuario->getErrores();
        } else {
            if ($nuevo_usuario)
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_USUARIO_CREAR, $a_Logs_Tipos[LOG_USUARIO_CREAR], '<b>Id:</b> ' . $o_Usuario->getId() . ' <b>Usuario:</b> ' . $o_Usuario->getEmail() . ' <b>Nombre:</b> ' . $o_Usuario->getNombreCompleto(), $o_Usuario->getId());
            else
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_USUARIO_EDITAR, $a_Logs_Tipos[LOG_USUARIO_EDITAR], '<b>Id:</b> ' . $o_Usuario->getId() . ' <b>Usuario:</b> ' . $o_Usuario->getEmail() . ' <b>Nombre:</b> ' . $o_Usuario->getNombreCompleto(), $o_Usuario->getId());
            $T_Mensaje = _('El usuario fue modificado con éxito.');
        }

        if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 99) {
            $T_UsuarioTipo = HtmlHelper::array2htmloptions(UsuarioTipo_L::obtenerTodos(), $o_Usuario->getTusId(), true, true, '', 'Tipo de Usuario');
        } else {
            $T_UsuarioTipo = HtmlHelper::array2htmloptions(UsuarioTipo_L::obtenerTodos('codigo < ' . Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo()), $o_Usuario->getTusId(), true, true, '', 'Tipo de Usuario');
        }
        $T_Modificar = true;
        goto defaultlabel;
        break;

    case 'enable':
        SeguridadHelper::Pasar(90);

        $o_Usuario = Usuario_L::obtenerPorId($T_Id, true);

        if (is_null($o_Usuario)) {
            $T_Error = _('Lo sentimos, el usuario que desea habilitar no existe.');
        }

        if (!is_null($o_Usuario)) {
            if (!$o_Usuario->undelete(Registry::getInstance()->general['debug'])) {
                //$T_Error = 'Lo sentimos, el usuario que desea habilitar no puede ser modificado.';
                $T_Error = $o_Usuario->getErrores();
            } else {
                //SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[2], 'Tabla - ' . $T_Script . ' Id - ' . $o_Usuario->getId());
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_USUARIO_DESBLOQUEAR, $a_Logs_Tipos[LOG_USUARIO_DESBLOQUEAR], '<b>Id:</b> ' . $o_Usuario->getId() . ' <b>Usuario:</b> ' . $o_Usuario->getEmail() . ' <b>Nombre:</b> ' . $o_Usuario->getNombreCompleto(), $o_Usuario->getId());
                $T_Mensaje = _('El usuario fue habilitado con éxito.');
            }
        }

        $T_Habilitando = true;
        goto defaultlabel;
        break;
    case 'disable':
        SeguridadHelper::Pasar(90);

        $o_Usuario = Usuario_L::obtenerPorId($T_Id);

        if (is_null($o_Usuario)) {
            $T_Error = _('Lo sentimos, el usuario que desea eliminar no existe.');
        }

        if (!is_null($o_Usuario)) {
            if(Registry::getInstance()->Usuario->getId()==$o_Usuario->getId()){
                $T_Error = "Lo sentimos, no se puede bloquear a sí mismo.";
            }else{
                if (!$o_Usuario->delete(Registry::getInstance()->general['debug'])) {
                    //$T_Error = 'Lo sentimos, el usuario que desea eliminar no puede ser eliminado.';
                    $T_Error = $o_Usuario->getErrores();
                } else {
                    //SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[3], 'Tabla - ' . $T_Script . ' Id - ' . $o_Usuario->getId());
                    SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_USUARIO_BLOQUEAR, $a_Logs_Tipos[LOG_USUARIO_BLOQUEAR], '<b>Id:</b> ' . $o_Usuario->getId() . ' <b>Usuario:</b> ' . $o_Usuario->getEmail() . ' <b>Nombre:</b> ' . $o_Usuario->getNombreCompleto(), $o_Usuario->getId());
                    $T_Mensaje = _('El usuario fue bloqueado con éxito.');
                }
            }

        }

        $T_Eliminado = true;
        goto defaultlabel;
        break;

    case 'enviaremail':
        SeguridadHelper::Pasar(999);

        $o_Usuario = Usuario_L::obtenerPorId($T_Id);

        if (is_null($o_Usuario)) {
            $T_Error = _('Lo sentimos, el usuario que desea no existe.');
        }

        if (!is_null($o_Usuario)) {


            $token = bin2hex(random_bytes(50));
            $o_Usuario->setResetToken($token);
            $o_Usuario->save('Off');

            $mail= new Email_O();
            $Sujeto="Bienvenido a enPunto!";
            $Cuerpo="Tu usuario enPunto ha sido creado!<br/>"
                . "<br/>"
                . "Para poder ingresar, necesitas generar una contraseña desde el siguiente enlace:"
                . "<br/>"
                . "<br/>"
                . "<div style=\"width:100%;text-align:center;\">"
                . "<a class=\"btn\" href=\"https://".$subdominio.".enpuntocontrol.com/password.php?t=".$token."\" style=\"margin: 0;padding: 6px 12px;font-family: &quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;color: #333;display: inline-block;margin-bottom: 0;font-size: 14px;font-weight: normal;line-height: 1.428571429;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;border: 1px solid transparent;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;background-color: white;border-color: #CCC;\">"
                . "Haz click aquí para generar tu contraseña</a>"
                . "</div>"
                . "<br/>"
                . "<br/><br/>"
                . "Ante cualquier inconveniente, contacta a nuestro soporte técnico"
                . "";
            $mail->setSujeto($Sujeto);
            $mail->setCuerpo($Cuerpo);
            $mail->setFrom("Usuario enPunto");
            $mail->setDestinatario($o_Usuario->getEmail());
            $mail->enviar();
            $mail->setEstado(2); //enviado
            $mail->setFecha(date("Y-m-d H:i:s"),"Y-m-d H:i:s");
            $mail->save('Off');
        }

        $T_Eliminado = true;
        goto defaultlabel;
        break;
    case 'show':
        SeguridadHelper::Pasar(90);
        $o_Usuario = Usuario_L::obtenerPorId($T_Id, true);

        if (is_null($o_Usuario)) {
            $T_Error = _('Lo sentimos, el usuario no existe.');
        }

        $T_Link = '_mos';
        break;
    default:
        defaultlabel:
        SeguridadHelper::Pasar(90);
        if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999)
            $o_Listado = Usuario_L::obtenerTodosSP('', '', 'ASC');
        else
            $o_Listado = Usuario_L::obtenerTodosSP(' usu_Tus_Id<>1 ', '', 'ASC');
        $T_Link = '';
}
