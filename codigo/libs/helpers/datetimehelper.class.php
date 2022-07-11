<?php

/**
 * DateTimeHelper
 *
 * Esta clase es una encapsulación de Funciones que permiten manipular datos relacionados a fechas y horas.
 *
 */
class DateTimeHelper {

	/**
	 * Esta función permite obtener un Timestamp desde una fecha/hora que tiene un formato determinado.
	 * Vea date() para conocer los posibles valores para $pFormat
	 *
	 * Es necesario que contenga como mínimo la fecha, es decir que tenga el día, mes y año.
	 *
	 * Esta función fue tomada de http://ar2.php.net/manual/en/class.datetime.php y adaptada.
	 * 
	 * Ejemplos de Uso:
	 * $ts = DateTimeHelper::getTimestampFromFormat('12/2/1990 15:45', 'd/m/Y H:i'); //Devuelve timestamp para 1990-02-12 15:45:00 (634844700)
	 * $ts = DateTimeHelper::getTimestampFromFormat('12/2/1990 15:45', 'd/m/Y H:i', true); //Devuelve false
	 * $ts = DateTimeHelper::getTimestampFromFormat('11.02.10 is 11:55:39', 'd.m.y \i\s H:i:s'); //Devuelve timestamp para 2010-02-11 11:55:39 (1265900139)
	 * $ts = DateTimeHelper::getTimestampFromFormat(1286306680, 'U'); //Devuelve timestamp para 2010-10-05 16:24:40 (1286306680)
	 * $ts = DateTimeHelper::getTimestampFromFormat('2004-02-12T15:19:21+00:00', 'c'); //Devuelve timestamp para 2004-02-12 12:19:21 (1076599161)
	 *
	 * NOTA: Las fechas del resultado devuelto en el ejemplo dependen del timezone America/Argentina/Cordoba (UTC/GMT -3 hours)
	 *
	 * @param string $pDateTime                La cadena fecha/hora que se quiere pasar a timestamp
	 * @param string $pFormat                  Por ahora sólo permite los valores Y, y, m, n, d, j, H, G, i, s
	 * @param string $leadingZeroIsImportant   Especifica si es absolutamente requerido, o no, el cero inicial.
	 * @return integer timestamp o FALSE en un Error
	 */
	public static function getTimestampFromFormat($pDateTime, $pFormat, $leadingZeroIsImportant = false) {
		assert($pFormat != "");
		if ($pDateTime == "") {
			return false;
		}

		//20101005 1516 Agregado para soportar los formatos U y c
		if ($pFormat == 'U') { //Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT) = timestamp
			return (integer) $pDateTime;
		} elseif ($pFormat == 'c') { //ISO 8601 date (added in PHP 5) example: 2004-02-12T15:19:21+00:00
			return strtotime($pDateTime);
		}
		//--

		$leadingZero = '{1}';
		if ($leadingZeroIsImportant === false) {
			$leadingZero = '?';
		}
		$regexpArray['Y'] = "(?P<Y>\d{4})";
		$regexpArray['y'] = "(?P<y>\d{2})";

		$regexpArray['m'] = "(?P<m>0{$leadingZero}[1-9]|1[012])";
		$regexpArray['n'] = '(?P<m>0{0,1}[1-9]|1[012])';

		$regexpArray['d'] = "(?P<d>0{$leadingZero}[1-9]|[12][0-9]|3[01])";
		$regexpArray['j'] = '(?P<d>0{0,1}[1-9]|[12][0-9]|3[01])';

		$regexpArray['-'] = "[-]";
		$regexpArray['.'] = "[\.]";
		$regexpArray[':'] = "[:]";
		$regexpArray['space'] = "[\s]";

		$regexpArray['H'] = "(?P<H>0{$leadingZero}[0-9]|1[0-9]|2[0-3])";
		$regexpArray['G'] = '(?P<H>0{0,1}[0-9]|1[0-9]|2[0-3])';

		$regexpArray['i'] = "(?P<i>[0-5]{$leadingZero}[0-9])";
		$regexpArray['s'] = "(?P<s>[0-5]{$leadingZero}[0-9])";

		$formatArray = str_split($pFormat);
		$regex = "";

		// create the regular expression
		$previousChar = '';
		foreach ($formatArray as $character) {
			if ($character == '\\') { //the escaped chars should not be interpreted
				$previousChar = $character;
				continue;
			}
			if ($previousChar == '\\')
				$regex = $regex . '[' . preg_quote($character, '/') . ']';
			elseif ($character == " ")
				$regex = $regex . $regexpArray['space'];
			elseif (array_key_exists($character, $regexpArray))
				$regex = $regex . $regexpArray[$character];
			else
				$regex = $regex . '[' . preg_quote($character, '/') . ']';

			$previousChar = $character;
		}
		$regex = "/^" . $regex . "$/";

		// get results for regualar expression
		if (preg_match($regex, $pDateTime, $result)) {
			//all ok
		} else {
			return false;
		}

		if (isset($result['y']) && !isset($result['Y'])) {
			$value = (integer) $result['y'];
			if ($value < 70) { //http://ar2.php.net/manual/en/function.mktime.php
				$value = 2000 + $value;
			} else {
				$value = 1900 + $value;
			}
			$result['Y'] = $value;
		}

		if (!isset($result['m']) || !isset($result['d']) || !isset($result['Y'])) {
			//m, d and Y must be present at least.
			return false;
		}

		if (!checkdate((int) $result['m'], (int) $result['d'], (int) $result['Y'])) {
			//m, d and Y must be a valid date.
			return false; //It's not a valid date
		}

		//make integer and pad it!
		foreach ($result as $key => $value) {
			$value = (integer) $value;
			$result[$key] = str_pad($value, 2, '0', STR_PAD_LEFT);
		}

		// create the init string for the new DateTime
		$initString = $result['Y'] . "-" . $result['m'] . "-" . $result['d'];

		// if no value for hours, minutes and seconds was found add 00:00:00
		if (isset($result['H']))
			$initString .= " " . $result['H'];
		else {
			$initString .= " 00";
		}

		if (isset($result['i']))
			$initString .= ":" . $result['i'];
		else {
			$initString .= ":00";
		}

		if (isset($result['s']))
			$initString .= ":" . $result['s'];
		else {
			$initString .= ":00";
		}

		$newDate = strtotime($initString);
		return $newDate;
	}

