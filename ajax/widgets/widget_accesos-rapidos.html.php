<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php 



?>

<style>
    
  .widget-btns {
		margin:0;
		padding:0;
		list-style:none;
	}
	.widget-btns > li {
		display:inline-block;
		margin-bottom:7px;
	}
    
</style>
<ul class="widget-btns">
    <li>
        <button class="btn btn-default btn-lg" type="button" data-toggle="modal" data-target="#editar" data-type="view" data-lnk="ajax/persona-editar.html.php" >
            <i class="fa fa-user" style="font-size: 32px;"></i>
            <div>Agregar Persona</div>
        </button>        
    </li>
    <li>
        <a href="javascript:void(0);" class="btn btn-default btn-lg ">
            <i class="fa fa-list-alt" style="font-size: 32px;"></i>
            <div>Ver Reportes</div>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);" class="btn btn-default btn-lg ">
            <i class="fa fa-hdd" style="font-size: 32px;"></i>
            <div>Ver Equipos</div>
        </a>
    </li>
</ul>

<script type="text/javascript">
	
	
	
  $(document).ready(function() {	
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
	    $.ajax({
	        cache: false,
	        type: 'POST',
	        url: lnk,
	        data:  {tipo:view_type,id:data_id},
	        success: function(data) 
	        {
	            $('.modal-content').show().html(data);
	        }
	    });
	  });
});
	
	
</script>


<?php
//INCLUYO los view/edit etc de los cosos
require_once APP_PATH . '/templates/edit-view_modal.html.php';
?>

