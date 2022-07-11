<?php

/*
 * Uso una funcion de datatatables propia, no la que viene con el template
 * utilizo los archivos datatables.min.js y datatables.min.css
 * el datatables.min.js ya esta pre-concatenado y tiene todos los plugins necesarios
 */

?>

loadScript("https://static.enpuntocontrol.com/app/v1/js/plugin/datatables/datatables.min.js", function () {


    $('#dt_basic').DataTable({
        "aaSorting": [],
        "retrieve": true,
        "oLanguage": {"sUrl": "https://static.enpuntocontrol.com/app/v1/js/plugin/datatables/Spanish.json"},
        "autoWidth": true,
        "responsive": {
            details: {
                type: 'column',
                target: 'tr',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.hidden ?
                            '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                            '<td class="dt_responsive_col_title">' + col.title + ':' + '</td> ' +
                            '<td class="dt_responsive_col_data">' + col.data + '</td>' +
                            '</tr>' :
                            '';
                    }).join('');

                    return data ?
                        $('<table/>').append(data) :
                        false;
                }
            },
            type: "column"
        },
        buttons: [
        ],
        "fnInitComplete": function (oSettings, json) {
            <?php
            $_SESSION['filtro']['Guardar_Descargar'] = 'Descargar';
            $T_Tipo     =   !isset($_REQUEST['tipo']) ? isset($_SESSION['filtro']['tipo']) ? $_SESSION['filtro']['tipo'] : '' : $_REQUEST['tipo'];

            ?>

            $("#dt_basic_length").after("<div class=\"table_tools_group\" id=\"BotonesTabla\" style=\"float:right;\"></div>");


            /*
            if($T_Tipo ==  'Personas'){  ?>

                $("#BotonesTabla").append(
                                            "<a " +
                                            "id             =\"BotonGuardarCSV\""+
                                            "class          =\"btn btn-default btn-sm  .DTTT.btn-group fa fa-ellipsis-v\"" +
                                            "type           =\"button\"" +
                                            "title          =\"Importar Excel\"" +
                                            "data-backdrop  =\"static\"" +
                                            "data-toggle    =\"modal\"" +
                                            "data-target    =\"#editar\"" +
                                            "data-type      =\"view\"" +
                                            "data-lnk       =\"ajax/upload-editar.html.php\"" +
                                            "onclick        =\"importar_Archivo()\" >" +
                                            "</a>"
                );

             */


        },
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'lB>r>" +
            "t" +
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>"
    });

    <?php if(isset($NoWrap) && $NoWrap): ?>
    var pepe=0;
    $('#dt_basic').on( 'responsive-resize.dt', function () {

        setTimeout(function () {
            if (!$(".addNoWrap").hasClass("nowrp")) {
                $(".addNoWrap").addClass("nowrp");
            }
        },1000);

    });
    <?php endif;  ?>





});


