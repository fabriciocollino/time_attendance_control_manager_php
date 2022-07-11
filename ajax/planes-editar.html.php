<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/planes.php'; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title"
        id="modalTitle"><?php if ($o_Plan == null) echo _("Agregar Plan"); else echo _("Editar Plan"); ?></h4>
</div>
<br class="modal-body" style="padding-top: 0;">

    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/planes.html.php' ?>?tipo=<?php if ($o_Plan->getId() == 0) echo "add"; else echo "edit&id=" . $o_Plan->getId(); ?>">

        <fieldset>
            <legend>Datos Generales</legend>
            <div class="row">
                <!-- NOMBRE -->
                <section class="col col-10" style="width: 100%">
                    Nombre
                    <label class="input">
                        <input type="text" name="nombre" id="nombre" placeholder="nombre">
                    </label>
                </section>

                <!-- DESCRIPCION -->
                <section class="col col-10" style="width: 100%">
                    Descripción
                    <label class="input">
                        <input type="text" name="descripcion" id="descripcion" placeholder="Descripción">
                    </label>
                </section>

                <!-- CARACTERISTICAS -->
                <section class="col col-10" style="width: 100%">
                    Características
                    <label class="textarea textarea-resizable">
                        <textarea rows="5" name="caracteristicas" id="caracteristicas" placeholder="Características"><?php echo stripcslashes($o_Plan->getCaracteristicas()); ?>
                        </textarea>
                    </label>
                </section>

                <!-- BACK URL -->
                <section class="col col-10" style="width: 100%">
                    Back Url
                    <label class="input">
                        <input type="text" name="back_url" id="back_url" placeholder="back_url">
                    </label>
                </section>

                <!-- ACTIVO -->
                <section class="col col-10" style="width: 100%">
                    Activo
                    <label class="select">
                        <select type="text" name="activo" id="activo">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        <i></i>
                    </label>
                </section>
            </div>
        </fieldset>

        <fieldset>
            <legend>Cobro</legend>
            <div class="row">
                <!-- TIPO DE FRECUENCIA -->
                <section class="col col-10" style="width: 100%">
                    Tipo de Frecuencia
                    <label class="select">
                        <select type="text" name="tipo_frecuencia" id="tipo_frecuencia" placeholder=" Tipo de Frecuencia" >
                            <option value="days">Diario</option>
                            <option value="months">Mensual</option>
                        </select>
                        <i></i>
                    </label>
                </section>

                <!-- FRECUENCIA -->
                <section class="col col-2">
                    Frecuencia
                    <label class="input">
                        <input type="number" name="frecuencia" id="frecuencia" placeholder="Frecuencia"  min="0" >
                    </label>
                </section>

                <!-- MONTO -->
                <section class="col col-10" style="width: 100%">
                    MONTO
                    <label class="input">
                        <input type="text" name="monto" id="monto" placeholder="Monto">
                    </label>
                </section>

                <!-- TIPO MONEDA -->
                <section class="col col-10" style="width: 100%">
                    Tipo Moneda
                    <label class="select">
                        <select type="text" name="tipo_moneda" id="tipo_moneda" placeholder="Tipo Moneda">
                            <option value="USD">USD</option>
                            <option value="ARS">ARS</option>
                        </select>
                        <i></i>
                    </label>
                </section>

                <!-- REPETICIONES -->
                <section class="col col-10" style="width: 100%">
                    Repeticiones ("0" para Ilimitada)
                    <label class="input">
                        <input type="number" name="repeticiones" id="repeticiones" placeholder="Repeticiones"  min="0" >
                    </label>
                </section>
            </div>
        </fieldset>

        <fieldset>
            <legend>Prueba Gratuita</legend>
            <div class="row">

                <!-- TIPO MONEDA -->
                <section class="col col-10" style="width: 100%">
                    Prueba Gratuita
                    <label class="select">
                        <select type="text" name="prueba_gratuita" id="prueba_gratuita" placeholder="Prueba Gratuita" >
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                        <i></i>
                    </label>
                </section>

            </div>


            <legend>IDs Externos</legend>
            </br>
            <div class="row">
                <!-- MERCADOPAGO PLAN ID -->
                <section class="col col-10" style="width: 100%" >
                    Mercado Pago Preapproval Plan Id
                    <label class="input">
                        <input type="text" name="mercadopago_plan_id" id="mercadopago_plan_id" placeholder="Mercado Pago Preapproval Plan Id" readonly>
                    </label>
                </section>

                <!-- MODULOS Y PERMISOS ID -->
                <section class="col col-10" style="width: 100%" >
                    MODULOS Y PERMISOS ID
                    <label class="input">
                        <input type="text" name="modulos_permisos_id" id="modulos_permisos_id" placeholder="Modulos y Permisos Id" readonly>
                    </label>
                </section>

            </div>

        </fieldset>

    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
    <button type="submit" class="btn btn-primary" id="submit-editar" data-dismiss="modal">
        Guardar
    </button>
</div>


<script type="text/javascript">


    $('#nombre').val("<?php echo $o_Plan->getNombre(); ?>");
    $('#descripcion').val("<?php echo $o_Plan->getDescripcion(); ?>");
    $('#back_url').val("<?php echo $o_Plan->getBackUrl(); ?>");
    $('#activo').val("<?php echo $o_Plan->getActivo(); ?>");
    $('#tipo_frecuencia').val("<?php echo $o_Plan->getTipoFrecuencia(); ?>");
    $('#frecuencia').val("<?php echo $o_Plan->getFrecuencia(); ?>");
    $('#monto').val("<?php echo $o_Plan->getMonto(); ?>");
    $('#tipo_moneda').val("<?php echo $o_Plan->getTipoMoneda(); ?>");
    $('#repeticiones').val("<?php echo $o_Plan->getRepeticiones(); ?>");
    $('#prueba_gratuita').val("<?php echo $o_Plan->getPruebaGratuita(); ?>");

    $('#mercadopago_plan_id').val("<?php echo $o_Plan->getMercadopagoPlanId(); ?>");
    $('#modulos_permisos_id').val("<?php echo $o_Plan->get_Modulos_Permisos_Id(); ?>");

    // ATRIBUTOS NO EDITABLES
    <?php if ($o_Plan->getId() == 0){  ?>
        $('#tipo_frecuencia').attr("disabled", true);
        $('#frecuencia').attr("disabled", true);
        $('#repeticiones').attr("disabled", true);
        $('#prueba_gratuita').attr("disabled", true);
    <?php  }   ?>

    $(document).ready(function () {

        $('#submit-editar').click(function () {
            var $form = $('#editar-form');

            if (!$('#editar-form').valid()) {
                return false;
            }
            else {


                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),

                    success: function (data, status) {
                       console.log('data',data);
                        console.log('status',status);
                        $('#content').css({opacity : '0.0'}).html(data).delay(50).animate({opacity : '1.0'}, 300);

                    }
                });
            }

        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $(window).keydown(function(event) {
            if ((event.keyCode == 13) && ($(event.target)[0] != $("textarea")[0])) {
                event.preventDefault();
                return false;
            }
        });



    });


</script>