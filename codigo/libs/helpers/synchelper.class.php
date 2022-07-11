<?php


class SyncHelper
{


    public static function getPasarHex($p_Bin) {
        $hex = 0;
        $hex = dechex(bindec($p_Bin));
        return $hex;
    }


    /**
     *
     * Sync
     * envia la persona a los equipos correspondientes
     *
     * @param Persona_O $p_Obj_Per Persona
     * @param String $p_Equipo_UUID equipo donde se realizo la carga
     * @param String $p_OrigenSync origen del sync, por ej, un ping
     *
     */
    public static function SyncPersona($p_Obj_Per, $p_Equipo_UUID='', $p_OrigenSync='') {
        //le mando un mensaje a todos los equipos
        //donde NO esta la persona, le pongo eliminada en 1


        $a_o_Equipo = Equipo_L::obtenerTodos();
        $array_equipos = explode(':', $p_Obj_Per->getEquipos());
        if ($a_o_Equipo != null) {

            foreach ($a_o_Equipo as $o_Equipo) {
                /* @var $o_Equipo Equipo_O */

                if ($p_Equipo_UUID != '')
                    if ($p_Equipo_UUID != $o_Equipo->getUUID()) continue;     //ver esto


                if ($o_Equipo->isOffline())continue;   //no mando nada a equipos offline. que se jodan. para eso esta el ping despues

                if (!in_array($o_Equipo->getId(), $array_equipos))
                    $p_Obj_Per->setEnabled(0); //la persona no esta en este equipo
                else
                    $p_Obj_Per->setEnabled(1);//la persona si esta en este equipo

                if($p_OrigenSync=="PING")
                    PubSubHelper::sendSyncMessage(TYPE_PERSON, $p_Obj_Per->toSyncArray(), $o_Equipo->getUUID(),array("req"=>"ping"));
                else
                    PubSubHelper::sendSyncMessage(TYPE_PERSON, $p_Obj_Per->toSyncArray(), $o_Equipo->getUUID());

            }
        }

        if(Config_L::p('firebase_sync')){
            require_once(APP_PATH . '/libs/firebase/firebaseLib.php');
            $firebase = new \Firebase\FirebaseLib(FIREBASE_URL, FIREBASE_TOKEN);
            $firebase->set(FIREBASE_BASE_REF.'/personas/'.$p_Obj_Per->getId(), $p_Obj_Per->toArray(true));
        }


    }

    /**
     *
     * Sync
     * envia un array de personas a los equipos correspondientes
     *
     * @param array $p_array_personas Array de personas a enviar
     * @param String $p_Equipo_UUID si esta seteado, se envia solo a este equipo
     * @param String $p_OrigenSync origen del sync, por ej, un ping
     *
     */
    public static function SyncArrayPersonas($p_array_personas, $p_Equipo_UUID='', $p_OrigenSync='') {
        if (!is_null($p_array_personas)) {

            $a_o_Equipo = Equipo_L::obtenerTodos();
            foreach ($a_o_Equipo as $o_Equipo) {  /* @var $o_Equipo Equipo_O */
                if ($a_o_Equipo != null) {
                    if ($p_Equipo_UUID != '')
                        if ($p_Equipo_UUID != $o_Equipo->getUUID()) continue;
                    if ($o_Equipo->isOffline())continue;   //no mando nada a equipos offline. que se jodan. para eso esta el ping despues
                    $array_a_enviar=array();
                    foreach ($p_array_personas as $o_Persona) {  /* @var $o_Persona Persona_O */ // sync cada una de estas personas
                        // Sync
                        $array_equipos = explode(':', $o_Persona->getEquipos());

                        if (!in_array($o_Equipo->getId(), $array_equipos))
                            $o_Persona->setEnabled(0); //la persona no esta en este equipo
                        else
                            $o_Persona->setEnabled(1);//la persona si esta en este equipo

                        $array_a_enviar[]=$o_Persona->toSyncArray();
                    }

                    if($p_OrigenSync=="PING") {
                        PubSubHelper::sendSyncMessage(TYPE_PERSON, $array_a_enviar, $o_Equipo->getUUID(), array("req" => "ping"));
                        echo "size_mb:".formatBytes(mb_strlen(serialize($array_a_enviar), '8bit'),3);//si viene de un ping, hago echo del size para que quede en los logs
                    }
                    else
                        PubSubHelper::sendSyncMessage(TYPE_PERSON, $array_a_enviar, $o_Equipo->getUUID());


                }
            }
        }
    }

