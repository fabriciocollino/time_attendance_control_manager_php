<?php

SeguridadHelper::Pasar(90);

$T_Script = 'logs_equipos';
$T_Link = '';
$o_Listado = null;

$T_Id = isset($_REQUEST['id']) ? (integer) $_REQUEST['id'] : 0;
$T_Accion = isset($_REQUEST['accion']) ? (string) $_REQUEST['accion'] : '';


$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;

//printear($_REQUEST);

switch ($T_Tipo) {
    case 'delete' :
        SeguridadHelper::Pasar(999);
        $o_Log = Logs_Equipo_L::obtenerPorId($T_Id);

        if (is_null($o_Log)) {
            $T_Error = _('Lo sentimos, el log que desea eliminar no existe.');
        } else {
            if (!$o_Log->delete(Registry::getInstance()->general['debug'])) {
                $T_Error = $o_Log->getErrores();
            } else {
                //SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_GRUPO_ELIMINAR, $a_Logs_Tipos[LOG_GRUPO_ELIMINAR], '<b>Id:</b> ' . $o_Grupo->getId() . ' <b>Grupo:</b> ' . $o_Grupo->getDetalle(), $o_Grupo->getId());
                $T_Mensaje = _('El log fue eliminado con éxito.');
            }

        }
        break;
}


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
	
	
if(!isset($_POST['equipoid'])){
	if(isset($_SESSION['filtro']['equipoid'])){
		$_SESSION['filtro']['equipoid'] = $_SESSION['filtro']['equipoid'];
	}else{
		$_SESSION['filtro']['equipoid'] =  0;
	}
}  else {
	$_SESSION['filtro']['equipoid'] = $_POST['equipoid'];
}


if ((DateTimeHelper::getTimestampFromFormat($_SESSION['filtro']['fechaD'], 'Y-m-d H:i:s') !== false || $_SESSION['filtro']['fechaD'] == '') && DateTimeHelper::getTimestampFromFormat($_SESSION['filtro']['fechaH'], 'Y-m-d H:i:s') !== false) {

		if($_SESSION['filtro']['equipoid']!=0)
				$condicion = " leq_Eq_Id = '{$_SESSION['filtro']['equipoid']}' AND leq_Fecha_Hora >= '{$_SESSION['filtro']['fechaD']}' AND leq_Fecha_Hora <= '{$_SESSION['filtro']['fechaH']}' ";
		else
				$condicion = " leq_Fecha_Hora >= '{$_SESSION['filtro']['fechaD']}' AND leq_Fecha_Hora <= '{$_SESSION['filtro']['fechaH']}' ";





	$o_Listado = Logs_Equipo_L::obtenerTodosOSP($condicion,'DESC');
	
	//echo "<pre>";print_r($o_Listado);echo "</pre>";
		

} else {
	$T_Error['error'] = _('Alguna de las fechas no es valida');
}
