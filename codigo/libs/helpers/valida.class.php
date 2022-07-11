<?php

class Valida {

	/**
	 * Controla vacio, contidad de caracteres max y min
	 * @param string $p_valor
	 * 
	 * @return string $error
	 */
	public static function String($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero='o') {
		$error = true;
		if ($p_valor == '') {
			$error = _("Debe proporcionar")." " . strtolower($p_articulo) . " {$p_texto}.";
		} elseif (strlen($p_valor) < $p_min) {
			$error = "{$p_articulo} {$p_texto} "._("especificad")."{$p_genero} "._("es demasiado corto.");
		} elseif (strlen($p_valor) > $p_max) {
			$error = "{$p_articulo} {$p_texto} "._("especificad")."{$p_genero} "._("no debe superar los")." {$p_max} "._("caracteres.");
		}
		return $error;
	}

	/**
	 * Controla si un radio esta seleccionado
	 * @param string $p_valor
	 * 
	 * @return string $error
	 */
	public static function Radio($p_valor, $p_texto) {
		$error = true;
		if (is_int($p_valor)) {
			if ($p_valor == 0) {
				$error = _("Debe seleccionar un")." {$p_texto}.";
			}
		} else {
			if ($p_valor == '') {
				$error = _("Debe seleccionar un")." {$p_texto}.";
			}
		}
		return $error;
	}

	/**
	 * Controla si un Facha es valida
	 * @param string $p_valor
	 * 
	 * @return string $error
	 */
	public static function Fecha($p_Fecha, $p_Format, $p_texto) {
		$_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
		if ($_fecha_hora === false) {
			$error[ValidateHelper::Cadena($p_texto)] = _("La")." {$p_texto} "._("es incorrecta.");
		}
	}

}
