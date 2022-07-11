<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php


SeguridadHelper::Pasar(20);
$UsarFechasWidget = true;
$T_Titulo = _('en Vivo');


?>

<style>

</style>


<table id="table_feed_en_vivo" class="table table-hover table-no-border ">

    <thead>
        <tr>
            <th>Persona</th>
            <th>Lector</th>
            <th>Equipo</th>
            <th>Tiempo</th>
        </tr>
    </thead>

    <tbody>

    </tbody>

</table>

<script>


    let socket = io('https://feed.enpuntocontrol.com');
    socket.on('log', function (data) {
        data = JSON.parse(data);



        if(data.lector===1){
            data.lector='<i class="fa fp_back_small" title="'+dedoAstring(data.dedo)+'" ></i>';
        }else if(data.lector===2){
            data.lector='<i class="fa fa-tag tag_back_fa_marging"></i>'
        }

        $("#table_feed_en_vivo tbody").prepend("<tr><td>"+data.persona+"</td><td>"+data.lector+"</td><td>"+data.equipo+"</td><td class='feed_moment' title='"+moment(data.fecha, "X").format("DD-MM-YYYY - HH:mm:ss")+"' data-timestamp='"+data.fecha+"'>"+moment(data.fecha, "X").fromNow()+"</td></tr>");

        var rows = document.getElementById("table_feed_en_vivo").rows.length;
        if(rows>11){
            document.getElementById("table_feed_en_vivo").deleteRow(rows -1);
        }

    });

    setInterval(()=>{
        $('#table_feed_en_vivo > tbody  > tr > td.feed_moment').each(function(index,element) {
            element.innerHTML = moment(element.dataset.timestamp, "X").fromNow();
        });
    },15000);

    function dedoAstring(dedo){
        switch (dedo){
            case 1: return "Pulgar Izquierdo";
            case 2: return "Índice Izquierdo";
            case 3: return "Medio Izquierdo";
            case 4: return "Anular Izquierdo";
            case 5: return "Meñique Izquierdo";
            case 6: return "Pulgar Derecho";
            case 7: return "Índice Derecho";
            case 8: return "Medio Derecho";
            case 9: return "Anular Derecho";
            case 10: return "Meñique Derecho";
        }
        return "";
    }


</script>