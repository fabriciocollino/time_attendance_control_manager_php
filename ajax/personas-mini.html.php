<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/personas.php'; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="modalTitle">
        Listado de Personas
    </h4>
</div>

<div class="modal-body"">

<?php // echo"<pre>";print_r($_POST);echo"</pre>"; ?>
<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">


        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                    <h2><?php echo _('Listado de Personas') ?></h2>

                </header>


                <div><!-- widget div-->

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox"><!-- This area used as dropdown edit box --></div>


                    <!-- widget content -->
                    <div class="widget-body no-padding">


                        <table id="dt_basic_1" class="table table-striped table-hover dataTable no-footer"
                               aria-describedby="dt_basic_info">
                            <thead>
                            <tr>

                                <th data-priority="1"><?php echo _('Apellido, Nombre') ?></th>
                                <th data-priority="2"><?php echo _('DNI') ?></th>
                                <th><?php echo _('Legajo') ?></th>
                                <th><?php echo _('Grupos') ?></th>
                                <th><?php echo _('Horario de Trabajo') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!is_null($o_Listado)): ?>

                                <?php foreach ($o_Listado as $key => $item): ?>
                                    <tr>

                                        <td><?php echo $item->getApellido() . ', ' . $item->getNombre(); ?></td>
                                        <td><?php echo $item->getDni(); ?></td>
                                        <td><?php echo $item->getLegajo(); ?></td>
                                        <td><?php
                                            $a_Grupos_Personas = Grupos_Personas_L::obtenerARRAYPorPersona($item->getId());
                                            if(is_null($a_Grupos_Personas)){
                                                echo '-';
                                            }else {
                                                $a_o_Grupos = Grupo_L::obtenerTodos();
                                                if ($a_o_Grupos != null) {
                                                    $salida = '';
                                                    foreach ($a_o_Grupos as $o_Grupo) {
                                                        if (in_array($o_Grupo->getId(), $a_Grupos_Personas))
                                                            $salida .= $o_Grupo->getDetalle() . " - ";
                                                    }
                                                    $salida = rtrim($salida, " - ");
                                                    echo $salida;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <?php switch ($item->getHorTipo()) {
                                            case HORARIO_NORMAL: ?>
                                                <td>
                                                    Normal: <?php echo Hora_Trabajo_L::obtenerPorId($item->getHorId())->getDetalle(); ?></td>
                                                <?php break;
                                            case HORARIO_FLEXIBLE: ?>
                                                <td>
                                                    Flexible: <?php echo Horario_Flexible_L::obtenerPorId($item->getHorId())->getDetalle(); ?></td>
                                                <?php break;
                                            case HORARIO_ROTATIVO: ?>
                                                <td>
                                                    Rotativo: <?php echo Horario_Rotativo_L::obtenerPorId($item->getHorId())->getDetalle(); ?></td>
                                                <?php break;

                                        } ?>


                                    </tr>
                                <?php endforeach; ?>


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

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
</div>


<script type="text/javascript">


    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }
    <?php

    ?>


</script>
