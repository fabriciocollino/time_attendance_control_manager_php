<?php

require_once(dirname(__FILE__) . '/_ruta.php');

if ($o_Plan->getId() < PLAN_PLUS)die('nop'); //plan free no pasa;


header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: *' );
header('Content-Type: application/json');


/*
 * http://www.restapitutorial.com/httpstatuscodes.html
 * http://racksburg.com/choosing-an-http-status-code/
 * errores para implementar
 * 401 auth error
 *
 *
 *
 *
200 – OK	- Everything worked
201 – CREATED	- Resource created
400 – Bad Request	- The application did something wrong
401 – UNAUTHORIZED	- You are not authorized
403 – FORBIDDEN 	- Forget it, you are forbidden
405 – METHOD NOT ALLOWED 	-  Nope don’t even try
500 – Internal Server Error	- The API did something wrong


 */




//********************************************************************************************************************//
//********************************************************************************************************************//
//*******************************************     HEADER DEL RESPONCE     ********************************************//
//********************************************************************************************************************//
//********************************************************************************************************************//



//armo el response;
$data=array();
$responce=array();
$responce['status']=200;
$responce['api_version']="0.0";
$responce['test_mode']='no';
$responce['hostname']=$_SERVER['HTTP_HOST'];
$responce['path']=$_SERVER['REQUEST_URI'];
if(GAE) {
	$responce['instance_id'] = $_SERVER['INSTANCE_ID'];
	$responce['request_id'] = $_SERVER['REQUEST_LOG_ID'];
}
$responce['resource']='';



//********************************************************************************************************************//
//********************************************************************************************************************//
//*********************************     EXTRACCION DE PARAMETROS DE LA URL     ***************************************//
//********************************************************************************************************************//
//********************************************************************************************************************//


//api_key
if(array_key_exists('HTTP_API_KEY',$_SERVER)){
	$api_key = $_SERVER['HTTP_API_KEY'];
}else{
	$responce['status']=400;//bad request
	$data['error'] = "Falta incluir la KEY en el header";
	$responce['data']=$data;
	http_response_code($responce['status']);
	die(json_encode($responce));
}

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

if(is_array($input) && ($input!='') && ($input!=null)) {
	foreach (array_keys($input) as $key) {
		if (!is_array($input[$key])) {
			$variable = $input[$key];
			$temp_r = str_replace(array("<", ">", "[", "]", "*", "^", "=", "'","\""), "", $variable);
			$input[$key] = $temp_r;
			//echo "<br>key:".$key.": ".$variable.">".$input[$key]."<br>";
		}
	}
}

/************   CAMPOS OBLIGATORIOS DE LA URL **********************/
//api_version
if(isset($request[1])){
	$api_version = preg_replace('/[^a-z0-9_]+/i','',$request[1]);
}else{
	$responce['status']=400;//bad request
	$data['error'] = "Falta incluir el parametro 'versión' en la URL";
	$responce['data']=$data;
	http_response_code($responce['status']);
	die(json_encode($responce));
}

//resource
if(isset($request[2])){
	$recurso = preg_replace('/[^a-z0-9_]+/i','',$request[2]);
	$responce['resource']=$recurso;
}else{
	$responce['status']=400;//bad request
	$data['error'] = "Falta incluir el parametro 'recurso' en la URL";
	$responce['data']=$data;
	http_response_code($responce['status']);
	die(json_encode($responce));
}

/******************   CAMPOS NO OBLIGATORIOS  **********************/

//id
if(isset($request[3])){
	$id = preg_replace('/[^a-z0-9_]+/i','',$request[3]);
	$id = str_replace ( array("< ",">","[","]","*","^","="), "" , $id);
	$responce['resource_id']=$id;
}else{
	$id='';
}



//********************************************************************************************************************//
//********************************************************************************************************************//
//******************************************     DATOS DEL CLIENTE (BD     *******************************************//
//********************************************************************************************************************//
//********************************************************************************************************************//



