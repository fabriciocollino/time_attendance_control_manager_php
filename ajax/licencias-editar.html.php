<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-editar.html.php') . '.php'; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title"
        id="modalTitle"><?php if ($o_Licencia->getId() == null) echo _("Agregar Licencia"); else echo _("Editar Licencia"); ?></h4>
</div>
<div class="modal-body" style="padding-top: 0px;">

    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/' . $Item_Name . 's.html.php' ?>?tipo=<?php if ($o_Licencia->getId() == null) echo "add"; else echo "edit&id=" . $o_Licencia->getId(); ?>">


        <fieldset>
            <legend>Datos Generales</legend>
            <div class="row">
                <section class="col col-10" style="width: 100%">
                    <label class="input"> <i class="icon-prepend fa fa-folder-o"></i>
                        <input type="text" name="motivo" placeholder="Motivo"
                               value="<?php echo htmlentities($o_Licencia->getMotivo(), ENT_COMPAT, 'utf-8'); ?>">
                    </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-6" id="selTipo">
                    <label class="select"> <span class="icon-prepend fa fa-calendar"></span>
                        <select name="selTipo" id="selTipo" style="padding-left: 32px;">
                            <?php echo HtmlHelper::array2htmloptions($a_Licencias_Tipos, $o_Licencia->getTipo(), true, false, '', 'Seleccione un Tipo'); ?>
                        </select> <i></i> </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-4">
                    <label class="toggle">
                        <input type="checkbox" id="enabled"
                               name="enabled" <?php if ($o_Licencia->getEnabled() == 1) echo "checked=\"yes\""; ?> >
                        <i data-swchon-text="SI" data-swchoff-text="NO"></i>Activa
                    </label>
                </section>
            </div>

        </fieldset>

        <fieldset>
            <legend>Personas</legend>
            <div class="row">
                <section class="col col-6">
                    <label class="select"> <span class="icon-prepend fa fa-user"></span>
                        <select name="persona" id="selPersona" style="padding-left: 32px;">
                            <?php echo HtmlHelper::array2htmloptions(Persona_L::obtenerTodos(0, 0, 0, 'per_Hor_Id <> 0'), $o_Licencia->getPerId(), false, true, 'PersonayGrupoLicencia'); ?>
                        </select> <i></i> </label>
                </section>
                <section class="col col-6" id="selRol">
                    <label class="select"> <span class="icon-prepend fa fa-users"></span>
                        <select name="grupo" id="selGrupo" style="padding-left: 32px;">
                            <?php echo HtmlHelper::array2htmloptions(Grupo_L::obtenerTodos(), $o_Licencia->getGrupoId(), true, true, '', _('Seleccione un Grupo')); ?>
                        </select> <i></i> </label>
                </section>
            </div>

        </fieldset>

        <fieldset>
            <legend>Período</legend>
            <div class="row">

                <div id="intervaloLlegadaTarde">
                    <section class="col col-6">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="icon-prepend fa fa-calendar"></span>
                                <input class="form-control " style="padding-left: 5px;font-size: 12px;height: 31px;"
                                       name="fechaLlegadaTarde" id="fechaLlegadaTarde" type="text" placeholder="Dia"
                                       value="<?php echo $o_Licencia->getFechaInicio(Config_L::p('f_fecha_corta')); ?>">
                                <span id="btnfechaLlegadaTarde" class="input-group-addon"><i class="fa fa-calendar"
                                                                                             style="cursor:pointer;line-height: 19px!important;padding-left: 5px;"></i></span>
                            </div>
                            <div id="DIVfechaLlegadaTarde"></div>
                        </div>
                    </section>
                    <section class="col col-6">
                        <label class="select"> <span class="icon-prepend fa fa-calendar"></span>
                            <select name="intervaloLlegadaTarde" id="selLlegadaTarde" style="padding-left: 32px;">
                                <?php echo HtmlHelper::array2htmloptions($IntervalosLlegadaTardeLicencias, $o_Licencia->getDuracionFilterString(), false, false); ?>
                            </select> <i></i> </label>
                    </section>
                    <div id="duracionLlegadaTarde">
                        <section class="col col-2">
                            <label class="input">
                                <input type="text" name="duracionLlegadaTarde" id="duracionLlegadaTarde" placeholder=""
                                       value="<?php echo $o_Licencia->getDuracionNumber(); ?>">
                            </label>
                        </section>
                        <section class="col col-4">
                            <label class="select">
                                <select name="intervaloDuracionLlegadaTarde">
                                    <?php echo HtmlHelper::array2htmloptions($SelectorMinutosHoras, $o_Licencia->getDuracionMHFilterString(), false, false); ?>
                                </select> <i></i> </label>
                        </section>
                    </div>
                </div>
                <div id="intervaloSalidaTemprano">
                    <section class="col col-6">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control " style="padding-left: 5px;font-size: 12px;height: 31px;"
                                       name="fechaSalidaTemprano" id="fechaSalidaTemprano" type="text" placeholder="Dia"
                                       value="<?php echo $o_Licencia->getFechaInicio(Config_L::p('f_fecha_corta')); ?>">
                                <span id="btnfechaSalidaTemprano" class="input-group-addon"><i class="fa fa-calendar"
                                                                                               style="cursor:pointer;line-height: 19px!important;padding-left: 5px;"></i></span>
                            </div>
                            <div id="DIVfechaSalidaTemprano"></div>
                        </div>
                    </section>
                    <section class="col col-6">
                        <label class="select"> <span class="icon-prepend fa fa-calendar"></span>
                            <select name="intervaloSalidaTemprano" id="selSalidaTemprano" style="padding-left: 32px;">
                                <?php echo HtmlHelper::array2htmloptions($IntervalosSalidaTempranoLicencias, $o_Licencia->getDuracionFilterString(), false, false); ?>
                            </select> <i></i> </label>
                    </section>
                    <div id="duracionSalidaTemprano">
                        <section class="col col-2">
                            <label class="input">
                                <input type="text" name="duracionSalidaTemprano" placeholder=""
                                       value="<?php echo $o_Licencia->getDuracionNumber(); ?>">
                            </label>
                        </section>
                        <section class="col col-4">
                            <label class="select">
                                <select name="intervaloDuracionSalidaTemprano">
                                    <?php echo HtmlHelper::array2htmloptions($SelectorMinutosHoras, $o_Licencia->getDuracionMHFilterString(), false, false); ?>
                                </select> <i></i> </label>
                        </section>
                    </div>
                </div>
                <div id="diaCompleto">
                    <section class="col col-6">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control " style="padding-left: 5px;font-size: 12px;height: 31px;"
                                       name="diaCompleto" id="fechaDiaCompleto" type="text" placeholder="Dia"
                                       value="<?php echo $o_Licencia->getFechaInicio(Config_L::p('f_fecha_corta')); ?>">
                                <span id="btndiaCompleto" class="input-group-addon"><i class="fa fa-calendar"
                                                                                       style="cursor:pointer;line-height: 19px!important;padding-left: 5px;"></i></span>
                            </div>
                            <div id="DIVfechaDiaCompleto"></div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div id="fechaPersonalizada">
                    <section class="col col-6">
                        <label class="select">Desde</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control " style="padding-left: 5px;font-size: 12px;height: 31px;"
                                       name="LfechaD" id="fechaD" type="text" placeholder="Desde"
                                       value="<?php echo $o_Licencia->getFechaInicio(Config_L::p('f_fecha_corta')); ?>">
                                <span id="btnDesde" class="input-group-addon"><i class="fa fa-calendar"
                                                                                 style="cursor:pointer;line-height: 19px!important;padding-left: 5px;"></i></span>
                            </div>
                            <div id="DIVfechaD"></div>
                        </div>
                    </section>
                    <section class="col col-6">
                        <label class="select">Hasta</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control " style="padding-left: 5px;font-size: 12px;height: 31px;"
                                       name="LfechaH" id="fechaH" type="text" placeholder="Hasta"
                                       value="<?php echo $o_Licencia->getFechaFin(Config_L::p('f_fecha_corta')); ?>">
                                <span id="btnHasta" class="input-group-addon"><i class="fa fa-calendar"
                                                                                 style="cursor:pointer;line-height: 19px!important;padding-left: 5px;"></i></span>
                            </div>
                            <div id="DIVfechaH"></div>
                        </div>
                    </section>
                </div>

            </div>


        </fieldset>


    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="submit-editar">
        <?php if ($o_Licencia->getId() == null) echo _("Agregar"); else echo _("Guardar"); ?>
    </button>
