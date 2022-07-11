<?php


class Suscripcion_O
{
    private $_plan;
    private $_cliente;
    private $_modulos_permisos_id;
    private $_status ;
    private $_reason ;
    private $_summarized_quotas ;
    private $_summarized_semaphore ;
    private $_summarized_charged_quantity ;
    private $_summarized_pending_charge_quantity ;
    private $_summarized_charged_amount ;
    private $_summarized_pending_charge_amount ;
    private $_summarized_last_charged_date ;
    private $_summarized_last_charged_amount ;
    private $_payer_id ;
    private $_payer_email ;
    private $_back_url ;
    private $_collector_id ;
    private $_application_id ;
    private $_external_reference ;
    private $_date_created ;
    private $_last_modified ;
    private $_init_point ;
    private $_sandbox_init_point ;
    private $_preapproval_id ;
    private $_preapproval_plan_id ;
    private $_auto_recurring_frequency ;
    private $_auto_recurring_frequency_type ;
    private $_auto_recurring_transaction_amount ;
    private $_auto_recurring_currency_id ;
    private $_auto_recurring_start_date ;
    private $_auto_recurring_end_date ;
    private $_next_payment_date ;
    private $_payment_method_id ;
    private $_payer_first_name ;
    private $_payer_last_name ;

    private $_factura_CAE ;
    private $_factura_URL ;

    private $_errores;

    public function __construct() {
        $this->_id = 0;
        $this->_plan = 0;
        $this->_cliente = 0;
        $this->_modulos_permisos_id = '';

        ///////////
        $this->_status = '' ;
        $this->_reason = '' ;
        $this->_summarized_quotas = 0 ;
        $this->_summarized_semaphore = '' ;
        $this->_summarized_charged_quantity = 0 ;
        $this->_summarized_pending_charge_quantity = 0 ;
        $this->_summarized_charged_amount = 0.00 ;
        $this->_summarized_pending_charge_amount = 0.00 ;
        $this->_summarized_last_charged_date = '' ;
        $this->_summarized_last_charged_amount = 0.00 ;
        $this->_payer_id = '' ;
        $this->_payer_email = '' ;
        $this->_back_url = '' ;
        $this->_collector_id = '' ;
        $this->_application_id = '' ;
        $this->_external_reference = '' ;
        $this->_date_created = '' ;
        $this->_last_modified = '' ;
        $this->_init_point = '' ;
        $this->_sandbox_init_point = '' ;
        $this->_preapproval_plan_id = '' ;
        $this->_preapproval_id = '' ;
        $this->_auto_recurring_frequency = 0 ;
        $this->_auto_recurring_frequency_type = '' ;
        $this->_auto_recurring_transaction_amount = 0.00 ;
        $this->_auto_recurring_currency_id = '' ;
        $this->_auto_recurring_start_date = '' ;
        $this->_auto_recurring_end_date = '' ;
        $this->_next_payment_date = '' ;
        $this->_payment_method_id = '' ;
        $this->_payer_first_name = '' ;
        $this->_payer_last_name = '' ;

        $this->_card_token_id = '' ;
        $this->_factura_CAE = '' ;
        $this->_factura_URL = '' ;


    }

    public function getId() {
        return $this->_id;
    }

    public function setId($p_id) {
        $p_id = (integer)$p_id;
        $this->_id = $p_id;
    }

    public function getPlan() {
        return $this->_plan;
    }

    public function setPlan($p_plan) {
        $p_plan = (integer)$p_plan;
        $this->_plan = $p_plan;
    }

    public function getCliente() {
        return $this->_cliente;
    }

    public function setCliente($p_cliente) {
        $p_cliente = (integer)$p_cliente;
        $this->_cliente = $p_cliente;
    }


    public function get_Modulos_Permisos_Id (){
        return $this->_modulos_permisos_id;
    }
    public function set_Modulos_Permisos_Id($p_Modulos_Permisos_Id){
        $p_Modulos_Permisos_Id = (string) $p_Modulos_Permisos_Id;
        $this->_modulos_permisos_id = $p_Modulos_Permisos_Id;
    }