    public static function SyncTodasLasPersonas() {
        $a_o_Personas = Persona_L::obtenerTodos(); // busco todas las personas
        if (!is_null($a_o_Personas)) {
            foreach ($a_o_Personas as $o_Persona) { // sync cada una de estas personas
                // Sync
                SyncHelper::SyncPersona($o_Persona);
                // Fin Sync
            }
        }
    }



    /**
     *
     * Sync
     * envia las huellas a los equipos correspondientes
     *
     * @param Huella_O $p_Obj_Huella Huella
     *
     */
    public static function SyncHuella($p_Obj_Huella, $p_Equipo_UUID='') {
        //si equipo_uuid no viene especificado
        //le mando un mensaje con la huella a todos los equipos en donde esta la persona
        //$o_Persona = Persona_L::obtenerPorId($p_Obj_Huella->getPerId());
        //if(!is_null($o_Persona)){
        //    $a_equipos=explode(':',$o_Persona->getEquipos());
        //    foreach($a_equipos as $eq_id) {
        //        $o_Equipo = Equipo_L::obtenerPorId($eq_id);
        //        if(is_null($o_Equipo))echo($eq_id . ' no existe');
        //        if($p_Equipo_UUID!=''){
        //            if($p_Equipo_UUID!=$o_Equipo->getUUID())continue;
        //        }
                if($p_Obj_Huella->getDatosSize()>0)   //no sincronizo huellas vacias
                    PubSubHelper::sendSyncMessage(TYPE_FINGERPRINT, $p_Obj_Huella->toSyncArray(), $p_Equipo_UUID);
                    //PubSubHelper::sendSyncMessage(TYPE_FINGERPRINT, $p_Obj_Huella->toSyncArray(), $o_Equipo->getUUID());
        //    }
        //}
    }


    /**
     *
     * Sync
     * envia un array de huellas a los equipos correspondientes
     *
     * @param array $p_array_huellas Array de huellas a enviar
     * @param String $p_Equipo_UUID si esta seteado, se envia solo a este equipo
     * @param String $p_OrigenSync origen del sync, por ej, un ping
     *
     */
    public static function SyncArrayHuellas($p_array_huellas, $p_Equipo_UUID='', $p_OrigenSync='') {
        if (!is_null($p_array_huellas)) {

            $a_o_Equipo = Equipo_L::obtenerTodos();
            foreach ($a_o_Equipo as $o_Equipo) {  /* @var $o_Equipo Equipo_O */
                if ($a_o_Equipo != null) {
                    if ($p_Equipo_UUID != '')
                        if ($p_Equipo_UUID != $o_Equipo->getUUID()) continue;

                    if ($o_Equipo->isOffline())continue;   //no mando nada a equipos offline. que se jodan. para eso esta el ping despues
                    $array_a_enviar=array();

                    foreach ($p_array_huellas as $o_Huella) {  /* @var $o_Huella Huella_O */ // sync cada una de estas personas
                        if($o_Huella->getDatosSize()>0)
                            $array_a_enviar[]=$o_Huella->toSyncArray();
                    }

                    if($p_OrigenSync=="PING") {
                        PubSubHelper::sendSyncMessage(TYPE_FINGERPRINT, $array_a_enviar, $o_Equipo->getUUID(), array("req" => "ping"));
                        echo "size_mb:".formatBytes(mb_strlen(serialize($array_a_enviar), '8bit'),3);//si viene de un ping, hago echo del size para que quede en los logs
                    }
                    else
                        PubSubHelper::sendSyncMessage(TYPE_FINGERPRINT, $array_a_enviar, $o_Equipo->getUUID());


                }
            }
        }
    }

    public static function SyncTodasLasHuellas() {
        $a_o_Huellas = Huella_L::obtenerTodos(); // busco todas las huellas
        if (!is_null($a_o_Huellas)) {
            foreach ($a_o_Huellas as $o_Huella) { // sync cada una de estas personas
                SyncHelper::SyncHuella($o_Huella);
            }
        }
    }





}
