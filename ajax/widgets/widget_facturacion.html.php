<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php 




?>

<style>
    
</style>



    <div class="row show-grid">
        <div class="col-xs-6 col-sm-3 col-md-3">
            <h5 class="grid-Hleft">Estado:</h5>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <h5 style="margin:0px;"><small><span class="label label-success" style="line-height: 23px;margin-left: 5px;">Licenced</span></small></h5>
        </div>	        
    </div>
    
    <div class="row show-grid">
        <div class="col-xs-6 col-sm-3 col-md-3">
            <h5 class="grid-Hleft">Suscripción:</h5>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <h5 class="grid-Hright"><?php echo $o_Plan->getNombre();  ?></h5>
        </div>   
    </div>

    <div class="row show-grid">
        <div class="col-xs-6 col-sm-3 col-md-3">
            <h5 class="grid-Hleft">Licenciado a:</h5>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <h5 class="grid-Hright"><?php 
                
                if($o_Cliente->getNombre()=='' || $o_Cliente->getApellido()==''){
                    echo $o_Cliente->getEmpresa();
                }else{
                    echo $o_Cliente->getNombre()." ". $o_Cliente->getApellido();
                }
                //echo (defined('MULTI-DB') ? $o_Cliente->getNombre()." ". $o_Cliente->getApellido() : Config_L::p('empresa_nombre'));
                ?></h5>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-6 col-sm-3 col-md-3">
           <h5 class="grid-Hleft">Fecha de Inicio:</h5>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
           <h5 class="grid-Hright"><?php echo $o_Suscripcion->getFechaInicio();  ?></h5>
        </div>
    </div> 
    <div class="row show-grid">
        <div class="col-xs-6 col-sm-3 col-md-3">
          <h5 class="grid-Hleft">Fecha de Fin:</h5>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
          <h5 class="grid-Hright"><?php echo $o_Suscripcion->getFechaFin();  ?></h5>
        </div>	  
    </div>




<script type="text/javascript">
	
	
	
	
	
</script>


