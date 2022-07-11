<?php

class Planes_O {

    private $_id;
    private $_nombre;
    private $_descripcion;
    private $_caracteristicas;
    private $_activo;

    private $_frecuencia;
    private $_tipo_frecuencia;
    private $_monto;
    private $_tipo_moneda;
    private $_repeticiones;
    private $_prueba_gratuita;
    private $_mercadopago_plan_id;
    private $_modulos_permisos_id;
    private $_back_url;




    private $_errores;

    public function __construct(){
        $this->_id                      = 0;
        $this->_nombre                  = '';
        $this->_descripcion             = '';
        $this->_caracteristicas         = '';
        $this->_activo                  = 1;

        $this->_tipo_frecuencia         = "months";
        $this->_frecuencia              = 1;
        $this->_monto                   = 100;
        $this->_tipo_moneda             = "ARS";
        $this->_repeticiones            = 0;
        $this->_prueba_gratuita         ="no";
        $this->_mercadopago_plan_id     = '';
        $this->_modulos_permisos_id     = 0;
        $this->_back_url                = "https://www.mercadolibre.com.ar/";
    }

    public function getId(){
        return $this->_id;
    }

    public function setId($p_id){
        $p_id = (integer)$p_id;
        $this->_id = $p_id;
    }

    public function getNombre(){
        return $this->_nombre;
    }
    public function setNombre($p_Nombre){
        $p_Nombre = (string)$p_Nombre;
        $this->_nombre = $p_Nombre;
    }

    public function getDescripcion(){
        return $this->_descripcion;
    }
    public function setDescripcion($p_Descripcion){
        $p_Descripcion = (string)$p_Descripcion;
        $this->_descripcion = $p_Descripcion;
    }

    public function getCaracteristicas($p_max = '')
    {

        $salida = trim($this->_caracteristicas);

        $append = "&hellip;";

        if ($p_max != '') {
            $p_max = (integer)$p_max;
            if (strlen($salida) > $p_max) {
                $salida = wordwrap($salida, $p_max);
                $salida = explode("\n", $salida);
                $salida = array_shift($salida) . $append;
            }
        }


        return $salida;
    }
    public function setCaracteristicas($p_Caracteristicas){
        $p_Caracteristicas = (string)$p_Caracteristicas;
        $this->_caracteristicas = $p_Caracteristicas;
    }

    public function getActivo(){
        return $this->_activo;
    }
    public function setActivo($p_Activo){
        $p_Activo = (integer)$p_Activo;
        $this->_activo = $p_Activo;
    }

    public function getTipoFrecuencia(){
        return $this->_tipo_frecuencia;
    }
    public function setTipoFrecuencia($_p_tipo_frecuencia){
        $_p_tipo_frecuencia = (string)$_p_tipo_frecuencia;
        $this->_tipo_frecuencia = $_p_tipo_frecuencia;
    }

    public function getFrecuencia($p_idioma = ''){

        $p_frecuencia = $this->_frecuencia;

        if($p_idioma == 'AR') {
            switch ($p_frecuencia) {

                case 'days':
                    $p_frecuencia = 'Diario';
                    break;

                case 'months':
                    $p_frecuencia = 'Mensual';
                    break;

                case 'years':
                    $p_frecuencia = 'Anual';
                    break;
            }
        }


        return $p_frecuencia;



    }
    public function setFrecuencia($_p_frecuencia){
        $_p_frecuencia = (integer)$_p_frecuencia;
        $this->_frecuencia = $_p_frecuencia;
    }

    public function getMonto(){
        return $this->_monto;
    }
    public function setMonto($_p_monto){
        $_p_monto = (float)$_p_monto;
        $this->_monto = $_p_monto;
    }

    public function getTipoMoneda(){
        return $this->_tipo_moneda;
    }
    public function setTipoMoneda($_p_tipo_moneda){
        $_p_tipo_moneda = (string)$_p_tipo_moneda;
        $this->_tipo_moneda = $_p_tipo_moneda;
    }

    public function getRepeticiones(){
        return $this->_repeticiones;
    }
    public function setRepeticiones($_p_repeticiones){
        $_p_repeticiones = (integer)$_p_repeticiones;
        $this->_repeticiones = $_p_repeticiones;
    }

