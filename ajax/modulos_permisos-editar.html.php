<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/modulos_permisos.php'; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="modalTitle">
        <?php echo _("Editar Modulos y Permisos"); ?>
    </h4>
</div>

<!-- TABS LINKS -->
<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'General_div')" id="General_tab">Sistema</button>
    <button class="tablinks" onclick="openTab(event, 'Personas_div')" id="Personas_tab">Personas</button>
    <button class="tablinks" onclick="openTab(event, 'Horarios_div')" id="Horarios_tab">Horarios</button>
    <button class="tablinks" onclick="openTab(event, 'Calendario_div')" id="Calendario_tab">Calendario</button>
    <button class="tablinks" onclick="openTab(event, 'Notificaciones_div')" id="Notificaciones_tab">Notificaciones</button>
    <button class="tablinks" onclick="openTab(event, 'Reportes_div')" id="Reportes_tab">Reportes</button>
</div>


<div class="modal-body" style="padding-top: 0;">

    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'codigo/controllers/modulos_permisos.php';?>">

        <input type="hidden" id="mod_id" name="mod_id">
        <input type="hidden" id="tipo" name="tipo">

        <!-- PERSONAS-->
        <div id="General_div" class="tabcontent">


            <!-- CONF. GENERALES -->
            <fieldset>
                <!-- /////////// -->
                <legend>CONFIGURACIONES</legend>
                <div class="row">

                    <!-- mod_configuraciones_ver -->
                    <section class='col col-4'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_configuraciones_ver'   name ='mod_configuraciones_ver' >
                            <i data-swchoff-text='NO' data-swchon-text='SI' ></i> Ver
                        </label>
                    </section>

                    <!-- mod_configuraciones_editar -->
                    <section class='col col-4'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_configuraciones_editar'   name ='mod_configuraciones_editar' >
                            <i data-swchoff-text='NO' data-swchon-text='SI' ></i> Editar
                        </label>
                    </section>

                    <!-- mod_configuraciones_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_configuraciones_cantidad'   name ='mod_configuraciones_cantidad'>Cantidad
                        </label>
                    </section>

                </div>
                <!-- /////////// -->

                <!-- /////////// -->
                <legend>INICIO</legend>
                <div class="row">
                    <!-- mod_inicio_ver -->
                    <section class='col col-4'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_inicio_ver'   name ='mod_inicio_ver' >
                            <i data-swchoff-text='NO' data-swchon-text='SI' ></i> Ver
                        </label>
                    </section>

                <div class="row">
                    <!-- mod_inicio_editar -->
                    <section class='col col-4'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_inicio_editar'   name ='mod_inicio_editar' >
                            <i data-swchoff-text='NO' data-swchon-text='SI' ></i> Editar
                        </label>
                    </section>
                </div>
                <div class="row">
                    <!-- mod_inicio_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_inicio_cantidad'   name ='mod_inicio_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
                <!-- /////////// -->

            </fieldset>


        </div>

        <!-- PERSONAS-->
        <div id="Personas_div" class="tabcontent">

            <!-- LISTADO PERSONAS-->
            <fieldset>
                <legend>LISTADO PERSONAS</legend>
                <div class="row">

                    <!-- mod_persona_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_ver'   name ='mod_persona_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_persona_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_crear'   name ='mod_persona_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_persona_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_editar'   name ='mod_persona_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_persona_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_eliminar'   name ='mod_persona_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_persona_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_persona_cantidad'   name ='mod_persona_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- HUELLAS-->
            <fieldset>
                <legend>HUELLAS</legend>
                <div class="row">

                    <!-- mod_persona_huellas_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_huellas_ver'   name ='mod_persona_huellas_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_persona_huellas_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_huellas_crear'   name ='mod_persona_huellas_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_persona_huellas_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_huellas_editar'   name ='mod_persona_huellas_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_persona_huellas_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_huellas_eliminar'   name ='mod_persona_huellas_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>


                    <!-- mod_persona_huellas_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_persona_huellas_cantidad'   name ='mod_persona_huellas_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- RFID-->
            <fieldset>
                <legend>RFID</legend>
                <div class="row">

                    <!-- mod_persona_rfid_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_rfid_ver'   name ='mod_persona_rfid_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_persona_rfid_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_rfid_crear'   name ='mod_persona_rfid_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_persona_rfid_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_rfid_editar'   name ='mod_persona_rfid_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_persona_rfid_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_persona_rfid_eliminar'   name ='mod_persona_rfid_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_persona_rfid_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_persona_rfid_cantidad'   name ='mod_persona_rfid_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- GRUPOS -->
            <fieldset>
                <legend>GRUPOS</legend>
                <div class="row">

                    <!-- mod_grupo_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_grupo_ver'   name ='mod_grupo_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_grupo_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_grupo_crear'   name ='mod_grupo_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_grupo_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_grupo_editar'   name ='mod_grupo_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_grupo_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_grupo_eliminar'   name ='mod_grupo_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_grupo_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_grupo_cantidad'   name ='mod_grupo_cantidad'>Cantidad
                        </label>
                    </section>

                </div>
            </fieldset>
        </div>


        <!-- HORARIOS -->
        <div id="Horarios_div" class="tabcontent">

            <!-- HORARIOS DE TRABAJO-->
            <fieldset>
                <legend>HORARIOS DE TRABAJO</legend>
                <div class="row">

                    <!-- mod_horario_trabajo_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_trabajo_ver'   name ='mod_horario_trabajo_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_horario_trabajo_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_trabajo_crear'   name ='mod_horario_trabajo_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_horario_trabajo_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_trabajo_editar'   name ='mod_horario_trabajo_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_horario_trabajo_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_trabajo_eliminar'   name ='mod_horario_trabajo_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_horario_trabajo_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_horario_trabajo_cantidad'   name ='mod_horario_trabajo_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- HORARIOS FLEXIBLES -->
            <fieldset>
                <legend>HORARIOS FLEXIBLES</legend>
                <div class="row">

                    <!-- mod_horario_flexible_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_flexible_ver'   name ='mod_horario_flexible_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_horario_flexible_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_flexible_crear'   name ='mod_horario_flexible_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_horario_flexible_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_flexible_editar'   name ='mod_horario_flexible_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_horario_flexible_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_flexible_eliminar'   name ='mod_horario_flexible_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_horario_flexible_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_horario_flexible_cantidad'   name ='mod_horario_flexible_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- HORARIOS MULTIPLES -->
            <fieldset>
                <legend>HORARIOS MULTIPLES</legend>
                <div class="row">

                    <!-- mod_horario_multiple_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_multiple_ver'   name ='mod_horario_multiple_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_horario_multiple_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_multiple_crear'   name ='mod_horario_multiple_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_horario_multiple_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_multiple_editar'   name ='mod_horario_multiple_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_horario_multiple_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_multiple_eliminar'   name ='mod_horario_multiple_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_horario_multiple_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_horario_multiple_cantidad'   name ='mod_horario_multiple_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- HORARIOS ROTATIVOS -->
            <fieldset>
                <legend>HORARIOS ROTATIVOS</legend>
                <div class="row">

                    <!-- mod_horario_rotativo_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_rotativo_ver'   name ='mod_horario_rotativo_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_horario_rotativo_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_rotativo_crear'   name ='mod_horario_rotativo_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_horario_rotativo_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_rotativo_editar'   name ='mod_horario_rotativo_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_horario_rotativo_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_horario_rotativo_eliminar'   name ='mod_horario_rotativo_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_horario_rotativo_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_horario_rotativo_cantidad'   name ='mod_horario_rotativo_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

        </div>

        <!-- CALENDARIO -->
        <div id="Calendario_div" class="tabcontent">

            <!-- LICENCIAS-->
            <fieldset>
                <legend>LICENCIAS</legend>
                <div class="row">

                    <!-- mod_licencia_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_licencia_ver'   name ='mod_licencia_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_licencia_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_licencia_crear'   name ='mod_licencia_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_licencia_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_licencia_editar'   name ='mod_licencia_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_licencia_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_licencia_eliminar'   name ='mod_licencia_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_licencia_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_licencia_cantidad'   name ='mod_licencia_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- SUSPENSIONES-->
            <fieldset>
                <legend>SUSPENSIONES</legend>
                <div class="row">

                    <!-- mod_suspension_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_suspension_ver'   name ='mod_suspension_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_suspension_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_suspension_crear'   name ='mod_suspension_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_suspension_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_suspension_editar'   name ='mod_suspension_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_suspension_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_suspension_eliminar'   name ='mod_suspension_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_suspension_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_suspension_cantidad'   name ='mod_suspension_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- FERIADOS-->
            <fieldset>
                <legend>FERIADOS</legend>
                <div class="row">

                    <!-- mod_feriado_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_feriado_ver'   name ='mod_feriado_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_feriado_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_feriado_crear'   name ='mod_feriado_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_feriado_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_feriado_editar'   name ='mod_feriado_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_feriado_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_feriado_eliminar'   name ='mod_feriado_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_feriado_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_feriado_cantidad'   name ='mod_feriado_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>
        </div>

        <!-- NOTIFICACIONES -->
        <div id="Notificaciones_div" class="tabcontent">

            <!-- ALERTAS-->
            <fieldset>
                <legend>ALERTAS</legend>
                <div class="row">

                    <!-- mod_alerta_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_alerta_ver'   name ='mod_alerta_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_alerta_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_alerta_crear'   name ='mod_alerta_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_alerta_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_alerta_editar'   name ='mod_alerta_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_alerta_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_alerta_eliminar'   name ='mod_alerta_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_alerta_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_alerta_cantidad'   name ='mod_alerta_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- REPORTES AUTOMÁTICOS -->
            <fieldset>
                <legend>REPORTES AUTOMÁTICOS</legend>
                <div class="row">

                    <!-- mod_reporte_automatico_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_automatico_ver'   name ='mod_reporte_automatico_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_reporte_automatico_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_automatico_crear'   name ='mod_reporte_automatico_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_automatico_editar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_automatico_editar'   name ='mod_reporte_automatico_editar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Editar
                        </label>
                    </section>

                    <!-- mod_reporte_automatico_eliminar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_automatico_eliminar'   name ='mod_reporte_automatico_eliminar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Eliminar
                        </label>
                    </section>

                    <!-- mod_reporte_automatico_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_automatico_cantidad'   name ='mod_reporte_automatico_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

        </div>

        <!-- REPORTES -->
        <div id="Reportes_div" class="tabcontent">

            <!-- REPORTE REGISTROS-->
            <fieldset>
                <legend>REPORTE REGISTROS</legend>
                <div class="row">

                    <!-- mod_reporte_registros_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_registros_ver'   name ='mod_reporte_registros_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_reporte_registros_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_registros_crear'   name ='mod_reporte_registros_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_registros_descargar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_registros_descargar'   name ='mod_reporte_registros_descargar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Descargar
                        </label>
                    </section>

                    <!-- mod_reporte_registros_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_registros_cantidad'   name ='mod_reporte_registros_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- REPORTE MARCACIONES-->
            <fieldset>
                <legend>REPORTE MARCACIONES</legend>
                <div class="row">

                    <!-- mod_reporte_marcaciones_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_marcaciones_ver'   name ='mod_reporte_marcaciones_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_reporte_marcaciones_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_marcaciones_crear'   name ='mod_reporte_marcaciones_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_marcaciones_descargar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_marcaciones_descargar'   name ='mod_reporte_marcaciones_descargar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Descargar
                        </label>
                    </section>

                    <!-- mod_reporte_marcaciones_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_marcaciones_cantidad'   name ='mod_reporte_marcaciones_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- REPORTE ASISTENCIAS-->
            <fieldset>
                <legend>REPORTE ASISTENCIAS</legend>
                <div class="row">

                    <!-- mod_reporte_asistencias_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_asistencias_ver'   name ='mod_reporte_asistencias_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_reporte_asistencias_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_asistencias_crear'   name ='mod_reporte_asistencias_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_asistencias_descargar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_asistencias_descargar'   name ='mod_reporte_asistencias_descargar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Descargar
                        </label>
                    </section>

                    <!-- mod_reporte_asistencias_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_asistencias_cantidad'   name ='mod_reporte_asistencias_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- REPORTE AUSENCIAS-->
            <fieldset>
                <legend>REPORTE AUSENCIAS</legend>
                <div class="row">

                    <!-- mod_reporte_ausencias_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_ausencias_ver'   name ='mod_reporte_ausencias_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_reporte_ausencias_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_ausencias_crear'   name ='mod_reporte_ausencias_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_ausencias_descargar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_ausencias_descargar'   name ='mod_reporte_ausencias_descargar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Descargar
                        </label>
                    </section>

                    <!-- mod_reporte_ausencias_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_ausencias_cantidad'   name ='mod_reporte_ausencias_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- REPORTE LLEGADAS TARDE-->
            <fieldset>
                <legend>REPORTE LLEGADAS TARDE</legend>
                <div class="row">

                    <!-- mod_reporte_llegadas_tarde_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_llegadas_tarde_ver'   name ='mod_reporte_llegadas_tarde_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_reporte_llegadas_tarde_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_llegadas_tarde_crear'   name ='mod_reporte_llegadas_tarde_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_llegadas_tarde_descargar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_llegadas_tarde_descargar'   name ='mod_reporte_llegadas_tarde_descargar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Descargar
                        </label>
                    </section>

                    <!-- mod_reporte_llegadas_tarde_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_llegadas_tarde_cantidad'   name ='mod_reporte_llegadas_tarde_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- REPORTE SALIDAS TEMPRANO-->
            <fieldset>
                <legend>REPORTE SALIDAS TEMPRANO</legend>
                <div class="row">

                    <!-- mod_reporte_salidas_temprano_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_salidas_temprano_ver'   name ='mod_reporte_salidas_temprano_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_salidas_temprano_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_salidas_temprano_crear'   name ='mod_reporte_salidas_temprano_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_salidas_temprano_descargar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_salidas_temprano_descargar'   name ='mod_reporte_salidas_temprano_descargar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Descargar
                        </label>
                    </section>

                    <!-- mod_reporte_salidas_temprano_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_salidas_temprano_cantidad'   name ='mod_reporte_salidas_temprano_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- REPORTE JORNADAS-->
            <fieldset>
                <legend>REPORTE JORNADAS</legend>
                <div class="row">

                    <!-- mod_reporte_jornadas_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_jornadas_ver'   name ='mod_reporte_jornadas_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_jornadas_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_jornadas_crear'   name ='mod_reporte_jornadas_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_jornadas_descargar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_jornadas_descargar'   name ='mod_reporte_jornadas_descargar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Descargar
                        </label>
                    </section>

                    <!-- mod_reporte_jornadas_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_jornadas_cantidad'   name ='mod_reporte_jornadas_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

            <!-- REPORTE INTERVALOS-->
            <fieldset>
                <legend>REPORTE INTERVALOS</legend>
                <div class="row">

                    <!-- mod_reporte_intervalos_ver -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_intervalos_ver'   name ='mod_reporte_intervalos_ver'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Ver
                        </label>
                    </section>

                    <!-- mod_reporte_intervalos_crear -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_intervalos_crear'   name ='mod_reporte_intervalos_crear'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Crear
                        </label>
                    </section>

                    <!-- mod_reporte_intervalos_descargar -->
                    <section class='col col-3'>
                        <label class='toggle'>
                            <input type ='checkbox'     id='mod_reporte_intervalos_descargar'   name ='mod_reporte_intervalos_descargar'>
                            <i data-swchoff-text='NO' data-swchon-text='SI'></i>Descargar
                        </label>
                    </section>

                    <!-- mod_reporte_intervalos_cantidad -->
                    <section class='col col-3'>
                        <label class='input'>
                            <input type ='number' min='0'     id='mod_reporte_intervalos_cantidad'   name ='mod_reporte_intervalos_cantidad'>Cantidad
                        </label>
                    </section>
                </div>
            </fieldset>

        </div>

    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
    <button type="submit" class="btn btn-primary" id="submit-editar" data-dismiss="modal">
        Guardar
    </button>
