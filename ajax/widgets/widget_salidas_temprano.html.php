<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php
$UsarFechasWidget = true;
SeguridadHelper::Pasar(20);

$T_Titulo = _('Salidas Temprano');

$Fecha_Boton = Config_L::p('reset_salidas_temprano');
$Fecha_Lunes = strtotime('Tuesday this week');

$T_SelIntervalo = (isset($_REQUEST['selIntervalo'])) ? $_REQUEST['selIntervalo'] : '';


if (Config_L::p('resetear_salidas_temprano_los_martes')) {
    if ($Fecha_Lunes > strtotime($Fecha_Boton) && $Fecha_Lunes < strtotime(date('Y-m-d H:i:s'))) {
        $_SESSION['filtro']['fechaDw'] = date('Y-m-d H:i:s', $Fecha_Lunes);
    } else {
        $Fecha_Lunes = strtotime('Tuesday last week');
        if ($Fecha_Lunes > strtotime($Fecha_Boton))
            $_SESSION['filtro']['fechaDw'] = date('Y-m-d H:i:s', $Fecha_Lunes);
        else
            $_SESSION['filtro']['fechaDw'] = date('Y-m-d H:i:s', strtotime($Fecha_Boton));
    }
} else {
    $_SESSION['filtro']['fechaDw'] = date('Y-m-d H:i:s', strtotime($Fecha_Boton));
}

//$_SESSION['filtro']['fechaD'] =date('Y-m-d H:i:s',time()-60*60*24*5);

$_SESSION['filtro']['fechaHw'] = date('Y-m-d H:i:s');

$_SESSION['filtro']['persona'] = '';

$cantidad = 0;


$day = date('w');
$week_start = date('Y-m-d 00:00:00', strtotime('-' . $day . ' days'));
$week_end = date('Y-m-d 23:59:59', strtotime('+' . (6 - $day) . ' days'));

switch ($T_SelIntervalo) {
    case '':
    case 'hoy':
        $_SESSION['filtro']['fechaDw'] = date('Y-m-d 00:00:00');
        $_SESSION['filtro']['fechaHw'] = date('Y-m-d 23:59:59');
        break;
    case 'esta_semana':
        $_SESSION['filtro']['fechaDw'] = $week_start;
        $_SESSION['filtro']['fechaHw'] = $week_end;
        break;
}


$T_Tipo = 'mod_Salida_Temprano';
$a_mod = null;

include_once APP_PATH . '/includes/reporte_control_personal.php';
$o_Listado = $a_mod;
//echo date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . ' - ' .date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH'])).'<br />';
if (isset($o_Listado) && !is_null($o_Listado)) {
    echo '<table class="tb_100">';
    echo '<thead>';
    echo '<tr>';
    echo '<th class="tb_80">';
    echo _('Persona');
    echo '</th>';
    if($T_SelIntervalo!='hoy') {
        echo '<th class="tb_20">';
        echo _('Días');
        echo '</th>';
    }
    echo '</tr>';
    echo '</thead>';

    $key = 1;
    foreach ($o_Listado as $reng) {
        echo '<tr>';
        echo '<td>';
        echo $reng['leg_ape_nomb'];
        echo '</td>';
        /*
        echo '<td><a href="';
        echo WEB_ROOT;
        echo '/control_personal.php?Tipo=L_Tarde&mod_id=';
        echo $reng['per_Id'];
        echo '&desde=' . $_SESSION['filtro']['fechaDw'] . '&hasta=' . $_SESSION['filtro']['fechaHw'] . ' ">';
        echo $reng['cant'];
        echo '</a></td>';
        */
        if($T_SelIntervalo!='hoy') {
            echo '<td>';
            echo $reng['cant'];
            echo '</td>';
        }
        echo '</tr>';
        $cantidad++;
        $key += 1;
    }
    echo '</table>';
} else {
    echo _('No hay salidas temprano');
}
echo '<div id="CantSalidasTemprano" style="display:none;">' . $cantidad . '</div>';

?>

<script type="text/javascript">


</script>


