<?php

if ($o_Plan->getId() < PLAN_PLUS)die('nop'); //plan free no pasa;

SeguridadHelper::Pasar(20);

$T_Titulo = _('Feriado');
$Item_Name = "feriado";
$T_Script = 'feriado';
$T_Mensaje = '';
$T_Titulo_Singular = _('Feriado');
$T_Titulo_Pre = _('el');

$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;
$T_FechaD = (isset($_REQUEST['LfechaD'])) ? $_REQUEST['LfechaD'] : '';
$T_FechaH = (isset($_REQUEST['LfechaH'])) ? $_REQUEST['LfechaH'] : '';
$T_FechaDiaCompleto = (isset($_REQUEST['diaCompleto'])) ? $_REQUEST['diaCompleto'] : '';
$T_Persona = (isset($_REQUEST['persona'])) ? (integer)$_REQUEST['persona'] : 0;
$T_Grupo = (isset($_REQUEST['grupo'])) ? (integer)$_REQUEST['grupo'] : 0;
$T_Descripcion = (isset($_REQUEST['descripcion'])) ? $_REQUEST['descripcion'] : '';
$T_Enabled = (isset($_REQUEST['enabled'])) ? $_REQUEST['enabled'] : '';
$T_Intervalo = isset($_REQUEST['intervaloFecha']) ? (string)$_REQUEST['intervaloFecha'] : '';

$T_Pasados = isset($_REQUEST['pasados']) ? (string)$_REQUEST['pasados'] : '';



switch ($T_Tipo) {
    case 'add':
    case 'edit':
        SeguridadHelper::Pasar(50);
        $o_Feriado = Feriado_L::obtenerPorId($T_Id);
        if (is_null($o_Feriado)) {
            $o_Feriado = new Feriado_O();
        }


        $o_Feriado->setDescripcion($T_Descripcion);

        if ($_REQUEST['persona'] == 'TodasLasPersonas') {
            $o_Feriado->setPerId(0);
            $o_Feriado->setGrupoId(0);
        }else if($_REQUEST['persona'] == 'SelectRol'){
            $o_Feriado->setPerId(0);
            $o_Feriado->setGrupoId($T_Grupo);
        }else if($T_Persona >= 0 && $T_Grupo >= 0){
            $o_Feriado->setPerId($T_Persona);
            $o_Feriado->setGrupoId(0);
        }else{
            $o_Feriado->setPerId($T_Persona);
            $o_Feriado->setGrupoId($T_Grupo);
        }

        if ($T_Intervalo == 1) {  //dia completo
            $fechaf = DateTime::createFromFormat('Y-m-d H:i:s', $T_FechaDiaCompleto);
            $o_Feriado->setFechaInicio($fechaf->format('Y-m-d H:i:s'), 'Y-m-d H:i:s');
            $fechaf->modify('+1 day');
            $o_Feriado->setFechaFin($fechaf->format('Y-m-d H:i:s'), 'Y-m-d H:i:s');

        } else if ($T_Intervalo == 2) {  //intervalo personalizado

            $o_Feriado->setFechaInicio($T_FechaD, 'Y-m-d H:i:s');
            $o_Feriado->setFechaFin($T_FechaH, 'Y-m-d H:i:s');
        }

        $o_Feriado->setTipo($T_Intervalo);


        if ($T_Enabled == "on")
            $o_Feriado->setEnabled(1);
        else
            $o_Feriado->setEnabled(0);


        if (!$o_Feriado->save(Registry::getInstance()->general['debug'])) {
            $T_Error = $o_Feriado->getErrores();
        } else {
            SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[1], 'Tabla - ' . $T_Script . ' Id - ' . $o_Feriado->getId());
            $T_Mensaje = _('El feriado fue modificado con éxito.');
        }


        $T_Modificar = true;
        goto defaultLabel;
        break;

    case 'delete' :

        SeguridadHelper::Pasar(50);

        $o_Feriado = Feriado_L::obtenerPorId($T_Id);

        if (is_null($o_Feriado)) {
            $T_Error = _('Lo sentimos, el feriado que desea eliminar no existe.');
        } else {

            if (!$o_Feriado->delete(Registry::getInstance()->general['debug'])) {
                $T_Error = $o_Feriado->getErrores();
            } else {
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_FERIADO_ELIMINAR, $a_Logs_Tipos[LOG_FERIADO_ELIMINAR], '<b>Id:</b> ' . $o_Feriado->getId() . ' <b>Descripción:</b> ' . $o_Feriado->getDescripcion(), $o_Feriado->getId());
                $T_Mensaje = _('El feriado fue eliminado con éxito.');
            }

        }

        goto defaultLabel;
        break;
    case 'view':
        SeguridadHelper::Pasar(20);
        $o_Feriado = Feriado_L::obtenerPorId($T_Id);


        if (is_null($o_Feriado)) {
            $o_Feriado = new Feriado_O();
            $o_Feriado->setEnabled(1);

        } else {


        }
        break;
    default:
        defaultLabel:
        SeguridadHelper::Pasar(20);
        if($T_Pasados!=''){
            $_SESSION['filtro']['pasados']=$T_Pasados;
            $o_Listado = Feriado_L::obtenerTodosSinPasados();
        }else{
            $_SESSION['filtro']['pasados']="off";
            $o_Listado = Feriado_L::obtenerTodos();
        }

        $T_Link = '';
}

