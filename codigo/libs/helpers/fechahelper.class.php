<?php

class FechaHelper {

	/**
	 * convierte GMT a UTC y Controla si un Facha es valida
	 * @param string $p_valor
	 * 
	 * @return string Fecha Hora GMT de la zona o FALSE en un Error
	 */
	public static function UTC($p_Fecha, $p_Format = 'Y-m-d H:i:s', $p_TimeZone = '3') {
		$fecha_hora_UTC = '';
		$_fecha_hora = 0;
		
		$_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
		if ($_fecha_hora === false) {
			return false;
		}
		
		$fecha_hora_UTC = gmdate($p_Format, $_fecha_hora + $p_TimeZone * 3600);
		
		return $fecha_hora_UTC;
	}

	
	/**
	 * convierte UTC a GMT y Controla si un Facha es valida
	 * @param string $p_valor
	 * 
	 * @return string Fecha Hora GMT de la zona o FALSE en un Error
	 */
	
	public static function GMT($p_Fecha, $p_Format = 'Y-m-d H:i:s', $p_TimeZone = '-3') {
		$fecha_hora_GMT = '';
		$_fecha_hora = 0;
		
		$_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
		if ($_fecha_hora === false) {
			return false;
		}
		
		$fecha_hora_GMT = gmdate($p_Format, $_fecha_hora + $p_TimeZone * 3600);
		
		return $fecha_hora_GMT;
	}

}
