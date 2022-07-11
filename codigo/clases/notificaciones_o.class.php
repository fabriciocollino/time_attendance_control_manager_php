<?php

class Notificaciones_O {

	private $_id;
	private $_detalle;
	private $_tipo;
	private $_grupo;
	private $_activa;
	
	
	private $_Dtipo;
	private $_Ddisparador;
	private $_Dhora;
	private $_Drepeticion;
	private $_Dequipo;
	private $_Dalarma;
	private $_Ddispositivo;
	private $_Dpersona;
	private $_Drol;
	private $_Dzona;
	private $_Dlog;
	private $_Dhorarios;
	
	private $_Cdetalle;
	private $_Ctipo;
	private $_Ctexto;
	private $_Cintervalo;
	private $_Cequipo;
	private $_Calarma;
	private $_Cdispositivo;
	private $_Cpersona;
	private $_Crol;
	private $_Czona;
	private $_Cusuario;
	
	public $_errores;
	
	

	public function __construct() {
		$this->_id = 0;
		$this->_detalle = ''; //varchar(50)
		$this->_tipo = 0; 
		$this->_grupo = 0; 
		$this->_contenido = 0; 
		
		$this->_Dtipo = 0;
		$this->_Ddisparador = 0;
		$this->_Dhora = null;
		$this->_Dequipo = 0;
		$this->_Dalarma = 0;
		$this->_Ddispositivo = 0;
		$this->_Dpersona = 0;
		$this->_Drol = 0;
		$this->_Dzona = 0;
		$this->_Dlog = 0;
		$this->_Dhorarios = '';
		
		$this->_Cdetalle = '';
		$this->_Ctipo = 0;
		$this->_Ctexto = '';
		$this->_Cintervalo = 0;
		$this->_Cequipo = 0;
		$this->_Calarma = 0;
		$this->_Cdispositivo = 0;
		$this->_Cpersona = 0;
		$this->_Crol = 0;
		$this->_Czona = 0;
		$this->_Cusuario = 0;

		$this->_errores = array();
	}
	
	
	private function seleccionado($p_valor, $p_texto) {
		if (is_int($p_valor)) {

			if ($p_valor == '') {
				$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un")." {$p_texto}.";
			}
		} else {
			if ($p_valor == '') {
				$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe seleccionar un")." {$p_texto}.";
			}
		}
	}
	
	private function control($p_valor, $p_texto, $p_min, $p_max, $p_articulo = 'El', $p_genero='o') {
		if ($p_valor == '') {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = _("Debe proporcionar")." " . strtolower($p_articulo) . " {$p_texto}.";
		} elseif (strlen($p_valor) < $p_min) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} "._("especificad")."{$p_genero} "._("es demasiado corto.");
		} elseif (strlen($p_valor) > $p_max) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} "._("especificad")."{$p_genero} "._("no debe superar los")." {$p_max} "._("caracteres.");
		} elseif (strpos($p_valor, ':')!== false) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = "{$p_articulo} {$p_texto} "._("especificad")."{$p_genero} "._("no debe contener dos puntos (:).");
		}
	}
	
	public function Fecha($p_Fecha, $p_Format, $p_texto) {
		$_fecha_hora = DateTimeHelper::getTimestampFromFormat($p_Fecha, $p_Format);
		if ($_fecha_hora === false) {
			$this->_errores[ValidateHelper::Cadena($p_texto)] = _("La")." {$p_texto} "._("es incorrecta.");
			return $p_Fecha;
		}
		return $_fecha_hora;
	}
	
	
	
	
	

	public function getId() {
		return $this->_id;
	}

	public function getDetalle() {
		return $this->_detalle;
	}

	public function setDetalle($p_detalle) {
		$p_detalle = trim($p_detalle);
		$this->control($p_detalle, _('Nombre'), 4, 100);
		$this->_detalle = $p_detalle; 
	}
	
	
	
	
	
	public function getTipo() {
		return $this->_tipo;
	}

	public function setTipo($p_tipo) {
		$this->seleccionado($p_tipo, _('Tipo'));
		$this->_tipo = $p_tipo;
	}
	public function getTipo_S() {
		global $a_Notificaciones_Tipos;
		return $a_Notificaciones_Tipos[$this->_tipo];
	}


	
	public function getGrupo() {
		return $this->_grupo;
	}

	public function setGrupo($p_grupo) {
		$this->seleccionado($p_grupo, _('Grupo'));
		$this->_grupo = $p_grupo;
	}
	
	public function getGrupo_S() {
		$o_Grupo = Grupo_L::obtenerPorId($this->_grupo);
		return $o_Grupo->getDetalle();
	}
	
	public function getGrupo_SC() {
		$o_Grupo = Grupo_L::obtenerPorId($this->_grupo);
		return $o_Grupo->getDetalle()." (".$o_Grupo->getPersonasCount().")";
	}
	
