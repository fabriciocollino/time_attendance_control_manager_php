<?php

ob_start();

function errorCuliado($errno, $errstr, $errfile, $errline){
    syslog(LOG_INFO, "Error: " . $errno . " " . $errstr . " en la linea " . $errline . " del archivo " . $errfile);
}

set_error_handler("errorCuliado");


$_SERVER['X-Appengine-Cron'] = true; //como este archivo se llama mediante un webhook, le pongo esto para que crea que es como un cron


if($_REQUEST['tokenSuperSeguro']!='hue395257d89658016985688c190b2896ca383')die('no vieja jajaj');



require_once(dirname(__FILE__) . '/_ruta.php');


use google\appengine\api\cloud_storage\CloudStorageTools;


//********************************************************************************************************************//
//********************************************************************************************************************//
//************************     INICIO DEL PROCESO DE RECUPERACION DE MENSAJES     ************************************//
//********************************************************************************************************************//
//********************************************************************************************************************//

$inputJSON = file_get_contents('php://input');
$request = json_decode($inputJSON, true);

//die("ok");

$subscription = $request['subscription'];
$message = '';
$message_id = '';
$data = array();
$attributes = array();
$publish_time = '';



if (!isset($request['message']['data']) || !$message = base64_decode($request['message']['data'])) {
    http_response_code(400);
}


$data = json_decode($message,true);

$message_id = $request['message']['message_id'];
$publish_time = $request['message']['publish_time'];
$attributes = $request['message']['attributes'];

$cli_id = null;
if (isset($attributes['cli_id']))
    $cli_id = $attributes['cli_id'];
$eq_uuid = null;
if (isset($attributes['uuid']))
    $eq_uuid = $attributes['uuid'];
$cmd = null;
if (isset($attributes['cmd']))
    $cmd = $attributes['cmd'];
$type = null;
if (isset($attributes['type']))
    $type = $attributes['type'];






//outputeo el mensaje, reemplazando el data por el contenido sin codificar
$request['message']['data'] = $data;
print_r($request['message']);






//********************************************************************************************************************//
//********************************************************************************************************************//
//***************************     INICIO DEL PROCESO DE LOGUEO DEL CLIENTE     ***************************************//
//********************************************************************************************************************//
//********************************************************************************************************************//

$o_Cliente = null;
$o_Cliente = Cliente_L::obtenerPorId($cli_id);

if (is_null($o_Cliente)) {
    die('No se pudo loguear el cliente');
}

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


//********************************************************************************************************************//
//********************************************************************************************************************//
//****************************     INICIO DEL PROCESO DE SINCRONIZACION     ******************************************//
//********************************************************************************************************************//
//********************************************************************************************************************//


