<?php

 
require_once(dirname(__FILE__) . '/_ruta.php');

require_once dirname(__FILE__) .'/codigo/libs/helpers/cronhelper.php';


//Cargamos el archivo de configuración al Registro de la Aplicación
$Registry = Registry::getInstance(dirname(__FILE__) . '/config/configuration.ini');


require_once($Registry->general['library_path'] . '/mysql/mysql.backup.class.php');

//do a tekbox server backup
set_time_limit(3600);
				
$params = array(
	'driver' => 'mysqli',
	'host' => $Registry->database['db_host'],
	'username' => $Registry->database['db_user'],
	'password' => $Registry->database['db_pass'],
	'database' => $Registry->database['db_name'],
	'temp' => APP_PATH . '/backup/'
);

$ftp_params = array(
		"server" => Config_L::p('tekbox_server_host'), 
		"user" => Config_L::p('tekbox_server_user'), 
		"pass" => Config_L::p('tekbox_server_pass'),
		"port" => Config_L::p('tekbox_server_port')
		);


mySQLBackup::init($params)->as_sql()->zip(true)->ftp($ftp_params)->remove()->showErrors();
		
		
$Cron=Cron_L::obtenerPorNombre('cron_backup.php');
$Cron->setTimestamp(time());
$Cron->Save('Off');		
 

session_destroy();