//SECCION DISPARADOR

	public function getTipoD() {
		return $this->_Dtipo;
	}
	
	public function setTipoD($p_Tipo) {
		$p_Tipo = (integer) $p_Tipo;
		if($p_Tipo!=0)
			$this->seleccionado($p_Tipo, _('Tipo'));
		$this->_Dtipo = $p_Tipo;
		
	}
	
	public function getTipo_SD() {
		if($this->_Dtipo==0)return _('Inmediato');
		if($this->_Dtipo==1)return _('Diario');
		if($this->_Dtipo==2)return _('Semanal');
		if($this->_Dtipo==3)return _('Quincenal');
		if($this->_Dtipo==4)return _('Mensual');
		if($this->_Dtipo==5)return _('Anual');
		if($this->_Dtipo==100)return _('Inmediato');
	}	
	
	public function getDisparador() {
		return $this->_Ddisparador;
	}
	
	public function setDisparador($p_Disparador) {
		$p_Disparador = (integer) $p_Disparador;
		$this->seleccionado($p_Disparador, _('Disparador'));
		$this->_Ddisparador = $p_Disparador;		
	}
	
	
	public function getHoraD($p_Format = null) {
		if (!is_null($p_Format) && is_string($p_Format)) {
			if (is_int($this->_Dhora)) {
				return date($p_Format, $this->_Dhora);
			} else {
				return $this->_Dhora;
			}
		}
		return $this->_Dhora;
	}

	public function setHoraD($p_Hora, $p_Format,$p_Ignore=false) {
		if(!$p_Ignore){
			$this->_Dhora = $this->Fecha($p_Hora, $p_Format, 'Hora');
			$this->_Dhora = $p_Hora;
		}else{
			$this->_Dhora = 0;
		}
	}
	
	public function getEquipoD() {
		return $this->_Dequipo;
	}
	
	public function setEquipoD($p_Equipo) {
		$p_Equipo = (integer) $p_Equipo;
		$this->seleccionado($p_Equipo, _('Equipo'));
		$this->_Dequipo = $p_Equipo;

	}
	
	public function setEquipoD_NoCHECK($p_Equipo) {
		$p_Equipo = (integer) $p_Equipo;
		$this->_Dequipo = $p_Equipo;

	}
	
	public function getDispositivoD() {
		return $this->_Ddispositivo;
	}
	
	public function setDispositivoD($p_Dispositivo) {
		$p_Dispositivo = (integer) $p_Dispositivo;
		$this->seleccionado($p_Dispositivo, _('Dispositivo'));
		$this->_Ddispositivo = $p_Dispositivo;
	}
	
	public function setDispositivoD_NoCHECK($p_Dispositivo) {
		$p_Dispositivo = (integer) $p_Dispositivo;
		$this->_Ddispositivo = $p_Dispositivo;
	}
	
	public function getPersonaD() {
		return $this->_Dpersona;
	}
	
	public function setPersonaD($p_Persona) {
		$p_Persona = (integer) $p_Persona;
		$this->seleccionado($p_Persona, _('Persona'));
		$this->_Dpersona = $p_Persona;
	}
	
	public function setPersonaD_NoCHECK($p_Persona) {
		$p_Persona = (integer) $p_Persona;
		$this->_Dpersona = $p_Persona;
	}
	
	public function getRolD() {
		return $this->_Drol;
	}
	public function getGrupoD() {//refactor a grupo
		return $this->_Drol;
	}
	
	public function setRolD($p_Grupo) {
		$p_Grupo = (integer) $p_Grupo;
		$this->seleccionado($p_Grupo, _('GrupoD'));
		$this->_Drol = $p_Grupo;
	}
	public function setGrupoD($p_Grupo) { //refactor a grupo
		$p_Grupo = (integer) $p_Grupo;
		$this->seleccionado($p_Grupo, _('GrupoD'));
		$this->_Drol = $p_Grupo;
	}
	
	public function setRolD_NoCHECK($p_Grupo) {
		$p_Grupo = (integer) $p_Grupo;
		$this->_Drol = $p_Grupo;
	}
	public function setGrupoD_NoCHECK($p_Grupo) { //refactor a grupo
		$p_Grupo = (integer) $p_Grupo;
		$this->_Drol = $p_Grupo;
	}
	
	public function getZonaD() {
		return $this->_Dzona;
	}
	
	public function setZonaD($p_Zona) {
		$p_Zona = (integer) $p_Zona;
		$this->seleccionado($p_Zona, _('Zona'));
		$this->_Dzona = $p_Zona;
	}
	
	public function setZonaD_NoCHECK($p_Zona) {
		$p_Zona = (integer) $p_Zona;
		$this->_Dzona = $p_Zona;
	}
	

	
	public function getLogD() {
		return $this->_Dlog;
	}
	
	public function setLogD($p_Log) {
		$p_Log = (integer) $p_Log;
		$this->_Dlog = $p_Log;
	}

	public function getHorariosD($p_Dia='') {
		if($p_Dia=='') {
			return $this->_Dhorarios;
		}else{
			$array_horarios=json_decode($this->_Dhorarios, true);
			return $array_horarios[$p_Dia];
		}
	}

	public function setHorariosD($p_Horarios) {
		$p_Horarios = (string) $p_Horarios;
		$this->_Dhorarios = $p_Horarios;
	}
	
	//0 for sunday
	//6 for saturday
	
	
	
	
	
	
	
	
	
	
	
