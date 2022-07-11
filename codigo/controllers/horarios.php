<?php


SeguridadHelper::Pasar(20);

$T_Titulo = _('Horario de Trabajo');
$T_Titulo_Singular = _('Horario');
$T_Titulo_Pre = _('el');
$T_Script = 'hora_trabajo';
$Item_Name = "horario";
$T_Link = '';
$T_Mensaje = '';
$a_dias = array(1 => _('Domingo'), _('Lunes'), _('Martes'), _('Miércoles'), _('Jueves'), _('Viernes'), _('Sábado'));
$a_abr_dias = array(1 => "Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");

$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;

//$T_Rotativo = (isset($_REQUEST['rotativo'])) ? $_REQUEST['rotativo'] : '';

switch ($T_Tipo) {
    case 'add':
        SeguridadHelper::Pasar(50);
        $o_Hora_Trabajo = new Hora_Trabajo_O();


        $o_Hora_Trabajo->setDetalle(isset($_POST['nombre']) ? $_POST['nombre'] : '');


        $o_Hora_Trabajo->setHsInicioDom((isset($_POST['hs_inicio_dom']) ? $_POST['hs_inicio_dom'] : '00:00:00'), 'H:i');
        $o_Hora_Trabajo->setHsFinDom((isset($_POST['hs_fin_dom']) ? $_POST['hs_fin_dom'] : '00:00:00'), 'H:i');

        $o_Hora_Trabajo->setHsInicioLun((isset($_POST['hs_inicio_lun']) ? $_POST['hs_inicio_lun'] : '00:00:00'), 'H:i');
        $o_Hora_Trabajo->setHsFinLun((isset($_POST['hs_fin_lun']) ? $_POST['hs_fin_lun'] : '00:00:00'), 'H:i');

        $o_Hora_Trabajo->setHsInicioMar((isset($_POST['hs_inicio_mar']) ? $_POST['hs_inicio_mar'] : '00:00:00'), 'H:i');
        $o_Hora_Trabajo->setHsFinMar((isset($_POST['hs_fin_mar']) ? $_POST['hs_fin_mar'] : '00:00:00'), 'H:i');

        $o_Hora_Trabajo->setHsInicioMie((isset($_POST['hs_inicio_mie']) ? $_POST['hs_inicio_mie'] : '00:00:00'), 'H:i');
        $o_Hora_Trabajo->setHsFinMie((isset($_POST['hs_fin_mie']) ? $_POST['hs_fin_mie'] : '00:00:00'), 'H:i');

        $o_Hora_Trabajo->setHsInicioJue((isset($_POST['hs_inicio_jue']) ? $_POST['hs_inicio_jue'] : '00:00:00'), 'H:i');
        $o_Hora_Trabajo->setHsFinJue((isset($_POST['hs_fin_jue']) ? $_POST['hs_fin_jue'] : '00:00:00'), 'H:i');

        $o_Hora_Trabajo->setHsInicioVie((isset($_POST['hs_inicio_vie']) ? $_POST['hs_inicio_vie'] : '00:00:00'), 'H:i');
        $o_Hora_Trabajo->setHsFinVie((isset($_POST['hs_fin_vie']) ? $_POST['hs_fin_vie'] : '00:00:00'), 'H:i');

        $o_Hora_Trabajo->setHsInicioSab((isset($_POST['hs_inicio_sab']) ? $_POST['hs_inicio_sab'] : '00:00:00'), 'H:i');
        $o_Hora_Trabajo->setHsFinSab((isset($_POST['hs_fin_sab']) ? $_POST['hs_fin_sab'] : '00:00:00'), 'H:i');

        if (!$o_Hora_Trabajo->save(Registry::getInstance()->general['debug'])) {
            $T_Error = $o_Hora_Trabajo->getErrores();
        } else {
            SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_NORMAL_CREAR, $a_Logs_Tipos[LOG_HORARIO_NORMAL_CREAR], '<b>Id:</b> ' . $o_Hora_Trabajo->getId() . ' <b>Horario:</b> ' . $o_Hora_Trabajo->getDetalle() , $o_Hora_Trabajo->getId());
            $T_Mensaje = _('Horario de trabajo guardado con éxito.');
            $o_Hora_Trabajo = new Hora_Trabajo_O();
        }

        goto defaultLabel;
        break;

    case 'edit':
        SeguridadHelper::Pasar(50);

        $o_Hora_Trabajo = Hora_Trabajo_L::obtenerPorId($T_Id);

        if (is_null($o_Hora_Trabajo)) {
            $T_Error = _('Lo sentimos, el horario no existe.');
        } else {

            $o_Hora_Trabajo->setDetalle(isset($_POST['nombre']) ? $_POST['nombre'] : '');

            $o_Hora_Trabajo->setHsInicioDom((isset($_POST['hs_inicio_dom']) ? $_POST['hs_inicio_dom'] : '00:00:00'), 'H:i');
            $o_Hora_Trabajo->setHsFinDom((isset($_POST['hs_fin_dom']) ? $_POST['hs_fin_dom'] : '00:00:00'), 'H:i');

            $o_Hora_Trabajo->setHsInicioLun((isset($_POST['hs_inicio_lun']) ? $_POST['hs_inicio_lun'] : '00:00:00'), 'H:i');
            $o_Hora_Trabajo->setHsFinLun((isset($_POST['hs_fin_lun']) ? $_POST['hs_fin_lun'] : '00:00:00'), 'H:i');

            $o_Hora_Trabajo->setHsInicioMar((isset($_POST['hs_inicio_mar']) ? $_POST['hs_inicio_mar'] : '00:00:00'), 'H:i');
            $o_Hora_Trabajo->setHsFinMar((isset($_POST['hs_fin_mar']) ? $_POST['hs_fin_mar'] : '00:00:00'), 'H:i');

            $o_Hora_Trabajo->setHsInicioMie((isset($_POST['hs_inicio_mie']) ? $_POST['hs_inicio_mie'] : '00:00:00'), 'H:i');
            $o_Hora_Trabajo->setHsFinMie((isset($_POST['hs_fin_mie']) ? $_POST['hs_fin_mie'] : '00:00:00'), 'H:i');

            $o_Hora_Trabajo->setHsInicioJue((isset($_POST['hs_inicio_jue']) ? $_POST['hs_inicio_jue'] : '00:00:00'), 'H:i');
            $o_Hora_Trabajo->setHsFinJue((isset($_POST['hs_fin_jue']) ? $_POST['hs_fin_jue'] : '00:00:00'), 'H:i');

            $o_Hora_Trabajo->setHsInicioVie((isset($_POST['hs_inicio_vie']) ? $_POST['hs_inicio_vie'] : '00:00:00'), 'H:i');
            $o_Hora_Trabajo->setHsFinVie((isset($_POST['hs_fin_vie']) ? $_POST['hs_fin_vie'] : '00:00:00'), 'H:i');

            $o_Hora_Trabajo->setHsInicioSab((isset($_POST['hs_inicio_sab']) ? $_POST['hs_inicio_sab'] : '00:00:00'), 'H:i');
            $o_Hora_Trabajo->setHsFinSab((isset($_POST['hs_fin_sab']) ? $_POST['hs_fin_sab'] : '00:00:00'), 'H:i');

            if (!$o_Hora_Trabajo->save(Registry::getInstance()->general['debug'])) {
                $T_Error = $o_Hora_Trabajo->getErrores();
            } else {
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_NORMAL_EDITAR, $a_Logs_Tipos[LOG_HORARIO_NORMAL_EDITAR], '<b>Id:</b> ' . $o_Hora_Trabajo->getId() . ' <b>Horario:</b> ' . $o_Hora_Trabajo->getDetalle() , $o_Hora_Trabajo->getId());
                $T_Mensaje = _('Horario de Trabajo modificado con éxito.');
            }
        }

        goto defaultLabel;
        break;

    case 'delete':
        SeguridadHelper::Pasar(50);
        $o_Hora_Trabajo = Hora_Trabajo_L::obtenerPorId($T_Id);

        if (is_null($o_Hora_Trabajo)) {
            $T_Error = _('Lo sentimos, el horario de trabajo que desea eliminar no existe.');
        } else {
            $cantidad_personas = Persona_L::obtenerPorHorariodeTrabajoCOUNT($T_Id, HORARIO_NORMAL);
            if ($cantidad_personas == 0) {
                if (!$o_Hora_Trabajo->delete(Registry::getInstance()->general['debug'])) {
                    $T_Error = $o_Hora_Trabajo->getErrores();
                } else {
                    SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HORARIO_NORMAL_ELIMINAR, $a_Logs_Tipos[LOG_HORARIO_NORMAL_ELIMINAR], '<b>Id:</b> ' . $o_Hora_Trabajo->getId() . ' <b>Horario:</b> ' . $o_Hora_Trabajo->getDetalle() , $o_Hora_Trabajo->getId());
                    $T_Mensaje = _('El horario de trabajo fue eliminado con éxito.');
                }
            } else {
                $T_Eliminado = false;
                $T_Error = _('El horario no se puede eliminar, porque está asignado a una o más personas.');
                goto defaultLabel;
            }


        }

        goto defaultLabel;
        break;

    case 'view':
        $o_Hora_Trabajo = Hora_Trabajo_L::obtenerPorId($T_Id, true);

        if (is_null($o_Hora_Trabajo))
            $o_Hora_Trabajo = new Hora_Trabajo_O();

        $o_Listado_Hora_Trabajo = Hora_Trabajo_L::obtenerTodos();

        break;


    default:
        defaultLabel:
        SeguridadHelper::Pasar(20);

        $o_Listado = Hora_Trabajo_L::obtenerTodos();

}
