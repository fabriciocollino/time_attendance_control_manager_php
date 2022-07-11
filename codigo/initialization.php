<?php

/*
 * Archivo de inicialización.
 */

require dirname(__FILE__) . '/../vendor/autoload.php';

header('Content-Type: text/html; charset=utf-8');

if (basename($_SERVER['PHP_SELF']) == 'initialization.php') {
    die('Acceso incorrecto a la aplicación.');
}

define('APP_PATH', dirname(__FILE__));
define('DATA_PATH', APP_PATH . '/data');



require_once(APP_PATH . '/libs/misc/registry.class.php');
require_once(APP_PATH . '/libs/misc/https.functions.php');
require_once(APP_PATH . '/libs/misc/misc.functions.php');
require_once(APP_PATH . '/libs/sesiones/sessions.php');


$http_s = "";
if (isHTTPS())
    $http_s = "https";
else
    $http_s = "http";


//Cargamos el archivo de configuración al Registro de la Aplicación
$Registry = Registry::getInstance(dirname(__FILE__) . '/config/configuration.ini');

define('WEB_ROOT', $Registry->general['web_root']);

define('GAE', $Registry->general['gae']);




$array_dominio = explode(".", $_SERVER['HTTP_HOST']);
$subdominio_inseguro = array_shift($array_dominio);
global $subdominio;
$subdominio = preg_replace("/[^a-zA-Z0-9]+/", "", $subdominio_inseguro);


define('GS_TEMP_BUCKET', 'gs://enpunto/temp/');
define('GS_CLIENTS_BUCKET', 'gs://enpunto/clients/');
define('GS_CLIENT_BUCKET', 'gs://enpunto/clients/' . $subdominio . "/");
define('GS_CLIENT_SESSIONS', GS_CLIENT_BUCKET . 'sesiones/');
define('GS_CLIENT_IMAGES_PERSONAS', GS_CLIENT_BUCKET . 'imagenes/personas/');
define('GS_CLIENT_IMAGES_LOGO', GS_CLIENT_BUCKET . 'imagenes/logo/');
define('GS_CLIENT_IMAGES_USUARIOS', GS_CLIENT_BUCKET . 'imagenes/usuarios/');
define('GS_CLIENT_TEMP_FOLDER', GS_CLIENT_BUCKET . 'temp/');


define('ACCESS_TOKEN_MERCADOPAGO_SUSCRIPCIONES', 'APP_USR-1659178055922851-080106-e68d9d6057977d7357a4517760162c5f-239560895');


//Quitar el problema de tener magic_quotes_gpc en On
//http://stackoverflow.com/questions/517008/how-to-turn-off-magic-quotes-on-shared-hosting
if (in_array(strtolower(ini_get('magic_quotes_gpc')), array('1', 'on'))) {
//  $_POST = array_map( 'stripslashes', $_POST );
    $_GET = array_map('stripslashes', $_GET);
    $_REQUEST = array_map('stripslashes', $_REQUEST);
    $_COOKIE = array_map('stripslashes', $_COOKIE);
}
//--
//Dependiendo de la configuración establezco si se mostrarán o no los errores.
//if ($Registry->general['debug']) {
if ($subdominio == 'dev' || $subdominio == 'manager') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
    ini_set('log_errors', 0);
} else {
    ini_set('display_errors', 0);
    error_reporting(E_ALL & ~E_DEPRECATED);
    ini_set('log_errors', 1);
    ini_set('error_log', $Registry->general['error_log']);
}


//Estableciendo la conexión de la BD con clases mySQL
require_once($Registry->general['library_path'] . '/mysql/mysql.class.php');
$G_DbConnMGR = new mySQL(
    $Registry->database['db_name'],
    $Registry->database['db_user'],
    $Registry->database['db_pass'],
    $Registry->database['db_host'],
    $Registry->database['db_port']
);

if (!$G_DbConnMGR->ConectarSocket()) {
    die($G_DbConnMGR->get_Error($Registry->general['debug']));
}



//Guardamos la Conexión en el Registro
$Registry->DbConnMGR = $G_DbConnMGR;


