<?php
/*
 * 
 * Para que este widget funcione, hay que asignar la variable $Filtro_Form_Action previamente
 */
?>


<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-51" data-widget-collapsed="true"
         data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false"
         data-widget-sortable="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-filter"></i> </span>
            <h2><?php echo _('Flitros') ?></h2>
        </header>
        <!-- widget div-->
        <div>
            <!-- widget content -->
            <div class="widget-body no-padding">
                <form class="smart-form" novalidate="novalidate" data-async="" method="post" id="filtro-form"
                      action="<?php echo $Filtro_Form_Action; ?>">
                    <fieldset>
                        <div class="row">
                            <section class="col col-1">
                            </section>
                            <section class="col col-2"  style="min-width: 215px;">
                                <label class="toggle" style="font-size:13px;">
                                    <input type="checkbox" id="pasados" name="pasados" <?php echo ($_SESSION['filtro']['pasados'] == 'on')?'checked="checked"':'' ?>>
                                    <i data-swchon-text="No" data-swchoff-text="Si"></i>Mostrar pasados
                                </label>
                            </section>
                        </div>
                    </fieldset>

                    <footer>
                        <button type="button" name="btnFiltro" id="submit-filtro" class="btn btn-primary">
                            Filtrar
                        </button>
                    </footer>

                    <?php echo (isset($T_Error['error'])) ? '<p class="error">' . htmlentities($T_Error['error'], ENT_COMPAT, 'utf-8') . '</p>' : ''; ?>

                    <script type="text/javascript">

                        $(document).ready(function () {

                            $('#submit-filtro').click(function () {
                                var $form = $('#filtro-form');

                                if (!$('#filtro-form').valid()) {
                                    return false;
                                } else {
                                    $('#content').html('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Cargando...</h1>');
                                    $.ajax({
                                        type: $form.attr('method'),
                                        url: $form.attr('action'),
                                        data: $form.serialize(),
                                        success: function (data, status) {

                                            $('#content').css({opacity: '0.0'}).html(data).delay(50).animate({opacity: '1.0'}, 300);
                                            $('#editar').off('hidden.bs.modal');

                                        }
                                    });
                                }
                            });
                            $('#filtro-form').bind("keyup keypress", function (e) {
                                var code = e.keyCode || e.which;
                                if (code == 13) {
                                    e.preventDefault();
                                    return false;
                                }
                            });


                        });
                    </script>
                </form>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->