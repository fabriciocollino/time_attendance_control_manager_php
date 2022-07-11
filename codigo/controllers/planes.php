<?php

require_once dirname(__FILE__) . '/../../_ruta.php';

$T_Titulo       = _('Planes');
$T_Titulo_Singular = _('Plan');
$T_Script       = 'plan';
$Item_Name      = "plan";
$T_Link         = '';
$T_Mensaje      = '';

$T_Tipo                 = isset($_REQUEST['tipo'])                  ?   $_REQUEST['tipo']                   :   '';

$T_Id                   = isset($_REQUEST['id'])                    ?   (integer)$_REQUEST['id']            :   0;
$T_Nombre               = isset($_REQUEST['nombre'])                ?   $_REQUEST['nombre']                 :   '';
$T_Descripcion          = isset($_REQUEST['descripcion'])           ?   $_REQUEST['descripcion']            :   '';
$T_Caracteristicas      = isset($_REQUEST['caracteristicas'])       ?   $_REQUEST['caracteristicas']        :   '';
$T_Back_Url             = isset($_REQUEST['back_url'])              ?   $_REQUEST['back_url']               :   'https://www.mercadolibre.com.ar/';
$T_Activo               = isset($_REQUEST['activo'])                ?   $_REQUEST['activo']                 :   1;


$T_Tipo_Frecuencia                      = isset($_REQUEST['tipo_frecuencia'])                       ?   $_REQUEST['tipo_frecuencia']                    :   'months';
$T_Frecuencia                           = isset($_REQUEST['frecuencia'])                            ?   $_REQUEST['frecuencia']                         :   '1';
$T_Monto                                = isset($_REQUEST['monto'])                                 ?   $_REQUEST['monto']                              :   '100';
$T_Tipo_Moneda                          = isset($_REQUEST['tipo_moneda'])                           ?   $_REQUEST['tipo_moneda']                        :   'ARS';
$T_Repeticiones                         = isset($_REQUEST['repeticiones'])                          ?   $_REQUEST['repeticiones']                       :   0;
$T_Prueba_Gratuita                      = isset($_REQUEST['prueba_gratuita'])                       ?   $_REQUEST['prueba_gratuita']                    :   'No';

$T_MercadoPago_Plan_Id                  = isset($_REQUEST['mercadopago_plan_id'])                   ?   $_REQUEST['mercadopago_plan_id']                :   '';
$T_Modulos_Permisos_Id                  = isset($_REQUEST['modulos_permisos_id'])                   ?   $_REQUEST['modulos_permisos_id']                :   0;


$o_Plan = null;


switch ($T_Tipo) {

    case 'add':

        $o_Plan = new Planes_O();

        $o_Plan->setNombre($T_Nombre);
        $o_Plan->setDescripcion($T_Descripcion);
        $o_Plan->setCaracteristicas($T_Caracteristicas);
        $o_Plan->setBackUrl($T_Back_Url);
        $o_Plan->setActivo($T_Activo);
        $o_Plan->setTipoFrecuencia($T_Tipo_Frecuencia);
        $o_Plan->setFrecuencia($T_Frecuencia);
        $o_Plan->setMonto($T_Monto);
        $o_Plan->setTipoMoneda($T_Tipo_Moneda);
        $o_Plan->setRepeticiones($T_Repeticiones);
        $o_Plan->setPruebaGratuita($T_Prueba_Gratuita);
        $o_Plan->CrearPlanMercadoPago();

        if (!$o_Plan->esValido()){
            $T_Error = json_encode($o_Plan->getErrores());
            $o_Listado = Planes_L::obtenerTodosArray();
            break;
        }
        // GUARDAR MODULOS PERMISOS
        $o_Modulos_Permisos = new Modulos_Permisos_O();
        if ($o_Modulos_Permisos->save()) {
            printear("exito al guardar modulos permisos");
            $_id    = $o_Modulos_Permisos->get_mod_id();
            $o_Plan->set_Modulos_Permisos_Id($_id);

            printear('$o_Plan');
            printear($o_Plan);
        }
        else {
            $T_Error = json_encode($o_Modulos_Permisos->getErrores());
            $o_Listado = Planes_L::obtenerTodosArray();
            printear("error al guardar modulos permisos");
        }



        // GUARDAR PLAN
        if ($o_Plan->save()) {
            $T_Mensaje = "Plan creado exitosamente";
        }
        else{
            $T_Error = json_encode($o_Plan->getErrores());
        }

        $o_Listado = Planes_L::obtenerTodosArray();
        break;

    case 'edit':

        $o_Plan = Planes_L::obtenerPorId($T_Id);

        if (is_null($o_Plan)) {
            return;
        }

        $o_Plan->setNombre($T_Nombre);
        $o_Plan->setDescripcion($T_Descripcion);
        $o_Plan->setCaracteristicas($T_Caracteristicas);
        $o_Plan->setBackUrl($T_Back_Url);
        $o_Plan->setActivo($T_Activo);

        // $o_Plan->setMercadopagoPlanId($T_MercadoPago_Plan_Id);
        $o_Plan->setTipoFrecuencia($T_Tipo_Frecuencia);
        $o_Plan->setFrecuencia($T_Frecuencia);
        $o_Plan->setMonto($T_Monto);
        $o_Plan->setTipoMoneda($T_Tipo_Moneda);
        $o_Plan->setRepeticiones($T_Repeticiones);
        $o_Plan->setPruebaGratuita($T_Prueba_Gratuita);
        $o_Plan->UpdatePlanMercadoPago();


        if (!$o_Plan->esValido()){
            $T_Error = json_encode($o_Plan->getErrores());
            $o_Listado = Planes_L::obtenerTodosArray();
            break;
        }

        // MODULOS PERMISOS
        if($T_Modulos_Permisos_Id == 0){

            // GUARDAR MODULOS PERMISOS
            $o_Modulos_Permisos = new Modulos_Permisos_O();
            if ($o_Modulos_Permisos->save()) {
                printear("exito al guardar modulos permisos");
                $_id    = $o_Modulos_Permisos->get_mod_id();
                $o_Plan->set_Modulos_Permisos_Id($_id);
            }
            else{
                printear("error al guardar modulos permisos");
                $T_Error = json_encode($o_Modulos_Permisos->getErrores());
                $o_Listado = Planes_L::obtenerTodosArray();
                break;
            }
        }
        else{
            // SET MODULOS PERMISOS
            printear("SET MODULOS PERMISOS: ya existe");
            $o_Plan->set_Modulos_Permisos_Id($T_Modulos_Permisos_Id);
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

        $o_Plan = Planes_L::obtenerPorId($T_Id);

        if ($o_Plan->delete()){
            $T_Mensaje = "Plan eliminado exitosamente";
        }
        else{
            $T_Error = json_encode($o_Plan->getErrores());
        }
        $o_Listado = Planes_L::obtenerTodosArray();

        break;

    case 'view':

        printear("entro a view");
        $o_Plan = Planes_L::obtenerPorId($T_Id);

        if (is_null($o_Plan)) {
            $o_Plan = new Planes_O();
        }

        break;

    default:

        $o_Listado = Planes_L::obtenerTodosArray();

        printear('$o_Listado');
        printear($o_Listado);
        break;

}
