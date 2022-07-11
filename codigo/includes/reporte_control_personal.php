<?php

/*
 *
 *
 * bueno estoy re-escribiendo esto desde 0.
 *
 * #1 primero, traigo todos los logs de la tabla, basado en los filtros seteados.
 * #2 despues, armo el array de salida, con los datos un poquito mas procesados
 * despues, estoy viendo q hago
 *
 *
 * la variable $o_listado, tiene la data del punto #1
 * la variable $a_orden, ya tiene los datos del punto #2
 *
 *
 */


function date_compare($a, $b) {
    $t1 = strtotime($a['Fecha']);
    $t2 = strtotime($b['Fecha']);
    return $t1 - $t2;
}


if($T_Tipo=='Feriados'){
    if(isset($_REQUEST["selFeriado"]) && $_REQUEST["selFeriado"]!="") {
        $_SESSION['filtro']['feriado'] = (integer)$_REQUEST["selFeriado"];
    }

    $o_Feriado = Feriado_L::obtenerPorId($_SESSION['filtro']['feriado']);
    if(isset($o_Feriado) && $o_Feriado!=null) {
        $_SESSION['filtro']['fechaD'] = $o_Feriado->getFechaInicio();
        $date = DateTime::createFromFormat('Y-m-d h:i:s', $o_Feriado->getFechaInicio());
        $date->modify('+1 day');
        $_SESSION['filtro']['fechaH'] = $date->format('Y-m-d 00:00:00');
    }else{
        $_SESSION['filtro']['fechaH'] = $_SESSION['filtro']['fechaD']; //para que no devuelva resultados;
    }
}

if (isset($UsarFechasWidget) && $UsarFechasWidget == true) {
    if (strlen($_SESSION['filtro']['fechaDw']) < 12) $_SESSION['filtro']['fechaDw'] .= " 00:00:00";
    if (strlen($_SESSION['filtro']['fechaHw']) < 12) $_SESSION['filtro']['fechaHw'] .= " 00:00:00";
} else {
    if (strlen($_SESSION['filtro']['fechaD']) < 12) $_SESSION['filtro']['fechaD'] .= " 00:00:00";
    if (strlen($_SESSION['filtro']['fechaH']) < 12) $_SESSION['filtro']['fechaH'] .= " 00:00:00";
}

/*
echo "<pre>";
echo "FechaD: ".$_SESSION['filtro']['fechaD'];
echo "<br>";
echo "FechaH: ".$_SESSION['filtro']['fechaH'];
echo "</pre>";
*/

/********************************************************************************************************************************************************************************************
 * *******************************************************************************************************************************************************************************************
 *  #1 se obtienen los logs de la tabla, a partir de los filtros de fecha y personas seteados.
 * *******************************************************************************************************************************************************************************************
 * *******************************************************************************************************************************************************************************************/

if (DateTimeHelper::getTimestampFromFormat($_SESSION['filtro']['fechaD'], 'Y-m-d H:i:s') !== false || $_SESSION['filtro']['fechaD'] == '' && DateTimeHelper::getTimestampFromFormat($_SESSION['filtro']['fechaH'], 'Y-m-d H:i:s') !== false || $_SESSION['filtro']['fechaH'] == '') {
    $condicion = '';


    //modifico esto para que funcione SOLAMENTE con los TK-810
    $a_Equipos = Equipo_L::obtenerTodos();
    $margen_llegada_tarde = Config_L::obtenerPorParametro("margen_llegada_tarde")->getValor() * 60;
    $margen_salidas_temprano = Config_L::obtenerPorParametro("margen_salida")->getValor() * 60;
    $o_Listado = null;
    if (!empty($a_Equipos)) {
        foreach ($a_Equipos as $o_Equipo) {

            $condicion .= '  OR leq_Eq_Id = ' . $o_Equipo->getId();


            if (!empty($_SESSION['filtro']['persona']) && $_SESSION['filtro']['persona'] != 'TodasLasPersonas' && $_SESSION['filtro']['persona'] != 'SelectRol') {
                $condicion .= ' AND leq_Per_Id = ' . $_SESSION['filtro']['persona'];
            }
            //para filtrar por grupo
            if (!empty($_SESSION['filtro']['rolF']) && $_SESSION['filtro']['persona'] == 'SelectRol') {
                $array_personas=Grupos_Personas_L::obtenerARRAYPorGrupo($_SESSION['filtro']['rolF']);
                if(isset($array_personas) && !empty($array_personas)){
                    //echo "<pre>";print_r($array_personas);echo "</pre>";
                    $condicion .= ' AND leq_Per_Id IN (' . implode(',', array_map('intval', $array_personas)). ') ';
                }
            }
            if (isset($UsarFechasWidget) && $UsarFechasWidget == true) {
                $condicion .=
                    ' AND leq_Per_Id = per_Id'
                    . " AND leq_Fecha_Hora >= '{$_SESSION['filtro']['fechaDw']}' AND leq_Fecha_Hora <= '{$_SESSION['filtro']['fechaHw']}' "
                    . ' AND leq_Accion = 1 ';
            } else {
                $condicion .=
                    ' AND leq_Per_Id = per_Id'
                    . " AND leq_Fecha_Hora >= '{$_SESSION['filtro']['fechaD']}' AND leq_Fecha_Hora <= '{$_SESSION['filtro']['fechaH']}' "
                    . ' AND leq_Accion = 1 ';

            }

        }

        $condicion = ltrim($condicion, ' OR ');

        $condicion .= ' AND per_Eliminada<>1 ';

        $condicion .= 'ORDER BY per_Id, leq_Fecha_Hora DESC';


        $o_Listado = Logs_Equipo_L::obtenerTodosEnArray('', '', '', $condicion, ', personas ', 'per_Hor_Id, per_Hor_Tipo, ' .
            'leq_Id, leq_Eq_Id, leq_Lector, leq_Fecha_Hora, leq_Per_Id, leq_Dedo');


        //debugging output
        //echo $condicion.'<br />';
        //echo "<pre>";print_r($o_Listado);echo "</pre>";

    }


    $a_orden = array();
    $fecha_rec = '';
    $per_Id_rec = '';

    /********************************************************************************************************************************************************************************************
     * *******************************************************************************************************************************************************************************************
     *  #2 por cada log, se obtiene la persona y los datos del horario de trabajo
     * *******************************************************************************************************************************************************************************************
     * *******************************************************************************************************************************************************************************************/
    if (!is_null($o_Listado)) {
        foreach ($o_Listado as $key => $item) {
            $o_persona = Persona_L::obtenerPorId($item['leq_Per_Id'], true);

            if($o_persona->getHorTipo()=='0')continue;  //persona sin horario

            switch ($item['per_Hor_Tipo']) {
                case HORARIO_NORMAL:
                    $o_hora_trabajo = Hora_Trabajo_L::obtenerPorId($item['per_Hor_Id']);
                    $a_orden[$item['leq_Per_Id']]['Hora_trabajo_Id'] = $o_hora_trabajo->getId();
                    $a_orden[$item['leq_Per_Id']]['Hora_trabajo_Tipo'] = HORARIO_NORMAL;
                    break;
                case HORARIO_FLEXIBLE:
                    $o_hora_trabajo = Horario_Flexible_L::obtenerPorId($item['per_Hor_Id']);
                    $a_orden[$item['leq_Per_Id']]['Hora_trabajo_Id'] = $o_hora_trabajo->getId();
                    $a_orden[$item['leq_Per_Id']]['Hora_trabajo_Tipo'] = HORARIO_FLEXIBLE;
                    break;
                case HORARIO_ROTATIVO:
                    $o_hora_trabajo = Horario_Rotativo_L::obtenerPorId($item['per_Hor_Id']);
                    $a_orden[$item['leq_Per_Id']]['Hora_trabajo_Id'] = $o_hora_trabajo->getId();
                    $a_orden[$item['leq_Per_Id']]['Hora_trabajo_Tipo'] = HORARIO_ROTATIVO;
                    break;
                case HORARIO_MULTIPLE:
                    $o_hora_trabajo = Horario_Multiple_L::obtenerPorId($item['per_Hor_Id']);
                    $a_orden[$item['leq_Per_Id']]['Hora_trabajo_Id'] = $o_hora_trabajo->getId();
                    $a_orden[$item['leq_Per_Id']]['Hora_trabajo_Tipo'] = HORARIO_MULTIPLE;
                    break;
            }

            $fecha_temp = date('Y-m-d', strtotime($item['leq_Fecha_Hora']));
            $seg_fecha_hora = strtotime($item['leq_Fecha_Hora']);
            $hora_temp = date('H:i:s', strtotime($item['leq_Fecha_Hora']));
            $sec_Hora_Temp = DateTimeHelper::time_to_sec($hora_temp);

            if ($fecha_temp != $fecha_rec || $per_Id_rec != $item['leq_Per_Id']) {
                $t_indice = 1;
            }
            $a_orden[$item['leq_Per_Id']]['Nombre'] = $o_persona->getNombreCompleto();
            $a_orden[$item['leq_Per_Id']]['Per_Id'] = $o_persona->getId();
            $a_orden[$item['leq_Per_Id']]['Legajo'] = $o_persona->getLegajo();

            //$a_orden[$item['leq_Per_Id']]['Hora_trabajada_Id'] = $item['hor_Id'];
            $a_orden[$item['leq_Per_Id']]['Hora_trabajada_Detalle'] = $o_hora_trabajo->getDetalle();

            //genera los encabezados de los reportes
            $a_dias_temp = array();
            $hora_trabajo = '';
            $hora_trabajo_margen = '';
            $a_temp = array();

//printear($item);
            /**************************************************************************************************************************************
             * en este foreach, busco en el horario de trabajo, el horario de entrada y salida
             *********************************************************************************************************************************/
            switch ($item['per_Hor_Tipo']) {//aca esta la magia
                case HORARIO_NORMAL:
                    //en el horario normal, cada dia tiene su horario y listo, no hay drama con nada
                    $a_Horas_compor = $o_hora_trabajo->getArrayDiasString();
                    //echo"<pre>";print_r($a_Horas_compor);echo"</pre>";
                    foreach ($a_Horas_compor as $key => $value) {

                        if (!is_null($value[0]) && $value[0] != '00:00:00') {
                            $inidice = $value[0] . '.' . $value[1];
                            if (!isset($a_temp[$inidice]['dias'])) {
                                $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                            } else {
                                $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                            }
                            $a_temp[$inidice]['hora_inicio'] = $value[0];
                            $a_temp[$inidice]['hora_fin'] = $value[1];
                        }
                        //echo"<pre>";	print_r($a_temp);echo"</pre>";
                    }
                    //echo"<pre>";	print_r($a_temp);echo"</pre>";

                    // estos 2 foreach son solamente para generar el texto del encabezado
                    foreach ($a_temp as $value) {
                        $hora_trabajo .= rtrim($value['dias'], ', ') . ' - ' . $value['hora_inicio'] . ' - ' . $value['hora_fin'] . '<br />';
                    }
                    foreach ($a_temp as $value) {
                        if ($value['hora_inicio'] != '00:00:00' && $value['hora_fin'] != '00:00:00') {
                            $hora_trabajo_margen .=
                                DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_inicio']) + $margen_llegada_tarde)) . ' - ' .
                                DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_fin']) - $margen_salidas_temprano)) . '<br />';
                        } else {
                            $hora_trabajo_margen .= _('Pase sin limites') . '<br />';
                        }
                    }
                    $a_orden[$item['leq_Per_Id']]['Hora_Trabajo'] = $hora_trabajo;
                    $a_orden[$item['leq_Per_Id']]['Hora_Trabajo_Margen'] = $hora_trabajo_margen;

                    break;
                case HORARIO_FLEXIBLE:
                    //en el horario flexible, primero tengo que calcular en que horario esta marcando.
                    //para eso, obtengo todos los horarios de inicio
                    //y calculo la diferencia con la hora del log
                    //el que este mas cerca de la hora del log es el ganador!
                    $a_Horas_horario_flexible = $o_hora_trabajo->getArrayDiasString();
                    //en el horario normal, cada dia tiene su horario y listo, no hay drama con nada
                    //echo"<pre>";print_r($a_Horas_compor);echo"</pre>";
                    foreach ($a_Horas_horario_flexible as $a_Horas_compor) {
                        foreach ($a_Horas_compor as $key => $value) {
                            //echo"<pre>";print_r($value);echo"</pre>";
                            if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                $inidice = $value[0] . '.' . $value[1];
                                if (!isset($a_temp[$inidice]['dias'])) {
                                    $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                } else {
                                    $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                }
                                $a_temp[$inidice]['hora_inicio'] = $value[0];
                                $a_temp[$inidice]['hora_fin'] = $value[1];
                            }
                            //echo"<pre>";	print_r($a_temp);echo"</pre>";
                        }
                    }
                    //echo"<pre>";	print_r($a_temp);echo"</pre>";

                    // estos 2 foreach son solamente para generar el texto del encabezado
                    foreach ($a_temp as $value) {
                        $hora_trabajo .= rtrim($value['dias'], ', ') . ' - ' . $value['hora_inicio'] . ' - ' . $value['hora_fin'] . '<br />';
                    }
                    foreach ($a_temp as $value) {
                        if ($value['hora_inicio'] != '00:00:00' && $value['hora_fin'] != '00:00:00') {
                            $hora_trabajo_margen .=
                                DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_inicio']) + $margen_llegada_tarde)) . ' - ' .
                                DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_fin']) - $margen_salidas_temprano)) . '<br />';
                        } else {
                            $hora_trabajo_margen .= _('Pase sin limites') . '<br />';
                        }
                    }
                    $a_orden[$item['leq_Per_Id']]['Hora_Trabajo'] = $hora_trabajo;
                    $a_orden[$item['leq_Per_Id']]['Hora_Trabajo_Margen'] = $hora_trabajo_margen;

                    break;
                case HORARIO_ROTATIVO:
                    //en el horario flexible, primero tengo que calcular en que horario esta marcando.
                    //para eso, obtengo todos los horarios de inicio
                    //y calculo la diferencia con la hora del log
                    //el que este mas cerca de la hora del log es el ganador!
                    $a_Horas_horario_rotativo = $o_hora_trabajo->getArrayDiasString(true,$item['leq_Fecha_Hora']);
                    //en el horario normal, cada dia tiene su horario y listo, no hay drama con nada
                    //echo"<pre>";print_r($a_Horas_compor);echo"</pre>";
                    foreach ($a_Horas_horario_rotativo as $a_Horas_compor) {
                        foreach ($a_Horas_compor as $key => $value) {
                            //echo"<pre>";print_r($value);echo"</pre>";
                            if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                $inidice = $value[0] . '.' . $value[1];
                                if (!isset($a_temp[$inidice]['dias'])) {
                                    $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                } else {
                                    $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                }
                                $a_temp[$inidice]['hora_inicio'] = $value[0];
                                $a_temp[$inidice]['hora_fin'] = $value[1];
                            }
                            //echo"<pre>";	print_r($a_temp);echo"</pre>";
                        }
                    }
                    //echo"<pre>";	print_r($a_temp);echo"</pre>";

                    // estos 2 foreach son solamente para generar el texto del encabezado
                    foreach ($a_temp as $value) {
                        $hora_trabajo .= rtrim($value['dias'], ', ') . ' - ' . $value['hora_inicio'] . ' - ' . $value['hora_fin'] . '<br />';
                    }
                    foreach ($a_temp as $value) {
                        if ($value['hora_inicio'] != '00:00:00' && $value['hora_fin'] != '00:00:00') {
                            $hora_trabajo_margen .=
                                DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_inicio']) + $margen_llegada_tarde)) . ' - ' .
                                DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_fin']) - $margen_salidas_temprano)) . '<br />';
                        } else {
                            $hora_trabajo_margen .= _('Pase sin limites') . '<br />';
                        }
                    }
                    $a_orden[$item['leq_Per_Id']]['Hora_Trabajo'] = $hora_trabajo;
                    $a_orden[$item['leq_Per_Id']]['Hora_Trabajo_Margen'] = $hora_trabajo_margen;
                    break;

                case HORARIO_MULTIPLE:
                    $a_Horas_horario_multiple = $o_hora_trabajo->getArrayDiasString();
                    //printear($a_Horas_horario_multiple);
                    foreach ($a_Horas_horario_multiple as $a_Horas_compor) {
                        foreach ($a_Horas_compor as $key => $value) {
                            //printear($value);
                            if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                $inidice = $value[0] . '.' . $value[1];
                                if (!isset($a_temp[$inidice]['dias'])) {
                                    $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                } else {
                                    $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                }
                                $a_temp[$inidice]['hora_inicio'] = $value[0];
                                $a_temp[$inidice]['hora_fin'] = $value[1];
                            }
                            //printear($a_temp);
                        }
                    }
                    //printear($a_temp);

                    // estos 2 foreach son solamente para generar el texto del encabezado
                    foreach ($a_temp as $value) {
                        $hora_trabajo .= rtrim($value['dias'], ', ') . ' - ' . $value['hora_inicio'] . ' - ' . $value['hora_fin'] . '<br />';
                    }
                    foreach ($a_temp as $value) {
                        if ($value['hora_inicio'] != '00:00:00' && $value['hora_fin'] != '00:00:00') {
                            $hora_trabajo_margen .=
                                DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_inicio']) + $margen_llegada_tarde)) . ' - ' .
                                DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_fin']) - $margen_salidas_temprano)) . '<br />';
                        } else {
                            $hora_trabajo_margen .= _('Pase sin limites') . '<br />';
                        }
                    }
                    $a_orden[$item['leq_Per_Id']]['Hora_Trabajo'] = $hora_trabajo;
                    $a_orden[$item['leq_Per_Id']]['Hora_Trabajo_Margen'] = $hora_trabajo_margen;
                    break;
            }

            /**************************************************************************************************************************************
             *
             *********************************************************************************************************************************/


            // fin de encabezados
            //Hora dia noche
            /**************************************************************************************************************************************
             * aca arreglo el tema dia/noche y organizo los logs por dia
             *********************************************************************************************************************************/
            $dia_n = (date('w', strtotime($fecha_temp))); // 0 (para domingo) hasta 6 (para sabado)
            if (DateTimeHelper::time_to_sec($a_Horas_compor[$dia_n][0]) <= DateTimeHelper::time_to_sec($a_Horas_compor[$dia_n][1])) {//horas de dia
                $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Fecha'] = $fecha_temp;
            } else { //horas de noche
                //echo $item[$a_Horas_compor[$dia_n][1]];
                //echo "<pre>";print_r($item);echo "</pre>";
                //chequear esto, creo que no estan funcionando las horas nocturnas
                if (array_key_exists($a_Horas_compor[$dia_n][1], $item) && (DateTimeHelper::time_to_sec($item[$a_Horas_compor[$dia_n][1]]) + (60 * 60 * Config_L::p('corte_noche')) >= $sec_Hora_Temp)) {
                    $fecha_temp = date('Y-m-d', strtotime('-1day', strtotime($fecha_temp)));
                    $dia_n = (date('w', strtotime($fecha_temp))); // 0 (para domingo) hasta 6 (para sabado)
                }
                $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Fecha'] = $fecha_temp;
            }//fin Hora de noche