    public function loadArray($p_Datos) {
        $this->_id = (integer)$p_Datos["susc_Id"];
        $this->_plan = (integer)$p_Datos["susc_Plan"];
        $this->_cliente = (integer)$p_Datos["susc_Cliente"];
        $this->_modulos_permisos_id = (string)$p_Datos["susc_modulos_permisos_id"];
        $this->_status  =  (string) $p_Datos ['susc_status'];
        $this->_reason  =  (string) $p_Datos ['susc_reason'];
        $this->_summarized_quotas  =  (int) $p_Datos ['susc_summarized_quotas'];
        $this->_summarized_semaphore  =  (string) $p_Datos ['susc_summarized_semaphore'];
        $this->_summarized_charged_quantity  =  (int) $p_Datos ['susc_summarized_charged_quantity'];
        $this->_summarized_pending_charge_quantity  =  (int) $p_Datos ['susc_summarized_pending_charge_quantity'];
        $this->_summarized_charged_amount  =  (float) $p_Datos ['susc_summarized_charged_amount'];
        $this->_summarized_pending_charge_amount  =  (float) $p_Datos ['susc_summarized_pending_charge_amount'];
        $this->_summarized_last_charged_date  =  (string) $p_Datos ['susc_summarized_last_charged_date'];
        $this->_summarized_last_charged_amount  =  (float) $p_Datos ['susc_summarized_last_charged_amount'];
        $this->_payer_id  =  (string) $p_Datos ['susc_payer_id'];
        $this->_payer_email  =  (string) $p_Datos ['susc_payer_email'];
        $this->_back_url  =  (string) $p_Datos ['susc_back_url'];
        $this->_collector_id  =  (string) $p_Datos ['susc_collector_id'];
        $this->_application_id  =  (string) $p_Datos ['susc_application_id'];
        $this->_external_reference  =  (string) $p_Datos ['susc_external_reference'];
        $this->_date_created  =  (string) $p_Datos ['susc_date_created'];
        $this->_last_modified  =  (string) $p_Datos ['susc_last_modified'];
        $this->_init_point  =  (string) $p_Datos ['susc_init_point'];
        $this->_sandbox_init_point  =  (string) $p_Datos ['susc_sandbox_init_point'];
        $this->_preapproval_plan_id  =  (string) $p_Datos ['susc_preapproval_plan_id'];
        $this->_preapproval_id  =  (string) $p_Datos ['susc_preapproval_id'];

        $this->_auto_recurring_frequency  =  (int) $p_Datos ['susc_auto_recurring_frequency'];
        $this->_auto_recurring_frequency_type  =  (string) $p_Datos ['susc_auto_recurring_frequency_type'];
        $this->_auto_recurring_transaction_amount  =  (float) $p_Datos ['susc_auto_recurring_transaction_amount'];
        $this->_auto_recurring_currency_id  =  (string) $p_Datos ['susc_auto_recurring_currency_id'];
        $this->_auto_recurring_start_date  =  (string) $p_Datos ['susc_auto_recurring_start_date'];
        $this->_auto_recurring_end_date  =  (string) $p_Datos ['susc_auto_recurring_end_date'];
        $this->_next_payment_date  =  (string) $p_Datos ['susc_next_payment_date'];
        $this->_payment_method_id  =  (string) $p_Datos ['susc_payment_method_id'];
        $this->_payer_first_name  =  (string) $p_Datos ['susc_payer_first_name'];
        $this->_payer_last_name  =  (string) $p_Datos ['susc_payer_last_name'];

        $this->_card_token_id  =  (string) $p_Datos ['susc_modulos_permisos_id'];
        $this->_factura_CAE  =  (string) $p_Datos ['susc_factura_CAE'];
        $this->_factura_URL  =  (string) $p_Datos ['susc_factura_URL'];

    }

    public function save($p_Debug = true) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConnMGR;

