<?php require_once dirname(__FILE__) . '/../../_ruta.php';

// VARIABLES
$T_Tipo             = isset($_REQUEST['tipo'])         ?   $_REQUEST['tipo']          :   "";
$T_Id               = isset($_REQUEST['id'])           ?   $_REQUEST['id']            :   "";
$o_Suscripcion      = null;
$o_Listado          = array();
$T_Suscripciones    = array();
$T_Mensaje          = '';

printear('$_POST');
printear($_REQUEST);
switch ($T_Tipo) {

    case 'view':

        printear("entro a VIEW");


        $o_Suscripcion = Suscripcion_L::obtenerPorId($T_Id);
        if (is_null($o_Suscripcion)) {
            $o_Suscripcion = new Suscripcion_O();
        }

        $T_Planes = Planes_L::obtenerTodosArray();
        $T_Clientes = Cliente_L::obtenerTodosArray();

        break;

    case 'add':
        printear("entro a ADD");

        // NEW SUSCRIPCION
        $o_Suscripcion      = new Suscripcion_O();

        // VARIABLES
        $susc_Plan_Id                   = isset($_REQUEST['susc_Plan_Id'])          ?   $_REQUEST['susc_Plan_Id']           :   '';

        $susc_Cliente_Id                = isset($_REQUEST['susc_Cliente_Id'])       ?   $_REQUEST['susc_Cliente_Id']        :   '';
        $susc_Fecha_Desde               = isset($_REQUEST['susc_Fecha_Desde'])      ?   $_REQUEST['susc_Fecha_Desde']       :   date('Y-m-d H:i:s', strtotime('today 00:00:00'));

        // OBJETOS
        $o_Plan                         = Planes_L::obtenerPorId($susc_Plan_Id);
        $o_Cliente                      = Cliente_L::obtenerPorId($susc_Cliente_Id);
        $o_Plan_Modulos_Permisos        = Modulos_Permisos_L::obtenerPorId($o_Plan->get_Modulos_Permisos_Id());
        $o_Suscripcion_Modulos_Permisos = new Modulos_Permisos_O();



        // VARIABLES
        $susc_status                                = 'authorized';
        $susc_reason                                = $o_Plan->getNombre();

        $susc_auto_recurring_frequency              = 1;
        $susc_auto_recurring_frequency_type         = $o_Plan->getFrecuencia();
        $susc_auto_recurring_transaction_amount     = $o_Plan->getMonto();
        $susc_susc_auto_recurring_currency_id       = $o_Plan->getTipoMoneda();
        $susc_auto_recurring_start_date             = date('Y-m-d H:i:s', strtotime($susc_Fecha_Desde));

        $susc_date_created                          = date('Y-m-d H:i:s');
        $susc_last_modified                         = date('Y-m-d H:i:s');
        $susc_next_payment_date                     = '';
        $susc_payment_method_id                     = 'free';

        $susc_payer_first_name                      = $o_Cliente->getNombre();
        $susc_payer_last_name                       = $o_Cliente->getApellido();
        $susc_payer_email                           = $o_Cliente->getEmail();

        // SET VARIABLES
        $o_Suscripcion->setPlan($susc_Plan_Id);
        $o_Suscripcion->setCliente($susc_Cliente_Id);
        $o_Suscripcion->set_status($susc_status);
        $o_Suscripcion->set_reason($susc_reason);

        $o_Suscripcion->set_auto_recurring_frequency($susc_auto_recurring_frequency);
        $o_Suscripcion->set_auto_recurring_frequency_type($susc_auto_recurring_frequency_type);
        $o_Suscripcion->set_auto_recurring_transaction_amount($susc_auto_recurring_transaction_amount);
        $o_Suscripcion->set_auto_recurring_currency_id($susc_susc_auto_recurring_currency_id);
        $o_Suscripcion->set_auto_recurring_start_date($susc_auto_recurring_start_date);

        $o_Suscripcion->set_date_created($susc_date_created);
        $o_Suscripcion->set_last_modified($susc_last_modified);
        $o_Suscripcion->set_next_payment_date($susc_next_payment_date);
        $o_Suscripcion->set_payment_method_id($susc_payment_method_id);

        $o_Suscripcion->set_payer_first_name($susc_payer_first_name);
        $o_Suscripcion->set_payer_last_name($susc_payer_last_name);
        $o_Suscripcion->set_payer_email($susc_payer_email);

        printear('$o_Suscripcion');
        printear($o_Suscripcion);

        // CREAR NUEVO MODULOS_PERMISOS
        $o_Suscripcion_Modulos_Permisos->loadArray($o_Plan_Modulos_Permisos->getArray());
        if ($o_Suscripcion_Modulos_Permisos->save()){
            $o_Suscripcion->set_Modulos_Permisos_Id($o_Suscripcion_Modulos_Permisos->get_mod_id());

            // SAVE SUSCRIPCION
            if ($o_Suscripcion->save()) {
                $T_Mensaje = "Suscripcion creada exitosamente";
            }
            else{
                $T_Error = json_encode($o_Suscripcion->getErrores());
            }
        }
        else{
            $T_Error = json_encode($o_Suscripcion->getErrores());
        }



        $T_Suscripciones    = Suscripcion_L::obtenerTodos();

        break;

    case 'edit':

        $o_Plan = Planes_L::obtenerPorId($T_Id);

        if (is_null($o_Plan)) {
            return;
        }


        if ($o_Plan->save()){
            $T_Mensaje = "Plan editado exitosamente";
        }
        else{
            $T_Error = json_encode($o_Plan->getErrores());
        }

        $o_Listado = Planes_L::obtenerTodosArray();




        break;

    case 'delete':

        $o_Suscripcion = Suscripcion_L::obtenerPorId($T_Id);

        if ($o_Suscripcion->delete()){
            $T_Mensaje = "Plan eliminado exitosamente";
        }
        else{
            $T_Error = json_encode($o_Plan->getErrores());
        }
        $o_Listado = Planes_L::obtenerTodosArray();

        break;

    case "editar_status_suscripcion":

        $status                     = isset($_POST['status'])               ?   $_POST['status']                :   "";
        $preapproval_id             = isset($_POST['preapproval_id'])       ?   $_POST['preapproval_id']        :   "";
        $application_id             = isset($_POST['application_id'])       ?   $_POST['application_id']        :   "";
        $access_token_suscripciones = "APP_USR-1659178055922851-080106-e68d9d6057977d7357a4517760162c5f-239560895";

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

        // STATUS 400: ERROR API
        if($response['status'] == 400){
            $T_Error        = _('Lo sentimos, hubo un error en la operación. (Error 400)');
            break;
        }

        // GET SUSCRIPTION
        $o_Suscripcion  = Suscripcion_L::obtenerPorIdMercadoPago($preapproval_id);

        // UPDATE SUSCRIPTION
        $o_Suscripcion->loadArrayMercadoPago($response);

        // SAVE SUSCRIPTION
        if ($o_Suscripcion->save())
            $T_Mensaje      = _('Suscripción actualizada correctamente.');
        else
            $T_Error        = _('Lo sentimos, hubo un error en la operación.');


        break;

    case "getDetallePagoMercadoPago":

        $preapproval_id             = isset($_POST['preapproval_id'])       ?   $_POST['preapproval_id']        :   "";

        // GET SUSCRIPTION OBJECT
        $o_Suscripcion              = Suscripcion_L::obtenerPorIdMercadoPago($preapproval_id);

        // printear con payer id
        $o_Listado = $o_Suscripcion->getDetallePagoMercadoPagoSearch();


        break;

    default:
        // GET CLIENT SUSCRIPTIONS
        $T_Suscripciones    = Suscripcion_L::obtenerTodos();
        break;

}


