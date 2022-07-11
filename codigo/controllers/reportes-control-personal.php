<?php

$T_Titulo = _('Control de Personal');
$Item_Name = 'reportes';

$T_Mensaje = '';
$T_Paginado = 'No';

//para los reportes
$Botones_Exportar=true;
$Reporte_Tipo='';
$Reporte_Nombre='';
//$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';  la variable T_Tipo es global, viene de los templates
if(!isset($T_Tipo))$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$template = $T_Template = (isset($_REQUEST['template'])) ? $_REQUEST['template'] : '';

if($template=='')$template='compacto';

$_SESSION['filtro']['csv'] = '';
$_SESSION['filtro']['pdf'] = array();

/*

if (isset($_POST['btnFiltro']) || isset($_GET['page']) || isset($_SESSION['filtro']['fechaH'])) {
	//para que la fecha no se panga en 0
} else {
	$_SESSION['filtro']['fechaD'] = date('Y-m-d H:i:s', strtotime('-7 day'));
	$_SESSION['filtro']['fechaH'] = date('Y-m-d H:i:s');
}

 */

if(!isset($_SESSION['filtro']['fechaD']))$_SESSION['filtro']['fechaD']='';
if(!isset($_SESSION['filtro']['fechaH']))$_SESSION['filtro']['fechaH']='';
 
if (isset($_GET['id'])) { // valor de los enlaces del encabezado de las tablas
	$_SESSION['filtro']['persona'] = $_GET['id'];
}
if (isset($_GET['mod_id'])) { // valores para el modulo de llegadas tarde
	$_SESSION['filtro']['persona'] = $_GET['mod_id'];
	$_SESSION['filtro']['fechaD'] = date('Y-m-d H:i:s', strtotime('-7 day'));   //que hace esto?
	$_SESSION['filtro']['fechaH'] = date('Y-m-d H:i:s');
}


if (isset($_GET['desde']))
	$_SESSION['filtro']['fechaD'] = $_GET['desde'];
if (isset($_GET['hasta']))
	$_SESSION['filtro']['fechaH'] = $_GET['hasta'];


$T_Intervalo = isset($_REQUEST['intervaloFecha']) ? (string) $_REQUEST['intervaloFecha'] : '';

if(isset ($_POST['bloqueados'])){
	$_SESSION['filtro']['bloqueados'] = $_POST['bloqueados'];
}  else{
	$_SESSION['filtro']['bloqueados'] = 'No';
}


