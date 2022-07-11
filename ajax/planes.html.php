<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/planes.php'; ?>
<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- PAGE HEADER -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa-fw fa fa-star"></i>
            <?php echo _('Facturación') ?>
            <span>>
                <?php echo _('Planes') ?>
			</span>
        </h1>
    </div>


    <!-- ADD BUTTON -->
    <div class="col-xs-4 col-sm-5 col-md-5 col-lg-8" id="sparkscontainer">
        <div id="sparks">
            <button data-backdrop       ="static"
                    data-target         ="#editar"
                    data-type           ="view"
                    data-lnk            ="ajax/planes-editar.html.php"
                    title               ="Editar"
                    data-toggle         ="modal"
                    class               ="btn btn-sm btn-primary"
                    onclick             ="Edit_Plan(0)">
                <?php echo _('Agregar Plan') ?>
            </button>
        </div>
    </div>

</div>


<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">


        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                    <h2><?php echo _('Listado de Planes') ?></h2>

                </header>


                <div><!-- widget div-->

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox"><!-- This area used as dropdown edit box --></div>


                    <!-- widget content -->
                    <div class="widget-body no-padding">


                        <table id="dt_basic" class="table table-striped table-hover dataTable no-footer" aria-describedby="dt_basic_info" style="width: 100%;">

                            <!-- ENCABEZADO -->
                            <thead>
                                <tr>
                                    <?php

                                    $o_Listado_copy = $o_Listado;

                                    if (count($o_Listado_copy)){
                                        $o_Listado_copy = array_shift($o_Listado_copy);
                                    }

                                    foreach ($o_Listado_copy as $_itemID => $_item){ ?>
                                        <th>
                                            <?php echo $_itemID; ?>
                                        </th>
                                    <?php } ?>
                                    <th data-priority="1">
                                        Opciones
                                    </th>
                                </tr>
                            </thead>

                            <!-- TABLA -->
                            <tbody>
                            <?php foreach ($o_Listado as $itemID => $item){ ?>
                                <tr>
                                    <?php foreach ($item as $iID => $i){ ?>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                    <?php } ?>

                                    <td>

                                        <!-- EDITAR -->
                                        <button data-backdrop       ="static"
                                                data-target         ="#editar"
                                                data-type           ="view"
                                                data-lnk            ="ajax/planes-editar.html.php"
                                                data-id             ="<?php echo $item['plan_Id']; ?>"
                                                title               ="Editar"
                                                data-toggle         ="modal"
                                                class               ="btn btn-default btn-sm fa fa-edit fa-lg"
                                                onclick             ="Edit_Plan('<?php echo $item['plan_Id']; ?>')">
                                        </button>

                                        <!-- MODULOS Y PERMISOS -->
                                        <button data-backdrop       ="static"
                                                data-target         ="#editar"
                                                data-type           ="view"
                                                data-lnk            ="ajax/modulos_permisos-editar.html.php"
                                                data-id             ="<?php echo $item['plan_Modulos_Permisos_Id']; ?>"
                                                title               ="Modulos y Permisos"
                                                data-toggle         ="modal"
                                                class               ="btn btn-default btn-sm fa fa-list fa-lg"
                                                onclick             ="Edit_Modulos_Permisos('<?php echo $item['plan_Modulos_Permisos_Id']; ?>','<?php echo $item['plan_Id']; ?>')">
                                        </button>


                                        <!-- ELIMINAR -->
                                        <button
                                                title           ="Eliminar"
                                                class           ="btn btn-default btn-sm fa fa-trash fa-lg"
                                                type            ="button"
                                                data-backdrop   ="static"
                                                onclick         ="Eliminar_Plan('delete','<?php echo $item['plan_Id']; ?>','ajax/planes-editar.html.php')">
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
<!-- end widget grid -->


<?php require_once APP_PATH . '/templates/edit-view_modal.html.php'; ?>



<script type="text/javascript">

    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }


    <?php
    //INCLUYO el js de las datatables
    require_once APP_PATH . '/includes/data_tables.js.php';
    ?>


    $(document).ready(function () {

    });

    // ESTA FUNCIONA DEBE IR LUEGO DEL DOCUMENT READY, SINO NO SE CARGA EL MODAL
    function Edit_Plan(data_id) {

        $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'ajax/planes-editar.html.php',
            data: {
                tipo: 'view',
                id: data_id
            },
            success: function (data) {
                $('.modal-content').show().html(data);
            }
        });
    }

    function Edit_Modulos_Permisos(_mod_id,_plan_id) {

        $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'ajax/modulos_permisos-editar.html.php',
            data: {
                tipo: 'view',
                mod_id: _mod_id,
                plan_id: _plan_id
            },
            success: function (data) {
                console.log(_mod_id);
                console.log(_plan_id);
                $('.modal-content').show().html(data);
            }
        });
    }

    function Eliminar_Plan(view_type,data_id,url) {


        ExistMsg = 0;//por un error en el plugin smartmessagebox  http://myorange.ca/supportforum/question/smartmessagebox-not-working-after-page-reload-smartmsgboxcount-not-reset

        $.SmartMessageBox({
                title: "Eliminar Plan",
                content: "Está por eliminar el plan.</br>Esta operación no se puede deshacer. ¿Desea continuar?",
                buttons: '[No][Si]'

            },
            function (ButtonPressed) {

                if (ButtonPressed === "Si") {
                    SmartUnLoading();

                    $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");
                    $.ajax({
                        cache: false,
                        type: 'POST',
                        url: url,
                        data: {
                            tipo: view_type,
                            id: data_id
                        },
                        success: function (data) {
                            // PRINT CONSOLE
                            location.reload();
                        }
                    });
                }
                else if (ButtonPressed === "No") {
                    SmartUnLoading();
                }

            });
    }





</script>