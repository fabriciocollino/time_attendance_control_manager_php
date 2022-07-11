<?php


$T_Titulo = _('SQL');
$T_Script = 'sql';
$Item_Name = "sql";
$T_Link = '';
$T_Mensaje = '';
 
$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Query = (isset($_REQUEST['sqlquery'])) ? $_REQUEST['sqlquery'] : '';

SeguridadHelper::Pasar(90);   //a este controller no accede nadie, excepto los admins

//die(printear($_REQUEST));

switch ($T_Tipo) {
    case 'run':

        $databases = array();

        $a_Clientes = Cliente_L::obtenerTodosEnabled();
        if (!is_null($a_Clientes)) {

            foreach ($a_Clientes as $o_Cliente) {
                $databases[]= $o_Cliente->getDBname();
            }

            echo "<pre>";

            echo "running query ".$T_Query."</br>";

            echo "on databases:";

            print_r($databases);

            echo "</pre>";

            echo "<pre>";

            foreach ($a_Clientes as $o_Cliente) {
                /* @var $o_Cliente Cliente_O */

                $subdominio = $o_Cliente->getSubdominio();

                if($subdominio=="dev")
                    continue;

                $o_Suscripcion = Suscripcion_L::obtenerPorId($o_Cliente->getSuscripcion());
                $o_Plan = Planes_L::obtenerPorId($o_Suscripcion->getPlan());
                $G_DbConn1 = new mySQL(
                    $o_Cliente->getDBname(),
                    $o_Cliente->getDBuser(),
                    $o_Cliente->getDBpass(),
                    $o_Cliente->getDBhost(),
                    $o_Cliente->getDBport()
                );


                if (!$G_DbConn1->ConectarSocket()) {
                    die($G_DbConnMGR->get_Error($Registry->general['debug']));
                }

                Registry::getInstance()->DbConn = $G_DbConn1;

                echo $o_Cliente->getDBname()."<br>";

                print_r($G_DbConn1->QueryWResult($T_Query));

                echo "<br>";

            }


            echo "</pre>";



        }


        break;

    default:
        defaultlabel:

        
        
        $T_Link = '';
        break;
}
