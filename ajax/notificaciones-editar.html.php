<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-editar.html.php') . '.php';  ?>


<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="modalTitle"><?php if ($o_Notificacion->getId()==null) echo _("Agregar Notificación"); else echo _("Editar Notificación"); ?></h4>
</div>
<div class="modal-body" style="padding-top: 0px;">
	
	
	<form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form" action="<?php echo 'ajax/'.$Item_Name.'.html.php' ?>?tipo=<?php if ($o_Notificacion->getId()==null) echo "add"; else echo "edit&id=".$o_Notificacion->getId(); ?>"> 


							<fieldset>
								<legend>Datos Generales</legend>
								<div class="row">
									<section class="col col-10" style="width: 100%">
										<label class="input"> <i class="icon-prepend fa fa-bullhorn"></i>
											<input type="text" name="detalle" placeholder="Nombre" value="<?php echo htmlentities($o_Notificacion->getDetalle(), ENT_COMPAT, 'utf-8'); ?>">
										</label>
									</section>									
								</div>
								<div class="row">
									<section class="col col-9">
										<label class="select"> <span class="icon-prepend fa fa-users"></span>
											<select name="grupo" style="padding-left: 32px;">
												<?php echo $T_Grupo; ?>
											</select> <i></i> </label>
									</section>	
									<section class="col col-3">
										<label class="select"> <span class="icon-prepend fa fa-asterisk"></span>
											<select name="tipon" style="padding-left: 32px;">
												<?php echo $T_Tipon; ?>
											</select> <i></i> </label>
									</section>																			
								</div>
								 
							</fieldset>

							<fieldset>
								<legend>Disparador</legend>
								<div class="row">
									<section class="col col-6">
										<label class="select"> <span class="icon-prepend fa fa-play"></span>
											<select name="tipod" id="selTipo" style="padding-left: 32px;">
												<?php echo $T_Tipod; ?>
											</select> <i></i> </label>
									</section>	
									<section class="col col-6" id="trDisparador">
										<label class="select"> <span class="icon-prepend fa fa-bolt"></span>
											<select name="disparador" id="selDisparador" style="padding-left: 32px;">
												<?php echo $T_Disparador; ?>
											</select> <i></i> </label>
									</section>	
									<section class="col col-6" id="trRepetir">
										<label class="select"> <span class="icon-prepend fa fa-bolt"></span>
											<select name="repetir" id="selRepetir" style="padding-left: 32px;">
												<?php echo $T_Repetir; ?>
											</select> <i></i> </label>
									</section>		
								</div>
								<div class="row" >
									<section class="col col-6" id="trEquipo">
										<label class="select"> <span class="icon-prepend fa fa-hdd-o"></span>
											<select name="eguipo"  id="selEquipo" style="padding-left: 32px;">
												<?php echo $T_Equipo; ?>
											</select> <i></i> </label>
									</section>
									<section class="col col-6" id="trFecha">
										<label class="input"> <span class="icon-prepend fa fa-clock-o"></span>
												<input class="form-control " name="hora" id="hora" type="text" placeholder="Fecha y Hora de Inicio" value="<?php echo $T_Hora ?>">
											</label>
									</section>	
								</div>
								<div class="row" >
									<section class="col col-6" id="trPersona">
										<label class="select"> <span class="icon-prepend fa fa-user"></span>
											<select name="persona"  id="selPersona" style="padding-left: 32px;">
												<?php echo $T_Persona; ?>
											</select> <i></i> </label>
									</section>
									<section class="col col-6" id="selRol">
											<label class="select"> <span class="icon-prepend fa fa-user"></span>
											<select name="grupos"  style="padding-left: 32px;">
												<?php echo $T_Grupos; ?>
											</select> <i></i> </label>
									</section>	
								</div>
							</fieldset>
			
			
							<fieldset>
								<legend>Contenido</legend>
								<div class="row">
									<section class="col col-6">
										<label class="select"> <span class="icon-prepend fa fa-play"></span>
											<select name="tipoc" id="selTipoc" style="padding-left: 32px;">
												<?php echo $T_Tipoc; ?>
											</select> <i></i> </label>
									</section>												
								</div>
								<div class="row" >
									<section class="col col-10" style="width: 100%" id="trDetallec">
										<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
											<input type="text" name="detallec" placeholder="Asunto" value="<?php echo htmlentities($o_Notificacion->getDetalleC(), ENT_COMPAT, 'utf-8'); ?>">
										</label>
									</section>
									<section class="col col-6" id="trReportec">
										<label class="select"> <span class="icon-prepend fa fa-play"></span>
											<select name="reportec" style="padding-left: 32px;">
												<?php echo $T_Reportec; ?>
											</select> <i></i> </label>
									</section>	
									<section class="col col-6" id="trPersonac">
										<label class="select"> <span class="icon-prepend fa fa-play"></span>
											<select name="personac"  id="selPersonac" style="padding-left: 32px;">
												<?php echo $T_Personac; ?>
											</select> <i></i> </label>
											<label class="select"> <span class="icon-prepend fa fa-play"></span>
											<select name="rolc"  id="selRolc" style="padding-left: 32px;">
												<?php echo $T_Grupoc; ?>
											</select> <i></i> </label>
									</section>
									<section class="col col-6" id="trEquipoc">
										<label class="select"> <span class="icon-prepend fa fa-hdd-o"></span>
											<select name="eguipoc"  id="selEquipoc" style="padding-left: 32px;">
												<?php echo $T_Equipoc; ?>
											</select> <i></i> </label>
									</section>	
								</div>
								<div class="row" >
									<section class="col col-6" id="trIntervaloc">
										<label class="select"> <span class="icon-prepend fa fa-hdd-o"></span>
											<select name="intervaloc"  id="selIntervaloc" style="padding-left: 32px;">
												<?php echo $T_Intervaloc; ?>
											</select> <i></i> </label>
									</section>
									<section class="col col-10" style="width: 100%" id="trMensajec">
										<label class="textarea textarea-resizable"> <i class="icon-prepend fa fa-envelope"></i>
											<textarea name="mensajec" rows="5" placeholder="Mensaje"><?php echo htmlentities($o_Notificacion->getTextoC(), ENT_COMPAT, 'utf-8'); ?></textarea>
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
		<?php if ($o_Notificacion->getId()==null) echo _("Agregar"); else echo _("Guardar"); ?>
	</button>
