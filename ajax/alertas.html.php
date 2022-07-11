<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php $alertaOreporte = 'alerta'; ?>
<?php require_once APP_PATH . '/controllers/' . 'notificaciones' . '.php'; ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-8 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-bullhorn"></i>
            <?php echo _('Notificaciones') ?>
            <span>>
                <?php echo _('Alertas') ?>
			</span>
        </h1>
    </div>
    <!-- end col -->
    <div class="col-xs-4 col-sm-5 col-md-5 col-lg-8" id="sparkscontainer">
        <div id="sparks">
            <button class="btn btn-sm btn-primary" type="button" data-backdrop="static" data-toggle="modal"
                    data-target="#editar" data-type="view" data-lnk="ajax/alertas-editar.html.php">
                <?php echo _('Agregar Alerta') ?>
            </button>
        </div>
    </div>


</div>
<!-- end row -->


<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-bullhorn"></i> </span>
                    <h2><?php echo _('Listado de Notificaciones') ?></h2>

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
                        <div class="widget-body-toolbar">

                        </div>
                        <table id="dt_basic" class="table table-striped table-hover dataTable no-footer"
                               aria-describedby="dt_basic_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th><?php echo _('Nombre') ?></th>
                                <th><?php echo _('Tipo') ?></th>
                                <th><?php echo _('Grupo') ?></th>
                                <th><?php echo _('Disparador') ?></th>
                                <th><?php echo _('Acciones') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!is_null($o_Listado)): ?>

                                <?php foreach ($o_Listado as $key => $item): /* @var $item Notificaciones_O */ ?>
                                    <tr<?php if (($key % 2) != 0): echo ' class="bg"'; endif; ?>>
                                        <td><?php echo $item->getDetalle(); ?></td>
                                        <td><?php echo $item->getTipo_S(); ?></td>
                                        <?php /*
                                        <td>
                                            <a href="not_grupos.php?Tipo=Add&amp;id=<?php echo $item->getGrupo(); ?>"><?php echo $item->getGrupo_SC(); ?></a>
                                        </td>
                                        */ ?>
                                        <td><?php echo $item->getGrupo_SC(); ?></td>
                                        <td><?php echo $Notificaciones_Disparadores[$item->getDisparador()]; ?> </td>
                                        <td>
                                            <button data-toggle="modal" data-backdrop="static" data-target="#editar"
                                                    data-type="view" data-lnk="ajax/alertas-editar.html.php"
                                                    data-id="<?php echo $item->getId(); ?>"
                                                    title="<?php echo _('Editar Alerta') ?>"
                                                    class="btn btn-default btn-sm fa fa-edit fa-lg"
                                                    style="line-height: .75em;"></button>
                                            <button title="<?php echo _('Enviar Alerta') ?>"
                                                    class="btn btn-default btn-sm fa fa-send fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="enviarNotificacion(<?php echo $item->getId(); ?>)"></button>
                                            <button data-type="delete" data-id="<?php echo $item->getId(); ?>"
                                                    title="<?php echo _('Eliminar Alerta') ?>"
                                                    class="btn btn-default btn-sm fa fa-trash-o fa-lg"
                                                    style="line-height: .75em;"></button>
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


    // load clockpicker script
    loadScript("js/plugin/clockpicker/clockpicker.min.js");


    function enviarNotificacion(not_id) {

        loadURLwData('alertas', $('#content'), {tipo: 'send', id: not_id});

        /*
         $.ajax({
         cache: false,
         type: 'POST',
         url: 'codigo/controllers/notificaciones.php',
         data: {tipo: 'send', id: not_id},
         success: function (data, status) {

         }
         });
         */
    }

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
                title: "Eliminar Alertas",
                content: "Está por eliminar la Alerta</br>Esta operación no se puede deshacer. Desea continuar?",
                buttons: '[No][Si]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Si") {
                    //esto refresca la pagina
                    loadURLwData('alertas', $('#content'), {tipo: view_type, id: data_id});
                }
                else if (ButtonPressed === "No") {
                    SmartUnLoading();
                }

            });
        });


    });


</script>


<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>