        $datos = array(
            'susc_Id' => $this->_id,
            'susc_Plan' => $this->_plan,
            'susc_Cliente' => $this->_cliente,
            'susc_modulos_permisos_id' => $this->_modulos_permisos_id,
            'susc_status' => $this->_status ,
            'susc_reason' => $this->_reason ,
            'susc_summarized_quotas' => $this->_summarized_quotas ,
            'susc_summarized_semaphore' => $this->_summarized_semaphore ,
            'susc_summarized_charged_quantity' => $this->_summarized_charged_quantity ,
            'susc_summarized_pending_charge_quantity' => $this->_summarized_pending_charge_quantity ,
            'susc_summarized_charged_amount' => $this->_summarized_charged_amount ,
            'susc_summarized_pending_charge_amount' => $this->_summarized_pending_charge_amount ,
            'susc_summarized_last_charged_date' => $this->_summarized_last_charged_date ,
            'susc_summarized_last_charged_amount' => $this->_summarized_last_charged_amount ,
            'susc_payer_id' => $this->_payer_id ,
            'susc_payer_email' => $this->_payer_email ,
            'susc_back_url' => $this->_back_url ,
            'susc_collector_id' => $this->_collector_id ,
            'susc_application_id' => $this->_application_id ,
            'susc_external_reference' => $this->_external_reference ,
            'susc_date_created' => $this->_date_created ,
            'susc_last_modified' => $this->_last_modified ,
            'susc_init_point' => $this->_init_point ,
            'susc_sandbox_init_point' => $this->_sandbox_init_point ,
            'susc_preapproval_plan_id' => $this->_preapproval_plan_id ,
            'susc_preapproval_id' => $this->_preapproval_id ,
            'susc_auto_recurring_frequency' => $this->_auto_recurring_frequency ,
            'susc_auto_recurring_frequency_type' => $this->_auto_recurring_frequency_type ,
            'susc_auto_recurring_transaction_amount' => $this->_auto_recurring_transaction_amount ,
            'susc_auto_recurring_currency_id' => $this->_auto_recurring_currency_id ,
            'susc_auto_recurring_start_date' => $this->_auto_recurring_start_date ,
            'susc_auto_recurring_end_date' => $this->_auto_recurring_end_date ,
            'susc_next_payment_date' => $this->_next_payment_date ,
            'susc_payment_method_id' => $this->_payment_method_id ,
            'susc_payer_first_name' => $this->_payer_first_name ,
            'susc_payer_last_name' => $this->_payer_last_name ,
            'susc_card_token_id' => $this->_card_token_id ,
            'susc_factura_CAE' => $this->_factura_CAE ,
            'susc_factura_URL' => $this->_factura_URL

        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('suscripciones', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('suscripciones', $datos, "susc_Id = {$this->_id}");
        }


        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;

    }

