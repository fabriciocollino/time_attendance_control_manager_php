<?php

class SeguridadHelper {
	
	/**
	 * Guarda los logueos realizados sean logrados o fallidos.
	 * 
	 * @param type $p_Id -> Id usuaraio si se podo loguar o 0 si no se pudo loguar.
	 * @param type $p_Usuario -> Nombre de usuario ingresado al fallar.
	 * @param type $p_Clave -> Contraseña que puso al fallar.
	 */
	public static function Login($p_Id, $p_Usuario = '', $p_Clave = '') {
		if ($p_Id == 0) {
			//$o_Logs = new Logs_Web_O($p_Id, _('Login Incorrecto'), "U: {$p_Usuario} - P: {$p_Clave}");
			$o_Logs = new Logs_Web_O($p_Id, _('Login Incorrecto'), "U: {$p_Usuario}");
		} else {
			$o_Logs = new Logs_Web_O($p_Id, _('Login'));
		}
		if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
			die(implode(PHP_EOL, $o_Logs->getErrores()));
		}
	}
	
        /**
	 * devuelve true or false segun si la ip esta bloqueada por varios intentos fallidos
	 * 
	 * @param type $p_Ip ip del cliente
	 */
	public static function CheckLoginAttempts($p_Ip) {
            
            //busco los ultimos logs de esta IP en los ultimos 30 minutos
            $a_logs=Logs_Web_L::obtenerPorIpMotivoyTiempo($p_Ip,'Login Incorrecto',30);
            //echo count($a_logs);
            //echo "<pre>";print_r($a_logs);echo "</pre>";
            if(count($a_logs)>5){
                if(count($a_logs)>15){die('Nope ;)');}
                SeguridadHelper::IpBloqueada($p_Ip,'login',count($a_logs));
                return false;
            }else{
                return true;
            }
            
	}
        
        /**
	 * devuelve true or false segun si la ip esta bloqueada por varios intentos fallidos
	 * 
	 * @param type $p_Ip ip del cliente
	 */
	public static function CheckResetEmailAttempts($p_Ip) {
            
            //busco los ultimos logs de esta IP en los ultimos 30 minutos
            $a_logs=Logs_Web_L::obtenerPorIpMotivoyTiempo($p_Ip,'Intento de Reset Incorrecto',30);
            //echo count($a_logs);
            //echo "<pre>";print_r($a_logs);echo "</pre>";
            if(count($a_logs)>5){
                if(count($a_logs)>15){die('Nope ;)');}
                SeguridadHelper::IpBloqueada($p_Ip,'reset (email)',count($a_logs));
                return false;
            }else{
                return true;
            }
            
	}
        
        /**
	 * devuelve true or false segun si la ip esta bloqueada por varios intentos fallidos
	 * 
	 * @param type $p_Ip ip del cliente
	 */
	public static function CheckResetTokenAttempts($p_Ip) {
            
            //busco los ultimos logs de esta IP en los ultimos 30 minutos
            $a_logs=Logs_Web_L::obtenerPorIpMotivoyTiempo($p_Ip,'Intento de Reset Incorrecto (Token)',3000);
            //echo count($a_logs);
            //echo "<pre>";print_r($a_logs);echo "</pre>";
            if(count($a_logs)>10){
                if(count($a_logs)>15){die('Nope ;)');}
                SeguridadHelper::IpBloqueada($p_Ip,'reset (token)',count($a_logs));
                return false;
            }else{
                return true;
            }
            
	}
        
        public static function IpBloqueada($p_Ip,$p_Tipo,$p_Intentos){
            $o_Logs = new Logs_Web_O(0, _('Ip Bloqueada por intentos fallidos'), "T: {$p_Tipo}, IP: {$p_Ip}, INTENTOS: {$p_Intentos}");
            if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
                    die(implode(PHP_EOL, $o_Logs->getErrores()));
            }
        }
        
        /**
	 * Guarda los intentos de password reset
	 * 
	 * @param type $p_Email -> Email ingresado
	 */
	public static function Reset($p_Id, $p_Email = '') {
                if($p_Id==0){
                    if($p_Email!=''){
                        $o_Logs = new Logs_Web_O(0, _('Intento de Reset Incorrecto'), "Email: {$p_Email}");
                    }else{
                        $o_Logs = new Logs_Web_O(0, _('Intento de Reset Incorrecto (Token)'), "");
                    }
                }
                else {
                    if($p_Email==''){
                        $o_Logs = new Logs_Web_O($p_Id, _('Contraseña reseteada correctamente'));
                    }
                    else{   
                        $o_Logs = new Logs_Web_O($p_Id, _('Envio correcto de Email para Resetear Contraseña'));
                    }
                    
                }
		
		if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
			die(implode(PHP_EOL, $o_Logs->getErrores()));
		}
	}
        
        
	/**
	 * Guarda los ingresos no autorizado a otras URL.
	 * 
	 */
	public static function Entrar() {
		if(isset($_SESSION['USUARIO']['id'])){
			$o_Logs = new Logs_Web_O($_SESSION['USUARIO']['id'], _('Trataron-Entrar'), $_SERVER["REQUEST_URI"]);
		}else{
			$o_Logs = new Logs_Web_O(0, _('No logueado'), $_SERVER["REQUEST_URI"]);
		}
		
		if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
			die(implode(PHP_EOL, $o_Logs->getErrores()));
		}
	}
	
	/**
	 * Chequea permisos y registra el nivel del usuario
	 * 
	 * @param integer $p_TipoUsuario -> Nivel del ususario
	 */
	public static function Pasar($p_TipoUsuario) {
		if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() < $p_TipoUsuario) {

			//genera log
			$o_Logs = new Logs_Web_O($_SESSION['USUARIO']['id'], _('Seguridad'), $_SERVER["REQUEST_URI"]);
			if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
				die(implode(PHP_EOL, $o_Logs->getErrores()));
			}//fin log

			header("Location: ../logout.php");
			exit();
		}
	}
	
	/**
	 * Guarda si un usuario trata de entrar a una página de un modulo que no esta prendido
	 * 
	 * @param type $p_Modulo -> nombre del modulo
	 * @param type $p_Valor -> Valor si el modulo esta prendido(true) o apagado(false)
	 * 
	 */
	public static function Modulo($p_Modulo, $p_Valor) {
		if (!$p_Valor) {
			//genera log
			$o_Logs = new Logs_Web_O($_SESSION['USUARIO']['id'], _('Seguridad - Modulo') . ' ' . $p_Modulo, $_SERVER["REQUEST_URI"]);
			if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
				die(implode(PHP_EOL, $o_Logs->getErrores()));
			}//fin log

			header("Location: logout.php");
			exit();
		}
	}

	/**
	 * Guarda usuarios bloqueados que tratan de entrar al sistema
	 * 
	 * @param type $p_Id -> Id usuario
	 * @param type $p_Texto -> Texto aclarativo
	 */
	public static function Bloqueardo($p_Id, $p_Texto) {
		$o_Logs = new Logs_Web_O($p_Id, _('logout'), $p_Texto);
		if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
			die(implode(PHP_EOL, $o_Logs->getErrores()));
		}
	}
	
	/**
	 * Guarda las salidas exitosas de un usuario.
	 * 
	 * @param type $p_Id -> Id usuario
	 */
	public static function Logout($p_Id) {
		$o_Logs = new Logs_Web_O($p_Id, _('logout'));
		if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
			die(implode(PHP_EOL, $o_Logs->getErrores()));
		}
	}
	
	/**
	 **
	 * Registra los cambios que realiza algún usuario web para tener registros si hay problemas.
	 * 
	 * @param type $p_Id		-> Id usuario
	 * @param type $p_Accion	-> Palabra clave de la acción
	 * @param type $p_Reporte	-> Descripcion de lo que se iso
	 */
	public static function Reporte($p_Id, $p_Accion, $p_Reporte, $p_Tipo=0, $p_Adicional=0) {
		$o_Logs = new Logs_Web_O($p_Id, $p_Accion, $p_Reporte, $p_Tipo,$p_Adicional);
		if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
			die(implode(PHP_EOL, $o_Logs->getErrores()));
		}
	}
	
	
	
	/**
	 **
	 * Registra los cambios del sistema web.
	 * 
	 * @param integer $p_UId		-> Id usuario
	 * @param integer $p_Tipo -> Tipo de LOG
	 * @param string $p_Accion
	 * @param string $p_Detalle
	 * @param string $p_Adicional  ID adicional del objeto
	 * 
	 */
	public static function Log($p_UId, $p_Tipo=0, $p_Accion, $p_Detalle,  $p_Adicional=0) {
			
		$o_Logs = new Logs_Web_O($p_UId, $p_Accion, $p_Detalle, $p_Tipo, $p_Adicional);
		if (!$o_Logs->save(Registry::getInstance()->general['debug'])) {
			die(implode(PHP_EOL, $o_Logs->getErrores()));
		}
	}
	
	

}
