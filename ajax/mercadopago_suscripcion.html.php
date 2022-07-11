<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>

<?php $T_Suscripciones = array(); ?>

<?php require_once(APP_PATH . '/libs/random/random.php'); ?>
<?php require_once APP_PATH . '/controllers/mercadopago_suscripcion.php'; ?>
<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- SECTION HEADER -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-star"></i>
            <?php echo _('Clientes') ?>
            <span>>
                <?php echo _('Suscripciones') ?>
			</span>
        </h1>
    </div>

    <!-- BUTTON: NEW SUBSCRIPTION -->
    <div class="col-xs-4 col-sm-5 col-md-5 col-lg-8" id="sparkscontainer">
        <div id="sparks">

            <button class="btn btn-sm btn-primary"
                    type="button"
                    data-backdrop="static"
                    data-toggle="modal"
                    data-target="#editar"
                    data-type="view"
                    data-lnk="ajax/mercadopago_suscripcion-editar.html.php">
                <?php echo _('Nueva Suscripción') ?>
            </button>
        </div>
    </div>




</div>



<!-- SUSCRIPCIONES -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                    <h2><?php echo _('Suscripciones') ?></h2>
                    <div id="selTemplate" class="widget-toolbar" role="menu">
                    </div>
                </header>


                <div>

                    <div class="jarviswidget-editbox">
                    </div>

                    <div class="widget-body no-padding">

                        <table id="dt_basic"
                               class="table table-striped table-hover dataTable no-footer"
                               aria-describedby="dt_basic_info"
                               style="width: 100%;">
                            <thead>

                                <th data-priority="1"><?php echo _('Cliente ID') ?></th>
                                <th data-priority="1"><?php echo _('Subdominio') ?></th>
                                <th data-priority="1"><?php echo _('Plan') ?></th>
                                <th data-priority="1"><?php echo _('Plan ID') ?></th>

                                <th data-priority="1"><?php echo _('Estado') ?></th>
                                <th data-priority="1"><?php echo _('Descripción') ?></th>
                                <th data-priority="1"><?php echo _('Importe') ?></th>

                                <th data-priority="3"><?php echo _('Fecha De Inicio') ?></th>
                                <th data-priority="2"><?php echo _('Fecha De Próximo Pago') ?></th>

                                <th data-priority="3"><?php echo _('Fecha De Último Cobro') ?></th>
                                <th data-priority="3"><?php echo _('Importe De Último Cobro') ?></th>

                                <th data-priority="4"><?php echo _('Medio de Pago') ?></th>
                                <th data-priority="4"><?php echo _('Email Titular Del Pago') ?></th>

                                <th data-priority="31"><?php echo _('MP Plan ID') ?></th>
                                <th data-priority="31"><?php echo _('MP Suscripcion ID') ?></th>
                                <th data-priority="31"><?php echo _('Módulos y Permisos ID') ?></th>

                                <th data-priority="1"><?php echo _('Opciones') ?></th>

                            </thead>

                            <tbody class="addNoWrap">


                            <?php foreach ($T_Suscripciones as $key => $_suscripcion){ ?>

                                <tr <?php if ($_suscripcion->get_status('') == 'cancelled') echo "class='text-muted'"; ?>>

                                    <?php

                                    $_clienteID = $_suscripcion->getCliente();
                                    $_clienteSubdominio = isset($T_Clientes [$_clienteID]) ? $T_Clientes [$_clienteID]['cli_Subdominio'] : "";
                                    $_planID = $_suscripcion->getPlan();
                                    $_planNombre = isset($T_Planes [$_planID]) ? $T_Planes [$_planID]['plan_Nombre'] : "";

                                    ?>
                                    <!-- CLIENTE -->
                                    <td>
                                        <?php echo _($_clienteID);  ?>
                                    </td>
                                    <!-- SUBDOMINIO -->
                                    <td>
                                        <?php echo _($_clienteSubdominio);  ?>
                                    </td>
                                    <!-- PLAN -->
                                    <td>
                                        <?php echo _($_planNombre);  ?>
                                    </td>

                                    <!-- PLAN ID-->
                                    <td>
                                        <?php echo _($_planID);  ?>
                                    </td>

                                    <!-- ESTADO -->
                                    <td>
                                        <?php echo _($_suscripcion->get_status());  ?>
                                    </td>
                                    <!-- RAZÓN -->
                                    <td>
                                        <?php echo _($_suscripcion->get_reason());  ?>
                                    </td>
                                    <!-- PRECIO -->
                                    <td>
                                        <?php echo _($_suscripcion->get_precio());  ?>
                                    </td>

                                    <!-- FECHA DE INICIO RECURRENTE AUTOMÁTICA -->
                                    <td>
                                        <?php echo _($_suscripcion->get_auto_recurring_start_date());  ?>
                                    </td>
                                    <!-- FECHA DE PAGO SIGUIENTE -->
                                    <td>
                                        <?php echo _($_suscripcion->get_next_payment_date());  ?>
                                    </td>

                                    <!-- RESUMIDO LA ÚLTIMA FECHA CARGADA -->
                                    <td>
                                        <?php echo _($_suscripcion->get_summarized_last_charged_date());  ?>
                                    </td>
                                    <!-- RESUMIDO EL ÚLTIMO IMPORTE CARGADO -->
                                    <td>
                                        <?php echo _(number_format($_suscripcion->get_summarized_last_charged_amount(),2));  ?>
                                    </td>

                                    <!-- ID DEL MÉTODO DE PAGO -->
                                    <td>
                                        <?php echo _($_suscripcion->get_payment_method_id('AR'));  ?>
                                    </td>
                                    <!-- EMAIL PAGARIO -->
                                    <td>
                                        <?php echo _($_suscripcion->get_payer_email());  ?>
                                    </td>

                                    <!-- ID PREAPPROAL PLAN MERCADOLIBRE -->
                                    <td>
                                        <?php echo _($_suscripcion->get_preapproval_plan_id());  ?>
                                    </td>
                                    <!-- ID SUSCRIPCION MERCADOLIBRE -->
                                    <td>
                                        <?php echo _($_suscripcion->get_preapproval_id());  ?>
                                    </td>

                                    <!-- MODULOS Y PERMISOS ID -->
                                    <td>
                                        <?php echo _($_suscripcion->get_Modulos_Permisos_Id());  ?>
                                    </td>

                                    <!-- OPCIONES -->
                                    <td class="fc-button-group">

                                        <!-- REACTIVAR -->
                                        <button
                                                title           ="Activar Suscripción"
                                                class           ="btn btn-default btn-sm fa fa-play-circle fa-lg "
                                                type            ="button"
                                                style           ="<?php  if ($_suscripcion->get_status('') == 'authorized') echo 'display:none"'; ?>"
                                                data-backdrop   ="static"
                                            <?php           if (($_suscripcion->get_status('') ==  'cancelled')) echo 'disabled'; ?>
                                                onclick         ="Editar_Suscripcion('editar_status_suscripcion','authorized','<?php echo $_suscripcion->get_preapproval_id();  ?>','<?php echo $_suscripcion->get_application_id();  ?>')">
                                        </button>

                                        <!-- PAUSAR -->
                                        <button
                                                title           ="Pausar Suscripción"
                                                class           ="btn btn-default btn-sm fa fa-pause-circle fa-lg"
                                                type            ="button"
                                                style           ="<?php  if ($_suscripcion->get_status('') == 'paused' || $_suscripcion->get_status('') == 'cancelled') echo 'display:none"'; ?>"
                                                data-backdrop   ="static"
                                            <?php           if (($_suscripcion->get_status('') ==  'cancelled')) echo 'disabled'; ?>
                                                onclick         ="Editar_Suscripcion('editar_status_suscripcion','paused','<?php echo $_suscripcion->get_preapproval_id(); ?>','<?php echo $_suscripcion->get_application_id();  ?>')">
                                        </button>

                                        <!-- CANCELAR -->
                                        <button
                                                title           ="Cancelar Suscripción"
                                                class           ="btn btn-default btn-sm fa fa-close fa-lg"
                                                type            ="button"
                                                data-backdrop   ="static"
                                            <?php           if ($_suscripcion->get_status('') == 'cancelled') echo 'disabled'; ?>
                                                onclick         ="Editar_Suscripcion('editar_status_suscripcion','cancelled','<?php echo $_suscripcion->get_preapproval_id();  ?>','<?php echo $_suscripcion->get_application_id();  ?>')">
                                        </button>

                                        <!-- ELIMINAR -->
                                        <button
                                                title           ="Eliminar Suscripción"
                                                class           ="btn btn-default btn-sm fa fa-trash-o fa-lg"
                                                type            ="button"
                                                data-backdrop   ="static"
                                                <?php          // if ($_suscripcion->get_status('') != 'cancelled') echo 'disabled'; ?>
                                                onclick         ="Eliminar_Suscripcion('delete','<?php echo $_suscripcion->getId();  ?>')">
                                        </button>


                                        <!-- VER LISTA DE PAGOS -->
                                        <button data-toggle         ="modal"
                                                data-backdrop       ="static"
                                                data-target         ="#editar"
                                                data-type           ="getDetallePagoMercadoPago"
                                                data-lnk            = "ajax/listado-mini.html.php"
                                                data-preapproval_id ="<?php echo $_suscripcion->get_preapproval_id();  ?>"
                                                title               ="Ver Pagos"
                                                class               ="btn btn-default btn-sm fa fa-list fa-lg">
                                        </button>


                                    </td>


                                </tr>
                            <?php } ?>



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