    public function loadArrayMercadoPago($p_suscripcion) {

        $this->_status = isset($p_suscripcion['status']) ? (string) $p_suscripcion['status']:$this->_status ;
        $this->_reason = isset($p_suscripcion['reason']) ? (string) $p_suscripcion['reason']:$this->_reason ;
        $this->_summarized_quotas = isset($p_suscripcion['summarized']['quotas']) ? (int) $p_suscripcion['summarized']['quotas']:$this->_summarized_quotas ;
        $this->_summarized_semaphore = isset($p_suscripcion['summarized']['semaphore']) ? (string) $p_suscripcion['summarized']['semaphore']:$this->_summarized_semaphore ;
        $this->_summarized_charged_quantity = isset($p_suscripcion['summarized']['charged_quantity']) ? (int) $p_suscripcion['summarized']['charged_quantity']:$this->_summarized_charged_quantity ;
        $this->_summarized_pending_charge_quantity = isset($p_suscripcion['summarized']['pending_charge_quantity']) ? (int) $p_suscripcion['summarized']['pending_charge_quantity']:$this->_summarized_pending_charge_quantity ;
        $this->_summarized_charged_amount = isset($p_suscripcion['summarized']['charged_amount']) ? (float) $p_suscripcion['summarized']['charged_amount']:$this->_summarized_charged_amount ;
        $this->_summarized_pending_charge_amount = isset($p_suscripcion['summarized']['pending_charge_amount']) ? (float) $p_suscripcion['summarized']['pending_charge_amount']:$this->_summarized_pending_charge_amount ;
        $this->_summarized_last_charged_date = isset($p_suscripcion['summarized']['last_charged_date']) ? (string) $p_suscripcion['summarized']['last_charged_date']:$this->_summarized_last_charged_date ;
        $this->_summarized_last_charged_amount = isset($p_suscripcion['summarized']['last_charged_amount']) ? (float) $p_suscripcion['summarized']['last_charged_amount']:$this->_summarized_last_charged_amount ;
        $this->_payer_id = isset($p_suscripcion['payer_id']) ? (string) $p_suscripcion['payer_id']:$this->_payer_id ;
        $this->_payer_email = isset($p_suscripcion['payer_email']) ? (string) $p_suscripcion['payer_email']:$this->_payer_email ;
        $this->_back_url = isset($p_suscripcion['back_url']) ? (string) $p_suscripcion['back_url']:$this->_back_url ;
        $this->_collector_id = isset($p_suscripcion['collector_id']) ? (string) $p_suscripcion['collector_id']:$this->_collector_id ;
        $this->_application_id = isset($p_suscripcion['application_id']) ? (string) $p_suscripcion['application_id']:$this->_application_id ;
        $this->_external_reference = isset($p_suscripcion['external_reference']) ? (string) $p_suscripcion['external_reference']:$this->_external_reference ;
        $this->_date_created = isset($p_suscripcion['date_created']) ? (string) $p_suscripcion['date_created']:$this->_date_created ;
        $this->_last_modified = isset($p_suscripcion['last_modified']) ? (string) $p_suscripcion['last_modified']:$this->_last_modified ;
        $this->_init_point = isset($p_suscripcion['init_point']) ? (string) $p_suscripcion['init_point']:$this->_init_point ;
        $this->_sandbox_init_point = isset($p_suscripcion['sandbox_init_point']) ? (string) $p_suscripcion['sandbox_init_point']:$this->_sandbox_init_point ;
        $this->_preapproval_plan_id = isset($p_suscripcion['preapproval_plan_id']) ? (string) $p_suscripcion['preapproval_plan_id']:$this->_preapproval_plan_id ;
        $this->_auto_recurring_frequency = isset($p_suscripcion['auto_recurring']['frequency']) ? (int) $p_suscripcion['auto_recurring']['frequency']:$this->_auto_recurring_frequency ;
        $this->_auto_recurring_frequency_type = isset($p_suscripcion['auto_recurring']['frequency_type']) ? (string) $p_suscripcion['auto_recurring']['frequency_type']:$this->_auto_recurring_frequency_type ;
        $this->_auto_recurring_transaction_amount = isset($p_suscripcion['auto_recurring']['transaction_amount']) ? (float) $p_suscripcion['auto_recurring']['transaction_amount']:$this->_auto_recurring_transaction_amount ;
        $this->_auto_recurring_currency_id = isset($p_suscripcion['auto_recurring']['currency_id']) ? (string) $p_suscripcion['auto_recurring']['currency_id']:$this->_auto_recurring_currency_id ;
        $this->_auto_recurring_start_date = isset($p_suscripcion['auto_recurring']['start_date']) ? (string) $p_suscripcion['auto_recurring']['start_date']:$this->_auto_recurring_start_date ;
        $this->_auto_recurring_end_date = isset($p_suscripcion['auto_recurring']['end_date']) ? (string) $p_suscripcion['auto_recurring']['end_date']:$this->_auto_recurring_end_date ;
        $this->_next_payment_date = isset($p_suscripcion['next_payment_date']) ? (string) $p_suscripcion['next_payment_date']:$this->_next_payment_date ;
        $this->_payment_method_id = isset($p_suscripcion['payment_method_id']) ? (string) $p_suscripcion['payment_method_id']:$this->_payment_method_id ;
        $this->_payer_first_name = isset($p_suscripcion['payer_first_name']) ? (string) $p_suscripcion['payer_first_name']:$this->_payer_first_name ;
        $this->_payer_last_name = isset($p_suscripcion['payer_last_name']) ? (string) $p_suscripcion['payer_last_name']:$this->_payer_last_name ;

    }