define('TEST_MODE',Config_L::p('api_test_mode'));
define('API_ENABLED',Config_L::p('api_enabled'));
define('API_KEY',Config_L::p('api_key'));





//********************************************************************************************************************//
//********************************************************************************************************************//
//**************************     CHEQUEOS DE API ENABLED KEY, RECURSO y VERSION     **********************************//
//********************************************************************************************************************//
//********************************************************************************************************************//

if(API_ENABLED == 0){
	$responce['status']=403;
	$data['error'] = "API Desactivada";
	$responce['data']=$data;
	http_response_code($responce['status']);
	die(json_encode($responce));
}

if(TEST_MODE == 1){
	$responce['test_mode']='yes';
}

if(API_KEY != $api_key){
	$responce['status']=401;
	$data['error'] = "Key no válida";
	$responce['data']=$data;
	http_response_code($responce['status']);
	die(json_encode($responce));
}

$versiones_disponibles=array('v1');
if(!in_array($api_version,$versiones_disponibles)){
	$responce['status']=400;
	$data['error'] = "Número de version incorrecto";
	$responce['data']=$data;
	http_response_code($responce['status']);
	die(json_encode($responce));
}

$recursos_disponibles=array('personas');
if(!in_array($recurso,$recursos_disponibles)){
	$responce['status']=400;
	$data['error'] = "Recurso incorrecto";
	$responce['data']=$data;
	http_response_code($responce['status']);
	die(json_encode($responce));
}



//si llego hasta aca quiere decir que esta lo anterior chequeado (cliente usuario key recurso etc)



//********************************************************************************************************************//
//********************************************************************************************************************//
//******************************************     API PROPIAMENTE DICHA     *******************************************//
//********************************************************************************************************************//
//********************************************************************************************************************//