    public function getPruebaGratuita(){
        return $this->_prueba_gratuita;
    }
    public function setPruebaGratuita($_p_prueba_gratuita){
        $_p_prueba_gratuita = (string)$_p_prueba_gratuita;
        $this->_prueba_gratuita = $_p_prueba_gratuita;
    }
    public function getPeriodoPrueba(){
        $p_Prueba_Gratuita = $this->_prueba_gratuita;

        if ($p_Prueba_Gratuita == 'no'){
            return 'No' ;
        }

        $p_tipo = $this->_tipo_frecuencia;
        $p_frecuencia = $this->_frecuencia;

        switch ($p_tipo) {

            case 'days':
                $p_tipo = 'Día/s';
                break;

            case 'months':
                $p_tipo = 'Mes';
                break;

            case 'years':
                $p_tipo = 'Año';
                break;
        }

        return $p_frecuencia . " x ". $p_tipo ;
    }

    public function get_Modulos_Permisos_Id (){
        return $this->_modulos_permisos_id;
    }
    public function set_Modulos_Permisos_Id($p_Modulos_Permisos_Id){
        $p_Modulos_Permisos_Id = (integer) $p_Modulos_Permisos_Id;
        $this->_modulos_permisos_id = $p_Modulos_Permisos_Id;
    }

    public function getMercadopagoPlanId(){
        return $this->_mercadopago_plan_id;
    }
    public function setMercadopagoPlanId($p_Preapprobal_Plan_Id){
        $p_Preapprobal_Plan_Id = (string) $p_Preapprobal_Plan_Id;
        $this->_mercadopago_plan_id = $p_Preapprobal_Plan_Id;
    }

    public function getBackUrl(){
        return $this->_back_url;
    }
    public function setBackUrl($_p_back_url){
        $_p_back_url = (string)$_p_back_url;
        $this->_back_url = $_p_back_url;
    }

