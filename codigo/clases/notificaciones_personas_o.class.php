<?php

class Notificaciones_Personas_O {

	private $_id;
	private $_grupo;
	private $_persona;
	private $_email;
	private $_telefono;
	
	
	private $_errores;

	public function __construct() {
		$this->_id = 0;
		$this->_grupo = 0; 
		$this->_persona = 0; 
		$this->_email = ''; 
		$this->_telefono = ''; 		
		
		$this->_errores = array();
	}

	public function getId() {
		return $this->_id;
	}

	
	public function getGrupo(){
		return $this->_grupo;
	}

	public function setGrupo($p_grupo){
		$p_grupo = (integer)$p_grupo;
		$this->_grupo = $p_grupo;
	}
	
	public function getPersona(){
		return $this->_persona;
	}

	public function setPersona($p_persona){
		$p_persona = (integer)$p_persona;
		$this->_persona = $p_persona;
	}
	
	public function getEmail(){
		return $this->_email;
	}

	public function setEmail($p_email){
		$p_email = (string)$p_email;
		$this->_email = $p_email;
	}
	
	public function getTelefono(){
		return $this->_telefono;
	}

	public function setTelefono($p_telefono){
		$p_telefono = (string)$p_telefono;
		$this->_telefono = $p_telefono;
	}
	
	
	
	public function esValido() {
		$this->_errores = array();

		
		
		//Si el array errores no tiene elementos entonces el objeto es valido.
		return count($this->_errores) == 0;
	}

	public function getErrores() {
		return $this->_errores;
	}

	public function loadArray($p_Datos) {

		$this->_id = (integer) $p_Datos["npe_Id"];
		$this->_grupo = (integer) $p_Datos["npe_Grupo"];
		$this->_persona = (integer) $p_Datos["npe_Persona"];
		$this->_email = (string) $p_Datos["npe_Email"];
		$this->_telefono = (string) $p_Datos["npe_Telefono"];
	}

	public function save($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if (!$this->esValido()) {
			return false;
		}

		$datos = array(
		    'npe_Grupo' => $this->_grupo,
		    'npe_Persona' => $this->_persona,
		    'npe_Email' => $this->_email,
		    'npe_Telefono' => $this->_telefono
		);

		if ($this->_id == 0) {
			$resultado = $cnn->Insert('notificaciones_personas', $datos);
			if ($resultado !== false) {
				$this->_id = $cnn->Devolver_Insert_Id();
			}
		} else {
			$resultado = $cnn->Update('notificaciones_personas', $datos, "npe_Id = {$this->_id}");
		}

		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}

	public function delete($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($cnn->Delete('notificaciones_personas', "npe_Id = {$this->_id}")) {
			return true;
		} else {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
			return false;
		}
	}

}
