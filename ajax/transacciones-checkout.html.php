<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/transacciones.php'; ?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="modalTitle">Checkout</h4>
</div>
<div class="modal-body" style="padding-top: 0px;">


    <div class="row padding-10">
        <br>
        <div class="col-sm-7">
            <h4 class="semi-bold"><?php echo htmlentities(Config_L::p('empresa_nombre'), ENT_COMPAT, 'utf-8'); ?></h4>
            <address>
                <strong><?php echo htmlentities(Config_L::p('empresa_direccion'), ENT_COMPAT, 'utf-8'); ?></strong>
                <br>
                <?php echo htmlentities(Config_L::p('empresa_localidad'), ENT_COMPAT, 'utf-8'); ?>, <?php echo htmlentities(Config_L::p('empresa_provincia'), ENT_COMPAT, 'utf-8'); ?> <?php echo htmlentities(Config_L::p('empresa_codigo_postal'), ENT_COMPAT, 'utf-8'); ?>
                <br>
                <abbr title="Teléfono">T:</abbr> <?php echo htmlentities(Config_L::p('empresa_telefono'), ENT_COMPAT, 'utf-8'); ?>
                <br>
                <abbr title="Email">E:</abbr> <?php echo htmlentities(Config_L::p('empresa_email'), ENT_COMPAT, 'utf-8'); ?>
            </address>
        </div>
        <div class="col-sm-5">
            <div>
                <div>
                    <strong>FACTURA #:</strong><span class="pull-right"><?php echo str_pad($o_Transaccion->getId(), 5, '0', STR_PAD_LEFT); ?></span>
                </div>
            </div>
            <div>
                <div class="font-md">
                    <strong>FECHA:</strong><span class="pull-right"> <i class="fa fa-calendar"></i> <?php echo $o_Transaccion->getFecha('d-m-Y'); ?></span>
                </div>
            </div>
            <div>
                <div class="font-md">
                    <strong>VTO:</strong><span class="pull-right"> <i class="fa fa-calendar"></i> <?php echo $o_Transaccion->getVencimiento('d-m-Y'); ?></span>
                </div>
            </div>
            <br>
            <div class="well well-sm  bg-color-darken txt-color-white no-border">
                <div class="fa-lg">Total:<span class="pull-right">$<?php echo $o_Transaccion->getMonto(); ?> ARS</span></div>
            </div>
        </div>
    </div>

    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/transacciones.html.php' ?>?tipo=processCheckout">
        <input type="hidden" id="ItemID" name="ItemID" value="<?php echo $o_Transaccion->getId(); ?>">

        <fieldset>
            <div class="row padding-10">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ITEM</th>
                        <th>DESCRIPCIÓN</th>
                        <th style="min-width: 60px;">TIPO</th>
                        <th style="min-width: 70px;" class="text-right">PRECIO</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><strong><?php echo htmlentities($o_TPlan->getNombre(), ENT_COMPAT, 'utf-8'); ?></strong></td>
                        <td><?php echo htmlentities($o_TPlan->getDescripcion(), ENT_COMPAT, 'utf-8'); ?></a></td>
                        <td id="tdTipoPlan">Mensual</td>
                        <td id="tdPrecioPlan" class="text-right">$<?php echo $o_Transaccion->getMontoSinIVA(); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">IVA</td>
                        <td class="text-right"><strong><?php echo IVA_MOSTRAR; ?>%</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Total</td>
                        <td id="tdTotal" class="text-right"><strong>$<?php echo $o_Transaccion->getMonto(); ?></strong></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </fieldset>

        <fieldset>
            <legend>Detalles del Pago</legend>

            <div class="row">
                <section class="col col-6">
                    <label class="select">
                        <select name="formadepago" id="formadepago">
                            <option value="" selected="" disabled="">Método de Pago</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="credito">Tarjeta de Credito</option>
                            <option value="transferencia">Transferencia/Cheque</option>
                        </select> <i></i> </label>
                </section>

            </div>
            <div class="row">
                <section class="col col-12">
                    <img id="imgMediosDePago" src="img/medios-de-pago-completo-horizontal.png">
                </section>
            </div>
        </fieldset>
        <fieldset id="pagoConTarjeta">

            <div class="row">
                <section class="col col-12">
                    <div class="inline-group">
                        <label class="radio">
                            <input type="radio" name="radio-tarjeta" value="VISA" checked=""><i></i>Visa
                        </label>
                        <label class="radio">
                            <input type="radio" name="radio-tarjeta" value="MASTERCARD"><i></i>MasterCard
                        </label>
                        <label class="radio">
                            <input type="radio" name="radio-tarjeta" value="AMEX"><i></i>American Express
                        </label>
                        <label class="radio">
                            <input type="radio" name="radio-tarjeta" value="NARANJA"><i></i>Naranja
                        </label>
                    </div>
                </section>
            </div>
            <div class="row">
                <section class="col col-5">
                    <label class="input">
                        <input type="text" name="name" placeholder="Nombre en la Tarjeta" autocomplete="cc-name">
                    </label>
                </section>
                <section class="col col-3">
                    <label class="input">
                        <input type="text" name="dni" placeholder="DNI">
                    </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-6">
                    <label class="input">
                        <input type="text" name="card" placeholder="Número de Tarjeta" data-mask="9999-9999-9999-9999" class="invalid" autocomplete="cc-number">
                    </label>
                </section>
                <section class="col col-2">
                    <label class="input">
                        <input type="text" name="cvv" placeholder="CVV" data-mask="999" class="invalid" autocomplete="cc-csc">
                    </label>
                </section>
            </div>

            <div class="row">
                <label class="label col col-3">Vencimiento:</label>
                <section class="col col-3">
                    <label class="select">
                        <select name="month">
                            <option value="0" selected="" disabled="">Mes</option>
                            <option value="1">Enero</option>
                            <option value="1">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select> <i></i> </label>
                </section>
                <section class="col col-2">
                    <label class="input">
                        <input type="text" name="year" placeholder="Año" data-mask="2099">
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
    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="submit-editar">Aceptar</button>
