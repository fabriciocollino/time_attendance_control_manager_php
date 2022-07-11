<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php


SeguridadHelper::Pasar(20);
$UsarFechasWidget = true;
$T_Titulo = _('en Vivo');

$T_SelIntervalo = (isset($_REQUEST['selIntervalo'])) ? $_REQUEST['selIntervalo'] : '';


$_SESSION['filtro']['fechaHw'] = date('Y-m-d H:i:s');

$_SESSION['filtro']['persona'] = '';


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
//}

//TODO: Hacer esto sin el modulo de control de personal, es decir, trayendo los logs y haciendo los calculos de entrada/salida directamente
$T_Tipo = 'mod_Entradas_Salidas';
$a_mod = null;
include_once APP_PATH . '/includes/reporte_control_personal.php';


$o_Listado_g = Grupo_L::obtenerTodosEnVivo();


?>

<style>

</style>

<?php if (!is_null($o_Listado_g)): ?>
    <table id="table_en_vivo" class="table table-hover table-no-border ">

        <tbody>

        <?php foreach ($o_Listado_g as $key => $item): /* @var $item Grupo_O */ ?>

            <tr data-id="<?php echo $item->getId(); ?>" data-parent="">

                <td class=""><?php echo $item->getDetalle(); ?></td>
                <td class="dashboard-icon-count-column">
                    <?php //a este foreach lo puedo eliminar, si guardo la cantidad en el foreach de las tr y despues actualizo el span con un javascript
                    $cant = 0;
                    if (!is_null($a_mod)) {
                        foreach ($a_mod as $index => $item_p) {
                            //TODO: optimizar esto. en vez de preguntar por cada persona, traer una sola vez el array de personas por grupo y preguntar aca con in_array
                            if(!Grupos_Personas_L::checkIfPersonaGrupo($item_p['per_Id'],$item->getId()))continue;
                            if($item_p['cantidad'] % 2 == 0)continue; //solo muestro numeros impares. (personas que estan presentes en el momento)
                            $cant++;
                        }
                    }
                    if ($cant == 0)
                        echo "<span title=\"Personas presentes\" class=\"badge bg-color-red\">" . $cant . "</span>";
                    else
                        echo "<span title=\"Personas presentes\" class=\"badge bg-color-greenLight\">" . $cant . "</span>";
                    ?>

                </td>
                <td class="dashboard-status-icons dashboard-icon-column"></td>
            </tr>
            <?php if (!is_null($a_mod)): ?>
                <?php foreach ($a_mod as $index => $item_p): ?>
                    <?php if(!Grupos_Personas_L::checkIfPersonaGrupo($item_p['per_Id'],$item->getId()))continue; ?>
                    <?php if($item_p['cantidad'] % 2 == 0)continue; //solo muestro numeros impares. (personas que estan presentes en el momento) ?>
                    <tr data-parent="<?php echo $item->getId(); ?>" style="display: none;">
                        <td title="<?php echo $item_p['hora']; ?>" style="padding-left: 5%"><?php echo $item_p['leg_ape_nomb']; ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php endforeach; ?>


        </tbody>
    </table>
<?php else: ?>
    No hay ningún grupo para mostrar en vivo.
<?php endif; ?>

<script>
    $(function () {
        $('[rel=popover-hover],[data-rel="popover-hover"]').popover({"trigger": "hover"});
    });

    function iniciar_collaptable() {
        $('#table_en_vivo').aCollapTable({
            startCollapsed: true,
            addColumn: false,
            plusButton: '<i class="fa fa-plus-square-o"></i> ',
            minusButton: '<i class="fa fa-minus-square-o"></i> '
        });
    }
    setTimeout(iniciar_collaptable, 1200);


</script>