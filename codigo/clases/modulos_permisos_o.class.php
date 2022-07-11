<?php

class Modulos_Permisos_O {

    private $_mod_id;
    private $_mod_detalle;

    private $_mod_configuraciones_ver;
    private $_mod_configuraciones_editar;
    private $_mod_configuraciones_cantidad;
    private $_mod_inicio_ver;
    private $_mod_inicio_editar;
    private $_mod_inicio_cantidad;
    private $_mod_persona_ver;
    private $_mod_persona_editar;
    private $_mod_persona_eliminar;
    private $_mod_persona_cantidad;
    private $_mod_persona_huellas_crear;
    private $_mod_persona_huellas_ver;
    private $_mod_persona_huellas_editar;
    private $_mod_persona_huellas_eliminar;
    private $_mod_persona_huellas_cantidad;
    private $_mod_persona_rfid_crear;
    private $_mod_persona_rfid_ver;
    private $_mod_persona_rfid_editar;
    private $_mod_persona_rfid_eliminar;
    private $_mod_persona_rfid_cantidad;
    private $_mod_grupo_crear;
    private $_mod_grupo_ver;
    private $_mod_grupo_editar;
    private $_mod_grupo_eliminar;
    private $_mod_grupo_cantidad;
    private $_mod_horario_trabajo_crear;
    private $_mod_horario_trabajo_ver;
    private $_mod_horario_trabajo_editar;
    private $_mod_horario_trabajo_eliminar;
    private $_mod_horario_trabajo_cantidad;
    private $_mod_horario_flexible_crear;
    private $_mod_horario_flexible_ver;
    private $_mod_horario_flexible_editar;
    private $_mod_horario_flexible_eliminar;
    private $_mod_horario_flexible_cantidad;
    private $_mod_horario_multiple_crear;
    private $_mod_horario_multiple_ver;
    private $_mod_horario_multiple_editar;
    private $_mod_horario_multiple_eliminar;
    private $_mod_horario_multiple_cantidad;
    private $_mod_horario_rotativo_crear;
    private $_mod_horario_rotativo_ver;
    private $_mod_horario_rotativo_editar;
    private $_mod_horario_rotativo_eliminar;
    private $_mod_horario_rotativo_cantidad;
    private $_mod_licencia_crear;
    private $_mod_licencia_ver;
    private $_mod_licencia_editar;
    private $_mod_licencia_eliminar;
    private $_mod_licencia_cantidad;
    private $_mod_suspension_crear;
    private $_mod_suspension_ver;
    private $_mod_suspension_editar;
    private $_mod_suspension_eliminar;
    private $_mod_suspension_cantidad;
    private $_mod_feriado_crear;
    private $_mod_feriado_ver;
    private $_mod_feriado_editar;
    private $_mod_feriado_eliminar;
    private $_mod_feriado_cantidad;
    private $_mod_alerta_crear;
    private $_mod_alerta_ver;
    private $_mod_alerta_editar;
    private $_mod_alerta_eliminar;
    private $_mod_alerta_cantidad;
    private $_mod_reporte_automatico_crear;
    private $_mod_reporte_automatico_ver;
    private $_mod_reporte_automatico_editar;
    private $_mod_reporte_automatico_eliminar;
    private $_mod_reporte_automatico_cantidad;
    private $_mod_reporte_registros_crear;
    private $_mod_reporte_registros_ver;
    private $_mod_reporte_registros_descargar;
    private $_mod_reporte_registros_cantidad;
    private $_mod_reporte_marcaciones_crear;
    private $_mod_reporte_marcaciones_ver;
    private $_mod_reporte_marcaciones_descargar;
    private $_mod_reporte_marcaciones_cantidad;
    private $_mod_reporte_asistencias_crear;
    private $_mod_reporte_asistencias_ver;
    private $_mod_reporte_asistencias_descargar;
    private $_mod_reporte_asistencias_cantidad;
    private $_mod_reporte_ausencias_crear;
    private $_mod_reporte_ausencias_ver;
    private $_mod_reporte_ausencias_descargar;
    private $_mod_reporte_ausencias_cantidad;
    private $_mod_reporte_llegadas_tarde_crear;
    private $_mod_reporte_llegadas_tarde_ver;
    private $_mod_reporte_llegadas_tarde_descargar;
    private $_mod_reporte_llegadas_tarde_cantidad;
    private $_mod_reporte_salidas_temprano_crear;
    private $_mod_reporte_salidas_temprano_ver;
    private $_mod_reporte_salidas_temprano_descargar;
    private $_mod_reporte_salidas_temprano_cantidad;
    private $_mod_reporte_jornadas_crear;
    private $_mod_reporte_jornadas_ver;
    private $_mod_reporte_jornadas_descargar;
    private $_mod_reporte_jornadas_cantidad;
    private $_mod_reporte_intervalos_crear;
    private $_mod_reporte_intervalos_ver;
    private $_mod_reporte_intervalos_descargar;
    private $_mod_reporte_intervalos_cantidad;

    private $_errores;

    public function __construct(){
        $this->_mod_id = 0;
        $this->_mod_detalle = '';


        $this->_mod_configuraciones_editar = 0;
        $this->_mod_configuraciones_cantidad = 0;

        $this->_mod_inicio_editar = 0;
        $this->_mod_inicio_cantidad = 0;
        $this->_mod_persona_crear = 0;
        $this->_mod_persona_editar = 0;
        $this->_mod_persona_eliminar = 0;
        $this->_mod_persona_cantidad = 0;
        $this->_mod_persona_huellas_crear = 0;
        $this->_mod_persona_huellas_editar = 0;
        $this->_mod_persona_huellas_eliminar = 0;
        $this->_mod_persona_huellas_cantidad = 0;
        $this->_mod_persona_rfid_crear = 0;
        $this->_mod_persona_rfid_editar = 0;
        $this->_mod_persona_rfid_eliminar = 0;
        $this->_mod_persona_rfid_cantidad = 0;
        $this->_mod_grupo_crear = 0;
        $this->_mod_grupo_editar = 0;
        $this->_mod_grupo_eliminar = 0;
        $this->_mod_grupo_cantidad = 0;
        $this->_mod_horario_trabajo_crear = 0;
        $this->_mod_horario_trabajo_editar = 0;
        $this->_mod_horario_trabajo_eliminar = 0;
        $this->_mod_horario_trabajo_cantidad = 0;
        $this->_mod_horario_flexible_crear = 0;
        $this->_mod_horario_flexible_editar = 0;
        $this->_mod_horario_flexible_eliminar = 0;
        $this->_mod_horario_flexible_cantidad = 0;
        $this->_mod_horario_multiple_crear = 0;
        $this->_mod_horario_multiple_editar = 0;
        $this->_mod_horario_multiple_eliminar = 0;
        $this->_mod_horario_multiple_cantidad = 0;
        $this->_mod_horario_rotativo_crear = 0;
        $this->_mod_horario_rotativo_editar = 0;
        $this->_mod_horario_rotativo_eliminar = 0;
        $this->_mod_horario_rotativo_cantidad = 0;
        $this->_mod_licencia_crear = 0;
        $this->_mod_licencia_editar = 0;
        $this->_mod_licencia_eliminar = 0;
        $this->_mod_licencia_cantidad = 0;
        $this->_mod_suspension_crear = 0;
        $this->_mod_suspension_editar = 0;
        $this->_mod_suspension_eliminar = 0;
        $this->_mod_suspension_cantidad = 0;
        $this->_mod_feriado_crear = 0;
        $this->_mod_feriado_editar = 0;
        $this->_mod_feriado_eliminar = 0;
        $this->_mod_feriado_cantidad = 0;
        $this->_mod_alerta_crear = 0;
        $this->_mod_alerta_editar = 0;
        $this->_mod_alerta_eliminar = 0;
        $this->_mod_alerta_cantidad = 0;
        $this->_mod_reporte_automatico_crear = 0;
        $this->_mod_reporte_automatico_editar = 0;
        $this->_mod_reporte_automatico_eliminar = 0;
        $this->_mod_reporte_automatico_cantidad = 0;
        $this->_mod_reporte_registros_crear = 0;
        $this->_mod_reporte_registros_descargar = 0;
        $this->_mod_reporte_registros_cantidad = 0;
        $this->_mod_reporte_marcaciones_crear = 0;
        $this->_mod_reporte_marcaciones_descargar = 0;
        $this->_mod_reporte_marcaciones_cantidad = 0;
        $this->_mod_reporte_asistencias_crear = 0;
        $this->_mod_reporte_asistencias_descargar = 0;
        $this->_mod_reporte_asistencias_cantidad = 0;
        $this->_mod_reporte_ausencias_crear = 0;
        $this->_mod_reporte_ausencias_descargar = 0;
        $this->_mod_reporte_ausencias_cantidad = 0;
        $this->_mod_reporte_llegadas_tarde_crear = 0;
        $this->_mod_reporte_llegadas_tarde_descargar = 0;
        $this->_mod_reporte_llegadas_tarde_cantidad = 0;
        $this->_mod_reporte_salidas_temprano_crear = 0;
        $this->_mod_reporte_salidas_temprano_descargar = 0;
        $this->_mod_reporte_salidas_temprano_cantidad = 0;
        $this->_mod_reporte_jornadas_crear = 0;
        $this->_mod_reporte_jornadas_descargar = 0;
        $this->_mod_reporte_jornadas_cantidad = 0;
        $this->_mod_reporte_intervalos_crear = 0;
        $this->_mod_reporte_intervalos_descargar = 0;
        $this->_mod_reporte_intervalos_cantidad = 0;

        $this->_mod_configuraciones_ver = 0;
        $this->_mod_inicio_ver= 0;
        $this->_mod_persona_ver= 0;
        $this->_mod_persona_huellas_ver= 0;
        $this->_mod_persona_rfid_ver= 0;
        $this->_mod_grupo_ver= 0;
        $this->_mod_horario_trabajo_ver= 0;
        $this->_mod_horario_flexible_ver= 0;
        $this->_mod_horario_multiple_ver= 0;
        $this->_mod_horario_rotativo_ver= 0;
        $this->_mod_licencia_ver= 0;
        $this->_mod_suspension_ver= 0;
        $this->_mod_feriado_ver= 0;
        $this->_mod_alerta_ver= 0;
        $this->_mod_reporte_automatico_ver= 0;
        $this->_mod_reporte_registros_ver= 0;
        $this->_mod_reporte_marcaciones_ver= 0;
        $this->_mod_reporte_asistencias_ver= 0;
        $this->_mod_reporte_ausencias_ver= 0;
        $this->_mod_reporte_llegadas_tarde_ver= 0;
        $this->_mod_reporte_salidas_temprano_ver= 0;
        $this->_mod_reporte_jornadas_ver= 0;
        $this->_mod_reporte_intervalos_ver= 0;
    }