    public function getSuscripcionMercadoPago() {

        sleep(1);

        $access_token_suscripciones = "APP_USR-1659178055922851-080106-e68d9d6057977d7357a4517760162c5f-239560895";

        // TOKEN PARA SUSCRIPCIONES (MERCADO PAGO)
        //MercadoPago\SDK::setAccessToken(ACCESS_TOKEN_MERCADOPAGO_SUSCRIPCIONES);
        MercadoPago\SDK::setAccessToken($access_token_suscripciones);
        // VARIBALES
        $service_url        = 'https://api.mercadopago.com/preapproval/search?id='.$this->_preapproval_id;
        //$service_url        = 'https://api.mercadopago.com/preapproval/search?payer_email=julio.ganam@gmail.com';

        // CURL INIT
        $ch = curl_init($service_url);

        // CURL OPTIONS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Authorization: Bearer '.$access_token_suscripciones));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // CURL EXEC
        $curl_response      = curl_exec($ch);

        // PLANES
        $p_suscripcion           = json_decode($curl_response,true);

        // CURL CLOSE
        curl_close($ch);

        if (isset($p_suscripcion['results'][0])){
            return $p_suscripcion['results'][0];
        }

        if (isset($p_suscripcion['results'])){
            return $p_suscripcion['results'];
        }

        return $p_suscripcion;

    }

    public function getDetallePagoMercadoPago($p_payment_id = '') {

        //sleep(1);

        // VARIBALES
        $service_url            = 'https://api.mercadopago.com/v1/payments/'.$p_payment_id;
        $access_token_api       = "APP_USR-1762536926307627-081006-53a401c2c4ba7bc9c1744cf8141e0881-239560895";

        /*
         curl -G -X GET \
            -H "accept: application/json" \
            -H 'Authorization: Bearer ACCESS_TOKEN' \
            "https://api.mercadopago.com/v1/payments/<payment_id>" \
            -d "status=approved" \
            -d "offset=0" \
            -d "limit=10"`
         */
        // CURL INIT
        $ch = curl_init($service_url);

        // CURL OPTIONS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Authorization: Bearer '.$access_token_api));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // CURL EXEC
        $curl_response      = curl_exec($ch);

        // PLANES
        $p_response           = json_decode($curl_response,true);

        // CURL CLOSE
        curl_close($ch);

        printear('$service_url');
        printear($service_url);

        printear('$p_response');
        printear($p_response);



        return $p_response;

    }

    public function getDetallePagoMercadoPagoSearch() {

        //sleep(1);

        // VARIBALES
        $service_url            = 'https://api.mercadopago.com/v1/payments/search?payer.id='.$this->_payer_id;
        $access_token_api       = "APP_USR-1762536926307627-081006-53a401c2c4ba7bc9c1744cf8141e0881-239560895";

        // TOKEN PARA SUSCRIPCIONES (MERCADO PAGO)
        MercadoPago\SDK::setAccessToken($access_token_api);


        /*
         curl -G -X GET \
            -H "accept: application/json" \
            -H 'Authorization: Bearer ACCESS_TOKEN' \
            "https://api.mercadopago.com/v1/payments/<payment_id>" \
            -d "status=approved" \
            -d "offset=0" \
            -d "limit=10"`
         */
        // CURL INIT
        $ch = curl_init($service_url);

        // CURL OPTIONS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Authorization: Bearer '.$access_token_api));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // CURL EXEC
        $curl_response      = curl_exec($ch);

        // PLANES
        $p_response           = json_decode($curl_response,true);

        // CURL CLOSE
        curl_close($ch);

        if (isset($p_response['results']))
            $p_response = $p_response['results'];

        return $p_response;

    }

    /// //// /// ////// //// /// ////// //// /// ////// //// /// ////// //// /// ////// //// /// ////// //// /// /////

    public function get_status($p_idioma = 'AR') {

        $p_status = $this->_status;

        if ($p_idioma == ''){
            return $p_status;
        }

        if ($p_idioma == 'AR') {
            switch ($p_status) {
                case 'paused':
                    $p_status = 'Pausada';
                    break;
                case 'cancelled':
                    $p_status = 'Cancelada';
                    break;
                case 'authorized':
                    $p_status = 'Activa';
                    break;
                case 'undefined':
                    $p_status = 'Indefinido';
                    break;
                default:
                    break;
            }
        }
        return $p_status;
    }

    public function set_status($p_) {
        $p_ = (string) $p_;
        $this->_status = $p_;
    }

    public function get_reason() {
        return $this->_reason;
    }
    public function set_reason($p_) {
        $p_ =  (string) $p_;
        $this->_reason = $p_;
    }