//SECCION CONTENIDO
	public function getDetalleC() {
		return $this->_Cdetalle;
	}
	
	public function setDetalleC($p_Detalle) {
		$p_Detalle = (string) $p_Detalle;
		$this->control($p_Detalle, _('Asunto'), 4, 100);
		$this->_Cdetalle = $p_Detalle;
	}
	
	

	public function getTipoC() {
		return $this->_Ctipo;
	}
	
	public function getTipo_SC() {
		global $a_Notificaciones_Contenidos_Tipos;
		global $a_Notificaciones_Contenidos_Intervalos;
		if($this->_Ctipo==1)
			return $a_Notificaciones_Contenidos_Tipos[$this->_Ctipo];	
		if($this->_Ctipo>=10)
			return $a_Notificaciones_Contenidos_Tipos[2];		
	}	
	
	public function setTipoC($p_Tipo) {
		$p_Tipo = (integer) $p_Tipo;
		$this->_Ctipo = $p_Tipo;
	}
	
	public function getTextoC(){
		return $this->_Ctexto;
	}
	
	public function setTextoC($p_Texto){
		$p_Texto = (string)$p_Texto;
		$this->_Ctexto = $p_Texto;
	}
	
	public function getEquipoC(){
		return $this->_Cequipo;
	}
	
	public function setEquipoC($p_Equipo){
		$p_Equipo = (integer)$p_Equipo;
		$this->_Cequipo = $p_Equipo;
	}
	
	public function getIntervaloC(){
		return $this->_Cintervalo;
	}
	
	public function setIntervaloC($p_Intervalo){
		$p_Intervalo = (integer)$p_Intervalo;
		$this->_Cintervalo = $p_Intervalo;
	}


	public function getDispositivoC() {
		return $this->_Cdispositivo;
	}
	
	public function setDispositivoC($p_Dispositivo) {
		$p_Dispositivo = (integer) $p_Dispositivo;
		$this->seleccionado($p_Dispositivo, _('Dispositivo'));
		$this->_Cdispositivo = $p_Dispositivo;
	}
	
	public function getPersonaC() {
		return $this->_Cpersona;
	}
	
	public function setPersonaC($p_Persona) {
		$p_Persona = (integer) $p_Persona;
		$this->seleccionado($p_Persona, _('Persona'));
		$this->_Cpersona = $p_Persona;
	}
	public function setPersonaC_NoCHECK($p_Persona) {
		$p_Persona = (integer) $p_Persona;
		$this->_Cpersona = $p_Persona;
	}
	
	public function getRolC() {
		return $this->_Crol;
	}
	
	public function setRolC($p_Grupo) {
		$p_Grupo = (integer) $p_Grupo;
		$this->seleccionado($p_Grupo, _('GrupoC'));
		$this->_Crol = $p_Grupo;
	}
	
	public function setRolC_NoCHECK($p_Grupo) {
		$p_Grupo = (integer) $p_Grupo;
		$this->_Crol = $p_Grupo;
	}
	
	public function getZonaC() {
		return $this->_Czona;
	}
	
	public function setZonaC($p_Zona) {
		$p_Zona = (integer) $p_Zona;
		$this->seleccionado($p_Zona, _('Zona'));
		$this->_Czona = $p_Zona;
	}
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	public function getActiva() {
		return $this->_id;
	}

	public function setActiva($p_activa) {
		$this->_activa = (integer)$p_activa;
	}
	
	
	

	public function esValido() {		
		
		//Si el array errores no tiene elementos entonces el objeto es valido.
		return count($this->_errores) == 0;
	}

	public function getErrores() {
		return $this->_errores;
	}

	public function loadArray($p_Datos) {

		$this->_id = (integer) $p_Datos["not_Id"];
		$this->_detalle = (string) $p_Datos["not_Detalle"];
		$this->_tipo = (integer) $p_Datos["not_Tipo"];
		$this->_grupo = (integer) $p_Datos["not_Grupo"];
		$this->_activa = (integer) $p_Datos["not_Activa"];
		
		$this->_Dtipo = (integer) $p_Datos["ndi_Tipo"];
		$this->_Ddisparador = (integer) $p_Datos["ndi_Disparador"];
		$this->_Dhora = (is_null($p_Datos["ndi_Hora"])) ? null : strtotime($p_Datos["ndi_Hora"]);
		$this->_Dequipo = (integer) $p_Datos["ndi_Equipo"];
		$this->_Dalarma = (integer) $p_Datos["ndi_Alarma"];
		$this->_Ddispositivo = (integer) $p_Datos["ndi_Dispositivo"];
		$this->_Dpersona = (integer) $p_Datos["ndi_Persona"];
		$this->_Drol = (integer) $p_Datos["ndi_Grupo"];
		$this->_Dzona = (integer) $p_Datos["ndi_Zona"];
		$this->_Dlog = (integer) $p_Datos["ndi_Log"];
		$this->_Dhorarios = (string) $p_Datos["ndi_Horarios"];
		
		$this->_Cdetalle = (string) $p_Datos["nco_Detalle"];
		$this->_Ctipo = (integer) $p_Datos["nco_Tipo"];
		$this->_Ctexto = (string) $p_Datos["nco_Texto"];
		$this->_Cintervalo=(integer)$p_Datos["nco_Intervalo"];
		$this->_Cequipo = (integer) $p_Datos["nco_Equipo"];
		$this->_Calarma = (integer) $p_Datos["nco_Alarma"];
		$this->_Cdispositivo = (integer) $p_Datos["nco_Dispositivo"];
		$this->_Cpersona = (integer) $p_Datos["nco_Persona"];
		$this->_Crol = (integer) $p_Datos["nco_Grupo"];
		$this->_Czona = (integer) $p_Datos["nco_Zona"];
		$this->_Cusuario = (integer) $p_Datos["nco_Usuario"];
		
		
	}

	public function save($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if (!$this->esValido()) {
			return false;
		}

		$datos = array(
		    'not_Detalle' => $this->_detalle,
		    'not_Tipo' => $this->_tipo,
		    'not_Grupo' => $this->_grupo,

			'ndi_Tipo' => $this->_Dtipo,
			'ndi_Disparador' => $this->_Ddisparador,
		    'ndi_Hora' => $this->_Dhora,
		    'ndi_Equipo' => $this->_Dequipo,
		    'ndi_Alarma' => $this->_Dalarma,
		    'ndi_Dispositivo' => $this->_Ddispositivo,
		    'ndi_Persona' => $this->_Dpersona,
		    'ndi_Grupo' => $this->_Drol,
		    'ndi_Zona' => $this->_Dzona,
		    'ndi_Log' => $this->_Dlog,
			'ndi_Horarios' => $this->_Dhorarios,
		    
		    'nco_Detalle' => $this->_Cdetalle,
		    'nco_Tipo' => $this->_Ctipo,
		    'nco_Texto' => $this->_Ctexto,
		    'nco_Equipo' => $this->_Cequipo,
		    'nco_Intervalo' => $this->_Cintervalo,
		    'nco_Alarma' => $this->_Calarma,
		    'nco_Dispositivo' => $this->_Cdispositivo,
		    'nco_Persona' => $this->_Cpersona,
		    'nco_Grupo' => $this->_Crol,
		    'nco_Zona' => $this->_Czona,
		    'nco_Usuario' => $this->_Cusuario,
			
		    'not_Activa' => $this->_activa
		);

		if ($this->_id == 0) {
			$resultado = $cnn->Insert('notificaciones', $datos);
			if ($resultado !== false) {
				$this->_id = $cnn->Devolver_Insert_Id();
			}
		} else {
			$resultado = $cnn->Update('notificaciones', $datos, "not_Id = {$this->_id}");
		}

		if ($resultado === false) {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
		}

		return $resultado;
	}
	
	
	
	
	
	
	
	
	public function enviar($extraPersona=0,$extraRol=0,$extraEquipo=0,$extraTipo='',$extraFecha='',$extraDispositivo=0,$extraAccion=0){
		global $a_Logs_Accion;
		
		
		if($this->_tipo==1){//EMAIL
		
			$mail= new Email_O();
		

			
			$Sujeto="";
			$Cuerpo="";
			
			if($this->getTipoC()==1){//AVISO
				
				$Sujeto=$this->getDetalleC();
				$Cuerpo=$this->getTextoC();				
			}
			
			
		
			if($this->getTipoC()>=10){//REPORTE
				
				$Sujeto=$this->getDetalleC();
				$Cuerpo=$this->getTextoC();	
				
				//paso los intervalos a cantidad de dias
				if($this->getIntervaloC()==1)$intervalo=1;//dia
				else if($this->getIntervaloC()==2)$intervalo=7;//semana
				else if($this->getIntervaloC()==3)$intervalo=15;//quincena
				else if($this->getIntervaloC()==4)$intervalo=30;//mes
				else if($this->getIntervaloC()==5)$intervalo=365;//año
				
				if($this->getTipoC()==NOT_REPORTE_DE_PERSONA)
					$attNombre=_("Reporte_de_Persona-").date("d_m_y_-_H_i_s").".pdf";
				else if($this->getTipoC()==NOT_REPORTE_DE_LLEGADA_TARDE)
					$attNombre=_("Reporte_de_Llegadas_Tarde-").date("d_m_y_-_H_i_s").".pdf";
				else if($this->getTipoC()==NOT_REPORTE_DE_ENTRADAS_SALIDAS)
					$attNombre=_("Reporte_de_Entradas_Salidas-").date("d_m_y_-_H_i_s").".pdf";
				else if($this->getTipoC()==NOT_REPORTE_DE_DIAS_HORAS_TRABAJADAS)
					$attNombre=_("Reporte_de_Dias_Horas_Trabajadas-").date("d_m_y_-_H_i_s").".pdf";
				else if($this->getTipoC()==NOT_REPORTE_DE_AUSENCIAS)
					$attNombre=_("Reporte_de_Ausencias-").date("d_m_y_-_H_i_s").".pdf";
				

				//genero el pdf
				GenerarReporte($this->getTipoC(),$intervalo,1,$attNombre,$this->getPersonaC(),$this->getZonaC(),$this->getEquipoC(),$this->getDispositivoC(),$this->getRolC());
				
				$mail->setAdjunto(GS_CLIENT_TEMP_FOLDER.$attNombre);
			
			}
		
		
			$mail->setSujeto($Sujeto);
			
			//agrego datos extras al email
			if($extraPersona!=0 || $extraRol!=0 || $extraEquipo!=0)
				$Cuerpo.="<br><br>";
			
			if($extraPersona!=0)
				$Cuerpo.="<br>"._("Persona").':'." ".Persona_L::obtenerPorId($extraPersona)->getNombreCompleto();
			if($extraRol!=0)
				$Cuerpo.="<br>"._("Grupo").':'." ".Grupo_L::obtenerPorId($extraRol)->getDetalle();
			if($extraEquipo!=0)
				$Cuerpo.="<br>"._("Equipo").':'." ".Equipo_L::obtenerPorId($extraEquipo)->getDetalle();
			if($extraDispositivo!=0)
				$Cuerpo.="<br>"._("Periférico").':'." ".Dispositivo_L::obtenerPorId($extraDispositivo)->getNombre();
			if($extraAccion!=0)
				$Cuerpo.="<br>"._("Acción").':'." ".ucfirst(strtolower($a_Logs_Accion[$extraAccion]));    //ver porque mierda lo pone en ingles.
				  
			if(($extraTipo=='LlegadaTarde' || $extraTipo=='LlegadaTemprana') && $extraFecha!='')	
				$Cuerpo.="<br>"._("Horario de Ingreso").':'." ".date("H:i:s - d-m-Y");
				
			if(($extraTipo=='SalidaTarde') && $extraFecha!='')	
				$Cuerpo.="<br>"._("Horario de Salida").':'." ".date("H:i:s - d-m-Y");
			
			if(($extraTipo=='TrackingPersona') && $extraFecha!='')	
				$Cuerpo.="<br>"._("Hora").':'." ".date("H:i:s - d-m-Y");
			
			
				
			$mail->setCuerpo($Cuerpo);
		
			$mail->setGrupo($this->_grupo);
			$mail->setGrupal(1);
			
			$mail->setEstado(1); //enviar

			$mail->setFrom('Notificaciones enPunto');
			
			//$mail->setFecha(date("Y-m-d H:i:s", time()));
			$mail->setFecha(date("Y-m-d H:i:s"),"Y-m-d H:i:s");
			
			$mail->save('Off');

			
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	

	public function delete($p_Debug) {
		/* @var $cnn mySQL */
		$cnn = Registry::getInstance()->DbConn;

		if ($cnn->Delete('notificaciones', "not_Id = {$this->_id}")) {
			return true;
		} else {
			$this->_errores['mysql'] = $cnn->get_Error($p_Debug);
			return false;
		}
	}

}