switch ($cmd) {
    case CMD_SYNC:
        switch ($type) {
            case TYPE_PERSON:
                break;//type person
            case TYPE_FINGERPRINT:
                break;//type fingerprint
            case TYPE_NORMAL_HOURS:
                break;//type normal hours
            case TYPE_FLEX_HOURS:
                break;//type flex hours
            case TYPE_ROTATIVE_HOURS:
                break;//type rotative hours
            case TYPE_COMPANIES:
                break;//type companies
            case TYPE_GROUPS:
                break;//type groups
            case TYPE_GROUPS_PERSONS:
                break;//type groups persons
            case TYPE_HOLIDAYS:
                break;//type holydays
            case TYPE_LICENSES:
                break;//type licenses
            case TYPE_CONFIG:
                break;//type config
        }//switch type
        break;//cmd sync
    case CMD_ENROLL_OK:

        $o_huella = null;
        $o_huella = Huella_L::obtenerPorId($data['hue_id']);
        if (!is_null($o_huella)) {


            $o_huella->setDatos1($data['hue_datos1']);
            $o_huella->setDatos2($data['hue_datos2']);
            $o_huella->setDatos3($data['hue_datos3']);
            $o_huella->save();

            $o_Persona = Persona_L::obtenerPorId($o_huella->getPerId());

            SeguridadHelper::Log(0, LOG_HUELLA_ENROLL_OK, $a_Logs_Tipos[LOG_HUELLA_ENROLL_OK], '<b>Persona Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto() . ' <b>Huella Id:</b>' . $o_huella->getId(). ' <b>Dedo:</b>' . $o_huella->getDedo(), $o_Persona->getId());
            SyncHelper::SyncHuella($o_huella);
        }

        break;//cmd enroll ok
    case CMD_RFID_READ_OK:

        $o_persona = null;
        $o_persona = Persona_L::obtenerPorId($data['per_id']);

        $o_persona_tag = Persona_L::obtenerPorTag($data['tag']);

        if(!is_null($o_persona_tag)){
            SeguridadHelper::Log(0, LOG_RFID_READ_ERROR, $a_Logs_Tipos[LOG_RFID_READ_ERROR], 'La tarjeta ya existe. <b>Persona Id:</b> ' . $o_persona_tag->getId() . ' <b>Nombre:</b> ' . $o_persona_tag->getNombreCompleto() . ' <b>TAG:</b>' . $o_persona_tag->getTag(), $o_persona_tag->getId());
        }else{
            if (!is_null($o_persona)) {

                $tagViejo = $o_persona->getTag();

                $o_persona->setTag($data['tag']);
                $o_persona->save();

                if($tagViejo!='') //cambio de tag
                    SeguridadHelper::Log(0, LOG_RFID_READ_OK, $a_Logs_Tipos[LOG_RFID_READ_OK], '<b>Persona Id:</b> ' . $o_persona->getId() . ' <b>Nombre:</b> ' . $o_persona->getNombreCompleto() . ' <b>TAG Anterior:</b>' . $o_persona->getTag() . ' <b>TAG Actual:</b>' . $tagViejo, $o_persona->getId());
                else   //tag nuevo
                    SeguridadHelper::Log(0, LOG_RFID_READ_OK, $a_Logs_Tipos[LOG_RFID_READ_OK], '<b>Persona Id:</b> ' . $o_persona->getId() . ' <b>Nombre:</b> ' . $o_persona->getNombreCompleto() . ' <b>TAG:</b>' . $o_persona->getTag(), $o_persona->getId());

                SyncHelper::SyncPersona($o_persona);

            }
        }



        break;//cmd rfid read ok
    case CMD_LOG:

        $resultado = array();

        foreach ($data as $log) {
            $o_Equipo = Equipo_L::obtenerPorUUID($eq_uuid);
            if(isset($o_Equipo)){

                $a_logCP = Logs_Equipo_L::obtenerPorPersonaYTiempo($log['persona'], Config_L::p('tiempo_bloqueo_lectura'));
                if ($a_logCP != null) {
                    //ya hay logs de esta persona dentro del margen de lectura
                    //devuelvo ok, pero no grabo
                    $resultado[] = array('id' => $log['log_id'],'status' => 'OK');
                }else{
                    $o_log = new Logs_Equipo_O($o_Equipo->getId());
                    $o_log->setPerId($log['persona']);
                    $o_log->setLector($log['lector']);
                    $o_log->setFechaHora(date('Y-m-d H:i:s',$log['fecha']), 'Y-m-d H:i:s');
                    $o_log->setAccion($log['accion']);

                    if ($o_log->save()) {
                        $resultado[] = array('id' => $log['log_id'],'status' => 'OK');
                    } else {
                        $resultado[] = array('id' => $log['log_id'],'status' => 'ERROR');
                    }
                }



            }

        }

        PubSubHelper::sendMessage(ACK_LOG, json_encode($resultado), $eq_uuid);

        break;//cmd log
    case CMD_PING:



        $o_Equipo = Equipo_L::obtenerPorUUID($eq_uuid);

        if(is_null($o_Equipo)) {
            echo($eq_uuid . ' no existe');
        }else {
            $o_Equipo->setHeartbeat(time(), 'U');
            $o_Equipo->save('Off');

            $o_Heartbeat = new Heartbeat_O($o_Equipo->getId());
            $o_Heartbeat->setHeartbeat($o_Equipo->getHeartbeat('U'), 'U');
            $o_Heartbeat->save();


            PubSubHelper::sendMessage(CMD_PONG, '', $eq_uuid);


            $sync_companies_time = 0;
            if (isset($data['companies'])) $sync_companies_time = intval($data['companies']);
            $sync_fingerprints_time = 0;
            if (isset($data['fingerprints'])) $sync_fingerprints_time = intval($data['fingerprints']);
            $sync_normal_hours_time = 0;
            if (isset($data['normal_hours'])) $sync_normal_hours_time = intval($data['normal_hours']);
            $sync_rotative_hours_time = 0;
            if (isset($data['rotative_hours'])) $sync_rotative_hours_time = intval($data['rotative_hours']);
            $sync_flex_hours_time = 0;
            if (isset($data['flex_hours'])) $sync_flex_hours_time = intval($data['flex_hours']);
            $sync_groups_time = 0;
            if (isset($data['groups'])) $sync_groups_time = intval($data['groups']);
            $sync_groups_persons_time = 0;
            if (isset($data['groups_persons'])) $sync_groups_persons_time = intval($data['groups_persons']);
            $sync_holidays_time = 0;
            if (isset($data['holidays'])) $sync_holidays_time = intval($data['holidays']);
            $sync_licenses_time = 0;
            if (isset($data['licenses'])) $sync_licenses_time = intval($data['licenses']);
            $sync_persons_time = 0;
            if (isset($data['persons'])) $sync_persons_time = intval($data['persons']);


            /*************************************************** **********************************************************/
            /*******************************************     PERSONAS     *************************************************/
            /*************************************************** **********************************************************/
            if ($sync_persons_time != 0) {
                $a_Personas = Persona_L::obtenerPorFechaMod($sync_persons_time);
                if (!is_null($a_Personas)) {
                    foreach ($a_Personas as $o_Persona) {
                        SyncHelper::SyncPersona($o_Persona, $eq_uuid);   //hacer eq uuid
                    }
                }
            } else {
                $a_Personas = Persona_L::obtenerTodos('', '', '', '', true);//persona con imagen
                if (!is_null($a_Personas)) {
                    foreach ($a_Personas as $o_Persona) {
                        SyncHelper::SyncPersona($o_Persona, $eq_uuid);   //hacer eq uuid
                    }
                }
            }
            /*************************************************** **********************************************************/
            /*******************************************     HUELLAS      *************************************************/
            /*************************************************** **********************************************************/
            if ($sync_fingerprints_time != 0) {
                $a_Huellas = Huella_L::obtenerPorFechaMod($sync_fingerprints_time);
                if (!is_null($a_Huellas)) {
                    foreach ($a_Huellas as $o_Huella)
                        SyncHelper::SyncHuella($o_Huella, $eq_uuid);
                }
            } else {
                $a_Huellas = Huella_L::obtenerTodos('', true);//huella con datos
                if (!is_null($a_Huellas)) {
                    foreach ($a_Huellas as $o_Huella)
                        SyncHelper::SyncHuella($o_Huella, $eq_uuid);
                }
            }
            /*************************************************** **********************************************************/
            /*******************************************     EMPRESAS     *************************************************/
            /*************************************************** **********************************************************/

            /*************************************************** **********************************************************/
            /****************************************     HORARIO NORMAL      *********************************************/
            /*************************************************** **********************************************************/

            /*************************************************** **********************************************************/
            /***************************************     HORARIO ROTATIVO      ********************************************/
            /*************************************************** **********************************************************/

            /*************************************************** **********************************************************/
            /***************************************     HORARIO FLEXIBLE      ********************************************/
            /*************************************************** **********************************************************/

            /*************************************************** **********************************************************/
            /********************************************     GRUPOS      *************************************************/
            /*************************************************** **********************************************************/

            /*************************************************** **********************************************************/
            /****************************************     GRUPOS PERSONAS      ********************************************/
            /*************************************************** **********************************************************/

            /*************************************************** **********************************************************/
            /*******************************************     FERIADOS      ************************************************/
            /*************************************************** **********************************************************/

            /*************************************************** **********************************************************/
            /******************************************     LICENCIAS      ************************************************/
            /*************************************************** **********************************************************/


        }



        break;//cmd ping
    case CMD_PONG:

        $o_Equipo = Equipo_L::obtenerPorUUID($eq_uuid);
        if(is_null($o_Equipo)) {
            echo($eq_uuid . ' no existe');
        }else {
            $o_Equipo->setHeartbeat(time(), 'U');
            $o_Equipo->save('Off');

            $o_Heartbeat = new Heartbeat_O($o_Equipo->getId());
            $o_Heartbeat->setHeartbeat($o_Equipo->getHeartbeat('U'), 'U');
            $o_Heartbeat->save('Off');
        }
        break;//cmd pong

    case CMD_ACK_ELIMINADO:
        switch ($type) {
            case TYPE_PERSON:
                $o_Equipo = Equipo_L::obtenerPorUUID($eq_uuid);
                $o_persona = null;

                $o_persona = Persona_L::obtenerPorId($data['per_id']);
                if (!is_null($o_persona))
                    $o_persona->deleteEquipo($o_Equipo->getId());

                break;//type person
            case TYPE_FINGERPRINT:
                break;//type fingerprint
            case TYPE_NORMAL_HOURS:
                break;//type normal hours
            case TYPE_FLEX_HOURS:
                break;//type flex hours
            case TYPE_ROTATIVE_HOURS:
                break;//type rotative hours
            case TYPE_COMPANIES:
                break;//type companies
            case TYPE_GROUPS:
                break;//type groups
            case TYPE_GROUPS_PERSONS:
                break;//type groups persons
            case TYPE_HOLIDAYS:
                break;//type holydays
            case TYPE_LICENSES:
                break;//type licenses
            case TYPE_CONFIG:
                break;//type config
        }//switch type

        break;//cmd ack eliminado

}//swtich cmd


session_destroy();


syslog(LOG_INFO, ob_get_contents());
ob_end_flush();



