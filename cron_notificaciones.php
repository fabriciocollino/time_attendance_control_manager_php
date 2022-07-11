<?php

$_SERVER['X-Appengine-Cron'] = true;

require_once(dirname(__FILE__) . '/_ruta.php');

require_once(dirname(__FILE__) . '/codigo/libs/pdf/reportes.php');

$errores = array();

$ErroresTipo = isset($_REQUEST['errorestipo']) ? (string)$_REQUEST['errorestipo'] : '';


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

        if(GAE) {
            if (!$G_DbConn1->ConectarSocket()) {
                die($G_DbConnMGR->get_Error($Registry->general['debug']));
            }
        }else{
            if (!$G_DbConn1->Conectar()) {
                die($G_DbConnMGR->get_Error($Registry->general['debug']));
            }
        }

        Registry::getInstance()->DbConn = $G_DbConn1;

        /*
         * Reviso todas las notificaciones ACTIVAS
         */
        $a_o_Notificaciones = Notificaciones_L::obtenerTodosActivos();
        if ($a_o_Notificaciones == null) die();
        foreach ($a_o_Notificaciones as $o_Notificacion) {
            /* @var $o_Notificacion Notificaciones_O */

            if ($o_Notificacion->getTipoD() == 0 || $o_Notificacion->getTipoD() == 100) {//si la notificacion es inmediata, busco la que sigue. Porque las notificaciones inmediatas se manejan en el cron.php

                if ($o_Notificacion->getTipoD() == 0 && $o_Notificacion->getDisparador() != NOT_AUSENCIA) {
                    continue;
                }
            }


            //reportes automaticos
            if($o_Notificacion->getTipoD()>0) {
                if (time() >= strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s"))) {  //si tengo que ejecutar la notificacion

                    //ejecuto la notificacion
                    $o_Notificacion->enviar();

                    if ($o_Notificacion->getTipoD() == 1)
                        $o_Notificacion->setHoraD(date("Y-m-d H:i:s", strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s") . "+1 day")), "Y-m-d H:i:s");//sumo un dia
                    if ($o_Notificacion->getTipoD() == 2)
                        $o_Notificacion->setHoraD(date("Y-m-d H:i:s", strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s") . "+1 week")), "Y-m-d H:i:s");//sumo una semana
                    if ($o_Notificacion->getTipoD() == 3)
                        $o_Notificacion->setHoraD(date("Y-m-d H:i:s", strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s") . "+15 days")), "Y-m-d H:i:s");//sumo 15 dias
                    if ($o_Notificacion->getTipoD() == 4)
                        $o_Notificacion->setHoraD(date("Y-m-d H:i:s", strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s") . "+1 month")), "Y-m-d H:i:s");//sumo un mes
                    if ($o_Notificacion->getTipoD() == 5)
                        $o_Notificacion->setHoraD(date("Y-m-d H:i:s", strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s") . "+1 year")), "Y-m-d H:i:s");//sumo un year

                    $o_Notificacion->save('Off');
                }
            }


            //cambio la hora para la sigujiente ejecucion
            if ($o_Notificacion->getTipoD() == 0) {
                if ($o_Notificacion->getDisparador() == NOT_AUSENCIA) {

                    $dia=date('w');
                    if($o_Notificacion->getHorariosD($dia)=='--:--')continue; //no se ejecuta hoy
                    $horarioDeHoy= date('Y-m-d').' '.$o_Notificacion->getHorariosD($dia).':00';
                    $ayer=strtotime('-24 hours', time());
/*
                    //echo "<pre>";print_r($o_Notificacion);echo"</pre>";
                    echo "<br>Id: ".$o_Notificacion->getId();
                    echo "<br>Dia: ".$dia;
                    echo "<br>HorariodeHoy: ".$horarioDeHoy;
                    echo "<br>HoraActual: ".date('Y-m-d H:i:s');
                    echo "<br>HorariodeHoy: ".strtotime($horarioDeHoy);
                    echo "<br>HoraActual: ".strtotime(date('H:i'));
                    echo "<br>time(): ".time();
                    echo "<br>HoraD(): ".$o_Notificacion->getHoraD("Y-m-d H:i:s");
                    echo "<br>HoraD(): ".strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s"));
                    echo "<br>ayer ".$ayer;
                    echo "<br>resta ".(strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s"))-$ayer);
*/

                    if(strtotime($horarioDeHoy)<strtotime(date('Y-m-d H:i:s'))){

                        if((strtotime($o_Notificacion->getHoraD("Y-m-d H:i:s"))-$ayer)<0){//quiere decir que hace 24 horas que se ejecuto
                            //chequeo ausencias
                            
                            //busco los logs de personas o grupos HOY
                            //TODO: esto no va a andar para los horarios nocturnos
                            $condicion= "'".date("Y-m-d 00:00:00")."' <= leq_Fecha_Hora";
                               
                            $ausencias=0; 

                            if($o_Notificacion->getPersonaD()==0 && $o_Notificacion->getGrupoD()==0){//TODAS LAS PERSONAS
                                $cant_Logs=Logs_Equipo_L::getCount($condicion);//probar porque la acabo de hacer
                                if($cant_Logs==0)//no hay nadie
                                    $ausencias=1;
                            }
                            else if($o_Notificacion->getPersonaD()==0 && $o_Notificacion->getGrupoD()!=0){//POR GRUPO
                                $cant_Logs=Logs_Equipo_L::getCountxGrupo($condicion,$o_Notificacion->getGrupoD());
                                if($cant_Logs==0)//no hay nadie
                                    $ausencias=1;
                            }
                            else if($o_Notificacion->getPersonaD()!=0 && $o_Notificacion->getGrupoD()==0){//PERSONA INDIVIDUAL
                                $cant_Logs=Logs_Equipo_L::getCountxPersona($o_Notificacion->getPersonaD(),$condicion); //probar esta funcion porque la acabo de hacer
                                if($cant_Logs==0)//no hay nadie
                                    $ausencias=1;
                            }

                            if($ausencias)
                                $o_Notificacion->enviar();
                            
                            $o_Notificacion->setHoraD(date("Y-m-d H:i:s",time()),"Y-m-d H:i:s");//actualizo la hora de disparo
                            $o_Notificacion->save('Off');
                        }
                    }
                } 
            }


        }


        $Cron = Cron_L::obtenerPorNombre('cron_notificaciones.php');
        $Cron->setTimestamp(time());
        $Cron->Save('Off');


    }
}

session_destroy();

//muestro los errores

if ($ErroresTipo == '') {
    foreach ($errores as $error) {
        echo $error[1];
    }
}