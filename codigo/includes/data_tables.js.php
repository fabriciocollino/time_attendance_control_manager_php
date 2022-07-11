<?php

/*
 * Uso una funcion de datatatables propia, no la que viene con el template
 * utilizo los archivos datatables.min.js y datatables.min.css
 * el datatables.min.js ya esta pre-concatenado y tiene todos los plugins necesarios
 */

?>

loadScript("js/plugin/datatables/datatables.min.js", function () {
    $('#dt_basic').DataTable({
        "aaSorting": [],
        "oLanguage": {"sUrl": "js/plugin/datatables/Spanish.json"},
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
            //display: $.fn.dataTable.Responsive.display.childRow,
            type: "column"
        },
        buttons: [
            <?php if(!isset($Botones_Exportar)): ?>
            {
                extend: 'pdfHtml5',
                text: '',
                pageSize: "A4",
                className: "buttons-pdf-save buttons-html5",
                <?php include APP_PATH . '/includes/data_tables_pdf_export.js.php'; ?>

            },
            {
                extend: 'pdfHtml5',
                text: '',
                pageSize: "A4",
                className: "buttons-pdf-open buttons-html5",
                download: 'open',
                <?php include APP_PATH . '/includes/data_tables_pdf_export.js.php'; ?>
            },
            {
                extend: 'excel',
                text: '',
                className: "buttons-excel buttons-html5"
            },
            {
                extend: 'csv',
                text: '',
                className: "buttons-csv-save buttons-html5"
            }
            <?php endif; ?>
        ],
        "fnInitComplete": function (oSettings, json) {
            <?php if(isset($Botones_Exportar) && $Botones_Exportar): ?>
            $("#dt_basic_length").after("<div class=\"table_tools_group\" id=\"BotonesTabla\" style=\"float:right;\"></div>");
            $("#BotonesTabla").append("<a id=\"BotonGuardarPDF\" href=\"<?php echo WEB_ROOT; ?>/reporte_pdf.php?tipo=<?php echo $Reporte_Tipo; ?>&nombre=<?php echo $Reporte_Nombre; ?>&guardar=2\" title=\"Guardar PDF\" target=\"_blank\" class=\"btn btn-default btn-sm  .DTTT.btn-group fa fa-file-pdf-o\"></a>");
            $("#BotonesTabla").append("<a id=\"BotonImprimir\" href=\"<?php echo WEB_ROOT; ?>/reporte_pdf.php?tipo=<?php echo $Reporte_Tipo; ?>&nombre=<?php echo $Reporte_Nombre; ?>&imprimir=1\" title=\"Imprimir\" target=\"_blank\" class=\"btn btn-default btn-sm  .DTTT.btn-group fa fa-print\"></a>");
            $("#BotonesTabla").append("<a id=\"BotonGuardarCSV\" href=\"<?php echo WEB_ROOT; ?>/csv.php?tipo=<?php echo $Reporte_Tipo; ?>\" title=\"Guardar Excel (CSV)\" target=\"_blank\" class=\"btn btn-default btn-sm  .DTTT.btn-group fa fa-floppy-o\"></a>");
            <?php endif; ?>
            $('.buttons-pdf-save').addClass("fa fa-file-pdf-o");
            $('.buttons-pdf-open').addClass("fa fa-print");
            $('.buttons-excel').addClass("fa fa-file-excel-o");
            $('.buttons-csv-save').addClass("fa fa-floppy-o");



        },
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'lB>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>"
    });

    <?php if(isset($NoWrap) && $NoWrap): ?>
        var pepe=0;
        $('#dt_basic').on( 'responsive-resize.dt', function () {
            //console.log('draw');
            setTimeout(function () {
                if (!$(".addNoWrap").hasClass("nowrp")) {
                    $(".addNoWrap").addClass("nowrp");
                    //console.log('clase agregada');
                }
            },1000);
        } );
    <?php endif; ?>




});
	
	
	