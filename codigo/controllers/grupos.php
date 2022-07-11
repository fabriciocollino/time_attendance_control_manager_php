<?php


SeguridadHelper::Pasar(20);

$T_Titulo = _('Grupos');
$T_Script = 'grupos';
$T_Titulo_Singular = _('Grupo');
$T_Titulo_Pre = _('el');
$Item_Name = 'grupos';
$T_Link = '';
$T_Error = '';
$T_Mensaje = '';
$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;
$T_EnVivo = (isset($_REQUEST['envivo'])) ? $_REQUEST['envivo'] : '';

switch ($T_Tipo) {
    case 'add':
    case 'edit':
        SeguridadHelper::Pasar(50);
        $o_Grupo = Grupo_L::obtenerPorId($T_Id);
        if (is_null($o_Grupo)) {
            $o_Grupo = new Grupo_O();
        }


        $o_Grupo->setDetalle((isset($_REQUEST['detalle'])) ? $_REQUEST['detalle'] : '');

        if ($T_EnVivo == "on")
            $o_Grupo->setEnVivo(1);
        else
            $o_Grupo->setEnVivo(0);


        $grupo_nuevo = 0;
        if ($o_Grupo->getId() == 0) $grupo_nuevo = 1;//esta variable me permite saber si fue un insert o un edit

        if (!$o_Grupo->save(Registry::getInstance()->general['debug'])) {
            $T_Error = $o_Grupo->getErrores();
        } else {
            if ($grupo_nuevo)
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_GRUPO_CREAR, $a_Logs_Tipos[LOG_GRUPO_CREAR], '<b>Id:</b> ' . $o_Grupo->getId() . ' <b>Grupo:</b> ' . $o_Grupo->getDetalle(), $o_Grupo->getId());
            else
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_GRUPO_EDITAR, $a_Logs_Tipos[LOG_GRUPO_EDITAR], '<b>Id:</b> ' . $o_Grupo->getId() . ' <b>Grupo:</b> ' . $o_Grupo->getDetalle(), $o_Grupo->getId());

            $T_Mensaje = _('El grupo fue modificado con éxito.');
        }


        $T_Modificar = true;
        goto defaultLabel;
        break;
    case 'personas':
        $o_Grupo = Grupo_L::obtenerPorId($T_Id);

        $a_Personas = HtmlHelper::array2htmloptions(Persona_L::obtenerTodos(), null, false, true, 'Persona');

        $a_PersonasGrupo = HtmlHelper::array2htmloptions(Grupos_Personas_L::obtenerListaPorGrupo($T_Id), null, false, true, 'Not_Persona');

        $T_Add = true;
        break;
    case 'insert':
        SeguridadHelper::Pasar(50);
        $o_Grupo = Grupo_L::obtenerPorId($T_Id);

        $o_GPersona = new Grupos_Personas_O();

        $o_personaCheck = Grupos_Personas_L::obtenerPorPerIDyGrupo(isset($_REQUEST['persona']) ? (integer)$_REQUEST['persona'] : 0, $T_Id);
        if ($o_personaCheck != null) die("error_persona_ya_existe");

        $o_GPersona->setPersona(isset($_REQUEST['persona']) ? (integer)$_REQUEST['persona'] : 0);
        $o_GPersona->setGrupo($T_Id);

        $o_GPersona->save('Off');

        //$a_PersonasGrupo = HtmlHelper::array2htmloptions(Grupos_Personas_L::obtenerListaPorGrupo($T_Id),null,false,true,'Not_Persona');
        //echo $a_PersonasGrupo;

        //$T_Add = true;
        //$T_Link = '_add';
        die();
        break;
    case 'remove':
        SeguridadHelper::Pasar(50);

        if (isset($_REQUEST['GpersonaID'])) {
            $o_GPersona = Grupos_Personas_L::obtenerPorPerIdyGrupo(isset($_REQUEST['GpersonaID']) ? (integer)$_REQUEST['GpersonaID'] : 0, $T_Id);
            $o_GPersona->delete('Off');
        }
        //$a_PersonasGrupo = HtmlHelper::array2htmloptions(Grupos_Personas_L::obtenerListaPorGrupo($T_Id),null,false,true,'Not_Persona');
        //echo $a_PersonasGrupo;

        //$T_Add = true;
        die();
        break;
    case 'delete' :
        SeguridadHelper::Pasar(50);
        $o_Grupo = Grupo_L::obtenerPorId($T_Id);

        if (is_null($o_Grupo)) {
            $T_Error = _('Lo sentimos, el grupo que desea eliminar no existe.');
        } else {
            $a_personas = Persona_L::obtenerPorGrupo($T_Id);
            if ($a_personas == null) {
                if (!$o_Grupo->delete(Registry::getInstance()->general['debug'])) {
                    $T_Error = $o_Grupo->getErrores();
                } else {
                    SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_GRUPO_ELIMINAR, $a_Logs_Tipos[LOG_GRUPO_ELIMINAR], '<b>Id:</b> ' . $o_Grupo->getId() . ' <b>Grupo:</b> ' . $o_Grupo->getDetalle(), $o_Grupo->getId());
                    $T_Mensaje = _('El grupo fue eliminado con éxito.');
                }
            } else {
                $T_Eliminado = false;
                $T_Error = _('El grupo no se puede eliminar, porque está asignado a una o más personas.');
                goto defaultLabel;
            }
        }

        goto defaultLabel;
        break;
    case 'view':
        SeguridadHelper::Pasar(20);
        $o_Grupo = Grupo_L::obtenerPorId($T_Id);

        if (is_null($o_Grupo)) {
            $o_Grupo = new Grupo_O();
        } else {

        }
        break;
    default:
        defaultLabel:
        $o_Listado = Grupo_L::obtenerTodos();
        $T_Link = '';
}