    public function get_summarized_quotas() {
        return $this->_summarized_quotas;
    }
    public function set_summarized_quotas($p_) {
        $p_ =  (int) $p_;
        $this->_summarized_quotas = $p_;
    }

    public function get_summarized_semaphore() {
        return $this->_summarized_semaphore;
    }
    public function set_summarized_semaphore($p_) {
        $p_ =  (string) $p_;
        $this->_summarized_semaphore = $p_;
    }
    public function get_summarized_charged_quantity() {
        return $this->_summarized_charged_quantity;
    }

    public function set_summarized_charged_quantity($p_) {
        $p_ =  (int) $p_;
        $this->_summarized_charged_quantity = $p_;
    }
    public function get_summarized_pending_charge_quantity() {
        return $this->_summarized_pending_charge_quantity;
    }

    public function set_summarized_pending_charge_quantity($p_) {
        $p_ =  (int) $p_;
        $this->_summarized_pending_charge_quantity = $p_;
    }
    public function get_summarized_charged_amount() {
        return $this->_summarized_charged_amount;
    }

    public function set_summarized_charged_amount($p_) {
        $p_ =  (float) $p_;
        $this->_summarized_charged_amount = $p_;
    }
    public function get_summarized_pending_charge_amount() {
        return $this->_summarized_pending_charge_amount;
    }

    public function set_summarized_pending_charge_amount($p_) {
        $p_ =  (float) $p_;
        $this->_summarized_pending_charge_amount = $p_;
    }

    public function get_summarized_last_charged_date($p_format = 'Y-m-d H:i:s') {
        if ($this->_summarized_last_charged_date == ''){
            return '';
        }
        $_Date= date($p_format,strtotime($this->_summarized_last_charged_date));

        return $_Date;
    }
    public function set_summarized_last_charged_date($p_) {
        $p_ =  (string) $p_;
        $this->_summarized_last_charged_date = $p_;
    }

    public function get_summarized_last_charged_amount() {
        return $this->_summarized_last_charged_amount;
    }
    public function set_summarized_last_charged_amount($p_) {
        $p_ =  (float) $p_;
        $this->_summarized_last_charged_amount = $p_;
    }

    public function get_payer_id() {
        return $this->_payer_id;
    }
    public function set_payer_id($p_) {
        $p_ =  (string) $p_;
        $this->_payer_id = $p_;
    }

    public function get_payer_email() {
        return $this->_payer_email;
    }
    public function set_payer_email($p_) {
        $p_ =  (string) $p_;
        $this->_payer_email = $p_;
    }

    public function get_back_url() {
        return $this->_back_url;
    }
    public function set_back_url($p_) {
        $p_ =  (string) $p_;
        $this->_back_url = $p_;
    }

    public function get_collector_id() {
        return $this->_collector_id;
    }
    public function set_collector_id($p_) {
        $p_ =  (string) $p_;
        $this->_collector_id = $p_;
    }

    public function get_application_id() {
        return $this->_application_id;
    }
    public function set_application_id($p_) {
        $p_ =  (string) $p_;
        $this->_application_id = $p_;
    }

    public function get_external_reference() {
        return $this->_external_reference;
    }
    public function set_external_reference($p_) {
        $p_ =  (string) $p_;
        $this->_external_reference = $p_;
    }

    public function get_date_created($p_format = 'Y-m-d H:i:s') {

        if ($this->_date_created == ''){
            return '';
        }
        $_Date= date($p_format,strtotime($this->_date_created));

        return $_Date;


    }
    public function set_date_created($p_) {
        $p_ =  (string) $p_;
        $this->_date_created = $p_;
    }

    public function get_last_modified() {
        return $this->_last_modified;
    }

    public function set_last_modified($p_) {
        $p_ =  (string) $p_;
        $this->_last_modified = $p_;
    }
    public function get_init_point() {
        return $this->_init_point;
    }

    public function set_init_point($p_) {
        $p_ =  (string) $p_;
        $this->_init_point = $p_;
    }
    public function get_sandbox_init_point() {
        return $this->_sandbox_init_point;
    }

