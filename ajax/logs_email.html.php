<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php';  ?>
<?php $Filtro_Form_Action = "ajax/".basename(__FILE__); ?>

<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">
	
	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-envelope"></i> 
				<?php echo _('Logs') ?> 
			<span>>  
				<?php echo _('Emails') ?>
			</span>
		</h1>
	</div>
	<!-- end col -->

	

</div>
<!-- end row -->





<!-- widget grid -->
<section id="widget-grid" class="">

		<div class="row">
		
		<?php require_once APP_PATH.'/includes/widgets/widget_filtro_intervalos.html.php';  ?>
		
		</div>
		
		
	<!-- row -->
	<div class="row">
		
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-sortable="false" > 

				<header>
					<span class="widget-icon"> <i class="fa fa-envelope"></i> </span>
					<h2><?php echo _('Logs de Emails') ?></h2>

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
										<th width="10%"><?php echo _('Fecha') ?></th>
										<th width="15%"><?php echo _('Destinatario') ?></th>					
										<th width="20%"><?php echo _('Sujeto') ?></th>
                                                                                <?php if(Config_L::p('mostrar_contenido_email')) { ?><th width="30%"><?php echo _('Mensaje') ?></th><?php } ?>
										<th width="40%"><?php echo _('Adjunto') ?></th>
										<th width="40%"><?php echo _('Estado') ?></th>
										<th width="40%"><?php echo _('Acciones') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!is_null($o_Listado)): ?>
									
									<?php	foreach ($o_Listado as $key => $item): ?>
										<tr>
					
										<td><?php echo $item->getFecha(Config_L::p('f_fecha_corta')); ?></td>					
										<?php $destinatario="";
										if($item->getGrupal()) {
											$o_Grupo=Grupo_L::obtenerPorId($item->getGrupo());
											$destinatario = $o_Grupo->getDetalle()." (".$o_Grupo->getPersonasCount().")";
										}else{
											$destinatario=$item->getDestinatario();
										}
										?>
										<td><?php echo $destinatario ?></td>				
										<td><?php if (strlen($item->getSujeto())>60) echo substr($item->getSujeto(),0,60).'...'; else echo  $item->getSujeto();?></td>
                                                                                <?php if(Config_L::p('mostrar_contenido_email')) { ?><td><?php if (strlen($item->getCuerpo())>350) echo strip_tags(substr($item->getCuerpo(),0,350),'<p>').'...'; else echo strip_tags($item->getCuerpo(),'<p>');?></td><?php } ?>
										<td><?php echo $item->getAdjunto(); ?></td>
										<td><?php echo $item->getEstado_S(); ?></td>					
										<?php if($item->getEstado()==1) $Val=_("Enviar");
											 else $Val=_("Re-Enviar");
										?>					
										<td><a href="<?php echo $T_Script;?>.php?accion=enviar&amp;id=<?php echo $item->getId(); ?>" title="<?php echo $Val; ?>"><?php echo $Val; ?></a></td>

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
	  })
	});
	
	

    


	
</script>

<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>

