<?php

require_once dirname(__FILE__) . '/../../_ruta.php';


use google\appengine\api\cloud_storage\CloudStorageTools;


$T_Titulo = _('Personas');
$Item_Name = "persona";
$T_Titulo_Singular = "persona";
$T_Titulo_Pre = "una";
$T_Script = 'persona';
$T_Mensaje = '';
$T_sync_checker = '';
$T_sync_js_start = '';

if (isset($_REQUEST['equipo'])) $_SESSION["EQUIPO"] = $_REQUEST['equipo'];


$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Id = isset($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;
$T_Tipo_Check = (isset($_REQUEST['tipo_check'])) ? $_REQUEST['tipo_check'] : '';
$T_Data = (isset($_REQUEST['data'])) ? $_REQUEST['data'] : '';
$T_Cmd = (isset($_REQUEST['cmd'])) ? $_REQUEST['cmd'] : '';
$T_Dedo = (isset($_REQUEST['dedo'])) ? $_REQUEST['dedo'] : '';
$T_Huella = (isset($_REQUEST['huella'])) ? $_REQUEST['huella'] : '';
$T_Tag = (isset($_REQUEST['tag'])) ? $_REQUEST['tag'] : '';

$T_Excluir = (isset($_REQUEST['excluido'])) ? $_REQUEST['excluido'] : '';

$T_Filtro = (isset($_POST['filtro'])) ? $_POST['filtro'] : 0;
$T_Filtro_Horario_Tipo = (isset($_POST['f_horario_tipo'])) ? $_POST['f_horario_tipo'] : 0;
$T_Filtro_Horario_Id = (isset($_POST['f_horario_id'])) ? $_POST['f_horario_id'] : 0;
$T_Filtro_Grupo_Id = (isset($_POST['f_grupo_id'])) ? $_POST['f_grupo_id'] : 0;


$T_IMGBorrar = (isset($_POST['inputBorrarImagen'])) ? $_POST['inputBorrarImagen'] : '';
$T_IMGExtension = (isset($_POST['inputImageExtension'])) ? $_POST['inputImageExtension'] : '';
$T_IMG = (isset($_POST['inputIMGsrc'])) ? $_POST['inputIMGsrc'] : '';
$T_IMGx = (isset($_POST['inputIMGx'])) ? $_POST['inputIMGx'] : '';
$T_IMGy = (isset($_POST['inputIMGy'])) ? $_POST['inputIMGy'] : '';
$T_IMGw = (isset($_POST['inputIMGw'])) ? $_POST['inputIMGw'] : '';
$T_IMGh = (isset($_POST['inputIMGh'])) ? $_POST['inputIMGh'] : '';

$T_HorarioTipo = (isset($_POST['horario_tipo']) ? $_POST['horario_tipo'] : 0);
$T_HorarioNormId = (isset($_POST['horarioNormId']) ? $_POST['horarioNormId'] : 0);
$T_HorarioFlexId = (isset($_POST['horarioFlexId']) ? $_POST['horarioFlexId'] : 0);
$T_HorarioMultId = (isset($_POST['horarioMultId']) ? $_POST['horarioMultId'] : 0);


switch ($T_Tipo) {
    case 'check':
        $o_Persona = Persona_L::obtenerPorId($T_Id);
        if (is_null($o_Persona)) {
            $o_Persona = new Persona_O();
        }

        switch ($T_Tipo_Check) {
            case 'c_tag':
                if ($o_Persona->getTag() != $_POST['tag'])
                    $o_Persona->setTag(isset($_POST['tag']) ? $_POST['tag'] : '');
                $T_Error = $o_Persona->getErrores();
                if (!is_null($T_Error) && array_key_exists('tag', $T_Error)) echo $T_Error['tag']; else echo "true";
                break;
            case 'c_dni':
                $o_Persona->setDni(isset($_POST['dni']) ? $_POST['dni'] : '');
                $T_Error = $o_Persona->getErrores();
                if (!is_null($T_Error) && array_key_exists('dni', $T_Error)) echo $T_Error['dni']; else echo "true";
                break;
            case 'c_legajo':
                $o_Persona->setLegajo(isset($_POST['legajo']) ? $_POST['legajo'] : '');
                $T_Error = $o_Persona->getErrores();
                if (!is_null($T_Error) && array_key_exists('legajo', $T_Error)) echo $T_Error['legajo']; else echo "true";
                break;
        }
        die();
        break;
    case 'add':

        $o_Persona = new Persona_O();

        $o_Persona->setHorTipo($T_HorarioTipo);
        
        switch ($T_HorarioTipo) {
            case HORARIO_NORMAL:
                $o_Persona->setHorId($T_HorarioNormId);
                break;
            case HORARIO_FLEXIBLE:
                $o_Persona->setHorId($T_HorarioFlexId);
                break;
            case HORARIO_ROTATIVO:
                $o_Persona->setHorId($T_HorarioRotId);
                break;
            case HORARIO_MULTIPLE:
                $o_Persona->setHorId($T_HorarioMultId);
                break;
        }


        $o_Persona->setNombre(isset($_POST['nombre']) ? $_POST['nombre'] : '');
        $o_Persona->setApellido(isset($_POST['apellido']) ? $_POST['apellido'] : '');
        $o_Persona->setDni(isset($_POST['dni']) ? $_POST['dni'] : '');
        $o_Persona->setTag(isset($_POST['tag']) ? $_POST['tag'] : '');
        //$o_Persona->setRolId(isset($_POST['grupo']) ? $_POST['grupo'] : 0);
        $o_Persona->setLegajo(isset($_POST['legajo']) ? $_POST['legajo'] : '');
        $o_Persona->setTeCelurar(isset($_POST['telefono']) ? $_POST['telefono'] : '');
        $o_Persona->setTeFijo(isset($_POST['te_personal']) ? $_POST['te_personal'] : '');
        $o_Persona->setEmail(isset($_POST['email']) ? $_POST['email'] : '');
        $o_Persona->setCreadoUsuarioId(Registry::getInstance()->Usuario->getId());

        if ($T_Excluir == "on")
            $o_Persona->setExcluir(1);
        else
            $o_Persona->setExcluir(0);


        $string_equipos = '';
        //echo '<pre>';echo print_r($_POST['equipo']);echo '</pre>';
        if (!empty($_POST['equipo'])) {

            foreach ($_POST['equipo'] as $key => $check_equipo) {

                $string_equipos .= $check_equipo . ":";
            }
        }
        //echo $string_equipos;
        $string_equipos = rtrim($string_equipos, ':');
        $o_Persona->setEquipos($string_equipos);


        if ($T_IMG != '') {//viene una imagen nueva

            $src = GS_CLIENT_TEMP_FOLDER . $T_IMG;

            if ($T_IMGExtension == 'image/png')
                $img_r = imagecreatefrompng($src);
            else if ($T_IMGExtension == 'image/gif')
                $img_r = imagecreatefromgif($src);
            else if ($T_IMGExtension == 'image/jpg')
                $img_r = imagecreatefromjpeg($src);
            else if ($T_IMGExtension == 'image/jpeg')
                $img_r = imagecreatefromjpeg($src);
            else
                $o_Persona->setErrores('imagen', 'formato no soportado');

            $dst_w = 250;
            $dst_h = 250;
            $dst_r = ImageCreateTrueColor($dst_w, $dst_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $T_IMGx, $T_IMGy, $dst_w, $dst_h, $T_IMGw, $T_IMGh);

            $filename = md5(time() . uniqid()) . ".jpg";
            $path = GS_CLIENT_IMAGES_PERSONAS . $o_Persona->getId() . "/";

            if (!file_exists($path))
                mkdir($path, 0777, true);

            imagejpeg($dst_r, $path . $filename, 100);

            $o_Persona->setImagen($path . $filename);
            $o_Persona->setImagenURL('');
        }


        //check de cantidad de personas segun el plan
        if(Persona_L::obtenerCantidad()>=$o_Plan->getCantPersonas()) {
            $T_Error = 'Líimite máximo de personas alcanzado. (Plan ' . $o_Plan->getNombre() . ', ' . $o_Plan->getCantPersonas() . ')';
        }else{
            if (!$o_Persona->save()) {
                $T_Error = $o_Persona->getErrores();
            } else {
                //SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[0], _('Tabla') . ' - ' . $T_Script . ' Id - ' . $o_Persona->getId());
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_PERSONA_CREAR, $a_Logs_Tipos[LOG_PERSONA_CREAR], '<b>Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto(), $o_Persona->getId());
                $se_sincroniza=0;
                $a_o_Equipo = Equipo_L::obtenerTodos();
                $array_equipos = explode(':', $o_Persona->getEquipos());
                if ($a_o_Equipo != null) {
                    foreach ($a_o_Equipo as $o_Equipo) {
                        /* @var $o_Equipo Equipo_O */
                        if ($o_Equipo->isOffline()) continue;
                        if (!in_array($o_Equipo->getId(), $array_equipos)) continue;
                        $se_sincroniza=1;
                    }
                }

                if($se_sincroniza){
                    $T_Mensaje = 'La persona fue guardada con éxito. Sincronizando datos...';
                    $T_sync_checker = "syncChecker(" . $o_Persona->getId() . ",\"" . $o_Persona->getApellido() . ', ' . $o_Persona->getNombre() . "\",".count(explode(':',$o_Persona->getEquipos())).");";
                    $T_sync_js_start = "disableRow(\"" . $o_Persona->getApellido() . ', ' . $o_Persona->getNombre() . "\");";
                }else{
                    $T_Mensaje = 'La persona fue guardada con éxito.';
                }

                //si la persona ya fue guardada, es decir que tengo el ID, entonces ahora le cargo los grupos
                if (!empty($_POST['grupo'])) {
                    foreach ($_POST['grupo'] as $key => $check_grupo) {
                        $grupo_persona = new Grupos_Personas_O;
                        $grupo_persona->setGrupo($check_grupo);
                        $grupo_persona->setPersona($o_Persona->getId());
                        $grupo_persona->save('Off');
                    }
                }
                // Sync
                SyncHelper::SyncPersona($o_Persona);
                // Fin Sync
            }
        }




        goto defaultLabel;
        break;
    case 'edit':
        SeguridadHelper::Pasar(50);

        $o_Persona = Persona_L::obtenerPorId($T_Id, true);

        $o_Persona->setHorTipo($T_HorarioTipo);
        switch ($T_HorarioTipo) {
            case HORARIO_NORMAL:
                $o_Persona->setHorId($T_HorarioNormId);
                break;
            case HORARIO_FLEXIBLE:
                $o_Persona->setHorId($T_HorarioFlexId);
                break;
            case HORARIO_ROTATIVO:
                $o_Persona->setHorId($T_HorarioRotId);
                break;
            case HORARIO_MULTIPLE:
                $o_Persona->setHorId($T_HorarioMultId);
                break;
        }

        $o_Persona->setNombre(isset($_POST['nombre']) ? $_POST['nombre'] : '');
        $o_Persona->setApellido(isset($_POST['apellido']) ? $_POST['apellido'] : '');
        $o_Persona->setDni(isset($_POST['dni']) ? $_POST['dni'] : '');
        $o_Persona->setTag(isset($_POST['tag']) ? $_POST['tag'] : '');
        //$o_Persona->setRolId(isset($_POST['grupo']) ? $_POST['grupo'] : 0);
        $o_Persona->setLegajo(isset($_POST['legajo']) ? $_POST['legajo'] : '');
        $o_Persona->setTeCelurar(isset($_POST['telefono']) ? $_POST['telefono'] : '');
        $o_Persona->setTeFijo(isset($_POST['te_personal']) ? $_POST['te_personal'] : '');
        $o_Persona->setEmail(isset($_POST['email']) ? $_POST['email'] : '');
        $o_Persona->setCreadoUsuarioId(Registry::getInstance()->Usuario->getId());


        if ($T_Excluir == "on")
            $o_Persona->setExcluir(1);
        else
            $o_Persona->setExcluir(0);

        $string_equipos = '';
        //echo '<pre>';echo print_r($_POST['equipo']);echo '</pre>';
        if (!empty($_POST['equipo'])) {

            foreach ($_POST['equipo'] as $key => $check_equipo) {

                $string_equipos .= $check_equipo . ":";
            }
        }
        //echo $string_equipos;
        $string_equipos = rtrim($string_equipos, ':');
        $o_Persona->setEquipos($string_equipos);

        //echo '<pre>';echo print_r($_POST['grupo']);echo '</pre>';
        if (!empty($_POST['grupo'])) {
            //primero borro todos los registros
            $a_o_Grupos_Personas = Grupos_Personas_L::obtenerPorPersona($o_Persona->getId());
            if (!is_null($a_o_Grupos_Personas)) {
                //echo '<pre>';echo print_r($a_o_Grupos_Personas);echo '</pre>';
                foreach ($a_o_Grupos_Personas as $g_persona) {
                    $g_persona->delete('Off');
                }
            }
            foreach ($_POST['grupo'] as $key => $check_grupo) {
                $grupo_persona = new Grupos_Personas_O;
                $grupo_persona->setGrupo($check_grupo);
                $grupo_persona->setPersona($o_Persona->getId());
                $grupo_persona->save('Off');
                //echo '<pre>';echo print_r($grupo_persona);echo '</pre>';
            }
        }

        if ($T_IMGBorrar != '') {
            $o_Persona->setImagen('');
        }

        if ($T_IMG != '') {//viene una imagen nueva


            $src = GS_CLIENT_TEMP_FOLDER . $T_IMG;

            if ($T_IMGExtension == 'image/png')
                $img_r = imagecreatefrompng($src);
            else if ($T_IMGExtension == 'image/gif')
                $img_r = imagecreatefromgif($src);
            else if ($T_IMGExtension == 'image/jpg')
                $img_r = imagecreatefromjpeg($src);
            else if ($T_IMGExtension == 'image/jpeg')
                $img_r = imagecreatefromjpeg($src);
            else
                $o_Persona->setErrores('imagen', 'formato no soportado');

            $dst_w = 250;
            $dst_h = 250;
            $dst_r = ImageCreateTrueColor($dst_w, $dst_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $T_IMGx, $T_IMGy, $dst_w, $dst_h, $T_IMGw, $T_IMGh);

            $filename = md5(time() . uniqid()) . ".jpg";
            $path = GS_CLIENT_IMAGES_PERSONAS . $o_Persona->getId() . "/";

            if (!file_exists($path))
                mkdir($path, 0777, true);

            imagejpeg($dst_r, $path . $filename, 100);

            $o_Persona->setImagen($path . $filename);
            $o_Persona->setImagenURL('');

        }


        if (!$o_Persona->save()) {
            $T_Error = $o_Persona->getErrores();
        } else {
            //SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[0], _('Tabla') . ' - ' . $T_Script . ' Id - ' . $o_Persona->getId(),LOG_PERSONAS_EDITAR,$o_Persona->getId());
            SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_PERSONA_EDITAR, $a_Logs_Tipos[LOG_PERSONA_EDITAR], '<b>Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto(), $o_Persona->getId());
            $se_sincroniza=0;
            $a_o_Equipo = Equipo_L::obtenerTodos();
            $array_equipos = explode(':', $o_Persona->getEquipos());
            if ($a_o_Equipo != null) {
                foreach ($a_o_Equipo as $o_Equipo) {
                    /* @var $o_Equipo Equipo_O */
                    if ($o_Equipo->isOffline()) continue;
                    if (!in_array($o_Equipo->getId(), $array_equipos)) continue;
                    $se_sincroniza=1;
                }
            }

            if($se_sincroniza){
                $T_Mensaje = 'La persona fue guardada con éxito. Sincronizando datos...';
                $T_sync_checker = "syncChecker(" . $o_Persona->getId() . ",\"" . $o_Persona->getApellido() . ', ' . $o_Persona->getNombre() . "\",".count(explode(':',$o_Persona->getEquipos())).");";
                $T_sync_js_start = "disableRow(\"" . $o_Persona->getApellido() . ', ' . $o_Persona->getNombre() . "\");";
            }else{
                $T_Mensaje = 'La persona fue guardada con éxito.';
            }

            // Sync
            SyncHelper::SyncPersona($o_Persona);
            // Fin Sync
        }


        goto defaultLabel;

        break;
    case 'enable':
        SeguridadHelper::Pasar(50);

        $o_Persona = Persona_L::obtenerPorId($T_Id, true);

        if (is_null($o_Persona)) {
            $T_Error = _('Lo sentimos, la persona que desea habilitar no existe.');
            goto defaultLabel;
            break;
        }

        $o_Persona->setEnabled(1);


        if (!$o_Persona->desbloquear()) {
            //$T_Error = 'Lo sentimos, la persona que desea habilitar no puede ser modificado.';
            $T_Error = $o_Persona->getErrores();
        } else {
            SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_PERSONA_DESBLOQUEAR, $a_Logs_Tipos[LOG_PERSONA_DESBLOQUEAR], '<b>Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto(), $o_Persona->getId());
            $T_Mensaje = _('La persona fue habilitada con éxito.');
            SyncHelper::SyncPersona($o_Persona);

        }


        goto defaultLabel;
        break;
    case 'disable':
        SeguridadHelper::Pasar(50);

        $o_Persona = Persona_L::obtenerPorId($T_Id);

        if (is_null($o_Persona)) {
            $T_Error = _('Lo sentimos, la persona que desea bloquear no existe.');
            goto defaultLabel;
            break;
        }
        $o_Persona->setBloqueadoUsuarioId(Registry::getInstance()->Usuario->getId());
        if (!$o_Persona->bloquear()) {
            $T_Error = $o_Persona->getErrores();
        } else {

            SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_PERSONA_BLOQUEAR, $a_Logs_Tipos[LOG_PERSONA_BLOQUEAR], '<b>Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto(), $o_Persona->getId());
            $T_Mensaje = _('La persona fue bloqueada con éxito.');
            SyncHelper::SyncPersona($o_Persona);
        }

        goto defaultLabel;
        break;
    case 'delete':
        SeguridadHelper::Pasar(50);

        $o_Persona = Persona_L::obtenerPorId($T_Id, true);

        if (is_null($o_Persona)) {
            $T_Error = _('Lo sentimos, la persona que desea eliminar no existe.');
        }

        if (!is_null($o_Persona)) {
            $o_Persona->setEliminadoUsuarioId(Registry::getInstance()->Usuario->getId());
            //elimino las huellas de la persona
            $a_huellas = Huella_L::obtenerPorPersona($o_Persona->getId());
            if(!is_null($a_huellas)) {
                foreach ($a_huellas as $o_huella) {
                    /* @var $o_huella Huella_O */
                    $o_huella->delete();
                }
            }

            Grupos_Personas_L::eliminarPersonaDeTodosLosGrupos($o_Persona->getId());

            if (!$o_Persona->delete()) {
                $T_Error = $o_Persona->getErrores();
            } else {
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_PERSONA_ELIMINAR, $a_Logs_Tipos[LOG_PERSONA_ELIMINAR], '<b>Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto(), $o_Persona->getId());
                $T_Mensaje = _('La persona fue eliminada con éxito.');
            }
        }

        $T_Eliminado = true;
        $T_Link = '_mos';
        goto defaultLabel;
        break;
    case 'view':
        SeguridadHelper::Pasar(20);
        $o_Persona = Persona_L::obtenerPorId($T_Id, true);

        if (is_null($o_Persona))
            $o_Persona = new Persona_O();


        break;
    case 'view-tag':
    case 'view-fp':
        SeguridadHelper::Pasar(50);
        $o_Persona = Persona_L::obtenerPorId($T_Id, true);

        if (is_null($o_Persona))
            $o_Persona = new Persona_O();


        break;
    case 'accion':

        if ($T_Cmd == "enrollstart") {
            if ($T_Data != "") {
                $o_Equipo = Equipo_L::obtenerPorId($T_Data);

                $o_huella = new Huella_O();
                $o_huella->setPerId($T_Id);
                $o_huella->setDedo($T_Dedo);
                $o_huella->setEnabled(1);
                $o_huella->save('off');

                $o_Persona = Persona_L::obtenerPorId($T_Id, true);

                PubSubHelper::sendMessage(CMD_ENROLL_START,json_encode(array('hue_id'=>$o_huella->getId(),'per_id'=>$T_Id,'hue_dedo'=>$T_Dedo,'fecha_start'=>time())),$o_Equipo->getUUID(),array('sess_id' => session_id()));
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HUELLA_ENROLL_START, $a_Logs_Tipos[LOG_HUELLA_ENROLL_START], '<b>Persona Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto() . ' <b>Huella ID:</b>' . $o_huella->getId() . ' <b>Dedo:</b>' . $o_huella->getDedo(), $o_Persona->getId());

                echo $o_huella->getId();
                die();
            }
        }else if ($T_Cmd == "enrollcancel") {
            if ($T_Data != "") {
                $o_Equipo = Equipo_L::obtenerPorUUID($T_Data);

                if(!is_null($o_Equipo)){
                    $o_huella = Huella_L::obtenerPorId($T_Huella);
                    if(!is_null($o_huella)){
                        PubSubHelper::sendMessage(CMD_ENROLL_CANCEL,json_encode(array('id'=>$o_huella->getId(),'fecha_start'=>time())),$o_Equipo->getUUID(),array('sess_id' => session_id()));
                        $o_Persona = Persona_L::obtenerPorId($o_huella->getPerId(), true);
                        SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HUELLA_ENROLL_CANCEL, $a_Logs_Tipos[LOG_HUELLA_ENROLL_CANCEL], '<b>Persona Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto() . ' <b>Huella ID:</b>' . $o_huella->getId() . ' <b>Dedo:</b>' . $o_huella->getDedo(), $o_Persona->getId());
                        $o_huella->purge();
                        die('OK');
                    }else {
                        die('La huella no existe');
                    }

                }else{
                    die('El equipo no existe');
                }

                die('kernel panic');
            }
        } else if ($T_Cmd == "deletefp") {

            $o_huella = Huella_L::obtenerPorPersonayDedo($T_Id, $T_Dedo);
            $o_Persona = Persona_L::obtenerPorId($T_Id, true);

            if (!empty($o_huella)) {
                $o_huella->delete();
                SyncHelper::SyncHuella($o_huella);
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_HUELLA_DELETE, $a_Logs_Tipos[LOG_HUELLA_DELETE], '<b>Persona Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto() . ' <b>Huella ID:</b>' . $o_huella->getId() . ' <b>Dedo:</b>' . $o_huella->getDedo(), $o_Persona->getId());
            }
            die();
        } else if ($T_Cmd == "tagenrollstart") {

            if ($T_Data != "") {
                $o_Equipo = Equipo_L::obtenerPorId($T_Data);


                $o_Persona = Persona_L::obtenerPorId($T_Id, true);

                PubSubHelper::sendMessage(CMD_RFID_READ_START,json_encode(array('per_id'=>$T_Id,'fecha_start'=>time())),$o_Equipo->getUUID(),array('sess_id' => session_id()));
                SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_RFID_READ_START, $a_Logs_Tipos[LOG_RFID_READ_START], '<b>Persona Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto(), $o_Persona->getId());

                echo $o_Persona->getId();

                die();
            }
        }else if ($T_Cmd == "tagenrollcancel") {
            if ($T_Data != "") {
                $o_Equipo = Equipo_L::obtenerPorUUID($T_Data);

                if(!is_null($o_Equipo)){

                    PubSubHelper::sendMessage(CMD_RFID_READ_CANCEL,json_encode(array('fecha_start'=>time())),$o_Equipo->getUUID(),array('sess_id' => session_id()));
                    //SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_RFID_READ_CANCEL, $a_Logs_Tipos[LOG_RFID_READ_CANCEL], '<b>Persona Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto() . ' <b>Huella ID:</b>' . $o_huella->getId() . ' <b>Dedo:</b>' . $o_huella->getDedo(), $o_Persona->getId());
                    SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_RFID_READ_CANCEL, $a_Logs_Tipos[LOG_RFID_READ_CANCEL], '');
                    die('OK');


                }else{
                    die('El equipo no existe');
                }

                die('kernel panic');
            }
        } else if ($T_Cmd == "deletetag") {

            $o_Persona = Persona_L::obtenerPorId($T_Id, true);
            $tagviejo = $o_Persona->getTag();
            $o_Persona->removeTag();
            $o_Persona->save();

            SeguridadHelper::Log(Registry::getInstance()->Usuario->getId(), LOG_RFID_DELETE, $a_Logs_Tipos[LOG_RFID_DELETE], '<b>Persona Id:</b> ' . $o_Persona->getId() . ' <b>Nombre:</b> ' . $o_Persona->getNombreCompleto() . ' <b>TAG eliminado:</b>' . $tagviejo, $o_Persona->getId());

            SyncHelper::SyncPersona($o_Persona);



            die();
        } else if ($T_Cmd == "tagsave") {


            $o_persona = null;
            $o_persona = Persona_L::obtenerPorId($T_Id,true);

            $o_persona_tag = Persona_L::obtenerPorTag($T_Tag);

            if(!is_null($o_persona_tag)){
                SeguridadHelper::Log(0, LOG_RFID_READ_ERROR, $a_Logs_Tipos[LOG_RFID_READ_ERROR], 'La tarjeta ya existe. <b>Persona Id:</b> ' . $o_persona_tag->getId() . ' <b>Nombre:</b> ' . $o_persona_tag->getNombreCompleto() . ' <b>TAG:</b>' . $o_persona_tag->getTag(), $o_persona_tag->getId());
                die("La tarjeta ya existe");
            }else{
                if (!is_null($o_persona)) {

                    $tagViejo = $o_persona->getTag();

                    $o_persona->setTag($T_Tag);
                    if($o_persona->save()==false){
                        die("El formato es incorrecto. Deben ser 10 caracteres hexadecimales.");
                    }

                    if($tagViejo!='') //cambio de tag
                        SeguridadHelper::Log(0, LOG_RFID_READ_OK, $a_Logs_Tipos[LOG_RFID_READ_OK], '<b>Persona Id:</b> ' . $o_persona->getId() . ' <b>Nombre:</b> ' . $o_persona->getNombreCompleto() . ' <b>TAG Anterior:</b>' . $tagViejo . ' <b>TAG Actual:</b>' . $o_persona->getTag(), $o_persona->getId());
                    else   //tag nuevo
                        SeguridadHelper::Log(0, LOG_RFID_READ_OK, $a_Logs_Tipos[LOG_RFID_READ_OK], '<b>Persona Id:</b> ' . $o_persona->getId() . ' <b>Nombre:</b> ' . $o_persona->getNombreCompleto() . ' <b>TAG:</b>' . $o_persona->getTag(), $o_persona->getId());

                    SyncHelper::SyncPersona($o_persona);

                    die('OK');

                }
            }




            die();
        }


        break;


    case 'view-filtro':
        SeguridadHelper::Pasar(20);

        if ($T_Filtro != 0) {
            if ($T_Filtro_Horario_Tipo) {
                switch ($T_Filtro_Horario_Tipo) {
                    case HORARIO_NORMAL:
                        $o_Listado = Persona_L::obtenerTodos(0, 0, 0, 'per_Hor_Tipo=' . HORARIO_NORMAL . ' AND per_Hor_Id=' . $T_Filtro_Horario_Id, false);
                        break;
                    case HORARIO_FLEXIBLE:
                        $o_Listado = Persona_L::obtenerTodos(0, 0, 0, 'per_Hor_Tipo=' . HORARIO_FLEXIBLE . ' AND per_Hor_Id=' . $T_Filtro_Horario_Id, false);
                        break;
                    case HORARIO_ROTATIVO:
                        $o_Listado = Persona_L::obtenerTodos(0, 0, 0, 'per_Hor_Tipo=' . HORARIO_ROTATIVO . ' AND per_Hor_Id=' . $T_Filtro_Horario_Id, false);
                        break;
                }
            } else if ($T_Filtro_Grupo_Id != 0) {
                $o_Listado = Grupos_Personas_L::obtenerPersonasPorGrupo($T_Filtro_Grupo_Id);
            }

        }

        break;


    case 'L_Blo':
    case 'L_Hor':
    default:
        defaultLabel:

        $T_ErrorPersonasMax='';
        if(Persona_L::obtenerCantidad()>=$o_Plan->getCantPersonas()) {
            $T_ErrorPersonasMax = 'Líimite máximo de personas alcanzado. (Plan ' . $o_Plan->getNombre() . ', ' . $o_Plan->getCantPersonas() . ')';
        }

        $o_Listado = Persona_L::obtenerTodos(0, 0, 0, 'per_Eliminada<>1', true);

        break;

}