    public function set_sandbox_init_point($p_) {
        $p_ =  (string) $p_;
        $this->_sandbox_init_point = $p_;
    }
    public function get_preapproval_plan_id() {
        return $this->_preapproval_plan_id;
    }

    public function set_preapproval_plan_id($p_) {
        $p_ =  (string) $p_;
        $this->_preapproval_plan_id = $p_;
    }

    public function get_preapproval_id() {
        return $this->_preapproval_id;
    }

    public function set_preapproval_id($p_) {
        $p_ =  (string) $p_;
        $this->_preapproval_id = $p_;
    }


    public function get_auto_recurring_frequency() {
        return $this->_auto_recurring_frequency;
    }

    public function set_auto_recurring_frequency($p_) {
        $p_ =  (int) $p_;
        $this->_auto_recurring_frequency = $p_;
    }

    public function get_auto_recurring_frequency_type($p_idioma = 'AR'){

        $p_frecuencia = $this->_auto_recurring_frequency_type;

        if ($p_idioma == 'AR') {
            switch ($p_frecuencia) {

                case 'days':
                    $p_frecuencia = 'Día';
                    break;

                case 'months':
                    $p_frecuencia = 'Mes';
                    break;

                case 'years':
                    $p_frecuencia = 'Año';
                    break;
            }
        }

        return $p_frecuencia;

    }

    public function set_auto_recurring_frequency_type($p_) {
        $p_ =  (string) $p_;
        $this->_auto_recurring_frequency_type = $p_;
    }

    public function get_auto_recurring_transaction_amount() {
        return $this->_auto_recurring_transaction_amount;
    }
    public function set_auto_recurring_transaction_amount($p_) {
        $p_ =  (float) $p_;
        $this->_auto_recurring_transaction_amount = $p_;
    }


    public function get_auto_recurring_currency_id() {
        return $this->_auto_recurring_currency_id;
    }
    public function set_auto_recurring_currency_id($p_) {
        $p_ =  (string) $p_;
        $this->_auto_recurring_currency_id = $p_;
    }

    // AUTO RECURRING: START DATE
    public function get_auto_recurring_start_date($p_format = 'Y-m-d H:i:s') {

        if ($this->_auto_recurring_start_date == ''){
            return '';
        }
        $_Date= date($p_format,strtotime($this->_auto_recurring_start_date));

        return $_Date;
    }
    public function set_auto_recurring_start_date($p_) {
        $p_ =  (string) $p_;
        $this->_auto_recurring_start_date = $p_;
    }

    // AUTO RECURRING: END DATE
    public function get_auto_recurring_end_date($p_format = 'Y-m-d H:i:s') {

        if ($this->_auto_recurring_end_date == ''){
            return '';
        }
        $_Date= date($p_format,strtotime($this->_auto_recurring_end_date));

        return $_Date;
    }
    public function set_auto_recurring_end_date($p_) {
        $p_ =  (string) $p_;
        $this->_auto_recurring_end_date = $p_;
    }

    // NEXT PAYMENT DATE
    public function get_next_payment_date($p_format = 'Y-m-d H:i:s') {

        if ($this->_next_payment_date == ''){
            return '';
        }
        $_Date= date($p_format,strtotime($this->_next_payment_date));

        return $_Date;
    }
    public function set_next_payment_date($p_) {
        $p_ =  (string) $p_;
        $this->_next_payment_date = $p_;
    }

    // PAYMENT METHOD ID
    public function get_payment_method_id($p_language = '') {

        $p_medio_de_pago = $this->_payment_method_id;

        if ($p_language == 'AR')
            switch ($p_medio_de_pago){
                case 'debvisa':
                    $p_medio_de_pago = 'Visa Débito';
                    break;
                case 'visa':
                    $p_medio_de_pago = 'Visa Crédito';
                    break;
                case 'debmastercard':
                    $p_medio_de_pago = 'Mastercard Débito';
                    break;
                case 'mastercard':
                    $p_medio_de_pago = 'Mastercard Crédito';
                    break;
            }

        return $p_medio_de_pago;

    }
    public function set_payment_method_id($p_) {
        $p_ =  (string) $p_;
        $this->_payment_method_id = $p_;
    }

