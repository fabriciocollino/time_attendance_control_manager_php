<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-editar-fp.html.php') . 's' . '.php'; ?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="modalTitle">
        <?php if ($o_Persona->getId() != null)
            echo _("Administrar Huellas de ") . $o_Persona->getNombreCompleto();
        ?></h4>
</div>
<div class="modal-body" style="padding-top: 0px;">


    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/' . $Item_Name . 's.html.php' ?>?tipo=<?php if ($o_Persona->getId() == null)
              echo "add";
          else
              echo "edit&id=" . $o_Persona->getId();
          ?>">
        <?php if ($o_Persona->getId() != null) echo '<input type="hidden" id="ItemID" name="ItemID" value="' . $o_Persona->getId() . '">'; ?>


        <fieldset>
            <legend>Lectores</legend>
            <div class="row">
                <section class="col col-6">

                    <label class="select"> <span class="icon-prepend fa fa-hdd-o"></span>
                        <select name="equipo" style="padding-left: 32px;">
                            <?php
                            $salida_options='';
                            $array_equipos_para_enrolear = array();

                            $a_o_Equipo = Equipo_L::obtenerTodos();
                            $array_equipos = explode(':', $o_Persona->getEquipos());
                            if ($a_o_Equipo != null) {
                                $checked = '';
                                foreach ($a_o_Equipo as $o_Equipo) { /* @var $o_Equipo Equipo_O */
                                    if (!in_array($o_Equipo->getId(), $array_equipos)) continue;
                                    if((integer)time() - (integer)$o_Equipo->getHeartbeat('U') > 600) continue; //hace mucho tiempo que el equipo no se conecta
                                    $array_equipos_para_enrolear[$o_Equipo->getId()] = $o_Equipo->getDetalle();
                                }
                                foreach ($array_equipos_para_enrolear as $eq_id=>$eq_nombre){
                                    $selected = '';
                                    if(count($array_equipos_para_enrolear)==1)$selected = "selected=\"selected\"";
                                    $salida_options.= "<option ". $selected ." value=\"" . $eq_id . "\">";
                                    $salida_options.= $eq_nombre . "</option>";
                                }

                            }
                            if($salida_options==''){
                                echo "<option value=\"0\" selected=\"selected\">No hay Equipos Conectados</option>";
                            }else if($array_equipos_para_enrolear==1) {
                                echo "<option value=\"0\" >Seleccione un Equipo</option>";
                                echo $salida_options;
                            }else{
                                echo "<option value=\"0\" selected=\"selected\">Seleccione un Equipo</option>";
                                echo $salida_options;
                            }
                            ?>


                        </select> <i></i> </label>
                </section>
            </div>


        </fieldset>
        
        <fieldset>
            <legend>Huellas</legend>

            <style>
                .fp_left_hand {
                    width: 250px;
                }

                .fp_left_hand_container {
                    display: inline;
                    position: relative;
                }

                .fp_left_hand_thumb {
                    width: 28px;
                    position: absolute;
                    top: 30px;
                    left: 194px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(48deg);
                    -webkit-transform: rotate(48deg);
                    -o-transform: rotate(48deg);
                    -ms-transform: rotate(48deg);
                }

                .fp_left_hand_index {
                    width: 20px;
                    position: absolute;
                    top: -93px;
                    left: 160px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(3deg);
                    -webkit-transform: rotate(3deg);
                    -o-transform: rotate(3deg);
                    -ms-transform: rotate(3deg);
                }

                .fp_left_hand_middle {
                    width: 20px;
                    position: absolute;
                    top: -112px;
                    left: 110px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(-3deg);
                    -webkit-transform: rotate(-3deg);
                    -o-transform: rotate(-3deg);
                    -ms-transform: rotate(-3deg);
                }

                .fp_left_hand_ring {
                    width: 17px;
                    position: absolute;
                    top: -90px;
                    left: 67px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(-15deg);
                    -webkit-transform: rotate(-15deg);
                    -o-transform: rotate(-15deg);
                    -ms-transform: rotate(-15deg);
                }

                .fp_left_hand_pinky {
                    width: 14px;
                    position: absolute;
                    top: -51px;
                    left: 25px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(-21deg);
                    -webkit-transform: rotate(-21deg);
                    -o-transform: rotate(-21deg);
                    -ms-transform: rotate(-21deg);
                }

                .fp_right_hand {
                    width: 250px;
                }

                .fp_right_hand_container {
                    display: inline;
                    position: relative;
                }

                .fp_right_hand_thumb {
                    width: 28px;
                    position: absolute;
                    top: 30px;
                    left: 29px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(-58deg);
                    -webkit-transform: rotate(-58deg);
                    -o-transform: rotate(-58deg);
                    -ms-transform: rotate(-58deg);
                }

                .fp_right_hand_index {
                    width: 20px;
                    position: absolute;
                    top: -93px;
                    left: 70px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(-16deg);
                    -webkit-transform: rotate(-16deg);
                    -o-transform: rotate(-16deg);
                    -ms-transform: rotate(-16deg);
                }

                .fp_right_hand_middle {
                    width: 20px;
                    position: absolute;
                    top: -112px;
                    left: 120px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(3deg);
                    -webkit-transform: rotate(3deg);
                    -o-transform: rotate(3deg);
                    -ms-transform: rotate(3deg);
                }

                .fp_right_hand_ring {
                    width: 17px;
                    position: absolute;
                    top: -90px;
                    left: 166px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(11deg);
                    -webkit-transform: rotate(11deg);
                    -o-transform: rotate(11deg);
                    -ms-transform: rotate(11deg);
                }

                .fp_right_hand_pinky {
                    width: 14px;
                    position: absolute;
                    top: -51px;
                    left: 211px;
                    behavior: url(-ms-transform.htc);
                    -moz-transform: rotate(21deg);
                    -webkit-transform: rotate(21deg);
                    -o-transform: rotate(21deg);
                    -ms-transform: rotate(21deg);
                }

                .popover-title {
                    margin: 0 !important;
                    padding: 8px 14px !important;
                }

                .popover-content {
                    padding: 9px 14px !important;
                }
            </style>
            <script type="text/javascript">
                //$(".fp_left_hand_thumb").popover({ trigger: "hover" });


                var timeoutObj;
                $('.fp_pop').popover({
                    offset: 10,
                    trigger: 'manual',
                    html: true,
                    placement: 'auto',
                    template: '<div class="popover" onmouseover="clearTimeout(timeoutObj);$(this).mouseleave(function() {$(this).hide();});"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
                }).mouseenter(function (e) {
                    $(this).popover('show');
                }).mouseleave(function (e) {
                    var ref = $(this);
                    timeoutObj = setTimeout(function () {
                        ref.popover('hide');
                    }, 50);
                });


            </script>
            <?php
            $a_huellas = Huella_L::obtenerPorPersona($o_Persona->getId());

            $fp_left_hand_thumb_img = 'fp_empty_small.png';
            $fp_left_hand_index_img = 'fp_empty_small.png';
            $fp_left_hand_middle_img = 'fp_empty_small.png';
            $fp_left_hand_ring_img = 'fp_empty_small.png';
            $fp_left_hand_pinky_img = 'fp_empty_small.png';
            $fp_right_hand_thumb_img = 'fp_empty_small.png';
            $fp_right_hand_index_img = 'fp_empty_small.png';
            $fp_right_hand_middle_img = 'fp_empty_small.png';
            $fp_right_hand_ring_img = 'fp_empty_small.png';
            $fp_right_hand_pinky_img = 'fp_empty_small.png';

            $fp_left_hand_thumb_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;1&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_left_hand_index_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;2&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_left_hand_middle_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;3&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_left_hand_ring_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;4&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_left_hand_pinky_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;5&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_right_hand_thumb_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;6&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_right_hand_index_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;7&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_right_hand_middle_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;8&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_right_hand_ring_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;9&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';
            $fp_right_hand_pinky_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Cargar Huella') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;enrollstart&quot; data-dedo=&quot;10&quot; &gt;' . _('Cargar Huella') . '&lt;/button&gt;';

            if (!empty($a_huellas)) {
                foreach ($a_huellas as $o_Huella) {

                    if ($o_Huella->getDatosSize() > 1) {
                        switch ($o_Huella->getDedo()) {
                            case LEFT_THUMB:
                                $fp_left_hand_thumb_img = 'fp_small.png';
                                $fp_left_hand_thumb_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;1&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case LEFT_INDEX:
                                $fp_left_hand_index_img = 'fp_small.png';
                                $fp_left_hand_index_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;2&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case LEFT_MIDDLE:
                                $fp_left_hand_middle_img = 'fp_small.png';
                                $fp_left_hand_middle_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;3&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case LEFT_RING:
                                $fp_left_hand_ring_img = 'fp_small.png';
                                $fp_left_hand_ring_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;4&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case LEFT_LITTLE:
                                $fp_left_hand_pinky_img = 'fp_small.png';
                                $fp_left_hand_pinky_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;5&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case RIGHT_THUMB:
                                $fp_right_hand_thumb_img = 'fp_small.png';
                                $fp_right_hand_thumb_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;6&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case RIGHT_INDEX:
                                $fp_right_hand_index_img = 'fp_small.png';
                                $fp_right_hand_index_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;7&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case RIGHT_MIDDLE:
                                $fp_right_hand_middle_img = 'fp_small.png';
                                $fp_right_hand_middle_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;8&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case RIGHT_RING:
                                $fp_right_hand_ring_img = 'fp_small.png';
                                $fp_right_hand_ring_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;9&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;
                            case RIGHT_LITTLE:
                                $fp_right_hand_pinky_img = 'fp_small.png';
                                $fp_right_hand_pinky_content = '&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm boton-fp&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;10&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;';
                                break;

                        }
                    } else {//la huella es invalida
                        switch ($o_Huella->getDedo()) {
                            case LEFT_THUMB:
                                $fp_left_hand_thumb_img = 'fp_red_small.png';
                                $fp_left_hand_thumb_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;1&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case LEFT_INDEX:
                                $fp_left_hand_index_img = 'fp_red_small.png';
                                $fp_left_hand_index_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;2&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case LEFT_MIDDLE:
                                $fp_left_hand_middle_img = 'fp_red_small.png';
                                $fp_left_hand_middle_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;3&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case LEFT_RING:
                                $fp_left_hand_ring_img = 'fp_red_small.png';
                                $fp_left_hand_ring_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;4&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case LEFT_LITTLE:
                                $fp_left_hand_pinky_img = 'fp_red_small.png';
                                $fp_left_hand_pinky_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;5&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case RIGHT_THUMB:
                                $fp_right_hand_thumb_img = 'fp_red_small.png';
                                $fp_right_hand_thumb_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;6&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case RIGHT_INDEX:
                                $fp_right_hand_index_img = 'fp_red_small.png';
                                $fp_right_hand_index_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;7&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case RIGHT_MIDDLE:
                                $fp_right_hand_middle_img = 'fp_red_small.png';
                                $fp_right_hand_middle_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;8&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case RIGHT_RING:
                                $fp_right_hand_ring_img = 'fp_red_small.png';
                                $fp_right_hand_ring_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;9&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;
                            case RIGHT_LITTLE:
                                $fp_right_hand_pinky_img = 'fp_red_small.png';
                                $fp_right_hand_pinky_content = 'Hubo un error al sincronizar la huella.&lt;div style=&quot;text-align:center;&quot;&gt;&lt;button type=&quot;button&quot; title=&quot;' . _('Eliminar') . '&quot; class=&quot;btn btn-default btn-sm&quot; style=&quot;line-height: 1.75em;&quot; data-type=&quot;accion&quot; data-id=&quot;' . $o_Persona->getId() . '&quot; data-accion=&quot;deletefp&quot; data-dedo=&quot;10&quot; &gt;' . _('Eliminar') . '&lt;/button&gt;&lt;/div&gt;';
                                break;

                        }
                    }
                }
            }
            /*
            if(!empty($a_huellas)){
                    echo "Se encontraron ".count($a_huellas)." huellas.";
            }else{
                    echo "No hay huellas cargadas.";
            }
            */
            ?>


            <div class="fp_left_hand_container">
                <img class="fp_left_hand" src="img/left_hand.png" alt="Left Hand"/>
                <img class="fp_left_hand_thumb fp_pop" src="img/<?= $fp_left_hand_thumb_img; ?>" alt="Left Hand Thumb"
                     data-original-title="Pulgar Izquierdo" data-content="<?= $fp_left_hand_thumb_content; ?>"/>
                <img class="fp_left_hand_index fp_pop" src="img/<?= $fp_left_hand_index_img; ?>" alt="Left Hand Index"
                     data-original-title="Indice Izquierdo" data-content="<?= $fp_left_hand_index_content; ?>"/>
                <img class="fp_left_hand_middle fp_pop" src="img/<?= $fp_left_hand_middle_img; ?>"
                     alt="Left Hand Middle" data-original-title="Medio Izquierdo"
                     data-content="<?= $fp_left_hand_middle_content; ?>"/>
                <img class="fp_left_hand_ring fp_pop" src="img/<?= $fp_left_hand_ring_img; ?>" alt="Left Hand Ring"
                     data-original-title="Anular Izquierdo" data-content="<?= $fp_left_hand_ring_content; ?>"/>
                <img class="fp_left_hand_pinky fp_pop" src="img/<?= $fp_left_hand_pinky_img; ?>" alt="Left Hand Pinky"
                     data-original-title="Meñique Izquierdo" data-content="<?= $fp_left_hand_pinky_content; ?>"/>
            </div>
            <div class="fp_right_hand_container">
                <img class="fp_right_hand" src="img/right_hand.png" alt="Right Hand"/>
                <img class="fp_right_hand_thumb fp_pop" src="img/<?= $fp_right_hand_thumb_img; ?>"
                     alt="Right Hand Thumb" data-original-title="Pulgar Derecho"
                     data-content="<?= $fp_right_hand_thumb_content; ?>"/>
                <img class="fp_right_hand_index fp_pop" src="img/<?= $fp_right_hand_index_img; ?>"
                     alt="Right Hand Index" data-original-title="Indice Derecho"
                     data-content="<?= $fp_right_hand_index_content; ?>"/>
                <img class="fp_right_hand_middle fp_pop" src="img/<?= $fp_right_hand_middle_img; ?>"
                     alt="Right Hand Middle" data-original-title="Medio Derecho"
                     data-content="<?= $fp_right_hand_middle_content; ?>"/>
                <img class="fp_right_hand_ring fp_pop" src="img/<?= $fp_right_hand_ring_img; ?>" alt="Right Hand Ring"
                     data-original-title="Anular Derecho" data-content="<?= $fp_right_hand_ring_content; ?>"/>
                <img class="fp_right_hand_pinky fp_pop" src="img/<?= $fp_right_hand_pinky_img; ?>"
                     alt="Right Hand Pinky" data-original-title="Meñique Derecho"
                     data-content="<?= $fp_right_hand_pinky_content; ?>"/>
            </div>
            <br/>


        </fieldset>



    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
