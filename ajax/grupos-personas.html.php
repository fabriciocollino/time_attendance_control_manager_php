<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-personas.html.php') . '.php'; ?>

<?php
if ($T_Tipo == "insert") {
    //esto es para el ajax del insertar/eliminar, para que solo devuelva el output del controller
} else {
    ?>


    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
        </button>
        <h4 class="modal-title" id="modalTitle"><?php if ($o_Grupo->getId() == null) echo _("Agregar Grupo");
            else echo _("Agregar personas al Grupo"); ?></h4>
    </div>
    <div class="modal-body" style="padding-top: 0px;">


        <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form" action="#">


            <fieldset>
                <div class="row">
                    <div id="loader" style="height: 30px;"></div>
                    <select multiple id="selGrupos">
                        <?php
                        $a_Grupos_Personas = Grupos_Personas_L::obtenerARRAYPorGrupo($o_Grupo->getId());
                        $a_o_Personas = Persona_L::obtenerTodos();
                        echo '<pre>';
                        echo $o_Grupo->getId();
                        echo print_r($a_Grupos_Personas);
                        echo '</pre>';
                        if ($a_o_Personas != null) {
                            foreach ($a_o_Personas as $o_Persona) {
                                $checked = '';
                                if (in_array($o_Persona->getId(), $a_Grupos_Personas))
                                    $checked = 'selected="selected"';

                                echo '<option value="' . $o_Persona->getId() . '" ' . $checked . ' >';
                                echo $o_Persona->getNombreCompleto();
                                echo "</option>";
                            }
                        } ?>
                    </select>
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


        loadScript("js/plugin/multi-select/jquery.multi-select.js", function () {
            loadScript("js/plugin/multi-select/jquery.quicksearch.js", pagefunction);
        });

        function pagefunction() {

            $('#selGrupos').multiSelect({
                selectableHeader: "<h3>Personas</h3><section><i class='icon-prepend icon-prepend-multi-select-search fa fa-search'></i><input type='text' class='search-input' autocomplete='off' placeholder='Buscar'></section>",
                selectionHeader: "<h3><?php echo $o_Grupo->getDetalle(); ?></h3><section><i class='icon-prepend icon-prepend-multi-select-search fa fa-search'></i><input type='text' class='search-input' autocomplete='off' placeholder='Buscar'></section>",
                afterSelect: function (value) {
                    AgregarPersona(value);
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function (value) { 
                    EliminarPersona(value);
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterInit: function (ms) {

                    var that = this,
                        $selectableSearch = that.$selectableUl.prev().find('input'),
                        $selectionSearch = that.$selectionUl.prev().find('input'),
                        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function (e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function (e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                }
            });
        }


        $(document).ready(function () {


        });

        function AgregarPersona(persona) {

            $('#loader').html('<img src="<?php echo WEB_ROOT; ?>/img/loading.gif" width="30" />');

            $.ajax({
                url: '<?php echo 'ajax/' . $Item_Name . '.html.php' ?>?tipo=insert&id=<?php echo $T_Id; ?>&persona=' + persona,
                dataType: 'html',
                async: true,
                timeout: 5000, //timeout de 5 segundos
                success: function (text) {

                    if (text) {
                        if (text == "error_persona_ya_existe") {
                            alert("<?php echo _('La persona que intenta agregar, ya existe en el grupo.') ?>");
                            $('#loader').html('');
                            alert("Error, no se puedo agregar la persona. Compruebe su conexion a Internet.");
                            return false;
                        }

                        $('#loader').html('');
                    }
                    $('#loader').html('');

                },
                error: function (text) {
                    alert("Error, no se puedo agregar la persona. Compruebe su conexion a Internet.");
                    $('#loader').html('');
                }

            });
        }
        ;

        function EliminarPersona(persona) {

            $('#loader').html('<img src="<?php echo WEB_ROOT; ?>/img/loading.gif" width="30" />');

            $.ajax({
                url: '<?php echo 'ajax/' . $Item_Name . '.html.php' ?>?tipo=remove&id=<?php echo $T_Id; ?>&GpersonaID=' + persona,
                dataType: 'html',
                async: true,
                timeout: 5000, //timeout de 5 segundos
                success: function (text) {
                    if (text) {

                    }
                    $('#loader').html('');
                },
                error: function (text) {
                    alert("Error, no se puedo agregar la persona. Compruebe su conexion a Internet.");
                    $('#loader').html('');
                }

            });

        }
        ;


        $('#editar').on('hidden.bs.modal', function () {
            //esto refresca la pagina
            loadURL('<?php echo $Item_Name ?>', $('#content'));


        });


    </script>


<?php } ?>