spl_autoload_register(function ($class_name) {
    $Registy = Registry::getInstance();
    foreach ($Registy->autoload['paths'] as $path) {
        $filepath = $path . '/' . strtolower($class_name) . '.class.php';

        if (is_file($filepath)) {
            require_once $filepath;
            break;
        }
    }
});


//PLANES
define('PLAN_BASICO', 1);
define('PLAN_PLUS', 2);
define('PLAN_PREMIUM', 3);


$Registry->DbConn = $G_DbConnMGR;


if($subdominio!="manager") {
    foreach (array_keys($_REQUEST) as $key) {
        if (!is_array($_REQUEST[$key])) {
            //echo $key;
            $variable = $_REQUEST[$key];
            $temp_re = mysqli_real_escape_string($Registry->DbConn->getLink(), $variable);
            $temp_r = str_replace(array("<", ">", "[", "]", "*", "^", "="), "", $temp_re);
            $_REQUEST [$key] = $temp_r;
            echo "$_REQUEST:".$key."->".$_REQUEST [ $key ];
        }
    }
    foreach (array_keys($_GET) as $key) {
        if (!is_array($_GET[$key])) {
            //echo $key;
            $variable = $_GET[$key];
            $temp_re = mysqli_real_escape_string($Registry->DbConn->getLink(), $variable);
            $temp_r = str_replace(array("<", ">", "[", "]", "*", "^", "="), "", $temp_re);
            $_GET [$key] = $temp_r;
            echo "$_GET:".$key."->".$_GET [ $key ];
        }
    }
}

//Configuración de la sesión
$sessioName = $Registry->session['name'];
session_name($sessioName);
session_set_cookie_params(0);

session_start();

if ($Registry->session['lifetime'] > 0 && isset($_COOKIE[$sessioName])) {
    $cookieParams = session_get_cookie_params();
    $cookieParams['httponly'] = isset($cookieParams['httponly']) ? $cookieParams['httponly'] : false;
    setcookie(session_name(), session_id(), time() + $Registry->session['lifetime'], $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
}


function _($variable) {
    return $variable;
}
$language = 'es_AR.utf8';
setlocale(LC_ALL, $language);




//--
//Verificar si el Usuario ha iniciado sesión, en caso de que no haya iniciado sesión
//enviarlo a la página de login.
$T_Error = '';
$necesitaIniciarSesion = false;
$o_Usuario = null;
if (!isset($_SESSION['USUARIO'])) {
    $necesitaIniciarSesion = true;
} elseif (isset($_SESSION['USUARIO'])) {
    $o_Usuario = Usuario_L::obtenerPorId($_SESSION['USUARIO']['id']);
    if (is_null($o_Usuario)) {
        SeguridadHelper::Bloqueardo($_SESSION['USUARIO']['id'], _('Usuario Bloqueado.'));
        $_SESSION = array();
        $necesitaIniciarSesion = true;
        $T_Error = _('Usuario temporalmente bloqueado.');
    } else {//login correcto
        $Registry->Usuario = $o_Usuario;
    }
}


if (basename($_SERVER['PHP_SELF']) == 'cron_notificaciones.php' || basename($_SERVER['PHP_SELF']) == 'password.php') {
    //pasa solo si viende de la pagina sync_o.php o cron.php


} else {

    if ($necesitaIniciarSesion && basename($_SERVER['PHP_SELF']) != 'login.php') {
        SeguridadHelper::Entrar();

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            die('login');
        }else{
            header('Location: ' . WEB_ROOT . '/login');
        }

        exit();
    } else {

    }


}


unset($Registry, $o_Usuario);


$a_Acciones = array(_('Crear'), _('Modificar'), _('Habilitar'), _('Bloquear'), _('Agregar'), _('Quitar'), _('Eliminar'), _('Borrar'), _('Reiniciar'), _('Re-Enviar'), _('Re-Sync'), _('Backup'), _('JavaScript'));
$a_Salida = array(1 => 'S-01', 'S-02', 'S-03', 'S-04', 'S-05', 'S-06', 'S-07', 'S-08');
$a_Lector = array(1 => 'L-01', 'L-02', 'L-03', 'L-04', 'L-05', 'L-06', 'L-07', 'L-08');
$a_Pulsador = array(1 => 'P-01', 'P-02', 'P-03', 'P-04', 'P-05', 'P-06', 'P-07', 'P-08');


