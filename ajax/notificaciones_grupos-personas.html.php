<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-personas.html.php') . '.php';  ?>

<?php if($T_Tipo=="insert"){
		//esto es para el ajax del insertar/eliminar, para que solo devuelva el output del controller
}
else{
?>		
		
		


<style>
.modal-content {
  width: 150%;
  margin-left: -25%;
}
</style>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="modalTitle"><?php if ($o_Grupo->getId()==null) echo _("Agregar Grupo"); else echo _("Agregar personas al Grupo"); ?></h4>
</div>
<div class="modal-body" style="padding-top: 0px;">
	
	
	<form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form" action="#"> 


							<fieldset>
								<legend>Personas</legend>
								<div class="row">
									<section class="col col-5" >
										<select multiple="multiple" size="15" id="selPersonas" class="form-control custom-scroll" title="Seleccione las Personas">
											<?php echo $a_Personas; ?>
										</select>
										<label class="input" style="margin-top: 10px;"> <i class="icon-prepend fa fa-envelope"></i>
											<input type="text" id="emailt" name="emailt" placeholder="Agregar un Email">
										</label>	
									</section>	
									<section class="col col-2" style="text-align: center;">
											<div class="row">
												<button data-id="btnAdd" title="<?php echo _('Agregar Personas') ?>" onclick="AgregarPersonas();return false;" class="btn btn-default btn-sm fa fa-arrow-right fa-lg" style="line-height: .75em;margin-bottom: 10px;margin-top: 90px;">&nbspAgregar&nbsp;</button>
											</div>
											<div id="loader" style="height: 30px;"></div>
											<div class="row">
												<button data-id="btnRmEmail" title="<?php echo _('Eliminar Personas') ?>" onclick="EliminarPersonas();return false;" class="btn btn-default btn-sm fa fa-arrow-left fa-lg" style="line-height: .75em;margin-bottom: 72px;margin-top: 10px;">&nbspEliminar</button>
											</div>
											<div class="row">
												<button data-id="btnAddEmail" title="<?php echo _('Agregar Email') ?>" onclick="AgregarEmail();return false;" class="btn btn-default btn-sm fa fa-arrow-right fa-lg" style="line-height: .75em;">&nbspAgregar Email</button>
											</div>
									</section>		
									<section class="col col-5" >
										<select multiple="multiple" id="selPersonasGrupo" size="17" style="height: 312px;" class="form-control custom-scroll" title="Personas del Grupo">
											<?php echo $a_PersonasGrupo; ?>
										</select>
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


<script type="text/javascript">


$(document).ready(function() {
		//$('#editar').on('shown.bs.modal', function() {
				
				
		//});//end del after modal shown
					
		
	
		
		
		
     
});

function AgregarPersonas(){	
	$("#selPersonas option:selected").each(function () {
			
		$('#loader').html('<img src="<?php echo WEB_ROOT; ?>/img/loading.gif" width="30" />');
		var persona=$(this).attr('value');
	    $.ajax({url:'<?php echo 'ajax/'.$Item_Name.'.html.php' ?>?tipo=insert&id=<?php echo $T_Id; ?>&persona='+persona,dataType:'html',async:true,timeout:5000,  //timeout de 5 segundos
	        success:function(text){	

	        	if(text){
	        		if(text=="error_persona_ya_existe"){
	        			alert("<?php echo _('La persona que intenta agregar, ya existe en el grupo.') ?>");
	        			$('#loader').html('');
	        			return false;
        			}
	        		$('#selPersonasGrupo').empty();
			        $('#selPersonasGrupo').append(text);
			        $('#loader').html('');
	        	}
	        	           
	        },
	        error:function(text){alert("Error.");}
	        
		});
  });
};

function EliminarPersonas(){	
	$("#selPersonasGrupo option:selected").each(function () {
		$('#loader').html('<img src="<?php echo WEB_ROOT; ?>/img/loading.gif" width="30" />');
		var persona=$(this).attr('value');
	    $.ajax({url:'<?php echo 'ajax/'.$Item_Name.'.html.php' ?>?tipo=remove&id=<?php echo $T_Id; ?>&GpersonaID='+persona,dataType:'html',async:true,timeout:5000,  //timeout de 5 segundos
	        success:function(text){	        	
	        	if(text){	        		
	        		$('#selPersonasGrupo').empty();
			        $('#selPersonasGrupo').append(text);
			        $('#loader').html('');
	        	}
	        	           
	        },
	        error:function(text){alert("Error.");}
	        
		});
  });
};

function AgregarEmail(){		
	
	var email=$('#emailt').val();
	if (email) {  
	    if (!isValidEmailAddress(email)) {
	        alert('<?php echo _('Debe ingresar una dirección de Email correcta') ?>');
	        return false;  
	    }
	}else{
		alert('<?php echo _('Debe ingresar una dirección de Email') ?>');
		return false;
	} 
    $('#loader').html('<img src="<?php echo WEB_ROOT; ?>/img/loading.gif" width="30" />');
    $.ajax({url:'<?php echo 'ajax/'.$Item_Name.'.html.php' ?>?tipo=insertemail&id=<?php echo $T_Id; ?>&email='+email,dataType:'html',async:true,timeout:5000,  //timeout de 5 segundos
        success:function(text){	        	
        	if(text){
        		if(text=="error_email_ya_existe"){
	        			alert("<?php echo _('El email que intenta agregar, ya existe en el grupo.') ?>");
	        			$('#loader').html('');
	        			return false;
    			}
        		$('#selPersonasGrupo').empty();
		        $('#selPersonasGrupo').append(text);
		        $('#loader').html('');
		        $('#emailt').val('');
        	}
        	           
        },
        error:function(text){alert("Error.");}
        
	});

};



$("#selPersonas").dblclick(function () {
  
  AgregarPersonas();
  
})
.trigger('change');





function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};





$('#editar').on('hidden.bs.modal', function () {
		//esto refresca la pagina
		loadURL('<?php echo $Item_Name ?>',$('#content'));
  
	
});





</script>






<?php } ?>


