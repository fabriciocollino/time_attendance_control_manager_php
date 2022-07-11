<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>

<?php require_once(APP_PATH . '/libs/random/random.php'); ?>
<?php require_once APP_PATH . '/controllers/subir_logs.php'; ?>
<?php //require_once APP_PATH . '/controllers/obtener_huellas.php'; ?>
<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>

<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-terminal"></i>
            <?php echo _('subir logs') ?>
        </h1>
    </div>

</div>
<!-- end row -->

<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-50" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" >
        <header>
            <span class="widget-icon"> <i class="fa fa-filter"></i> </span>
            <h2><?php echo _('Subir logs de un equipo - Pub Sub simulation') ?></h2>
        </header>
        <!-- widget div-->
        <div>
            <!-- widget content -->
            <div class="widget-body no-padding">

                <form class="smart-form" novalidate="novalidate" data-async="" method="post" id="filtro-form" >

                    <fieldset>
                        <div class="row">

                            <section class="col col-6">
                                <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                    <input type="text" name="equuid" id="equuid" placeholder="equuid" value="<?php echo $T_eqUUID ;?>">
                                </label>
                            </section>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="row">
                            <section class="col col-6">
                                <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                    <input type="text" name="subdom" id="subdom" placeholder="subdom" value="<?php echo $T_SubDominio ;?>">
                                </label>
                            </section>
                        </div>
                    </fieldset>


                    <fieldset>
                        <div class="row">
                            <section class="col col-12">
                                <label class="textarea textarea-resizable"> <i class="icon-prepend fa fa-envelope"></i>
                                    <textarea name="devicelogs" rows="10" id="devicelogs" placeholder="devicelogs" style="width: 600px;"><?php echo $T_Logs ;?></textarea>
                                </label>
                            </section>
                        </div>
                    </fieldset>


                    <footer>
                        <button type="button" name="submit-editar" id="submit-editar" class="btn btn-primary">
                            subir
                        </button>
                    </footer>


                    <script type="text/javascript">

                        $(document).ready(function () {


                            $('#submit-editar').click(function(){

                                var $form = $('#filtro-form');

                                console.log( $form.serialize());


                                $.ajax({
                                    type: "POST",
                                    url: "ajax/subir_logs.html.php",
                                    data: $form.serialize(),

                                    success: function (data, status) {

                                        function refreshpage() {
                                            $('#content').css({opacity: '0.0'}).html(data).delay(50).animate({opacity: '1.0'}, 300);
                                        }

                                        setTimeout(refreshpage, 200);

                                        console.log("LLEGO!")
                                    }

                                });

                            });



                            $(window).keydown(function (event) {
                                if (event.keyCode === 13) {
                                    event.preventDefault();
                                    return false;
                                }
                            });


                        });




                    </script>

                </form>
                <!-- end widget div -->
            </div>
        </div>
            <!-- end widget -->
</article>
<!-- WIDGET END -->