    public function CrearPlanMercadoPago(){

        $p_back_url                         = $this->_back_url;
        $p_reason                           = $this->_nombre;
        $p_frequency_type                   = $this->_tipo_frecuencia;
        $p_frequency                        = $this->_frecuencia;
        $p_transaction_amount               = $this->_monto;
        $p_currency_id                      = $this->_tipo_moneda;
        $p_repetitions                      = $this->_repeticiones;
        $p_prueba_gratuita                  = $this->_prueba_gratuita;


        // TOKEN PARA SUSCRIPCIONES (MERCADO PAGO)
        MercadoPago\SDK::setAccessToken(ACCESS_TOKEN_MERCADOPAGO_SUSCRIPCIONES);

        // VARIABLES
        $service_url                = 'https://api.mercadopago.com/preapproval_plan';
        $curl_post_data             = array(

            "back_url"          => $p_back_url,
            "reason"            =>  $p_reason,
            "auto_recurring"    => array(
                "frequency"             =>  $p_frequency,
                "frequency_type"        =>  $p_frequency_type,
                "transaction_amount"    =>  $p_transaction_amount,
                "currency_id"           =>  $p_currency_id
            )
        );


        if($p_repetitions > 0 ){
            $curl_post_data['auto_recurring']['repetitions'] = $p_repetitions;
        }

        if ($p_prueba_gratuita == "si"){
            $curl_post_data['auto_recurring']['free_trial']['frequency_type']   = $p_frequency_type;
            $curl_post_data['auto_recurring']['free_trial']['frequency']        = $p_frequency;
        }

        // CURL INIT
        $ch = curl_init($service_url);

        // CURL OPTIONS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Authorization: Bearer '.ACCESS_TOKEN_MERCADOPAGO_SUSCRIPCIONES));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // CURL EXEC
        $curl_response      = curl_exec($ch);
        $response           = json_decode($curl_response,true);

        // CURL CLOSE
        curl_close($ch);

        if(!isset($response['id'])){
            $this->_errores['mysql'] = json_encode($response);
            return false;
        }

        $this->_mercadopago_plan_id = $response['id'];

        return true;
    }
    public function UpdatePlanMercadoPago(){

        /*
               // ACCESS TOKEN MERCADOPAGO
        MercadoPago\SDK::setAccessToken($access_token_suscripciones);

        // VARIABLES
        $curl_post_data     = array(
            "status"            => $status,
            "application_id"    => $application_id
        );
        $service_url                        = 'https://api.mercadopago.com/preapproval/' . $preapproval_id;

        // CURL INIT
        $ch = curl_init($service_url);

        // CURL OPTIONS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer ' . $access_token_suscripciones));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // CURL EXEC
        $curl_response = curl_exec($ch);
        $response = json_decode($curl_response, true);

        // CURL CLOSE
        curl_close($ch);

        */

        $p_back_url                         = $this->_back_url;
        $p_reason                           = $this->_nombre;

        $p_frequency_type                   = $this->_tipo_frecuencia;
        $p_frequency                        = $this->_frecuencia;
        $p_transaction_amount               = $this->_monto;
        $p_currency_id                      = $this->_tipo_moneda;
        $p_repetitions                      = $this->_repeticiones;
        $p_prueba_gratuita                  = $this->_prueba_gratuita;

        $preapproval_plan_id                = $this->_mercadopago_plan_id;

        // TOKEN PARA SUSCRIPCIONES (MERCADO PAGO)
        MercadoPago\SDK::setAccessToken(ACCESS_TOKEN_MERCADOPAGO_SUSCRIPCIONES);

        // VARIABLES
        $service_url            = 'https://api.mercadopago.com/preapproval_plan/' . $preapproval_plan_id;
        $curl_post_data         = array(

            "reason"            =>  $p_reason,
            "back_url"          => $p_back_url,
            "auto_recurring"    => array(
                "frequency"             =>  $p_frequency,
                "frequency_type"        =>  $p_frequency_type,
                "transaction_amount"    =>  $p_transaction_amount,
                "currency_id"           =>  $p_currency_id
            )
        );


        if($p_repetitions > 0 ){
            $curl_post_data['auto_recurring']['repetitions'] = $p_repetitions;
        }


        if ($p_prueba_gratuita == "si"){
            $curl_post_data['auto_recurring']['free_trial']['frequency_type']   = $p_frequency_type;
            $curl_post_data['auto_recurring']['free_trial']['frequency']        = $p_frequency;
        }
        else{
            $curl_post_data['auto_recurring']['free_trial']['frequency_type']   = null;
            $curl_post_data['auto_recurring']['free_trial']['frequency']        = null;
        }

        // CURL INIT
        $ch = curl_init($service_url);

        // CURL OPTIONS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer ' . ACCESS_TOKEN_MERCADOPAGO_SUSCRIPCIONES));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // CURL EXEC
        $curl_response      = curl_exec($ch);
        $response           = json_decode($curl_response,true);

        // CURL CLOSE
        curl_close($ch);

        if(!isset($response['id'])){
            $this->_errores['mysql'] = json_encode($response);
            return false;
        }


        return true;
    }

