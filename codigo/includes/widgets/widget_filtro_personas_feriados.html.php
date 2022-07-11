<?php
/*
 * 
 * Para que este widget funcione, hay que asignar la variable $Filtro_Form_Action previamente
 */


?>


<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-50" data-widget-editbutton="false"
         data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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
                            <section class="col col-4">
                                <label class="select">Persona</label>
                                <label class="select"> <span class="icon-prepend fa fa-user"></span>
                                    <select name="persona" id="selPersona" style="padding-left: 32px;">
                                        <?php echo HtmlHelper::array2htmloptions(Persona_L::obtenerTodos(0, 0, 0, 'per_Hor_Id <> 0'), $_SESSION['filtro']['persona'], true, true, 'PersonayRol', _('Todas las Personas')); ?>
                                    </select> <i></i> </label>
                            </section>
                            <section class="col col-4" id="selRol">
                                <label class="select">Grupo</label>
                                <label class="select"> <span class="icon-prepend fa fa-user"></span>
                                    <select name="rolF" style="padding-left: 32px;">
                                        <?php echo HtmlHelper::array2htmloptions(Grupo_L::obtenerTodos(), $_SESSION['filtro']['rolF'], true, true, '', _('Seleccione un Grupo')); ?>
                                    </select> <i></i> </label>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-1">
                            </section>
                            <section class="col col-2" style="min-width: 180px;">
                                <label class="select">Feriado</label>
                                <label class="select"> <span class="icon-prepend fa fa-calendar"></span>
                                    <select name="selFeriado" id="selFeriado" style="padding-left: 32px;">
                                        <?php echo HtmlHelper::array2htmloptions(Feriado_L::obtenerTodos(), $_SESSION['filtro']['feriado'], true, true, '',"Seleccione un Feriado"); ?>
                                    </select> <i></i> </label>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-1">
                            </section>
                            <section class="col col-2" style="min-width: 215px;">
                                <label class="toggle" style="font-size:13px;">
                                    <input type="checkbox" id="bloqueado"
                                           name="bloqueados" <?php echo ($_SESSION['filtro']['bloqueados'] == 'on') ? 'checked="checked"' : '' ?>>
                                    <i data-swchon-text="Si" data-swchoff-text="No"></i>Listar bloqueados
                                </label>
                            </section>
                        </div>
                    </fieldset>

                    <footer>
                        <button type="button" name="btnFiltro" id="submit-filtro" class="btn btn-primary">
                            Filtrar
                        </button>
                    </footer>

                    <?php echo (isset ($T_Error['error'])) ? '<p class="error">' . htmlentities($T_Error['error'], ENT_COMPAT, 'utf-8') . '</p>' : ''; ?>

                    <script type="text/javascript">

                        $('#selFecha').change(function () {
                            if ($(this).find('option:selected').attr('value') === 'F_Personalizado') {
                                $('#fechaPersonalizada').show();
                                <?php /*	$('#Fechas').hide(); */ ?>
                            } else {
                                $('#fechaPersonalizada').hide();
                                <?php /*	$('#Fechas').show(); */ ?>
                            }

                        });
                        $('#selPersona').change(function () {
                            if ($(this).find('option:selected').attr('value') == 'SelectRol') {
                                $('#selRol').show();
                            } else {
                                $('#selRol').hide();
                            }

                        });
                        $('#selFecha').trigger("change");
                        $('#selPersona').trigger("change");
                        // Date Range Picker
                        $("#fechaD").datepicker({
                            //defaultDate: "+1w",
                            changeMonth: true,
                            dateFormat: "yy-mm-dd 00:00:00",
                            changeYear: true,
                            numberOfMonths: 1,
                            prevText: '<i class="fa fa-chevron-left"></i>',
                            nextText: '<i class="fa fa-chevron-right"></i>',
                            onClose: function (selectedDate) {
                                $("#fechaH").datepicker("option", "minDate", selectedDate);
                            }

                        });
                        $("#fechaH").datepicker({
                            //defaultDate: "+1w",
                            changeMonth: true,
                            dateFormat: "yy-mm-dd 00:00:00",
                            changeYear: true,
                            numberOfMonths: 1,
                            prevText: '<i class="fa fa-chevron-left"></i>',
                            nextText: '<i class="fa fa-chevron-right"></i>',
                            onClose: function (selectedDate) {
                                $("#fechaD").datepicker("option", "maxDate", selectedDate);
                            }
                        });

                        $('#btnDesde').click(function () {
                            $(document).ready(function () {
                                $("#fechaD").datepicker().focus();
                            });
                        });
                        $('#btnHasta').click(function () {
                            $(document).ready(function () {
                                $("#fechaH").datepicker().focus();
                            });
                        });


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