<?php

require_once(dirname(__FILE__) . '/_ruta.php');
if (isset($_SESSION['USUARIO']['id'])) {
	SeguridadHelper::Pasar(20);
	$T_Tipo = isset($_REQUEST['tipo']) ? (integer) $_REQUEST['tipo'] : 0;
	
	include_once 'codigo/includes/reporte_control_personal.php';
	
	if (is_array($a_csv)) {
/*
		header("Content-type: application/vnd.ms-excel");
*/

		header('Content-Encoding: UTF-8');
		header('Content-type: text/csv; charset=UTF-8');
		header("Content-Disposition: attachment; filename=" . $_SESSION['filtro']['csv_nombre'] . ".csv");
		echo "\xEF\xBB\xBF"; // UTF-8 BOM
		
		$outstream = fopen("php://output", 'w');

		foreach ($a_csv as $array) {
			//fputcsv($outstream, $array, ';', '"');
			fputcsv($outstream, $array, ',', '"');
		}

		fclose($outstream);
	}  else {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit();
	}
}