    public function loadArray($p_Datos){
        $this->_id                                  = (integer)$p_Datos["plan_Id"];
        $this->_nombre                              = (string)$p_Datos["plan_Nombre"];
        $this->_descripcion                         = (string)$p_Datos["plan_Descripcion"];
        $this->_caracteristicas                     = (string)$p_Datos["plan_Caracteristicas"];
        $this->_activo                              = (integer)$p_Datos["plan_Activo"];
        $this->_mercadopago_plan_id                 = (string) $p_Datos["plan_Mercadopago_Plan_Id"];

        $this->_tipo_frecuencia                     = (string)$p_Datos["plan_Tipo_Frecuencia"];
        $this->_frecuencia                          = (integer)$p_Datos["plan_Frecuencia"];
        $this->_monto                               = (float)$p_Datos["plan_Monto"];
        $this->_tipo_moneda                         = (string)$p_Datos["plan_Tipo_Moneda"];
        $this->_repeticiones                        = (integer)$p_Datos["plan_Repeticiones"];
        $this->_prueba_gratuita                     = (string)$p_Datos["plan_Prueba_Gratuita"];
        $this->_modulos_permisos_id                 = (string) $p_Datos["plan_Modulos_Permisos_Id"];
        $this->_back_url                            = (string) $p_Datos["plan_Back_Url"];

        return true;
    }
    public function LoadArrayMercadoPago($p_data = array()) {

        $this->_nombre              = isset($p_data['reason']) ? (string) $p_data['reason']:$this->_nombre ;
        $this->_frecuencia          = isset($p_data['auto_recurring']['frequency']) ? (int) $p_data['auto_recurring']['frequency']:$this->_frecuencia ;
        $this->_tipo_frecuencia     = isset($p_data['auto_recurring']['frequency_type']) ? (string) $p_data['auto_recurring']['frequency_type']:$this->_tipo_frecuencia ;
        $this->_monto               = isset($p_data['auto_recurring']['transaction_amount']) ? (float) $p_data['auto_recurring']['transaction_amount']:$this->_monto ;
        $this->_tipo_moneda         = isset($p_data['auto_recurring']['currency_id']) ? (string) $p_data['auto_recurring']['currency_id']:$this->_tipo_moneda ;
        $this->_repeticiones        = isset($p_data['auto_recurring']['repetitions']) ? (int) $p_data['auto_recurring']['repetitions']:$this->_repeticiones ;
        $this->_back_url            = isset($p_data['back_url']) ? (string) $p_data['back_url']:$this->_back_url ;
    }
    public function GetArrayMercadoPago(){
        //sleep(1);

        $preapproval_plan_id                = $this->_mercadopago_plan_id;

        // TOKEN PARA SUSCRIPCIONES (MERCADO PAGO)
        MercadoPago\SDK::setAccessToken(ACCESS_TOKEN_MERCADOPAGO_SUSCRIPCIONES);


        // VARIBALES
        $service_url            = 'https://api.mercadopago.com/preapproval_plan/' . $preapproval_plan_id;

        // CURL INIT
        $ch = curl_init($service_url);

        // CURL OPTIONS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Authorization: Bearer '.ACCESS_TOKEN_MERCADOPAGO_SUSCRIPCIONES));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // CURL EXEC
        $curl_response      = curl_exec($ch);

        // PLANES
        $p_response         = json_decode($curl_response,true);

        printear($p_response);


        // CURL CLOSE
        curl_close($ch);

        if(!isset($response['id'])){
            $this->_errores['mysql'] = json_encode($p_response);
            return false;
        }


        if (isset($p_response['results'][0])){
            $this->LoadArrayMercadoPago($p_response);
        }


        return true;

    }

    public function save($p_Debug=false){

        if (!$this->esValido()) {
            return false;
        }

        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $datos=array(
            'plan_Id'                               => $this->_id,
            'plan_Nombre'                           => $this->_nombre,
            'plan_Descripcion'                      => $this->_descripcion,
            'plan_Caracteristicas'                  => $this->_caracteristicas,
            'plan_Activo'                           => $this->_activo,
            'plan_Mercadopago_Plan_Id'              => $this->_mercadopago_plan_id,

            'plan_Tipo_Frecuencia'                  => $this->_tipo_frecuencia,
            'plan_Frecuencia'                       => $this->_frecuencia,
            'plan_Monto'                            => $this->_monto,
            'plan_Tipo_Moneda'                      => $this->_tipo_moneda,
            'plan_Repeticiones'                     => $this->_repeticiones,
            'plan_Prueba_Gratuita'                  => $this->_prueba_gratuita,
            'plan_Modulos_Permisos_Id'              => $this->_modulos_permisos_id,
            'plan_Back_Url'                         => $this->_back_url

        );

        if($this->_id==0){
            $resultado = $cnn->Insert('planes',$datos);
            if($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        }
        else {
            $resultado = $cnn->Update('planes', $datos, "plan_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;

    }
    public function delete($p_Debug){
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        if ($this->_id == 0) {
            return false;
        }

        $resultado = $cnn->Delete('planes', "plan_Id = " . $this->_id);

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
        return true;
    }

    public function getErrores(){
        return $this->_errores;
    }
    public function esValido()
    {
        //Si el array errores no tiene elementos entonces el objeto es valido.
        return count($this->_errores) == 0;
    }



}
