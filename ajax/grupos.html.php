<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php'; ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-8 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-users"></i>
            <?php echo _('Personas') ?>
            <span>>
                <?php echo _('Grupos') ?>
			</span>
        </h1>
    </div>
    <!-- end col -->
    <?php if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 50) { ?>
        <div class="col-xs-4 col-sm-5 col-md-5 col-lg-8" id="sparkscontainer">
            <div id="sparks">
                <button class="btn btn-sm btn-primary" type="button" data-backdrop="static" data-toggle="modal"
                        data-target="#editar" data-type="view" data-lnk="ajax/<?= $Item_Name ?>-editar.html.php">
                    <?php echo _('Agregar Grupo') ?>
                </button>
            </div>
        </div>
    <?php } ?>


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
                    <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                    <h2><?php echo _('Listado de Grupos') ?></h2>

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

                        <table id="dt_basic" class="table table-striped table-hover dataTable no-footer col-12"
                               aria-describedby="dt_basic_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th data-priority="1" ><?php echo _('Nombre') ?></th>
                                <th data-priority="2" ><?php echo _('Personas') ?></th>
                                <th data-priority="2" ><?php echo _('En Vivo') ?></th>
                                <th data-priority="1" ><?php echo _('Opciones') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!is_null($o_Listado)): ?>

                                <?php foreach ($o_Listado as $key => $item): /* @var $item Grupo_O */ ?>
                                    <tr>
                                        <td><?php echo htmlentities($item->getDetalle(), ENT_QUOTES, 'utf-8'); ?> </td>
                                        <td><a data-toggle="modal" data-backdrop="static" data-target="#editar"
                                               data-type="view-filtro" data-lnk="ajax/personas-mini.html.php"
                                               title="<?php echo _('Ver Personas') ?>" data-filtro="1"
                                               data-grupo_id="<?php echo $item->getId(); ?>"
                                               class="aboton"><?php echo $item->getPersonasCount(); ?></a></td>
                                        <td><?php if ($item->getEnVivo() == 1) echo "Si"; else echo "No"; ?> </td>
                                        <td style="white-space: nowrap;">
                                            <?php if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 50) { ?>
                                                <button data-toggle="modal" data-backdrop="static" data-target="#editar"
                                                        data-type="personas" data-lnk="ajax/grupos-personas.html.php"
                                                        data-id="<?php echo $item->getId(); ?>"
                                                        title="<?php echo _('Agregar/Ver Personas') ?>"
                                                        class="btn btn-default btn-sm fa fa-user fa-lg"
                                                        style="line-height: .75em;"><i class="fa fa-plus fa-xs"></i>
                                                </button>
                                                <button data-toggle="modal" data-backdrop="static" data-target="#editar"
                                                        data-type="view" data-lnk="ajax/grupos-editar.html.php"
                                                        data-id="<?php echo $item->getId(); ?>"
                                                        title="<?php echo _('Editar Nombre') ?>"
                                                        class="btn btn-default btn-sm fa fa-edit fa-lg"
                                                        style="line-height: .75em;"></button>
                                                <button data-type="delete" data-id="<?php echo $item->getId(); ?>"
                                                        title="<?php echo _('Eliminar Grupo') ?>"
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
            var filtro = '';
            var grupo_id = '';
            if (typeof $(this).data('id') !== 'undefined') {
                data_id = $(this).data('id');
            }
            if (typeof $(this).data('lnk') !== 'undefined') {
                lnk = $(this).data('lnk');
            }
            if (typeof $(this).data('type') !== 'undefined') {
                view_type = $(this).data('type');
            }
            if (typeof $(this).data('filtro') !== 'undefined') {
                filtro = $(this).data('filtro');
            }
            if (typeof $(this).data('grupo_id') !== 'undefined') {
                grupo_id = $(this).data('grupo_id');
            }

            $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");
            $.ajax({
                cache: false,
                type: 'POST',
                url: lnk,
                data: {tipo: view_type, id: data_id, filtro: filtro, f_grupo_id: grupo_id},
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
                title: "Eliminar <?php echo $T_Titulo_Singular; ?>",
                content: "Está por eliminar <?php echo $T_Titulo_Pre; ?> <?php echo $T_Titulo_Singular; ?>. Esta operación no se puede deshacer. Desea continuar?",
                buttons: '[No][Si]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Si") {
                    //esto refresca la pagina
                    loadURLwData('<?php echo $Item_Name ?>', $('#content'), {tipo: view_type, id: data_id});
                }
                else if (ButtonPressed === "No") {
                    SmartUnLoading();

                }

            });


        });


    });


</script>

<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>

