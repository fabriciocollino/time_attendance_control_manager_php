<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php


$o_Listado = Equipo_L::obtenerTodos();


?>

<style>

</style>
<table id="datatable_tabletools" class="table table-striped table-hover table-no-border ">

    <tbody>
    <?php if (!is_null($o_Listado)): ?>

        <?php foreach ($o_Listado as $key => $item): ?>
            <?php
            $g_temp = (integer)time() - (integer)$item->getHeartbeat('U');
            //echo 'Time: '.time().' - HB: '.$item->getHeartbeat('U').' = '.$g_temp.'<br>';
            if ($g_temp < 15) {
                $status_c = "fa-check-square status-green";
                $status_s = "En Línea";
            } else {
                $status_c = "fa-minus-square status-red";
                $status_s = "Sin Conexión";
            }
            ?>
            <tr>
                <td class="fa dashboard-status-icons <?php echo $status_c ?> col-1"></td>
                <td class="dashboard-status-text col-2"><?php echo $status_s ?></td>
                <td class="dashboard-status-text col-2"><?php echo $item->getDetalle(); ?></td>
                <td class="dashboard-status-text no-mobile hidden-mobile" title="Último chequeo"
                    style=""><?php echo $item->getHeartbeat(Config_L::p('f_fecha_corta')); ?></td>
                <td class="dashboard-status-text no-mobile" width="40%" style="padding: 0px;">
                                <span style="font-size:2px;" class="sparkline" data-sparkline-type="line"
                                      data-sparkline-width="100%" data-sparkline-height="40px" data-sparkline-min-y="1"
                                      data-sparkline-max-y="20">
                                    <?php echo Heartbeat_L::getChartData($item->getId(), 70); ?>
                                    <?php $tiempoG = (integer)time() - (integer)$item->getHeartbeat('U');
                                    if ($tiempoG > 15) echo ",0"; ?>
                                </span>
                    <?php
                    /*
                     * El span de arriba tiene un font-size chico porque sino, antes de crear el grafico
                     * el espacio para hacerlo es distinto al de despues de crear el grafico, entonces el segundo sparkline queda mas chico.
                     */
                    ?>
                </td>
            </tr>


            <?php
            $tiempoG = (integer)time() - (integer)$item->getHeartbeat('U');
            if ($tiempoG > 120 && $tiempoG < 240) {//esto es para que solo se ejecute una sola vez.
                echo "<script type=\"text/javascript\">NotificacionPerdidaConexion('" . $item->getDetalle() . "')</script>";
                $o_Mensaje = new Mensaje_O($item->getId(), 0, "Pérdida de Conexión", "Se ha perdido la conexión con: " . $item->getDetalle());
                $o_Mensaje->save('Off');
            } else {

            }
            ?>
        <?php endforeach; ?>


    <?php else: ?>
        No hay ningún equipo configurado aún
    <?php endif; ?>

    </tbody>
</table>


<script type="text/javascript">


    runAllCharts();


    function NotificacionPerdidaConexion(Equipo) {

        $.smallBox({
            title: "Atención",
            content: "Se ha perdido la conexión con: " + Equipo,
            color: "#A65858",
            icon: "fa fa-bell swing animated",
            timeout: 25000
        });
    }


</script>


