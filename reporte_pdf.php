<?php
require_once(dirname(__FILE__) . '/_ruta.php');

SeguridadHelper::Pasar(50);

require_once(APP_PATH . '/libs/pdf/reportes.php');

$dias[3]=iconv('UTF-8', 'windows-1252', $dias[3]);//para el acento del miercoles
$dias[6]=iconv('UTF-8', 'windows-1252', $dias[6]);//para el acento del sabado

$T_Tipo = isset($_REQUEST['tipo']) ? (integer) $_REQUEST['tipo'] : 0;
$T_Persona = isset($_REQUEST['persona']) ? (integer) $_REQUEST['persona'] : 0;
$T_Zona = isset($_REQUEST['zona']) ? (integer) $_REQUEST['zona'] : 0;
$T_Equipo = isset($_REQUEST['equipo']) ? (integer) $_REQUEST['equipo'] : 0;
$T_Dispositivo = isset($_REQUEST['dispositivo']) ? (integer) $_REQUEST['dispositivo'] : 0;
$T_Intervalo = isset($_REQUEST['intervalo']) ? (integer) $_REQUEST['intervalo'] : 0;
$T_Save = isset($_REQUEST['guardar']) ? (integer) $_REQUEST['guardar'] : 0;
$T_Filename = isset($_REQUEST['nombre']) ? (string) $_REQUEST['nombre'] : '';
$T_Imprimir = isset($_REQUEST['imprimir']) ? (integer) $_REQUEST['imprimir'] : 0;
$T_Grupo = isset($_REQUEST['grupo']) ? (integer) $_REQUEST['grupo'] : 0;



//http://localhost/reporte_pdf.php?tipo=11&zona=4&intervalo=30
//http://localhost/reporte_pdf.php?tipo=11&zona=4&intervalo=30&guardar=1&nombre=attachment.pdf
//http://localhost/reporte_pdf.php?tipo=11&zona=4&intervalo=30&imprimir=1
//http://localhost/reporte_pdf.php?tipo=11&zona=2&intervalo=30
//http://localhost/reporte_pdf.php?tipo=12&equipo=1&intervalo=30
//http://localhost/reporte_pdf.php?tipo=14&dispositivo=1&intervalo=30
//http://localhost/reporte_pdf.php?tipo=15&dispositivo=1&persona=1&intervalo=30
//http://localhost/reporte_pdf.php?tipo=16&intervalo=30

GenerarReporte($T_Tipo,$T_Intervalo,$T_Save,$T_Filename,$T_Persona,$T_Zona,$T_Equipo,$T_Dispositivo,$T_Grupo,$T_Imprimir,$dias,$meses,$a_Logs_Accion);

die();

?>

