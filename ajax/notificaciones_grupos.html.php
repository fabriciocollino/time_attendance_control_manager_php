<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php';  ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">
	
	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-users"></i> 
				<?php echo _('Notificaciones') ?> 
			<span>>
				<?php echo _('Grupos de Personas') ?>
			</span>
		</h1>
	</div>
	<!-- end col -->
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8" style="text-align: right;padding-top: 20px;">
		<button class="btn btn-sm btn-primary" type="button" data-backdrop="static" data-toggle="modal" data-target="#editar" data-type="view" data-lnk="ajax/<?=$Item_Name?>-editar.html.php" >
			<?php echo _('Agregar Grupo') ?>
		</button>
	</div>
	

</div>
<!-- end row -->





<!-- widget grid -->
<section id="widget-grid" class="">

	<!-- row -->
	<div class="row">
				
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-sortable="false" > 

				<header>
					<span class="widget-icon"> <i class="fa fa-users"></i> </span>
					<h2><?php echo _('Listado de Grupos') ?></h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<table id="dt_basic" class="table table-striped table-hover dataTable no-footer" aria-describedby="dt_basic_info"  style="width: 100%;">
							<thead>
								<tr>									
										<th><?php echo _('Nombre') ?></th>							
										<th><?php echo _('Personas') ?></th>
										<th><?php echo _('Acciones') ?></th>	
								</tr>
							</thead>
							<tbody>
								<?php if (!is_null($o_Listado)): ?>
									
									<?php	foreach ($o_Listado as $key => $item): ?>
												<tr>
												<td><?php echo htmlentities($item->getDetalle(), ENT_QUOTES, 'utf-8'); ?> </td>						
												<td><a data-toggle="modal" data-target="#editar" data-type="personas" data-lnk="ajax/notificaciones_grupos-personas.html.php" data-id="<?php echo $item->getId();?>" title="Ver Personas" style="cursor: pointer;"><?php echo $item->getPersonasCount(); ?></a></td>	

												<td>							
													<button data-toggle="modal" data-backdrop="static" data-target="#editar" data-type="personas" data-lnk="ajax/notificaciones_grupos-personas.html.php" data-id="<?php echo $item->getId();?>" title="<?php echo _('Agregar Personas') ?>" class="btn btn-default btn-sm fa fa-user fa-lg" style="line-height: .75em;"><i class="fa fa-plus fa-xs"></i></button>
													<button data-toggle="modal" data-backdrop="static" data-target="#editar" data-type="view" data-lnk="ajax/notificaciones_grupos-editar.html.php" data-id="<?php echo $item->getId();?>" title="<?php echo _('Editar Nombre') ?>" class="btn btn-default btn-sm fa fa-edit fa-lg" style="line-height: .75em;"></button>
													<button data-type="delete" data-lnk="ajax/notificaciones_grupos-personas.html.php" data-id="<?php echo $item->getId();?>" title="<?php echo _('Eliminar Grupo') ?>" class="btn btn-default btn-sm fa fa-trash-o fa-lg" style="line-height: .75em;"></button>													
												</td>
											</tr>
									<?php	endforeach; ?>
									
									
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

		if($('.DTTT_dropdown.dropdown-menu').length){
			$('.DTTT_dropdown.dropdown-menu').remove();
		}
		<?php
				//INCLUYO el js de las datatables
				require_once APP_PATH . '/includes/data_tables.js.php';
		?>

	//esto asigna el ID al modal cada vez que se hace click en el boton
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
				content : "Está por eliminar <?php echo $T_Titulo_Pre; ?> <?php echo $T_Titulo_Singular; ?>. Esta operación no se puede deshacer. Desea continuar?",
				buttons : '[No][Si]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Si") {
						//esto refresca la pagina
						loadURLwData('<?php echo $Item_Name ?>',$('#content'),{tipo:view_type,id:data_id});
				}
				else if (ButtonPressed === "No") {
					
				}
	
			});			
	    
			
	  });
		
		
	  
	  
	});
	
	


	
</script>


<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>

