<?php


$T_Titulo = _('subir logs');
$T_Script = 'subir_logs';
$Item_Name = "subir_log";
$T_Link = '';
$T_Mensaje = '';
 
$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : 'logs';
$T_Logs = (isset($_REQUEST['devicelogs'])) ? $_REQUEST['devicelogs'] : '';
$T_SubDominio = (isset($_REQUEST['subdom'])) ? $_REQUEST['subdom'] : '';
$T_eqUUID = (isset($_REQUEST['equuid'])) ? $_REQUEST['equuid'] : '';


switch ($T_Tipo) {

    case 'logs':

        $o_Cliente = Cliente_L::obtenerPorSubdominio($T_SubDominio);

        $G_DbConn1 = new mySQL(
            $o_Cliente->getDBname(),
            $o_Cliente->getDBuser(),
            $o_Cliente->getDBpass(),
            $o_Cliente->getDBhost(),
            $o_Cliente->getDBport()
        );



        if (!$G_DbConn1->ConectarSocket()) {
            printear("error al conectar");
            printear('$T_Logs');
            printear($T_Logs);

            $data = json_decode($T_Logs,true);

            printear('$data');
            printear($data);


           break;
        }

        Registry::getInstance()->DbConn = $G_DbConn1;



        echo $o_Cliente->getDBname()."<br>";

        $data = json_decode($T_Logs,true);




        foreach ($data as $log) {
            $o_Equipo = Equipo_L::obtenerPorUUID($T_eqUUID);
            if (isset($o_Equipo)) {

                printear("INICIO LOGS ELIMINADOS");

                $_fechita           = date('Y-m-d H:i:s', $log['fecha']);

                $a_logCP = Logs_Equipo_L::obtenerPorPersonaPorFechaPorEquipo($log['persona'],$_fechita, $o_Equipo->getId());
                if ($a_logCP != null) {

                    foreach ($a_logCP as $a_l){
                        printear($a_l);
                        printear("eliminandodo log". $a_l->getId());
                        if ($a_l->delete()){
                            printear("Eliminado correctamente");
                        }
                        else{
                            printear("Error al eliminar");
                        }
                    }
                }


                printear(" // /// /// /// /// /// // // /// /// /// /// /// //  FIN LOGS ELIMINADOS ");

                $_fechita_nueva     = date('Y-m-d H:i:s', $log['fecha'] - 10800);

                $a_logCP = Logs_Equipo_L::obtenerPorPersonaPorFechaPorEquipo($log['persona'],$_fechita_nueva, $o_Equipo->getId());

                if ($a_logCP != null) continue;


                printear("INICIO NUEVO LOG");
                $o_log = new Logs_Equipo_O($o_Equipo->getId());
                $o_log->setPerId($log['persona']);
                $o_log->setLector($log['lector']);
                $o_log->setFechaHora($_fechita_nueva, 'Y-m-d H:i:s');
                $o_log->setAccion($log['accion']);

                printear($o_log);

                if ($o_log->save()) {
                    $resultado[] = array('id' => $log['log_id'], 'status' => 'OK');
                    printear("Creado correctamente");
                } else {
                    printear("Error al crear");
                    $resultado[] = array('id' => $log['log_id'], 'status' => 'ERROR');
                }

                printear(" // /// /// /// /// /// // // /// /// /// /// /// //  FIN LOGS NUEVOS ");

            }


        }

        break;

    case 'huellas':

        $o_Cliente = Cliente_L::obtenerPorSubdominio($T_SubDominio);

        $G_DbConn1 = new mySQL(
            $o_Cliente->getDBname(),
            $o_Cliente->getDBuser(),
            $o_Cliente->getDBpass(),
            $o_Cliente->getDBhost(),
            $o_Cliente->getDBport()
        );



        if (!$G_DbConn1->ConectarSocket()) {
            printear("error al conectar");
            printear('$T_Logs');
            printear($T_Logs);

            $data = json_decode($T_Logs,true);

            printear('$data');
            printear($data);


            break;
        }

        Registry::getInstance()->DbConn = $G_DbConn1;

        $a_personas = Persona_L::obtenerTodos();
        $a_huellas = Huella_L::obtenerTodos();

        $a_personas_json = json_encode($a_personas);
        $a_huellas_json  = json_encode($a_huellas);



        $string_personas = '
            const a_personas_json;
            a_personas_json = [];
            sync(a_personas_json, "TYPE_PERSON", "api", "", function () {},false);
            ';

                    $string_huellas = '
            const a_huellas_json;
            a_huellas_json = [];
            sync(a_huellas_json, "TYPE_FINGERPRINT", "api", "", function () {},false);
            ';


                    printear($a_personas_json);
                    printear($a_huellas_json);

        break;

    default:
        defaultlabel:

        
        
        $T_Link = '';
        break;
}

