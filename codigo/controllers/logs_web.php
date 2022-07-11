<?php

SeguridadHelper::Pasar(90);

$T_Script = 'logs_web';

$T_Intervalo = isset($_REQUEST['intervaloFecha']) ? (string) $_REQUEST['intervaloFecha'] : '';
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
	
	
if ((DateTimeHelper::getTimestampFromFormat($_SESSION['filtro']['fechaD'], 'Y-m-d H:i:s') !== false || $_SESSION['filtro']['fechaD'] == '') && DateTimeHelper::getTimestampFromFormat($_SESSION['filtro']['fechaH'], 'Y-m-d H:i:s') !== false) {
	$condicion = " log_Fecha_Hora >= '{$_SESSION['filtro']['fechaD']}' AND log_Fecha_Hora <= '{$_SESSION['filtro']['fechaH']}' ";

	$o_Listado = Logs_Web_L::obtenerTodosSP($condicion,'DESC');
	$pagiando = 'Si';
} else {
	$T_Error['error'] = _('Alguna de las fechas no es valida');
}