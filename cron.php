<?php

$_SERVER['X-Appengine-Cron']=true;

require_once(dirname(__FILE__) . '/_ruta.php');


$errores = array();

$ErroresTipo = isset($_REQUEST['errorestipo']) ? (string)$_REQUEST['errorestipo'] : '';
$CronTipo = isset($_REQUEST['tipo']) ? (string)$_REQUEST['tipo'] : '';
$DebugCron = isset($_REQUEST['debug']) ? 1 : 0;


$additionalHeaders = "";
$payloadName = "";

//if(date('i')>=54&&date('i')<55){echo "si";die();}else {echo "no".date('i');die();}

if ($DebugCron) echo "</br>Iniciando CRON JOB";
if ($DebugCron) echo "</br>Último cron: " . Cron_L::obtenerPorNombre('cron.php')->getFechaHora();


$a_Clientes = Cliente_L::obtenerTodosEnabled();
if (!is_null($a_Clientes)) {


    foreach ($a_Clientes as $o_Cliente) {
        /* @var $o_Cliente Cliente_O */

        $subdominio = $o_Cliente->getSubdominio();
        $o_Suscripcion = Suscripcion_L::obtenerPorId($o_Cliente->getSuscripcion());
        $o_Plan = Planes_L::obtenerPorId($o_Suscripcion->getPlan());
        $G_DbConn1 = new mySQL(
            $o_Cliente->getDBname(),
            $o_Cliente->getDBuser(),
            $o_Cliente->getDBpass(),
            $o_Cliente->getDBhost(),
            $o_Cliente->getDBport()
        );


        if (!$G_DbConn1->ConectarSocket()) {
            die($G_DbConnMGR->get_Error($Registry->general['debug']));
        }

        Registry::getInstance()->DbConn = $G_DbConn1;






        $a_o_Equipo = Equipo_L::obtenerTodos();


        
//NOTIFICACIONES INMEDIATAS, PERO QUE NO TIENEN RELACION CON LOS LOGS QUE LLEGAN

        if ($CronTipo == '' || $CronTipo == 'not_equipo_pierde_conexion') {
            if ($a_o_Equipo != null) {
                foreach ($a_o_Equipo as $o_Equipo) {
                    $ip = $o_Equipo->getIp();
                    if (!empty ($ip)) {
                        //me fijo el tiempo del ultimo heartbeat del equipo, para ver si se perdio la conexion y mandar la notificacion si es necesario.
                        $tiempoG = (integer)time() - (integer)$o_Equipo->getHeartbeat('U');
                        if ($tiempoG > 60 && $tiempoG < 120) {//esto es para que solo se ejecute una sola vez.
                            $a_o_Notificaciones = Notificaciones_L::obtenerTodosActivos();
                            if ($a_o_Notificaciones != null) {
                                foreach ($a_o_Notificaciones as $o_Notificacion) {
                                    if ($o_Notificacion->getDisparador() != NOT_PERDIDA_DE_CONEXION)//solo sigo si el disparador es que el equipo pierde conexion
                                        continue;
                                    if ($o_Notificacion->getEquipoD() == 0) {
                                        //TODOS LOS GATEWAYS
                                        $o_Notificacion->enviar(0, 0, $o_Equipo->getId());
                                    } else if ($o_Notificacion->getEquipoD() == $o_Equipo->getId()) { //si coincide el equipo del disparador con el equipo del log
                                        //GATEWAY INDIVIDUAL
                                        $o_Notificacion->enviar();
                                    }
                                }
                            }
                        }//repeticion de la notificacion de desconexion
                        else if (Config_L::p('repetir_notificacion_equipo_desconectado') && $tiempoG > 60) {

                            $tiempoDeRepeticion = Config_L::p('repeticion_notifiacion_equipo_desconectado');
                            $tiempoDeRepeticion = $tiempoDeRepeticion * 60; //lo paso a segundos

                            //esto es para que se ejecute una sola vez por intervalo
                            $multiplo = $tiempoG / $tiempoDeRepeticion;
                            $multiploENT = (int)($tiempoG / $tiempoDeRepeticion);
                            $muliploMax = ($multiploENT * $tiempoDeRepeticion + 60) / $tiempoDeRepeticion;
                            $muliploMin = ($multiploENT * $tiempoDeRepeticion - 60) / $tiempoDeRepeticion;

                            if ($multiplo > $muliploMin && $multiplo < $muliploMax) {

                                $a_o_Notificaciones = Notificaciones_L::obtenerTodosActivos();
                                if ($a_o_Notificaciones != null) {
                                    foreach ($a_o_Notificaciones as $o_Notificacion) {
                                        if ($o_Notificacion->getDisparador() != NOT_PERDIDA_DE_CONEXION)//solo sigo si el disparador es que el equipo pierde conexion
                                            continue;
                                        if ($o_Notificacion->getEquipoD() == 0) {
                                            //TODOS LOS GATEWAYS
                                            $o_Notificacion->enviar(0, 0, $o_Equipo->getId());
                                        } else if ($o_Notificacion->getEquipoD() == $o_Equipo->getId()) { //si coincide el equipo del disparador con el equipo del log
                                            //GATEWAY INDIVIDUAL
                                            $o_Notificacion->enviar();
                                        }
                                    }
                                }
                            }
                        }


                    }
                }
            }
        }


//Proceso de actualizacion de la tabla de sync

        /*
         * Busco todos los registros de la tabla sync cuyo status sea distinto de 3 (ok).
         *
         * Pregunto si la diferencia entre la fecha_hora del registro con la fecha actual es mayor a 1 minuto, si es asi, me fijo si el registro tiene un staus 2 (enviado pero no recibido por el equipo)
         * y el contador de reintentos sea menor a 3. entonces, lo vuelvo a poner en status 1, y sumo 1 al contador de re-intentos
         *
         * si el contador de reintentos es mayor o igual a 3, envio una notificacion al grupo de administradores del sistema.
         *
         *
         *
         *
         *
         */




//Proceso de envio de emails
        if ($CronTipo == '' || $CronTipo == 'email') {
            $a_Email_Listado = Email_L::obtenerTodosAEnviar();
            if (count($a_Email_Listado)) {
                foreach ($a_Email_Listado as $o_Email) {
                    /* @var $o_Email Email_O */
                    //TODO: Mostrar errores

                    $o_Email->enviar();
                    $o_Email->setEstado(2); //enviado
                    $o_Email->setFecha($o_Email->getFecha("Y-m-d H:i:s"), "Y-m-d H:i:s");

                    $o_Email->save('Off');

                }
            }
        }

        /*
         TODO: hacer las funciones en el equipo y reemplazar esto por mqtt
        //Obtengo el numero de serie de los equipos
        if ($CronTipo == '' || $CronTipo == 'serial') {
            $a_o_Equipo2 = Equipo_L::obtenerTodos();
            if ($a_o_Equipo2 != null) {
                foreach ($a_o_Equipo2 as $o_Equipo2) {
                    if ($o_Equipo2->getIp() != '') {
                        if ($o_Equipo2->getVersion() == '') {
                            if (!ConsolaHelper::ejecutarComandoConsola('get hardware info', $o_Equipo2, 0)) {
                                $errores[] = array('SERIAL', "<br>" . _('No se puede enviar comandos al Equipo') . " \"" . $o_Equipo2->getHost() . "\" " . _('IP') . ": " . $o_Equipo2->getIp());
                                continue;
                            }
                        }
                    }
                }
            }
        }
        */

//Tareas Mensuales
        if ($CronTipo == 'mensual') {

            //TODO  Limpiar archivos temporales

        }

//TODO: mover esto a otro cron que sea por hora
//Tareas por Hora
        if ($CronTipo == 'hora') {

            //TODO  Limpiar tokens de usuario

            $a_usuarios = Usuario_L::obtenerTodosSPconTokens('usu_ResetTokenDate <= DATE_SUB(NOW(),INTERVAL 1 HOUR)');
            if (!is_null($a_usuarios)) {
                foreach ($a_usuarios as $o_Usuario) {
                    if ($o_Usuario->getResetTokenDate()) {
                        $o_Usuario->clearResetToken();
                        $o_Usuario->save('Off');
                    }
                }
            }
        }


        /*  ***************  INICIO DEL CHEQUEO DE LA LICENCIA  ****************  */
        /*
        Reviso el estado de la licencia en el servidor remoto.  Si se cumplio el tiempo de espera, actualizo la licencia local.
        Este código solo se ejecuta cuando el tipo de cron es 'licencia'

        */
        if ($Usar_Licencia) {
            if ($CronTipo == 'licencia') {

                //obtengo los datos de la licencia local
                $Licencia = Licencia_L::obtenerLicencia();
                if ($Licencia == null) {
                    session_destroy();
                    die(_("Los datos de la licencia local no son válidos. No se puede continuar."));
                }

                $serverURL = "https://server1.tekbox.com.ar/tasm-licencias/check-licencia.php";
                $datosPOST = "a=check&u=" . $Licencia->getUser() . "&c=" . $Licencia->getPass();


                $process = curl_init($serverURL);
                curl_setopt($process, CURLOPT_USERAGENT, 'PHP-ACSM');
                curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($process, CURLOPT_HEADER, false);
                curl_setopt($process, CURLOPT_TIMEOUT, 50);
                curl_setopt($process, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($process, CURLOPT_POST, 1);
                curl_setopt($process, CURLOPT_POSTFIELDS, $datosPOST);
                curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($process, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
                $return = curl_exec($process);


                if (empty($return)) {
                    //NO SE PUDO CONECTAR AL SERVIDOR DE LICENCIAS


                } else {
                    $return = explode("\r\n", $return);
                    //print_r($return);

                    if ($return[0] == "OK") {//el usuario y la contraseña existen en el servidor
                        if ($return[1] == "LICENCE CHECK RESULT OK") {
                            //LICENCIA VALIDA
                            $Licencia->setEnabled(1);
                            $Licencia->setLast_heartbeat(time());
                            $Licencia->save('Off');

                        } else if ($return[1] == "LICENCE NOT ENABLED") {
                            //LICENCIA INCORRECTA
                            $Licencia->setEnabled(0);
                            $Licencia->save('Off');
                        }
                    }

                }

                curl_close($process);
            }
        }
        /*  ***************  FIN DEL CHEQUEO DE LA LICENCIA  ****************  */


        if ($DebugCron) echo "</br></br> ERRORES:</br>";


//muestro los errores

        if ($ErroresTipo == 'logs') {
            foreach ($errores as $error) {
                if ($error[0] == 'LOGS') echo $error[1];
            }
        } else if ($ErroresTipo == 'sync') {
            foreach ($errores as $error) {
                if ($error[0] == 'SYNC_STATUS') echo $error[1];
            }
        } else if ($ErroresTipo == '') {

            foreach ($errores as $error) {
                //echo $error[0]." - ".$error[1];
                echo $error[1];
            }
        }


        /* Limpio SESIONES viejas. */
//system("find " . realpath(dirname(__FILE__)) . "/codigo/data/sesiones -type f -name 'sess_*' -mmin +24 -delete");


        /* Limpio logs heartbeat viejos */
        $cnn = Registry::getInstance()->DbConn;
        $cnn->Query("DELETE FROM `logs_heartbeat` WHERE loh_Heartbeat < (NOW() - INTERVAL 1 HOUR)");


        $Cron = Cron_L::obtenerPorNombre('cron.php');
        $Cron->setTimestamp(time());
        $Cron->Save('Off');


//flock($fp, LOCK_UN); // release the lock
//cronHelper::unlock("cron.php");
//}
//else{
//	die(_("El recurso está en uso"));
//}

//fclose($fp);


        /*
         * Si el llamado vino desde el sistema, no destruyo la sesion, pero si vino desde el cron comun si
         */


    }
}


if ($CronTipo != 'logs')
    session_destroy();

