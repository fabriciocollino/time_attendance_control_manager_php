<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php $o_Listado = array(); ?>
<?php require_once APP_PATH . '/controllers/transacciones.php'; ?>
<?php require_once APP_PATH . '/includes/top-mensajes.inc.php'; ?>


<!-- Bread crumb is created dynamically -->
<!-- row -->
<div class="row">

    <!-- col -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">

            <!-- PAGE HEADER -->
            <i class="fa-fw fa fa-tasks"></i>
            <?php echo _('Facturación') ?>
            <span>>
                <?php echo _('Transacciones') ?>
			</span>
        </h1>
    </div>

</div>
<!-- end row -->


<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-tasks"></i> </span>
                    <h2><?php echo _('Listado de Transacciones') ?></h2>
                </header>


                <div><!-- widget div-->

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox"><!-- This area used as dropdown edit box --></div>


                    <!-- widget content -->
                    <div class="widget-body no-padding">


                        <table id="dt_basic" class="table table-striped table-hover dataTable no-footer" aria-describedby="dt_basic_info" style="width: 100%;">

                            <!-- ENCABEZADO -->
                            <thead>
                            <tr>
                                <?php

                                $o_Listado_copy = $o_Listado;
                                $o_Listado_copy = array_shift($o_Listado_copy);

                                foreach ($o_Listado_copy as $_itemID => $_item){ ?>
                                    <th>
                                        <?php echo $_itemID; ?>
                                    </th>
                                <?php } ?>
                            </tr>
                            </thead>

                            <!-- TABLA -->
                            <tbody>
                            <?php foreach ($o_Listado as $itemID => $item){ ?>
                                <tr>
                                    <?php foreach ($item as $iID => $i){ ?>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

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


<?php require_once APP_PATH . '/templates/edit-view_modal.html.php'; ?>

<script type="text/javascript">

    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }

    <?php
    //INCLUYO el js de las datatables
    require_once APP_PATH . '/includes/data_tables.js.php';
    ?>



</script>


