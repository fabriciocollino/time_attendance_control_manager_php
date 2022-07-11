<?php

class Grupos_Personas_L
{

    public static function obtenerPorId($pId) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $pId = (integer)$pId;

        $row = $cnn->Select_Fila("SELECT * FROM grupos_personas WHERE gpe_Id = ? ORDER BY gpe_Id", array($pId));
        $object = null;

        if (!empty($row)) {
            $object = new Grupos_Personas_O();
            $object->loadArray($row);
        }

        if ($row === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $object;
    }

    public static function obtenerPorPerIdyGrupo($perId, $Grupo) {

        $cnn = Registry::getInstance()->DbConn;

        $perId = (integer)$perId;
        $Grupo = (integer)$Grupo;

        $row = $cnn->Select_Fila("SELECT * FROM grupos_personas WHERE gpe_Per_Id =" . $perId . " AND gpe_Grupo_Id=" . $Grupo . " ORDER BY gpe_Id");

        $object = null;

        if (!empty($row)) {
            $object = new Grupos_Personas_O();
            $object->loadArray($row);
        }

        if ($row === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $object;
    }

    public static function obtenerPorPersona($perId) {

        $cnn = Registry::getInstance()->DbConn;

        $perId = (integer)$perId;


        $rows = $cnn->Select_Lista("SELECT * FROM grupos_personas WHERE gpe_Per_Id =" . $perId . " ORDER BY gpe_Id");
        $list = array();
        $object = null;

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupos_Personas_O();
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

    public static function obtenerARRAYPorPersona($perId) {


        $cnn = Registry::getInstance()->DbConn;

        $perId = (integer)$perId;


        $rows = $cnn->Select_Lista("SELECT * FROM grupos_personas WHERE gpe_Per_Id =" . $perId . " ORDER BY gpe_Id");

        $object = null;
        $a_salida = array();
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupos_Personas_O();
                $object->loadArray($row);
                $list[] = $object;
                $a_salida[] = $object->getGrupo();
            }
        } else {
            $a_salida[] = null;
        }

        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $a_salida;
    }


    public static function obtenerARRAYPorGrupo($grupoId) {


        $cnn = Registry::getInstance()->DbConn;

        $grupoId = (integer)$grupoId;


        $rows = $cnn->Select_Lista("SELECT * FROM grupos_personas WHERE gpe_Grupo_Id =" . $grupoId . " ORDER BY gpe_Id");

        $object = null;
        $a_salida = array();
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupos_Personas_O();
                $object->loadArray($row);
                $list[] = $object;
                $a_salida[] = $object->getPersona();
            }
        } else {
            $a_salida[] = null;
        }

        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $a_salida;
    }

    public static function obtenerARRAYEmailsPorGrupo($grupoId) {


        $cnn = Registry::getInstance()->DbConn;

        $grupoId = (integer)$grupoId;


        $rows = $cnn->Select_Lista("SELECT * FROM grupos_personas WHERE gpe_Grupo_Id =" . $grupoId . " ORDER BY gpe_Id");

        $object = null;
        $a_salida = array();
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupos_Personas_O();
                $object->loadArray($row);
                $list[] = $object;
                $o_persona=Persona_L::obtenerPorId($object->getPersona());
                $a_salida[] = $o_persona->getEmail();
            }
        } else {
            $a_salida[] = null;
        }

        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $a_salida;
    }

    public static function obtenerPorGrupo($Grupo) {

        $cnn = Registry::getInstance()->DbConn;

        $Grupo = (integer)$Grupo;

        $row = $cnn->Select_Fila("SELECT * FROM grupos_personas WHERE gpe_Grupo_Id=" . $Grupo . " ORDER BY gpe_Id");

        $object = null;

        if (!empty($row)) {
            $object = new Grupos_Personas_O();
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

        $rows = $cnn->Select_Lista("SELECT * FROM grupos_personas ORDER BY gpe_Id");
        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupos_Personas_O();
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


    //esta funcion puede estar duplicada
    //
    public static function obtenerListaPorGrupo($grupo) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT * FROM grupos_personas WHERE gpe_Grupo_Id=" . $grupo . " ORDER BY gpe_Id");
        $object = null;
        $list = array();

        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = new Grupos_Personas_O();
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


    //devuelve un array con los objeto personas
    //
    public static function obtenerPersonasPorGrupo($grupo) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $rows = $cnn->Select_Lista("SELECT gpe_Per_Id FROM grupos_personas WHERE gpe_Grupo_Id=" . $grupo . " ORDER BY gpe_Per_Id");
        $object = null;
        $list = array();


        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $object = Persona_L::obtenerPorId($row['gpe_Per_Id']);
                $list[] = $object;
            }
        }

        if ($rows === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $list;
    }

    //devuelve un entero con la cantidad de personas por grupo
    //
    public static function obtenerCantidadPersonasPorGrupo($grupo) {
        /* @var $cnn mySQL */


        $cnn = Registry::getInstance()->DbConn;

        $grupo = (integer)$grupo;

        $row = $cnn->Select_Fila("SELECT COUNT(gpe_Per_Id) FROM grupos_personas WHERE gpe_Grupo_Id=" . $grupo . " ORDER BY gpe_Per_Id");

        $cantidad = null;

        if (!empty($row)) {
            $cantidad = $row['COUNT(gpe_Per_Id)'];
        }

        if ($row === false) { // devuelve el error si algo fallo con MySql
            echo $cnn->get_Error(Registry::getInstance()->general['debug']);
        }

        return $cantidad;

    }



    public static function checkIfPersonaGrupo($p_Persona,$p_Grupo){
        $a_Grupos_Personas = Grupos_Personas_L::obtenerARRAYPorGrupo($p_Grupo);
        if (in_array($p_Persona, $a_Grupos_Personas))
            return true;
        else
            return false;
    }


    public static function eliminarPersonaDeTodosLosGrupos($perId) {

        $cnn = Registry::getInstance()->DbConn;

        $perId = (integer)$perId;


        $resultado = $cnn->Query("DELETE FROM grupos_personas WHERE gpe_Per_Id =" . $perId);

        if ($resultado === false) {
            return false;
        }

        return false;
    }


}