	/**
	 * Valida la horas
	 * 
	 * @param string $p_Hora 
	 * @param string $p_Format	Soporta el fomato H:i:s o H:i
	 * @return integer		timestamp o FALSE en un Error
	 */
	public static function ValidarHora($p_Hora, $p_Format) {
		//assert($p_Format != "");
		if (empty($p_Hora)) {
			return false;
		}

		$leadingZero = '{1}';
		$regexpArray[':'] = "[:]";

		$regexpArray['H'] = "(?P<H>0{$leadingZero}[0-9]|1[0-9]|2[0-3])";
		$regexpArray['G'] = '(?P<H>0{0,1}[0-9]|1[0-9]|2[0-3])';

		$regexpArray['i'] = "(?P<i>[0-5]{$leadingZero}[0-9])";
		$regexpArray['s'] = "(?P<s>[0-5]{$leadingZero}[0-9])";

		$formatArray = str_split($p_Format);
		$regex = "";

		$previousChar = '';
		foreach ($formatArray as $character) {
			if ($character == '\\') { //the escaped chars should not be interpreted
				$previousChar = $character;
				continue;
			}
			if ($previousChar == '\\')
				$regex = $regex . '[' . preg_quote($character, '/') . ']';
			elseif ($character == " ")
				$regex = $regex . $regexpArray['space'];
			elseif (array_key_exists($character, $regexpArray))
				$regex = $regex . $regexpArray[$character];
			else
				$regex = $regex . '[' . preg_quote($character, '/') . ']';

			$previousChar = $character;
		}
		$regex = "/^" . $regex . "$/";

		// get results for regualar expression
		if (preg_match($regex, $p_Hora, $result)) {
			//all ok
		} else {
			return false;
		}

		switch ($p_Format) {
			case 'H:i:s':
				if ($result['H'] > -1 && $result['H'] < 24 && $result['i'] > -1 && $result['i'] < 60 && $result['s'] > -1 && $result['s'] < 60) {
					return strtotime($p_Hora);
				}
				break;
			case 'H:i':
				if ($result['H'] > -1 && $result['H'] < 24 && $result['i'] > -1 && $result['i'] < 60) {
					return strtotime($p_Hora);
				}
				break;
		}

		return false;
	}

	public static function RestaHora($inicio, $fin) {
		$dif = date("H:i:s", strtotime("00:00:00") + strtotime($fin) - strtotime($inicio));
		return $dif;
	}

