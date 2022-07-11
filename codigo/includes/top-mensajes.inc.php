

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


