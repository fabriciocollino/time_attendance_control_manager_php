<?php


$T_Titulo = _('Transacciones');
$T_Script = 'transacciones';
$Item_Name = "transacciones";
$T_Link = ''; 
$T_Mensaje = '';

$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';

switch ($T_Tipo) {

    default:

        $o_Listado = Transaccion_L::obtenerTodosArray();

}
