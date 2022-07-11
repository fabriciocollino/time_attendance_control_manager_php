<?php

class MQTTHelper
{

    /** sendMessage Envia un mensaje a mqtt
     * @param $p_subdominio   subominio del cliente
     * @param $p_tipo   tipo de mensaje a enviar, por ej: 'equipo'
     * @param $p_objeto  objeto para obtener informacion extra de ser necesario
     * @param $p_Mensaje mensaje a enviar
     */
    public static function sendMessage($p_tipo, $p_objeto, $p_Mensaje)
    {

        global $subdominio;

        $host = Config_L::p('host_mqtt');
        $port = Config_L::p('port_mqtt');
        $username = Config_L::p('user_mqtt');
        $password = Config_L::p('password_mqtt');

        $mqtt = new phpMQTT($host, $port, $subdominio."PHPsend");

        //$mqtt->debug=true;

        if ($mqtt->connect(true, NULL, $username, $password)) {
            if($p_tipo=='equipo' && !is_null($p_objeto))$hash=$p_objeto->getHash();
            else $hash='';
            //echo $subdominio . "/" . $p_tipo . "/" . $hash;
            $mqtt->publish($subdominio . "/" . $p_tipo . "/" . $hash, $p_Mensaje, 1, 0);
            $mqtt->close();
        } else {
            echo "Could not connect MQTT<br />";
        }


    }

}

