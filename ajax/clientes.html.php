<?php require_once dirname(__FILE__) . '/../_ruta.php';?>
<?php $o_Listado = array(); ?>
<?php require_once APP_PATH . '/controllers/clientes.php'; ?>
<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->

<div class="row"><!-- row -->

    <div class="col-xs-8 col-sm-7 col-md-7 col-lg-4"><!-- col -->
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-user"></i>
            <?php echo _('Clientes') ?>
            <span>>
                <?php echo _('Listado de Clientes') ?>
            </span>
        </h1>
    </div>


    <!-- ADD BUTTON -->
    <div class="col-xs-4 col-sm-5 col-md-5 col-lg-8" id="sparkscontainer">
        <div id="sparks">

            <!-- NUEVO -->
            <button data-backdrop       ="static"
                    data-target         ="#editar"
                    data-type           ="add"
                    data-lnk            ="ajax/planes-editar.html.php"
                    title               ="Editar"
                    data-toggle         ="modal"
                    class               ="btn btn-default btn-sm fa fa-trash fa-lg"
                    id                  ="submit-delete"
                    onclick             ="Eliminar_Clientes()">
                Eliminar Seleccion
            </button>

        </div>
    </div>

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
                    <h2><?php echo _('Listado de Clientes') ?></h2>

                </header>

                <div><!-- widget div-->

                    <!-- widget content -->
                    <div class="widget-body no-padding">


                        <table id="dt_basic" class="table table-striped table-hover dataTable no-footer" aria-describedby="dt_basic_info" style="width: 100%;">

                            <!-- ENCABEZADO -->
                            <thead>
                                <tr>
                                    <!-- CHECKBOX HEADER -->
                                    <th id="th_selectall" style="min-width: 20px">
                                        <input  type="checkbox" id="selectall"/>
                                    </th>

                                    <!-- DATA HEADERS -->

                                    <?php

                                    $o_Listado_copy = $o_Listado;
                                    $o_Listado_copy = array_shift($o_Listado_copy);

                                    foreach ($o_Listado_copy as $_itemID => $_item){ ?>
                                        <th>
                                            <?php echo $_itemID; ?>
                                        </th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <!-- TABLA -->
                            <tbody>
                                <?php foreach ($o_Listado as $itemID => $item){ ?>
                                    <tr>
                                        <!-- CHECKBOX TD -->
                                        <td>
                                            <input class="single_checkbox" type="checkbox" value="<?php echo $itemID; ?>" name="checkbox_cli_Id">
                                        </td>

                                        <!-- DATA TD -->

                                        <?php foreach ($item as $iID => $i){ ?>
                                            <td>
                                                <?php echo $i; ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>

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


<?php require_once APP_PATH . '/templates/edit-view_modal.html.php'; ?>


<script type="text/javascript">

    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }

    <?php  require_once APP_PATH . '/includes/data_tables.js.php';?>



    $(document).ready(function () {

        $('#th_selectall').change(function (e) {

            $('#th_selectall').removeClass();
            e.stopPropagation();
            //e.preventDefault();

            var table = $('#dt_basic').DataTable();
            var checkbox_state = "";

            if( $('#selectall').is(":checked")) {
                checkbox_state =true;
            }
            else {
                checkbox_state =false;
            }

            table.rows().nodes().to$().find("input[name='checkbox_cli_Id']").each(function(){
                $(this).prop('checked', checkbox_state);
            });
        });

        $('.single_checkbox').click(function(e) {

            e.stopPropagation();
            //e.preventDefault();

            if(! $(this).is(":checked")) {
                $('#selectall').prop('checked', false);
            }

        });


    });


    function Get_Checked_Ids_Array() {
        var ids   = [];

        var table = $('#dt_basic').DataTable();
        table.rows().nodes().to$().find("input[name='checkbox_cli_Id']:checked").each(function(){

            console.log('$(this).val()',$(this).val());
            ids.push($(this).val());

        });

        console.log('lista_ids',ids);
        return ids;
    }

    function Eliminar_Clientes() {

        var tipo        = "delete_lista";
        var lista_ids   = JSON.stringify(Get_Checked_Ids_Array());


        ExistMsg = 0;//por un error en el plugin smartmessagebox  http://myorange.ca/supportforum/question/smartmessagebox-not-working-after-page-reload-smartmsgboxcount-not-reset

        $.SmartMessageBox(
            {
                title: "Eliminar Clientes",
                content:
                    "Está por eliminar el listado de clientes seleccionado." +
                    "</br>"     + lista_ids       +     "</br>"     +
                    "Esta operación no se puede deshacer. ¿Desea continuar?",
                buttons: '[No][Si]'
            },

            function (ButtonPressed) {

               if (ButtonPressed === "Si") {
                    SmartUnLoading();

                   // $('.modal-content').html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Cargando...</h1></div>");

                   var lista_ids2   = JSON.stringify(Get_Checked_Ids_Array());

                    $.ajax({
                        type: "POST",
                        url: "codigo/controllers/clientes.php",
                        data: {
                            lista_ids   : lista_ids2,
                            tipo        : tipo
                        },
                        success: function (data, status) {


                            //$('#content').css({opacity : '0.0'}).html(data).delay(50).animate({opacity : '1.0'}, 300);

                            console.log('data',data);

                            //location.reload();
                        }
                    });
                }
                else if (ButtonPressed === "No") {
                    SmartUnLoading();
                }
              }
        );
    }

</script>

