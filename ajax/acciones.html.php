<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php'; ?>

<?php if (isset($T_Mensaje) && $T_Mensaje != null): ?>
    <div class="alert alert-success fade in">
        <button class="close" data-dismiss="alert">
            ×
        </button>
        <i class="fa-fw fa fa-check"></i>
        <strong>Éxito!</strong> <?= $T_Mensaje ?>
    </div>
<?php endif; ?>

<?php if (isset($T_Error) && $T_Error != null): ?>
    <div class="alert alert-danger fade in">
        <button class="close" data-dismiss="alert">
            ×
        </button>
        <i class="fa-fw fa fa-times"></i>
        <strong>Error!</strong> <?php if (is_array($T_Error)) print_r($T_Error); else echo $T_Error; ?>
    </div>
<?php endif; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-briefcase"></i>
            <?php echo _('Configuración') ?>
            <span>>
                <?php echo _('Acciones del Sistema') ?>
			</span>
        </h1>
    </div>
    <!-- end col -->


</div>
<!-- end row -->


<!-- widget grid -->
<section id="widget-grid" class="">
    <div class="row"><!-- row -->


        <!-- NEW WIDGET START -->
        <article class=" col-sm-1 col-md-1 col-lg-2"></article>
        <article class="col-xs-12 col-sm-10 col-md-10 col-lg-8">
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-123" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-briefcase"></i> </span>
                    <h2><?php echo _('Acciones del Sistema') ?></h2>
                </header>
                <div><!-- widget div-->
                    <div class="jarviswidget-editbox"></div><!-- end widget edit box -->
                    <div class="widget-body "><!-- widget content -->

<?php if($subdominio=='dev' || $subdominio=='tasm' || $subdominio=='demo'){ ?>
                        <div class="row">
                            <div class="col-xs-8 col-sm-7 col-md-6">
                                <h5 class="grid-Hleft"><?php echo _("Resetear Base de Datos") ?></h5>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-5">
                                <button data-type="accion" data-lnk="ajax/<?= $Item_Name ?>.html.php" data-id="resetear"
                                        title="<?php echo _('Resetear') ?>" class="btn btn-default btn-sm"
                                        style="line-height: .75em;"><?php echo _('Resetear') ?></button>
                            </div>
                        </div>
<?php } ?>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-xs-8 col-sm-7 col-md-6">
                                <h5 class="grid-Hleft"><?php echo _("Re-sincronizar Personas") ?></h5>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-5">
                                <button data-type="accion" data-lnk="ajax/<?= $Item_Name ?>.html.php" data-id="<?php ?>"
                                        title="<?php echo _('Re-Sincronizar') ?>" class="btn btn-default btn-sm"
                                        style="line-height: .75em;"><?php echo _('Re-Sincronizar') ?></button>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-xs-8 col-sm-7 col-md-6">
                                <h5 class="grid-Hleft"><?php echo _("Hacer copia de seguridad de la Base de Datos") ?></h5>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-5">
                                <button data-type="accion" data-lnk="ajax/<?= $Item_Name ?>.html.php" data-id="<?php ?>"
                                        title="<?php echo _('Exportar') ?>" class="btn btn-default btn-sm"
                                        style="line-height: .75em;"><?php echo _('Exportar') ?></button>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-xs-8 col-sm-7 col-md-6">
                                <h5 class="grid-Hleft"><?php echo _("Copias de seguridad de la Base de Datos") ?></h5>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-5">
                                <button data-type="accion" data-lnk="ajax/<?= $Item_Name ?>.html.php" data-id="<?php ?>"
                                        title="<?php echo _('Restaurar') ?>" class="btn btn-default btn-sm"
                                        style="line-height: .75em;"><?php echo _('Restaurar') ?></button>
                                <button data-type="accion" data-lnk="ajax/<?= $Item_Name ?>.html.php" data-id="<?php ?>"
                                        title="<?php echo _('Descargar') ?>" class="btn btn-default btn-sm"
                                        style="line-height: .75em;"><?php echo _('Descargar') ?></button>
                                <button data-type="accion" data-lnk="ajax/<?= $Item_Name ?>.html.php" data-id="<?php ?>"
                                        title="<?php echo _('Eliminar') ?>" class="btn btn-default btn-sm"
                                        style="line-height: .75em;"><?php echo _('Eliminar') ?></button>
                            </div>
                        </div>


                    </div><!-- end widget content -->
                </div><!-- end widget div -->
            </div><!-- end widget -->
        </article><!-- WIDGET END -->
    </div><!-- end row -->

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




    $(document).ready(function () {
        $('a[data-type=accion], button[data-type=accion]').click(function () {

            $.ajax({
                cache:false,
                type: 'post',
                url: $(this).data('lnk'),
                async: true,
                data: {tipo: 'accion', id: $(this).data('id')},
                success: function (data, status) {
                    $('#editar').modal('hide');
                    function refreshpage() {
                        $('#content').css({opacity: '0.0'}).html(data).delay(50).animate({opacity: '1.0'}, 300);
                    }

                    setTimeout(refreshpage, 200);
                }
            });


        });
    });


</script>


<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>


