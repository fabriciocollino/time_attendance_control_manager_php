<?php
require_once dirname(__FILE__) . '/../../_ruta.php';

$o_Cliente = Cliente_L::obtenerPorSubdominio('intersys');

$G_DbConn1 = new mySQL(
    $o_Cliente->getDBname(),
    $o_Cliente->getDBuser(),
    $o_Cliente->getDBpass(),
    $o_Cliente->getDBhost(),
    $o_Cliente->getDBport()
);



if (!$G_DbConn1->ConectarSocket()) {
    //printear("sin conexion");
    die();
}

Registry::getInstance()->DbConn = $G_DbConn1;

$a_personas = Persona_L::obtenerTodosArray();
$a_huellas = Huella_L::obtenerTodosArray();

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


printear($string_personas);
printear($string_huellas);