    public function get_mod_id() {
        return $this->_mod_id;
    }
    public function set_mod_id($p_) {
        $p_ = (integer) $p_;
        $this->_mod_id = $p_;
    }

    public function get_mod_detalle() {
        return $this->_mod_detalle;
    }
    public function set_mod_detalle($p_) {
        $p_ = (string) $p_;
        $this->_mod_detalle = $p_;
    }


    public function get_mod_inicio_ver() {
        return (integer) $this->_mod_inicio_ver;
    }
    public function set_mod_inicio_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_inicio_ver = $p_;
    }

    public function get_mod_inicio_editar() {
        return (integer) $this->_mod_inicio_editar;

    }
    public function set_mod_inicio_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_inicio_editar = $p_;
    }

    public function get_mod_inicio_cantidad() {
        return (integer) $this->_mod_inicio_cantidad;

    }
    public function set_mod_inicio_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_inicio_cantidad = $p_;
    }


    ///////////////
    public function get_mod_configuraciones_ver() {
        return (integer) $this->_mod_configuraciones_ver;
    }
    public function set_mod_configuraciones_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_configuraciones_ver = $p_;
    }

    public function get_mod_configuraciones_editar() {
        return (integer) $this->_mod_configuraciones_editar;

    }
    public function set_mod_configuraciones_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_configuraciones_editar = $p_;
    }

    public function get_mod_configuraciones_cantidad() {
        return (integer) $this->_mod_configuraciones_cantidad;

    }
    public function set_mod_configuraciones_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_configuraciones_cantidad = $p_;
    }



    /////////////

    public function get_mod_persona_crear() {
        return (integer) $this->_mod_persona_crear;

    }
    public function set_mod_persona_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_crear = $p_;
    }

    public function get_mod_persona_ver() {
        return (integer) $this->_mod_persona_ver;

    }
    public function set_mod_persona_verr($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_ver = $p_;
    }

    public function get_mod_persona_editar() {
        return (integer) $this->_mod_persona_editar;
    }
    public function set_mod_persona_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_editar = $p_;
    }

    public function get_mod_persona_eliminar() {
        return $this->_mod_persona_eliminar;
    }
    public function set_mod_persona_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_eliminar = $p_;
    }

    public function get_mod_persona_cantidad() {
        return $this->_mod_persona_cantidad;
    }
    public function set_mod_persona_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_cantidad = $p_;
    }


    public function get_mod_persona_huellas_crear() {
        return (integer) $this->_mod_persona_huellas_crear;

    }
    public function set_mod_persona_huellas_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_huellas_crear = $p_;
    }

    public function get_mod_persona_huellas_ver() {
        return (integer) $this->_mod_persona_huellas_ver;

    }
    public function set_mod_persona_huellas_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_huellas_crear = $p_;
    }

    public function get_mod_persona_huellas_editar() {
        return $this->_mod_persona_huellas_editar;
    }
    public function set_mod_persona_huellas_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_huellas_editar = $p_;
    }

    public function get_mod_persona_huellas_eliminar() {
        return (integer) $this->_mod_persona_huellas_eliminar;

    }
    public function set_mod_persona_huellas_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_huellas_eliminar = $p_;
    }

    public function get_mod_persona_huellas_cantidad() {
        return $this->_mod_persona_huellas_cantidad;
    }
    public function set_mod_persona_huellas_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_huellas_cantidad = $p_;
    }


    public function get_mod_persona_rfid_crear() {
        return (integer) $this->_mod_persona_rfid_crear;

    }
    public function set_mod_persona_rfid_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_rfid_crear = $p_;
    }

    public function get_mod_persona_rfid_ver() {
        return (integer) $this->_mod_persona_rfid_ver;

    }
    public function set_mod_persona_rfid_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_rfid_ver = $p_;
    }

    public function get_mod_persona_rfid_editar() {
        return $this->_mod_persona_rfid_editar;
    }
    public function set_mod_persona_rfid_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_rfid_editar = $p_;
    }

    public function get_mod_persona_rfid_eliminar() {
        return (integer) $this->_mod_persona_rfid_eliminar;

    }
    public function set_mod_persona_rfid_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_rfid_eliminar = $p_;
    }

    public function get_mod_persona_rfid_cantidad() {
        return $this->_mod_persona_rfid_cantidad;
    }
    public function set_mod_persona_rfid_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_persona_rfid_cantidad = $p_;
    }


    public function get_mod_grupo_crear() {
        return $this->_mod_grupo_crear;
    }
    public function set_mod_grupo_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_grupo_crear = $p_;
    }

    public function get_mod_grupo_ver() {
        return $this->_mod_grupo_ver;
    }
    public function set_mod_grupo_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_grupo_ver = $p_;
    }

    public function get_mod_grupo_editar() {
        return $this->_mod_grupo_editar;
    }
    public function set_mod_grupo_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_grupo_editar = $p_;
    }

    public function get_mod_grupo_eliminar() {
        return $this->_mod_grupo_eliminar;
    }
    public function set_mod_grupo_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_grupo_eliminar = $p_;
    }

    public function get_mod_grupo_cantidad() {
        return $this->_mod_grupo_cantidad;
    }
    public function set_mod_grupo_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_grupo_cantidad = $p_;
    }


    public function get_mod_horario_trabajo_crear() {
        return $this->_mod_horario_trabajo_crear;
    }
    public function set_mod_horario_trabajo_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_trabajo_crear = $p_;
    }

    public function get_mod_horario_trabajo_ver() {
        return $this->_mod_horario_trabajo_ver;
    }
    public function set_mod_horario_trabajo_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_trabajo_ver = $p_;
    }

    public function get_mod_horario_trabajo_editar() {
        return $this->_mod_horario_trabajo_editar;
    }
    public function set_mod_horario_trabajo_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_trabajo_editar = $p_;
    }

    public function get_mod_horario_trabajo_eliminar() {
        return $this->_mod_horario_trabajo_eliminar;
    }
    public function set_mod_horario_trabajo_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_trabajo_eliminar = $p_;
    }

    public function get_mod_horario_trabajo_cantidad() {
        return $this->_mod_horario_trabajo_cantidad;
    }
    public function set_mod_horario_trabajo_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_trabajo_cantidad = $p_;
    }


    public function get_mod_horario_flexible_crear() {
        return $this->_mod_horario_flexible_crear;
    }
    public function set_mod_horario_flexible_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_flexible_crear = $p_;
    }

    public function get_mod_horario_flexible_ver() {
        return $this->_mod_horario_flexible_ver;
    }
    public function set_mod_horario_flexible_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_flexible_ver = $p_;
    }

    public function get_mod_horario_flexible_editar() {
        return $this->_mod_horario_flexible_editar;
    }
    public function set_mod_horario_flexible_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_flexible_editar = $p_;
    }

    public function get_mod_horario_flexible_eliminar() {
        return $this->_mod_horario_flexible_eliminar;
    }
    public function set_mod_horario_flexible_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_flexible_eliminar = $p_;
    }

    public function get_mod_horario_flexible_cantidad() {
        return $this->_mod_horario_flexible_cantidad;
    }
    public function set_mod_horario_flexible_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_flexible_cantidad = $p_;
    }


    public function get_mod_horario_multiple_crear() {
        return $this->_mod_horario_multiple_crear;
    }
    public function set_mod_horario_multiple_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_multiple_crear = $p_;
    }

    public function get_mod_horario_multiple_ver() {
        return $this->_mod_horario_multiple_ver;
    }
    public function set_mod_horario_multiple_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_multiple_ver = $p_;
    }

    public function get_mod_horario_multiple_editar() {
        return $this->_mod_horario_multiple_editar;
    }
    public function set_mod_horario_multiple_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_multiple_editar = $p_;
    }

    public function get_mod_horario_multiple_eliminar() {
        return $this->_mod_horario_multiple_eliminar;
    }
    public function set_mod_horario_multiple_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_multiple_eliminar = $p_;
    }

    public function get_mod_horario_multiple_cantidad() {
        return $this->_mod_horario_multiple_cantidad;
    }
    public function set_mod_horario_multiple_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_multiple_cantidad = $p_;
    }


    public function get_mod_horario_rotativo_crear() {
        return $this->_mod_horario_rotativo_crear;
    }
    public function set_mod_horario_rotativo_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_rotativo_crear = $p_;
    }

    public function get_mod_horario_rotativo_ver() {
        return $this->_mod_horario_rotativo_ver;
    }
    public function set_mod_horario_rotativo_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_rotativo_ver = $p_;
    }

    public function get_mod_horario_rotativo_editar() {
        return $this->_mod_horario_rotativo_editar;
    }
    public function set_mod_horario_rotativo_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_rotativo_editar = $p_;
    }

    public function get_mod_horario_rotativo_eliminar() {
        return $this->_mod_horario_rotativo_eliminar;
    }
    public function set_mod_horario_rotativo_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_rotativo_eliminar = $p_;
    }

    public function get_mod_horario_rotativo_cantidad() {
        return $this->_mod_horario_rotativo_cantidad;
    }
    public function set_mod_horario_rotativo_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_horario_rotativo_cantidad = $p_;
    }


    public function get_mod_licencia_crear() {
        return $this->_mod_licencia_crear;
    }
    public function set_mod_licencia_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_licencia_crear = $p_;
    }

    public function get_mod_licencia_ver() {
        return $this->_mod_licencia_ver;
    }
    public function set_mod_licencia_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_licencia_ver = $p_;
    }

    public function get_mod_licencia_editar() {
        return $this->_mod_licencia_editar;
    }
    public function set_mod_licencia_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_licencia_editar = $p_;
    }

    public function get_mod_licencia_eliminar() {
        return $this->_mod_licencia_eliminar;
    }
    public function set_mod_licencia_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_licencia_eliminar = $p_;
    }

    public function get_mod_licencia_cantidad() {
        return $this->_mod_licencia_cantidad;
    }
    public function set_mod_licencia_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_licencia_cantidad = $p_;
    }


    public function get_mod_suspension_crear() {
        return $this->_mod_suspension_crear;
    }
    public function set_mod_suspension_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_suspension_crear = $p_;
    }

    public function get_mod_suspension_ver() {
        return $this->_mod_suspension_ver;
    }
    public function set_mod_suspension_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_suspension_ver = $p_;
    }

    public function get_mod_suspension_editar() {
        return $this->_mod_suspension_editar;
    }
    public function set_mod_suspension_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_suspension_editar = $p_;
    }

    public function get_mod_suspension_eliminar() {
        return $this->_mod_suspension_eliminar;
    }
    public function set_mod_suspension_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_suspension_eliminar = $p_;
    }

    public function get_mod_suspension_cantidad() {
        return $this->_mod_suspension_cantidad;
    }
    public function set_mod_suspension_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_suspension_cantidad = $p_;
    }


    public function get_mod_feriado_crear() {
        return $this->_mod_feriado_crear;
    }
    public function set_mod_feriado_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_feriado_crear = $p_;
    }

    public function get_mod_feriado_ver() {
        return $this->_mod_feriado_ver;
    }
    public function set_mod_feriado_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_feriado_ver = $p_;
    }

    public function get_mod_feriado_editar() {
        return $this->_mod_feriado_editar;
    }
    public function set_mod_feriado_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_feriado_editar = $p_;
    }

    public function get_mod_feriado_eliminar() {
        return $this->_mod_feriado_eliminar;
    }
    public function set_mod_feriado_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_feriado_eliminar = $p_;
    }

    public function get_mod_feriado_cantidad() {
        return $this->_mod_feriado_cantidad;
    }
    public function set_mod_feriado_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_feriado_cantidad = $p_;
    }


    public function get_mod_alerta_crear() {
        return $this->_mod_alerta_crear;
    }
    public function set_mod_alerta_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_alerta_crear = $p_;
    }

    public function get_mod_alerta_ver() {
        return $this->_mod_alerta_ver;
    }
    public function set_mod_alerta_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_alerta_ver = $p_;
    }

    public function get_mod_alerta_editar() {
        return $this->_mod_alerta_editar;
    }
    public function set_mod_alerta_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_alerta_editar = $p_;
    }

    public function get_mod_alerta_eliminar() {
        return $this->_mod_alerta_eliminar;
    }
    public function set_mod_alerta_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_alerta_eliminar = $p_;
    }

    public function get_mod_alerta_cantidad() {
        return $this->_mod_alerta_cantidad;
    }
    public function set_mod_alerta_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_alerta_cantidad = $p_;
    }


    public function get_mod_reporte_automatico_crear() {
        return $this->_mod_reporte_automatico_crear;
    }
    public function set_mod_reporte_automatico_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_automatico_crear = $p_;
    }

    public function get_mod_reporte_automatico_ver() {
        return $this->_mod_reporte_automatico_ver;
    }
    public function set_mod_reporte_automatico_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_automatico_ver = $p_;
    }

    public function get_mod_reporte_automatico_editar() {
        return $this->_mod_reporte_automatico_editar;
    }
    public function set_mod_reporte_automatico_editar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_automatico_editar = $p_;
    }

    public function get_mod_reporte_automatico_eliminar() {
        return $this->_mod_reporte_automatico_eliminar;
    }
    public function set_mod_reporte_automatico_eliminar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_automatico_eliminar = $p_;
    }

    public function get_mod_reporte_automatico_cantidad() {
        return $this->_mod_reporte_automatico_cantidad;
    }
    public function set_mod_reporte_automatico_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_automatico_cantidad = $p_;
    }


    public function get_mod_reporte_registros_crear() {
        return $this->_mod_reporte_registros_crear;
    }
    public function set_mod_reporte_registros_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_registros_crear = $p_;
    }

    public function get_mod_reporte_registros_ver() {
        return $this->_mod_reporte_registros_ver;
    }
    public function set_mod_reporte_registros_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_registros_ver = $p_;
    }

    public function get_mod_reporte_registros_descargar() {
        return $this->_mod_reporte_registros_descargar;
    }
    public function set_mod_reporte_registros_descargar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_registros_descargar = $p_;
    }

    public function get_mod_reporte_registros_cantidad() {
        return $this->_mod_reporte_registros_cantidad;
    }
    public function set_mod_reporte_registros_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_registros_cantidad = $p_;
    }


    public function get_mod_reporte_marcaciones_crear() {
        return $this->_mod_reporte_marcaciones_crear;
    }
    public function set_mod_reporte_marcaciones_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_marcaciones_crear = $p_;
    }

    public function get_mod_reporte_marcaciones_ver() {
        return $this->_mod_reporte_marcaciones_ver;
    }
    public function set_mod_reporte_marcaciones_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_marcaciones_ver = $p_;
    }

    public function get_mod_reporte_marcaciones_descargar() {
        return $this->_mod_reporte_marcaciones_descargar;
    }
    public function set_mod_reporte_marcaciones_descargar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_marcaciones_descargar = $p_;
    }

    public function get_mod_reporte_marcaciones_cantidad() {
        return $this->_mod_reporte_marcaciones_cantidad;
    }
    public function set_mod_reporte_marcaciones_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_marcaciones_cantidad = $p_;
    }


    public function get_mod_reporte_asistencias_crear() {
        return $this->_mod_reporte_asistencias_crear;
    }
    public function set_mod_reporte_asistencias_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_asistencias_crear = $p_;
    }

    public function get_mod_reporte_asistencias_ver() {
        return $this->_mod_reporte_asistencias_ver;
    }
    public function set_mod_reporte_asistencias_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_asistencias_ver = $p_;
    }

    public function get_mod_reporte_asistencias_descargar() {
        return $this->_mod_reporte_asistencias_descargar;
    }
    public function set_mod_reporte_asistencias_descargar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_asistencias_descargar = $p_;
    }

    public function get_mod_reporte_asistencias_cantidad() {
        return $this->_mod_reporte_asistencias_cantidad;
    }
    public function set_mod_reporte_asistencias_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_asistencias_cantidad = $p_;
    }


    public function get_mod_reporte_ausencias_crear() {
        return $this->_mod_reporte_ausencias_crear;
    }
    public function set_mod_reporte_ausencias_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_ausencias_crear = $p_;
    }

    public function get_mod_reporte_ausencias_ver() {
        return $this->_mod_reporte_ausencias_ver;
    }
    public function set_mod_reporte_ausencias_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_ausencias_ver = $p_;
    }

    public function get_mod_reporte_ausencias_descargar() {
        return $this->_mod_reporte_ausencias_descargar;
    }
    public function set_mod_reporte_ausencias_descargar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_ausencias_descargar = $p_;
    }

    public function get_mod_reporte_ausencias_cantidad() {
        return $this->_mod_reporte_ausencias_cantidad;
    }
    public function set_mod_reporte_ausencias_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_ausencias_cantidad = $p_;
    }


    public function get_mod_reporte_llegadas_tarde_crear() {
        return $this->_mod_reporte_llegadas_tarde_crear;
    }
    public function set_mod_reporte_llegadas_tarde_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_llegadas_tarde_crear = $p_;
    }

    public function get_mod_reporte_llegadas_tarde_ver() {
        return $this->_mod_reporte_llegadas_tarde_ver;
    }
    public function set_mod_reporte_llegadas_tarde_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_llegadas_tarde_ver = $p_;
    }

    public function get_mod_reporte_llegadas_tarde_descargar() {
        return $this->_mod_reporte_llegadas_tarde_descargar;
    }
    public function set_mod_reporte_llegadas_tarde_descargar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_llegadas_tarde_descargar = $p_;
    }

    public function get_mod_reporte_llegadas_tarde_cantidad() {
        return $this->_mod_reporte_llegadas_tarde_cantidad;
    }
    public function set_mod_reporte_llegadas_tarde_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_llegadas_tarde_cantidad = $p_;
    }


    public function get_mod_reporte_salidas_temprano_crear() {
        return $this->_mod_reporte_salidas_temprano_crear;
    }
    public function set_mod_reporte_salidas_temprano_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_salidas_temprano_crear = $p_;
    }

    public function get_mod_reporte_salidas_temprano_ver() {
        return $this->_mod_reporte_salidas_temprano_ver;
    }
    public function set_mod_reporte_salidas_temprano_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_salidas_temprano_ver = $p_;
    }

    public function get_mod_reporte_salidas_temprano_descargar() {
        return $this->_mod_reporte_salidas_temprano_descargar;
    }
    public function set_mod_reporte_salidas_temprano_descargar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_salidas_temprano_descargar = $p_;
    }

    public function get_mod_reporte_salidas_temprano_cantidad() {
        return $this->_mod_reporte_salidas_temprano_cantidad;
    }
    public function set_mod_reporte_salidas_temprano_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_salidas_temprano_cantidad = $p_;
    }

    public function get_mod_reporte_jornadas_crear() {
        return $this->_mod_reporte_jornadas_crear;
    }
    public function set_mod_reporte_jornadas_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_jornadas_crear = $p_;
    }

    public function get_mod_reporte_jornadas_ver() {
        return $this->_mod_reporte_jornadas_ver;
    }
    public function set_mod_reporte_jornadas_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_jornadas_ver = $p_;
    }

    public function get_mod_reporte_jornadas_descargar() {
        return $this->_mod_reporte_jornadas_descargar;
    }
    public function set_mod_reporte_jornadas_descargar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_jornadas_descargar = $p_;
    }

    public function get_mod_reporte_jornadas_cantidad() {
        return $this->_mod_reporte_jornadas_cantidad;
    }
    public function set_mod_reporte_jornadas_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_jornadas_cantidad = $p_;
    }

    public function get_mod_reporte_intervalos_crear() {
        return $this->_mod_reporte_intervalos_crear;
    }
    public function set_mod_reporte_intervalos_crear($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_intervalos_crear = $p_;
    }

    public function get_mod_reporte_intervalos_ver() {
        return $this->_mod_reporte_intervalos_ver;
    }
    public function set_mod_reporte_intervalos_ver($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_intervalos_ver = $p_;
    }

    public function get_mod_reporte_intervalos_descargar() {
        return $this->_mod_reporte_intervalos_descargar;
    }
    public function set_mod_reporte_intervalos_descargar($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_intervalos_descargar = $p_;
    }

    public function get_mod_reporte_intervalos_cantidad() {
        return $this->_mod_reporte_intervalos_cantidad;
    }
    public function set_mod_reporte_intervalos_cantidad($p_) {
        $p_ = (integer) $p_;
        $this->_mod_reporte_intervalos_cantidad = $p_;
    }

    public function get_errores() {
        return $this->_errores;
    }

    public function loadArray($p_Datos){

        $this->_mod_id                                  = isset($p_Datos ['mod_id']) ? (integer) $p_Datos ['mod_id'] : $this->_mod_id;
        $this->_mod_detalle                             = isset($p_Datos ['mod_detalle']) ? (string) $p_Datos ['mod_detalle'] : $this->_mod_detalle;

        $this->_mod_configuraciones_ver                 = isset($p_Datos ['mod_configuraciones_ver']) ? filter_var( $p_Datos ['mod_configuraciones_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_configuraciones_ver;
        $this->_mod_configuraciones_editar              = isset($p_Datos ['mod_configuraciones_editar']) ? filter_var( $p_Datos ['mod_configuraciones_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_configuraciones_editar;
        $this->_mod_configuraciones_cantidad            = isset($p_Datos ['mod_configuraciones_cantidad']) ? (integer) $p_Datos ['mod_configuraciones_cantidad'] : $this->_mod_configuraciones_cantidad;

        $this->_mod_inicio_editar                       = isset($p_Datos ['mod_inicio_editar']) ? filter_var( $p_Datos ['mod_inicio_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_inicio_editar;
        $this->_mod_inicio_cantidad                     = isset($p_Datos ['mod_inicio_cantidad']) ? (integer) $p_Datos ['mod_inicio_cantidad'] : $this->_mod_inicio_cantidad;
        $this->_mod_persona_crear                       = isset($p_Datos ['mod_persona_crear']) ? filter_var( $p_Datos ['mod_persona_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_crear;
        $this->_mod_persona_editar                      = isset($p_Datos ['mod_persona_editar']) ? filter_var( $p_Datos ['mod_persona_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_editar;
        $this->_mod_persona_eliminar                    = isset($p_Datos ['mod_persona_eliminar']) ? filter_var( $p_Datos ['mod_persona_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_eliminar;
        $this->_mod_persona_cantidad                    = isset($p_Datos ['mod_persona_cantidad']) ? (integer) $p_Datos ['mod_persona_cantidad'] : $this->_mod_persona_cantidad;
        $this->_mod_persona_huellas_crear               = isset($p_Datos ['mod_persona_huellas_crear']) ? filter_var( $p_Datos ['mod_persona_huellas_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_huellas_crear;
        $this->_mod_persona_huellas_editar              = isset($p_Datos ['mod_persona_huellas_editar']) ? filter_var( $p_Datos ['mod_persona_huellas_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_huellas_editar;
        $this->_mod_persona_huellas_eliminar            = isset($p_Datos ['mod_persona_huellas_eliminar ']) ? filter_var( $p_Datos ['mod_persona_huellas_eliminar '] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_huellas_eliminar;
        $this->_mod_persona_huellas_cantidad            = isset($p_Datos ['mod_persona_huellas_cantidad']) ? (integer) $p_Datos ['mod_persona_huellas_cantidad'] : $this->_mod_persona_huellas_cantidad;
        $this->_mod_persona_rfid_crear                  = isset($p_Datos ['mod_persona_rfid_crear']) ? filter_var( $p_Datos ['mod_persona_rfid_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_rfid_crear;
        $this->_mod_persona_rfid_editar                 = isset($p_Datos ['mod_persona_rfid_editar']) ? filter_var( $p_Datos ['mod_persona_rfid_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_rfid_editar;
        $this->_mod_persona_rfid_eliminar               = isset($p_Datos ['mod_persona_rfid_eliminar']) ? filter_var( $p_Datos ['mod_persona_rfid_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_rfid_eliminar;
        $this->_mod_persona_rfid_cantidad               = isset($p_Datos ['mod_persona_rfid_cantidad']) ? (integer) $p_Datos ['mod_persona_rfid_cantidad'] : $this->_mod_persona_rfid_cantidad;
        $this->_mod_grupo_crear                         = isset($p_Datos ['mod_grupo_crear']) ? filter_var( $p_Datos ['mod_grupo_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_grupo_crear;
        $this->_mod_grupo_editar                        = isset($p_Datos ['mod_grupo_editar']) ? filter_var( $p_Datos ['mod_grupo_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_grupo_editar;
        $this->_mod_grupo_eliminar                      = isset($p_Datos ['mod_grupo_eliminar']) ? filter_var( $p_Datos ['mod_grupo_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_grupo_eliminar;
        $this->_mod_grupo_cantidad                      = isset($p_Datos ['mod_grupo_cantidad']) ? (integer) $p_Datos ['mod_grupo_cantidad'] : $this->_mod_grupo_cantidad;
        $this->_mod_horario_trabajo_crear               = isset($p_Datos ['mod_horario_trabajo_crear']) ? filter_var( $p_Datos ['mod_horario_trabajo_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_trabajo_crear;
        $this->_mod_horario_trabajo_editar              = isset($p_Datos ['mod_horario_trabajo_editar']) ? filter_var( $p_Datos ['mod_horario_trabajo_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_trabajo_editar;
        $this->_mod_horario_trabajo_eliminar            = isset($p_Datos ['mod_horario_trabajo_eliminar']) ? filter_var( $p_Datos ['mod_horario_trabajo_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_trabajo_eliminar;
        $this->_mod_horario_trabajo_cantidad            = isset($p_Datos ['mod_horario_trabajo_cantidad']) ? (integer) $p_Datos ['mod_horario_trabajo_cantidad'] : $this->_mod_horario_trabajo_cantidad;
        $this->_mod_horario_flexible_crear              = isset($p_Datos ['mod_horario_flexible_crear']) ? filter_var( $p_Datos ['mod_horario_flexible_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_flexible_crear;
        $this->_mod_horario_flexible_editar             = isset($p_Datos ['mod_horario_flexible_editar']) ? filter_var( $p_Datos ['mod_horario_flexible_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_flexible_editar;
        $this->_mod_horario_flexible_eliminar           = isset($p_Datos ['mod_horario_flexible_eliminar']) ? filter_var( $p_Datos ['mod_horario_flexible_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_flexible_eliminar;
        $this->_mod_horario_flexible_cantidad           = isset($p_Datos ['mod_horario_flexible_cantidad']) ? (integer) $p_Datos ['mod_horario_flexible_cantidad'] : $this->_mod_horario_flexible_cantidad;
        $this->_mod_horario_multiple_crear              = isset($p_Datos ['mod_horario_multiple_crear']) ? filter_var( $p_Datos ['mod_horario_multiple_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_multiple_crear;
        $this->_mod_horario_multiple_editar             = isset($p_Datos ['mod_horario_multiple_editar']) ? filter_var( $p_Datos ['mod_horario_multiple_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_multiple_editar;
        $this->_mod_horario_multiple_eliminar           = isset($p_Datos ['mod_horario_multiple_eliminar']) ? filter_var( $p_Datos ['mod_horario_multiple_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_multiple_eliminar;
        $this->_mod_horario_multiple_cantidad           = isset($p_Datos ['mod_horario_multiple_cantidad']) ? (integer) $p_Datos ['mod_horario_multiple_cantidad'] : $this->_mod_horario_multiple_cantidad;
        $this->_mod_horario_rotativo_crear              = isset($p_Datos ['mod_horario_rotativo_crear']) ? filter_var( $p_Datos ['mod_horario_rotativo_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_rotativo_crear;
        $this->_mod_horario_rotativo_editar             = isset($p_Datos ['mod_horario_rotativo_editar']) ? filter_var( $p_Datos ['mod_horario_rotativo_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_rotativo_editar;
        $this->_mod_horario_rotativo_eliminar           = isset($p_Datos ['mod_horario_rotativo_eliminar']) ? filter_var( $p_Datos ['mod_horario_rotativo_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_rotativo_eliminar;
        $this->_mod_horario_rotativo_cantidad           = isset($p_Datos ['mod_horario_rotativo_cantidad']) ? (integer) $p_Datos ['mod_horario_rotativo_cantidad'] : $this->_mod_horario_rotativo_cantidad;
        $this->_mod_licencia_crear                      = isset($p_Datos ['mod_licencia_crear']) ? filter_var( $p_Datos ['mod_licencia_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_licencia_crear;
        $this->_mod_licencia_editar                     = isset($p_Datos ['mod_licencia_editar']) ? filter_var( $p_Datos ['mod_licencia_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_licencia_editar;
        $this->_mod_licencia_eliminar                   = isset($p_Datos ['mod_licencia_eliminar']) ? filter_var( $p_Datos ['mod_licencia_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_licencia_eliminar;
        $this->_mod_licencia_cantidad                   = isset($p_Datos ['mod_licencia_cantidad']) ? (integer) $p_Datos ['mod_licencia_cantidad'] : $this->_mod_licencia_cantidad;
        $this->_mod_suspension_crear                    = isset($p_Datos ['mod_suspension_crear']) ? filter_var( $p_Datos ['mod_suspension_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_suspension_crear;
        $this->_mod_suspension_editar                   = isset($p_Datos ['mod_suspension_editar']) ? filter_var( $p_Datos ['mod_suspension_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_suspension_editar;
        $this->_mod_suspension_eliminar                 = isset($p_Datos ['mod_suspension_eliminar']) ? filter_var( $p_Datos ['mod_suspension_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_suspension_eliminar;
        $this->_mod_suspension_cantidad                 = isset($p_Datos ['mod_suspension_cantidad']) ? (integer) $p_Datos ['mod_suspension_cantidad'] : $this->_mod_suspension_cantidad;
        $this->_mod_feriado_crear                       = isset($p_Datos ['mod_feriado_crear']) ? filter_var( $p_Datos ['mod_feriado_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_feriado_crear;
        $this->_mod_feriado_editar                      = isset($p_Datos ['mod_feriado_editar']) ? filter_var( $p_Datos ['mod_feriado_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_feriado_editar;
        $this->_mod_feriado_eliminar                    = isset($p_Datos ['mod_feriado_eliminar']) ? filter_var( $p_Datos ['mod_feriado_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_feriado_eliminar;
        $this->_mod_feriado_cantidad                    = isset($p_Datos ['mod_feriado_cantidad']) ? (integer) $p_Datos ['mod_feriado_cantidad'] : $this->_mod_feriado_cantidad;
        $this->_mod_alerta_crear                        = isset($p_Datos ['mod_alerta_crear']) ? filter_var( $p_Datos ['mod_alerta_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_alerta_crear;
        $this->_mod_alerta_editar                       = isset($p_Datos ['mod_alerta_editar']) ? filter_var( $p_Datos ['mod_alerta_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_alerta_editar;
        $this->_mod_alerta_eliminar                     = isset($p_Datos ['mod_alerta_eliminar']) ? filter_var( $p_Datos ['mod_alerta_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_alerta_eliminar;
        $this->_mod_alerta_cantidad                     = isset($p_Datos ['mod_alerta_cantidad']) ? (integer) $p_Datos ['mod_alerta_cantidad'] : $this->_mod_alerta_cantidad;
        $this->_mod_reporte_automatico_crear            = isset($p_Datos ['mod_reporte_automatico_crear']) ? filter_var( $p_Datos ['mod_reporte_automatico_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_automatico_crear;
        $this->_mod_reporte_automatico_editar           = isset($p_Datos ['mod_reporte_automatico_editar']) ? filter_var( $p_Datos ['mod_reporte_automatico_editar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_automatico_editar;
        $this->_mod_reporte_automatico_eliminar         = isset($p_Datos ['mod_reporte_automatico_eliminar']) ? filter_var( $p_Datos ['mod_reporte_automatico_eliminar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_automatico_eliminar;
        $this->_mod_reporte_automatico_cantidad         = isset($p_Datos ['mod_reporte_automatico_cantidad']) ? (integer) $p_Datos ['mod_reporte_automatico_cantidad'] : $this->_mod_reporte_automatico_cantidad;
        $this->_mod_reporte_registros_crear             = isset($p_Datos ['mod_reporte_registros_crear']) ? filter_var( $p_Datos ['mod_reporte_registros_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_registros_crear;
        $this->_mod_reporte_registros_descargar         = isset($p_Datos ['mod_reporte_registros_descargar']) ? filter_var( $p_Datos ['mod_reporte_registros_descargar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_registros_descargar;
        $this->_mod_reporte_registros_cantidad          = isset($p_Datos ['mod_reporte_registros_cantidad']) ? (integer) $p_Datos ['mod_reporte_registros_cantidad'] : $this->_mod_reporte_registros_cantidad;
        $this->_mod_reporte_marcaciones_crear           = isset($p_Datos ['mod_reporte_marcaciones_crear']) ? filter_var( $p_Datos ['mod_reporte_marcaciones_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_marcaciones_crear;
        $this->_mod_reporte_marcaciones_descargar       = isset($p_Datos ['mod_reporte_marcaciones_descargar']) ? filter_var( $p_Datos ['mod_reporte_marcaciones_descargar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_marcaciones_descargar;
        $this->_mod_reporte_marcaciones_cantidad        = isset($p_Datos ['mod_reporte_marcaciones_cantidad']) ? (integer) $p_Datos ['mod_reporte_marcaciones_cantidad'] : $this->_mod_reporte_marcaciones_cantidad;
        $this->_mod_reporte_asistencias_crear           = isset($p_Datos ['mod_reporte_asistencias_crear']) ? filter_var( $p_Datos ['mod_reporte_asistencias_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_asistencias_crear;
        $this->_mod_reporte_asistencias_descargar       = isset($p_Datos ['mod_reporte_asistencias_descargar']) ? filter_var( $p_Datos ['mod_reporte_asistencias_descargar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_asistencias_descargar;
        $this->_mod_reporte_asistencias_cantidad        = isset($p_Datos ['mod_reporte_asistencias_cantidad']) ? (integer) $p_Datos ['mod_reporte_asistencias_cantidad'] : $this->_mod_reporte_asistencias_cantidad;
        $this->_mod_reporte_ausencias_crear             = isset($p_Datos ['mod_reporte_ausencias_crear']) ? filter_var( $p_Datos ['mod_reporte_ausencias_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_ausencias_crear;
        $this->_mod_reporte_ausencias_descargar         = isset($p_Datos ['mod_reporte_ausencias_descargar']) ? filter_var( $p_Datos ['mod_reporte_ausencias_descargar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_ausencias_descargar;
        $this->_mod_reporte_ausencias_cantidad          = isset($p_Datos ['mod_reporte_ausencias_cantidad']) ? (integer) $p_Datos ['mod_reporte_ausencias_cantidad'] : $this->_mod_reporte_ausencias_cantidad;
        $this->_mod_reporte_llegadas_tarde_crear        = isset($p_Datos ['mod_reporte_llegadas_tarde_crear']) ? filter_var( $p_Datos ['mod_reporte_llegadas_tarde_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_llegadas_tarde_crear;
        $this->_mod_reporte_llegadas_tarde_descargar    = isset($p_Datos ['mod_reporte_llegadas_tarde_descargar']) ? filter_var( $p_Datos ['mod_reporte_llegadas_tarde_descargar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_llegadas_tarde_descargar;
        $this->_mod_reporte_llegadas_tarde_cantidad     = isset($p_Datos ['mod_reporte_llegadas_tarde_cantidad']) ? (integer) $p_Datos ['mod_reporte_llegadas_tarde_cantidad'] : $this->_mod_reporte_llegadas_tarde_cantidad;
        $this->_mod_reporte_salidas_temprano_crear      = isset($p_Datos ['mod_reporte_salidas_temprano_crear']) ? filter_var( $p_Datos ['mod_reporte_salidas_temprano_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_salidas_temprano_crear;
        $this->_mod_reporte_salidas_temprano_descargar  = isset($p_Datos ['mod_reporte_salidas_temprano_descargar']) ? filter_var( $p_Datos ['mod_reporte_salidas_temprano_descargar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_salidas_temprano_descargar;
        $this->_mod_reporte_salidas_temprano_cantidad   = isset($p_Datos ['mod_reporte_salidas_temprano_cantidad']) ? (integer) $p_Datos ['mod_reporte_salidas_temprano_cantidad'] : $this->_mod_reporte_salidas_temprano_cantidad;
        $this->_mod_reporte_jornadas_crear              = isset($p_Datos ['mod_reporte_jornadas_crear']) ? filter_var( $p_Datos ['mod_reporte_jornadas_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_jornadas_crear;
        $this->_mod_reporte_jornadas_descargar          = isset($p_Datos ['mod_reporte_jornadas_descargar']) ? filter_var( $p_Datos ['mod_reporte_jornadas_descargar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_jornadas_descargar;
        $this->_mod_reporte_jornadas_cantidad           = isset($p_Datos ['mod_reporte_jornadas_cantidad']) ? (integer) $p_Datos ['mod_reporte_jornadas_cantidad'] : $this->_mod_reporte_jornadas_cantidad;
        $this->_mod_reporte_intervalos_crear            = isset($p_Datos ['mod_reporte_intervalos_crear']) ? filter_var( $p_Datos ['mod_reporte_intervalos_crear'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_intervalos_crear;
        $this->_mod_reporte_intervalos_descargar        = isset($p_Datos ['mod_reporte_intervalos_descargar']) ? filter_var( $p_Datos ['mod_reporte_intervalos_descargar'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_intervalos_descargar;
        $this->_mod_reporte_intervalos_cantidad         = isset($p_Datos ['mod_reporte_intervalos_cantidad']) ? (integer) $p_Datos ['mod_reporte_intervalos_cantidad'] : $this->_mod_reporte_intervalos_cantidad;


        $this->_mod_inicio_ver                          = isset($p_Datos ['mod_inicio_ver']) ? filter_var( $p_Datos ['mod_inicio_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_inicio_ver;
        $this->_mod_persona_ver                         = isset($p_Datos ['mod_persona_ver']) ? filter_var( $p_Datos ['mod_persona_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_ver;
        $this->_mod_persona_huellas_ver                 = isset($p_Datos ['mod_persona_huellas_ver']) ? filter_var( $p_Datos ['mod_persona_huellas_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_huellas_ver;
        $this->_mod_persona_rfid_ver                    = isset($p_Datos ['mod_persona_rfid_ver']) ? filter_var( $p_Datos ['mod_persona_rfid_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_persona_rfid_ver;
        $this->_mod_grupo_ver                           = isset($p_Datos ['mod_grupo_ver']) ? filter_var( $p_Datos ['mod_grupo_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_grupo_ver;
        $this->_mod_horario_trabajo_ver                 = isset($p_Datos ['mod_horario_trabajo_ver']) ? filter_var( $p_Datos ['mod_horario_trabajo_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_trabajo_ver;
        $this->_mod_horario_flexible_ver                = isset($p_Datos ['mod_horario_flexible_ver']) ? filter_var( $p_Datos ['mod_horario_flexible_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_flexible_ver;
        $this->_mod_horario_multiple_ver                = isset($p_Datos ['mod_horario_multiple_ver']) ? filter_var( $p_Datos ['mod_horario_multiple_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_multiple_ver;
        $this->_mod_horario_rotativo_ver                = isset($p_Datos ['mod_horario_rotativo_ver']) ? filter_var( $p_Datos ['mod_horario_rotativo_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_horario_rotativo_ver;
        $this->_mod_licencia_ver                        = isset($p_Datos ['mod_licencia_ver']) ? filter_var( $p_Datos ['mod_licencia_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_licencia_ver;
        $this->_mod_suspension_ver                      = isset($p_Datos ['mod_suspension_ver']) ? filter_var( $p_Datos ['mod_suspension_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_suspension_ver;
        $this->_mod_feriado_ver                         = isset($p_Datos ['mod_feriado_ver']) ? filter_var( $p_Datos ['mod_feriado_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_feriado_ver;
        $this->_mod_alerta_ver                          = isset($p_Datos ['mod_alerta_ver']) ? filter_var( $p_Datos ['mod_alerta_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_alerta_ver;
        $this->_mod_reporte_automatico_ver              = isset($p_Datos ['mod_reporte_automatico_ver']) ? filter_var( $p_Datos ['mod_reporte_automatico_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_automatico_ver;
        $this->_mod_reporte_registros_ver               = isset($p_Datos ['mod_reporte_registros_ver']) ? filter_var( $p_Datos ['mod_reporte_registros_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_registros_ver;
        $this->_mod_reporte_marcaciones_ver             = isset($p_Datos ['mod_reporte_marcaciones_ver']) ? filter_var( $p_Datos ['mod_reporte_marcaciones_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_marcaciones_ver;
        $this->_mod_reporte_asistencias_ver             = isset($p_Datos ['mod_reporte_asistencias_ver']) ? filter_var( $p_Datos ['mod_reporte_asistencias_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_asistencias_ver;
        $this->_mod_reporte_ausencias_ver               = isset($p_Datos ['mod_reporte_ausencias_ver']) ? filter_var( $p_Datos ['mod_reporte_ausencias_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_ausencias_ver;
        $this->_mod_reporte_llegadas_tarde_ver          = isset($p_Datos ['mod_reporte_llegadas_tarde_ver']) ? filter_var( $p_Datos ['mod_reporte_llegadas_tarde_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_llegadas_tarde_ver;
        $this->_mod_reporte_salidas_temprano_ver        = isset($p_Datos ['mod_reporte_salidas_temprano_ver']) ? filter_var( $p_Datos ['mod_reporte_salidas_temprano_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_salidas_temprano_ver;
        $this->_mod_reporte_jornadas_ver                = isset($p_Datos ['mod_reporte_jornadas_ver']) ? filter_var( $p_Datos ['mod_reporte_jornadas_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_jornadas_ver;
        $this->_mod_reporte_intervalos_ver              = isset($p_Datos ['mod_reporte_intervalos_ver']) ? filter_var( $p_Datos ['mod_reporte_intervalos_ver'] , FILTER_VALIDATE_BOOLEAN ) : $this->_mod_reporte_intervalos_ver;
    }

    public function getArray(){

        $datos  = array(
            'mod_id' => $this->_mod_id,
            'mod_detalle' => $this->_mod_detalle,

            'mod_configuraciones_editar' => $this->_mod_configuraciones_editar,
            'mod_configuraciones_cantidad' => $this->_mod_configuraciones_cantidad,
            'mod_inicio_editar' => $this->_mod_inicio_editar,
            'mod_inicio_cantidad' => $this->_mod_inicio_cantidad,
            'mod_persona_crear' => $this->_mod_persona_crear,
            'mod_persona_editar' => $this->_mod_persona_editar,
            'mod_persona_eliminar' => $this->_mod_persona_eliminar,
            'mod_persona_cantidad' => $this->_mod_persona_cantidad,
            'mod_persona_huellas_crear' => $this->_mod_persona_huellas_crear,
            'mod_persona_huellas_editar' => $this->_mod_persona_huellas_editar,
            'mod_persona_huellas_eliminar' => $this->_mod_persona_huellas_eliminar,
            'mod_persona_huellas_cantidad' => $this->_mod_persona_huellas_cantidad,
            'mod_persona_rfid_crear' => $this->_mod_persona_rfid_crear,
            'mod_persona_rfid_editar' => $this->_mod_persona_rfid_editar,
            'mod_persona_rfid_eliminar' => $this->_mod_persona_rfid_eliminar,
            'mod_persona_rfid_cantidad' => $this->_mod_persona_rfid_cantidad,
            'mod_grupo_crear' => $this->_mod_grupo_crear,
            'mod_grupo_editar' => $this->_mod_grupo_editar,
            'mod_grupo_eliminar' => $this->_mod_grupo_eliminar,
            'mod_grupo_cantidad' => $this->_mod_grupo_cantidad,
            'mod_horario_trabajo_crear' => $this->_mod_horario_trabajo_crear,
            'mod_horario_trabajo_editar' => $this->_mod_horario_trabajo_editar,
            'mod_horario_trabajo_eliminar' => $this->_mod_horario_trabajo_eliminar,
            'mod_horario_trabajo_cantidad' => $this->_mod_horario_trabajo_cantidad,
            'mod_horario_flexible_crear' => $this->_mod_horario_flexible_crear,
            'mod_horario_flexible_editar' => $this->_mod_horario_flexible_editar,
            'mod_horario_flexible_eliminar' => $this->_mod_horario_flexible_eliminar,
            'mod_horario_flexible_cantidad' => $this->_mod_horario_flexible_cantidad,
            'mod_horario_multiple_crear' => $this->_mod_horario_multiple_crear,
            'mod_horario_multiple_editar' => $this->_mod_horario_multiple_editar,
            'mod_horario_multiple_eliminar' => $this->_mod_horario_multiple_eliminar,
            'mod_horario_multiple_cantidad' => $this->_mod_horario_multiple_cantidad,
            'mod_horario_rotativo_crear' => $this->_mod_horario_rotativo_crear,
            'mod_horario_rotativo_editar' => $this->_mod_horario_rotativo_editar,
            'mod_horario_rotativo_eliminar' => $this->_mod_horario_rotativo_eliminar,
            'mod_horario_rotativo_cantidad' => $this->_mod_horario_rotativo_cantidad,
            'mod_licencia_crear' => $this->_mod_licencia_crear,
            'mod_licencia_editar' => $this->_mod_licencia_editar,
            'mod_licencia_eliminar' => $this->_mod_licencia_eliminar,
            'mod_licencia_cantidad' => $this->_mod_licencia_cantidad,
            'mod_suspension_crear' => $this->_mod_suspension_crear,
            'mod_suspension_editar' => $this->_mod_suspension_editar,
            'mod_suspension_eliminar' => $this->_mod_suspension_eliminar,
            'mod_suspension_cantidad' => $this->_mod_suspension_cantidad,
            'mod_feriado_crear' => $this->_mod_feriado_crear,
            'mod_feriado_editar' => $this->_mod_feriado_editar,
            'mod_feriado_eliminar' => $this->_mod_feriado_eliminar,
            'mod_feriado_cantidad' => $this->_mod_feriado_cantidad,
            'mod_alerta_crear' => $this->_mod_alerta_crear,
            'mod_alerta_editar' => $this->_mod_alerta_editar,
            'mod_alerta_eliminar' => $this->_mod_alerta_eliminar,
            'mod_alerta_cantidad' => $this->_mod_alerta_cantidad,
            'mod_reporte_automatico_crear' => $this->_mod_reporte_automatico_crear,
            'mod_reporte_automatico_editar' => $this->_mod_reporte_automatico_editar,
            'mod_reporte_automatico_eliminar' => $this->_mod_reporte_automatico_eliminar,
            'mod_reporte_automatico_cantidad' => $this->_mod_reporte_automatico_cantidad,
            'mod_reporte_registros_crear' => $this->_mod_reporte_registros_crear,
            'mod_reporte_registros_descargar' => $this->_mod_reporte_registros_descargar,
            'mod_reporte_registros_cantidad' => $this->_mod_reporte_registros_cantidad,
            'mod_reporte_marcaciones_crear' => $this->_mod_reporte_marcaciones_crear,
            'mod_reporte_marcaciones_descargar' => $this->_mod_reporte_marcaciones_descargar,
            'mod_reporte_marcaciones_cantidad' => $this->_mod_reporte_marcaciones_cantidad,
            'mod_reporte_asistencias_crear' => $this->_mod_reporte_asistencias_crear,
            'mod_reporte_asistencias_descargar' => $this->_mod_reporte_asistencias_descargar,
            'mod_reporte_asistencias_cantidad' => $this->_mod_reporte_asistencias_cantidad,
            'mod_reporte_ausencias_crear' => $this->_mod_reporte_ausencias_crear,
            'mod_reporte_ausencias_descargar' => $this->_mod_reporte_ausencias_descargar,
            'mod_reporte_ausencias_cantidad' => $this->_mod_reporte_ausencias_cantidad,
            'mod_reporte_llegadas_tarde_crear' => $this->_mod_reporte_llegadas_tarde_crear,
            'mod_reporte_llegadas_tarde_descargar' => $this->_mod_reporte_llegadas_tarde_descargar,
            'mod_reporte_llegadas_tarde_cantidad' => $this->_mod_reporte_llegadas_tarde_cantidad,
            'mod_reporte_salidas_temprano_crear' => $this->_mod_reporte_salidas_temprano_crear,
            'mod_reporte_salidas_temprano_descargar' => $this->_mod_reporte_salidas_temprano_descargar,
            'mod_reporte_salidas_temprano_cantidad' => $this->_mod_reporte_salidas_temprano_cantidad,
            'mod_reporte_jornadas_crear' => $this->_mod_reporte_jornadas_crear,
            'mod_reporte_jornadas_descargar' => $this->_mod_reporte_jornadas_descargar,
            'mod_reporte_jornadas_cantidad' => $this->_mod_reporte_jornadas_cantidad,
            'mod_reporte_intervalos_crear' => $this->_mod_reporte_intervalos_crear,
            'mod_reporte_intervalos_descargar' => $this->_mod_reporte_intervalos_descargar,
            'mod_reporte_intervalos_cantidad' => $this->_mod_reporte_intervalos_cantidad,

            'mod_configuraciones_ver' => $this->_mod_configuraciones_ver,
            'mod_inicio_ver' => $this->_mod_inicio_ver,
            'mod_persona_ver' => $this->_mod_persona_ver,
            'mod_persona_huellas_ver' => $this->_mod_persona_huellas_ver,
            'mod_persona_rfid_ver' => $this->_mod_persona_rfid_ver,
            'mod_grupo_ver' => $this->_mod_grupo_ver,
            'mod_horario_trabajo_ver' => $this->_mod_horario_trabajo_ver,
            'mod_horario_flexible_ver' => $this->_mod_horario_flexible_ver,
            'mod_horario_multiple_ver' => $this->_mod_horario_multiple_ver,
            'mod_horario_rotativo_ver' => $this->_mod_horario_rotativo_ver,
            'mod_licencia_ver' => $this->_mod_licencia_ver,
            'mod_suspension_ver' => $this->_mod_suspension_ver,
            'mod_feriado_ver' => $this->_mod_feriado_ver,
            'mod_alerta_ver' => $this->_mod_alerta_ver,
            'mod_reporte_automatico_ver' => $this->_mod_reporte_automatico_ver,
            'mod_reporte_registros_ver' => $this->_mod_reporte_registros_ver,
            'mod_reporte_marcaciones_ver' => $this->_mod_reporte_marcaciones_ver,
            'mod_reporte_asistencias_ver' => $this->_mod_reporte_asistencias_ver,
            'mod_reporte_ausencias_ver' => $this->_mod_reporte_ausencias_ver,
            'mod_reporte_llegadas_tarde_ver' => $this->_mod_reporte_llegadas_tarde_ver,
            'mod_reporte_salidas_temprano_ver' => $this->_mod_reporte_salidas_temprano_ver,
            'mod_reporte_jornadas_ver' => $this->_mod_reporte_jornadas_ver,
            'mod_reporte_intervalos_ver' => $this->_mod_reporte_intervalos_ver
        );

        return $datos;
    }
    public function save($p_Debug = true){
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConnMGR;

        $datos=array(

            'mod_id' => $this->_mod_id,
            'mod_detalle' => $this->_mod_detalle,

            'mod_configuraciones_editar' => $this->_mod_configuraciones_editar,
            'mod_configuraciones_cantidad' => $this->_mod_configuraciones_cantidad,
            'mod_inicio_editar' => $this->_mod_inicio_editar,
            'mod_inicio_cantidad' => $this->_mod_inicio_cantidad,
            'mod_persona_crear' => $this->_mod_persona_crear,
            'mod_persona_editar' => $this->_mod_persona_editar,
            'mod_persona_eliminar' => $this->_mod_persona_eliminar,
            'mod_persona_cantidad' => $this->_mod_persona_cantidad,
            'mod_persona_huellas_crear' => $this->_mod_persona_huellas_crear,
            'mod_persona_huellas_editar' => $this->_mod_persona_huellas_editar,
            'mod_persona_huellas_eliminar' => $this->_mod_persona_huellas_eliminar,
            'mod_persona_huellas_cantidad' => $this->_mod_persona_huellas_cantidad,
            'mod_persona_rfid_crear' => $this->_mod_persona_rfid_crear,
            'mod_persona_rfid_editar' => $this->_mod_persona_rfid_editar,
            'mod_persona_rfid_eliminar' => $this->_mod_persona_rfid_eliminar,
            'mod_persona_rfid_cantidad' => $this->_mod_persona_rfid_cantidad,
            'mod_grupo_crear' => $this->_mod_grupo_crear,
            'mod_grupo_editar' => $this->_mod_grupo_editar,
            'mod_grupo_eliminar' => $this->_mod_grupo_eliminar,
            'mod_grupo_cantidad' => $this->_mod_grupo_cantidad,
            'mod_horario_trabajo_crear' => $this->_mod_horario_trabajo_crear,
            'mod_horario_trabajo_editar' => $this->_mod_horario_trabajo_editar,
            'mod_horario_trabajo_eliminar' => $this->_mod_horario_trabajo_eliminar,
            'mod_horario_trabajo_cantidad' => $this->_mod_horario_trabajo_cantidad,
            'mod_horario_flexible_crear' => $this->_mod_horario_flexible_crear,
            'mod_horario_flexible_editar' => $this->_mod_horario_flexible_editar,
            'mod_horario_flexible_eliminar' => $this->_mod_horario_flexible_eliminar,
            'mod_horario_flexible_cantidad' => $this->_mod_horario_flexible_cantidad,
            'mod_horario_multiple_crear' => $this->_mod_horario_multiple_crear,
            'mod_horario_multiple_editar' => $this->_mod_horario_multiple_editar,
            'mod_horario_multiple_eliminar' => $this->_mod_horario_multiple_eliminar,
            'mod_horario_multiple_cantidad' => $this->_mod_horario_multiple_cantidad,
            'mod_horario_rotativo_crear' => $this->_mod_horario_rotativo_crear,
            'mod_horario_rotativo_editar' => $this->_mod_horario_rotativo_editar,
            'mod_horario_rotativo_eliminar' => $this->_mod_horario_rotativo_eliminar,
            'mod_horario_rotativo_cantidad' => $this->_mod_horario_rotativo_cantidad,
            'mod_licencia_crear' => $this->_mod_licencia_crear,
            'mod_licencia_editar' => $this->_mod_licencia_editar,
            'mod_licencia_eliminar' => $this->_mod_licencia_eliminar,
            'mod_licencia_cantidad' => $this->_mod_licencia_cantidad,
            'mod_suspension_crear' => $this->_mod_suspension_crear,
            'mod_suspension_editar' => $this->_mod_suspension_editar,
            'mod_suspension_eliminar' => $this->_mod_suspension_eliminar,
            'mod_suspension_cantidad' => $this->_mod_suspension_cantidad,
            'mod_feriado_crear' => $this->_mod_feriado_crear,
            'mod_feriado_editar' => $this->_mod_feriado_editar,
            'mod_feriado_eliminar' => $this->_mod_feriado_eliminar,
            'mod_feriado_cantidad' => $this->_mod_feriado_cantidad,
            'mod_alerta_crear' => $this->_mod_alerta_crear,
            'mod_alerta_editar' => $this->_mod_alerta_editar,
            'mod_alerta_eliminar' => $this->_mod_alerta_eliminar,
            'mod_alerta_cantidad' => $this->_mod_alerta_cantidad,
            'mod_reporte_automatico_crear' => $this->_mod_reporte_automatico_crear,
            'mod_reporte_automatico_editar' => $this->_mod_reporte_automatico_editar,
            'mod_reporte_automatico_eliminar' => $this->_mod_reporte_automatico_eliminar,
            'mod_reporte_automatico_cantidad' => $this->_mod_reporte_automatico_cantidad,
            'mod_reporte_registros_crear' => $this->_mod_reporte_registros_crear,
            'mod_reporte_registros_descargar' => $this->_mod_reporte_registros_descargar,
            'mod_reporte_registros_cantidad' => $this->_mod_reporte_registros_cantidad,
            'mod_reporte_marcaciones_crear' => $this->_mod_reporte_marcaciones_crear,
            'mod_reporte_marcaciones_descargar' => $this->_mod_reporte_marcaciones_descargar,
            'mod_reporte_marcaciones_cantidad' => $this->_mod_reporte_marcaciones_cantidad,
            'mod_reporte_asistencias_crear' => $this->_mod_reporte_asistencias_crear,
            'mod_reporte_asistencias_descargar' => $this->_mod_reporte_asistencias_descargar,
            'mod_reporte_asistencias_cantidad' => $this->_mod_reporte_asistencias_cantidad,
            'mod_reporte_ausencias_crear' => $this->_mod_reporte_ausencias_crear,
            'mod_reporte_ausencias_descargar' => $this->_mod_reporte_ausencias_descargar,
            'mod_reporte_ausencias_cantidad' => $this->_mod_reporte_ausencias_cantidad,
            'mod_reporte_llegadas_tarde_crear' => $this->_mod_reporte_llegadas_tarde_crear,
            'mod_reporte_llegadas_tarde_descargar' => $this->_mod_reporte_llegadas_tarde_descargar,
            'mod_reporte_llegadas_tarde_cantidad' => $this->_mod_reporte_llegadas_tarde_cantidad,
            'mod_reporte_salidas_temprano_crear' => $this->_mod_reporte_salidas_temprano_crear,
            'mod_reporte_salidas_temprano_descargar' => $this->_mod_reporte_salidas_temprano_descargar,
            'mod_reporte_salidas_temprano_cantidad' => $this->_mod_reporte_salidas_temprano_cantidad,
            'mod_reporte_jornadas_crear' => $this->_mod_reporte_jornadas_crear,
            'mod_reporte_jornadas_descargar' => $this->_mod_reporte_jornadas_descargar,
            'mod_reporte_jornadas_cantidad' => $this->_mod_reporte_jornadas_cantidad,
            'mod_reporte_intervalos_crear' => $this->_mod_reporte_intervalos_crear,
            'mod_reporte_intervalos_descargar' => $this->_mod_reporte_intervalos_descargar,
            'mod_reporte_intervalos_cantidad' => $this->_mod_reporte_intervalos_cantidad,

            'mod_configuraciones_ver' => $this->_mod_configuraciones_ver,
            'mod_inicio_ver' => $this->_mod_inicio_ver,
            'mod_persona_ver' => $this->_mod_persona_ver,
            'mod_persona_huellas_ver' => $this->_mod_persona_huellas_ver,
            'mod_persona_rfid_ver' => $this->_mod_persona_rfid_ver,
            'mod_grupo_ver' => $this->_mod_grupo_ver,
            'mod_horario_trabajo_ver' => $this->_mod_horario_trabajo_ver,
            'mod_horario_flexible_ver' => $this->_mod_horario_flexible_ver,
            'mod_horario_multiple_ver' => $this->_mod_horario_multiple_ver,
            'mod_horario_rotativo_ver' => $this->_mod_horario_rotativo_ver,
            'mod_licencia_ver' => $this->_mod_licencia_ver,
            'mod_suspension_ver' => $this->_mod_suspension_ver,
            'mod_feriado_ver' => $this->_mod_feriado_ver,
            'mod_alerta_ver' => $this->_mod_alerta_ver,
            'mod_reporte_automatico_ver' => $this->_mod_reporte_automatico_ver,
            'mod_reporte_registros_ver' => $this->_mod_reporte_registros_ver,
            'mod_reporte_marcaciones_ver' => $this->_mod_reporte_marcaciones_ver,
            'mod_reporte_asistencias_ver' => $this->_mod_reporte_asistencias_ver,
            'mod_reporte_ausencias_ver' => $this->_mod_reporte_ausencias_ver,
            'mod_reporte_llegadas_tarde_ver' => $this->_mod_reporte_llegadas_tarde_ver,
            'mod_reporte_salidas_temprano_ver' => $this->_mod_reporte_salidas_temprano_ver,
            'mod_reporte_jornadas_ver' => $this->_mod_reporte_jornadas_ver,
            'mod_reporte_intervalos_ver' => $this->_mod_reporte_intervalos_ver
        );

        if($this->_mod_id==0){
            printear('entro a mod_id=0');
            $resultado = $cnn->Insert('modulos_permisos',$datos);
            if($resultado !== false) {
                $this->_mod_id = $cnn->Devolver_Insert_Id();
            }
        }
        else {
            $resultado = $cnn->Update('modulos_permisos', $datos, "mod_id = {$this->_mod_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }


        return $resultado;

    }

    public function getErrores(){
        return $this->_errores;
    }

}
