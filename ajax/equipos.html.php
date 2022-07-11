<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php'; ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-8 col-sm-7 col-md-7 col-lg-4"><!-- col -->
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-hdd-o"></i>
            <?php echo _('Equipos') ?>
            <span>>
                <?php echo _('Listado de Equipos') ?>
			</span>
        </h1>
    </div>

    <?php /*
    <div class="col-xs-4 col-sm-5 col-md-5 col-lg-8" id="sparkscontainer">
        <div id="sparks">
            <button class="btn btn-sm btn-primary" type="button" data-backdrop="static" data-toggle="modal"
                    data-target="#editar" data-type="view" data-lnk="ajax/<?= $Item_Name ?>-editar.html.php">
                <?php echo _('Agregar Equipo') ?>
            </button>
        </div>
    </div>
    */ ?>

</div>
<!-- end row -->


<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-hdd"></i> </span>
                    <h2><?php echo _('Listado de Equipos') ?></h2>

                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        <table id="dt_basic" class="table table-striped table-hover dataTable no-footer"
                               aria-describedby="dt_basic_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th data-sortable="false"><?php echo _('Estado') ?></th>
                                <th><?php echo _('Detalle') ?></th>
                                <th><?php echo _('Red') ?></th>
                                <!--<th><?php echo _('IP') ?></th>-->
                                <!--<th><?php echo _('Bloqueado') ?></th>-->
                                <th style="width:150px;"><?php echo _('Opciones') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!is_null($o_Listado)): ?>

                                <?php foreach ($o_Listado as $key => $item): ?>
                                    <?php
                                    $g_temp = (integer)time() - (integer)$item->getHeartbeat('U');
                                    if ($g_temp < 600) {  //10 minutos
                                        $status_c = "fa fa-check-square status-green";

                                    } else {
                                        $status_c = "fa fa-minus-square status-red";

                                    }
                                    ?>
                                    <tr>
                                        <td class="dashboard-status-icons dashboard-icon-column"
                                            onclick="ProbarEquipoenVivo(<?php echo $item->getId(); ?>,this)"
                                            style="cursor: pointer;"><p
                                                style="margin-bottom: 0px;"
                                                rel="popover-hover" data-placement="top"
                                                data-original-title="Último chequeo"
                                                data-content="<?php echo $item->getHeartbeat(Config_L::p('f_fecha_corta')); ?>">
                                                <i class="<?php echo $status_c ?> status-icon-vivo"></i></p></td>
                                        <td><?php echo $item->getDetalle(); ?></td>
                                        <td><?php
                                            echo $item->getTipoRed_S();
                                            if($item->getTipoRed()=="wlan"){
                                                echo " Señal: ".$item->getWifiSignal();
                                            }
                                        ?></td>
                                        <!--<td><?php echo $item->getIP(); ?></td>-->
                                        <!--<td><?php echo $item->getBloqueadoEl('Y-m-d H:i:s') . '&nbsp;'; ?></td>-->
                                        <td style="white-space: nowrap;">
                                            <button data-toggle="modal" data-backdrop="static" data-target="#editar"
                                                    data-type="view" data-lnk="ajax/<?= $Item_Name ?>-editar.html.php"
                                                    data-id="<?php echo $item->getId(); ?>"
                                                    title="<?php echo _('Editar') ?>"
                                                    class="btn btn-default btn-sm fa fa-edit fa-lg"
                                                    style="line-height: .75em;"></button>
                                    <?php    if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999){ ?>
                                            <button title="<?php echo _('Blink') ?>"
                                                    class="btn btn-default btn-sm fa fa-lightbulb-o fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="Blink(<?php echo $item->getId(); ?>)"></button>
                                            <button title="<?php echo _('Forzar Ping') ?>"
                                                class="btn btn-default btn-sm fa fa-mail-reply-all fa-lg"
                                                style="line-height: .75em;"
                                                onclick="ForzarPing(<?php echo $item->getId(); ?>)"></button>
                                            <button title="<?php echo _('Resetear Lector') ?>"
                                                    class="btn btn-default btn-sm fa fa-usb fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="ReiniciarLector(<?php echo $item->getId(); ?>)"></button>
                                            <button title="<?php echo _('Reiniciar') ?>"
                                                    class="btn btn-default btn-sm fa fa-power-off fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="ReiniciarEquipo(<?php echo $item->getId(); ?>)"></button>
                                            <button title="<?php echo _('Reiniciar APP') ?>"
                                                    class="btn btn-default btn-sm fa fa-refresh fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="ReiniciarAPP(<?php echo $item->getId(); ?>)"></button>
                                            <button title="<?php echo _('Restart Wifi') ?>"
                                                    class="btn btn-default btn-sm fa fa-spoon fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="ResetWireless(<?php echo $item->getId(); ?>)"></button>
                                            <?php if($item->getBloquearSync()) { ?>
                                            <button title="<?php echo _('Desloquear Sync') ?>"
                                                    class="btn btn-danger btn-sm fa fa-cloud-download fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="BloquearSync(<?php echo $item->getId(); ?>)"></button>
                                            <?php } else { ?>
                                            <button title="<?php echo _('Bloquear Sync') ?>"
                                                    class="btn btn-default btn-sm fa fa-cloud-download fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="BloquearSync(<?php echo $item->getId(); ?>)"></button>
                                            <?php } ?>
                                            <?php if($item->getLockUpdates()) { ?>
                                                <button title="<?php echo _('Desloquear Updates') ?>"
                                                        class="btn btn-danger btn-sm fa fa-download fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="BloquearUpdates(<?php echo $item->getId(); ?>)"></button>
                                            <?php } else { ?>
                                                <button title="<?php echo _('Bloquear Updates') ?>"
                                                        class="btn btn-default btn-sm fa fa-download fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="BloquearUpdates(<?php echo $item->getId(); ?>)"></button>
                                            <?php } ?>
                                            <button title="<?php echo _('Purge Database') ?>"
                                                    class="btn btn-default btn-sm fa fa-database fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="PurgeDatabase(<?php echo $item->getId(); ?>)"></button>
                                            <button title="<?php echo _('Clear Network Info') ?>"
                                                    class="btn btn-default btn-sm fa fa-wifi fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="ClearNetworkInfo(<?php echo $item->getId(); ?>)"></button>
                                            <?php if($item->getMaintenanceMode()) { ?>
                                                <button title="<?php echo _('Salir de Modo de Mantenimiento') ?>"
                                                        class="btn btn-danger btn-sm fa fa-wrench fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="MaintenanceMode(<?php echo $item->getId(); ?>)"></button>
                                            <?php } else { ?>
                                                <button title="<?php echo _('Modo Mantenimiento') ?>"
                                                        class="btn btn-default btn-sm fa fa-wrench fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="MaintenanceMode(<?php echo $item->getId(); ?>)"></button>
                                            <?php } ?>
                                            <button title="<?php echo _('Debug Info') ?>"
                                                    class="btn btn-default btn-sm fa fa-info fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="DebugInfo(<?php echo $item->getId(); ?>)"></button>

                                    <?php } ?>
                                            <?php if (is_null($item->getBloqueadoEl())): ?>
                                                <button title="<?php echo _('Bloquear') ?>"
                                                        class="btn btn-default btn-sm fa fa-lock fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="BloquearEquipo(<?php echo $item->getId(); ?>)"></button>
                                            <?php else: ?>
                                                <button title="<?php echo _('Des-Bloquear') ?>"
                                                        class="btn btn-default btn-sm fa fa-unlock fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="DesBloquearEquipo(<?php echo $item->getId(); ?>)"></button>
                                            <?php endif; ?>
                                    <?php    if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999){ ?>
                                            <button data-type="delete" data-id="<?php echo $item->getId(); ?>"
                                                    title="<?php echo _('Eliminar') ?>"
                                                    class="btn btn-default btn-sm fa fa-trash-o fa-lg"
                                                    style="line-height: .75em;"></button>
                                    <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>


                            <?php else: ?>
                            <?php endif; ?>

                            </tbody>
                        </table>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->

        </article>
        <!-- WIDGET END -->

    </div>

    <!-- end row -->


</section>
<!-- end widget grid -->


<?php
//INCLUYO los view/edit etc de los cosos
require_once APP_PATH . '/templates/edit-view_modal.html.php';
?>


<script type="text/javascript">


    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }
    <?php
    //INCLUYO el js de las datatables
    require_once APP_PATH . '/includes/data_tables.js.php';
    ?>

    //esto asigna el ID al modal cada vez que se hace click en el boton
    $(document).ready(function () {
        $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {
            var data_id = '';
            var lnk = '';
            var view_type = '';
            if (typeof $(this).data('id') !== 'undefined') {
                data_id = $(this).data('id');
            }
            if (typeof $(this).data('lnk') !== 'undefined') {
                lnk = $(this).data('lnk');
            }
            if (typeof $(this).data('type') !== 'undefined') {
                view_type = $(this).data('type');
            }


            $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");
            $.ajax({
                cache: false,
                type: 'POST',
                url: lnk,
                data: {tipo: view_type, id: data_id},
                success: function (data) {
                    $('.modal-content').show().html(data);
                }
            });
        })
    });


    $('a[data-type=delete], button[data-type=delete]').click(function () {
        var data_id = '';
        var lnk = '';
        var view_type = '';
        if (typeof $(this).data('id') !== 'undefined') {
            data_id = $(this).data('id');
        }
        if (typeof $(this).data('lnk') !== 'undefined') {
            lnk = $(this).data('lnk');
        }
        if (typeof $(this).data('type') !== 'undefined') {
            view_type = $(this).data('type');
        }

        ExistMsg = 0;//por un error en el plugin smartmessagebox  http://myorange.ca/supportforum/question/smartmessagebox-not-working-after-page-reload-smartmsgboxcount-not-reset

        $.SmartMessageBox({
            title: "Eliminar <?php echo $T_Titulo_Singular; ?>",
            content: "Está por eliminar <?php echo $T_Titulo_Pre; ?> <?php echo $T_Titulo_Singular; ?>. Todos los datos relacionados con este equipo serán Eliminados. </br>Esta operación no se puede deshacer. Desea continuar?",
            buttons: '[No][Si]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Si") {
                //esto refresca la pagina
                loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: view_type, id: data_id});
            }
            else if (ButtonPressed === "No") {
                SmartUnLoading();
            }

        });


    });



    function BloquearEquipo(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'disable', id: Equipo});
    }