$a_Notificaciones_Tipos = array(
    1 => _("Email"),
    _("Mensaje de Inicio"),
    _("Llamada IP")
);

$a_Notificaciones_Contenidos_Tipos = array(
    1 => _("Aviso"),
    _("Reporte")
);

$a_Notificaciones_Contenidos_Intervalos = array(
    1 => _("Dia"),
    _("Semana"),
    _("Quincena"),
    _("Mes"),
    _("Año")
);

$a_Notificaciones_Contenidos_Repetir = array(
    _("Única Vez"),
    _("Diariamente"),
    _("Semanalmente"),
    _("Quincenalmente"),
    _("Mensualmente"),
    _("Anualmente")
);


$dias = array(_("Domingo"), _("Lunes"), _("Martes"), _("Miércoles"), _("Jueves"), _("Viernes"), _("Sábado"));
$dias_red = array(_("Dom."), _("Lun."), _("Mar."), _("Mié."), _("Jue."), _("Vie."), _("Sáb."));
$meses = array(_("Enero"), _("Febrero"), _("Marzo"), _("Abril"), _("Mayo"), _("Junio"), _("Julio"), _("Agosto"), _("Septiembre"), _("Octubre"), _("Noviembre"), _("Diciembre"));
$a_meses = array(1 => _("Enero"), _("Febrero"), _("Marzo"), _("Abril"), _("Mayo"), _("Junio"), _("Julio"), _("Agosto"), _("Septiembre"), _("Octubre"), _("Noviembre"), _("Diciembre"));
$a_dias = array(1 => _('Domingo'), _('Lunes'), _('Martes'), _('Miércoles'), _('Jueves'), _('Viernes'), _('Sábado'));
$a_abr_dias = array(1 => "Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");

$IntervalosFechas = array(
    'F_Hoy' => _("Hoy"),
    'F_Semana' => _("Esta Semana"),
    'F_Quincena' => _("Esta Quincena"),
    'F_Mes' => _("Este Mes"),
//'F_Ano' =>_("Este Año"), 
    'F_Personalizado' => _("Personalizado:")
);


$SelectorMinutosHoras = array(
    'F_Minutos' => _("Minutos"),
    'F_Horas' => _("Horas")
);

$IntervalosLlegadaTardeLicencias = array(
    'F_15' => _("15 Minutos"),
    'F_30' => _("30 Minutos"),
    'F_1' => _("1 Hora"),
    'F_2' => _("2 Horas"),
    'F_Personalizado' => _("Personalizado:")
);

$IntervalosSalidaTempranoLicencias = array(
    'F_15' => _("15 Minutos"),
    'F_30' => _("30 Minutos"),
    'F_1' => _("1 Hora"),
    'F_2' => _("2 Horas"),
    'F_3' => _("3 Horas"),
    'F_Personalizado' => _("Personalizado:")
);

if (!isset($_SESSION['js'])) {
    $_SESSION['js'] = 1;
    $_SESSION['count'] = 0;
}

$rutaBackup = APP_PATH . '/../backups';
$webRutaBackup = WEB_ROOT . '/backups';


/* * *******************************************
 * NOTIFICACIONES
 * DISPARADORES
 * 
 * ******************************************* */
define('NOT_REINICIO_EQUIPO', 180);
define('NOT_PERDIDA_DE_CONEXION', 200);

define('NOT_LLEGADA_TARDE', 500);
define('NOT_LLEGADA_TEMPRANA', 520);
define('NOT_SALIDA_TARDE', 540);
define('NOT_SALIDA_TEMPRANA', 560);
define('NOT_AUSENCIA', 580);
define('NOT_TRACKING_PERSONA', 600);


$Notificaciones_Disparadores = array(
    NOT_LLEGADA_TARDE => _("Llegada Tarde"),
    NOT_LLEGADA_TEMPRANA => _("Llegada Temprana"),
    NOT_SALIDA_TARDE => _("Salida Tarde"),
    NOT_AUSENCIA => _("Ausencias"),
    NOT_PERDIDA_DE_CONEXION => _("Pérdida de conexión con Equipo")
);