</div>


<script type="text/javascript">
		
		
	  //Y-m-d H:i:s
          
		$("#hora").datetimepicker({
				minDate:'moment',
				locale: 'es',
				collapse: false,  
                                sideBySide:true,
				format: 'YYYY-MM-DD HH:mm:ss'
		}); 


	$('#selTipo').change(function() {	 
	   if($(this).find('option:selected').attr('value')==='0'){//inmediato
	   		$('#trDisparador').show();
	   		$('#trRepetir').hide();
   			$('#trFecha').hide();
	   }else if($(this).find('option:selected').attr('value')==='1'){ //diferido
	   		$('#trDisparador').hide();
	   		$('#trPersona').hide();
				$('#trEquipo').hide();
				$('#trRepetir').show();
				$('#trFecha').show();
	   }
	});
	
	$('#selPersona').change(function() {	   
	   if($(this).find('option:selected').attr('value')==='SelectRol'){
				$('#selRol').show();
	   }else{ 
	   		$('#selRol').hide();
	   }
	});
	
$('#selDisparador').change(function() {
	   //$('#form1, #form2, #form3').hide();
	   //$('#form' + $(this).find('option:selected').attr('id')).show();
	
	   if($(this).find('option:selected').attr('value')==='<?php echo NOT_DISPARO_TAMPER ?>'){ //alarmas
	   		$('#trEquipo').show();
	   		$('#trPersona').hide();
				$('#trRepetir').hide();
				$('#trFecha').hide();
				$('#trAccion').hide();
	   }else if($(this).find('option:selected').attr('value')==='<?php echo NOT_PERDIDA_DE_CONEXION ?>'){ //Equipo Pierde conexion
	   		$('#trPersona').hide();
	   		$('#trEquipo').show();
	   		$('#trRepetir').hide();
	   		$('#trFecha').hide();
	   		$('#trAccion').hide();
	   }else if($(this).find('option:selected').attr('value')==='<?php echo NOT_REINICIO_EQUIPO ?>'){ //Equipo reinicio
	   		$('#trPersona').hide();
	   		$('#trEquipo').show();
	   		$('#trRepetir').hide();
	   		$('#trFecha').hide();
	   		$('#trAccion').hide();
	   }else if($(this).find('option:selected').attr('value')==='<?php echo NOT_LLEGADA_TARDE ?>'){ 
	   		$('#trPersona').show();
	   		$('#trEquipo').hide();
	   		$('#trRepetir').hide();
	   		$('#trFecha').hide();
	   		$('#trAccion').hide();
	   }else if($(this).find('option:selected').attr('value')==='<?php echo NOT_AUSENCIA ?>'){ 
	   		$('#trPersona').show();
	   		$('#trEquipo').hide();
	   		$('#trRepetir').hide();
	   		$('#trFecha').hide();
	   		$('#trAccion').hide();
	   }else if($(this).find('option:selected').attr('value')==='<?php echo NOT_LLEGADA_TEMPRANA ?>'){ 
	   		$('#trPersona').show();
	   		$('#trEquipo').hide();
	   		$('#trRepetir').hide();
	   		$('#trFecha').hide();
	   		$('#trAccion').hide();
	   }else if($(this).find('option:selected').attr('value')==='<?php echo NOT_SALIDA_TARDE ?>'){ 
	   		$('#trPersona').show();
	   		$('#trEquipo').hide();
	   		$('#trRepetir').hide();
	   		$('#trFecha').hide();
	   		$('#trAccion').hide();
	   }else{
	   		$('#trPersona').hide();
				$('#trDispositivo').hide();
				$('#trEquipo').hide();
				$('#trZona').hide();
				$('#trRepetir').hide();
				$('#trFecha').hide();
				$('#trAccion').hide();
	   }
	   
	});
		
	$('#selTipoc').change(function() {	   
	   if($(this).find('option:selected').attr('value')==='1'){//Aviso
	   		$('#trMensajec').show();
	   		$('#trDetallec').show();
	   		$('#trPersonac').hide();
				$('#trEquipoc').hide();
	   		$('#trIntervaloc').hide();
	   		$('#trReportec').hide();
	   		$('#selRolc').hide();
				$('#trPersonac').hide();

	   }else if($(this).find('option:selected').attr('value')==='2'){ //reporte
	   		$('#trReportec').show();
				$('#trIntervaloc').show();
				$('#trDetallec').show();
	   		$('#trMensajec').hide();	   	
	   		$('#trPersonac').hide();
	   		$('#selRolc').hide();
				$('#trEquipoc').hide();
	   }else{
	   		$('#trReportec').hide();
				$('#trIntervaloc').hide();
				$('#trDetallec').hide();
	   		$('#trMensajec').hide();	   	
	   		$('#trPersonac').hide();
	   		$('#selRolc').hide();
				$('#trEquipoc').hide();
	   }
	   
	});
	
	$('#selReportec').change(function() {
	   
	   if($(this).find('option:selected').attr('value')==='<?php echo NOT_REPORTE_DE_EQUIPO ?>'){ //reporte por Equipo
	   		$('#trPersonac').hide();
	   		$('#trEquipoc').show();
	   		
	   }else if($(this).find('option:selected').attr('value')==='<?php echo NOT_REPORTE_DE_ALARMAS ?>'){ //reporte de alarmas
	   		$('#trPersonac').hide();
	   		$('#trEquipoc').hide();
	   		
	   }else if($(this).find('option:selected').attr('value')==='<?php echo NOT_REPORTE_GENERAL ?>'){ //reporte general
	   		$('#trPersonac').hide();
	   		$('#trEquipoc').hide();
	   		
	   	}else if($(this).find('option:selected').attr('value')==='<?php echo NOT_REPORTE_DE_LLEGADA_TARDE ?>'){ 
	   		$('#trPersonac').show();
	   		$('#trEquipoc').hide();
	   		if($("#selPersonac option[value='SelectRol']").length <= 0)
	   			$("#selPersonac option").eq(1).before('<option value="SelectRol"><?php echo _("Grupos"); ?></option');//si saque la opcion de grupo, la agrego de nuevo
	   		
	   	}else if($(this).find('option:selected').attr('value')==='<?php echo NOT_REPORTE_DE_ENTRADAS_SALIDAS ?>'){ 
	   		$('#trPersonac').show();
	   		$('#trEquipoc').hide();
	   		if($("#selPersonac option[value='SelectRol']").length <= 0)
	   			$("#selPersonac option").eq(1).before('<option value="SelectRol"><?php echo _("Grupos"); ?></option');//si saque la opcion de grupo, la agrego de nuevo
	   		
	   	}else if($(this).find('option:selected').attr('value')==='<?php echo NOT_REPORTE_DE_DIAS_HORAS_TRABAJADAS ?>'){ 
	   		$('#trPersonac').show();
	   		$('#trEquipoc').hide();
	   		if($("#selPersonac option[value='SelectRol']").length <= 0)
	   			$("#selPersonac option").eq(1).before('<option value="SelectRol"><?php echo _("Grupos"); ?></option');//si saque la opcion de grupo, la agrego de nuevo
	   		
	   	}else if($(this).find('option:selected').attr('value')==='<?php echo NOT_REPORTE_DE_AUSENCIAS ?>'){ 
	   		$('#trPersonac').show();
	   		$('#trEquipoc').hide();
	   		if($("#selPersonac option[value='SelectRol']").length <= 0)
	   			$("#selPersonac option").eq(1).before('<option value="SelectRol"><?php echo _("Grupos"); ?></option');//si saque la opcion de grupo, la agrego de nuevo	
	   	}
	});
	
	
	$('#selPersonac').change(function() {	   
	   if($(this).find('option:selected').attr('value')==='SelectRol'){
	   		$('#selRolc').show();
	   }else{ //diferido
	   		$('#selRolc').hide();
	   }
	});
	
	



