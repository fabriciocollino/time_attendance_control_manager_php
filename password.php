<?php


require_once(dirname(__FILE__) . '/_ruta.php');

require_once(APP_PATH . '/libs/random/random.php');

//fuerzo que el login sea por SSL
if(Config_L::p('force_ssl'))
		if(!isHTTPS())
				forceSSL();

if (isset($_POST['btnLogout'])) {
	header('Location: ' . WEB_ROOT . '/logout.php');
	exit();
}


$T_Email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$T_Token = isset($_REQUEST['t']) ? $_REQUEST['t'] : '';
$T_Clave = isset($_REQUEST['clave']) ? $_REQUEST['clave'] : '';
$T_ReClave = isset($_REQUEST['re_clave']) ? $_REQUEST['re_clave'] : '';
$mensaje='';

//echo "<pre>";print_r($_REQUEST);echo "</pre>";

if (isset($_SESSION['USUARIO'])) {
    header('Location: ' . WEB_ROOT. '/');
    exit();
}

//echo "<pre>";print_r($o_Cliente);echo "</pre>";


if (isset($_POST['btnReset'])) {
    
    if(SeguridadHelper::CheckResetEmailAttempts($_SERVER['REMOTE_ADDR'])){
    
        if($T_Email!=''){
            $o_Usuario = Usuario_L::obtenerPorEmail($T_Email);
            
            if (is_null($o_Usuario)) {
                    //el email no existe, guardo un log
                    $T_Error="El email no existe.";
                    SeguridadHelper::Reset(0,$T_Email);
            } else {
                    //genero los tokens, para enviar por email
                    SeguridadHelper::Reset($o_Usuario->getId(),$T_Email);
                    $token = bin2hex(random_bytes(50));
                    $o_Usuario->setResetToken($token);                    
                    $o_Usuario->save('Off');     
                    $mail= new Email_O();     
                    $Sujeto="Recuperación de Contraseña";
                    $Cuerpo="Recibimos tu petición para resetear la contraseña.<br/>"
                            . "<br/>"
                            . "<a href=\"https://".$subdominio.".enpuntocontrol.com/password.php?t=".$token."\">Haz click aquí para recuperar tu contraseña</a>"
                            . "<br/><br/><br/>"
                            . "Ante cualquier inconveniente, contacta a nuestro soporte técnico"
                            . "";
                    $mail->setSujeto($Sujeto);
                    $mail->setCuerpo($Cuerpo);
                    $mail->setFrom("Contraseña enPunto");
                    $mail->setDestinatario($o_Usuario->getEmail());
                    $mail->enviar();
                    $mail->setEstado(2); //enviado
                    $mail->setFecha(date("Y-m-d H:i:s"),"Y-m-d H:i:s");
                    $mail->save('Off');
                    
                    $mensaje="Se ha enviado un email, por favor sigue las instrucciones para resetear la contraseña";
	
            }
        }else{
            
            if($T_Token!=''){
                //vengo con el token, reseteo la password si esta todo bien
                if(SeguridadHelper::CheckResetTokenAttempts($_SERVER['REMOTE_ADDR'])){
                    $o_usuario=Usuario_L::obtenerPorToken($T_Token);

                    if(is_null($o_usuario)){
                        //el usuario no existe
                        $T_Token='';
                        $T_Error="El token no es válido";
                        SeguridadHelper::Reset(0,'');
                    }else{
                        if($T_Clave!='' && $T_ReClave!=''){
                            SeguridadHelper::Reset($o_usuario->getId());
                            //reseteo la password
                            $o_usuario->setClave($T_Clave);
                            $o_usuario->setConfirmacionClave($T_ReClave);
                            $o_usuario->clearResetToken();
                            $o_usuario->save('Off');

                            $mensaje="Su contraseña se ha reseteado correctamente.<br/> Vuelva a ingresar <a href=\"https://".$subdominio.".enpuntocontrol.com\">aquí</a>.";
                        }
                    }
                }else{
                    $T_Token='';
                    $T_Error="Bloqueado por varios intentos fallidos. Intente nuevamente más tarde.";
                }
            }
        }
    }else{
        $T_Error="Bloqueado por varios intentos fallidos. Intente nuevamente más tarde.";
    }
}
else{
    if($T_Token!=''){
        //vengo con el token, reseteo la password si esta todo bien
        if(SeguridadHelper::CheckResetTokenAttempts($_SERVER['REMOTE_ADDR'])){
            $o_usuario=Usuario_L::obtenerPorToken($T_Token);

    //echo $o_usuario->getNombre();
            if(is_null($o_usuario)){
                //el usuario no existe
                
                SeguridadHelper::Reset(0,'');
                $T_Token='';
                $T_Error='El Token no es válido';
            }else{
                //reseteo la password
                //tengo el usuario
            }
        }else{
            $T_Token='';
            $T_Error="Bloqueado por varios intentos fallidos. Intente nuevamente más tarde.";
            $mensaje='';
        }
    }
    
    
    
}
//if(isHTTPS())echo "Conexión segura";
//echo $_SERVER["HTTP_X_FORWARDED_FOR"];

require_once APP_PATH . '/templates/password.html.php';