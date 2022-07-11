<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/modulos_permisos.php'; ?>
<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- PAGE HEADER -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa-fw fa fa-star"></i>
            <?php echo _('Modulos y Permisos') ?>
            <span>>
                <?php echo _('Permisos de Uso') ?>
			</span>
        </h1>
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

                                        <!-- MODULOS Y PERMISOS -->
                                        <button data-backdrop       ="static"
                                                data-target         ="#editar"
                                                data-type           ="view"
                                                data-lnk            ="ajax/modulos_permisos-editar.html.php"
                                                data-id             ="<?php echo $item['mod_id']; ?>"
                                                title               ="Modulos y Permisos"
                                                data-toggle         ="modal"
                                                class               ="btn btn-default btn-sm fa fa-list fa-lg"
                                                onclick             ="Edit_Modulos_Permisos('<?php echo $item['mod_id']; ?>')">
                                        </button>

                                        <!-- TestSmallBox -->
                                        <button data-backdrop       ="static"
                                                title               ="SMALL BOX"
                                                class               ="btn btn-default btn-sm fa fa-list fa-lg"
                                                onclick             ="TestSmallBox('<?php echo $item['mod_id']; ?>')">
                                        </button>

                                        <!-- TestSmallBox -->
                                        <button data-backdrop       ="static"
                                                title               ="BIG BOX"
                                                class               ="btn btn-default btn-sm fa fa-list fa-lg"
                                                onclick             ="TestBigBox('<?php echo $item['mod_id']; ?>')">
                                        </button>

                                        <!-- TestSmallBox -->
                                        <button data-backdrop       ="static"
                                                title               ="SMART BOX"
                                                class               ="btn btn-default btn-sm fa fa-list fa-lg"
                                                onclick             ="TestSmartBox('<?php echo $item['mod_id']; ?>')">
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



    function Edit_Modulos_Permisos(_mod_id) {

        $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'ajax/modulos_permisos-editar.html.php',
            data: {
                tipo: 'view',
                mod_id: _mod_id
            },
            success: function (data) {
                console.log(_mod_id);
                $('.modal-content').show().html(data);
            }
        });
    }

    function TestSmallBox(persona) {
        $.smallBox({
            title: "Synced Successfully",
            content: " Data Synced Done",
            color: "#659265",
            iconSmall: "fa fa-check fa-2x fadeInRight animated",
            timeout: 4000
        });
        $.fn.size = function () {
        };
    };


    function TestBigBox(persona) {
        $.bigBox({
            title: "Huella Cargada!",
            content: "La huella ha sido cargada correctamente.</br><small>Este mensaje se cerrará automáticamente</small>",
            color: "#739E73",
            timeout: 6000,
            icon: "fa fa-check shake animated",
            sound: true
        });

        $.bigBox({
            title: "No se sincronizaron los datos!",
            content: "Algunos equipos no responden, los datos se sincronizarán automáticamente cuando los equipos vuelvan a conectarse.</br>",
            color: "#C46A69",
            timeout: 6000,
            icon: "fa fa-warning shake animated",
            sound: false
        })

        $.bigBox({
            title: "Enviando comando...",
            content: "El comando está siendo enviado al Equipo...",
            color: "#C79121",
            timeout: 30000,
            icon: "fa fa-refresh fa-spin",
            //number : "2"
            sound: false
        });
    };


    function TestSmartBox(persona) {
        $.SmartMessageBox({
            title: "Funcionalidad no disponible en su plan actual",
            content: "Suscribete para tener mas acceso.",
            buttons: '[Ver Planes][Deseo continuar sin suscribirme]'
        }, function (ButtonPressed) {

            switch (ButtonPressed){
                case "Ver Planes":
                    SmartUnLoading();
                    //loadURLwData('<?php //echo $Item_Name . 's' ?>', $('#content'), {tipo: view_type, id: data_id});
                    break;

                case "Deseo continuar sin suscribirme":
                    SmartUnLoading();
                    break;
            }


           }
        );
    };





</script>