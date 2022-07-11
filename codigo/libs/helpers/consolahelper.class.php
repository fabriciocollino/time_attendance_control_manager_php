<?php

class ConsolaHelper
{

    public static function ejecutarComandoConsola($p_Comando, $p_Obj_Gat, $p_die = 1)
    {
        $additionalHeaders = "";
        $payloadName = "";


        if ($p_Comando != '' && is_object($p_Obj_Gat)) {
            $submit_url = "http://" . $p_Obj_Gat->getIp() . "/SYNC/consola.cgi" . "?comando=" . urlencode($p_Comando);

            $process = curl_init($submit_url);
            curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));
            curl_setopt($process, CURLOPT_HEADER, 1);
            curl_setopt($process, CURLOPT_USERPWD, $p_Obj_Gat->getHost() . ':' . strtolower($p_Obj_Gat->getPassword()));
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            curl_setopt($process, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, $payloadName);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $buffer = curl_exec($process);
            curl_close($process);

            if (empty($buffer)) {
                if ($p_die)
                    die(_('No se pudo conectar con el Equipo') . ' \"' . $p_Obj_Gat->getHost() . '\" IP: ' . $p_Obj_Gat->getIp());
                else
                    echo(_('No se pudo conectar con el Equipo') . ' \"' . $p_Obj_Gat->getHost() . '\" IP: ' . $p_Obj_Gat->getIp());
            } else
                return TRUE;

        } else {
            if ($p_die)
                die(_('Parámetros erróneos consulte con su programador. Error Consola - 01.00'));
            else
                echo(_('Parámetros erróneos consulte con su programador. Error Consola - 01.00'));
        }
    }

}



