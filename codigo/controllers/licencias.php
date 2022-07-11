<?php

if ($o_Plan->getId() < PLAN_PLUS)die('nop'); //plan free no pasa;


SeguridadHelper::Pasar(20);

$T_Titulo = _('Licencias');
$Item_Name = "licencia";
$T_Script = 'licencia';
$T_Mensaje = '';
$T_Titulo_Singular = _('Licencia');
$T_Titulo_Pre = _('la');

$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;
$T_FechaD = (isset($_REQUEST['LfechaD'])) ? $_REQUEST['LfechaD'] : '';
$T_FechaH = (isset($_REQUEST['LfechaH'])) ? $_REQUEST['LfechaH'] : '';
$T_Persona = (isset($_REQUEST['persona'])) ? (integer)$_REQUEST['persona'] : 0;
$T_Grupo = (isset($_REQUEST['grupo'])) ? (integer)$_REQUEST['grupo'] : 0;
$T_Motivo = (isset($_REQUEST['motivo'])) ? $_REQUEST['motivo'] : '';
$T_Enabled = (isset($_REQUEST['enabled'])) ? $_REQUEST['enabled'] : '';
$T_Intervalo = isset($_REQUEST['intervaloFecha']) ? (string)$_REQUEST['intervaloFecha'] : '';
$T_selTipo = isset($_REQUEST['selTipo']) ? (string)$_REQUEST['selTipo'] : '';
$T_IntervaloLlegadaTarde = isset($_REQUEST['intervaloLlegadaTarde']) ? (string)$_REQUEST['intervaloLlegadaTarde'] : '';
$T_IntervaloSalidaTemprano = isset($_REQUEST['intervaloSalidaTemprano']) ? (string)$_REQUEST['intervaloSalidaTemprano'] : '';
$T_DuracionLlegadaTarde = isset($_REQUEST['duracionLlegadaTarde']) ? (integer)$_REQUEST['duracionLlegadaTarde'] : 0;
$T_DuracionSalidaTemprano = isset($_REQUEST['duracionSalidaTemprano']) ? (integer)$_REQUEST['duracionSalidaTemprano'] : 0;
$T_IntervaloDuracionLlegadaTarde = isset($_REQUEST['intervaloDuracionLlegadaTarde']) ? (string)$_REQUEST['intervaloDuracionLlegadaTarde'] : '';
$T_IntervaloDuracionSalidaTemprano = isset($_REQUEST['intervaloDuracionSalidaTemprano']) ? (string)$_REQUEST['intervaloDuracionSalidaTemprano'] : '';
$T_FechaLlegadaTarde = isset($_REQUEST['fechaLlegadaTarde']) ? (string)$_REQUEST['fechaLlegadaTarde'] : '';
$T_FechaSalidaTemprano = isset($_REQUEST['fechaSalidaTemprano']) ? (string)$_REQUEST['fechaSalidaTemprano'] : '';
$T_DiaCompleto = isset($_REQUEST['diaCompleto']) ? (string)$_REQUEST['diaCompleto'] : '';

$T_Pasados = isset($_REQUEST['pasados']) ? (string)$_REQUEST['pasados'] : '';

//echo '<pre>';print_r($_REQUEST);echo '</pre>';


