<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/mercadopago_suscripcion.php'; ?>

<div class="modal-header">

    <h4 class="modal-title" id="modalTitle">
        Transacciones: <?php echo $o_Suscripcion->get_reason() ;?>
    </h4>
</div>

<div class="modal-body"">


<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false"
                 data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                    <h2><?php echo _('Lista') ?></h2>
                    <div id="selTemplate" class="widget-toolbar" role="menu">
                    </div>
                </header>

                <div>

                    <div class="jarviswidget-editbox"><!-- This area used as dropdown edit box --></div>


                    <div class="widget-body no-padding">


                        <table id="dt_basic_modal"
                               class="table table-striped table-hover dataTable no-footer"
                               aria-describedby="dt_basic_info"
                               style="width: 100%;">
                            <!-- ENCABEZADO -->

                            <?php if (!empty($o_Listado)){ ?>

                                <thead>
                                <tr>
                                    <?php

                                    $o_Listado_copy = $o_Listado;
                                    $o_Listado_copy = array_shift($o_Listado_copy);

                                    foreach ($o_Listado_copy as $_itemID => $_item){ ?>
                                        <th>
                                            <?php echo $_itemID; ?>
                                        </th>
                                    <?php }

                                    ?>

                                </tr>
                                </thead>

                                <tbody>

                                <?php foreach ($o_Listado as $key => $item):?>

                                    <tr>
                                        <!-- NOMBRE -->
                                        <?php foreach ($item as $keyi => $i){ ?>
                                            <td>
                                                <table class="tablainterna no-footer" aria-describedby="dt_basic_info">

                                                    <tbody>
                                                    <?php if (is_array($i)){ ?>

                                                        <?php foreach ($i as $key_i => $_i){ ?>
                                                            <tr>
                                                            <td>
                                                            <?php if (is_array($_i)){ ?>

                                                                <?php foreach ($_i as $key__i => $__i){ ?>

                                                                    <?php if (is_array($__i)){ ?>

                                                                        <?php foreach ($__i as $key___i => $___i){ ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <?php  echo $key__i."_".$key___i.": ".$___i;?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>

                                                                    <?php }

                                                                    else { ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php echo $key__i.": ".$__i;?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>


                                                                <?php } ?>

                                                            <?php }
                                                            else { ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $key_i.": ".$_i;       ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>

                                                            </td>
                                                            </tr>
                                                        <?php } ?>

                                                    <?php }
                                                    else { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $i;       ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>



                                                    </tbody>
                                                </table>
                                            </td>

                                        <?php } ?>
                                    </tr>


                                <?php endforeach; ?>

                                </tbody>

                            <?php }?>




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

</section>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
</div>

<script type="text/javascript">

    // PAGE
    pageSetUp();

    if ($('.DTTT_dropdown.dropdown-menu').length) {
        $('.DTTT_dropdown.dropdown-menu').remove();
    }

    <?php require_once APP_PATH . '/includes/data_tables_modal.js.php'; ?>

</script>


<style>
    @media (min-width: 768px) {
        .modal-dialog {
            width: 60% !important;
        }
    }
</style>|