/*********************************************
 * NOTIFICACIONES
 * CONTENIDO
 *
 *********************************************/
define('NOT_REPORTE_DE_PERSONA', 10);
define('NOT_REPORTE_DE_EQUIPO', 12);
define('NOT_REPORTE_DE_LLEGADA_TARDE', 19);
define('NOT_REPORTE_DE_ENTRADAS_SALIDAS', 20);
define('NOT_REPORTE_DE_DIAS_HORAS_TRABAJADAS', 21);
define('NOT_REPORTE_DE_AUSENCIAS', 22);


$Notificaciones_Contenidos = array(
    NOT_REPORTE_DE_LLEGADA_TARDE => _("Reporte de Llegadas Tarde"),
    NOT_REPORTE_DE_ENTRADAS_SALIDAS => _("Reporte de Entradas/Salidas"),
    NOT_REPORTE_DE_DIAS_HORAS_TRABAJADAS => _("Reporte de Días/Horas Trabajadas"),
    NOT_REPORTE_DE_AUSENCIAS => _("Reporte de Ausencias"),
    NOT_REPORTE_DE_EQUIPO => _("Reporte por Equipo")
);


define('MOD_TK_822_F', 5);
$Equipos_Modelos = array(
    MOD_TK_822_F => _("TK-822F")

);


//echo 'FechaD: '.$_SESSION['filtro']['fechaD'].'<br>';
//echo 'FechaH: '.$_SESSION['filtro']['fechaH'];


//Definiciones DEDOS
define('LEFT_THUMB', 1);
define('LEFT_INDEX', 2);
define('LEFT_MIDDLE', 3);
define('LEFT_RING', 4);
define('LEFT_LITTLE', 5);
define('RIGHT_THUMB', 6);
define('RIGHT_INDEX', 7);
define('RIGHT_MIDDLE', 8);
define('RIGHT_RING', 9);
define('RIGHT_LITTLE', 10);


$Intervalos_De_Horarios_Rotativos_Repetitivos = array(
    1 => _("1"),
    _("2"),
    _("3"),
    _("4"),
    _("5"),
    _("6")
);


if (Config_L::p('usar_horarios_flexibles')) {
    $a_Tipos_De_Horario = array(
        1 => _("Horario Normal"),
        2 => _("Horario Flexible"),
        3 => _("Horario Rotativo")
    );
} else {
    $a_Tipos_De_Horario = array(
        1 => _("Horario Normal"),
        3 => _("Horario Rotativo")
    );
}
//Definiciones HORARIOS
define('HORARIO_NORMAL', 1);
define('HORARIO_FLEXIBLE', 2);
define('HORARIO_ROTATIVO', 3);


//Definiciones de Licencias
define('LICENCIA_LLEGADA_TARDE', 1);
define('LICENCIA_SALIDA_TEMPRANO', 2);
define('LICENCIA_DIA_COMPLETO', 3);
define('LICENCIA_PERSONALIZADA', 4);

$a_Licencias_Tipos = array(
    LICENCIA_LLEGADA_TARDE => 'Llegada Tarde',
    LICENCIA_SALIDA_TEMPRANO => 'Salida Temprano',
    LICENCIA_DIA_COMPLETO => 'Día Completo',
    LICENCIA_PERSONALIZADA => 'Personalizada'
);


define('FERIADO_DIA_COMPLETO', 1);
define('FERIADO_PERIODO', 2);

$IntervalosFechasFeriados = array(
    FERIADO_DIA_COMPLETO => _("Día Completo:"),
    FERIADO_PERIODO => _("Personalizado:")
);


//Definiciones TIPOS DE LOG WEB
define('LOG_PERSONA_CREAR', 1);
define('LOG_PERSONA_EDITAR', 2);
define('LOG_PERSONA_ELIMINAR', 3);
define('LOG_PERSONA_BLOQUEAR', 4);
define('LOG_PERSONA_DESBLOQUEAR', 5);