switch ($T_Tipo) {
    case 'add':
    case 'edit':
        SeguridadHelper::Pasar(50);
        $o_Licencia = Licencias_L::obtenerPorId($T_Id);
        if (is_null($o_Licencia)) {
            $o_Licencia = new Licencias_O();
        }


        $o_Licencia->setMotivo($T_Motivo);

        if ($_REQUEST['persona'] == 'TodasLasPersonas') {
            $o_Licencia->setPerId(0);
            $o_Licencia->setGrupoId(0);
        } else if ($_REQUEST['persona'] == 'SelectRol') {
            $o_Licencia->setPerId(0);
            $o_Licencia->setGrupoId($T_Grupo);
        } else if ($T_Persona >= 0 && $T_Grupo >= 0) {
            $o_Licencia->setPerId($T_Persona);
            $o_Licencia->setGrupoId(0);
        } else {
            $o_Licencia->setPerId($T_Persona);
            $o_Licencia->setGrupoId($T_Grupo);
        }

        $o_Licencia->setTipo($T_selTipo);

        switch ($T_selTipo) {
            case LICENCIA_LLEGADA_TARDE:
                switch ($T_IntervaloLlegadaTarde) {
                    case 'F_15':
                        $o_Licencia->setDuracion('15,m');
                        break;
                    case 'F_30':
                        $o_Licencia->setDuracion('30,m');
                        break;
                    case 'F_1':
                        $o_Licencia->setDuracion('1,h');
                        break;
                    case 'F_2':
                        $o_Licencia->setDuracion('2,h');
                        break;
                    case 'F_Personalizado':
                        $horaminuto = '';
                        if ($T_IntervaloDuracionLlegadaTarde == 'F_Minutos')
                            $horaminuto = 'm';
                        else if ($T_IntervaloDuracionLlegadaTarde == 'F_Horas')
                            $horaminuto = 'h';
                        $o_Licencia->setDuracion($T_DuracionLlegadaTarde . ',' . $horaminuto);
                        break;
                }
                $o_Licencia->setFechaInicio($T_FechaLlegadaTarde, 'Y-m-d H:i:s');
                $o_Licencia->setFechaFin($T_FechaLlegadaTarde, 'Y-m-d H:i:s');
                break;
            case LICENCIA_SALIDA_TEMPRANO:
                switch ($T_IntervaloSalidaTemprano) {
                    case 'F_15':
                        $o_Licencia->setDuracion('15,m');
                        break;
                    case 'F_30':
                        $o_Licencia->setDuracion('30,m');
                        break;
                    case 'F_1':
                        $o_Licencia->setDuracion('1,h');
                        break;
                    case 'F_2':
                        $o_Licencia->setDuracion('2,h');
                        break;
                    case 'F_Personalizado':
                        $horaminuto = '';
                        if ($T_IntervaloDuracionSalidaTemprano == 'F_Minutos')
                            $horaminuto = 'm';
                        else if ($T_IntervaloDuracionSalidaTemprano == 'F_Horas')
                            $horaminuto = 'h';
                        $o_Licencia->setDuracion($T_DuracionSalidaTemprano . ',' . $horaminuto);
                        break;
                }
                $o_Licencia->setFechaInicio($T_FechaSalidaTemprano, 'Y-m-d H:i:s');
                $o_Licencia->setFechaFin($T_FechaSalidaTemprano, 'Y-m-d H:i:s');
                break;
            case LICENCIA_DIA_COMPLETO:
                $o_Licencia->setFechaInicio($T_DiaCompleto, 'Y-m-d H:i:s');
                $o_Licencia->setFechaFin($T_DiaCompleto, 'Y-m-d H:i:s');
                break;
            case LICENCIA_PERSONALIZADA:
                //MANEJO DE LOS INTERVALOS DE FECHAS
                if (isset($T_Intervalo) && $T_Intervalo != '') {
                    switch ($T_Intervalo) {
                        case 'F_Hoy'://diario
                            $T_FechaD = date('Y-m-d H:i:s', strtotime('today 00:00'));
                            $T_FechaH = date('Y-m-d H:i:s', strtotime('tomorrow 00:00'));
                            break;
                        case 'F_Manana'://mañana
                            $T_FechaD = date('Y-m-d H:i:s', strtotime('tomorrow 00:00'));
                            $T_FechaH = date('Y-m-d H:i:s', strtotime('+2 day 00:00'));
                            break;
                        case 'F_Personalizado':
                            //$_SESSION['filtro']['fechaD'] = (!isset($_POST['fechaD'])) ? (isset($_SESSION['filtro']['fechaD'])) ? $_SESSION['filtro']['fechaD'] : date('Y-m-d H:i:s', strtotime('-1 day'))  : $_POST['fechaD'];
                            //$_SESSION['filtro']['fechaH'] = (!isset($_POST['fechaH'])) ? (isset($_SESSION['filtro']['fechaH'])) ? $_SESSION['filtro']['fechaH'] : date('Y-m-d H:i:s')  : $_POST['fechaH'];
                            break;
                    }
                } else {//selecciono el dropdown si la fecha ya viene
                    if ($T_FechaD == date('Y-m-d H:i:s', strtotime('today 00:00')) && $T_FechaH == date('Y-m-d H:i:s', strtotime('tomorrow 00:00')))
                        $T_Intervalo = 'F_Hoy';
                    elseif ($T_FechaD == date('Y-m-d H:i:s', strtotime('today 00:00')) && $T_FechaH == date('Y-m-d H:i:s', strtotime('tomorrow 23:59')))
                        $T_Intervalo = 'F_Manana';
                    else    $T_Intervalo = 'F_Personalizado';
                }


                $o_Licencia->setFechaInicio($T_FechaD, 'Y-m-d H:i:s');
                $o_Licencia->setFechaFin($T_FechaH, 'Y-m-d H:i:s');
                break;
        }


        if ($T_Enabled == "on")
            $o_Licencia->setEnabled(1);
        else
            $o_Licencia->setEnabled(0);

        $nueva_licencia = 0;
        if ($o_Licencia->getId() == 0) $nueva_licencia = 1;//esta variable me permite saber si fue un insert o un edit

        if (!$o_Licencia->save(Registry::getInstance()->general['debug'])) {
            $T_Error = $o_Licencia->getErrores();
        } else {
            $personagrupo = '';
            if ($o_Licencia->getPersonaOGrupo() == 'persona') {
                $personagrupo = Persona_L::obtenerPorId($o_Licencia->getPerId(), true)->getNombreCompleto();
            } else if ($o_Licencia->getPersonaOGrupo() == 'grupo') {
                $personagrupo = 'Grupo: ' . Grupo_L::obtenerPorId($o_Licencia->getGrupoId())->getDetalle();
            }

            if ($nueva_licencia) {
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_LICENCIA_CREAR, $a_Logs_Tipos[LOG_LICENCIA_CREAR], '<b>Id:</b> ' . $o_Licencia->getId() . ' <b>Motivo:</b> ' . $o_Licencia->getMotivo() . ' <b>Personas:</b> ' . $personagrupo, $o_Licencia->getId());
                $T_Mensaje = _('La Licencia fue agregada con éxito.');
            }
            else {
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_LICENCIA_EDITAR, $a_Logs_Tipos[LOG_LICENCIA_EDITAR], '<b>Id:</b> ' . $o_Licencia->getId() . ' <b>Motivo:</b> ' . $o_Licencia->getMotivo() . ' <b>Personas:</b> ' . $personagrupo, $o_Licencia->getId());
                $T_Mensaje = _('La Licencia fue modificada con éxito.');
            }

        }


        $T_Modificar = true;
        goto defaultLabel;
        break;

    case 'delete' :
        SeguridadHelper::Pasar(50);
        $o_Licencia = Licencias_L::obtenerPorId($T_Id);

        if (is_null($o_Licencia)) {
            $T_Error = _('Lo sentimos, la licencia que desea eliminar no existe.');
        } else {
            $personagrupo = '';
            if ($o_Licencia->getPersonaOGrupo() == 'persona') {
                $personagrupo = Persona_L::obtenerPorId($o_Licencia->getPerId(), false, false)->getNombreCompleto();
            } else if ($o_Licencia->getPersonaOGrupo() == 'grupo') {
                $personagrupo = 'Grupo: ' . Grupo_L::obtenerPorId($o_Licencia->getGrupoId())->getDetalle();
            }
            if (!$o_Licencia->delete(Registry::getInstance()->general['debug'])) {
                $T_Error = $o_Licencia->getErrores();
            } else {
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_LICENCIA_ELIMINAR, $a_Logs_Tipos[LOG_LICENCIA_ELIMINAR], '<b>Id:</b> ' . $o_Licencia->getId() . ' <b>Motivo:</b> ' . $o_Licencia->getMotivo() . ' <b>Personas:</b> ' . $personagrupo, $o_Licencia->getId());
                $T_Mensaje = _('La Licencia fue eliminada con éxito.');
            }

        }

        goto defaultLabel;
        break;
    case 'view':
        SeguridadHelper::Pasar(20);
        $o_Licencia = Licencias_L::obtenerPorId($T_Id);


        if (is_null($o_Licencia)) {
            $o_Licencia = new Licencias_O();
            $o_Licencia->setEnabled(1);
        } else {


        }
        break;
    default:
        defaultLabel:
        SeguridadHelper::Pasar(20);
        if($T_Pasados!=''){
            $_SESSION['filtro']['pasados']=$T_Pasados;
            $o_Listado = Licencias_L::obtenerTodosSinPasadas();
        }else{
            $_SESSION['filtro']['pasados']="off";
            $o_Listado = Licencias_L::obtenerTodos();
        }
        $T_Link = '';
}

