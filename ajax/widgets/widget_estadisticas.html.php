<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php

SeguridadHelper::Pasar(20);

?>


<div class="row">

    <div class="col-xs-5 col-sm-4 col-md-4 col-lg-6" style="min-width:60px;">
        <h5 class="grid-Hleft">Equipos:</h5>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
        <h5 class="grid-Hright"><?php echo Equipo_L::obtenerCantidad(); ?></h5>
    </div>
</div>
<br>

<div class="row">

    <div class="col-xs-5 col-sm-4 col-md-4 col-lg-6" style="min-width:130px;">
        <h5 class="grid-Hleft">Total Personas:</h5>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
        <h5 class="grid-Hright"><?php echo Persona_L::obtenerCantidad(); ?></h5>
    </div>
</div>
<div class="row">

    <div class="col-xs-5 col-sm-4 col-md-4 col-lg-6" style="min-width:130px;">
        <h5 class="grid-Hleft"><span class="hidden-md hidden-1280">Personas </span>Bloqueadas:</h5>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
        <h5 class="grid-Hright"><?php echo Persona_L::obtenerCantidadBloqueadas(); ?></h5>
    </div>
</div>

  




