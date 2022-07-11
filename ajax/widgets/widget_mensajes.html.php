<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php

$o_Listado = Mensaje_L::obtenerTodos('men_Visto=0', '', 5);

?>

<style>
    #inbox-table tr td {
        border-right: 0;
        border-left: 0;
        line-height: 15px !important;
        padding-bottom: 3px !important;
        padding-top: 6px !important;
        vertical-align: middle;
    }

    .inbox-data-message > :first-child {
        height: 15px;
    }

    @media (min-width: 1200px) and (max-width: 1807px) {
        .inbox-data-from {
            display: none !important;
        }
    }

    @media (min-width: 1200px) and (max-width: 1390px) {
        .inbox-data-date {
            display: none !important;
        }
    }


</style>

<?php

$cantidad_unread = 0;
$cantidad_unread = Mensaje_L::obtenerCantidadUnread();


?>

<?php if (!is_null($o_Listado)): ?>
    <table id="inbox-table" class="table table-striped table-hover">
        <tbody>


        <?php foreach ($o_Listado as $key => $item): /*  @var $item Mensaje_O */ ?>
            <tr id="msg_id_<?php echo $item->getId(); ?>"
                class="<?php echo($item->getVisto() == 1 ? 'read' : 'unread'); ?>">

                <td class="inbox-data-from hidden-xs hidden-sm ">
                    <div>
                        <?php echo $item->getTitulo(); ?>
                    </div>
                </td>
                <td class="inbox-data-message ">
                    <div>
                        <span><span
                                class="label bg-color-orange"><?php echo $item->getTipo_S(); ?></span> <?php echo Equipo_L::obtenerPorId($item->getEqId())->getDetalle(); ?></span> <?php echo $item->getMensaje(60); ?>
                    </div>
                </td>
                <td class="inbox-data-date hidden-xs">
                    <div title="<?php echo $item->getFecha(Config_L::p('f_fecha_corta')); ?>">
                        <?php echo $item->getFechaFormatoGmail(); ?>
                    </div>
                </td>
                <td class="inbox-table-icon">
                    <a href="javascript:void(0);" onclick="setMensajeVisto(<?php echo $item->getId(); ?>);return;"
                       class="btn btn-default btn-xs"><i class="fa fa-close"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>


        </tbody>
    </table>

<?php else: ?>
No hay mensajes
<?php endif; ?>

<script type="text/javascript">


    $("#div_unread_count").text("<?php echo $cantidad_unread; ?>");
    if (<?php echo $cantidad_unread; ?> >
    0
    )
    $("#div_unread_count").show();
    else
    $("#div_unread_count").hide();


</script>


