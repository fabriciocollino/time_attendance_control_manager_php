<?php

ob_start();


function errorCuliado($errno, $errstr, $errfile, $errline){

    syslog(LOG_INFO, "Error: " . $errno . " " . $errstr . " en la linea " . $errline . " del archivo " . $errfile);
}

set_error_handler("errorCuliado");



$_SERVER['X-Appengine-Cron'] = true; //como este archivo se llama mediante un webhook, le pongo esto para que crea que es como un cron



require_once(dirname(__FILE__) . '/_ruta.php');

//require __DIR__ . '/vendor/autoload.php';  //esto me carga la libreria google-php-cloud nueva, y no anda el pubsub

use google\appengine\api\taskqueue\PushTask;
use google\appengine\api\taskqueue\PushQueue;




//printear($_POST);
//printear($_SERVER);

//campos obligatorios
//TODO: chequear que vengan todos
$tipo = $_REQUEST['tipo'];
$accion = $_REQUEST['accion'];
$cliente =$_REQUEST['client_id'];


$o_Cliente = Cliente_L::obtenerPorClientID($cliente);
//TODO: chequear if client es null
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

$subdominio = $o_Cliente->getSubdominio();


$fecha_mod = $_REQUEST['fecha_mod'];
$eq_uuid = $_REQUEST['eq_uuid'];

define('SYNC_CANT_PERSONAS_A_ENVIAR',30);
define('SYNC_CANT_HUELLAS_A_ENVIAR',20);

echo "subdominio: ".$o_Cliente->getSubdominio();

switch ($accion){
    case 'sync': {
        switch ($tipo){
            case 'personas':
                $a_Personas = Persona_L::obtenerPorFechaMod($fecha_mod,SYNC_CANT_PERSONAS_A_ENVIAR);
                if (!is_null($a_Personas)) {
                    SyncHelper::SyncArrayPersonas($a_Personas,$eq_uuid,"PING");
                    echo "\r\nse enviaron " . count($a_Personas) . " personas a ".$eq_uuid;
                }
                break;
            case 'huellas':
                $a_Huellas = Huella_L::obtenerPorFechaMod($fecha_mod,SYNC_CANT_HUELLAS_A_ENVIAR,true);
                if (!is_null($a_Huellas)) {
                    SyncHelper::SyncArrayHuellas($a_Huellas, $eq_uuid, "PING");   //hacer eq uuid
                    echo "\r\nse enviaron " . count($a_Huellas) . " huellas a ".$eq_uuid;
                }
                break;
        }


        break;
    }

}


/*
X-AppEngine-QueueName

X-AppEngine-TaskRetryCount


X-AppEngine-TaskExecutionCount

X-AppEngine-TaskETA

X-AppEngine-FailFast
*/


session_destroy();


syslog(LOG_INFO, ob_get_contents());
ob_end_flush();