</div>


<script type="text/javascript">


    pageSetUp();

    $(function () {
        // Validation

        $('#pagoConTarjeta').hide();
        $('#pagoConEfectivo').hide();
        $('#pagoConTransferencia').hide();


        $('#formadepago').change(function () {

            if ($(this).find('option:selected').attr('value') === 'efectivo') {
                $('#pagoConTarjeta').hide();
                $('#pagoConEfectivo').show();
                $('#pagoConTransferencia').hide();
                $("#imgMediosDePago").attr("src","img/medios-de-pago-efectivo-horizontal.png");

            } else if ($(this).find('option:selected').attr('value') === 'credito') {
                $('#pagoConTarjeta').show();
                $('#pagoConEfectivo').hide();
                $('#pagoConTransferencia').hide();
                $("#imgMediosDePago").attr("src","img/medios-de-pago-credito-horizontal.png");

            } else if ($(this).find('option:selected').attr('value') === 'transferencia') {
                $('#pagoConTarjeta').hide();
                $('#pagoConEfectivo').hide();
                $('#pagoConTransferencia').show();
                $("#imgMediosDePago").attr("src","");

            }
        });


        $("#editar-form").validate({
            rules: {
                name: {
                    required: true
                },
                card: {
                    required: true,
                    creditcard: true
                },
                cvv: {
                    required: true,
                    digits: true
                },
                month: {
                    required: true
                },
                year: {
                    required: true,
                    digits: true
                }
            },
            // Messages for form validation
            messages: {
                name: {
                    required: 'Porfavor, ingrese el nombre como aparece en la tarjeta'
                },
                card: {
                    required: 'Porfavor, ingrese los numeros de la tarjeta',
                    creditcard: 'Porfavor, ingrese un numero de tarjeta válido'
                },
                cvv: {
                    required: 'Ingrese el codigo CVV',
                    digits: 'Solo numeros'
                },
                month: {
                    required: 'Seleccione un Mes'
                },
                year: {
                    required: 'Ingrese el año',
                    digits: 'Solo numeros',
                    mask: '4 digitos, por ej: 2016'
                }
            },
            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });
    });


    $(document).ready(function () {
        $('#submit-editar').click(function () {
            var $form = $('#editar-form');
            if (!$('#editar-form').valid()) {
                return false;
            } else {
                $('#editar').modal('hide');
                function showProcesando() {
                    $('#content').css({opacity: '0.0'}).html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Procesando transacción...</h1></div>").delay(50).animate({opacity: '1.0'}, 300);
                }
                setTimeout(showProcesando, 300);
                //check
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


    });



</script>

