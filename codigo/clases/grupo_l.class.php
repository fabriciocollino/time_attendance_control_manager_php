<?php

class Grupo_L
{

    public static function obtenerPorId($pId) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $pId = (integer)$pId;

        $row = $cnn->Select_Fila("SELECT * FROM grupos WHERE gru_Id = ? ORDER BY gru_Id", array($pId));
        $object = null;

        if (!empty($row)) {
            $object = new Grupo_O();
            $object->loadArray($row);
        }

        if ($row === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $object;
    }

    public static function obtenerPorDetalle($p_Detalle, $p_Id = '') {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;


        if ($p_Id != '') {
            $p_Id = 'AND gru_Id <> ' . (int)$p_Id;
        } else {
            $p_Id = "";
        }

        $row = $cnn->Select_Fila("SELECT * FROM grupos WHERE gru_Detalle = ? {$p_Id} ORDER BY gru_Id", array($p_Detalle));
        $object = null;

        if (!empty($row)) {
            $object = new Grupo_O();
            $object->loadArray($row);
        }

        if ($row === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $object;
    }

    public static function obtenerTodos() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM grupos ORDER BY gru_Id");
        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupo_O();
                $object->loadArray($row);
                $list[] = $object;
            }
        } else {
            $list = null;
        }

        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $list;
    }

    public static function obtenerTodosEnVivo() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM grupos WHERE gru_En_Vivo=1 ORDER BY gru_Id");
        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupo_O();
                $object->loadArray($row);
                $list[] = $object;
            }
        } else {
            $list = null;
        }

        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $list;
    }

    public static function obtenerTodosARRAY() {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM grupos ORDER BY gru_Id");
        $object = null;
        $list = array();

        $a_salida = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupo_O();
                $object->loadArray($row);
                $list[] = $object;
                $a_salida[] = $object->getId();
            }
        } else {
            $list = null;
        }

        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $a_salida;
    }

    public static function obtenerListaEmailsPorId($p_Id) {

        return Grupos_Personas_L::obtenerARRAYEmailsPorGrupo($p_Id);
    }

}
