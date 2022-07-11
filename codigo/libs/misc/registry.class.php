<?php

class Registry {

	private static $instance = null;
	private $settings;

	/**
	 * Esta clase no puede ser creada con NEW, es necesario que se llame a getInstance
	 * para crear/obtener la instancia al objeto Registry.
	 * 
	 * @param string $ini_file Ruta completa al archivo de configuración.
	 */
	private function __construct($ini_file) {
		$this->settings = parse_ini_file($ini_file, true);
		if ($this->settings === false) {
			$this->settings = array();
		}
	}

	/**
	 * Este método permite obtener la única instancia de Registry.
	 *
	 * La primera vez que es llamado este método se le debe especificar cual es
	 * el archivo de configuración que debe cargar.
	 * 
	 * Luego, siempre que se llame a este método devolverá la misma instancia.
	 *
	 * @param string $ini_file Ruta completa al archivo de configuración.
	 * @return Registry
	 */
	public static function getInstance($ini_file = null) {
		if (is_null(self::$instance) && !is_null($ini_file)) {
			self::$instance = new Registry($ini_file);
		}
		return self::$instance;
	}

	/**
	 * Permite obtener una propiedad del Registry.
	 *
	 * __get() es un método magico de PHP.
	 *
	 * @param string $setting
	 * @return mixed
	 */
	public function __get($setting) {
		if (array_key_exists($setting, $this->settings)) {
			return $this->settings[$setting];
		} else {
			return null;
		}
	}

	/**
	 * Permite crear/modificar el valor de una propiedad del Registry.
	 *
	 * __set() es un método magico de PHP.
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		$this->settings[$name] = $value;
	}

	/**
	 * Permite verificar si una propiedad existe o no.
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function __isset($name) {
		return isset($this->settings[$name]);
	}

	/**
	 * Permite quitar una propiedad de la clase.
	 *
	 * @param string $name
	 */
	public function __unset($name) {
		if (isset($this->settings[$name])) {
			unset($this->settings[$name]);
		}
	}

}