//MANEJO DE LOS INTERVALOS DE FECHAS
if(isset($T_Intervalo) && $T_Intervalo!=''){
		switch($T_Intervalo){
			case 'F_Hoy'://diario
				$_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime('today 00:00'));
				$_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime('tomorrow 00:00'));
			break;
			case 'F_Semana'://semana
				$_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime('this week 00:00'));
				$_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime('next week 00:00'));
			break;
			case 'F_Quincena'://quincena
				$primerDiadelMes=strtotime('first day of this month 00:00');
				$ultimoDiadelMes=strtotime('first day of next month 00:00');
				$mitadDelMes=strtotime('+15 days',$primerDiadelMes);
				if(time()<$mitadDelMes){//primera quincena					
					$_SESSION['filtro']['fechaD']= date('Y-m-d H:i:s',$primerDiadelMes);
					$_SESSION['filtro']['fechaH']= date('Y-m-d H:i:s',$mitadDelMes);
				}
				else {					
					$_SESSION['filtro']['fechaD']= date('Y-m-d H:i:s',$mitadDelMes);
					$_SESSION['filtro']['fechaH']= date('Y-m-d H:i:s',$ultimoDiadelMes);
				}				
			break;
			case 'F_Mes'://mes
				$_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime('first day of this month 00:00'));
				$_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime('first day of next month 00:00'));
			break;
			case 'F_Ano'://mes
				$_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime("first day of january " . date('Y') . " 00:00 "));
				$_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime("first day of january " . date('Y') . " 00:00 +1 year"));
			break;
			case 'F_Personalizado':
				$_SESSION['filtro']['fechaD'] = (!isset($_POST['fechaD'])) ? (isset($_SESSION['filtro']['fechaD'])) ? $_SESSION['filtro']['fechaD'] : date('Y-m-d H:i:s', strtotime('-1 day'))  : $_POST['fechaD'];
				$_SESSION['filtro']['fechaH'] = (!isset($_POST['fechaH'])) ? (isset($_SESSION['filtro']['fechaH'])) ? $_SESSION['filtro']['fechaH'] : date('Y-m-d H:i:s')  : $_POST['fechaH'];
			break;
		}
	}else{//selecciono el dropdown si la fecha ya viene 	
		if($_SESSION['filtro']['fechaD']==date('Y-m-d H:i:s',strtotime('today 00:00')) && $_SESSION['filtro']['fechaH']==date('Y-m-d H:i:s',strtotime('tomorrow 00:00')))
			$T_Intervalo='F_Hoy';
		elseif($_SESSION['filtro']['fechaD']==date('Y-m-d H:i:s',strtotime('this week 00:00')) && $_SESSION['filtro']['fechaH']==date('Y-m-d H:i:s',strtotime('next week 00:00')))
			$T_Intervalo='F_Semana';
		elseif($_SESSION['filtro']['fechaD']==date('Y-m-d H:i:s',strtotime('first day of this month 00:00')) && $_SESSION['filtro']['fechaH']==date('Y-m-d H:i:s',strtotime('+15 days',strtotime('first day of this month 00:00'))))
			$T_Intervalo='F_Quincena';	
		elseif($_SESSION['filtro']['fechaD']==date('Y-m-d H:i:s',strtotime('+15 days',strtotime('first day of this month 00:00'))) && $_SESSION['filtro']['fechaH']==date('Y-m-d H:i:s',strtotime('first day of next month 00:00')))
			$T_Intervalo='F_Quincena';
		elseif($_SESSION['filtro']['fechaD']==date('Y-m-d H:i:s',strtotime('first day of this month 00:00')) && $_SESSION['filtro']['fechaH']==date('Y-m-d H:i:s',strtotime('first day of next month 00:00')))
			$T_Intervalo='F_Mes';
		elseif($_SESSION['filtro']['fechaD']==date('Y-m-d H:i:s',strtotime("first day of january " . date('Y') . " 00:00 ")) && $_SESSION['filtro']['fechaH']==date('Y-m-d H:i:s',strtotime("first day of january " . date('Y') . " 00:00 +1 year")))
			$T_Intervalo='F_Ano';
		else	$T_Intervalo='F_Personalizado';
	}





