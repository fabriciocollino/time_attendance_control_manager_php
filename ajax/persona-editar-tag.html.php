<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-editar-tag.html.php') . 's' . '.php'; ?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="modalTitle">
        <?php if ($o_Persona->getId() != null)
            echo _("Administrar TAG de ") . $o_Persona->getNombreCompleto();
        ?></h4>
</div>
<div class="modal-body" style="padding-top: 0px;">


    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/' . $Item_Name . 's.html.php' ?>?tipo=<?php if ($o_Persona->getId() == null)
              echo "add";
          else
              echo "edit&id=" . $o_Persona->getId();
          ?>">
        <?php if ($o_Persona->getId() != null) echo '<input type="hidden" id="ItemID" name="ItemID" value="' . $o_Persona->getId() . '">'; ?>


        <fieldset>
            <legend>Lectores</legend>
            <div class="row">
                <section class="col col-6">

                    <label class="select"> <span class="icon-prepend fa fa-hdd-o"></span>
                        <select name="equipo" style="padding-left: 32px;">
                            <?php
                            $salida_options='';
                            $array_equipos_para_enrolear = array();

                            $a_o_Equipo = Equipo_L::obtenerTodos();
                            $array_equipos = explode(':', $o_Persona->getEquipos());
                            if ($a_o_Equipo != null) {
                                $checked = '';
                                foreach ($a_o_Equipo as $o_Equipo) { /* @var $o_Equipo Equipo_O */
                                    if (!in_array($o_Equipo->getId(), $array_equipos)) continue;
                                    if((integer)time() - (integer)$o_Equipo->getHeartbeat('U') > 600) continue; //hace mucho tiempo que el equipo no se conecta
                                    $array_equipos_para_enrolear[$o_Equipo->getId()] = $o_Equipo->getDetalle();
                                }
                                foreach ($array_equipos_para_enrolear as $eq_id=>$eq_nombre){
                                    $selected = '';
                                    if(count($array_equipos_para_enrolear)==1)$selected = "selected=\"selected\"";
                                    $salida_options.= "<option ". $selected ." value=\"" . $eq_id . "\">";
                                    $salida_options.= $eq_nombre . "</option>";
                                }

                            }
                            if($salida_options==''){
                                echo "<option value=\"0\" selected=\"selected\">No hay Equipos Conectados</option>";
                            }else if($array_equipos_para_enrolear==1) {
                                echo "<option value=\"0\" >Seleccione un Equipo</option>";
                                echo $salida_options;
                            }else{
                                echo "<option value=\"0\" selected=\"selected\">Seleccione un Equipo</option>";
                                echo $salida_options;
                            }
                            ?>


                        </select> <i></i> </label>
                </section>
            </div>


        </fieldset>
        
        <fieldset>
            <legend>TAG</legend>

            <?php

            ?>

            <div class="row">
                <section class="col col-3"></section>
                <section class="col col-6" style="line-height: 32px;">
                    <div class="row">
                        <section class="col col-4">TAG:</section>
                        <section class="col col-8" id="tag_section"><?php echo $o_Persona->getTag(); ?></section>
                        <section id="tag_viejo" style="display: none;"><?php echo $o_Persona->getTag(); ?></section>
                    </div>
                </section>
                <section class="col col-3">
                    <button id="tagenrollstart" type="button" data-type="accion" data-id="<?php echo $o_Persona->getId(); ?>" data-accion="tagenrollstart" class="btn btn-sm btn-default" style="padding:6px;">Leer</button>
                    <button id="tagsave" type="button" data-type="accion" data-id="<?php echo $o_Persona->getId(); ?>" data-accion="tagsave" class="btn btn-sm btn-default" style="padding:6px;display:none;">Guardar</button>
                    <button id="tagsavecancel" type="button" data-type="accion" data-id="<?php echo $o_Persona->getId(); ?>" data-accion="tagsavecancel" class="btn btn-sm btn-default" style="padding:6px;display:none;">Cancelar</button>
                    <button id="tagedit" type="button" data-type="accion" data-id="<?php echo $o_Persona->getId(); ?>" data-accion="tagedit" class="btn btn-sm btn-default fa fa-lg fa-edit" style="padding:4px 7px 4px 7px;"></button>
                    <button id="deletetag" type="button" data-type="accion" data-id="<?php echo $o_Persona->getId(); ?>" data-accion="deletetag" class="btn btn-sm btn-default fa fa-lg fa-trash-o" style="padding: 4px 7px 4px 7px;"></button>
                </section>
            </div>

        </fieldset>



    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
</div>

<style>
    .modal-open .modal { outline: none; }
</style>