</div>


<script type="text/javascript">


    $(document).ready(function () {


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
        $('#selTipo').change(function () {
            if ($(this).find('option:selected').attr('value') == <?php echo LICENCIA_LLEGADA_TARDE; ?>) {
                $('#intervaloLlegadaTarde').show();
                $('#intervaloSalidaTemprano').hide();
                $('#diaCompleto').hide();
                $('#fechaPersonalizada').hide();
            } else if ($(this).find('option:selected').attr('value') == <?php echo LICENCIA_SALIDA_TEMPRANO; ?>) {
                $('#intervaloLlegadaTarde').hide();
                $('#intervaloSalidaTemprano').show();
                $('#diaCompleto').hide();
                $('#fechaPersonalizada').hide();
            } else if ($(this).find('option:selected').attr('value') == <?php echo LICENCIA_DIA_COMPLETO; ?>) {
                $('#intervaloLlegadaTarde').hide();
                $('#intervaloSalidaTemprano').hide();
                $('#diaCompleto').show();
                $('#fechaPersonalizada').hide();
            } else if ($(this).find('option:selected').attr('value') == <?php echo LICENCIA_PERSONALIZADA; ?>) {
                $('#intervaloLlegadaTarde').hide();
                $('#intervaloSalidaTemprano').hide();
                $('#diaCompleto').hide();
                $('#fechaPersonalizada').show();
            } else {//seleccione un tipo
                $('#intervaloLlegadaTarde').hide();
                $('#intervaloSalidaTemprano').hide();
                $('#diaCompleto').hide();
                $('#fechaPersonalizada').hide();
            }
        });
        $('#selLlegadaTarde').change(function () {
            if ($(this).find('option:selected').attr('value') == 'F_Personalizado') {
                $('#duracionLlegadaTarde').show();
            } else {
                $('#duracionLlegadaTarde').hide();
            }
        });
        $('#selSalidaTemprano').change(function () {
            if ($(this).find('option:selected').attr('value') == 'F_Personalizado') {
                $('#duracionSalidaTemprano').show();
            } else {
                $('#duracionSalidaTemprano').hide();
            }
        });


        $('#selFecha').trigger("change");
        $('#selPersona').trigger("change");
        $('#selTipo').trigger("change");
        $('#selLlegadaTarde').trigger("change");
        $('#selSalidaTemprano').trigger("change");
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

        $("#fechaDiaCompleto").datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "yy-mm-dd 00:00:00",
            changeYear: true,
            numberOfMonths: 1,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>'
        });
        $("#fechaLlegadaTarde").datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "yy-mm-dd 00:00:00",
            changeYear: true,
            numberOfMonths: 1,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>'
        });
        $("#fechaSalidaTemprano").datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "yy-mm-dd 00:00:00",
            changeYear: true,
            numberOfMonths: 1,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>'
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

        $('#btnfechaLlegadaTarde').click(function () {
            $(document).ready(function () {
                $("#fechaLlegadaTarde").datepicker().focus();
            });
        });
        $('#btnfechaSalidaTemprano').click(function () {
            $(document).ready(function () {
                $("#fechaSalidaTemprano").datepicker().focus();
            });
        });
        $('#btndiaCompleto').click(function () {
            $(document).ready(function () {
                $("#fechaDiaCompelto").datepicker().focus();
            });
        });

        $(function () {
            // Validation


            $("#editar-form").validate({
                // Rules for form validation
                rules: {
                    motivo: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    persona: {
                        required: true
                    },
                    grupo: {
                        required: "#selGrupo:visible"
                    },
                    selTipo: {
                        required: true
                    },
                    fechaLlegadaTarde: {
                        required: "#fechaLlegadaTarde:visible"
                    },
                    fechaSalidaTemprano: {
                        required: "#fechaSalidaTemprano:visible"
                    },
                    duracionLlegadaTarde: {
                        required: "#duracionLlegadaTarde:visible"
                    },
                    duracionSalidaTemprano: {
                        required: "#duracionSalidaTemprano:visible"
                    },
                    diaCompleto: {
                        required: "#fechaDiaCompleto:visible"
                    },
                    LfechaD: {
                        required: "#fechaD:visible"
                    },
                    LfechaH: {
                        required: "#fechaH:visible"
                    }
                },
                // Messages for form validation
                messages: {
                    motivo: {
                        required: '<?php echo _('Por favor ingrese el motivo de la licencia') ?>',
                        minlength: '<?php echo _('El motivo es muy corto') ?>',
                        maxlength: '<?php echo _('El motivo es muy largo') ?>'
                    },
                    persona: {
                        required: "Por favor seleccione un item"
                    },
                    grupo: {
                        required: "Seleccione un grupo"
                    },
                    selTipo: {
                        required: "Seleccione un tipo"
                    },
                    fechaLlegadaTarde: {
                        required: "Seleccione una fecha"
                    },
                    fechaSalidaTemprano: {
                        required: "Seleccione una fecha"
                    },
                    duracionLlegadaTarde: {
                        required: "Seleccione una duración"
                    },
                    duracionSalidaTemprano: {
                        required: "Seleccione una duración"
                    },
                    diaCompleto: {
                        required: "Seleccione un día"
                    },
                    LfechaD: {
                        required: "Seleccione una fecha"
                    },
                    LfechaH: {
                        required: "Seleccione una fecha"
                    }
                },
                // Do not change code below
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "fechaLlegadaTarde") {
                        error.insertAfter("#DIVfechaLlegadaTarde");
                    }
                    else if (element.attr("name") == "fechaSalidaTemprano") {
                        error.insertAfter("#DIVfechaSalidaTemprano");
                    }
                    else if (element.attr("name") == "diaCompleto") {
                        error.insertAfter("#DIVfechaDiaCompleto");
                    }
                    else if (element.attr("name") == "LfechaD") {
                        error.insertAfter("#DIVfechaD");
                    }
                    else if (element.attr("name") == "LfechaH") {
                        error.insertAfter("#DIVfechaH");
                    }
                    else {
                        error.insertAfter(element);
                    }

                }
            });
        });


        $('#submit-editar').click(function () {
            var $form = $('#editar-form');

            if (!$('#editar-form').valid()) {
                return false;
            } else {

                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),

                    success: function (data, status) {
                        $('#editar').modal('hide');
                        function refreshpage() {
                            $('#content').css({opacity: '0.0'}).html(data).delay(50).animate({opacity: '1.0'}, 300);
                            $('body').removeData('bs.modal');

                        }
                        setTimeout(refreshpage, 200);
                    }
                });
            }

        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });


        $(window).keydown(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                return false;
            }
        });


    })
    ;


</script>