define('LOG_USUARIO_CREAR', 20);
define('LOG_USUARIO_EDITAR', 21);
define('LOG_USUARIO_ELIMINAR', 22);
define('LOG_USUARIO_BLOQUEAR', 23);
define('LOG_USUARIO_DESBLOQUEAR', 24);

define('LOG_HORARIO_ROTATIVO_CREAR', 40);
define('LOG_HORARIO_ROTATIVO_EDITAR', 41);
define('LOG_HORARIO_ROTATIVO_ELIMINAR', 42);

define('LOG_HORARIO_FLEXIBLE_CREAR', 50);
define('LOG_HORARIO_FLEXIBLE_EDITAR', 51);
define('LOG_HORARIO_FLEXIBLE_ELIMINAR', 52);

define('LOG_HORARIO_NORMAL_CREAR', 60);
define('LOG_HORARIO_NORMAL_EDITAR', 61);
define('LOG_HORARIO_NORMAL_ELIMINAR', 62);

define('LOG_LICENCIA_CREAR', 70);
define('LOG_LICENCIA_EDITAR', 71);
define('LOG_LICENCIA_ELIMINAR', 72);

define('LOG_FERIADO_CREAR', 80);
define('LOG_FERIADO_EDITAR', 81);
define('LOG_FERIADO_ELIMINAR', 82);

define('LOG_GRUPO_CREAR', 90);
define('LOG_GRUPO_EDITAR', 91);
define('LOG_GRUPO_ELIMINAR', 92);

define('LOG_TRANSACCION_CHECKOUT_OK', 100);
define('LOG_TRANSACCION_CHECKOUT_ERROR', 101);
define('LOG_SUSCRIPCION_CHECKOUT_OK', 102);
define('LOG_SUSCRIPCION_CHECKOUT_ERROR', 103);

define('LOG_API_ACTIVAR', 120);
define('LOG_API_GENERAR_KEY', 121);
define('LOG_API_REGENERAR_KEY', 122);
define('LOG_API_DESACTIVAR', 123);
define('LOG_API_MODO_DE_PRUEBAS_ON', 124);
define('LOG_API_MODO_DE_PRUEBAS_OFF', 125);

define('LOG_HUELLA_ENROLL_START', 160);
define('LOG_HUELLA_DELETE', 161);
define('LOG_HUELLA_ENROLL_OK', 162);
define('LOG_HUELLA_ENROLL_CANCEL', 163);

define('LOG_RFID_READ_START', 170);
define('LOG_RFID_DELETE', 171);
define('LOG_RFID_READ_OK', 172);
define('LOG_RFID_READ_CANCEL', 173);
define('LOG_RFID_READ_ERROR', 174);



//array de tipos de log

