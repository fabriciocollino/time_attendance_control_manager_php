<?php

require_once(dirname(__FILE__) . '/_ruta.php');


$errores=array();

$ErroresTipo = isset($_REQUEST['errorestipo']) ? (string) $_REQUEST['errorestipo'] : '';

$Ciudad=  Config_L::p('location');
$request = 'http://api.openweathermap.org/data/2.5/weather?APPID=1a243033994672660fa2ad8129c03c9d&units=metric&q='.$Ciudad;

$response  = file_get_contents($request);
$jsonobj  = json_decode($response);
//echo "<pre>";print_r($jsonobj->main->temp);echo "</pre>";

if($jsonobj!=null){
		if($jsonobj->main!=null){
				if($jsonobj->main->temp!=null){
						$o_Temp = Config_L::obtenerPorParametro('temperatura');												
						$o_Temp->setValor(substr($jsonobj->main->temp, 0,4));
						$o_Temp->save('Off');
						//echo $o_Temp->getValor();
				}
		}
}

//muestro los errores

if($ErroresTipo==''){
	foreach ($errores as $error) {
		echo $error[1];
	}
}
	
$Cron=Cron_L::obtenerPorNombre('cron_temperatura.php');
$Cron->setTimestamp(time());
$Cron->Save('Off');

session_destroy();