</div>


<script type="text/javascript">
    $('body').off('click', 'button[data-type=accion]');
    $('body').on('click', 'button[data-type=accion]', function () {
//$('a[data-type=accion], button[data-type=accion]').click(function () {	
        $(this).off('click');

        var data_id = '';
        var data_accion = '';
        var data_dedo = '';
        var data_huella = '';
        var dataI = '';

        if (typeof $(this).data('id') !== 'undefined') {
            data_id = $(this).data('id');
        }
        if (typeof $(this).data('accion') !== 'undefined') {
            data_accion = $(this).data('accion');
        }
        if (typeof $(this).data('dedo') !== 'undefined') {
            data_dedo = $(this).data('dedo');
        }
        if (typeof $(this).data('huella') !== 'undefined') {
            data_huella = $(this).data('huella');
        }
        if (data_accion === 'enrollstart') {
            dataI = $('select[name=equipo]').val();

            //if(dataI==='' || dataI===0 || typeof dataI === 'undefined' || dataI==="0"){$.smallBox({title : "Debe seleccionar un equipo para realizar la lectura.",content : "",color : "#A65858",iconSmall : "fa fa-warning",timeout : 5000});return;}
            //	if(dataI==='' || dataI===0 || typeof dataI === 'undefined' || dataI==="0"){return;}
            if (dataI === '' || dataI === 0 || typeof dataI === 'undefined' || dataI === "0") {
                $.SmartMessageBox({
                    title: "Debe seleccionar un Equipo",
                    content: "Debe seleccionar un Equipo para realizar la lectura de la huella.",
                    buttons: '[Ok]'
                });
                return;
            }
            $('#editar').modal('hide');
            $('#editar').on('hidden.bs.modal', function () {
                $('#editar').off('hidden.bs.modal');
            });
            $.bigBox({
                title: "Enviando comando...",
                content: "El comando está siendo enviado al Equipo...",
                color: "#C79121",
                timeout: 30000,
                icon: "fa fa-refresh fa-spin",
                //number : "2"
                sound: false
            });
            $.ajax({
                cache: false,
                type: 'POST',
                url: 'codigo/controllers/personas.php',
                data: {tipo: 'accion', id: data_id, cmd: data_accion, data: dataI, dedo: data_dedo, huella:data_huella},
                success: function (dataR) {
                    var returnID = dataR;
                    $("[id^=botClose]").click();
                    $.bigBox({
                        title: "Enviando comando...",
                        content: "El comando está siendo enviado al Equipo...</br>La carga comenzará en unos segundos...",
                        color: "#C79121",
                        timeout: 60000,
                        icon: "fa fa-refresh fa-spin",
                        //number : "2"
                        sound: false
                    });
                    //checker = setInterval(function () {
                        comandoAchecker(returnID,0);
                    //}, 2000);

                }
            });

        }
        else if (data_accion === 'deletefp') {

            $('#editar').modal('hide');
            $('#editar').on('hidden.bs.modal', function () {
                $('#editar').off('hidden.bs.modal');
            });

            $.ajax({
                cache: false,
                type: 'POST',
                url: 'codigo/controllers/personas.php',
                data: {tipo: 'accion', id: data_id, cmd: data_accion, dedo: data_dedo},
                success: function (dataR) {
                    $.bigBox({
                        title: "Huella Eliminada!",
                        content: "La Huella fue eliminada...",
                        color: "#739E73",
                        timeout: 6000,
                        icon: "fa fa-check shake animated",
                        //number : "2"
                        sound: true
                    });

                }
            });

        }else if (data_accion === 'enrollcancel') {
            $("[id^=botClose]").click();
            $.bigBox({
                title: "Cancelando...",
                content: "Cancelando la carga.",
                color: "#C79121",
                timeout: 60000,
                icon: "fa fa-refresh fa-spin",
                //number : "2"
                sound: false
            });

            $.ajax({
                cache: false,
                type: 'POST',
                url: 'codigo/controllers/personas.php',
                data: {tipo: 'accion', data: data_id, cmd: data_accion, huella:data_huella},
                success: function (dataR) {

                    if(dataR=='OK'){
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Carga cancelada!",
                            content: "La carga de huella ha sido cancelada correctamente.</br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#739E73",
                            timeout: 6000,
                            icon: "fa fa-check shake animated",
                            sound: true
                        });
                    }else{
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Oh no!",
                            content: "Hubo un problema al cancelar la carga de la huella. </br><small>"+dataR+"<small></br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#C46A69",
                            timeout: 10000,
                            icon: "fa fa-warning shake animated",
                            //number : "2"
                            sound: true
                        });
                    }


                }
            });

        }
    });

    function comandoAchecker(ComandoID,CantIntentos) {
        if(CantIntentos>3){
            //console.log('numero de intentos maximos excedidos');
            return;
        }
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'pspull.php',
            data: {id: ComandoID, cmd: 'ACK_ENROLL_START'},
            success: function (data) {

                if(data=='' || data.indexOf('Fatal error:')>=1){
                    return;
                }
                var mensaje = JSON.parse(data);
                //console.log('mensaje:',mensaje);

                if(mensaje.data.id==ComandoID){
                    //console.log('ack enroll start huella',mensaje.data.id);
                    $("[id^=botClose]").click();
                    $.bigBox({
                        title: "Carga Iniciada!",
                        content: "Siga las instrucciones en la pantalla del equipo para cargar la huella.</br><button style=\"float:right;\" type=\"button\" class=\"btn btn-default btn-sm\" data-type=\"accion\" data-huella=\"" + ComandoID + "\" data-id=\"" + mensaje.attributes.uuid + "\" data-accion=\"enrollcancel\">Cancelar</button>",
                        color: "#3276B1",
                        timeout: 30000,
                        icon: "fa fa-bell swing animated",
                        sound: true
                    });
                    comandoAchecker2(ComandoID,0);

                }else{
                    //console.log('detectado mensaje que no es ack y huella');
                    //console.log('intento',CantIntentos);
                    comandoAchecker(ComandoID,CantIntentos+1);

                }

            }
        });

    }

    function comandoAchecker2(ComandoID,CantIntentos) {
        if(CantIntentos>3){
            //console.log('numero de intentos maximos excedidos');
            return;
        }
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'pspull.php',
            data: {id: ComandoID, cmd: 'CMD_ENROLL_STATUS'},
            success: function (data) {

                if(data=='' || data.indexOf('Fatal error:')>=1){

                    return;
                }
                var mensaje = JSON.parse(data);
                //console.log('mensaje:',mensaje);

                if(mensaje.data.id==ComandoID){
                    equiposOK.push(mensaje.attributes.uuid);
                    //console.log('huella',mensaje.data.id);
                    //console.log('persona',mensaje.data.id);
                    //console.log('equipo',mensaje.attributes.uuid);
                    //console.log('status',mensaje.data.status);


                    if(mensaje.data.status=='OK'){
                        //console.log('sync ok!');
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Huella Cargada!",
                            content: "La huella ha sido cargada correctamente.</br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#739E73",
                            timeout: 6000,
                            icon: "fa fa-check shake animated",
                            sound: true
                        });
                    }else if(mensaje.data.status=='CANCEL'){
                        //por ahora no hago nada
                    }else {
                        $("[id^=botClose]").click();
                        $.bigBox({
                            title: "Oh no!",
                            content: "Hubo un problema al cargar la huella y esta no se cargó corretamente. </br><small>"+mensaje.data.status+"<small></br><small>Este mensaje se cerrará automáticamente</small>",
                            color: "#C46A69",
                            timeout: 10000,
                            icon: "fa fa-warning shake animated",
                            //number : "2"
                            sound: true
                        });
                    }

                }else{
                    //console.log('detectado mensaje que no es status y huella');
                    //console.log('intento',CantIntentos);
                    comandoAchecker2(ComandoID,CantIntentos+1);
                }


            }
        });

    }


    $(document).ready(function () {

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

    });


</script>
