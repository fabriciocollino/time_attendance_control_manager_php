<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-acciones.html.php') . 's' . '.php';  ?>


<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="modalTitle"><?php echo _("Configuración"); ?></h4>
</div>
<div class="modal-body">
		
	<form class="smart-form" novalidate="novalidate" data-async method="post" id="config-form" action="<?php echo 'ajax/'.$Item_Name.'s.html.php' ?>?tipo=<?php echo "config&id=".$o_Equipo->getId(); ?>"> 
			<?php if ($o_Equipo->getId()!=null) echo '<input type="hidden" id="ItemID" name="ItemID" value="'.$o_Equipo->getId().'">'; ?>

						<fieldset>
								<legend><?php echo htmlentities($o_Equipo->getDetalle(), ENT_COMPAT, 'utf-8'); ?></legend>
								<div class="row">
									<section class="col col-4">
											<label>Borrar Usuarios</label>
									</section>		
									<section class="col col-4"> 
											<button type="button" title="<?php echo _('Borrar') ?>" class="btn btn-default btn-sm " style="line-height: .75em;" data-type="accion" data-id="<?php echo $o_Equipo->getId(); ?>" data-accion="borrarusuarios" ><?php echo _('Borrar') ?></button>
									</section>	
								</div>
								<div class="row">
									<section class="col col-4">
											<label>Resetear Configuración</label>
									</section>		
									<section class="col col-4"> 
											<button type="button" title="<?php echo _('Resetear') ?>" class="btn btn-default btn-sm " style="line-height: .75em;" data-type="accion" data-id="<?php echo $o_Equipo->getId(); ?>" data-accion="resetconfig" ><?php echo _('Resetear') ?></button>
									</section>	
								</div>
								<div class="row">
									<section class="col col-4">
											<label>Reiniciar</label>
									</section>		
									<section class="col col-4"> 
											<button type="button" title="<?php echo _('Reiniciar') ?>" class="btn btn-default btn-sm " style="line-height: .75em;" data-type="accion" data-id="<?php echo $o_Equipo->getId(); ?>" data-accion="reiniciar" ><?php echo _('Reiniciar') ?></button>
									</section>	
								</div>
								<div class="row">
									<section class="col col-4">
											<label>Enviar Fecha y Hora</label>
									</section>		
									<section class="col col-4"> 
											<button type="button" title="<?php echo _('Enviar Fecha y Hora') ?>" class="btn btn-default btn-sm " style="line-height: .75em;" data-type="accion" data-id="<?php echo $o_Equipo->getId(); ?>" data-accion="enviarfechayhora" ><?php echo _('Enviar') ?></button>
									</section>	
								</div>
								<div class="row">
									<section class="col col-4">
											<label>Re-Enviar Configuración</label>
									</section>		
									<section class="col col-4"> 
											<button type="button" title="<?php echo _('Re-Enviar') ?>" class="btn btn-default btn-sm " style="line-height: .75em;" data-type="accion" data-id="<?php echo $o_Equipo->getId(); ?>" data-accion="reenviarconfig" ><?php echo _('Re-Enviar') ?></button>
									</section>	
								</div>
								<div class="row">
									<section class="col col-4">
											<label>Comando Personalizado</label>
									</section>	
									<section class="col col-4"> 
											<input type="text" name="Ccomando" placeholder="" value="">
									</section>	
									<section class="col col-4"> 
											<button type="button" title="<?php echo _('Enviar') ?>" class="btn btn-default btn-sm " style="line-height: .75em;" data-type="accion" data-id="<?php echo $o_Equipo->getId(); ?>" data-accion="enviarcomando" ><?php echo _('Enviar') ?></button>
									</section>	
								</div>
								<div class="row">
									<section class="col col-4">
											<label>Comando Asincrónico</label>
									</section>	
									<section class="col col-4"> 
											<input type="text" name="CcomandoA" placeholder="" value="">
									</section>	
									<section class="col col-4"> 
											<button type="button" title="<?php echo _('Enviar') ?>" class="btn btn-default btn-sm " style="line-height: .75em;" data-type="accion" data-id="<?php echo $o_Equipo->getId(); ?>" data-accion="enviarcomandoa" ><?php echo _('Enviar') ?></button>
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
			
			$.SmartMessageBox({
				title : "Eliminar <?php echo $T_Titulo_Singular; ?>",
				content : "Está por eliminar <?php echo $T_Titulo_Pre; ?> <?php echo $T_Titulo_Singular; ?>. Todos los datos relacionados con este equipo serán Eliminados. </br>Esta operación no se puede deshacer. Desea continuar?",
				buttons : '[No][Si]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Si") {
						//esto refresca la pagina
						loadURLwData('<?php echo $Item_Name.'s' ?>',$('#content'),{tipo:view_type,id:data_id});
				}
				else if (ButtonPressed === "No") {
					
				}
	
			});			
	    
			
	  });
		
		
		
		
		$('a[data-type=accion], button[data-type=accion]').click(function () {	
	    var data_id = '';
	    var data_accion = '';
			var dataI = '';
	    if (typeof $(this).data('id') !== 'undefined') {
	      data_id = $(this).data('id');
	    }
	    if (typeof $(this).data('accion') !== 'undefined') {
	      data_accion = $(this).data('accion');
	    }
	
			
		if(data_accion==='enviarcomandoa'){
				dataI=$('input[name=CcomandoA]').val();
				$('input[name=CcomandoA]').val('');
				if(dataI===''){$.smallBox({title : "El comando está en blanco!",content : "",color : "#A65858",iconSmall : "fa fa-warning",timeout : 5000});return;}
				$.bigBox({
						title : "Enviando comando...",
						content : "El comando está siendo enviado al Equipo...",
						color : "#3276B1",
					  timeout: 30000,
						icon : "fa fa-refresh fa-spin",
						//number : "2"
						sound: false
					});
				$.ajax({
	        cache: false,
	        type: 'POST',
	        url: 'codigo/controllers/equipos.php',
	        data:  {tipo:'accion',id:data_id,cmd:data_accion,data:dataI},
	        success: function(dataR) 
	        {
							var returnID = dataR;
	            $("[id^=botClose]").click();
							$.bigBox({
								title : "Comando enviado!",
								content : "El comando ha sido enviado al Equipo, puede esperar para ver el resultado o cerrar este mensaje.",
								color : "#C79121",
								timeout: 30000,
								icon : "fa fa-bell swing animated",
								//number : "2"
								sound: false
							});
							checker = setInterval(function() {comandoAchecker(returnID);}, 2000);
								
	        }
				});
				
		}else if(data_accion==='enviarcomando'){
				dataI=$('input[name=Ccomando]').val();
				$('input[name=Ccomando]').val('');
				if(dataI===''){$.smallBox({title : "El comando está en blanco!",content : "",color : "#A65858",iconSmall : "fa fa-warning",timeout : 5000});return;}
				if(dataI==='reboot'){$.smallBox({title : "No se puede enviar un comando 'reboot' mediante este método. Por favor, utilice un envío asincrónico.",content : "",color : "#A65858",iconSmall : "fa fa-warning",timeout : 5000});return;}
				$.bigBox({
						title : "Enviando comando...",
						content : "El comando está siendo enviado al Equipo...",
						color : "#3276B1",
					  timeout: 30000,
						icon : "fa fa-refresh fa-spin",
						//number : "2"
						sound: false
				});
				$.ajax({
	        cache: false,
	        type: 'POST',
	        url: 'codigo/controllers/equipos.php',
	        data:  {tipo:'accion',id:data_id,cmd:data_accion,data:dataI},
	        success: function(dataR) 
	        {
							if(dataR==='OK'){
									$("[id^=botClose]").click();
									$.bigBox({
										title : "Comando recibido!",
										content : "El comando ha sido ejecutado correctamente en el Equipo.</br><small>Este mensaje se cerrará automáticamente</small>",
										color : "#739E73",
										timeout: 6000,
										icon : "fa fa-check shake animated",
										//number : "2"
										sound: true
									});
							}else{
									$("[id^=botClose]").click();
									$.bigBox({
										title : "Comando erróneo!",
										content : "Se ha producido un error. Detalles: " + dataR + ".</br><small>Este mensaje se cerrará automáticamente</small>",
										color : "#C46A69",
										timeout: 10000,
										icon : "fa fa-warning shake animated",
										//number : "2"
										sound: true
									});
							}
							
								
	        }
				});
		}else if(data_accion==='reenviarconfig'){
				$.bigBox({
						title : "Enviando comando...",
						content : "El comando está siendo enviado al Equipo...",
						color : "#3276B1",
					  timeout: 30000,
						icon : "fa fa-refresh fa-spin",
						//number : "2"
						sound: false
				});
				$.ajax({
	        cache: false,
	        type: 'POST',
	        url: 'codigo/controllers/equipos.php',
	        data:  {tipo:'accion',id:data_id,cmd:data_accion,data:dataI},
	        success: function(dataR) 
	        {
						$("[id^=botClose]").click();
						$.bigBox({
							title : "Comando recibido!",
							content : "Se reenviará toda la configuración al Equipo. Esto puede demorar varios minutos.</br><small>Este mensaje se cerrará automáticamente</small>",
							color : "#739E73",
							timeout: 6000,
							icon : "fa fa-check shake animated",
							//number : "2"
							sound: true
						});							
	        }
				});
		
		}else if(data_accion==='enviarfechayhora'){
				$.bigBox({
						title : "Enviando comando...",
						content : "El comando está siendo enviado al Equipo...",
						color : "#3276B1",
					  timeout: 30000,
						icon : "fa fa-refresh fa-spin",
						//number : "2"
						sound: false
				});
				$.ajax({
	        cache: false,
	        type: 'POST',
	        url: 'codigo/controllers/equipos.php',
	        data:  {tipo:'accion',id:data_id,cmd:data_accion,data:dataI},
	        success: function(dataR) 
	        {
							if(dataR==='OK'){
									$("[id^=botClose]").click();
									$.bigBox({
										title : "Comando recibido!",
										content : "El comando ha sido ejecutado correctamente en el Equipo.</br><small>Este mensaje se cerrará automáticamente</small>",
										color : "#739E73",
										timeout: 6000,
										icon : "fa fa-check shake animated",
										//number : "2"
										sound: true
									});
							}else{
									$("[id^=botClose]").click();
									$.bigBox({
										title : "Comando erróneo!",
										content : "Se ha producido un error. Detalles: " + dataR + ".</br><small>Este mensaje se cerrará automáticamente</small>",
										color : "#C46A69",
										timeout: 10000,
										icon : "fa fa-warning shake animated",
										//number : "2"
										sound: true
									});
							}
							
								
	        }
				});
		
		}else if(data_accion==='reiniciar'){
				$.bigBox({
						title : "Enviando comando...",
						content : "El comando está siendo enviado al Equipo...",
						color : "#3276B1",
					  timeout: 30000,
						icon : "fa fa-refresh fa-spin",
						//number : "2"
						sound: false
				});
				$.ajax({
	        cache: false,
	        type: 'POST',
	        url: 'codigo/controllers/equipos.php',
	        data:  {tipo:'accion',id:data_id,cmd:data_accion,data:dataI},
	        success: function(dataR) 
	        {
						$("[id^=botClose]").click();
						$.bigBox({
							title : "Comando recibido!",
							content : "Se ha disparado un reinicio del equipo.</br><small>Este mensaje se cerrará automáticamente</small>",
							color : "#739E73",
							timeout: 6000,
							icon : "fa fa-check shake animated",
							//number : "2"
							sound: true
						});							
	        }
				});
		
		}else if(data_accion==='resetconfig'){
				$.SmartMessageBox({
								title : "Está por resetear la configuración del Equipo",
								content : "El Equipo perderá la conexión con el servidor y deberá ser reestablecida manualmente. </br>Desea continuar?",
								buttons : '[No][Si]'
							}, function(ButtonPressed) {
								if (ButtonPressed === "Si") {
										//continuamos
										$.bigBox({
												title : "Enviando comando...",
												content : "El comando está siendo enviado al Equipo...",
												color : "#3276B1",
												timeout: 30000,
												icon : "fa fa-refresh fa-spin",
												//number : "2"
												sound: false
										});
										$.ajax({
											cache: false,
											type: 'POST',
											url: 'codigo/controllers/equipos.php',
											data:  {tipo:'accion',id:data_id,cmd:data_accion,data:dataI},
											success: function(dataR) 
											{
													if(dataR==='OK'){
															$("[id^=botClose]").click();
															$.bigBox({
																title : "Comando recibido!",
																content : "El comando ha sido ejecutado correctamente en el Equipo.</br><small>Este mensaje se cerrará automáticamente</small>",
																color : "#739E73",
																timeout: 6000,
																icon : "fa fa-check shake animated",
																//number : "2"
																sound: true
															});
													}else{
															$("[id^=botClose]").click();
															$.bigBox({
																title : "Comando erróneo!",
																content : "Se ha producido un error. Detalles: " + dataR + ".</br><small>Este mensaje se cerrará automáticamente</small>",
																color : "#C46A69",
																timeout: 10000,
																icon : "fa fa-warning shake animated",
																//number : "2"
																sound: true
															});
													}


											}
										});
								}
								else if (ButtonPressed === "No") {
										return;		
								}
				});
				
		
		}else if(data_accion==='borrarusuarios'){
				$.SmartMessageBox({
								title : "Está por eliminar todos los usuarios del Equipo",
								content : "Está por eliminar todos los usuarios del Equipo. </br>Desea continuar?",
								buttons : '[No][Si]'
							}, function(ButtonPressed) {
								if (ButtonPressed === "Si") {
										//continuamos
										$.bigBox({
												title : "Enviando comando...",
												content : "El comando está siendo enviado al Equipo...",
												color : "#3276B1",
												timeout: 30000,
												icon : "fa fa-refresh fa-spin",
												//number : "2"
												sound: false
										});
										$.ajax({
											cache: false,
											type: 'POST',
											url: 'codigo/controllers/equipos.php',
											data:  {tipo:'accion',id:data_id,cmd:data_accion,data:dataI},
											success: function(dataR) 
											{
													if(dataR==='OK'){
															$("[id^=botClose]").click();
															$.bigBox({
																title : "Comando recibido!",
																content : "El comando ha sido ejecutado correctamente en el Equipo.</br><small>Este mensaje se cerrará automáticamente</small>",
																color : "#739E73",
																timeout: 6000,
																icon : "fa fa-check shake animated",
																//number : "2"
																sound: true
															});
													}else{
															$("[id^=botClose]").click();
															$.bigBox({
																title : "Comando erróneo!",
																content : "Se ha producido un error. Detalles: " + dataR + ".</br><small>Este mensaje se cerrará automáticamente</small>",
																color : "#C46A69",
																timeout: 10000,
																icon : "fa fa-warning shake animated",
																//number : "2"
																sound: true
															});
													}


											}
										});
								}
								else if (ButtonPressed === "No") {
										return;		
								}
				});
				
		
		}
		
					
	    
			
	  });
		
		


		function comandoAchecker(ComandoID){
				$.ajax({
	        cache: false,
	        type: 'POST',
	        url: 'codigo/controllers/equipos.php',
	        data:  {tipo:'accion',id:ComandoID,cmd:'checksyncstatus'},
	        success: function(data) 
	        {
							if(data==="3"){//correcto
									$("[id^=botClose]").click();
									$.bigBox({
										title : "Comando recibido!",
										content : "El comando ha sido ejecutado correctamente en el Equipo.</br><small>Este mensaje se cerrará automáticamente</small>",
										color : "#739E73",
										timeout: 6000,
										icon : "fa fa-check shake animated",
										//number : "2"
										sound: true
									});
									clearInterval(checker);
							}else if(data==="4"){ //error
									$("[id^=botClose]").click();
									$.bigBox({
										title : "Comando erróneo!",
										content : "El comando ha sido recibido por el Equipo, pero produjo un error al ser ejecutado.</br><small>Este mensaje se cerrará automáticamente</small>",
										color : "#C46A69",
										timeout: 10000,
										icon : "fa fa-warning shake animated",
										//number : "2"
										sound: true
									});
									clearInterval(checker);
							}	
	        }
				});
				
		}
		//clearTimeout(checker);

</script>

