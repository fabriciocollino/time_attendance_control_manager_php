<?php


$_SERVER['X-Appengine-Cron']=true;

require_once(dirname(__FILE__) . '/_ruta.php');
require_once(APP_PATH . '/libs/random/random.php');

$subdominio = 'brazzalotto';
$destinatarioNombre = "Leonardo";
$destinatario = 'leonardobrazzalotto@gmail.com';
//$destinatario = 'diegosucaria@gmail.com';

//ogiraudo@giraudoequipamiento.com

$token = bin2hex(random_bytes(50));
//$o_Usuario->setResetToken($token);
//$o_Usuario->save('Off');



$mail= new Email_O();
$Sujeto="Bienvenido a enPunto!";
$Cuerpo="<h3>Tu cuenta enPunto ya se encuentra activa!</h3><br/>"
    . "<br/>"
    . "<b>Éstos son los datos para acceder a tu cuenta:</b>"
    . "<br/>"
    . "<br/>"
    . "<span style=\"width:20%;display:inline-block;\">URL Empresa:</span><b>".$subdominio."</b>"
    . "<br/>"
    . "<span style=\"width:20%;display:inline-block;\">Usuario:</span><b>".$destinatario."</b>"
    . "<br/>"
    . "<span style=\"width:20%;display:inline-block;\">Contraseña:</span><i>Podés generarla <a href=\"https://".$subdominio.".enpuntocontrol.com/password.php\">aquí</a></i>"
    . "<br/>"
    . "<br/>"
    . "Para ingresar al sistema, sigue el siguiente enlace:"
    . "<br/>"
    . "<br/>"
    . "<br/>"
    . "<div style=\"width:100%;text-align:center;\">"
    . "<a class=\"btn\" href=\"https://".$subdominio.".enpuntocontrol.com\" style=\"margin: 0;padding: 6px 12px;font-family: &quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;color: #333;display: inline-block;margin-bottom: 0;font-size: 14px;font-weight: normal;line-height: 1.428571429;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;border: 1px solid transparent;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;background-color: white;border-color: #CCC;\">"
    . "Login enPunto</a>"
    . "</div>"
    . "<br/>"
    . "<br/>"
    . "<br/>"
    . "Te recordamos que al utilizar nuestro sistema, estás aceptando nuestros "
    . "<a href=\"https://".$subdominio.".enpuntocontrol.com/terminosycondiciones.pdf\">términos y condiciones</a>"
    . " puedes acceder a ellos desde el link anterior, o desde el sistema, en la sección de ayuda."
    . "<br/><br/><br/>"
    . "Ante cualquier inconveniente, contacta a nuestro soporte técnico"
    . "";
$mail->setSujeto($Sujeto);
$mail->setCuerpo($Cuerpo);
$mail->setSubDominio($subdominio);
$mail->setDestinatarioNombre($destinatarioNombre);
$mail->setFrom("enPunto");
$mail->setDestinatario($destinatario);
$mail->enviar();
$mail->setEstado(2); //enviado
$mail->setFecha(date("Y-m-d H:i:s"),"Y-m-d H:i:s");
$mail->save('Off');






