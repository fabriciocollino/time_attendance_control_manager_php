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
                            <section class="col col-2" style="min-width: 180px;">
                                <label class="select">Fecha</label>
                                <label class="select"> <span class="icon-prepend fa fa-calendar"></span>
                                    <select name="intervaloFecha" id="selFecha" style="padding-left: 32px;">
                                        <?php echo HtmlHelper::array2htmloptions($IntervalosFechas, $T_Intervalo, false, false); ?>
                                    </select> <i></i> </label>
                            </section>
                            <div id="fechaPersonalizada">
                                <section class="col col-2" style="min-width: 195px;">
                                    <label class="select">Intervalo</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control "
                                                   style="padding-left: 5px;font-size: 12px;height: 31px;" name="fechaD"
                                                   id="fechaD" type="text" placeholder="Desde"
                                                   value="<?php echo $_SESSION['filtro']['fechaD']; ?>">
                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                               style="line-height: 19px!important;padding-left: 5px;"></i></span>
                                        </div>
                                    </div>
                                </section>
                                <section class="col col-2" style="min-width: 195px;">
                                    <label class="select">&nbsp;</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control "
                                                   style="padding-left: 5px;font-size: 12px;height: 31px;" name="fechaH"
                                                   id="fechaH" type="text" placeholder="Hasta"
                                                   value="<?php echo $_SESSION['filtro']['fechaH']; ?>">
                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                               style="line-height: 19px!important;padding-left: 5px;"></i></span>
                                        </div>
                                    </div>
                                </section>
                            </div>

                        </div>
                        <div class="row">
                            <section class="col col-1">
                            </section>
                            <section class="col col-2" style="min-width: 180px;">
                                <label class="select">Estado</label>
                                <label class="select"> <span class="icon-prepend fa fa-info"></span>
                                    <select name="equipoid" id="equipoid" style="padding-left: 32px;">
                                        <?php echo HtmlHelper::array2htmloptions(Equipo_L::obtenerTodos(), $_SESSION['filtro']['equipoid'], true, true,'Equipo','Todos los Equipos'); ?>
                                    </select> <i></i> </label>
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