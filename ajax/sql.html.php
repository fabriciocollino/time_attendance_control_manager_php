<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>

<?php require_once(APP_PATH . '/libs/random/random.php'); ?>

<?php require_once APP_PATH . '/controllers/sql.php'; ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-terminal"></i>
            <?php echo _('SQL') ?>
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
                    <h2><?php echo _('SQL on ALL DBs') ?></h2>
                </header>
                <!-- widget div-->
                <div role="content" class="widget-body">
                    <div class="row show-grid">
                        <section class="col col-10" style="width: 100%" id="trMensajec">
                            <label class="textarea textarea-resizable"> <i class="icon-prepend fa fa-envelope"></i>
                                <textarea id="sqlquery" rows="3" placeholder="SQL" style="width: 600px;"></textarea>
                            </label>
                        </section>
                    </div>

                    <div class="row show-grid">
                        <button class="btn btn-sm btn-primary " type="button" id="runquery"
                                onclick="event.preventDefault();loadURLwData('sql',$('#content'),{tipo: 'run',sqlquery: $('#sqlquery').val()});return;">
                            <?php echo _('RUN') ?>
                        </button>
                    </div>



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

