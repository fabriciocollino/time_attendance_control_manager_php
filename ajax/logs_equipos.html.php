<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php'; ?>
<?php $Filtro_Form_Action = "ajax/" . basename(__FILE__); ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-refresh"></i>
            <?php echo _('Logs') ?>
            <span>>
                <?php echo _('Equipos') ?>
			</span>
        </h1>
    </div>
    <!-- end col -->


</div>
<!-- end row -->


<!-- widget grid -->
<section id="widget-grid" class="">

    <div class="row">

        <?php require_once APP_PATH . '/includes/widgets/widget_filtro_intervalos_equipos.html.php'; ?>

    </div>


    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-refresh"></i> </span>
                    <h2><?php echo _('Logs Equipos') ?></h2>

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
                                <th><?php echo _('Fecha') ?></th>
                                <th><?php echo _('Equipo') ?></th>
                                <th><?php echo _('Lector') ?></th>
                                <th><?php echo _('Dedo') ?></th>
                                <th><?php echo _('Persona') ?></th>
                                <th><?php echo _('Acción') ?></th>
                                <?php if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) { ?>
                                <th><?php echo _('Acciones') ?></th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!is_null($o_Listado)): ?>

                                <?php foreach ($o_Listado as $key => $item): /* @var $item Logs_Equipo_O */ ?>
                                    <tr>
                                        <td title="<?php echo $item->getId(); ?>"><?php echo $item->getFechaHora(Config_L::p('f_fecha_corta')); ?></td>
                                        <td><?php echo "<b>".$item->getEqId()."</b>";
                                            $eq = Equipo_L::obtenerPorId($item->getEqId());
                                            if (!is_null($eq)) echo " (" . $eq->getDetalle() . ")"; ?></td>
                                        <td><?php echo $item->getLector(); ?></td>
                                        <td title="<?php echo $item->getDedo(); ?>"><?php echo $item->getDedo_S(); ?></td>
                                        <td><?php echo "<b>".$item->getPerId()."</b>";
                                            $per = Persona_L::obtenerPorId($item->getPerId());
                                            if (!is_null($per)) echo " (" . $per->getNombreCompleto() . ")"; ?></td>
                                        <td><?php echo $item->getAccion(); ?></td>
                                        <?php if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) { ?>
                                        <td>
                                        <button title="<?php echo _('Eliminar') ?>" data-type="delete"
                                                data-id="<?php echo $item->getId(); ?>"
                                                class="btn btn-default btn-sm fa fa-trash-o fa-lg"
                                                style="line-height: .75em;"</button>
                                        </td>
                                        <?php } ?>
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



<script type="text/javascript">


    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }
    <?php
    //INCLUYO el js de las datatables
    require_once APP_PATH . '/includes/data_tables.js.php';
    ?>

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
            title: "Eliminar el Log",
            content: "Está por eliminar un Log.</br>Esta operación no se puede deshacer. Desea continuar?",
            buttons: '[No][Si]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Si") {
                //esto refresca la pagina
                SmartUnLoading();
                loadURLwData('logs_equipos', $('#content'), {tipo: view_type, id: data_id});
            }
            else if (ButtonPressed === "No") {
                SmartUnLoading();
            }

        });


    });


</script>


<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>

