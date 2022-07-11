<?php


$T_Titulo = _('Api');
$T_Script = 'api';
$Item_Name = "api";
$T_Link = '';
$T_Mensaje = '';
 
$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;

SeguridadHelper::Pasar(90);   //a este controller no accede nadie, excepto los admins

//echo "<pre>";print_r($_REQUEST);echo "</pre>";

switch ($T_Tipo) {
    case 'enable_and_generate':

        $o_api_key = null;
        $o_api_key = Config_L::obtenerPorParametro('api_key'); if(is_null($o_api_key))die('no se encontro el parametro key');
        $o_api_key->setValor(md5(bin2hex(random_bytes(15))));
        $o_api_key->save('Off');

        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_API_GENERAR_KEY, $a_Logs_Tipos[LOG_API_GENERAR_KEY], '', 0);

        $o_api_enabled = null;
        $o_api_enabled = Config_L::obtenerPorParametro('api_enabled');if(is_null($o_api_enabled))die('no se encontro el parametro enabled');
        $o_api_enabled->setValor(1);
        $o_api_enabled->save('Off');
        
        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_API_ACTIVAR, $a_Logs_Tipos[LOG_API_ACTIVAR], '', 0);
        

        break;
    case 'regenerate':

        $o_api_key = null;
        $o_api_key = Config_L::obtenerPorParametro('api_key'); if(is_null($o_api_key))die('no se encontro el parametro key');
        $o_api_key->setValor(md5(bin2hex(random_bytes(15))));
        $o_api_key->save('Off');

        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_API_REGENERAR_KEY, $a_Logs_Tipos[LOG_API_REGENERAR_KEY], '', 0);

        break;
    case 'enable':

        $o_api_enabled = null;
        $o_api_enabled = Config_L::obtenerPorParametro('api_enabled');if(is_null($o_api_enabled))die('no se encontro el parametro enabled');
        $o_api_enabled->setValor(1);
        $o_api_enabled->save('Off');

        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_API_ACTIVAR, $a_Logs_Tipos[LOG_API_ACTIVAR], '', 0);

        break;
    case 'disable':

        $o_api_enabled = null;
        $o_api_enabled = Config_L::obtenerPorParametro('api_enabled');if(is_null($o_api_enabled))die('no se encontro el parametro enabled');
        $o_api_enabled->setValor(0);
        $o_api_enabled->save('Off');

        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_API_DESACTIVAR, $a_Logs_Tipos[LOG_API_DESACTIVAR], '', 0);

        break;
    case 'test_mode_on':

        $o_api_test_mode = null;
        $o_api_test_mode = Config_L::obtenerPorParametro('api_test_mode');if(is_null($o_api_test_mode))die('no se encontro el parametro test mode');
        $o_api_test_mode->setValor(1);
        $o_api_test_mode->save('Off');

        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_API_MODO_DE_PRUEBAS_ON, $a_Logs_Tipos[LOG_API_MODO_DE_PRUEBAS_ON], '', 0);

        break;
    case 'test_mode_off':

        $o_api_test_mode = null;
        $o_api_test_mode = Config_L::obtenerPorParametro('api_test_mode'); if(is_null($o_api_test_mode))die('no se encontro el parametro test mode');
        $o_api_test_mode->setValor(0);
        $o_api_test_mode->save('Off');

        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_API_MODO_DE_PRUEBAS_OFF, $a_Logs_Tipos[LOG_API_MODO_DE_PRUEBAS_OFF], '', 0);

        break;
    default:
        defaultlabel:

        
        
        $T_Link = '';
        break;
}