//printear($item);
            //aca es donde puedo agregar cosas
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Hora_Inicio'] = $a_Horas_compor[$dia_n][0];
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Hora_Fin'] = $a_Horas_compor[$dia_n][1];
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Hora'] = $hora_temp;
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Seg_Hora'] = $sec_Hora_Temp;
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Dispositivo'] = $item['leq_Lector'].'_'.Equipo_L::obtenerPorId($item['leq_Eq_Id'])->getDetalle();
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Fecha_Hora'] = $item['leq_Fecha_Hora'];
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Eq_Id'] = $item['leq_Eq_Id'];
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Lector'] = $item['leq_Lector'];
            $a_orden[$item['leq_Per_Id']]['Dias'][$fecha_temp][$t_indice]['Dedo'] = $item['leq_Dedo'];
            $fecha_rec = $fecha_temp;
            $per_Id_rec = $item['leq_Per_Id'];
            $t_indice += 1;
        }
        //echo "<pre>";print_r($a_orden);echo "</pre>";
        //printearenproduccion($a_orden);

        /*temporal para arreglar los horarios dentro del margen de bloqueo */
        /*
        if ($a_orden != array()) {
            foreach ($a_orden as $t_per_id => $item) {
                echoenproduccion("<pre>Persona: ".$item['Nombre']."<br>");
                foreach ($item['Dias'] as $fecha => $dia) {

                    printearenproduccion($dia);
                    echoenproduccion("<pre>Chequeando dia ".$fecha."<br>");
                    $length = count($dia);
                    echoenproduccion($length." registros."."<br><br>");
                    for($i = 1; $i < $length; $i++) {
                        echoenproduccion("Registro: ".$dia[$i]['Hora']." (".DateTimeHelper::time_to_sec($dia[$i]['Hora']).")"."<br>");
                        echoenproduccion("Siguiente: ".$dia[$i+1]['Hora']." (".DateTimeHelper::time_to_sec($dia[$i+1]['Hora']).")"."<br>");
                        echoenproduccion("Diferencia en seg: ".abs(DateTimeHelper::time_to_sec($dia[$i]['Hora']) - DateTimeHelper::time_to_sec($dia[$i+1]['Hora']))."<br>");
                        if(abs(DateTimeHelper::time_to_sec($dia[$i]['Hora']) - DateTimeHelper::time_to_sec($dia[$i+1]['Hora'])) < 300){
                            echoenproduccion($dia[$i]['Hora']." BORRAR"."<br>");
                            $o_Log = Logs_Equipo_L::obtenerPorPersonayFechaHora($t_per_id,$dia[$i]['Fecha_Hora']);
                            if(!is_null($o_Log)){

                                //$o_Log->delete();
                            }

                        }

                    }
                    echoenproduccion("</pre>");

                }
                echoenproduccion("</pre>");
            }
        }
*/

        /**************************************************************************************************************************************
         * aca arreglo el tema de los horarios flexibles
         *********************************************************************************************************************************/
        if ($a_orden != array()) {
            foreach ($a_orden as $t_per_id => $item) {//por cada persona
                //echo "<pre>";print_r($item);echo "</pre>";
                if ($item["Hora_trabajo_Tipo"] == HORARIO_FLEXIBLE) {
                    $o_hora_trabajo = Horario_Flexible_L::obtenerPorId($item['Hora_trabajo_Id']);
                    foreach ($item['Dias'] as $fecha_temp => $t_dia) {//por cada dia
                        //echo "<pre>";print_r($t_dia);echo "</pre>";
                        $min_date = '23:59:59';
                        $min_index = '';
                        foreach ($t_dia as $index_dia => $datos_dia) {//por cada registro del dia
                            if (DateTimeHelper::time_to_sec($datos_dia['Hora']) < DateTimeHelper::time_to_sec($min_date)) {
                                $min_date = $datos_dia['Hora'];
                                $min_index = $index_dia;
                            }
                        }
                        ///echo "<pre>"; echo "el dia ".$fecha_temp." el primer registro fue a las: ".$min_date." :".$min_index; echo "</pre>";
                        //en este punto tengo el registro mas temprano del dia.
                        //echo "<pre>";echo "dia: ".$fecha_temp." hora del log: ".$t_dia[$min_index]['Hora']." hora de inicio detectada: ".$o_hora_trabajo->getHorarioByClosestTime($t_dia[$min_index]['Fecha_Hora'])[0];echo "</pre>";
                        //echo "<pre>";echo "dia: ".$fecha_temp." hora del log: ".$t_dia[$min_index]['Hora']." hora de fin  detectada: ".$o_hora_trabajo->getHorarioByClosestTime($t_dia[$min_index]['Fecha_Hora'])[1];echo "</pre>";
                        //aca tengo que modificar el arrat $a_orden original, con los indices estos
                        $nueva_hora_inicio = $o_hora_trabajo->getHorarioByClosestTime($t_dia[$min_index]['Fecha_Hora'])[0];
                        $nueva_hora_fin = $o_hora_trabajo->getHorarioByClosestTime($t_dia[$min_index]['Fecha_Hora'])[1];
                        foreach ($t_dia as $index_dia => $datos_dia) {//por cada registro del dia
                            $a_orden[$item['Per_Id']]['Dias'][$fecha_temp][$index_dia]['Hora_Inicio'] = $nueva_hora_inicio;
                            $a_orden[$item['Per_Id']]['Dias'][$fecha_temp][$index_dia]['Hora_Fin'] = $nueva_hora_fin;
                        }

                    }
                    //echo "<pre>";print_r($item);echo "</pre>";
                }
            }
        }

        /**************************************************************************************************************************************
         * aca arreglo el tema de los horarios rotativos
         *********************************************************************************************************************************/
        if ($a_orden != array()) {
            foreach ($a_orden as $t_per_id => $item) {//por cada persona
                //echo "<pre>";print_r($item);echo "</pre>";
                if ($item["Hora_trabajo_Tipo"] == HORARIO_ROTATIVO) {
                    $o_hora_trabajo = Horario_Rotativo_L::obtenerPorId($item['Hora_trabajo_Id']);
                    foreach ($item['Dias'] as $fecha_temp => $t_dia) {//por cada dia

                        foreach ($t_dia as $index_dia => $datos_dia) {//por cada registro del dia
                            //echo "<pre>";print_r($datos_dia);echo "</pre>";

                            $nueva_hora_inicio = $o_hora_trabajo->getHorarioByDay($datos_dia['Fecha_Hora'])[0];
                            $nueva_hora_fin = $o_hora_trabajo->getHorarioByDay($datos_dia['Fecha_Hora'])[1];

                            $a_orden[$item['Per_Id']]['Dias'][$fecha_temp][$index_dia]['Hora_Inicio'] = $nueva_hora_inicio;
                            $a_orden[$item['Per_Id']]['Dias'][$fecha_temp][$index_dia]['Hora_Fin'] = $nueva_hora_fin;


                        }
                    }
                    //echo "<pre>";print_r($item);echo "</pre>";
                }
            }
        }

        /**************************************************************************************************************************************
         * aca arreglo el tema de los horarios multiples
         *********************************************************************************************************************************/
        if ($a_orden != array()) {
            foreach ($a_orden as $t_per_id => $item) {//por cada persona
                //echo "<pre>";print_r($item);echo "</pre>";
                if ($item["Hora_trabajo_Tipo"] == HORARIO_MULTIPLE) {
                    $o_hora_trabajo = Horario_Multiple_L::obtenerPorId($item['Hora_trabajo_Id']);
                    foreach ($item['Dias'] as $fecha_temp => $t_dia) {//por cada dia
                        //printear($t_dia);

                        foreach ($t_dia as $index_dia => $datos_dia) {//por cada registro del dia

                            $nuevo_horario_detectado = $o_hora_trabajo->getHorarioByClosestTime($t_dia[$index_dia]['Fecha_Hora']);
                            $nueva_hora_inicio = $nuevo_horario_detectado[0];
                            $nueva_hora_fin = $nuevo_horario_detectado[1];

                            //echo "<pre>";echo "dia: ".$fecha_temp." hora del log: ".$t_dia[$index_dia]['Hora']." hora de inicio detectada: ".$o_hora_trabajo->getHorarioByClosestTime($t_dia[$index_dia]['Fecha_Hora'])[0];echo "</pre>";
                            //echo "<pre>";echo "dia: ".$fecha_temp." hora del log: ".$t_dia[$index_dia]['Hora']." hora de fin  detectada: ".$o_hora_trabajo->getHorarioByClosestTime($t_dia[$index_dia]['Fecha_Hora'])[1];echo "</pre>";

                            $a_orden[$item['Per_Id']]['Dias'][$fecha_temp][$index_dia]['Hora_Inicio'] = $nueva_hora_inicio;
                            $a_orden[$item['Per_Id']]['Dias'][$fecha_temp][$index_dia]['Hora_Fin'] = $nueva_hora_fin;
                        }
                    }
                }
            }
        }
    }
    //printear($a_orden);
    $a_Hora_Procesada = null;

    //nivelar los impares
    if ($a_orden != array()) {
        foreach ($a_orden as $t_per_id => $item) {
            foreach ($item['Dias'] as $fecha_temp => $t_dia) {
                if (count($t_dia) % 2 == 0) {//par 2,4,6
                    //no hace nada
                } else {//impar 1, 3 ,5
                    $campo_cero = array('Hora_Inicio' => '', 'Hora_Fin' => '', 'Fecha' => $fecha_temp, 'Hora' => '', 'Seg_Hora' => '', 'Dispositivo' => '', 'Fecha_Hora' => '', 'Eq_Id' => '', 'Lector' => '', 'Dedo' => '');
                    $a_orden[$t_per_id]['Dias'][$fecha_temp][0] = $campo_cero;
                    ksort($a_orden[$t_per_id]['Dias'][$fecha_temp]);
                }
            }
        }
    }//fin nivelacion
    /**************************************************************************************************************************************
     * aca ordeno los registros para que los dias mas recientes queden arriba. esto no funca
     *************************************************************************************************************************************/
    /*  if ($a_orden != array()) {
          foreach ($a_orden as $t_per_id => $item) {

              $temp_array_persona=$item;
              krsort($item['Dias']);

              array_splice($a_orden,)
              unset($a_orden[$t_per_id]);


              echo "<pre>";print_r($item);echo "</pre>";

              //echo "end foreach dia";
          }
      }*/
    /**************************************************************************************************************************************
     * por cada persona, acomodo los dias. aca tambien veo las llegadas tarde
     *********************************************************************************************************************************/
    //printear($a_orden);
    if ($a_orden != array()) {
        foreach ($a_orden as $t_per_id => $item) {
            foreach ($item['Dias'] as $t_dia) {

                $ban_cambio = 0;
                $recordar_cambio = 2;
                $marca = 1;
                $a_hora = array();
                $acumula_x_dia = 0;
                foreach ($t_dia as $t_valor) {
                 /*   echo "<pre>";
                    echo "ban_cambio: ".$ban_cambio."</br>";
                    echo "recordar_cambio: ".$recordar_cambio."</br>";
                    echo "marca: ".$marca."</br>";
                    echo "count(t_dia): ".count($t_dia)."</br>";
                    echo "</pre>";   */
                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Nombre'] = $item['Nombre'];
                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Legajo'] = $item['Legajo'];
                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Per_Id'] = $t_per_id;
                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Hora_Trabajo'] = $item['Hora_Trabajo'];
                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Hora_Trabajo_Margen'] = $item['Hora_Trabajo_Margen'];
                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Acumula_x_Dia'] = '';
                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Hora_Trabajo_Detalle'] = $item['Hora_trabajada_Detalle'];

                    if ($ban_cambio != $recordar_cambio) {
                        //fecha fin
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Fecha'] = $t_valor['Fecha'];
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Fin'] = $t_valor['Hora'];
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['D_Fin'] = $t_valor['Dispositivo'];
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Dedo_Fin'] = $t_valor['Dedo'];
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Fin_Fecha_Hora'] = $t_valor['Fecha_Hora'];
                        $date1 = new DateTime('2006-04-14T' . $t_valor['Hora_Fin']);
                        $date2 = new DateTime('2006-04-14T' . $t_valor['Hora']);
                        if ($date2 > $date1) {
                            $diff = $date2->diff($date1);
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Extra'] = $diff->format('%h:%i:00');
                        }

                        if ($marca == 1 || $item['Hora_trabajo_Tipo'] == HORARIO_MULTIPLE) {   //si es un horario multiple entro siempre, sino solo cuando es el ultimo horario de salida
                            /*echo "<pre>";
                            echo "persona: ".$t_per_id."<br/>";
                            echo "hora fin: ".$t_valor['Hora_Fin']."<br/>";
                            echo "hora fin - margen: ".intval(DateTimeHelper::time_to_sec($t_valor['Hora_Fin']) + intval($margen_salidas_temprano))."<br/>";
                            echo "seg_hora: ".$t_valor['Seg_Hora']."<br/>";
                            echo "</pre>"; */
                            if ($t_valor['Hora_Fin'] == '' || (DateTimeHelper::time_to_sec($t_valor['Hora_Fin']) - $margen_salidas_temprano) < $t_valor['Seg_Hora'] || ($t_valor['Hora_Fin'] == '00:00:00' && $item['Hora_Fin'] == '00:00:00')) {
                                $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Fin_Tarde'] = 'No';
                            } else {
                                $licencia = Licencias_L::obtenerPorSalidaTempranoyPersona($t_valor['Fecha'] . " " . $t_valor['Hora_Fin'], $t_per_id, $t_valor['Fecha'] . " " . $t_valor['Hora']);
                                if (!is_null($licencia) && !empty($licencia)) {
                                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Fin_Tarde'] = 'No';
                                } else {
                                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Fin_Tarde'] = 'Si';
                                }

                            }
                        } else {
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Fin_Tarde'] = 'No';
                        }
                        if (!isset($a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Inicio'])) {
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Inicio'] = '';
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['D_Inicio'] = '';
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Inicio_Fecha_Hora'] = '';
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Inicio_Tarde'] = '';
                        }
                        $recordar_cambio = $ban_cambio;
                        $a_hora[] = $t_valor['Fecha'] . ' ' . $t_valor['Hora'];
                    } else {
                        //fecha inicio
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Fecha'] = $t_valor['Fecha'];
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Inicio'] = $t_valor['Hora'];
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['D_Inicio'] = $t_valor['Dispositivo'];
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Dedo_Inicio'] = $t_valor['Dedo'];
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Inicio_Fecha_Hora'] = $t_valor['Fecha_Hora'];
                        if ($marca == count($t_dia) || $item['Hora_trabajo_Tipo'] == HORARIO_MULTIPLE) {  //si es un horario multiple entro siempre, sino solo cuando es el primer horario de salida
                        /*    echo "<pre>";
                            echo "persona: ".$t_per_id."<br/>";
                            echo "hora inicio: ".$t_valor['Hora_Inicio']."<br/>";
                            echo "hora inicio + margen: ".intval(DateTimeHelper::time_to_sec($t_valor['Hora_Inicio']) + intval($margen_llegada_tarde))."<br/>";
                            echo "seg_hora: ".$t_valor['Seg_Hora']."<br/>";
                            echo "</pre>";  */
                            if ($t_valor['Hora_Inicio'] == '' || DateTimeHelper::time_to_sec($t_valor['Hora_Inicio']) + intval($margen_llegada_tarde) > $t_valor['Seg_Hora'] || ($t_valor['Hora_Fin'] == '00:00:00' && $t_valor['Hora_Inicio'] == '00:00:00')) {
                                $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Inicio_Tarde'] = 'No';
                            } else {
                                //echo "<pre>";print_r($t_valor);echo"</pre>";
                                $licencia = Licencias_L::obtenerPorLlegadaTardeyPersona($t_valor['Fecha'] . " " . $t_valor['Hora_Inicio'], $t_per_id, $t_valor['Fecha'] . " " . $t_valor['Hora']);
                                if (!is_null($licencia) && !empty($licencia)) {
                                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Inicio_Tarde'] = 'No';
                                } else {
                                    $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Inicio_Tarde'] = 'Si';
                                }
                            }
                        } else {
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Inicio_Tarde'] = 'No';
                        }
                        if (!isset($a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Fin'])) {
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Fin'] = '';
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['D_Fin'] = '';
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['Fin_Fecha_Hora'] = '';
                            $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . $ban_cambio]['H_Fin_Tarde'] = '';
                        }
                        $ban_cambio += 1;
                        $a_hora[] = $t_valor['Fecha'] . ' ' . $t_valor['Hora'];
                    }
                    // acumula hora de un solo dia
                    if ($marca == count($t_dia)) {
                        for ($i = 0; $i <= count($t_dia) - 1; $i += 2) {
                            $hs_1 = date('H:i:s', strtotime($a_hora[$i + 1]));
                            $hs_2 = date('H:i:s', strtotime($a_hora[$i]));
                            if ($hs_1 != '00:00:00' && $hs_2 != '00:00:00') {
                                $a_diff = DateTimeHelper::diff_Fecha_Hora($a_hora[$i + 1], $a_hora[$i]);
                                $t_tiempo = sprintf("%02d:%02d:%02d", $a_diff[3], $a_diff[4], $a_diff[5]);

                                $acumula_x_dia += DateTimeHelper::time_to_sec($t_tiempo);
                            }
                        }
                        $a_Hora_Procesada[$t_per_id . '.' . $t_valor['Fecha'] . '.' . ($ban_cambio - 1)]['Acumula_x_Dia'] = $acumula_x_dia;
                    }//fin acumula hora de un solo dia
                    $marca += 1;
                }
            }
        }
    }
    $o_Listado = $a_Hora_Procesada;
    //printearenproduccion($o_Listado);
    unset($a_Hora_Procesada, $a_orden);
}
$a_pdf = null;
$a_csv = null;
//echo "tipo:".$T_Tipo;
switch ($T_Tipo) {
    case 'Tarde': //llegadas tarde web
        if (!is_null($o_Listado)) {
            $t_o_Listado = array();
            foreach ($o_Listado as $indice => $valores) {
                if ($valores['Legajo'] != '') {
                    if (Config_L::p('usar_legajo'))
                        $valores['leg_ape_nomb'] = htmlentities($valores['Legajo'] . ' - ' . $valores['Nombre'], ENT_QUOTES, 'utf-8');
                    else
                        $valores['leg_ape_nomb'] = htmlentities($valores['Nombre'], ENT_QUOTES, 'utf-8');
                } else
                    $valores['leg_ape_nomb'] = htmlentities($valores['Nombre'], ENT_QUOTES, 'utf-8');

                if ($valores['H_Inicio_Tarde'] == 'Si') {
                    $t_o_Listado[$indice] = $valores;

                }
            }
            $o_Listado = $t_o_Listado;
            unset($t_o_Listado);
        }
        break;
    case 'Temprano': //llegadas tarde webs
        if (!is_null($o_Listado)) {
            $t_o_Listado = array();
            foreach ($o_Listado as $indice => $valores) {
                if ($valores['Legajo'] != '') {
                    if (Config_L::p('usar_legajo'))
                        $valores['leg_ape_nomb'] = htmlentities($valores['Legajo'] . ' - ' . $valores['Nombre'], ENT_QUOTES, 'utf-8');
                    else
                        $valores['leg_ape_nomb'] = htmlentities($valores['Nombre'], ENT_QUOTES, 'utf-8');
                } else
                    $valores['leg_ape_nomb'] = htmlentities($valores['Nombre'], ENT_QUOTES, 'utf-8');

                if ($valores['H_Fin_Tarde'] == 'Si') {
                    $t_o_Listado[$indice] = $valores;
                }
            }
            $o_Listado = $t_o_Listado;
            unset($t_o_Listado);
        }
        break;
    case '19': //llegadas tarde pdf
        if (!is_null($o_Listado)) {
            $per_Leg = '';
            $renglon = 1;
            $key = 0;
            foreach ($o_Listado as $item) {
                if ($item['H_Inicio_Tarde'] == 'Si') {
                    if ($per_Leg != $item['Per_Id']) {//legajo hijo de puta
                        // parte para pdf
                        $a_pdf[$renglon]['legajo'] = htmlentities($item['Legajo'], ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['nombre'] = htmlentities($item['Nombre'], ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['per_id'] = htmlentities($item['Per_Id'], ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['horarios'] = _('Horario de Tabajo') . " (" . $item['Hora_Trabajo_Detalle'] . ")" . ' <br />' . rtrim($item['Hora_Trabajo'], '<br />');
                        // parte para pdf
                        $a_pdf[$renglon]['t1'] = _('Fecha');
                        $a_pdf[$renglon]['t2'] = _('Hora Ingreso');
                        $a_pdf[$renglon]['t3'] = _('Hora Salida');

                        $per_Leg = $item['Per_Id'];//legajo hijo de puta
                    }
                    // parte para csv
                    $texto = '';
                    if ($item['H_Inicio_Tarde'] == 'Si') {
                        $texto = htmlentities($item['D_Inicio'], ENT_QUOTES, 'utf-8');
                    } else {
                        $texto = htmlentities($item['D_Fin'], ENT_QUOTES, 'utf-8');
                    }

                    $key += 1;
                    $fecha_i = $item['Fecha'] . ' ';
                    $fecha_i .= ($item['H_Inicio_Tarde'] == 'Si') ? $item['H_Inicio'] : $item['H_Fin'];
                    $a_csv[] = array($fecha_i, $item['Legajo'], $item['Nombre'], $texto);

                    // parte para pdf
                    $a_pdf[$renglon]['fecha'] = htmlentities(date(Config_L::p('f_fecha'), strtotime($item['Fecha'])), ENT_QUOTES, 'utf-8');
                    $a_pdf[$renglon]['ingreso'] = ($item['H_Inicio'] != '') ? htmlentities($item['H_Inicio'] . ' - ' . $item['D_Inicio'], ENT_QUOTES, 'utf-8') : _('Horario Incierto');
                    $a_pdf[$renglon]['ing_tarde'] = $item['H_Inicio_Tarde'];
                    $tc = (strtotime($item['Fecha']) == strtotime(date('Y-m-d'))) ? _('Salida no Registrada') : _('Horario Incierto');
                    $a_pdf[$renglon]['salida'] = ($item['H_Fin'] != '') ? htmlentities($item['H_Fin'] . ' - ' . $item['D_Fin'], ENT_QUOTES, 'utf-8') : $tc;
                    $a_pdf[$renglon]['sal_tarde'] = $item['H_Fin_Tarde'];
                    $renglon += 1;
                }
            }
        }

        break;
    case '23': //salidas temprano pdf
        if (!is_null($o_Listado)) {
            $per_Leg = '';
            $renglon = 1;
            $key = 0;
            foreach ($o_Listado as $item) {
                if ($item['H_Fin_Tarde'] == 'Si') {
                    if ($per_Leg != $item['Per_Id']) {//legajo hijo de puta
                        // parte para pdf
                        $a_pdf[$renglon]['legajo'] = htmlentities($item['Legajo'], ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['nombre'] = htmlentities($item['Nombre'], ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['per_id'] = htmlentities($item['Per_Id'], ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['horarios'] = _('Horario de Tabajo') . " (" . $item['Hora_Trabajo_Detalle'] . ")" . ' <br />' . rtrim($item['Hora_Trabajo'], '<br />');
                        // parte para pdf
                        $a_pdf[$renglon]['t1'] = _('Fecha');
                        $a_pdf[$renglon]['t2'] = _('Hora Ingreso');
                        $a_pdf[$renglon]['t3'] = _('Hora Salida');

                        $per_Leg = $item['Per_Id'];//legajo hijo de puta
                    }
                    // parte para csv
                    $texto = '';
                    if ($item['H_Inicio_Tarde'] == 'Si') {
                        $texto = htmlentities($item['D_Inicio'], ENT_QUOTES, 'utf-8');
                    } else {
                        $texto = htmlentities($item['D_Fin'], ENT_QUOTES, 'utf-8');
                    }

                    $key += 1;
                    $fecha_i = $item['Fecha'] . ' ';
                    $fecha_i .= ($item['H_Inicio_Tarde'] == 'Si') ? $item['H_Inicio'] : $item['H_Fin'];
                    $a_csv[] = array($fecha_i, $item['Legajo'], $item['Nombre'], $texto);

                    // parte para pdf
                    $a_pdf[$renglon]['fecha'] = htmlentities(date(Config_L::p('f_fecha'), strtotime($item['Fecha'])), ENT_QUOTES, 'utf-8');
                    $a_pdf[$renglon]['ingreso'] = ($item['H_Inicio'] != '') ? htmlentities($item['H_Inicio'] . ' - ' . $item['D_Inicio'], ENT_QUOTES, 'utf-8') : _('Horario Incierto');
                    $a_pdf[$renglon]['ing_tarde'] = $item['H_Inicio_Tarde'];
                    $tc = (strtotime($item['Fecha']) == strtotime(date('Y-m-d'))) ? _('Salida no Registrada') : _('Horario Incierto');
                    $a_pdf[$renglon]['salida'] = ($item['H_Fin'] != '') ? htmlentities($item['H_Fin'] . ' - ' . $item['D_Fin'], ENT_QUOTES, 'utf-8') : $tc;
                    $a_pdf[$renglon]['sal_tarde'] = $item['H_Fin_Tarde'];
                    $renglon += 1;
                }
            }
        }

        break;
    case '20'://entradas salidas pdf
        if (!is_null($o_Listado)) {
            $per_Leg = '';
            $acumula_horas = 0;
            $renglon = 1;
            $key = 0;
            foreach ($o_Listado as $item) {
                if ($per_Leg != $item['Per_Id']) {//legajo hijo de puta


                    $a_pdf[$renglon]['legajo'] = htmlentities($item['Legajo'], ENT_QUOTES, 'utf-8');
                    $a_pdf[$renglon]['nombre'] = htmlentities($item['Nombre'], ENT_QUOTES, 'utf-8');
                    $a_pdf[$renglon]['horarios'] = _('Horario de Tabajo') . " (" . $item['Hora_Trabajo_Detalle'] . ")" . ' <br />' . rtrim($item['Hora_Trabajo'], '<br />');

                    $a_pdf[$renglon]['t1'] = _('Fecha');
                    $a_pdf[$renglon]['t2'] = _('Hora Ingreso');
                    $a_pdf[$renglon]['t3'] = _('Hora Salida');
                    $per_Leg = $item['Per_Id'];
                    $acumula_horas = 0;
                }
                // parte para csv
                $a_csv[] = array($item['Fecha'], $item['Legajo'], $item['Nombre'], ($item['H_Inicio'] != '') ? $item['H_Inicio'] : '00:00:00', ($item['D_Inicio'] != '') ? $item['D_Inicio'] : '---', ($item['H_Fin'] != '') ? $item['H_Fin'] : '00:00:00', ($item['D_Fin'] != '') ? $item['D_Fin'] : '---');
                // parte para pdf
                $a_pdf[$renglon]['fecha'] = htmlentities(date(Config_L::p('f_fecha'), strtotime($item['Fecha'])), ENT_QUOTES, 'utf-8');
                $a_pdf[$renglon]['ingreso'] = ($item['H_Inicio'] != '') ? htmlentities($item['H_Inicio'] . ' - ' . $item['D_Inicio'], ENT_QUOTES, 'utf-8') : _('Horario Incierto');
                $a_pdf[$renglon]['ing_tarde'] = $item['H_Inicio_Tarde'];
                $tc = (strtotime($item['Fecha']) == strtotime(date('Y-m-d'))) ? _('Salida no Registrada') : _('Horario Incierto');
                $a_pdf[$renglon]['salida'] = ($item['H_Fin'] != '') ? htmlentities($item['H_Fin'] . ' - ' . $item['D_Fin'], ENT_QUOTES, 'utf-8') : $tc;
                $a_pdf[$renglon]['sal_tarde'] = $item['H_Fin_Tarde'];
                $renglon += 1;
            }
        }

        break;
    case '21'://dias horas trabajadas pdf
        if (!is_null($o_Listado)) {
            $per_Leg = '';
            $acumula_horas = 0;
            $acumula_dias = 0;
            $renglon = 1;
            $key = 0;
            foreach ($o_Listado as $item) {
                if ($per_Leg != $item['Per_Id']) {
                    if ($key != 0) {
                        // parte para pdf
                        $a_pdf[$renglon]['t10'] = htmlentities(_('Dias trabajados'), ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['t11'] = htmlentities(_('Horas trabajadas'), ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['inconsistencia'] = ($t_inconsistencia) ? _('Es posible que los totales tengan inconsistencias por no haber marcado correctamente el ingreso o el egreso.') : '';
                        $a_pdf[$renglon]['dias_acumula'] = htmlentities($acumula_dias, ENT_QUOTES, 'utf-8');
                        $a_pdf[$renglon]['horas_acumula'] = htmlentities(DateTimeHelper::sec_to_time($acumula_horas), ENT_QUOTES, 'utf-8');
                    }
                    // parte para pdf
                    $a_pdf[$renglon]['legajo'] = htmlentities($item['Legajo'], ENT_QUOTES, 'utf-8');
                    $a_pdf[$renglon]['nombre'] = htmlentities($item['Nombre'], ENT_QUOTES, 'utf-8');
                    $a_pdf[$renglon]['horarios'] = _('Horario de Tabajo') . " (" . $item['Hora_Trabajo_Detalle'] . ")" . ' <br />' . rtrim($item['Hora_Trabajo'], '<br />');

                    $a_pdf[$renglon]['t1'] = _('Fecha');
                    $a_pdf[$renglon]['t2'] = _('Hora Ingreso');
                    $a_pdf[$renglon]['t3'] = _('Hora Salida');
                    $a_pdf[$renglon]['t4'] = _('Total Intervalo');
                    $a_pdf[$renglon]['t5'] = _('Total Diario');

                    $per_Leg = $item['Per_Id'];
                    $acumula_horas = 0;
                    $acumula_dias = 0;
                    $temp_dia = 0;
                    $t_inconsistencia = 0;
                }

                if ($item['H_Inicio'] != '' && $item['H_Fin'] != '') {
                    $a_diff = DateTimeHelper::diff_Fecha_Hora($item['Inicio_Fecha_Hora'], $item['Fin_Fecha_Hora']);
                    $t_tiempo = sprintf("%02d:%02d:%02d", $a_diff[3], $a_diff[4], $a_diff[5]);
                    $acumula_horas += DateTimeHelper::time_to_sec($t_tiempo);
                } else {
                    $t_inconsistencia = 1;
                }
                //echo "$temp_dia != ".date('d', strtotime($item['Fecha']));
                $t_dia = date('d', strtotime($item['Fecha']));
                if ($temp_dia != $t_dia) {
                    $acumula_dias += 1;
                    $temp_dia = $t_dia;
                } else {
                    $temp_dia = $t_dia;
                }
                $key += 1;

                // parte para csv
                $a_csv[] = array($item['Fecha'], $item['Legajo'], $item['Nombre'], ($item['H_Inicio'] != '') ? $item['H_Inicio'] : '00:00:00', ($item['H_Fin'] != '') ? $item['H_Fin'] : '00:00:00', isset($t_tiempo) ? $t_tiempo : '00:00:00');

                // parte para pdf
                $a_pdf[$renglon]['fecha'] = htmlentities(date(Config_L::p('f_fecha'), strtotime($item['Fecha'])), ENT_QUOTES, 'utf-8');
                $a_pdf[$renglon]['ingreso'] = ($item['H_Inicio'] != '') ? htmlentities($item['H_Inicio'] . ' - ' . $item['D_Inicio'], ENT_QUOTES, 'utf-8') : _('Horario Incierto');
                $a_pdf[$renglon]['ing_tarde'] = $item['H_Inicio_Tarde'];
                $tc = (strtotime($item['Fecha']) == strtotime(date('Y-m-d'))) ? _('Salida no Registrada') : _('Horario Incierto');
                $a_pdf[$renglon]['salida'] = ($item['H_Fin'] != '') ? htmlentities($item['H_Fin'] . ' - ' . $item['D_Fin'], ENT_QUOTES, 'utf-8') : $tc;
                $a_pdf[$renglon]['sal_tarde'] = $item['H_Fin_Tarde'];
                $a_pdf[$renglon]['total_horas'] = ($item['H_Inicio'] != '' && $item['H_Fin'] != '') ? $t_tiempo : '00:00:00';
                $a_pdf[$renglon]['acumula_x_dia'] = ($item['Acumula_x_Dia'] != '') ? DateTimeHelper::sec_to_time($item['Acumula_x_Dia']) : '';
                $renglon += 1;
            }
            // parte para pdf
            $a_pdf[$renglon]['t10'] = htmlentities(_('Dias trabajados'), ENT_QUOTES, 'utf-8');
            $a_pdf[$renglon]['t11'] = htmlentities(_('Horas trabajadas'), ENT_QUOTES, 'utf-8');
            $a_pdf[$renglon]['inconsistencia'] = ($t_inconsistencia) ? htmlentities(_('Es posible que los totales tengan inconsistencias por no haber marcado correctamente el ingreso o el egreso.'), ENT_QUOTES, 'utf-8') : '';
            $a_pdf[$renglon]['dias_acumula'] = htmlentities($acumula_dias, ENT_QUOTES, 'utf-8');
            $a_pdf[$renglon]['horas_acumula'] = htmlentities(DateTimeHelper::sec_to_time($acumula_horas), ENT_QUOTES, 'utf-8');
        }
        break;

    case 'mod_LLegada_Tarde':
        if (!is_null($o_Listado)) {
            $per_Leg = '';
            $a_mod = null;
            foreach ($o_Listado as $item) {
                if ($item['H_Inicio_Tarde'] == 'Si') {// || $item['H_Fin_Tarde'] == 'Si') {
                    if ($per_Leg != $item['Per_Id']) {
                        if (Config_L::p('usar_legajo'))
                            $a_mod[$item['Per_Id']]['leg_ape_nomb'] = htmlentities($item['Legajo'] . ' - ' . $item['Nombre'], ENT_QUOTES, 'utf-8');
                        else
                            $a_mod[$item['Per_Id']]['leg_ape_nomb'] = htmlentities($item['Nombre'], ENT_QUOTES, 'utf-8');
                        $a_mod[$item['Per_Id']]['per_Id'] = htmlentities($item['Per_Id'], ENT_QUOTES, 'utf-8');
                        $a_mod[$item['Per_Id']]['cant'] = 0;
                    }
                    $a_mod[$item['Per_Id']]['cant'] += 1;
                    $per_Leg = $item['Per_Id'];
                }
            }
        }

        break;
    case 'mod_Salida_Temprano':
        if (!is_null($o_Listado)) {
            $per_Leg = '';
            $a_mod = null;
            foreach ($o_Listado as $item) {
                if ($item['H_Fin_Tarde'] == 'Si') {
                    if ($per_Leg != $item['Per_Id']) {
                        if (Config_L::p('usar_legajo'))
                            $a_mod[$item['Per_Id']]['leg_ape_nomb'] = htmlentities($item['Legajo'] . ' - ' . $item['Nombre'], ENT_QUOTES, 'utf-8');
                        else
                            $a_mod[$item['Per_Id']]['leg_ape_nomb'] = htmlentities($item['Nombre'], ENT_QUOTES, 'utf-8');
                        $a_mod[$item['Per_Id']]['per_Id'] = htmlentities($item['Per_Id'], ENT_QUOTES, 'utf-8');
                        $a_mod[$item['Per_Id']]['cant'] = 0;
                    }
                    $a_mod[$item['Per_Id']]['cant'] += 1;
                    $per_Leg = $item['Per_Id'];
                }
            }
        }

        break;
    case 'mod_Entradas_Salidas':
        if (!is_null($o_Listado)) {
            $per_Leg = '';
            $a_mod = null;

            foreach ($o_Listado as $item) {

                if (Config_L::p('usar_legajo'))
                    $a_mod[$item['Per_Id']]['leg_ape_nomb'] = htmlentities($item['Legajo'] . ' - ' . $item['Nombre'], ENT_QUOTES, 'utf-8');
                else
                    $a_mod[$item['Per_Id']]['leg_ape_nomb'] = htmlentities($item['Nombre'], ENT_QUOTES, 'utf-8');

                $a_mod[$item['Per_Id']]['per_Id'] = htmlentities($item['Per_Id'], ENT_QUOTES, 'utf-8');
                $a_mod[$item['Per_Id']]['equipo'] = htmlentities($item['D_Inicio'], ENT_QUOTES, 'utf-8');
                $a_mod[$item['Per_Id']]['hora'] = htmlentities($item['Inicio_Fecha_Hora'], ENT_QUOTES, 'utf-8');
                $a_mod[$item['Per_Id']]['H_Inicio_Tarde'] = htmlentities($item['H_Inicio_Tarde'], ENT_QUOTES, 'utf-8');
                $a_mod[$item['Per_Id']]['H_Inicio_Tarde'] = htmlentities($item['H_Inicio_Tarde'], ENT_QUOTES, 'utf-8');
                $cant_a_sumar = 0;
                if (isset($item['H_Inicio']) && $item['H_Inicio'] != '') {
                    $cant_a_sumar++;
                    if (isset($item['H_Fin']) && $item['H_Fin'] != '') {
                        $cant_a_sumar++;
                    }
                }


                if (!isset($a_mod[$item['Per_Id']]['cantidad']))
                    $a_mod[$item['Per_Id']]['cantidad'] = $cant_a_sumar;
                else
                    $a_mod[$item['Per_Id']]['cantidad'] = $a_mod[$item['Per_Id']]['cantidad'] + $cant_a_sumar;

            }
        }

        break;
    case 'Feriados':

        //printear($o_Listado);




        break;
    case '22': // Ausencias PDF
    case 'Ausencias': // Ausencias
    case 'mod_Ausencias':
        $a_csv = array();
        $a_dias_vino = array();
        $a_Leg_Vinieron = array();
        //printear($o_Listado);
        if (isset($o_Listado) && !is_null($o_Listado)) {
            foreach ($o_Listado as $item) {// almacena los dias que una persona vino a trabajar

                if (Config_L::p('usar_legajo'))
                    $a_dias_vino[$item['Per_Id']]['leg_ape_nomb'] = $item['Legajo'] . ' - ' . $item['Nombre'];
                else
                    $a_dias_vino[$item['Per_Id']]['leg_ape_nomb'] = $item['Nombre'];
                $a_dias_vino[$item['Per_Id']]['ape_nomb'] = htmlentities($item['Nombre'], ENT_QUOTES, 'utf-8');
                $a_dias_vino[$item['Per_Id']]['per_id'] = htmlentities($item['Per_Id'], ENT_QUOTES, 'utf-8');
                $a_dias_vino[$item['Per_Id']]['horarios'] = ''; //_('Horario de Tabajo') . " (" . $item['Hora_Trabajo_Detalle'] . ")" . ' <br />' . rtrim($item['Hora_Trabajo'], '<br />');
                //$a_dias_vino[$item['per_id']]['fecha'][$item['Fecha']] = $item['Fecha'];
                //$a_dias_vino[$item['per_id']]['fecha'][$item['Fecha'] . '_h'] = $item['H_Inicio'];
                $a_dias_vino[$item['Per_Id']]['fecha'][$item['Fecha']] = $item['H_Inicio'];
                $a_dias_vino[$item['Per_Id']]['Hora_Trabajo_Margen'] = $item['Hora_Trabajo_Margen'];
                $a_dias_vino[$item['Per_Id']]['Hora_Trabajo'] = $item['Hora_Trabajo'];
                $a_dias_vino[$item['Per_Id']]['Hora_Trabajo_Detalle'] = $item['Hora_Trabajo_Detalle'];
                $a_Leg_Vinieron[] = (string)$item['Per_Id'];
            }
        }
        unset($o_Listado);
        //printear($a_dias_vino);
        $margen_ausencia = Config_L::obtenerPorParametro("margen_ausencia")->getValor() * 60;
        foreach ($a_dias_vino as $legajo => $persona) {// recorro las persona que vinieron para ver si estan drentro del rango para ver si estan ausentes
            //$t_fecha = $persona['fecha'];
            $o_Persona_o = Persona_L::obtenerPorId($persona['per_id'], true, false);
            if (!is_null($o_Persona_o)) {
                //echo "<pre>"; print_r($persona['fecha']);echo "</pre>";
                foreach ($persona['fecha'] as $t_fecha => $t_hora) {

                    switch ($o_Persona_o->getHorTipo()) {
                        case HORARIO_NORMAL:
                            $a_Horario_Tabajo = $o_Persona_o->getHoraTrabajoObject()->getArrayDias();
                            $dia_n = (date('w', strtotime($t_fecha)) + 1); // 1 (para domingo) hasta 7 (para sabado)
                            if (date('H:i', $a_Horario_Tabajo[$dia_n][0]) != '00:00' && date('H:i', $a_Horario_Tabajo[$dia_n][1]) != '00:00') {// dias que falto
                                //echo "aca esta el problema";echo "<br>";
                                //echo "persona:".$persona["ape_nomb"];echo "<br>";
                                //echo "horario hoy:".date('Y-m-d H:i:s',$a_Horario_Tabajo[$dia_n][0]);echo "<br>";
                                //echo "horario + margen:".date('Y-m-d H:i:s',($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia));echo "<br>";
                                //echo "horario del log:".date('Y-m-d H:i:s',strtotime($t_hora));echo "<br>";
                                //echo "<br>";
                                if ($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia < strtotime($t_hora)) {// borro fechas que estan fuera de rango
                                    unset($a_dias_vino[$legajo]['fecha'][$t_fecha]); //borro la facha para que se cuente como ausencia
                                    //echo "unseted";echo "<br>";
                                } else {
                                    $a_dias_vino[$legajo]['fecha'][$t_fecha] = $t_fecha; //fijo la fecha para que sea salteada
                                }
                            }
                            break;
                        case HORARIO_FLEXIBLE:
                            $a_Horarios_Tabajo = $o_Persona_o->getHoraTrabajoObject()->getArrayDias();
                            $dia_n = (date('w', strtotime($t_fecha)) + 1); // 1 (para domingo) hasta 7 (para sabado)
                            foreach ($a_Horarios_Tabajo as $a_Horario_Tabajo) {
                                if (date('H:i', $a_Horario_Tabajo[$dia_n][0]) != '00:00' && date('H:i', $a_Horario_Tabajo[$dia_n][1]) != '00:00') {// dias que falto
                                    if ($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia < strtotime($t_hora)) {// borro fechas que estan fuera de rango
                                        unset($a_dias_vino[$legajo]['fecha'][$t_fecha]); //borro la fecha para que se cuente como ausencia
                                    } else {
                                        $a_dias_vino[$legajo]['fecha'][$t_fecha] = $t_fecha; //fijo la fecha para que sea salteada
                                    }
                                }
                            }
                            break;
                        case HORARIO_ROTATIVO:
                            $a_Horarios_Tabajo = $o_Persona_o->getHoraTrabajoObject()->getArrayDias(true,$t_fecha . ' ' . $t_hora);
                            $dia_n = (date('w', strtotime($t_fecha)) + 1); // 1 (para domingo) hasta 7 (para sabado)
                            //printear($a_Horarios_Tabajo);
                            foreach ($a_Horarios_Tabajo as $a_Horario_Tabajo) {
                                if (date('H:i', $a_Horario_Tabajo[$dia_n][0]) != '00:00' && date('H:i', $a_Horario_Tabajo[$dia_n][1]) != '00:00') {// dias que falto

                                    /*
                                    if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) {
                                        echo "persona:" . $persona["ape_nomb"];echo "<br>";
                                        echo "horario hoy:" . date('Y-m-d H:i:s', $a_Horario_Tabajo[$dia_n][0]);echo "<br>";
                                        echo "horario + margen:" . date('Y-m-d H:i:s', ($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia));echo "<br>";
                                        echo "horario del log:" . date('Y-m-d H:i:s', strtotime($t_hora)); echo "<br>";echo "<br>";echo "<br>";
                                    }
                                    */
                                    if ($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia < strtotime($t_hora)) {// borro fechas que estan fuera de rango
                                        unset($a_dias_vino[$legajo]['fecha'][$t_fecha]); //borro la facha para que se cuente como ausencia
                                       // echo "unseted";echo "<br>";
                                    } else {
                                        $a_dias_vino[$legajo]['fecha'][$t_fecha] = $t_fecha; //fijo la fecha para que sea salteada
                                    }
                                }
                            }
                            break;
                    }

                }
            }
        }
        //printear($a_dias_vino);
        // gente que no esta en el array $a_dias_vino y la tengo que insertar porque son ausentes
        if (!empty($_SESSION['filtro']['persona']) && $_SESSION['filtro']['persona'] != 'TodasLasPersonas' && $_SESSION['filtro']['persona'] != 'SelectRol') {// una sola persona
            $t_persona = Persona_L::obtenerPorId($_SESSION['filtro']['persona'], true, false);
            if (!in_array($t_persona->getId(), $a_Leg_Vinieron)) {
                if (Config_L::p('usar_legajo'))
                    $a_dias_vino[$t_persona->getId()]['leg_ape_nomb'] = $t_persona->getLegajo() . ' - ' . $t_persona->getNombreCompleto();
                else
                    $a_dias_vino[$t_persona->getId()]['leg_ape_nomb'] = $t_persona->getNombreCompleto();

                $a_dias_vino[$t_persona->getId()]['ape_nomb'] = htmlentities($t_persona->getNombreCompleto(), ENT_QUOTES, 'utf-8');
                $a_dias_vino[$t_persona->getId()]['per_id'] = $t_persona->getId();
                $a_dias_vino[$t_persona->getId()]['horarios'] = ''; //_('Horario de Tabajo') . " (" . $item['Hora_Trabajo_Detalle'] . ")" . ' <br />' . rtrim($item['Hora_Trabajo'], '<br />');
                $a_dias_temp = array();
                $hora_trabajo = '';
                $hora_trabajo_margen = '';
                $a_temp = array();
                switch ($t_persona->getHorTipo()) {
                    case HORARIO_NORMAL:
                        $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                        $a_Horas_compor = $o_hora_trabajo->getArrayDiasString();
                        foreach ($a_Horas_compor as $key => $value) {
                            if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                $inidice = $value[0] . '.' . $value[1];
                                if (!isset($a_temp[$inidice]['dias'])) {
                                    $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                } else {
                                    $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                }
                                $a_temp[$inidice]['hora_inicio'] = $value[0];
                                $a_temp[$inidice]['hora_fin'] = $value[1];
                            }
                        }
                        break;
                    case HORARIO_FLEXIBLE:
                        $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                        $a_Horas_horario_flexible = $o_hora_trabajo->getArrayDiasString();
                        foreach ($a_Horas_horario_flexible as $a_Horas_compor) {
                            foreach ($a_Horas_compor as $key => $value) {
                                if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                    $inidice = $value[0] . '.' . $value[1];
                                    if (!isset($a_temp[$inidice]['dias'])) {
                                        $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                    } else {
                                        $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                    }
                                    $a_temp[$inidice]['hora_inicio'] = $value[0];
                                    $a_temp[$inidice]['hora_fin'] = $value[1];
                                }
                            }
                        }
                        break;
                    case HORARIO_ROTATIVO:
                        $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                        $a_Horas_horario_rotativo = $o_hora_trabajo->getArrayDiasString();
                        foreach ($a_Horas_horario_rotativo as $a_Horas_compor) {
                            foreach ($a_Horas_compor as $key => $value) {
                                if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                    $inidice = $value[0] . '.' . $value[1];
                                    if (!isset($a_temp[$inidice]['dias'])) {
                                        $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                    } else {
                                        $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                    }
                                    $a_temp[$inidice]['hora_inicio'] = $value[0];
                                    $a_temp[$inidice]['hora_fin'] = $value[1];
                                }
                            }
                        }
                        break;
                }
                //echo"<pre>";	print_r($a_Horas_compor);echo"</pre>";
                foreach ($a_temp as $value) {
                    $hora_trabajo .= rtrim($value['dias'], ', ') . ' - ' . $value['hora_inicio'] . ' - ' . $value['hora_fin'] . '</br>';
                }
                foreach ($a_temp as $value) {
                    if ($value['hora_inicio'] != '00:00:00' && $value['hora_fin'] != '00:00:00') {
                        $hora_trabajo_margen .=
                            DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_inicio']) + $margen_llegada_tarde)) . ' - ' .
                            DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_fin']) - $margen_salidas_temprano)) . '</br>';
                    } else {
                        $hora_trabajo_margen .= _('Pase sin limites') . '</br>';
                    }
                }
                $a_dias_vino[$t_persona->getId()]['Hora_Trabajo_Margen'] = $hora_trabajo_margen;
                $a_dias_vino[$t_persona->getId()]['Hora_Trabajo'] = $hora_trabajo;
                $a_dias_vino[$t_persona->getId()]['Hora_Trabajo_Detalle'] = $o_hora_trabajo->getDetalle();
                $a_dias_vino[$t_persona->getId()]['fecha'] = array();
            }
        } elseif (!empty($_SESSION['filtro']['rolF']) && $_SESSION['filtro']['persona'] == 'SelectRol') {// por Grupo
            $o_Persona = Persona_L::obtenerPorGrupo($_SESSION['filtro']['rolF']);

            if (!is_null($o_Persona)) {
                foreach ($o_Persona as $t_persona) { // gente que no esta en el array $a_dias_vino
                    if (!in_array($t_persona->getId(), $a_Leg_Vinieron)) {
                        if (Config_L::p('usar_legajo'))
                            $a_dias_vino[$t_persona->getId()]['leg_ape_nomb'] = $t_persona->getLegajo() . ' - ' . $t_persona->getNombreCompleto();
                        else
                            $a_dias_vino[$t_persona->getId()]['leg_ape_nomb'] = $t_persona->getNombreCompleto();
                        $a_dias_vino[$t_persona->getId()]['ape_nomb'] = htmlentities($t_persona->getNombreCompleto(), ENT_QUOTES, 'utf-8');
                        $a_dias_vino[$t_persona->getId()]['per_id'] = $t_persona->getId();
                        $a_dias_vino[$t_persona->getId()]['horarios'] = '';
                        $a_dias_temp = array();
                        $hora_trabajo = '';
                        $hora_trabajo_margen = '';
                        $a_temp = array();
                        switch ($t_persona->getHorTipo()) {
                            case HORARIO_NORMAL:
                                $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                                $a_Horas_compor = $o_hora_trabajo->getArrayDiasString();
                                foreach ($a_Horas_compor as $key => $value) {
                                    if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                        $inidice = $value[0] . '.' . $value[1];
                                        if (!isset($a_temp[$inidice]['dias'])) {
                                            $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                        } else {
                                            $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                        }
                                        $a_temp[$inidice]['hora_inicio'] = $value[0];
                                        $a_temp[$inidice]['hora_fin'] = $value[1];
                                    }
                                }
                                break;
                            case HORARIO_FLEXIBLE:
                                $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                                $a_Horas_horario_flexible = $o_hora_trabajo->getArrayDiasString();
                                foreach ($a_Horas_horario_flexible as $a_Horas_compor) {
                                    foreach ($a_Horas_compor as $key => $value) {
                                        if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                            $inidice = $value[0] . '.' . $value[1];
                                            if (!isset($a_temp[$inidice]['dias'])) {
                                                $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                            } else {
                                                $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                            }
                                            $a_temp[$inidice]['hora_inicio'] = $value[0];
                                            $a_temp[$inidice]['hora_fin'] = $value[1];
                                        }
                                    }
                                }
                                break;
                            case HORARIO_ROTATIVO:
                                $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                                $a_Horas_horario_rotativo = $o_hora_trabajo->getArrayDiasString();
                                foreach ($a_Horas_horario_rotativo as $a_Horas_compor) {
                                    foreach ($a_Horas_compor as $key => $value) {
                                        if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                            $inidice = $value[0] . '.' . $value[1];
                                            if (!isset($a_temp[$inidice]['dias'])) {
                                                $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                            } else {
                                                $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                            }
                                            $a_temp[$inidice]['hora_inicio'] = $value[0];
                                            $a_temp[$inidice]['hora_fin'] = $value[1];
                                        }
                                    }
                                }
                                break;
                        }
                        //echo"<pre>";	print_r($a_Horas_compor);echo"</pre>";
                        foreach ($a_temp as $value) {
                            $hora_trabajo .= rtrim($value['dias'], ', ') . ' - ' . $value['hora_inicio'] . ' - ' . $value['hora_fin'] . '</br>';
                        }
                        foreach ($a_temp as $value) {
                            if ($value['hora_inicio'] != '00:00:00' && $value['hora_fin'] != '00:00:00') {
                                $hora_trabajo_margen .=
                                    DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_inicio']) + $margen_llegada_tarde)) . ' - ' .
                                    DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_fin']) - $margen_salidas_temprano)) . '</br>';
                            } else {
                                $hora_trabajo_margen .= _('Pase sin limites') . '</br>';
                            }
                        }
                        $a_dias_vino[$t_persona->getId()]['Hora_Trabajo_Margen'] = $hora_trabajo_margen;
                        $a_dias_vino[$t_persona->getId()]['Hora_Trabajo'] = $hora_trabajo;
                        $a_dias_vino[$t_persona->getId()]['Hora_Trabajo_Detalle'] = $o_hora_trabajo->getDetalle();
                        $a_dias_vino[$t_persona->getId()]['fecha'] = array();
                    }
                }
            }
        } else { // Listado total de personas
            $o_Persona = Persona_L::obtenerTodos(0, 0, 0, 'per_Hor_Id <> 0 AND per_Eliminada<>1');

            if (!is_null($o_Persona)) {
                foreach ($o_Persona as $t_persona) {
                    /* @var $t_persona Persona_O */ // gente que no esta en el array $a_dias_vino
                    if (!in_array($t_persona->getId(), $a_Leg_Vinieron)) {
                        if (Config_L::p('usar_legajo'))
                            $a_dias_vino[$t_persona->getId()]['leg_ape_nomb'] = $t_persona->getLegajo() . ' - ' . $t_persona->getNombreCompleto();
                        else
                            $a_dias_vino[$t_persona->getId()]['leg_ape_nomb'] = $t_persona->getNombreCompleto();
                        $a_dias_vino[$t_persona->getId()]['ape_nomb'] = htmlentities($t_persona->getNombreCompleto(), ENT_QUOTES, 'utf-8');
                        $a_dias_vino[$t_persona->getId()]['per_id'] = $t_persona->getId();
                        $a_dias_vino[$t_persona->getId()]['horarios'] = '';
                        $a_dias_temp = array();
                        $hora_trabajo = '';
                        $hora_trabajo_margen = '';
                        $a_temp = array();
                        switch ($t_persona->getHorTipo()) {
                            case HORARIO_NORMAL:
                                $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                                $a_Horas_compor = $o_hora_trabajo->getArrayDiasString();
                                foreach ($a_Horas_compor as $key => $value) {
                                    if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                        $inidice = $value[0] . '.' . $value[1];
                                        if (!isset($a_temp[$inidice]['dias'])) {
                                            $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                        } else {
                                            $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                        }
                                        $a_temp[$inidice]['hora_inicio'] = $value[0];
                                        $a_temp[$inidice]['hora_fin'] = $value[1];
                                    }
                                }
                                break;
                            case HORARIO_FLEXIBLE:
                                $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                                $a_Horas_horario_flexible = $o_hora_trabajo->getArrayDiasString();
                                foreach ($a_Horas_horario_flexible as $a_Horas_compor) {
                                    foreach ($a_Horas_compor as $key => $value) {
                                        if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                            $inidice = $value[0] . '.' . $value[1];
                                            if (!isset($a_temp[$inidice]['dias'])) {
                                                $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                            } else {
                                                $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                            }
                                            $a_temp[$inidice]['hora_inicio'] = $value[0];
                                            $a_temp[$inidice]['hora_fin'] = $value[1];
                                        }
                                    }
                                }
                                break;
                            case HORARIO_ROTATIVO:
                                $o_hora_trabajo = $t_persona->getHoraTrabajoObject();
                                $a_Horas_horario_rotativo = $o_hora_trabajo->getArrayDiasString();
                                foreach ($a_Horas_horario_rotativo as $a_Horas_compor) {
                                    foreach ($a_Horas_compor as $key => $value) {
                                        if (!is_null($value[0]) && $value[0] != '00:00:00') {
                                            $inidice = $value[0] . '.' . $value[1];
                                            if (!isset($a_temp[$inidice]['dias'])) {
                                                $a_temp[$inidice]['dias'] = $dias_red[$key] . ', ';
                                            } else {
                                                $a_temp[$inidice]['dias'] .= $dias_red[$key] . ', ';
                                            }
                                            $a_temp[$inidice]['hora_inicio'] = $value[0];
                                            $a_temp[$inidice]['hora_fin'] = $value[1];
                                        }
                                    }
                                }
                                break;
                        }

                        //echo"<pre>";	print_r($a_Horas_compor);echo"</pre>";
                        foreach ($a_temp as $value) {
                            $hora_trabajo .= rtrim($value['dias'], ', ') . ' - ' . $value['hora_inicio'] . ' - ' . $value['hora_fin'] . '</br>';
                        }
                        foreach ($a_temp as $value) {
                            if ($value['hora_inicio'] != '00:00:00' && $value['hora_fin'] != '00:00:00') {
                                $hora_trabajo_margen .=
                                    DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_inicio']) + $margen_llegada_tarde)) . ' - ' .
                                    DateTimeHelper::sec_to_time((DateTimeHelper::time_to_sec($value['hora_fin']) - $margen_salidas_temprano)) . '</br>';
                            } else {
                                $hora_trabajo_margen .= _('Pase sin limites') . '</br>';
                            }
                        }
                        $a_dias_vino[$t_persona->getId()]['Hora_Trabajo_Margen'] = $hora_trabajo_margen;
                        $a_dias_vino[$t_persona->getId()]['Hora_Trabajo'] = $hora_trabajo;
                        $a_dias_vino[$t_persona->getId()]['Hora_Trabajo_Detalle'] = $o_hora_trabajo->getDetalle();
                        $a_dias_vino[$t_persona->getId()]['fecha'] = array();
                    }
                }
            }
        }
        //printear($a_dias_vino);
        if (isset($UsarFechasWidget) && $UsarFechasWidget == true) {
            $fecha_inicio = $_SESSION['filtro']['fechaDw'];
            $fecha_fin = $_SESSION['filtro']['fechaHw'];
        } else {
            $fecha_inicio = $_SESSION['filtro']['fechaD'];
            $fecha_fin = $_SESSION['filtro']['fechaH'];
        }
        $contidad_dias = DateTimeHelper::diff_Fecha_En_Dias($fecha_inicio, $fecha_fin);
        	//echo $fecha_inicio; echo '<br>';
        	//echo $fecha_fin; echo '<br>';
            //echo $contidad_dias; echo '<br>';

        foreach ($a_dias_vino as $legajo => $persona) { // recorre las personas para ver que dias faltaron
            $t_fecha = date('Y-m-d', strtotime($_SESSION['filtro']['fechaD']));
            $o_Persona_o = Persona_L::obtenerPorId($persona['per_id'], true, false);
            if (!is_null($o_Persona_o)) {
                switch ($o_Persona_o->getHorTipo()) {
                    case HORARIO_NORMAL:
                        $a_Horario_Tabajo = $o_Persona_o->getHoraTrabajoObject()->getArrayDias();
                        //echo "<pre>"; print_r($a_Horario_Tabajo);echo "</pre>";
                        for ($i = 0; $i < $contidad_dias; $i++) {
                            if ($i != 0) {
                                $t_fecha = DateTimeHelper::Sum_Dias($t_fecha, '1');
                            }
                            if (!in_array($t_fecha, $persona['fecha'])) {

                                $dia_n = (date('w', strtotime($t_fecha)) + 1); // 1 (para domingo) hasta 7 (para sabado)

                                if (date('H:i', $a_Horario_Tabajo[$dia_n][0]) != '00:00' && date('H:i', $a_Horario_Tabajo[$dia_n][1]) != '00:00') {// dias que falto
                                    //echo '<br>'.$persona['per_id'] . ' -- '. $dia_n . ' -- '. $t_fecha.'-i-'.date('H:i', $a_Horario_Tabajo[$dia_n][0]).'-f-'.date('H:i', $a_Horario_Tabajo[$dia_n][1]).'-h-'.date('H:i').'-A-'.date('H:i',$a_Horario_Tabajo[$dia_n][0] + $margen_ausencia).'<br /> ';
                                    //echo '<br>H'.$a_Horario_Tabajo[$dia_n][0] + $margen_ausencia;
                                    //echo '<br>H'.strtotime(date('H:i'));
                                    //echo '<br>d'.$dia_n;
                                    //echo '<br>w'.date('w');
                                    if ((($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia) > strtotime(date('Y-m-d H:i:s'))) && $dia_n==(date('w')+1)) {
                                        continue; //Saco a las personas que todavia no tiene que ingresar a trabajar. (solo aplica para hoy)
                                    }
                                    if (isset ($_SESSION['filtro']['bloqueados']) && $_SESSION['filtro']['bloqueados'] == 'No' && $o_Persona_o->getEnabled()==0) {
                                        continue; //saco los bloqueado si el boton esta seleccionado por No listar
                                    }
                                    if (strtotime($t_fecha) > time()) {
                                        continue;  //Para que no marque como ausencia los dias futuros!
                                    }
                                    if ($o_Persona_o->getExcluir()) continue;
                                    $feriado = Feriado_L::obtenerPorDiayPersona($t_fecha, $o_Persona_o->getId());
                                    if (!is_null($feriado) && !empty($feriado)) continue;
                                    $licencia = Licencias_L::obtenerPorDiaCompletoyPersona($t_fecha, $o_Persona_o->getId());
                                    if (!is_null($licencia) && !empty($licencia)) continue;


                                    $a_aus[$legajo]['leg_ape_nomb'] = $persona['leg_ape_nomb'] . (($o_Persona_o->getEnabled()) ? '' : ' - ' . _('Bloqueado')); //.'---'.date('H:i', $a_Horario_Tabajo[$dia_n][0]).'---'.date('H:i', $a_Horario_Tabajo[$dia_n][1]).'---'.date('H:i');
                                    $a_aus[$legajo]['per_id'] = $persona['per_id'];
                                    $a_aus[$legajo]['Nombre'] = $o_Persona_o->getNombre();
                                    $a_aus[$legajo]['Apellido'] = $o_Persona_o->getApellido();
                                    $a_aus[$legajo]['Legajo'] = $o_Persona_o->getLegajo();
                                    $a_aus[$legajo]['horarios'] = $persona['horarios'];
                                    $a_aus[$legajo]['Hora_Trabajo_Margen'] = $persona['Hora_Trabajo_Margen'];
                                    $a_aus[$legajo]['Hora_Trabajo'] = $persona['Hora_Trabajo'];
                                    $a_aus[$legajo]['Hora_Trabajo_Detalle'] = $persona['Hora_Trabajo_Detalle'];
                                    $a_aus[$legajo]['fecha'][] = $t_fecha;

                                    // parte para csv
                                    $a_csv[] = array($legajo, $persona['ape_nomb'], $t_fecha);

                                }
                            }
                        }
                        break;
                    case HORARIO_FLEXIBLE:
                        $a_Horarios_Tabajo = $o_Persona_o->getHoraTrabajoObject()->getArrayDias();
                        //echo "<pre>"; print_r($a_Horario_Tabajo);echo "</pre>";
                        foreach ($a_Horarios_Tabajo as $a_Horario_Tabajo) {
                            for ($i = 0; $i < $contidad_dias; $i++) {
                                if ($i != 0) {
                                    $t_fecha = DateTimeHelper::Sum_Dias($t_fecha, '1');
                                }
                                if (!in_array($t_fecha, $persona['fecha'])) {

                                    $dia_n = (date('w', strtotime($t_fecha)) + 1); // 1 (para domingo) hasta 7 (para sabado)

                                    if (date('H:i', $a_Horario_Tabajo[$dia_n][0]) != '00:00' && date('H:i', $a_Horario_Tabajo[$dia_n][1]) != '00:00') {// dias que falto
                                        //echo $persona['per_id'] . ' -- '. $dia_n . ' -- '. $t_fecha.'-i-'.date('H:i', $a_Horario_Tabajo[$dia_n][0]).'-f-'.date('H:i', $a_Horario_Tabajo[$dia_n][1]).'-h-'.date('H:i').'-A-'.date('H:i',$a_Horario_Tabajo[$dia_n][0] + $margen_ausencia).'<br /> ';
                                        if ((($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia) > strtotime(date('Y-m-d H:i:s'))) && $dia_n==(date('w')+1)) {
                                            continue; //Saco a las personas que todavia no tiene que ingresar a trabajar. (solo aplica para hoy)
                                        }
                                        if (isset ($_SESSION['filtro']['bloqueados']) && $_SESSION['filtro']['bloqueados'] == 'No' && $o_Persona_o->getEnabled()==0) {
                                            continue; // saco los bloqueados si el boton esta seleccionado por No listar
                                        }
                                        if (strtotime($t_fecha) > time()) {
                                            continue;  //Para que no marque como ausencia los dias futuros!
                                        }
                                        if ($o_Persona_o->getExcluir()) continue;
                                        $feriado = Feriado_L::obtenerPorDiayPersona($t_fecha, $o_Persona_o->getId());
                                        if (!is_null($feriado) && !empty($feriado)) continue;
                                        $licencia = Licencias_L::obtenerPorDiaCompletoyPersona($t_fecha, $o_Persona_o->getId());
                                        if (!is_null($licencia) && !empty($licencia)) continue;


                                        $a_aus[$legajo]['leg_ape_nomb'] = $persona['leg_ape_nomb'] . (($o_Persona_o->getEnabled()) ? '' : ' - ' . _('Bloqueado')); //.'---'.date('H:i', $a_Horario_Tabajo[$dia_n][0]).'---'.date('H:i', $a_Horario_Tabajo[$dia_n][1]).'---'.date('H:i');
                                        $a_aus[$legajo]['per_id'] = $persona['per_id'];
                                        $a_aus[$legajo]['Nombre'] = $o_Persona_o->getNombre();
                                        $a_aus[$legajo]['Apellido'] = $o_Persona_o->getApellido();
                                        $a_aus[$legajo]['Legajo'] = $o_Persona_o->getLegajo();
                                        $a_aus[$legajo]['horarios'] = $persona['horarios'];
                                        $a_aus[$legajo]['Hora_Trabajo_Margen'] = $persona['Hora_Trabajo_Margen'];
                                        $a_aus[$legajo]['Hora_Trabajo'] = $persona['Hora_Trabajo'];
                                        $a_aus[$legajo]['Hora_Trabajo_Detalle'] = $persona['Hora_Trabajo_Detalle'];
                                        $a_aus[$legajo]['fecha'][] = $t_fecha;

                                        // parte para csv
                                        $a_csv[] = array($legajo, $persona['ape_nomb'], $t_fecha);

                                    }
                                }
                            }
                        }
                        break;
                    case HORARIO_ROTATIVO:
                        //$a_Horarios_Tabajo = $o_Persona_o->getHoraTrabajoObject()->getArrayDias();
                        $a_Horarios_Tabajo = $o_Persona_o->getHoraTrabajoObject()->getArrayDias(true,$t_fecha);
                        //echo "<pre>"; print_r($a_Horario_Tabajo);echo "</pre>";
                        foreach ($a_Horarios_Tabajo as $a_Horario_Tabajo) { //siempre va a ser 1, pero dejo el foreach para bajar un nivel de array
                       /*
                        if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) {
                            echo "<br>Arancando proceso de Horario Rotativo para:".$o_Persona_o->getNombreCompleto();
                            echo "<br>Cantidad Dias:".$contidad_dias;
                            echo "<br>t_fecha:".$t_fecha;
                            //echo "<br>Horario Detectado:";
                            //printear($a_Horario_Tabajo);
                        }
                       */
                            for ($i = 0; $i < $contidad_dias; $i++) {
                                if ($i != 0) {
                                    $t_fecha = DateTimeHelper::Sum_Dias($t_fecha, '1');
                                }
                                if (!in_array($t_fecha, $persona['fecha'])) {

                                    $dia_n = (date('w', strtotime($t_fecha)) + 1); // 1 (para domingo) hasta 7 (para sabado)

                                    if (date('H:i', $a_Horario_Tabajo[$dia_n][0]) != '00:00' && date('H:i', $a_Horario_Tabajo[$dia_n][1]) != '00:00') {// dias que falto
                                        //echo $persona['per_id'] . ' -- '. $dia_n . ' -- '. $t_fecha.'-i-'.date('H:i', $a_Horario_Tabajo[$dia_n][0]).'-f-'.date('H:i', $a_Horario_Tabajo[$dia_n][1]).'-h-'.date('H:i').'-A-'.date('H:i',$a_Horario_Tabajo[$dia_n][0] + $margen_ausencia).'<br /> ';
                                    /*
                                        if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) {
                                            echo "persona:" . $o_Persona_o->getNombreCompleto();echo "<br>";
                                            echo "horario hoy:" . date('Y-m-d H:i:s', $a_Horario_Tabajo[$dia_n][0]);echo "<br>";
                                            echo "horario + margen:" . date('Y-m-d H:i:s', ($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia));echo "<br>";
                                            echo "horario de ahora:" . date('Y-m-d H:i:s', strtotime(date('H:i'))); echo "<br>";
                                            echo "dia de la semana:" . $dia_n; echo "<br>";
                                            echo "dia de la semana segun date:" . date('w'); echo "<br>";
                                            echo "<br>";echo "<br>";
                                        }
                                    */
                                        if ((($a_Horario_Tabajo[$dia_n][0] + $margen_ausencia) > strtotime(date('Y-m-d H:i:s'))) && $dia_n==(date('w')+1)) {
                                            continue; //Saco a las personas que todavia no tienen que ingresar a trabajar. (solo aplica para hoy)
                                        }
                                        if (isset ($_SESSION['filtro']['bloqueados']) && $_SESSION['filtro']['bloqueados'] == 'No' && $o_Persona_o->getEnabled()==0) {
                                            continue; // saco los bloqueados si el boton esta seleccionado por No listar
                                        }
                                        if (strtotime($t_fecha) > time()) {
                                            continue;  //Para que no marque como ausencia los dias futuros!
                                        }
                                        if ($o_Persona_o->getExcluir()) continue;
                                        $feriado = Feriado_L::obtenerPorDiayPersona($t_fecha, $o_Persona_o->getId());
                                        if (!is_null($feriado) && !empty($feriado)) continue;
                                        $licencia = Licencias_L::obtenerPorDiaCompletoyPersona($t_fecha, $o_Persona_o->getId());
                                        if (!is_null($licencia) && !empty($licencia)) continue;


                                        $a_aus[$legajo]['leg_ape_nomb'] = $persona['leg_ape_nomb'] . (($o_Persona_o->getEnabled()) ? '' : ' - ' . _('Bloqueado')); //.'---'.date('H:i', $a_Horario_Tabajo[$dia_n][0]).'---'.date('H:i', $a_Horario_Tabajo[$dia_n][1]).'---'.date('H:i');
                                        $a_aus[$legajo]['per_id'] = $persona['per_id'];
                                        $a_aus[$legajo]['Nombre'] = $o_Persona_o->getNombre();
                                        $a_aus[$legajo]['Apellido'] = $o_Persona_o->getApellido();
                                        $a_aus[$legajo]['Legajo'] = $o_Persona_o->getLegajo();
                                        $a_aus[$legajo]['horarios'] = $persona['horarios'];
                                        $a_aus[$legajo]['Hora_Trabajo_Margen'] = $persona['Hora_Trabajo_Margen'];
                                        $a_aus[$legajo]['Hora_Trabajo'] = $persona['Hora_Trabajo'];
                                        $a_aus[$legajo]['Hora_Trabajo_Detalle'] = $persona['Hora_Trabajo_Detalle'];
                                        $a_aus[$legajo]['fecha'][] = $t_fecha;

                                        // parte para csv
                                        $a_csv[] = array($legajo, $persona['ape_nomb'], $t_fecha);

                                    }
                                }
                            }
                        }
                        break;
                }

            }
            //echo ' <br /><br /> ';
        }
        //printear($a_aus);

//echo $T_Tipo;
        //esto es solo para el widget_ausencias
        if ($T_Tipo=='mod_Ausencias') {
            if (!is_null($a_aus)) {
                $per_Leg = '';
                $a_mod = null;
                //printear($a_aus);
                foreach ($a_aus as $item) {
                    //printear($item);
                    if ($per_Leg != $item['per_id']) {
                        if (Config_L::p('usar_legajo'))
                            $a_mod[$item['per_id']]['leg_ape_nomb'] = htmlentities($item['Legajo'] . ' - ' . $item['Nombre'] . ' ' . $item['Apellido'], ENT_QUOTES, 'utf-8');
                        else
                            $a_mod[$item['per_id']]['leg_ape_nomb'] = htmlentities($item['Nombre']. ' ' . $item['Apellido'], ENT_QUOTES, 'utf-8');
                        $a_mod[$item['per_id']]['per_Id'] = htmlentities($item['per_id'], ENT_QUOTES, 'utf-8');
                        $a_mod[$item['per_id']]['cant'] = 0;
                        $contadordeausenciasporpersona=0;  //alto nombre
                        foreach($item['fecha'] as $fechadeausencia){
                            $contadordeausenciasporpersona++;
                        }
                        $a_mod[$item['per_id']]['cant']=$contadordeausenciasporpersona;
                    }
                    //$a_mod[$item['per_id']]['cant'] += 1;
                    $per_Leg = $item['per_id'];

                }
            }
            //echo "<pre>"; print_r($a_mod); echo "</pre>";
        }
        break;


    default:

        break;
}





	