w<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '.html.php') . '.php';  ?>

<?php if (isset($T_Mensaje) && $T_Mensaje!=null): ?>
<div class="alert alert-success fade in">
	<button class="close" data-dismiss="alert">
		×
	</button>
	<i class="fa-fw fa fa-check"></i>
	<strong>Éxito!</strong> <?=$T_Mensaje?>
</div>
<?php endif; ?>

<?php if (isset($T_Error) && $T_Error!=null): ?>
<div class="alert alert-danger fade in">
	<button class="close" data-dismiss="alert">
		×
	</button>
	<i class="fa-fw fa fa-times"></i>
	<strong>Error!</strong> <?php if(is_array($T_Error)) print_r($T_Error); else echo $T_Error; ?>
</div>
<?php endif; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">
	
	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-cogs"></i> 
				<?php echo _('Configuración') ?> 
			<span>>  
				<?php echo _('Opciones del Sistema') ?>
			</span>
		</h1>
	</div>
	<!-- end col -->
	
	

</div>
<!-- end row -->





<!-- widget grid -->
<section id="widget-grid" class="">
<?php if (!is_null($o_ListadoSecciones)): ?>
		<div class="row"><!-- row -->

	
	
		
		<!-- NEW WIDGET START -->
		<article class=" col-sm-1 col-md-1 col-lg-2"></article> 
		<article class="col-xs-12 col-sm-10 col-md-10 col-lg-8">
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-123" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" > 
				<header>
					<span class="widget-icon"> <i class="fa fa-cogs"></i> </span>
					<h2><?php echo _('Opciones del Sistema') ?></h2>
				</header>
				<div><!-- widget div-->
					<div class="jarviswidget-editbox"></div><!-- end widget edit box -->
						<div class="widget-body no-padding"><!-- widget content -->
						<form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form" action="<?php echo 'ajax/'.$Item_Name.'.html.php' ?>?tipo=save" >
								<?php $i=0; ?>
								<?php	foreach ($o_ListadoSecciones as $seccion): ?>	
										<fieldset>
										<legend><?php echo htmlentities($seccion->getSeccion(), ENT_QUOTES, 'utf-8'); ?></legend>
										<?php	$o_Listado = Config_L::obtenerTodosPorSeccion($seccion->getSeccion()); ?>
										<?php	foreach ($o_Listado as $key => $item): 										
												if(!$item->getVisible())continue; 
												?>
												<div class="row">
												<?php if($item->getTipo()=='si_no' || $item->getTipo()=='si_no_invertido'){ ?>
												<section class="col col-5">			
												<?php } else { ?>
												<section class="col col-10" style="width: 100%;">	
												<?php } ?>
																					
												<?php
														switch ($item->getTipo()){
																case 'numerico':
																?>	<label class="label">	<?php echo htmlentities($item->getDetalle(), ENT_QUOTES, 'utf-8'); ?></label>
																		<label class="input">
																		<input type="text" autocomplete="off" size="5" name="pregunta[<?php echo $item->getId(); ?>]" value="<?php echo (isset($T_Pregunta[$item->getId()]))?$T_Pregunta[$item->getId()]:$item->getValor(); //$item->getValor(); ?>" /> 
																		</label>	
																<?php
																break;
																case 'string':
																?>	<label class="label">	<?php echo htmlentities($item->getDetalle(), ENT_QUOTES, 'utf-8'); ?></label>	
																		<label class="input">
																		<input type="text" autocomplete="off" size="35" name="pregunta[<?php echo $item->getId(); ?>]" value="<?php echo (isset($T_Pregunta[$item->getId()]))?$T_Pregunta[$item->getId()]:$item->getValor(); //$item->getValor(); ?>" /> 
																		</label>	
																<?php
																break;
																case 'si_no':
																?>	<label class="toggle">
																		<input type="hidden" name="<?php echo "pregunta[".$item->getId()."]"; ?>" value="">
																		<input type="checkbox" name="<?php echo "pregunta[".$item->getId()."]"; ?>" <?php echo ($item->getValor() == '1')?'checked="checked"':'' ?>>	
																		<i data-swchon-text="Si" data-swchoff-text="No"></i><?php echo htmlentities($item->getDetalle(), ENT_QUOTES, 'utf-8'); ?>
																		</label>	
																<?php
																break;
																case 'password':
																?>	<label class="label">	<?php echo htmlentities($item->getDetalle(), ENT_QUOTES, 'utf-8'); ?></label>	
																		<label class="input">
																		<input type="password" autocomplete="off" size="35" name="pregunta[<?php echo $item->getId(); ?>]" value="<?php echo (isset($T_Pregunta[$item->getId()]))?$T_Pregunta[$item->getId()]:$item->getValor(); //$item->getValor(); ?>" /> 
																		</label>			
																<?php
																break;

														}
														 echo (isset ($T_Error['e'.$item->getId()]))?'<p class="error">'.htmlentities($T_Error['e'.$item->getId()], ENT_COMPAT, 'utf-8').'</p>':''; 
												?>

												</section>									
												</div>
										<?php	endforeach; ?>
										</fieldset>
								<?php $i++; ?>		
								<?php	endforeach; ?>		<!-- end seccion -->
						</form>		
						<div class="modal-footer">		
						<button type="submit" class="btn btn-primary" data-dismiss="modal" id="submit-editar">
						<?php echo _("Guardar"); ?>
						</button>	
						</div>
					</div><!-- end widget content -->					
				</div><!-- end widget div -->				
			</div><!-- end widget -->				
		</article><!-- WIDGET END -->
	</div><!-- end row -->
<?php endif; ?>
</section>
<!-- end widget grid -->





<script type="text/javascript">
	
	
	 
	pageSetUp();
	
	if($('.DTTT_dropdown.dropdown-menu').length){
		$('.DTTT_dropdown.dropdown-menu').remove();
	}
<?php
//INCLUYO el js de las datatables
require_once APP_PATH . '/includes/data_tables.js.php';
?>
	

	
	
$(document).ready(function() {
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
						$('#content').css({opacity : '0.0'}).html(data).delay(50).animate({opacity : '1.0'}, 300);							
	            }
	        });
 		}
		    
    }); 
});


</script>


<?php require_once APP_PATH . '/includes/chat_widget.php'; ?>