    // FIRST NAME
    public function get_payer_first_name() {
        return $this->_payer_first_name;
    }
    public function set_payer_first_name($p_) {
        $p_ =  (string) $p_;
        $this->_payer_first_name = $p_;
    }

    // LAST NAME
    public function get_payer_last_name() {
        return $this->_payer_last_name;
    }
    public function set_payer_last_name($p_) {
        $p_ =  (string) $p_;
        $this->_payer_last_name = $p_;
    }

    // CARD_TOKEN_ID
    public function get_card_token_id() {
        return $this->_card_token_id;
    }
    public function set_card_token_id($p_) {
        $p_ =  (string) $p_;
        $this->_card_token_id = $p_;
    }


    // FACTURA CAE
    public function get_factura_CAE() {
        return $this->_factura_CAE;
    }
    public function set_factura_CAE($p_) {
        $p_ =  (string) $p_;
        $this->_factura_CAE = $p_;
    }

    // FACTURA URL
    public function get_factura_URL() {
        return $this->_factura_URL;
    }
    public function set_factura_URL($p_) {
        $p_ =  (string) $p_;
        $this->_factura_URL = $p_;
    }


    /////////
    public function get_precio($p_number_format = 2 ) {
        $p_precio =
            number_format($this->_auto_recurring_transaction_amount, $p_number_format) .
            ' ['
            . $this->_auto_recurring_currency_id
            . ']'
            . ' x '
            . $this->get_auto_recurring_frequency_type();
        return  $p_precio;
    }

    public function show_attribute($p_attr){

        $p_mostrar_dato['status']	 =	 true	;
        $p_mostrar_dato['reason']	 =	 true	;
        $p_mostrar_dato['summarized']['quotas']	 =	 false	;
        $p_mostrar_dato['summarized']['semaphore']	 =	 false	;
        $p_mostrar_dato['summarized']['charged_quantity']	 =	 false	;
        $p_mostrar_dato['summarized']['pending_charge_quantity']	 =	 false	;
        $p_mostrar_dato['summarized']['charged_amount']	 =	 false	;
        $p_mostrar_dato['summarized']['pending_charge_amount']	 =	 false	;
        $p_mostrar_dato['summarized']['last_charged_date']	 =	 true	;
        $p_mostrar_dato['summarized']['last_charged_amount']	 =	 true	;
        $p_mostrar_dato['payer_id']	 =	 false	;
        $p_mostrar_dato['payer_email']	 =	 true	;
        $p_mostrar_dato['back_url']	 =	 false	;
        $p_mostrar_dato['collector_id']	 =	 false	;
        $p_mostrar_dato['application_id']	 =	 false	;
        $p_mostrar_dato['external_reference']	 =	 false	;
        $p_mostrar_dato['date_created']	 =	 false	;
        $p_mostrar_dato['last_modified']	 =	 false	;
        $p_mostrar_dato['init_point']	 =	 false	;
        $p_mostrar_dato['sandbox_init_point']	 =	 false	;
        $p_mostrar_dato['preapproval_plan_id']	 =	 false	;
        $p_mostrar_dato['auto_recurring']['frequency']	 =	 false	;
        $p_mostrar_dato['auto_recurring']['frequency_type']	 =	 true	;
        $p_mostrar_dato['auto_recurring']['transaction_amount']	 =	 true	;
        $p_mostrar_dato['auto_recurring']['currency_id']	 =	 true	;
        $p_mostrar_dato['auto_recurring']['start_date']	 =	 true	;
        $p_mostrar_dato['auto_recurring']['end_date']	 =	 true	;
        $p_mostrar_dato['next_payment_date']	 =	 true	;
        $p_mostrar_dato['payment_method_id']	 =	 true	;
        $p_mostrar_dato['payer_first_name']	 =	 true	;
        $p_mostrar_dato['payer_last_name']	 =	 true	;

        $result = isset($p_mostrar_dato[$p_attr]) ? $p_mostrar_dato[$p_attr] : null;

        return  $result;

    }

    public function delete($p_Debug = 1){
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConnMGR;

        if ($this->_id == 0) {
            return false;
        }

        $resultado = $cnn->Delete('suscripciones', "susc_Id = " . $this->_id);

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
            return false;
        }
        return true;
    }


}
