<?php
require_once dirname(__FILE__) . '/../../_ruta.php';


$T_Titulo       = _('Modulos y Permisos');
$T_Titulo_Singular = _('Modulo');
$T_Script       = 'modulo';
$Item_Name      = "modulo";
$T_Link         = '';
$T_Mensaje      = '';


$T_Tipo                 = isset($_REQUEST['tipo'])                  ?   $_REQUEST['tipo']               :   "";
$T_Id                   = isset($_REQUEST['mod_id'])                ?   $_REQUEST['mod_id']             :   "";
$T_Plan_Id              = isset($_REQUEST['plan_id'])               ?   $_REQUEST['plan_id']            :   "";

$T_mod_persona_crear    = isset($_REQUEST['mod_persona_crear'])     ?  filter_var( $_REQUEST['mod_persona_crear'], FILTER_VALIDATE_BOOLEAN )            :   "nul no hay";
$T_mod_persona_editar   = isset($_REQUEST['mod_persona_editar'])    ? filter_var( $_REQUEST['mod_persona_crear'], FILTER_VALIDATE_BOOLEAN )           :   "nul no hay";


$o_Modulos_Permisos = null;

//printear('$T_Id');
//printear($T_Id);
//printear('$_REQUEST');
//printear($_REQUEST);

//printear('$T_mod_persona_crear');
//printear($T_mod_persona_crear);
//printear('$T_mod_persona_editar');
//printear($T_mod_persona_editar);

switch ($T_Tipo) {

    case 'view':

        printear("entro a view");

        // MODULOS PERMISOS NO EXISTE
        if ($T_Id == "") {
            //printear("entro a NULL o VACIO");
            $o_Modulos_Permisos = new Modulos_Permisos_O();

            if ($o_Modulos_Permisos->save()){
                //printear("entro a saving new modulos permisos");
                $T_Id       = $o_Modulos_Permisos->get_mod_id();
                $o_Plan         = Planes_L::obtenerPorId($T_Plan_Id);

                if (!is_null($o_Plan)) {
                    $o_Plan->set_Modulos_Permisos_Id($T_Id);
                    $o_Plan->save();
                }
                else{
                    //printear(" NULL");
                }
            }
        }
        else {
            //printear("entro a NOT NULL");
            $o_Modulos_Permisos = Modulos_Permisos_L::obtenerPorId($T_Id);
        }


        break;

    case 'edit':
            //printear("entro a editar");

        $o_Modulos_Permisos = Modulos_Permisos_L::obtenerPorId($T_Id);

        if (is_null($o_Modulos_Permisos)) {
            //printear("no se encontro el modulo_permisos t id");
            break;
        }

        $o_Modulos_Permisos->loadArray($_REQUEST);

        if ($o_Modulos_Permisos->save()){
            $T_Mensaje = "Plan editado exitosamente";
        }
        else{
            $T_Error = json_encode($o_Modulos_Permisos->getErrores());
        }

        //printear($o_Modulos_Permisos);


        break;

    default:

        $o_Listado = Modulos_Permisos_L::obtenerTodosArray();

        break;
}
