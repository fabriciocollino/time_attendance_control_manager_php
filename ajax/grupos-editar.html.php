<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-editar.html.php') . '.php'; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title"
        id="modalTitle"><?php if ($o_Grupo->getId() == null) echo _("Agregar Grupo"); else echo _("Editar Grupo"); ?></h4>
</div>
<div class="modal-body" style="padding-top: 0px;">

    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/' . $Item_Name . '.html.php' ?>?tipo=<?php if ($o_Grupo->getId() == null) echo "add"; else echo "edit&id=" . $o_Grupo->getId(); ?>">


        <fieldset>
            <legend>Datos Generales</legend>
            <div class="row">
                <section class="col col-10" style="width: 100%">
                    <label class="input"> <i class="icon-prepend fa fa-users"></i>
                        <input type="text" name="detalle" placeholder="Nombre"
                               value="<?php echo htmlentities($o_Grupo->getDetalle(), ENT_COMPAT, 'utf-8'); ?>">
                    </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-5">
                    <label class="toggle">
                        <input type="checkbox" id="envivo"
                               name="envivo" <?php if ($o_Grupo->getEnVivo() != 0) echo "checked=\"yes\""; ?> >
                        <i data-swchon-text="SI" data-swchoff-text="NO"></i>Mostrar en vivo
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
    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="submit-editar">
        <?php if ($o_Grupo->getId() == null) echo _("Agregar"); else echo _("Guardar"); ?>
    </button>
</div>


<script type="text/javascript">


    $(document).ready(function () {
        //$('#editar').on('shown.bs.modal', function() {


        //});//end del after modal shown

        $(function () {
            // Validation


            $("#editar-form").validate({
                // Rules for form validation
                rules: {
                    detalle: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    }
                },
                // Messages for form validation
                messages: {
                    detalle: {
                        required: '<?php echo _('Por favor ingrese el nombre del grupo') ?>',
                        minlength: '<?php echo _('El nombre es muy corto') ?>',
                        maxlength: '<?php echo _('El nombre es muy largo') ?>'
                    }
                },
                // Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
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


    });


</script>