</div>



<style>

    @media (min-width: 768px) {
        .modal-dialog {
            width: 50% !important;
        }
    }

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #ffffff;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        -webkit-animation: fadeEffect 1s;
        animation: fadeEffect 1s;
    }

    /* Fade in tabs */
    @-webkit-keyframes fadeEffect {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    @keyframes fadeEffect {
        from {opacity: 0;}
        to {opacity: 1;}
    }
</style>


<script type="text/javascript">

    $('#mod_id').val("<?php echo $o_Modulos_Permisos->get_mod_id(); ?>");
    $('#tipo').val("edit");

    $('#mod_configuraciones_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_configuraciones_ver(); ?>);
    $('#mod_configuraciones_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_configuraciones_editar(); ?>);
    $('#mod_configuraciones_cantidad').val(<?php echo $o_Modulos_Permisos->get_mod_configuraciones_cantidad(); ?>);
    $('#mod_inicio_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_inicio_ver(); ?>);
    $('#mod_inicio_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_inicio_editar(); ?>);
    $('#mod_inicio_cantidad').val(<?php echo $o_Modulos_Permisos->get_mod_inicio_cantidad(); ?>);
    $('#mod_persona_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_crear(); ?>);
    $('#mod_persona_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_ver(); ?>);
    $('#mod_persona_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_editar(); ?>);
    $('#mod_persona_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_eliminar(); ?>);
    $('#mod_persona_cantidad').val(<?php echo $o_Modulos_Permisos->get_mod_persona_cantidad(); ?>);
    $('#mod_persona_huellas_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_huellas_crear(); ?>);//
    $('#mod_persona_huellas_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_huellas_ver(); ?>);
    $('#mod_persona_huellas_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_huellas_editar(); ?>);
    $('#mod_persona_huellas_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_huellas_eliminar(); ?>);//
    $('#mod_persona_huellas_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_persona_huellas_cantidad(); ?>);
    $('#mod_persona_rfid_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_rfid_crear(); ?>);//
    $('#mod_persona_rfid_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_rfid_ver(); ?>);
    $('#mod_persona_rfid_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_rfid_editar(); ?>);
    $('#mod_persona_rfid_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_persona_rfid_eliminar(); ?>);//
    $('#mod_persona_rfid_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_persona_rfid_cantidad(); ?>);
    $('#mod_grupo_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_grupo_crear(); ?>);
    $('#mod_grupo_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_grupo_ver(); ?>);
    $('#mod_grupo_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_grupo_editar(); ?>);
    $('#mod_grupo_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_grupo_eliminar(); ?>);
    $('#mod_grupo_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_grupo_cantidad(); ?>);
    $('#mod_horario_trabajo_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_trabajo_crear(); ?>);
    $('#mod_horario_trabajo_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_trabajo_ver(); ?>);
    $('#mod_horario_trabajo_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_trabajo_editar(); ?>);
    $('#mod_horario_trabajo_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_trabajo_eliminar(); ?>);
    $('#mod_horario_trabajo_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_horario_trabajo_cantidad(); ?>);
    $('#mod_horario_flexible_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_flexible_crear(); ?>);
    $('#mod_horario_flexible_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_flexible_ver(); ?>);
    $('#mod_horario_flexible_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_flexible_editar(); ?>);
    $('#mod_horario_flexible_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_flexible_eliminar(); ?>);
    $('#mod_horario_flexible_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_horario_flexible_cantidad(); ?>);
    $('#mod_horario_multiple_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_multiple_crear(); ?>);
    $('#mod_horario_multiple_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_multiple_ver(); ?>);
    $('#mod_horario_multiple_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_multiple_editar(); ?>);
    $('#mod_horario_multiple_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_multiple_eliminar(); ?>);
    $('#mod_horario_multiple_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_horario_multiple_cantidad(); ?>);
    $('#mod_horario_rotativo_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_rotativo_crear(); ?>);
    $('#mod_horario_rotativo_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_rotativo_ver(); ?>);
    $('#mod_horario_rotativo_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_rotativo_editar(); ?>);
    $('#mod_horario_rotativo_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_horario_rotativo_eliminar(); ?>);
    $('#mod_horario_rotativo_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_horario_rotativo_cantidad(); ?>);
    $('#mod_licencia_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_licencia_crear(); ?>);
    $('#mod_licencia_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_licencia_ver(); ?>);
    $('#mod_licencia_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_licencia_editar(); ?>);
    $('#mod_licencia_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_licencia_eliminar(); ?>);
    $('#mod_licencia_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_licencia_cantidad(); ?>);
    $('#mod_suspension_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_suspension_crear(); ?>);
    $('#mod_suspension_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_suspension_ver(); ?>);
    $('#mod_suspension_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_suspension_editar(); ?>);
    $('#mod_suspension_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_suspension_eliminar(); ?>);
    $('#mod_suspension_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_suspension_cantidad(); ?>);
    $('#mod_feriado_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_feriado_crear(); ?>);
    $('#mod_feriado_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_feriado_ver(); ?>);
    $('#mod_feriado_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_feriado_editar(); ?>);
    $('#mod_feriado_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_feriado_eliminar(); ?>);
    $('#mod_feriado_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_feriado_cantidad(); ?>);
    $('#mod_alerta_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_alerta_crear(); ?>);
    $('#mod_alerta_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_alerta_ver(); ?>);
    $('#mod_alerta_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_alerta_editar(); ?>);
    $('#mod_alerta_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_alerta_eliminar(); ?>);
    $('#mod_alerta_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_alerta_cantidad(); ?>);
    $('#mod_reporte_automatico_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_automatico_crear(); ?>);
    $('#mod_reporte_automatico_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_automatico_ver(); ?>);
    $('#mod_reporte_automatico_editar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_automatico_editar(); ?>);
    $('#mod_reporte_automatico_eliminar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_automatico_eliminar(); ?>);
    $('#mod_reporte_automatico_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_automatico_cantidad(); ?>);
    $('#mod_reporte_registros_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_registros_crear(); ?>);
    $('#mod_reporte_registros_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_registros_ver(); ?>);
    $('#mod_reporte_registros_descargar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_registros_descargar(); ?>);
    $('#mod_reporte_registros_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_registros_cantidad(); ?>);
    $('#mod_reporte_marcaciones_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_marcaciones_ver(); ?>);
    $('#mod_reporte_marcaciones_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_marcaciones_crear(); ?>);
    $('#mod_reporte_marcaciones_descargar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_marcaciones_descargar(); ?>);
    $('#mod_reporte_marcaciones_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_marcaciones_cantidad(); ?>);
    $('#mod_reporte_asistencias_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_asistencias_crear(); ?>);
    $('#mod_reporte_asistencias_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_asistencias_ver(); ?>);
    $('#mod_reporte_asistencias_descargar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_asistencias_descargar(); ?>);
    $('#mod_reporte_asistencias_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_asistencias_cantidad(); ?>);
    $('#mod_reporte_ausencias_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_ausencias_crear(); ?>);
    $('#mod_reporte_ausencias_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_ausencias_ver(); ?>);
    $('#mod_reporte_ausencias_descargar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_ausencias_descargar(); ?>);
    $('#mod_reporte_ausencias_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_ausencias_cantidad(); ?>);
    $('#mod_reporte_llegadas_tarde_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_llegadas_tarde_crear(); ?>);
    $('#mod_reporte_llegadas_tarde_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_llegadas_tarde_ver(); ?>);
    $('#mod_reporte_llegadas_tarde_descargar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_llegadas_tarde_descargar(); ?>);
    $('#mod_reporte_llegadas_tarde_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_llegadas_tarde_cantidad(); ?>);
    $('#mod_reporte_salidas_temprano_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_salidas_temprano_ver(); ?>);
    $('#mod_reporte_salidas_temprano_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_salidas_temprano_crear(); ?>);
    $('#mod_reporte_salidas_temprano_descargar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_salidas_temprano_descargar(); ?>);
    $('#mod_reporte_salidas_temprano_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_salidas_temprano_cantidad(); ?>);
    $('#mod_reporte_jornadas_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_jornadas_crear(); ?>);
    $('#mod_reporte_jornadas_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_jornadas_ver(); ?>);
    $('#mod_reporte_jornadas_descargar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_jornadas_descargar(); ?>);
    $('#mod_reporte_jornadas_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_jornadas_cantidad(); ?>);
    $('#mod_reporte_intervalos_crear').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_intervalos_crear(); ?>);
    $('#mod_reporte_intervalos_ver').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_intervalos_ver(); ?>);
    $('#mod_reporte_intervalos_descargar').prop('checked', <?php echo $o_Modulos_Permisos->get_mod_reporte_intervalos_descargar(); ?>);
    $('#mod_reporte_intervalos_cantidad').val( <?php echo $o_Modulos_Permisos->get_mod_reporte_intervalos_cantidad(); ?>);




    function openTab(evt, tabId) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabId).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("General_tab").click();



    $(document).ready(function () {

        $('#submit-editar').click(function () {

            var b = $("input:checkbox:not(:checked)");

            $(b).each(function () {
                $(this).prop("checked", true).val("off");
            });

            var $form = $('#editar-form');

            if (!$('#editar-form').valid()) {
                return false;
            }
            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),

                success: function (data, status) {
                    console.log('data',data);
                    console.log('status',status);
                    location.reload();
                    //$('#content').css({opacity : '0.0'}).html(data).delay(50).animate({opacity : '1.0'}, 300);

                }
            });

        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $(window).keydown(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                return false;
            }
        });

    });


</script>