<script type="text/javascript">

    $('body').off('click', 'button[data-type=accion]');
    $('body').on('click', 'button[data-type=accion]', function () {
        $(this).off('click');

        var data_id = '';
        var data_accion = '';
        var dataI = '';

        if (typeof $(this).data('id') !== 'undefined') {
            data_id = $(this).data('id');
        }
        if (typeof $(this).data('accion') !== 'undefined') {
            data_accion = $(this).data('accion');
        }
        if (data_accion === 'tagenrollstart') {
            dataI = $('select[name=equipo]').val();

            if (dataI === '' || dataI === 0 || typeof dataI === 'undefined' || dataI === "0") {
                $.SmartMessageBox({
                    title: "Debe seleccionar un Equipo",
                    content: "Debe seleccionar un Equipo para realizar la lectura de la tarjeta.",
                    buttons: '[Ok]'
                });
                return;
            }
            $('#editar').modal('hide');
            $('#editar').on('hidden.bs.modal', function () {
                $('#editar').off('hidden.bs.modal');
            });
            $.bigBox({
                title: "Enviando comando...",
                content: "El comando está siendo enviado al Equipo...",
                color: "#C79121",
                timeout: 30000,
                icon: "fa fa-refresh fa-spin",
                //number : "2"
                sound: false
            });
            $.ajax({
                cache: false,
                type: 'POST',
                url: 'codigo/controllers/personas.php',
                data: {tipo: 'accion', id: data_id, cmd: data_accion, data: dataI},
                success: function (dataR) {
                    var returnID = dataR;
                    $("[id^=botClose]").click();
                    $.bigBox({
                        title: "Enviando comando...",
                        content: "El comando está siendo enviado al Equipo...</br>La carga comenzará en unos segundos...",
                        color: "#C79121",
                        timeout: 60000,
                        icon: "fa fa-refresh fa-spin",
                        sound: false
                    });
                    comandoAchecker(returnID,0);

                }
            });

        }
        else if (data_accion === 'deletetag') {

            $('#editar').modal('hide');
            $('#editar').on('hidden.bs.modal', function () {
                $('#editar').off('hidden.bs.modal');
            });

            $.ajax({
                cache: false,
                type: 'POST',
                url: 'codigo/controllers/personas.php',
                data: {tipo: 'accion', id: data_id, cmd: data_accion},
                success: function (dataR) {
                    var returnID = dataR;
                    $.bigBox({
                        title: "Tarjeta Eliminada!",
                        content: "La Tarjeta fue eliminada...",
                        color: "#739E73",
                        timeout: 6000,
                        icon: "fa fa-check shake animated",
                        //number : "2"
                        sound: true
                    });

                }
            });

        }
        else if (data_accion === 'tagedit') {

            if($('#tag_section').text()===''){
                $('#tag_section').html("<input type='text' size='10' id='tag_input' style='line-height: 21px;margin-left: -15px;'/>");
                $('#tag_section').focus();
            }else{
                $('#tag_section').html("<input type='text' size='10' id='tag_input' style='line-height: 21px;margin-left: -15px;' value='" + $('#tag_section').text() + "' />");
            }

            $('#tagenrollstart').hide();
            $('#tagedit').hide();
            $('#deletetag').hide();
            $('#tagsave').show();
            $('#tagsavecancel').show();


        }else if (data_accion === 'tagsave') {

            $.ajax({
                cache: false,
                type: 'POST',
                url: 'codigo/controllers/personas.php',
                data: {tipo: 'accion', id: data_id, cmd: data_accion, tag:$("#tag_input").val()},
                success: function (dataR) {
                    var returnID = dataR;
                    $('#editar').modal('hide');
                    $('#editar').on('hidden.bs.modal', function () {
                        $('#editar').off('hidden.bs.modal');
                    });
                    if(dataR=='OK') {
                        $.bigBox({
                            title: "Tarjeta Guardada!",
                            content: "La Tarjeta fue guardada...",
                            color: "#739E73",
                            timeout: 6000,
                            icon: "fa fa-check shake animated",
                            //number : "2"
                            sound: true
                        });
                    }else{
                        $.bigBox({
                            title: "Oh no!",
                            content: "Hubo un problema al cancelar la carga de la tarjeta. </br><small>"+dataR+"<small></br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#C46A69",
                            timeout: 10000,
                            icon: "fa fa-warning shake animated",
                            //number : "2"
                            sound: true
                        });
                    }


                }
            });


        }else if (data_accion === 'tagsavecancel') {

            $('#tagenrollstart').show();
            $('#tagedit').show();
            $('#deletetag').show();
            $('#tagsave').hide();
            $('#tagsavecancel').hide();
            $('#tag_section').html($('#tag_viejo').text());


        }else if (data_accion === 'tagenrollcancel') {
            $("[id^=botClose]").click();
            $.bigBox({
                title: "Cancelando...",
                content: "Cancelando la carga.",
                color: "#C79121",
                timeout: 60000,
                icon: "fa fa-refresh fa-spin",
                //number : "2"
                sound: false
            });

            $.ajax({
                cache: false,
                type: 'POST',
                url: 'codigo/controllers/personas.php',
                data: {tipo: 'accion', data: data_id, cmd: data_accion},
                success: function (dataR) {
                    if(dataR=='OK'){
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Carga cancelada!",
                            content: "La carga de la tarjeta ha sido cancelada correctamente.</br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#739E73",
                            timeout: 6000,
                            icon: "fa fa-check shake animated",
                            sound: true
                        });
                    }else{
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Oh no!",
                            content: "Hubo un problema al cancelar la carga de la tarjeta. </br><small>"+dataR+"<small></br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#C46A69",
                            timeout: 10000,
                            icon: "fa fa-warning shake animated",
                            //number : "2"
                            sound: true
                        });
                    }


                }
            });

        }
    });

    function comandoAchecker(ComandoID,CantIntentos) {
        if(CantIntentos>3){
            //console.log('numero de intentos maximos excedidos');
            return;
        }
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'pspull.php',
            data: {id: ComandoID, cmd: 'ACK_RFID_READ_START'},
            success: function (data) {

                if(data=='' || data.indexOf('Fatal error:')>=1){
                    return;
                }
                var mensaje = JSON.parse(data);
                //console.log('mensaje:',mensaje);

                if(mensaje.data.id==ComandoID){
                    //console.log('ack enroll start tag',mensaje.data.id);
                    $("[id^=botClose]").click();
                    $.bigBox({
                        title: "Carga Iniciada!",
                        content: "Siga las instrucciones en la pantalla del equipo para cargar la tarjeta.</br><button style=\"float:right;\" type=\"button\" class=\"btn btn-default btn-sm\" data-type=\"accion\" data-id=\"" + mensaje.attributes.uuid + "\" data-accion=\"tagenrollcancel\">Cancelar</button>",
                        color: "#3276B1",
                        timeout: 30000,
                        icon: "fa fa-bell swing animated",
                        sound: true
                    });
                    comandoAchecker2(ComandoID,0);

                }else{
                    //console.log('detectado mensaje que no es ack y tarjeta');
                    //console.log('intento',CantIntentos);
                    comandoAchecker(ComandoID,CantIntentos+1);

                }

            }
        });

    }

    function comandoAchecker2(ComandoID,CantIntentos) {

        if(CantIntentos>3){
            console.log('numero de intentos maximos excedidos');
            return;
        }
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'pspull.php',
            data: {id: ComandoID, cmd: 'CMD_RFID_READ_STATUS'},
            success: function (data) {

                if(data=='' || data.indexOf('Fatal error:')>=1){

                    return;
                }
                var mensaje = JSON.parse(data);
                //console.log('mensaje:',mensaje);

                if(mensaje.data.per_id==ComandoID){
                    equiposOK.push(mensaje.attributes.uuid);
                    //console.log('persona',mensaje.data.id);
                    //console.log('equipo',mensaje.attributes.uuid);
                    //console.log('status',mensaje.data.status);


                    if(mensaje.data.status=='OK'){
                        //console.log('sync ok!');
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Tarjeta Cargada!",
                            content: "La tarjeta ha sido cargada correctamente.</br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#739E73",
                            timeout: 6000,
                            icon: "fa fa-check shake animated",
                            sound: true
                        });
                    }else if(mensaje.data.status=='CANCEL'){
                        //por ahora no hago nada
                    }if(mensaje.data.status=='ERROR'){
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Oh no!",
                            content: "Hubo un problema al cargar la tarjeta y esta no se cargó corretamente. </br>La tarjeta ya se encuentra asignada a "+mensaje.data.owner_name + " " + mensaje.data.owner_lastname + "</br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#C46A69",
                            timeout: 10000,
                            icon: "fa fa-warning shake animated",
                            sound: true
                        });
                    }else{
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Oh no!",
                            content: "Hubo un problema al cargar la tarjeta y esta no se cargó corretamente. </br><small>"+mensaje.data.status+"<small></br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#C46A69",
                            timeout: 10000,
                            icon: "fa fa-warning shake animated",
                            sound: true
                        });
                    }

                }else{
                    //console.log('detectado mensaje que no es status y tarjeta');
                    //console.log('intento',CantIntentos);
                    comandoAchecker2(ComandoID,CantIntentos+1);
                }


            }
        });


    }


    $(document).ready(function () {
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
    });


</script>
