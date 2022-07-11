<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php'; ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->

<div class="row"><!-- row -->

    <div class="col-xs-8 col-sm-7 col-md-7 col-lg-4"><!-- col -->
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-user"></i>
            <?php echo _('Personas') ?>
            <span>>
                <?php echo _('Listado de Personas') ?>
				</span>
        </h1>
    </div><!-- end col -->
    <?php if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 50) { ?>
        <div class="col-xs-4 col-sm-5 col-md-5 col-lg-8" id="sparkscontainer">
            <div id="sparks">
                <button class="btn btn-sm btn-primary <?php if($T_ErrorPersonasMax!='')echo " disabled "; ?>" type="button"
                        <?php if($T_ErrorPersonasMax==''){ ?>
                            data-backdrop="static" data-toggle="modal"
                            data-target="#editar" data-type="view" data-lnk="ajax/<?= $Item_Name ?>-editar.html.php">
                        <?php } else { ?>
                            rel="tooltip" data-placement="top" data-original-title="<?php echo $T_ErrorPersonasMax; ?>" >
                        <?php } ?>
                    <?php echo _('Agregar Persona') ?>
                </button>
            </div>
        </div>
    <?php } ?>

</div><!-- end row -->


<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">


        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                    <h2><?php echo _('Listado de Personas') ?></h2>

                </header>


                <div><!-- widget div-->

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox"><!-- This area used as dropdown edit box --></div>


                    <!-- widget content -->
                    <div class="widget-body no-padding">


                        <table id="dt_basic" class="table table-striped table-hover dataTable no-footer"
                               aria-describedby="dt_basic_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <?php /* <th><?php echo _('ID') ?></th> */ ?>
                                <th data-priority="2"><?php echo _('Foto') ?></th>
                                <th data-priority="1"><?php echo _('Apellido, Nombre') ?></th>
                                <th data-priority="2"><?php echo _('DNI') ?></th>
                                <?php if (Config_L::p('usar_legajo')) { ?>
                                    <th><?php echo _('Legajo') ?></th><?php } ?>
                                <th data-visible="false"><?php echo _('Cód. Tarjeta') ?></th>
                                <th data-visible="false"><?php echo _('Grupos') ?></th>
                                <th data-priority="3"><?php echo _('Horario de Trabajo') ?></th>
                                <th data-priority="4"><?php echo _('E-mail') ?></th>
                                <th data-priority="1" style="width:150px;"><?php echo _('Opciones') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!is_null($o_Listado)): ?>

                                <?php foreach ($o_Listado as $key => $item): ?>
                                    <tr>
                                        <?php /*		<td><?php echo $item->getId(); ?></td> */ ?>
                                        <td>
                                            <div class="smallImageThumb"><?php if ($item->getImagen() == '') {
                                                    echo '<img src="img/avatars/male-big.png" />';
                                                } else {
                                                    echo '<img src="imagen.php?per_id=' . $item->getId() . '&size=25" />';
                                                } ?></div>
                                        </td>
                                        <td><?php echo $item->getApellido() . ', ' . $item->getNombre(); ?></td>
                                        <td><?php echo $item->getDni(); ?></td>
                                        <?php if (Config_L::p('usar_legajo')) { ?>
                                            <td><?php echo $item->getLegajo(); ?></td><?php } ?>
                                        <td><?php echo $item->getTag(); ?></td>
                                        <td><?php
                                            $a_Grupos_Personas = Grupos_Personas_L::obtenerARRAYPorPersona($item->getId());
                                            if(is_null($a_Grupos_Personas)){
                                                echo '-';
                                            }else {
                                                $a_o_Grupos = Grupo_L::obtenerTodos();
                                                if ($a_o_Grupos != null) {
                                                    $salida = '';
                                                    foreach ($a_o_Grupos as $o_Grupo) {
                                                        if (in_array($o_Grupo->getId(), $a_Grupos_Personas))
                                                            $salida .= $o_Grupo->getDetalle() . " - ";
                                                    }
                                                    $salida = rtrim($salida, " - ");
                                                    echo $salida;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <?php switch ($item->getHorTipo()) {
                                            case HORARIO_NORMAL: ?>
                                                <td>
                                                    Normal: <?php echo Hora_Trabajo_L::obtenerPorId($item->getHorId())->getDetalle(); ?></td>
                                                <?php break;
                                            case HORARIO_FLEXIBLE: ?>
                                                <td>
                                                    Flexible: <?php echo Horario_Flexible_L::obtenerPorId($item->getHorId())->getDetalle(); ?></td>
                                                <?php break;
                                            case HORARIO_ROTATIVO: ?>
                                                <td>
                                                    Rotativo: <?php echo Horario_Rotativo_L::obtenerPorId($item->getHorId())->getDetalle(); ?></td>
                                                <?php break;
                                            case HORARIO_MULTIPLE: ?>
                                                <td>
                                                    Múltiple: <?php echo Horario_Multiple_L::obtenerPorId($item->getHorId())->getDetalle(); ?></td>
                                                <?php break;

                                            default: //cuando no tiene horario ?>
                                                <td>Sin Horario</td>
                                                <?php break;
                                        } ?>

                                        <td><?php echo $item->getEmail(); ?></td>
                                        <td style="white-space: nowrap;">
                                            <?php if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 50) { ?>
                                                <?php if ($item->getEquipos()!='') { ?>
                                                <button data-toggle="modal" data-backdrop="static" data-target="#editar"
                                                        data-type="view-fp"
                                                        data-lnk="ajax/<?= $Item_Name ?>-editar-fp.html.php"
                                                        data-id="<?php echo $item->getId(); ?>"
                                                        title="<?php echo _('Administrar Huellas') ?>"
                                                        class="btn btn-default btn-sm fa fp_back fa-lg"
                                                        style="line-height: .75em;">&nbsp;</button>
                                                 <?php } else { ?>
                                                    <button
                                                            title="<?php echo _('Necesita agregar la persona a un equipo para administrar huellas') ?>"
                                                            class="btn btn-default btn-sm fa fp_back fa-lg disabled"
                                                            style="line-height: .75em;">&nbsp;</button>
                                                 <?php } ?>
                                                <button data-toggle="modal" data-backdrop="static" data-target="#editar"
                                                        data-type="view-tag"
                                                        data-lnk="ajax/<?= $Item_Name ?>-editar-tag.html.php"
                                                        data-id="<?php echo $item->getId(); ?>"
                                                        title="<?php echo _('Administrar TAG') ?>"
                                                        class="btn btn-default btn-sm fa fa-tag fa-lg"
                                                        style="line-height: .75em;padding-right: 5px;padding-left: 9px;">&nbsp;</button>
                                                <button data-toggle="modal" data-backdrop="static" data-target="#editar"
                                                        data-type="view"
                                                        data-lnk="ajax/<?= $Item_Name ?>-editar.html.php"
                                                        data-id="<?php echo $item->getId(); ?>"
                                                        title="<?php echo _('Editar') ?>"
                                                        class="btn btn-default btn-sm fa fa-edit fa-lg"
                                                        style="line-height: .75em;padding-right: 7px;"></button>
                                                <?php if ($item->getEnabled())    : ?>
                                                    <button title="<?php echo _('Bloquear') ?>"
                                                            class="btn btn-default btn-sm fa fa-lock fa-lg"
                                                            style="line-height: .75em;"
                                                            onclick="BloquearPersona(<?php echo $item->getId(); ?>)"></button>
                                                <?php else : ?>
                                                    <button title="<?php echo _('Desbloquear') ?>"
                                                            class="btn btn-default btn-sm fa fa-unlock fa-lg"
                                                            style="line-height: .75em;padding-left: 8px;padding-right: 8px;"
                                                            onclick="DesBloquearPersona(<?php echo $item->getId(); ?>)"></button>
                                                <?php endif; ?>
                                                <button title="<?php echo _('Eliminar') ?>" data-type="delete"
                                                        data-id="<?php echo $item->getId(); ?>"
                                                        class="btn btn-default btn-sm fa fa-trash-o fa-lg"
                                                        style="line-height: .75em;"
                                                        onclick="EliminarPersona(<?php echo $item->getId(); ?>)"></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>


                            <?php else: ?>
                            <?php endif; ?>

                            </tbody>
                        </table>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->

        </article>
        <!-- WIDGET END -->

    </div>

    <!-- end row -->


</section>
<!-- end widget grid -->


<?php
//INCLUYO los view/edit etc de los cosos
require_once APP_PATH . '/templates/edit-view_modal.html.php';
?>


<script type="text/javascript">


    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }
    <?php
    //INCLUYO el js de las datatables
   //require_once APP_PATH . '/includes/data_tables.js.php';
    ?>


    //esto asigna el ID al modal cada vez que se hace click en el boton
    $(document).ready(function () {

        //inicia el sync checker si se edito o agrego una persona

        <?php echo $T_sync_checker; ?>
        <?php echo $T_sync_js_start; ?>

        //en esta pagina uso este metodo para bindear el click porque los botones son "cambiados/agregados" dinamicamente por el jquery mobile, despues de renderizar el dom. por eso la funcion click() no anda
        //$(document).on('click', 'a[data-toggle=modal], button[data-toggle=modal]', function (e) {
        $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {
            var data_id = '';
            var lnk = '';
            var view_type = '';
            if (typeof $(this).data('id') !== 'undefined') {
                data_id = $(this).data('id');
            }
            if (typeof $(this).data('lnk') !== 'undefined') {
                lnk = $(this).data('lnk');
            }
            if (typeof $(this).data('type') !== 'undefined') {
                view_type = $(this).data('type');
            }


            $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");
            $.ajax({
                cache: false,
                type: 'POST',
                url: lnk,
                data: {tipo: view_type, id: data_id},
                success: function (data) {
                    $('.modal-content').show().html(data);
                }
            });

        });


    });


    function BloquearPersona(Persona) {
        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'disable', id: Persona});
    }

    function DesBloquearPersona(Persona) {

        loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: 'enable', id: Persona});
    }

    $('a[data-type=delete], button[data-type=delete]').click(function () {
        var data_id = '';
        var lnk = '';
        var view_type = '';
        if (typeof $(this).data('id') !== 'undefined') {
            data_id = $(this).data('id');
        }
        if (typeof $(this).data('lnk') !== 'undefined') {
            lnk = $(this).data('lnk');
        }
        if (typeof $(this).data('type') !== 'undefined') {
            view_type = $(this).data('type');
        }
        ExistMsg = 0;//por un error en el plugin smartmessagebox  http://myorange.ca/supportforum/question/smartmessagebox-not-working-after-page-reload-smartmsgboxcount-not-reset


        $.SmartMessageBox({
            title: "Eliminar <?php echo $T_Titulo_Singular; ?>",
            content: "Está por eliminar <?php echo $T_Titulo_Pre; ?> <?php echo $T_Titulo_Singular; ?>.</br>Esta operación no se puede deshacer. Desea continuar?",
            buttons: '[No][Si]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Si") {
                //esto refresca la pagina
                SmartUnLoading();
                loadURLwData('<?php echo $Item_Name . 's' ?>', $('#content'), {tipo: view_type, id: data_id});
            }
            else if (ButtonPressed === "No") {
                SmartUnLoading();
            }

        });


    });


    function getRow(table_id, arg1) {
        var oTable = $('#' + table_id).dataTable(), data = oTable.fnGetData(), row, i, l = data.length;
        for (i = 0; i < l; i++) {
            row = data[i];

            // columns to search are hard-coded, but you could easily pass this in as well
            if ($.inArray(arg1, row) >= 0) {
                return $('#' + table_id + ' tr').eq(i + 1);
            }
        }
        return false;
    }


    function disableRow(perNombre) {

        $row = getRow('dt_basic', perNombre);

        $row.addClass('text-muted');
        $row.children("td").children("button").addClass('disabled');
        $row.children("td:last").append("<h4 class=\"ajax-loading-animation\" style=\"display: inline;\"><i class=\"fa fa-cog fa-spin\"></i></h4>");
    }

    function enableRow(perNombre) {
        $row = getRow('dt_basic', perNombre);

        $row.removeClass('text-muted');
        $row.children("td").children("button").removeClass('disabled');
        $row.children("td").children("h4").fadeOut(300);
    }

    var contadorTimeout = 0;

    var contadorPulls = 0;
    var equiposOK = [];



    function syncChecker(perID, perNombre, cantEquipos) {
        //console.log('iniciando syncChequer',contadorPulls);
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'pspull.php',
            data: {id: perID, cmd: 'CMD_ACK', type:'TYPE_PERSON'},
            success: function (data) {
                if(data=='' || data.indexOf('Fatal error:')>=1){
                    contadorPulls = 0;
                    console.log('timeout PS Fatal Error');
                    $('button[data-dismiss="alert"').click();
                    $("[id^=botClose]").click();
                    $.bigBox({
                        title: "No se sincronizaron los datos!",
                        content: "Algunos equipos no responden, los datos se sincronizarán automáticamente cuando los equipos vuelvan a conectarse.</br>",
                        color: "#C46A69",
                        timeout: 6000,
                        icon: "fa fa-warning shake animated",
                        //number : "2"
                        sound: false
                    });
                    enableRow(perNombre);
                    equiposOK=[];

                    return;
                }
                var mensaje = JSON.parse(data);
                console.log('mensaje:',mensaje);

                if($.inArray(mensaje.attributes.uuid, equiposOK) > -1){
                    console.log('vino un mensaje del mismo equipo, descartado...');
                }

                if(mensaje.data[0].id==perID && $.inArray(mensaje.attributes.uuid, equiposOK) == -1){
                    equiposOK.push(mensaje.attributes.uuid);
                    console.log('persona',mensaje.data[0].id);
                    console.log('status',mensaje.data[0].result);
                    console.log('equipo',mensaje.attributes.uuid);
                    if(cantEquipos>1){
                        console.log('mas de un equipo. iniciando chequeo nuevamente');
                        cantEquipos--;
                        syncChecker(perID, perNombre, cantEquipos);
                    }else{
                        enableRow(perNombre);
                        contadorPulls = 0;
                        $('button[data-dismiss="alert"').click();
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Datos sincronizados!",
                            content: "Se han sincronizado los cambios en todos los equipos.</br>",
                            color: "#739E73",
                            timeout: 6000,
                            icon: "fa fa-check shake animated",
                            //number : "2"
                            sound: false
                        });
                        equiposOK=[];
                    }

                }else{
                    console.log('detectado mensaje que no es ack y persona');
                    if(contadorPulls>=3){
                        console.log('timeout de intentos');
                        $('button[data-dismiss="alert"').click();
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "No se sincronizaron los datos!",
                            content: "Algunos equipos no responden, los datos se sincronizarán automáticamente cuando los equipos vuelvan a conectarse.</br>",
                            color: "#C46A69",
                            timeout: 6000,
                            icon: "fa fa-warning shake animated",
                            //number : "2"
                            sound: false
                        });
                        enableRow(perNombre);
                        equiposOK=[];
                    }else {
                        syncChecker(perID, perNombre, cantEquipos);
                        contadorPulls++;
                    }
                }

            }
        });
    }


</script>

<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>