	public static function RestarHoras($horaini, $horafin) {
		$horai = substr($horaini, 0, 2);
		$mini = substr($horaini, 3, 2);
		//$segi=substr($horaini,6,2);

		$horaf = substr($horafin, 0, 2);
		$minf = substr($horafin, 3, 2);
		//$segf=substr($horafin,6,2);

		$ini = ((($horai * 60) * 60) + ($mini * 60)/* +$segi */);
		$fin = ((($horaf * 60) * 60) + ($minf * 60)/* +$segf */);

		$dif = $fin - $ini;

		$difh = floor($dif / 3600);
		$difm = floor(($dif - ($difh * 3600)) / 60);
		//$difs=$dif-($difm*60)-($difh*3600);
		return date("H:i", mktime($difh, $difm));
		//return date("H-i-s",mktime($difh,$difm,$difs));
	}

	public static function time_to_sec($time) {
		//echo $time. '-';
		$tiempo = explode(':', (string) $time);
		$temp = $tiempo[0] * 3600 + $tiempo[1] * 60 + $tiempo[2];
		return $temp;
	}

	public static function sec_to_time($seconds) {
		$hours = abs(floor($seconds / 3600));
		$minutes = abs(floor($seconds % 3600 / 60));
		$seconds = abs($seconds % 60);

		if ($hours <= 99) {
			return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
		} else {
			return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
		}
	}

	public static function diff_Fecha_Hora($date1, $date2) {
		//$date1 = "2009-12-04 22:30:00";
		//$date2 = "2009-12-05 07:30:00";

		$diff = abs(strtotime($date1) - strtotime($date2));

		$years = floor($diff / (365 * 60 * 60 * 24));
		$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

		$hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

		$minuts = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);