$(document).ready(function() {
		//$('#editar').on('shown.bs.modal', function() {
				
				$('#trDisparador').hide();
				$('#trEquipo').hide();
				$('#trRepetir').hide();
				$('#trFecha').hide(); 
				$('#selRol').hide(); 

				<?php	if (isset($T_Modificar) && $i_Tipod!=1):?>
					$('#trDisparador').show();
					$('#trAccion').show();
				<?php	endif; ?>

				<?php if($i_Disparador!=null || isset ($T_Error['disparador']) || (isset ($_POST['disparador']) && $_POST['disparador']!='')): ?>
					$('#trDisparador').show();
				<?php endif; ?>

				<?php //	$('#selDisparador').find('option:selected').attr('value')== ?>

				<?php if($i_Persona!=null || isset ($T_Error['persona']) || (isset ($_POST['persona']) && $_POST['persona']!='')): ?>
					$('#trPersona').show();
				<?php endif; ?>
	
	
				<?php if($i_Equipo!=null || isset ($T_Error['Equipo']) || (isset ($_POST['Equipo']) && $_POST['Equipo']!='')): ?>
					$('#trEquipo').show();
				<?php endif; ?>

				<?php if($i_Grupos!=null || isset ($T_Error['grupos']) || (isset ($_POST['grupos']) && $_POST['grupos']!='')): ?>
					$('#selRol').show();
					$('#trPersona').show();
				<?php endif; ?>

				<?php if($i_Tipod==1): //diferido?>
					$('#trRepetir').show();
					$('#trFecha').show();
				<?php endif; ?>

				<?php	if ( $i_Tipod!=1): ?>
					$(document).ready(function () {
						$('#selDisparador').trigger("change");
					});
				<?php	endif; ?>
	
	
	

	
				$('#trMensajec').hide();
				$('#trPersonac').hide();
				$('#trEquipoc').hide();
				$('#trReportec').hide();
				$('#trIntervaloc').hide();
				$('#trDetallec').hide();
	
				<?php if($i_Tipoc==1): //aviso ?>
					$('#trMensajec').show();
					$('#trDetallec').show();
				<?php endif; ?>
				<?php if($i_Tipoc==2): //reporte ?>
					$('#trReportec').show();
					$('#trIntervaloc').show();
					$('#trDetallec').show();
				<?php endif; ?>
	
	
				<?php if($i_Personac!=null || isset ($T_Error['personac']) || (isset ($_POST['personac']) && $_POST['personac']!='')): ?>
					$('#trPersonac').show();
				<?php endif; ?>

				<?php if($i_Equipoc!=null || isset ($T_Error['Equipoc']) || (isset ($_POST['Equipoc']) && $_POST['Equipoc']!='')): ?>
					$('#trEquipoc').show();
				<?php endif; ?>

				<?php if($i_Intervaloc!=null || isset ($T_Error['intervaloc']) || (isset ($_POST['intervaloc']) && $_POST['intervaloc']!='')): ?>
					$('#trIntervaloc').show();
				<?php endif; ?>

				<?php if($i_Grupoc!=null || isset ($T_Error['rolc']) || (isset ($_POST['rolc']) && $_POST['rolc']!='')): ?>
					$('#selRolc').show();
					$('#trPersonac').show();
				<?php endif; ?>
			
			
			
			
				$('#selTipo').trigger("change");
				$('#selTipoc').trigger("change");
				$('#selReportec').trigger("change");
				$('#selPersonac').trigger("change");
		//});//end del after modal shown
					
		
	
		
		
		
    $('#submit-editar').click(function(){
        var $form = $('#editar-form');
		
		if (!$('#editar-form').valid()) {
			return false;
		}else{
		
	        $.ajax({
	            type: $form.attr('method'),
	            url: $form.attr('action'),
	            data: $form.serialize(),
	 
	            success: function(data, status) { 
                        
	            	$('#editar').modal('hide');
								$('#editar').on('hidden.bs.modal', function () {
								$('#content').css({opacity : '0.0'}).html(data).delay(50).animate({opacity : '1.0'}, 300);							
								$('#editar').off('hidden.bs.modal');
					});
	            }
	        });
 		}
		    
    }); 
});


</script>