$a_Logs_Tipos = array(
    LOG_PERSONA_CREAR => 'Persona - Creada',
    LOG_PERSONA_EDITAR => 'Persona - Editada',
    LOG_PERSONA_ELIMINAR => 'Persona - Eliminada',
    LOG_PERSONA_BLOQUEAR => 'Persona - Bloqueada',
    LOG_PERSONA_DESBLOQUEAR => 'Persona - Desbloqueada',
    LOG_USUARIO_CREAR => 'Usuario - Creado',
    LOG_USUARIO_EDITAR => 'Usuario - Editado',
    LOG_USUARIO_ELIMINAR => 'Usuario - Eliminado',
    LOG_USUARIO_BLOQUEAR => 'Usuario - Bloqueado',
    LOG_USUARIO_DESBLOQUEAR => 'Usuario - Desbloqueado',
    LOG_HORARIO_ROTATIVO_CREAR => 'Horario Rotativo - Creado',
    LOG_HORARIO_ROTATIVO_EDITAR => 'Horario Rotativo - Editado',
    LOG_HORARIO_ROTATIVO_ELIMINAR => 'Horario Rotativo - Eliminado',
    LOG_HORARIO_FLEXIBLE_CREAR => 'Horario Flexible - Creado',
    LOG_HORARIO_FLEXIBLE_EDITAR => 'Horario Flexible - Editado',
    LOG_HORARIO_FLEXIBLE_ELIMINAR => 'Horario Flexible - Eliminado',
    LOG_HORARIO_NORMAL_CREAR => 'Horario - Creado',
    LOG_HORARIO_NORMAL_EDITAR => 'Horario - Editado',
    LOG_HORARIO_NORMAL_ELIMINAR => 'Horario - Eliminado',
    LOG_LICENCIA_CREAR => 'Licencia - Creada',
    LOG_LICENCIA_EDITAR => 'Licencia - Editada',
    LOG_LICENCIA_ELIMINAR => 'Licencia - Eliminada',
    LOG_FERIADO_CREAR => 'Feriado - Creado',
    LOG_FERIADO_EDITAR => 'Feriado - Editado',
    LOG_FERIADO_ELIMINAR => 'Feriado - Eliminado',
    LOG_GRUPO_CREAR => 'Grupo - Creado',
    LOG_GRUPO_EDITAR => 'Grupo - Editado',
    LOG_GRUPO_ELIMINAR => 'Grupo - Eliminado',
    LOG_TRANSACCION_CHECKOUT_OK => 'Transacciones - OK',
    LOG_TRANSACCION_CHECKOUT_ERROR => 'Transacciones - Error',
    LOG_SUSCRIPCION_CHECKOUT_OK => 'Suscripciones - OK',
    LOG_SUSCRIPCION_CHECKOUT_ERROR => 'Suscripciones - Error',
    LOG_API_ACTIVAR => 'API - Activada',
    LOG_API_GENERAR_KEY => 'API - Key Generada',
    LOG_API_REGENERAR_KEY => 'API - Key Re-Generada',
    LOG_API_DESACTIVAR => 'API - Desactivada',
    LOG_API_MODO_DE_PRUEBAS_ON => 'API - Modo de Pruebas Activado',
    LOG_API_MODO_DE_PRUEBAS_OFF => 'API - Modo de Pruebas Desctivado',


    LOG_HUELLA_ENROLL_START => 'Huella - Inicio de carga de huella',
    LOG_HUELLA_DELETE => 'Huella - Huella eliminada',
    LOG_HUELLA_ENROLL_OK => 'Huella - Carga finalizada correctamente',
    LOG_HUELLA_ENROLL_CANCEL => 'Huella - Carga cancelada',
    LOG_RFID_READ_START => 'RFID - Inicio de carga de Tag',
    LOG_RFID_DELETE => 'RFID - Tag eliminado',
    LOG_RFID_READ_OK => 'RFID - Carga de Tag finalizada correctamente',
    LOG_RFID_READ_CANCEL => 'RFID - Carga cancelada',
    LOG_RFID_READ_ERROR => 'RFID - Error de carga'

);

/*
echo "session name: ".session_name()."<br />";
echo "session save path: ".session_save_path()."<br />";
echo "session cookie params: "; echo "<pre>";print_r(session_get_cookie_params());echo "</pre>"; echo "<br />";
*/




//logs equipos

define('LOGE_NULL', 0);
define('LOGE_INGRESO_CORRECTO', 1);
define('LOGE_PERSONA_NO_REGISTRADA', 2);
define('LOGE_PERSONA_DESACTIVADA', 3);

$a_Logs_Accion = array(
    LOGE_NULL => "NULL",
    LOGE_INGRESO_CORRECTO => "INGRESO CORRECTO",
    LOGE_PERSONA_NO_REGISTRADA => "PERSONA NO REGISTRADA",
    LOGE_PERSONA_DESACTIVADA => "PERSONA DESACTIVADA",
);


//defines para la sincronizacion

