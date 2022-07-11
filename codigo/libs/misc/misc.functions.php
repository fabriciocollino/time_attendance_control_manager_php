<?php


function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


function printear($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function printearenproduccion($array){
    if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) {
        printear($array);
    }
}

function echoenproduccion($text){
    if (Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() >= 999) {
        echo($text);
    }
}


function dedoAstring($dedo){
    switch ($dedo){
        case LEFT_THUMB: return "Pulgar Izquierdo";
        case LEFT_INDEX: return "Índice Izquierdo";
        case LEFT_MIDDLE: return "Medio Izquierdo";
        case LEFT_RING: return "Anular Izquierdo";
        case LEFT_LITTLE: return "Meñique Izquierdo";
        case RIGHT_THUMB: return "Pulgar Derecho";
        case RIGHT_INDEX: return "Índice Derecho";
        case RIGHT_MIDDLE: return "Medio Derecho";
        case RIGHT_RING: return "Anular Derecho";
        case RIGHT_LITTLE: return "Meñique Derecho";
    }
    return "";
}


function formatBytes($size, $precision = 2){
    $base = log($size, 1024);
    $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}



