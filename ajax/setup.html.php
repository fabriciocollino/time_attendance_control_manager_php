<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php'; ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row" style="height: 50px;">



</div>
<!-- end row -->

<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 .col-lg-offset-3">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-hdd"></i> </span>
                    <h2><?php echo _('Agregar Equipo') ?></h2>

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
                        <?php if(isset($T_IngreseNombre) && $T_IngreseNombre == true) { ?>
                            <form class="smart-form" novalidate="novalidate" data-async method="post" id="add-form">
                                <input type="hidden" id="key" name="key" value="<?php echo $T_Key; ?>">
                                <fieldset>
                                    <legend>Ingresa un nombre para identificar el equipo</legend>
                                    <div class="row">
                                        <section class="col col-10" style="width: 100%;">
                                            <label class="input"> <i class="icon-prepend fa fa-hdd-o"></i>
                                                <input type="text" id="detalle" name="detalle" placeholder="Nombre del Equipo" value="">
                                            </label>
                                        </section>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="row" style="text-align: right">
                                <button type="submit" class="btn btn-primary" data-dismiss="modal" id="submit-save" style="margin:15px;margin-right: 25px;">
                                    Guardar
                                </button>
                            </div>
                        <?php }else{ ?>
                            <form class="smart-form" novalidate="novalidate" data-async method="post" id="add-form">
                                <fieldset>
                                    <legend>Ingresa el código que aparece en la pantalla del equipo</legend>
                                    <div class="row">
                                        <section class="col col-10" style="width: 100%;">
                                            <label class="input"> <i class="icon-prepend fa fa-key"></i>
                                                <input type="text" id="key" placeholder="XXX XXX  (Código identificador)" value="" data-mask="999 999">
                                            </label>
                                        </section>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="row" style="text-align: right">
                                <button type="submit" class="btn btn-primary" data-dismiss="modal" id="submit-add" style="margin:15px;margin-right: 25px;">
                                    Verificar
                                </button>
                            </div>
                        <?php } ?>

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


    $(document).ready(function () {
        $('#submit-add').click(function () {
            loadURLwData('setup', $('#content'), {tipo: 'verify-add', key: $('#key').val()});
        });
        $('#submit-save').click(function () {
            loadURLwData('setup', $('#content'), {tipo: 'add', key: $('#key').val(),detalle:$('#detalle').val()});
        });
    });


</script>


<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>
