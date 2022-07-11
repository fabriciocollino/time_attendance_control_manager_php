<?php

require_once(dirname(__FILE__) . '/_ruta.php');

$Registro = Registry::getInstance();
if (isset ($_GET['log'])){
	SeguridadHelper::Entrar();
}else{
	SeguridadHelper::Logout(Registry::getInstance()->Usuario->getId());
}

$_SESSION = array();
unset($Registro->Usuario);
session_destroy();

header('Location: ' . WEB_ROOT . '/index.php');
exit();