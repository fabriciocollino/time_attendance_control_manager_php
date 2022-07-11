<?php

class SOHelper {

	public static function backupExport($p_BD_Usuario, $p_BD_Passw, $p_BD_Nombre, $p_BD_Tablas, $p_Ruta, $p_Ruta_mysql) {
		$out_AP = "";

		//TODO: Chequear si los paths son validos antes de ejecutar. SINO, mostrar ERROR.
		if (is_dir($p_Ruta)) {
			//echo "{$p_Ruta_mysql}mysqldump -u {$p_BD_Usuario} -p'{$p_BD_Passw}' {$p_BD_Nombre} {$p_BD_Tablas} > {$p_Ruta}/{$p_BD_Nombre}-{$p_BD_Tablas}-" . ValidateHelper::Cadena(date(Config_L::p('f_fecha_corta'))) . ".sql";
			exec("{$p_Ruta_mysql}mysqldump -u {$p_BD_Usuario} -p'{$p_BD_Passw}' {$p_BD_Nombre} {$p_BD_Tablas} > {$p_Ruta}/{$p_BD_Nombre}-{$p_BD_Tablas}-" . ValidateHelper::Cadena(date(Config_L::p('f_fecha_corta'))) . ".sql", $out_AP);
		} else {
			return _("No se ha podido acceder al directorio copias de seguridad con esta ruta") . ' [ ' . $p_Ruta . ' ] - 10.00 - ';
		}
		//echo system("{$p_Ruta_mysql}mysqldump -u {$p_BD_Usuario} -p{$p_BD_Passw} {$p_BD_Nombre} {$p_BD_Tablas} > {$p_Ruta}\\{$p_BD_Nombre}-{$p_BD_Tablas}-" . ValidateHelper::Cadena(date(Config_L::p('f_fecha_corta'))) . ".sql", $out_AP);
		return $out_AP;
	}

	public static function backupImport($p_BD_Usuario, $p_BD_Passw, $p_BD_Nombre, $p_BD_Tablas, $p_Ruta, $p_Ruta_mysql, $p_Archivo_Nombre) {
		$out_AP = "";
		if (is_dir($p_Ruta)) {
			//echo "{$p_Ruta_mysql}mysql -u " . $p_BD_Usuario . " -p" . $p_BD_Passw . " " . $p_BD_Nombre . " < {$p_Ruta}//{$p_Archivo_Nombre}";
			exec("{$p_Ruta_mysql}mysql -u " . $p_BD_Usuario . " -p" . $p_BD_Passw . " " . $p_BD_Nombre . " < {$p_Ruta}//{$p_Archivo_Nombre}", $out_AP);
		} else {
			return _("No se ha podido acceder al directorio copias de seguridad con esta ruta") . ' [ ' . $p_Ruta . ' ] - 10.01 - ';
		}
		return $out_AP;
	}

	public static function getFiles($directory, $exempt = array('.', '..', '.ds_store', '.svn'), &$files = array()) {
		$handle = opendir($directory);
		while (false !== ($resource = readdir($handle))) {
			if (!in_array(strtolower($resource), $exempt)) {
				if (is_dir($directory . $resource . '/'))
					array_merge($files, self::getFiles($directory . $resource . '/', $exempt, $files));
				else
					$files[] = $directory . $resource;
			}
		}
		closedir($handle);
		return $files;
	}

	public static function file_array($path, $exclude = ".|..", $p_Filtar = '.sql', $recursive = false) {
		if (is_dir($path)) {
			$path = rtrim($path, "/") . "/";
			$folder_handle = opendir($path);
			$exclude_array = explode("|", $exclude);
			$result = array();
			$result[] = '';
			while (false !== ($filename = readdir($folder_handle))) {
				if (!in_array(strtolower($filename), $exclude_array)) {
					if (@is_dir($path . $filename . "/")) {
						// Need to include full "path" or it's an infinite loop
						if ($recursive)
							$result[] = SOHelper::file_array($path . $filename . "/", $exclude, true);
					} else {
						$result[] = $filename;
					}
				}
			}
			foreach ($result as $i => $value) {
				if (@substr($value, -4) != $p_Filtar) {
					unset($result[$i]);
				}
			}
			return $result;
		} else {
			return _("No se ha podido acceder al directorio copias de seguridad con esta ruta") . ' [ ' . $path . ' ] - 10.02 - ';
		}
	}

	/**
	 *

	 * @param type $p_Usuario	Usuario de la Carpeta Compartida
	 * @param type $p_Password	Password de la Carpeta Compartida
	 * @param type $p_Red		Direccion de la RED
	 * @param type $p_Carpeta	Carpeta en donde se monta la Carpeta Compartida
	 * @return array $out_AP	Las linea que devuelve el comando ejecutado en un array
	 * 
	 */
	public static function mountRed($p_Usuario, $p_Password, $p_Red, $p_Carpeta) {
		$out_AP = "";

		exec("sudo mount -t cifs -o username={$p_Usuario},password={$p_Password} {$p_Red} {$p_Carpeta}", $out_AP);
		//exec("sudo mount -t cifs -o username=marco,password=123456 //Cheetara/temp1 /media", $out_AP);

		return $out_AP;
	}

	/**
	 *
	 * @param type $p_Carpeta	Carpeta en donde se monta la Carpeta Compartida
	 * @return array $out_AP	Las linea que devuelve el comando ejecutado en un array 
	 */
	public static function umountRed($p_Carpeta) {
		$out_AP = "";

		exec("sudo umount -l {$p_Carpeta}", $out_AP);
		//exec("sudo umount /media", $out_AP);

		return $out_AP;
	}

}