		$seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minuts * 60));

		//printf("%d years, %d months, %d days, %d hours, %d minuts\n, %d seconds\n", $years, $months, $days, $hours, $minuts, $seconds);
		return array($years, $months, $days, $hours, $minuts, $seconds);
	}

	/**
	 * Dada una las 2 fechas devuelve la diferencia en dias
	 * 
	 * @param type $date1
	 * @param type $date2
	 * @return type integer 
	 */
	public static function diff_Fecha_En_Dias($date1, $date2) {
		//$date1 = "2009-12-04 22:30:00";
		//$date2 = "2009-12-05 07:30:00";
		$diff = abs(strtotime($date1) - strtotime($date2));

		$days = floor($diff / (60 * 60 * 24));

		return $days;
	}

	/**
	 * Dada una fecha 'Y-m-d' te devuelve el un array con el lunes y el domingo de la semana que pertenese la fecha.
	 * 
	 * @param type $p_Fecha
	 * @return type array(Lunes,Domingo)
	 */
	public static function Lunes_Domingo($p_Fecha) {
		// Obtener semana y numero de dia en base a la fecha dada
		list($anio, $mes, $dia, $semana, $sdia) = explode(':', date('Y:m:d:W:w', strtotime($p_Fecha)));
		// Creamos la nueva fecha
		$inicio = strtotime("$anio-$mes-$dia 12:00am");
		// Obtenemos el timestamp del lunes para esa semana
		$inicio += (1 - $sdia) * 86400;
		// Agregamos 6 dias y obtenemos el timestamp del fin de semana
		$fin = $inicio + (6 * 86400);
		return array($inicio, $fin);
	}

	/**
	 * Dada una fecha 'Y-m-d' te devuelve el un array con el domingo y el sabado de la semana que pertenese la fecha.
	 * 
	 * @param type $p_Fecha
	 * @return type array(Domingo, Sabado)
	 */
	public static function Domingo_Sabado($date) {
		$ts = strtotime($date);
		$inico = strtotime('sunday this week -1 week', $ts);
		$fin = strtotime('saturday this week', $ts);
		return array(date('Y-m-d', $inico), date('Y-m-d', $fin));
	}

	/**
	 * Dada una fecha 'Y-m-d' te devuelve el un array con los dias que que pertenese a esa semana.
	 * 
	 * @param type $p_Fecha
	 * @return type array(Lunes,...,Domingo)
	 */
	/* public static function Dias_De_Una_Semana($p_Fecha) {
	  // Obtener semana y numero de dia en base a la fecha dada
	  list($anio, $mes, $dia, $semana, $sdia) = explode(':', date('Y:m:d:W:w', strtotime($p_Fecha)));
	  // Creamos la nueva fecha
	  $lunes = strtotime("$anio-$mes-$dia 12:00am");
	  // Obtenemos el timestamp del lunes para esa semana
	  $lunes += (1 - $sdia) * 86400;

	  // Obtengo el timestamp del resto de los días a partir del lunes
	  // Los guardo en un arreglo
	  $diasSemana = array();
	  for ($i = 0; $i < 7; ++$i) {
	  $diasSemana[] = strtotime('+' . $i . ' days', $lunes);
	  }
	  // Retorno el arreglo de dias de una semana..
	  return $diasSemana;
	  }
	 */

	/**
	 * Dada una fecha 'Y-m-d' te devuelve el un array con los dias que que pertenese a esa semana.
	 * 
	 * @param type $p_Fecha
	 * @param type $p_Comienso N = comienza lunes - w = comienza domingo
	 * @return type array(Lunes,...,Domingo)
	 */
	public static function Dias_De_Una_Semana($p_Fecha, $p_Comienso = 'w') {// N = comienza lunes - w = comienza domingo
		$ts = strtotime($p_Fecha);
		$dia = 'sunday this week -1 week';
		if ($p_Comienso == 'N') {
			$dia = 'monday this week';
		}
		$dia_inicio = strtotime($dia, $ts);
		// Obtengo el timestamp del resto de los días
		// Los guardo en un arreglo 
		$diasSemana = array();
		for ($i = 0; $i < 7; ++$i) {
			$diasSemana[] = strtotime('+' . $i . ' days', $dia_inicio);
		}
		// Retorno el arreglo de dias de una semana..
		return $diasSemana;
	}

	/**
	 * Dada una fecha 'Y-m-d' te devuelve la misma fecha con n meses mas.
	 * 
	 * @param type $p_Fecha
	 * @param type $p_Meses
	 * @return type array(Lunes,...,Domingo)
	 */
	public static function suma_mes($p_Fecha, $p_Meses = 1) {

		$nueva_fecha = strtotime("+{$p_Meses} months", strtotime($p_Fecha));

		return date('Y-m-d', $nueva_fecha);
	}

	/**
	 * Dada una fecha 'Y-m-d' te devuelve el un array con los dias que que pertenese a esa semana.
	 * 
	 * @param type $p_Anio_Mes Y-m paso el año y el mes
	 * @param type $p_Comienso N = comienza lunes a domingo - w = comienza domingo a sabado
	 * @return type array(dias del mes)
	 */
	public static function Dias_De_Una_Mes($p_Anio_Mes, $p_Comienso = 'w', $p_Con = true) {// N = comienza lunes a domingo - w = comienza domingo a sabado
		$ts = strtotime($p_Anio_Mes . '-01');

		$inicio_dia = 'sunday this week -1 week';
		$fin_dia = 'Saturday this week';
		if ($p_Comienso == 'N') {
			$inicio_dia = 'monday this week';
			$fin_dia = 'sunday this week';
		}

		$inicio_mes = strtotime($inicio_dia, $ts);
		$fin_mes = strtotime($fin_dia, mktime(0, 0, 0, date("m", $ts) + 1, 1, date("Y", $ts)) - 1);
		
		//echo $inicio_mes;
		//echo date('Y-m-d',$fin_mes);
		
		// Obtengo el timestamp del resto de los días
		// Los guardo en un arreglo 
		$diasMes = array();
		$i = 0;
		$dia_mes = 0;
		while (true) {
			$dia_mes = strtotime('+' . $i . ' days', $inicio_mes);
			//echo date('Y-m-d', $dia_mes) . ' - ' . date('Y-m-d', $fin_mes) . '<br />';
			if($p_Con){
				if($ts>$dia_mes){
					$diasMes[] = null;
				} elseif((mktime(0, 0, 0, date("m", $ts) + 1, 1, date("Y", $ts)) - 1)<$dia_mes){
					$diasMes[] = null;
				} else {
					$diasMes[] = $dia_mes;
				}
				
			}  else {
				$diasMes[] = $dia_mes;
			}
			
			if (date('Y-m-d', $fin_mes) == date('Y-m-d', $dia_mes)) {
				return $diasMes;
			}
			$i++;
		}
		// Retorno el arreglo de dias de una mes..
		return $diasMes;
	}

	/**
	 * Dada una las 1 fechas devuelve la suna de x dias
	 * 
	 * @param type $p_Fecha 'Y-m-d'
	 * @param type $p_Dias
	 * @return type string 'Y-m-d'
	 */
	public static function Sum_Dias($p_Fecha, $p_Dias) {

		$nueva_fecha = date('Y-m-d', strtotime("+{$p_Dias} Day", strtotime($p_Fecha)));

		return $nueva_fecha;
	}

	/**
	 * Dada una las 1 fechas devuelve la resta de x dias
	 * 
	 * @param type $p_Fecha 'Y-m-d'
	 * @param type $p_Dias
	 * @return type string 'Y-m-d'
	 */
	public static function Restar_Dias($p_Fecha, $p_Dias) {

		$nueva_fecha = date('Y-m-d', strtotime("-{$p_Dias} Day", strtotime($p_Fecha)));

		return $nueva_fecha;
	}

}

