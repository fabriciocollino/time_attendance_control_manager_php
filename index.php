<?php

require_once(dirname(__FILE__) . '/_ruta.php');

if (isset($_POST['btnLogout'])) {
	header('Location: ' . WEB_ROOT . '/logout.php');
	exit();
}

 
$T_Usuario = isset($_POST['username']) ? $_POST['username'] : '';
$T_Clave = isset($_POST['password']) ? $_POST['password'] : '';

if (isset($_POST['btnLogin'])) {
	$o_Usuario = Usuario_L::obtenerPorLogin($T_Usuario, $T_Clave);
	if (is_null($o_Usuario)) {
		$T_Error = _('Usuario o Contraseña incorrecta.');
		SeguridadHelper::Login(0, $T_Usuario, $T_Clave);
	} else {
		session_regenerate_id(true);
		$_SESSION['USUARIO']['id'] = $o_Usuario->getId();	
		SeguridadHelper::Login($_SESSION['USUARIO']['id']);
		header('Location: ' . WEB_ROOT . '/index.php');
		exit();
	}
}

$T_ContentScript = APP_PATH . '/templates/inicio.html.php';
require_once APP_PATH . '/templates/layout.html.php';

  