switch ($api_version){
	case 'v1':{
		$responce['api_version']="1.0";

		switch ($recurso){
//********************************************************************************************************************//
//*************************************************     PERSONAS     *************************************************//
//********************************************************************************************************************//
			case 'personas':{

				switch ($method){
					case 'GET':{
						if($id==''){  //devuelvo todos
							$a_o_Personas = Persona_L::obtenerTodos();
							$array=array();
							foreach ($a_o_Personas as $o_persona){ /* @var $o_persona Persona_O */
								$array[] = $o_persona->toArray();
							}
							$data=$array;
						}else{//viene una ID
							$o_persona = null;
							$o_persona = Persona_L::obtenerPorId((integer)$id,true);
							if(is_null($o_persona)){
								$responce['status']=404;
								$data['error'] = "Persona ID:".$id." no encontrada ";
								$responce['data']=$data;
								http_response_code($responce['status']);
								die(json_encode($responce));
							}else{
								$data=$o_persona->toArray();
							}
						}
						break;
					}//method GET
					case 'POST':{
						$o_persona = new Persona_O();
						$o_persona->fromArray($input);
                        if(TEST_MODE){
                            if (!$o_persona->esValido()) {
                                $responce['status']=422;
                                $data['error'] = "Error con los datos de la persona";
                                $data['detalle'] = $o_persona->getErrores();;
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_persona->toArray();
                            }
                        }else{
                            if(!$o_persona->save()){
                                $responce['status']=422;
                                $data['error'] = "Error con los datos de la persona";
                                $data['detalle'] = $o_persona->getErrores();;
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_persona->toArray();
                            }
                        }
						break;
					}//method POST

					case 'PUT':{
						$responce['status']=501;
						$data['error'] = "Método PUT no implementado. Usar PATCH.";
						$responce['data']=$data;
						http_response_code($responce['status']);
						die(json_encode($responce));
						break;
					}//method PUT

					case 'PATCH':{
						if($id==''){
							$responce['status']=400;//bad request
							$data['error'] = "Falta incluir el parametro 'id' en la URL";
							$responce['data']=$data;
							http_response_code($responce['status']);
							die(json_encode($responce));
						}else{
							$o_persona = null;
							$o_persona = Persona_L::obtenerPorId((integer)$id,true);
							if(is_null($o_persona)){
								$responce['status']=404;
								$data['error'] = "Persona ID:".$id." no encontrada ";
								$responce['data']=$data;
								http_response_code($responce['status']);
								die(json_encode($responce));
							}else{
								$o_persona->fromArray($input);
                                if(TEST_MODE){
                                    if (!$o_persona->esValido()) {
                                        $responce['status']=422;
                                        $data['error'] = "Error con los datos de la persona";
                                        $data['detalle'] = $o_persona->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=$o_persona->toArray();
                                    }
                                }else{
                                    if(!$o_persona->save()){
                                        $responce['status']=422;
                                        $data['error'] = "Error con los datos de la persona";
                                        $data['detalle'] = $o_persona->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=$o_persona->toArray();
                                    }
                                }

							}
						}
						break;
					}//method PATCH

					case 'DELETE':{
						if($id==''){
							$responce['status']=400;//bad request
							$data['error'] = "Falta incluir el parametro 'id' en la URL";
							$responce['data']=$data;
							http_response_code($responce['status']);
							die(json_encode($responce));
						}else{
							$o_persona = null;
							$o_persona = Persona_L::obtenerPorId((integer)$id,true);
							if(is_null($o_persona)){
								$responce['status']=404;
								$data['error'] = "Persona ID:".$id." no encontrada ";
								$responce['data']=$data;
								http_response_code($responce['status']);
								die(json_encode($responce));
							}else{
                                if(TEST_MODE) {
                                    $data=array(); //se elimino correctamente
                                }else{
                                    if(!$o_persona->delete()){
                                        $responce['status']=500;
                                        $data['error'] = "Error al eliminar la persona";
                                        $data['detalle'] = $o_persona->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=array(); //se elimino correctamente
                                    }
                                }
							}
						}
						break;
					}//method DELETE


				}//switch method

				break;
			}//recurso personas
//********************************************************************************************************************//
//*********************************************     HORARIOS NORMALES     ********************************************//
//********************************************************************************************************************//
            case 'horarios-normales':{
                switch ($method){
                    case 'GET':{
                        if($id==''){  //devuelvo todos
                            $a_o_horarios = Hora_Trabajo_L::obtenerTodos();
                            $array=array();
                            foreach ($a_o_horarios as $o_horario){ /* @var $o_horario Hora_Trabajo_O */
                                $array[] = $o_horario->toArray();
                            }
                            $data=$array;
                        }else{//viene una ID
                            $o_horario = null;
                            $o_horario = Hora_Trabajo_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }
                        break;
                    }//method GET
                    case 'POST':{
                        $o_horario = new Hora_Trabajo_O();
                        $o_horario->fromArray($input);
                        if(TEST_MODE){
                            if (!$o_horario->esValido()) {
                                $responce['status']=422;
                                $data['error'] = "Error con los datos del horario";
                                $data['detalle'] = $o_horario->getErrores();;
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }else{
                            if(!$o_horario->save()){
                                $responce['status']=422;
                                $data['error'] = "Error con los datos del horario";
                                $data['detalle'] = $o_horario->getErrores();;
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }
                        break;
                    }//method POST

                    case 'PUT':{
                        $responce['status']=501;
                        $data['error'] = "Método PUT no implementado. Usar PATCH.";
                        $responce['data']=$data;
                        http_response_code($responce['status']);
                        die(json_encode($responce));
                        break;
                    }//method PUT

                    case 'PATCH':{
                        if($id==''){
                            $responce['status']=400;//bad request
                            $data['error'] = "Falta incluir el parametro 'id' en la URL";
                            $responce['data']=$data;
                            http_response_code($responce['status']);
                            die(json_encode($responce));
                        }else{
                            $o_horario = null;
                            $o_horario = Hora_Trabajo_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $o_horario->fromArray($input);
                                if(TEST_MODE){
                                    if (!$o_horario->esValido()) {
                                        $responce['status']=422;
                                        $data['error'] = "Error con los datos del horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=$o_horario->toArray();
                                    }
                                }else{
                                    if(!$o_horario->save()){
                                        $responce['status']=422;
                                        $data['error'] = "Error con los datos del horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=$o_horario->toArray();
                                    }
                                }

                            }
                        }
                        break;
                    }//method PATCH

                    case 'DELETE':{
                        if($id==''){
                            $responce['status']=400;//bad request
                            $data['error'] = "Falta incluir el parametro 'id' en la URL";
                            $responce['data']=$data;
                            http_response_code($responce['status']);
                            die(json_encode($responce));
                        }else{
                            $o_horario = null;
                            $o_horario = Hora_Trabajo_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                if(TEST_MODE) {
                                    $data=array(); //se elimino correctamente
                                }else{
                                    if(!$o_horario->delete()){
                                        $responce['status']=500;
                                        $data['error'] = "Error al eliminar el horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=array(); //se elimino correctamente
                                    }
                                }
                            }
                        }
                        break;
                    }//method DELETE


                }//switch method
            }//recurso horarios_normales
//********************************************************************************************************************//
//*********************************************     HORARIOS FLEXIBLES     *******************************************//
//********************************************************************************************************************//
            case 'horarios-flexibles':{
                switch ($method){
                    case 'GET':{
                        if($id==''){  //devuelvo todos
                            $a_o_horarios = Horario_Flexible_L::obtenerTodos();
                            $array=array();
                            foreach ($a_o_horarios as $o_horario){ /* @var $o_horario Horario_Flexible_O */
                                $array[] = $o_horario->toArray();
                            }
                            $data=$array;
                        }else{//viene una ID
                            $o_horario = null;
                            $o_horario = Horario_Flexible_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }
                        break;
                    }//method GET
                    case 'POST':{
                        $o_horario = new Horario_Flexible_O();
                        $o_horario->fromArray($input);
                        if(TEST_MODE){
                            if (!$o_horario->esValido()) {
                                $responce['status']=422;
                                $data['error'] = "Error con los datos del horario";
                                $data['detalle'] = $o_horario->getErrores();;
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }else{
                            if(!$o_horario->save()){
                                $responce['status']=422;
                                $data['error'] = "Error con los datos del horario";
                                $data['detalle'] = $o_horario->getErrores();;
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }
                        break;
                    }//method POST

                    case 'PUT':{
                        $responce['status']=501;
                        $data['error'] = "Método PUT no implementado. Usar PATCH.";
                        $responce['data']=$data;
                        http_response_code($responce['status']);
                        die(json_encode($responce));
                        break;
                    }//method PUT

                    case 'PATCH':{
                        if($id==''){
                            $responce['status']=400;//bad request
                            $data['error'] = "Falta incluir el parametro 'id' en la URL";
                            $responce['data']=$data;
                            http_response_code($responce['status']);
                            die(json_encode($responce));
                        }else{
                            $o_horario = null;
                            $o_horario = Horario_Flexible_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $o_horario->fromArray($input);
                                if(TEST_MODE){
                                    if (!$o_horario->esValido()) {
                                        $responce['status']=422;
                                        $data['error'] = "Error con los datos del horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=$o_horario->toArray();
                                    }
                                }else{
                                    if(!$o_horario->save()){
                                        $responce['status']=422;
                                        $data['error'] = "Error con los datos del horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=$o_horario->toArray();
                                    }
                                }

                            }
                        }
                        break;
                    }//method PATCH

                    case 'DELETE':{
                        if($id==''){
                            $responce['status']=400;//bad request
                            $data['error'] = "Falta incluir el parametro 'id' en la URL";
                            $responce['data']=$data;
                            http_response_code($responce['status']);
                            die(json_encode($responce));
                        }else{
                            $o_horario = null;
                            $o_horario = Horario_Flexible_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                if(TEST_MODE) {
                                    $data=array(); //se elimino correctamente
                                }else{
                                    if(!$o_horario->delete()){
                                        $responce['status']=500;
                                        $data['error'] = "Error al eliminar el horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=array(); //se elimino correctamente
                                    }
                                }
                            }
                        }
                        break;
                    }//method DELETE


                }//switch method
            }//recurso horarios_flexibles
//********************************************************************************************************************//
//*********************************************     HORARIOS ROTATIVOS     *******************************************//
//********************************************************************************************************************//
            case 'horarios-rotativos':{
                switch ($method){
                    case 'GET':{
                        if($id==''){  //devuelvo todos
                            $a_o_horarios = Horario_Rotativo_L::obtenerTodos();
                            $array=array();
                            foreach ($a_o_horarios as $o_horario){ /* @var $o_horario Horario_Rotativo_O */
                                $array[] = $o_horario->toArray();
                            }
                            $data=$array;
                        }else{//viene una ID
                            $o_horario = null;
                            $o_horario = Horario_Rotativo_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }
                        break;
                    }//method GET
                    case 'POST':{
                        $o_horario = new Horario_Rotativo_O();
                        $o_horario->fromArray($input);
                        if(TEST_MODE){
                            if (!$o_horario->esValido()) {
                                $responce['status']=422;
                                $data['error'] = "Error con los datos del horario";
                                $data['detalle'] = $o_horario->getErrores();;
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }else{
                            if(!$o_horario->save()){
                                $responce['status']=422;
                                $data['error'] = "Error con los datos del horario";
                                $data['detalle'] = $o_horario->getErrores();;
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $data=$o_horario->toArray();
                            }
                        }
                        break;
                    }//method POST

                    case 'PUT':{
                        $responce['status']=501;
                        $data['error'] = "Método PUT no implementado. Usar PATCH.";
                        $responce['data']=$data;
                        http_response_code($responce['status']);
                        die(json_encode($responce));
                        break;
                    }//method PUT

                    case 'PATCH':{
                        if($id==''){
                            $responce['status']=400;//bad request
                            $data['error'] = "Falta incluir el parametro 'id' en la URL";
                            $responce['data']=$data;
                            http_response_code($responce['status']);
                            die(json_encode($responce));
                        }else{
                            $o_horario = null;
                            $o_horario = Horario_Rotativo_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                $o_horario->fromArray($input);
                                if(TEST_MODE){
                                    if (!$o_horario->esValido()) {
                                        $responce['status']=422;
                                        $data['error'] = "Error con los datos del horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=$o_horario->toArray();
                                    }
                                }else{
                                    if(!$o_horario->save()){
                                        $responce['status']=422;
                                        $data['error'] = "Error con los datos del horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=$o_horario->toArray();
                                    }
                                }

                            }
                        }
                        break;
                    }//method PATCH

                    case 'DELETE':{
                        if($id==''){
                            $responce['status']=400;//bad request
                            $data['error'] = "Falta incluir el parametro 'id' en la URL";
                            $responce['data']=$data;
                            http_response_code($responce['status']);
                            die(json_encode($responce));
                        }else{
                            $o_horario = null;
                            $o_horario = Horario_Rotativo_L::obtenerPorId((integer)$id);
                            if(is_null($o_horario)){
                                $responce['status']=404;
                                $data['error'] = "Horario ID:".$id." no encontrado ";
                                $responce['data']=$data;
                                http_response_code($responce['status']);
                                die(json_encode($responce));
                            }else{
                                if(TEST_MODE) {
                                    $data=array(); //se elimino correctamente
                                }else{
                                    if(!$o_horario->delete()){
                                        $responce['status']=500;
                                        $data['error'] = "Error al eliminar el horario";
                                        $data['detalle'] = $o_horario->getErrores();;
                                        $responce['data']=$data;
                                        http_response_code($responce['status']);
                                        die(json_encode($responce));
                                    }else{
                                        $data=array(); //se elimino correctamente
                                    }
                                }
                            }
                        }
                        break;
                    }//method DELETE


                }//switch method
            }//recurso horarios_rotativos


		}//switch recurso

		break;
	}//api_version v1
}//switch api_version







$responce['data']=$data;
echo json_encode($responce);