<?php    if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999){ ?>
    function ReiniciarEquipo(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'reboot', id: Equipo});
    }

    function ReiniciarAPP(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'restart_app', id: Equipo});
    }

    function ReiniciarLector(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'reset_reader', id: Equipo});
    }

    function Blink(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'blink', id: Equipo});
    }

    function ForzarPing(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'force_ping', id: Equipo});
    }

    function BloquearSync(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'block_sync', id: Equipo});
    }

    function BloquearUpdates(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'block_updates', id: Equipo});
    }

    function MaintenanceMode(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'maintenance_mode', id: Equipo});
    }

    function ClearNetworkInfo(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'clear_network_info', id: Equipo});
    }

    function DebugInfo(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'debug_info', id: Equipo});
    }

    function ResetWireless(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'reset_wireless', id: Equipo});
    }

    function PurgeDatabase(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'purge_database', id: Equipo});
    }

<?php } ?>
    function ProbarEquipo(Equipo) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'testsync', id: Equipo});
    }

    function DesBloquearEquipo(Equipo) {

        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'enable', id: Equipo});
    }


    function ProbarEquipoenVivo(Equipo, Elemento) {

        var widget = "#wid-id-108";


        $(Elemento).css({"pointer-events": "none"});
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'codigo/controllers/equipos.php',
            data: {tipo: 'sendsync', id: Equipo},
            success: function (data, status) {
                //setTimeout(function(){ $(widget + ' .jarviswidget-refresh-btn').click(); }, 1000);
                $(Elemento).find('.status-icon-vivo').removeClass('fa-check-square');
                $(Elemento).find('.status-icon-vivo').removeClass('fa-minus-square');
                $(Elemento).find('.status-icon-vivo').addClass('fa-gear');
                $(Elemento).find('.status-icon-vivo').addClass('fa-spin');
                //alert(data);
                setTimeout(function () {
                    loadURL('equipos', $('#content'));
                }, 3000);

            }
        });

    }

</script>


<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>