<?php require_once APP_PATH . '/templates/edit-view_modal.html.php'; ?>


<script type="text/javascript">

    $("th td").each(function(){
        $(this).attr("colSpan", 6);
    });




    // PAGE
    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }



    <?php require_once APP_PATH . '/includes/data_tables_otros.js.php'; ?>


    // NUEVA SUSCRIPCION
    $(document).ready(function () {

        $('a[data-toggle=modal], button[data-toggle=modal]').click(function (e) {
            //e.stopPropagation();

            e.preventDefault();

            var data_id = '';
            var lnk = '';
            var view_type = '';
            var preapproval_id = '';
            var application_id = '';


            if (typeof $(this).data('id') !== 'undefined') {
                data_id = $(this).data('id');
            }
            if (typeof $(this).data('lnk') !== 'undefined') {
                lnk = $(this).data('lnk');
            }
            if (typeof $(this).data('type') !== 'undefined') {
                view_type = $(this).data('type');
            }

            if (typeof $(this).data('preapproval_id') !== 'undefined') {
                preapproval_id = $(this).data('preapproval_id');
            }
            if (typeof $(this).data('application_id') !== 'undefined') {
                application_id = $(this).data('application_id');
            }

            $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");

            $.ajax({
                cache: false,
                type: 'POST',
                url: lnk,
                data: {
                    tipo: view_type,
                    preapproval_id: preapproval_id,
                    application_id: application_id,
                    id: data_id
                },
                success: function (data) {
                    //     $('.modal-content').css({opacity: '0.0'}).html(data).delay(50).animate({opacity: '1.0'}, 300);

                    $('.modal-content').html(data).show('slow');
                }
            });
        });
    });

    // EDITAR SUSCRIPCION
    function Editar_Suscripcion(tipo, status, preapproval_id, application_id) {


        if (status != "cancelled"){
            $('#content').html('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Cargando...</h1>');
            $.ajax({
                type: "POST",
                url: "/ajax/mercadopago_suscripcion.html.php",
                data: {
                    tipo                : tipo,
                    preapproval_id      : preapproval_id,
                    status              : status,
                    application_id      : application_id
                },
                success: function (data, status) {
                    // RELOAD CONTENT
                    $('#content').css({opacity : '0.0'}).html(data).delay(50).animate({opacity : '1.0'}, 300);
                }
            });
        }
        else{
            ExistMsg = 0;

            $.SmartMessageBox({
                title: "Cancelar suscripción",
                content: "Está por cancelar su suscripción</br>Esta operación no se puede deshacer. ¿Desea continuar?",
                buttons: '[No][Si]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Si" || ButtonPressed === "Yes") {

                    $('#content').html('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Cargando...</h1>');
                    $.ajax({
                        type: "POST",
                        url: "/ajax/mercadopago_suscripcion.html.php",
                        data: {
                            tipo                : tipo,
                            preapproval_id      : preapproval_id,
                            status              : status,
                            application_id      : application_id
                        },
                        success: function (data, status) {
                            // RELOAD CONTENT
                            $('#content').css({opacity : '0.0'}).html(data).delay(50).animate({opacity : '1.0'}, 300);
                        }
                    });
                }
                else if (ButtonPressed === "No" || ButtonPressed === "Do not") {
                    SmartUnLoading();
                }
            });
        }



    }
    function Eliminar_Suscripcion(tipo, id) {

        $('#content').html('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Cargando...</h1>');
        $.ajax({
            type: "POST",
            url: "/ajax/mercadopago_suscripcion.html.php",
            data: {
                tipo                : tipo,
                id                  : id
            },
            success: function (data, status) {
                // RELOAD CONTENT
                $('#content').css({opacity : '0.0'}).html(data).delay(50).animate({opacity : '1.0'}, 300);
            }
        });


    }

</script>

<!-- MERCADO PAGO -->
<!DOCTYPE html>
<html>
<head>
    <title>Template Code - Transparent Payment</title>
    <meta charset="utf-8">
    <script src="https://sdk.mercadopago.com/js/v2"></script>

</head>
<body>

</body>
</html>
