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
            <?php echo _('Usuarios') ?>
            <span>>
                <?php echo _('Listado de Usuarios') ?>
			</span>
        </h1>
    </div>
    <!-- end col -->
    <div class="col-xs-4 col-sm-5 col-md-5 col-lg-8" id="sparkscontainer">
        <div id="sparks">
            <button class="btn btn-sm btn-primary" type="button" data-backdrop="static" data-toggle="modal"
                    data-target="#editar" data-type="view" data-lnk="ajax/<?= $Item_Name ?>-editar.html.php">
                <?php echo _('Agregar Usuario') ?>
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

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                    <h2><?php echo _('Listado de Usuarios') ?></h2>
                </header>

                <!-- widget div-->
                <div>

                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        <table id="dt_basic" class="table table-striped table-hover dataTable no-footer"
                               aria-describedby="dt_basic_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th data-priority="2"><?php echo _('Foto') ?></th>
                                <th data-priority="1"><?php echo _('Nombre') ?></th>
                                <th data-priority="2"><?php echo _('Tipo de Usuario') ?></th>
                                <th data-visible="false"><?php echo _('Teléfono') ?></th>
                                <th><?php echo _('Celular') ?></th>
                                <th data-priority="3"><?php echo _('E-mail') ?></th>
                                <th><?php echo _('Fecha de Alta') ?></th>
                                <th><?php echo _('Bloqueado') ?></th>
                                <th><?php echo _('Opciones') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!is_null($o_Listado)): ?>

                                <?php foreach ($o_Listado as $key => $item): ?>
                                    <tr>
                                        <td>
                                            <div class="smallImageThumb"><?php if ($item->getImagen() == '') {
                                                    echo '<img src="img/avatars/male-big.png" />';
                                                } else {
                                                    echo '<img src="imagen.php?usu_id=' . $item->getId() . '&size=25" />';
                                                } ?></div>
                                        </td>
                                        <td><?php echo $item->getNombre() . ' ' . $item->getApellido(); ?></td>
                                        <td><?php echo $item->getTipoUsuarioObject()->getDetalle(); ?></td>
                                        <td><?php echo $item->getTePersonal(); ?></td>
                                        <td><?php echo $item->getTeCelular(); ?></td>
                                        <td><?php echo $item->getEmail(); ?></td>
                                        <td><?php echo $item->getCreadoEl(Config_L::p('f_fecha_corta')); ?></td>
                                        <td><?php echo $item->getEliminadoEl(Config_L::p('f_fecha_corta')) . "&nbsp;"; ?></td>
                                        <td style="white-space: nowrap;">
                                            <?php if (is_null($item->getEliminadoEl())): ?>
                                                <button data-toggle="modal" data-backdrop="static" data-target="#editar"
                                                        data-type="view"
                                                        data-lnk="ajax/<?= $Item_Name ?>-editar.html.php"
                                                        data-id="<?php echo $item->getId(); ?>"
                                                        title="<?php echo _('Editar') ?>"
                                                        class="btn btn-default btn-sm fa fa-edit fa-lg"
                                                        style="line-height: .75em;"></button>
                                                <button title="<?php echo _('Bloquear') ?>"
                                                        class="btn btn-default btn-sm fa fa-lock fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="BloquearUsuario(<?php echo $item->getId(); ?>)"></button>
                                            <?php else: ?>
                                                <button title="<?php echo _('Des-Bloquear') ?>"
                                                        class="btn btn-default btn-sm fa fa-unlock fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="DesBloquearUsuario(<?php echo $item->getId(); ?>)"></button>
                                            <?php endif; ?>
                                            <?php if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) { ?>
                                            <button title="<?php echo _('Enviar Email') ?>"
                                                    class="btn btn-default btn-sm fa fa-envelope fa-lg"
                                                    style="line-height: .75em;"
                                                    onclick="enviarEmail(<?php echo $item->getId(); ?>)"></button>
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

<style>
    .modal-open .modal { outline: none; }
</style>

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


    function BloquearUsuario(Usuario) {
        loadURLwData('<?php echo $Item_Name ?>', $('#content'), {tipo: 'disable', id: Usuario});
    }

    function DesBloquearUsuario(Usuario) {

        loadURLwData('<?php echo $Item_Name ?>', $('#content'), {tipo: 'enable', id: Usuario});
    }

    <?php if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) { ?>
    function enviarEmail(Usuario) {

        loadURLwData('<?php echo $Item_Name ?>', $('#content'), {tipo: 'enviaremail', id: Usuario});
    }
    <?php } ?>


</script>

<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>

