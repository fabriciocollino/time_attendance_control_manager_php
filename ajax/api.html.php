<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>

<?php require_once(APP_PATH . '/libs/random/random.php'); ?>

<?php require_once APP_PATH . '/controllers/api_token.php'; ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-terminal"></i>
            <?php echo _('enPunto API') ?>
        </h1>
    </div>

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
                 data-widget-sortable="false" data-widget-fullscreenbutton="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-key"></i> </span>
                    <h2><?php echo _('API Key') ?></h2>
                </header>
                <!-- widget div-->
                <div role="content" class="widget-body">
                    <div class="row show-grid">
                        <div class="col-xs-6 col-sm-3 col-md-2">
                            <h5 class="grid-Hleft">Estado:</h5>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <h5 style="margin:0px;">
                                <small>
                                    <?php
                                    if (Config_L::p('api_enabled'))
                                        echo '<span class="label label-success" style="line-height: 23px;margin-left: 5px;">Activada</span>';
                                    else
                                        echo '<span class="label label-danger" style="line-height: 23px;margin-left: 5px;">Desactivada</span>';
                                    ?>
                                </small>
                            </h5>
                        </div>
                    </div>

                    <div class="row show-grid">
                        <div class="col-xs-6 col-sm-3 col-md-2">
                            <h5 class="grid-Hleft">API Key:</h5>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <h5 class="grid-Hright"><?php echo Config_L::p('api_key'); ?></h5>
                        </div>
                    </div>
                    <?php if (Config_L::p('api_enabled')) { ?>
                    <div class="row show-grid">
                        <div class="col-xs-6 col-sm-3 col-md-2">
                            <h5 class="grid-Hleft">Modo de Pruebas:</h5>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <h5 style="margin:0px;">
                                <small>
                                    <?php
                                    if (Config_L::p('api_test_mode'))
                                        echo '<span class="label label-danger" style="line-height: 23px;margin-left: 5px;">Activado</span><small><a style="position: relative;top: 1px;" href="#" onclick="event.preventDefault();loadURLwData(\'api\',$(\'#content\'),{tipo: \'test_mode_off\'});return;">  Desactivar</a></small>';
                                    else
                                        echo '<span class="label label-default" style="line-height: 23px;margin-left: 5px;">Desactivado</span><small><a style="position: relative;top: 1px;"  href="#" onclick="event.preventDefault();loadURLwData(\'api\',$(\'#content\'),{tipo: \'test_mode_on\'});return;">  Activar</a></small>';
                                    ?>

                                </small>

                            </h5>
                        </div>
                    </div>
                    <?php } ?>
                    <br>
                    <br>
                    <div class="row show-grid">
                        <div class="col-xs-6 col-sm-3 col-md-2">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <?php if (Config_L::p('api_enabled')) { ?>
                                <h5 class="grid-Hright"><a class="btn btn-default" href="#" onclick="event.preventDefault();loadURLwData('api',$('#content'),{tipo: 'regenerate'});return;">Re-Generar Key</a></h5>
                            <?php } else { ?>
                                <?php if (Config_L::p('api_key')=='') { ?>
                                    <h5 class="grid-Hright"><a class="btn btn-default" href="#" onclick="event.preventDefault();loadURLwData('api',$('#content'),{tipo: 'enable_and_generate'});return;">Activar y Generar Key</a></h5>
                                <?php } else { ?>
                                    <h5 class="grid-Hright"><a class="btn btn-default" href="#" onclick="event.preventDefault();loadURLwData('api',$('#content'),{tipo: 'enable'});return;">Activar API</a></h5>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>

                    <?php if (Config_L::p('api_enabled')) { ?>
                        <div class="row show-grid">
                            <div class="col-xs-6 col-sm-3 col-md-2">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <h5 class="grid-Hright"><a class="btn btn-default" href="#" onclick="event.preventDefault();loadURLwData('api',$('#content'),{tipo: 'disable'});return;">Desactivar API</a></h5>
                            </div>
                        </div>
                    <?php } ?>


                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- WIDGET END -->

    </div>
    <!-- end row -->
    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false" data-widget-fullscreenbutton="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-question"></i> </span>
                    <h2><?php echo _('API Docs') ?></h2>
                </header>
                <!-- widget div-->
                <div role="content" class="widget-body">

                    documentacion
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


    //esto asigna el ID al modal cada vez que se hace click en el boton
    $(document).ready(function () {

        //en esta pagina uso este metodo para bindear el click porque los botones son "cambiados/agregados" dinamicamente por el jquery mobile, despues de renderizar el dom. por eso la funcion click() no anda
        //$(document).on('click', 'a[data-toggle=modal], button[data-toggle=modal]', function (e) {
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
        });
    });


</script>

<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>

