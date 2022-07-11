<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/mercadopago_suscripcion.php'; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title"
        id="modalTitle"><?php if ($o_Suscripcion->getId() == 0) echo _("Agregar Plan"); else echo _("Editar Plan"); ?></h4>
</div>


<div class="modal-body" style="padding-top: 0;">

    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/mercadopago_suscripcion.html.php' ?>?tipo=<?php if ($o_Suscripcion->getId() == 0) echo "add"; else echo "edit&id=" . $o_Suscripcion->getId(); ?>">


        <fieldset>

            <!-- PLAN -->
            <legend>Seleccion de Plan</legend>

            <div class="row">

                <?php foreach ($T_Planes as $_itemKey => $_item)  {  ?>

                    <?php $o_Plan = new Planes_O(); $o_Plan->loadArray($_item); ?>

                    <div class="row">
                        <section class="col col-12" style="width: 100%">

                            <!-- DETALLE PLAN -->
                            <div class="col col-md-8">
                                <!-- NOMBRE -->
                                <h5><?php echo $o_Plan->getNombre(); ?></h5>
                                <!-- DETALLE -->
                                <div class="product-info">
                                    <p>
                                        <!-- DESCRIPCIÓN -->
                                        <b>Descripción: </b>
                                        <span>
                                            <?php echo $o_Plan->getDescripcion(); ?>
                                            <br>
                                        </span>

                                        <!-- CARACTERISTICAS -->
                                        <b>Características: </b>
                                        <span>
                                            <?php echo stripcslashes($o_Plan->getCaracteristicas()); ?>
                                            <br>
                                        </span>

                                        <!-- FRECUENCIA COBRO -->
                                        <b>Tipo de Suscripcion: </b>
                                        <span>
                                            <?php echo $o_Plan->getFrecuencia('AR'); ?>
                                            <br>
                                        </span>

                                        <!-- PRECIO -->
                                        <b>Precio:</b> $
                                        <span>
                                            <?php echo $o_Plan->getMonto() . " " . $o_Plan->getTipoMoneda(); ?>
                                            <br>
                                        </span>

                                        <!-- PERIODO DE PRUEBA -->
                                        <b>Periodo de Prueba:</b>
                                        <span>
                                            <?php echo $o_Plan->getPeriodoPrueba(); ?>
                                            <br>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <br><br><br>
                                <input type     ="radio"
                                       name     ="checkout-plan-radio"
                                       id       ="<?php echo 'checkout-plan-radio-'.$o_Plan->getId(); ?>"
                                       onchange ="updatePlanSelected('<?php echo $o_Plan->getId(); ?>')">
                            </div>
                        <section>
                    </div>

                <?php   } ?>

            </div>


            <!-- HIDDEN PLAN ID -->
            <input type="hidden" id="susc_Plan_Id" name="susc_Plan_Id"/>


            <!-- CLIENTE -->
            <legend>Seleccion de Cliente</legend>
            <br>
            <!-- SUBDOMINIO  -->
            <div class="row">

                <section class="col col-sm-6">
                    <label class = "select">
                        <span class = "icon-prepend fa fa-user"></span>
                        <select name = "susc_Cliente_Id" id = "susc_Cliente_Id" style = "padding-left: 32px;">
                            <?php echo HtmlHelper::array2htmloptions(Cliente_L::obtenerTodos(),0, true, true, 'Clientes_Subdominios', _('Seleccione un Subdominio')); ?>
                        </select> <i></i>
                    </label>
                </section>

            </div>

            <!-- PERIODO -->
            <legend>Seleccion de Periodo</legend>
            <br>
            <div class="row">

                <!-- FECHA DESDE -->
                <section class="col col-6">
                    <label class="select">Desde</label>
                    <div class="form-group">
                        <div class="input-group">
                            <input class        = "form-control "
                                   style        = "padding-left: 5px;font-size: 12px;height: 31px;"
                                   name         = "susc_Fecha_Desde"
                                   id           = "susc_Fecha_Desde"
                                   type         = "text"
                                   placeholder  = "Desde">
                            <span id="btnDesde_Editar" class="input-group-addon">
                                <i class="fa fa-calendar" style="cursor:pointer;line-height: 19px!important;padding-left: 5px;"></i>
                            </span>
                        </div>
                    </div>
                </section>

                <!-- FECHA HASTA -->
                <section class="col col-6">
                    <label class="select">Hasta</label>
                    <div class="form-group">
                        <div class="input-group">
                            <input class        = "form-control "
                                   style        = "padding-left: 5px;font-size: 12px;height: 31px;"
                                   name         = "susc_Fecha_Hasta"
                                   id           = "susc_Fecha_Hasta"
                                   type         = "text"
                                   placeholder  = "Hasta">
                            <span id="btnHasta_Editar" class="input-group-addon">
                                <i class="fa fa-calendar" style="cursor:pointer;line-height: 19px!important;padding-left: 5px;"></i>
                            </span>
                        </div>
                    </div>
                </section>



            </div>


        </fieldset>
    </form>
</div>

<!-- FOOTER -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
    <button type="submit" class="btn btn-primary" id="submit-editar" data-dismiss="modal">
        Guardar
    </button>
</div>


<script type="text/javascript">

    // DATETIME-PICKER
    $(function(){
        // FECHA DESDE
        $("#susc_Fecha_Desde").datetimepicker({
            locale: 'es',
            collapse: true,
            //sideBySide: true,
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        // FECHA HASTA
        $("#susc_Fecha_Hasta").datetimepicker({
            locale: 'es',
            collapse: true,
            //sideBySide: true,
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $("#susc_Fecha_Desde").change(function () {

            $("#susc_Fecha_Hasta").datetimepicker({
                minDate: $("#susc_Fecha_Desde").val()
            });

        });

        $("#susc_Fecha_Hasta").change(function () {

            $("#susc_Fecha_Desde").datetimepicker({
                maxDate: $("#susc_Fecha_Hasta").val()
            });

        });
    })

    // PLAN SELECCIONADO
    function updatePlanSelected(susc_Plan_Id) {
        document.getElementById("susc_Plan_Id").value   =   susc_Plan_Id;
    }

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

        $(window).keydown(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                return false;
            }
        });


    });


</script>