switch ($T_Tipo) {
	case'Tarde':
	case'Temprano':
	case'Dias':
	case'Entradas':
    case'Feriados':
		SeguridadHelper::Pasar(20);
		
		
		if ($T_Tipo == 'Dias') {
			$T_Titulo = _('Días/Horas Trabajadas');
			$_SESSION['filtro']['csv_nombre'] = _('Días_Horas_Trabajadas');
			$paginado = 'No';
			$Reporte_Tipo=21;
			$Reporte_Nombre=_('Reporte_Dias-Horas_Trabajadas').' - '.date(Config_L::p('f_fecha_archivos'),time()).'.pdf';
		} elseif ($T_Tipo == 'Entradas') {
			$T_Titulo = _('Entradas/Salidas por Persona');
			$_SESSION['filtro']['csv_nombre'] = _('Entradas_Salidas_por_Persona');
			$paginado = 'No';
			$Reporte_Tipo=20;
			$Reporte_Nombre=_('Reporte_Entradas_Salidas').' - '.date(Config_L::p('f_fecha_archivos'),time()).'.pdf';
		} elseif ($T_Tipo == 'Feriados') {
            $T_Titulo = _('Reporte de Feriados');
            $_SESSION['filtro']['csv_nombre'] = _('Reporte_de_Feriados');
            $paginado = 'No';
            $Reporte_Tipo=20;
            $Reporte_Nombre=_('Reporte_de_Feriados').' - '.date(Config_L::p('f_fecha_archivos'),time()).'.pdf';
        } elseif ($T_Tipo == 'Tarde') {
			$T_Titulo = _('Llegadas Tarde');
			$_SESSION['filtro']['csv_nombre'] = _('Llegadas_Tarde');
			$paginado = 'No';
			$Reporte_Tipo=19;
			$Reporte_Nombre=_('Reporte_Llegadas_tarde').' - '.date(Config_L::p('f_fecha_archivos'),time()).'.pdf';
		} elseif ($T_Tipo == 'Temprano') {
			$T_Titulo = _('Salidas Temprano');
			$_SESSION['filtro']['csv_nombre'] = _('Salidas_Temprano');
			$paginado = 'No';
			$Reporte_Tipo=23;
			$Reporte_Nombre=_('Reporte_Salidas_Temprano').' - '.date(Config_L::p('f_fecha_archivos'),time()).'.pdf';
		}

		
		$_SESSION['filtro']['persona'] = (integer) (!isset($_POST['persona'])) ? (isset($_SESSION['filtro']['persona'])) ? $_SESSION['filtro']['persona'] : 0  : $_POST['persona'];
		$_SESSION['filtro']['rolF'] = (integer) (!isset($_POST['rolF'])) ? (isset($_SESSION['filtro']['rolF'])) ? $_SESSION['filtro']['rolF'] : 0  : $_POST['rolF'];
		
		//if (isset($_POST['btnFiltro']) || isset($_GET['page'])) {
		//	if ($_SESSION['filtro']['persona'] != 0) {
		if (DateTimeHelper::getTimestampFromFormat($_SESSION['filtro']['fechaD'], 'Y-m-d H:i:s') !== false || $_SESSION['filtro']['fechaD'] == '' && DateTimeHelper::getTimestampFromFormat($_SESSION['filtro']['fechaH'], 'Y-m-d H:i:s') !== false || $_SESSION['filtro']['fechaH'] == '') {

			include_once APP_PATH.'/includes/reporte_control_personal.php';

			//echo "<pre>";	print_r($o_Listado); echo "</pre>";
		} else {
			$T_Error['error'] = _('Alguna de las fechas no es valida');
		}
		//} else {
		//		$T_Error['error'] = 'Ingrese una persona';
		//	}
		//}

		

		break;
	case 'Ausencias': 
		$Reporte_Tipo=22;	
		$Reporte_Nombre=_('Reporte_Ausencias').' - '.date(Config_L::p('f_fecha_archivos'),time()).'.pdf';
		SeguridadHelper::Pasar(20);
		$T_Titulo = _('Ausencia del Personal');
		$_SESSION['filtro']['csv_nombre'] = _('Reporte_Ausencias');

		
		//$_SESSION['filtro']['fechaD'] = (!isset($_POST['fechaD'])) ? (isset($_SESSION['filtro']['fechaD'])) ? $_SESSION['filtro']['fechaD'] : date('Y-m-d H:i:s', strtotime('-1 day'))  : $_POST['fechaD'];
		//$_SESSION['filtro']['fechaH'] = (!isset($_POST['fechaH'])) ? (isset($_SESSION['filtro']['fechaH'])) ? $_SESSION['filtro']['fechaH'] : date('Y-m-d H:i:s')  : $_POST['fechaH'];
		$_SESSION['filtro']['persona'] = (integer) (!isset($_POST['persona'])) ? (isset($_SESSION['filtro']['persona'])) ? $_SESSION['filtro']['persona'] : 0  : $_POST['persona'];
		$_SESSION['filtro']['rolF'] = (integer) (!isset($_POST['rolF'])) ? (isset($_SESSION['filtro']['rolF'])) ? $_SESSION['filtro']['rolF'] : 0  : $_POST['rolF'];
		
		$a_aus = Control_PersonalHelper::Ausencias($_SESSION['filtro']['persona'], $_SESSION['filtro']['fechaD'], $_SESSION['filtro']['fechaH'], $dias);
		
		//printear($a_aus);
		
		break;
	default:
		$T_Tipo = 'L_Dia';
		SeguridadHelper::Pasar(20);
		$T_Link = '';
		$o_Listado = null;

}