define('CMD_SYNC', "CMD_SYNC");
define('CMD_ACK', "CMD_ACK");
define('CMD_FIRST_START', "CMD_FIRST_START");
define('CMD_CONFIG', "CMD_CONFIG");
define('ACK', "ACK");
define('CMD_ENROLL_START', "CMD_ENROLL_START");
define('ACK_ENROLL_START', "ACK_ENROLL_START");
define('CMD_ENROLL_CANCEL', "CMD_ENROLL_CANCEL");
define('CMD_ENROLL_STATUS', "CMD_ENROLL_STATUS");
define('CMD_ENROLL_OK', "CMD_ENROLL_OK");
define('CMD_RFID_READ_START', "CMD_RFID_READ_START");
define('ACK_RFID_READ_START', "ACK_RFID_READ_START");
define('CMD_RFID_READ_CANCEL', "CMD_RFID_READ_CANCEL");
define('CMD_RFID_READ_STATUS', "CMD_RFID_READ_STATUS");
define('CMD_RFID_READ_OK', "CMD_RFID_READ_OK");
define('CMD_LOG', "CMD_LOG");
define('ACK_LOG', "ACK_LOG");
define('CMD_PING', "CMD_PING");
define('CMD_PONG', "CMD_PONG");
define('CMD_ACK_ELIMINADO', "CMD_ACK_ELIMINADO");




define('TYPE_PERSON', "TYPE_PERSON");
define('TYPE_FINGERPRINT', "TYPE_FINGERPRINT");
define('TYPE_NORMAL_HOURS', "TYPE_NORMAL_HOURS");
define('TYPE_FLEX_HOURS', "TYPE_FLEX_HOURS");
define('TYPE_ROTATIVE_HOURS', "TYPE_ROTATIVE_HOURS");
define('TYPE_COMPANIES', "TYPE_COMPANIES");
define('TYPE_GROUPS', "TYPE_GROUPS");
define('TYPE_GROUPS_PERSONS', "TYPE_GROUPS_PERSONS");
define('TYPE_HOLIDAYS', "TYPE_HOLIDAYS");
define('TYPE_LICENSES', "TYPE_LICENSES");
define('TYPE_CONFIG', "TYPE_CONFIG");






define('TRANSACTION_PENDING', 1);
define('TRANSACTION_APPROVED', 2);
define('TRANSACTION_REJECTED', 3);
define('TRANSACTION_PAID', 4);
define('TRANSACTION_UNPAID', 5);

$a_Estados_Transacciones = array(
    TRANSACTION_PENDING => 'Pendiente',
    TRANSACTION_APPROVED => 'Aprobada',
    TRANSACTION_REJECTED => 'Rechazada',
    TRANSACTION_PAID => 'Pagada',
    TRANSACTION_UNPAID => 'Sin Pagar'
);


define("IVA", 1.21);
define("IVA_MOSTRAR", 21);


/* datos payu sandbox */
/*
define("PAYU_API_KEY",'4Vj8eK4rloUd272L48hsrarnUA');
define("PAYU_API_LOGIN",'pRRXKOl8ikMmt9u');
define("PAYU_ACCOUNT_ID",'512322');
define("PAYU_MERCHANT_ID",'508029');
define("PAYU_LANGUAGE",'es');
define("PAYU_IS_TEST",true);
define("PAYU_API_PAYMENTS_URL",'https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi');
define("PAYU_API_REPORTS_URL",'https://sandbox.api.payulatam.com/reports-api/4.0/service.cgi');
define("PAYU_SUSCRIPTIONS_URL",'https://sandbox.api.payulatam.com/payments-api/rest/v4.3/');
*/
/* datos payu reales */

 /* fabri */
define("PAYU_API_KEY",'6V5rQjO56DSyr4U7KcBCzoz52A');
define("PAYU_API_LOGIN",'YedrDJ16MVKNtTm');
define("PAYU_ACCOUNT_ID",'540353');
define("PAYU_MERCHANT_ID",'538292');
define("PAYU_LANGUAGE",'es');
define("PAYU_IS_TEST",false);
define("PAYU_API_PAYMENTS_URL",'https://api.payulatam.com/payments-api/4.0/service.cgi');
define("PAYU_API_REPORTS_URL",'https://api.payulatam.com/reports-api/4.0/service.cgi');
define("PAYU_SUSCRIPTIONS_URL",'https://api.payulatam.com/payments-api/rest/v4.3/');









//pubsub
require_once(APP_PATH . '/libs/google/vendor/autoload.php');

$psclient = new Google_Client();
$psclient->useApplicationDefaultCredentials();//usa las credenciales de app engine
$psclient->addScope(Google_Service_Pubsub::PUBSUB);




