<?php

class Control_PersonalHelper {

	public static function cotrolPersonal($p_Persona, $p_Fecha_Desde, $p_Fecha_Hasta, $dias_red) {

		$_SESSION['filtro']['fechaD'] = $p_Fecha_Desde;
		$_SESSION['filtro']['fechaH'] = $p_Fecha_Hasta;
		$_SESSION['filtro']['persona'] = $p_Persona;

		$T_Tipo = 'mod_LLegada_Tarde';
		$paginado = 'No';
		$a_mod = null;

		include_once 'codigo/includes/reporte_control_personal.php';

		$a_mod;

		return $a_mod;
	}
	
	public static function Ausencias($p_Persona, $p_Fecha_Desde, $p_Fecha_Hasta, $dias_red) {

		$_SESSION['filtro']['fechaD'] = $p_Fecha_Desde;
		$_SESSION['filtro']['fechaH'] = $p_Fecha_Hasta;
		$_SESSION['filtro']['persona'] = $p_Persona;

		$T_Tipo = 'Ausencias';
		$paginado = 'No';
		$a_aus = null;

		include_once '../codigo/includes/reporte_control_personal.php';

		$a_aus;

		return $a_aus;
	}

}
