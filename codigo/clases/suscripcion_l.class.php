<?php

class Suscripcion_L {

    public static function obtenerPorId($p_Id){

        $cnn = Registry::getInstance() -> DbConnMGR;

        $p_Id = (integer)$p_Id;

        $row = $cnn -> Select_Fila("SELECT * FROM suscripciones WHERE susc_Id = ? ORDER BY susc_Id", array($p_Id));

        $object = null;
        if (!empty($row)) {
            $object = new Suscripcion_O();
            $object -> loadArray($row);
        }

        if ($row === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return $object;
    }

    public static function obtenerTodos($p_Condicion = '', $p_Tablas = ''){

        $cnn = Registry::getInstance() -> DbConnMGR;

        if ($p_Condicion != '') {
            $p_Condicion = 'WHERE ' . $p_Condicion;
        }

        if ($p_Tablas != '') {
            $p_Tablas = ', ' . $p_Tablas;
        }

        $rows = $cnn -> Select_Lista("SELECT * FROM suscripciones {$p_Tablas} {$p_Condicion} ORDER BY susc_Id");

        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Suscripcion_O();
                $object -> loadArray($row);
                $list[$object->getId()] = $object;
            }
        }
        if ($rows === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return $list;
    }

    public static function obtenerTodosArray(){

        $cnn = Registry::getInstance() -> DbConnMGR;

        $rows = $cnn -> Select_Lista("SELECT * FROM suscripciones  ORDER BY susc_Id");

        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $list[$row['susc_Id']] = $row;
            }
        } else {
            $list = $object;
        }
        if ($rows === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return $list;
    }

    public static function obtenerPorIdMercadoPago($p_Id)
    {

        $cnn = Registry::getInstance()->DbConnMGR;


        $row = $cnn->Select_Fila("SELECT * FROM suscripciones WHERE susc_preapproval_id = ? ORDER BY susc_Id", array($p_Id));

        $object = null;
        if (!empty($row)) {
            $object = new Suscripcion_O();
            $object->loadArray($row);
        }

        if ($row === false) {// devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $object;
    }

    public static function obtenerTodosPorClienteId($p_Id){

        $cnn = Registry::getInstance() -> DbConnMGR;

        $p_Id = (integer)$p_Id;

        $rows = $cnn -> Select_Lista("SELECT * FROM suscripciones WHERE susc_Cliente = {$p_Id} ORDER BY susc_Id DESC");


        $list = array();

        if ($rows) {
            foreach ($rows as $row) {
                $object = new Suscripcion_O();
                $object -> loadArray($row);
                $list[$object->getId()] = $object;
            }
        }

        if ($rows === false) {// devuelve el error si algo fallo con MySql
            echo $cnn -> get_Error(Registry::getInstance() -> general['debug']);
        }

        return $list;
    }

}