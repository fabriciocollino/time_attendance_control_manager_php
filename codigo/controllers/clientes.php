<?php

require_once dirname(__FILE__) . '/../../_ruta.php';


$T_Titulo = _('Clientes');
$Item_Name = "cliente";
$T_Titulo_Singular = "cliente";
$T_Titulo_Pre = "un";
$T_Script = 'cliente';
$T_Mensaje = '';


$T_Tipo                 =       isset($_REQUEST['tipo'])            ?         $_REQUEST['tipo']                     :       '';
$T_Lista_Ids            =       isset($_REQUEST['lista_ids'])       ?         json_decode($_REQUEST['lista_ids'])   :       array();


switch ($T_Tipo) {
    case 'delete_lista':

        printear('$T_Lista_Ids');
        printear($T_Lista_Ids);

        if (empty($T_Lista_Ids)){
            printear('$T_Lista_Ids');
            printear($T_Lista_Ids);
        }

        $resultado = array();

        foreach($T_Lista_Ids as $_Id){

            $o_Cliente          = Cliente_L::obtenerPorId($_Id);
            $deletion_result    = $o_Cliente->delete_db();
            $deletion_errores   = $o_Cliente->getErrores();

            $resultado[] = array(
                'id'        => $_Id,
                'status'    => $deletion_result,
                'errors'    => $deletion_errores
            );
        }
        echo json_encode($resultado);

        $o_Listado = Cliente_L::obtenerTodosArray();

        break;

    default:

        $o_Listado = Cliente_L::obtenerTodosArray();

        foreach ($o_Listado as $_cli_Id => $_cli){

            $_Cliente = Cliente_L::obtenerPorId($_cli_Id);

        }
        break;

}

