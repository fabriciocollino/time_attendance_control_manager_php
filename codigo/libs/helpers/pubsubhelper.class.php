<?php


class PubSubHelper
{





    /** publish funcion base para enviar por pubsub
     * @param $p_data   array datos
     * @param $p_attributes   array atributos
     */
    public static function publish($p_data, $p_attributes) {
        global $subdominio;
        global $psclient;

        $pubsub = new Google_Service_Pubsub($psclient);

        $topicName = 'projects/enpunto-1286/topics/clients-' . $subdominio;

        $Message = new Google_Service_Pubsub_PubsubMessage();
        $Message->setAttributes($p_attributes);
        $Message->setData(base64_encode($p_data));

        $Request = new Google_Service_Pubsub_PublishRequest();
        $Request->setMessages(array(
            $Message
        ));
        try {
            $pubsub->projects_topics->publish($topicName, $Request);
        }catch (Exception $e){
            //nada
        }
    }


    /** sendMessage Envia un mensaje por pubsub
     * @param $p_comando   string comando del mensaje, por ej 'CMD_SYNC'
     * @param $p_mensaje   string cuerpo del mensaje
     * @param $p_eq_id   integer id del equipo de destino
     * @param $opt_params array arrray con parametros opcionales
     */
    public static function sendMessage($p_comando, $p_mensaje, $p_eq_id, $opt_params=null){

        $atributos=array(
            'uuid' => (string)$p_eq_id,
            'cmd' => (string)$p_comando,
            'ver' => '1.0'
        );
        if($opt_params!=null)
            $atributos = array_merge($atributos, $opt_params);


        self::publish($p_mensaje,$atributos);
    }


    /** sendMessage Envia un mensaje de sync por pubsub
     * @param $p_type   string comando del mensaje, por ej 'TYPE_PERSON'
     * @param $p_a_objeto  array objeto sync
     * @param $p_eq_id   integer id del equipo de destino
     * @param $p_extra_atrib array atributos extra
     */
    public static function sendSyncMessage($p_type, $p_a_objeto, $p_eq_id, $p_extra_atrib=null)
    {

        $mensaje = json_encode($p_a_objeto);
        $atributos=array(
            'uuid' => (string)$p_eq_id,
            'cmd' => 'CMD_SYNC',
            'type' => (string)$p_type,
            'sess_id' => session_id(),
            'ver' => '1.0'
        );
        if($p_extra_atrib!=null){
            $atributos = array_merge($atributos,$p_extra_atrib);
        }
        self::publish($mensaje,$atributos);

    }


    /** sendMessage Envia un mensaje de sync por pubsub
     * @param $p_type   string comando del mensaje, por ej 'TYPE_PERSON'
     * @param $p_Objeto_Id  integer id del objeto
     *
     */
    public static function sendBrowserACK($p_Objeto_Id, $p_type)
    {

        $atributos=array(
            'cmd' => (string)CMD_ACK,
            'type' => (string)$p_type,
            'ver' => '1.0'
        );
        self::publish(json_encode($p_Objeto_Id),$atributos);

    }

}


