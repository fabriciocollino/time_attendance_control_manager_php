<?php

use \Firebase\JWT\JWT;
require_once('_ruta.php');
require_once('codigo/libs/jwt/JWT.php');

//fuerzo que el login sea por SSL
if(Config_L::p('force_ssl'))
    if(!isHTTPS())
        forceSSL();

if (isset($_POST['btnLogout'])) {
    header('Location: ' . WEB_ROOT . '/logout.php');
    exit();
}


$T_Usuario          =   isset   (   $_REQUEST['username']  )        ?           $_REQUEST['username']       :       ''      ;
$T_Clave            =   isset   (   $_POST['password']  )           ?           $_POST['password']          :       ''      ;
$T_Company          =   isset   (   $_POST['company']   )           ?           $_POST['company']           :       ''      ;
$T_Setup            =   isset   (   $_REQUEST['setup']  )           ?           $_REQUEST['setup']          :       ''      ;
$T_LoginEmpleado    =   isset   (   $_REQUEST['empleado']  )        ?           1                           :       ''      ;


// SUB-DOMAIN LOGIN
if (isset($_POST['btnLogin'])) {

    // NOT BLOCKED FOR ATTEMPS
    //if(SeguridadHelper::CheckLoginAttempts($_SERVER['REMOTE_ADDR'])){


    // LOGIN ADMIN
    if(!$T_LoginEmpleado){
        $o_Usuario = Usuario_L::obtenerPorLogin($T_Usuario, $T_Clave);
        if (is_null($o_Usuario)){
            $o_Usuario = Usuario_L::obtenerPorLoginDni($T_Usuario, $T_Clave);
        }
    }


    // LOGIN EMPLOYEE
    else{
        $o_Usuario = Usuario_L::obtenerPorLoginEmpleado($T_Usuario, $T_Clave);
        if(is_null($o_Usuario)){
            $o_Usuario = Usuario_L::obtenerPorLoginDniEmpleado($T_Usuario, $T_Clave);
        }
    }

    if (is_null($o_Usuario)) {

        // USER OR PASS WRONG
        $T_Error = _('usuario o contraseña incorrectos.');
        SeguridadHelper::Login(0, $T_Usuario, $T_Clave);
    }
    else {
        // USER ID
        session_regenerate_id(true);


        $_SESSION['PERSONA_LOGIN'] = $T_LoginEmpleado == 1 ? true : false;
        $_SESSION['USUARIO']['id'] = $o_Usuario->getId();

        // LOG: LOGIN
        SeguridadHelper::Login($_SESSION['USUARIO']['id']);

        if($T_LoginEmpleado){
            header('Location: ' . WEB_ROOT . '/#inicio_empleado');
        }
        else if ($o_Usuario->getTipoUsuarioObject()->getCodigo() == 10) {
            header('Location: ' . WEB_ROOT . '/#personas');
        }
        else {
            if ($T_Setup != '')
                header('Location: ' . WEB_ROOT . '/#setup');
            else
                header('Location: ' . WEB_ROOT . '/#inicio');
        }

        // DEFAULT DATE (FOR FILTERS WIDGET)
        $_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime('today 00:00'));
        $_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime('tomorrow 00:00'));
        $_SESSION['filtro']['bloqueados']='';

        // API LOGIN & TOKEN
        $_SESSION['authToken'] = apiLogin($T_Usuario,$T_Clave);

        exit();
    }
    //}
    // else{
    //   $T_Error="Login bloqueado por varios intentos fallidos. Intente nuevamente más tarde.";
    // }
}
else if(isset($_POST['btnContinue'])){  //login general
    $o_Cliente = Cliente_L::obtenerPorSubdominio($T_Company);

    if (isset($o_Cliente) && $o_Cliente != null) {
        if($T_Setup!='') {
            header('Location: https://' . $o_Cliente->getSubdominio() . '.enpuntocontrol.com?setup=1');
        }
        else {
            header('Location: https://' . $o_Cliente->getSubdominio() . '.enpuntocontrol.com');
        }
        exit();
    }else{
        $T_Error =  "la URL es incorrecta";
    }


}
else if(isset($_POST['loginExterno'])){   //login android

    // Get your service account's email address and private key from the JSON key file
    $service_account_email = "firebase@enpunto-1286.iam.gserviceaccount.com";
    //$private_key = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDEfKZAae0oOe46\nzdbYX0y5Nh7OQ/SMzjfoGSAt+c6JkO1OtPtXPVhZR8DgFhe3pfFn/ga7AoPFn8jl\nU+YdiBt/iD5U50csZtSDaKtHOU+5iGHrAXAwbLVYO2iH5CUBu5fhW9rkIA7HC32K\nCiA+OCLuGxEXvaYYwrVFlcfmq+36/7wfFNPNYtogJrrtm4XveQefLwkNfkkqfEDG\nyyqkdjP/Hw9tB6JIFJLMG7Q9X/umUXPrC9cMGKGHm8j0XV3uzYGh9tamaGGAh+uY\n3muj3PZtpPZWNFK4c261SnhGjYEBm8wJg9iEvElw6AVBxm2wMhDdBknbFQwpc7YW\nLtYcDlljAgMBAAECggEAW5bTFFGMF+UxFD4g+MkrhWYh4/ovQ3dY/hrAMk4wpVVm\nGPsp8deJmExnLs19jsCOj/AMiR25+OPrjGKYcImib8c9buxD9AGW7A5dUJz5eb2G\nDzqjZh82RQOkTTveuDkOqiDcHtyGpufHRBJGR1p5hc4eIJfplb8lKmOQRAk+rHG5\nzepdSDHMfxn6Ias3odOCRsuv228Z4gGs1VtUzgR4qf7dJLZBhumm2F7PyPJqV20v\n9XpczZ9flTWAaAEQcR/ZOhNavXn6zRYJU2xCHMuCgwA+2Iczvidq9fEt5Gb7dmUz\n8B5QXbSW/p/L0uS6DoTNhsUVU3GBUesMwN0AH+l06QKBgQDjaZerScpl+/d/Uhz6\n/5D9vJ2auOEOTYNvOT4Ggb0pORTJBwaoa/ZPNGuo0JeDS49ubN18iKjbxgEipUEf\njYiAwSirPk2iXyi3B2fwxChSVwhsoYa5so8DadZh/Dm+h9kr5N8JRGJgxa4lcQSv\nNQRQ8I6dSQ05XLwvLeWyYWi7PwKBgQDdL9XO89g8faDhUxAvKuidsEWR5wvZ9Mh+\nGLDuQgDCt/c55ATDAu7LIVCg/ipptSgcjIzPcqIeIGxAv3CkoYIOmMhuSefG+TVA\ncFT0oEoC9Cv6tAyZbBn9ymAedLj5ZRTOI14v+zd8hf7d+XZO0wKtHT4Cup3Aazib\nR6KatXJM3QKBgQC9LFh7p42Tmq9+nVr4POJrAJ0GWSb2E+ry+eYr2X72rMIqnAqg\nzfZ+Wrf4HVT8Zj2xeSQh9TiqYaMOI/PxgHX9zTC8ir5gBNLEtodzVGnKXRXn79I3\n5V5sU31/0yZh5XX1upUCi31ezPKZuNNRwEOP5RxtoJg8kHUGtiJuafOKVwKBgBIi\nQtg1u6ux7QesJK6JSQrskbeVhq422F0mLxNJjABqzrULUayfR+6Va6PXUqjZ9lDo\n4P58+neX1ug0CcslhqElu4D3RC5W7hu7Weu4XHkDhbuHGWVWrIbXGaxFi4i+1cbU\ntXsfkHwADFYshpuNxzFkLVpR7G8DG1/3rogaiiVtAoGAHzoMfq80dVOfEGJOXnYa\nORzlhtwHlLMeSFJcpI2WW7Xro5Lh9hZva6U0Ykxtbtmr+XZknD3R3NlrGOJgd5T6\nJ1FBcqV90AulRQMACeLuhEypgBfVxDEpr0Bl6fauua3XiPeXYqxlbIuZ/wWrK/Yi\nKR2Izw3PmFKgWk3VTB2xVYw=\n-----END PRIVATE KEY-----\n";


    $private_key = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDRErNVicyTV7Kk\n9WwYdpH6qTCowY7xEcYsxrtht0Sj7kndXVvhocoQdcQrCxRlGIpsnf/FiRHe7Ifh\nd2IaDfGYTPfOhW8Ge0gNtbbFpFilK9KgPfV8sazujUwkiXJFv5gn2/AXzIYDVSDv\n+OYyajTxhOV3mzLW3zTzNmuFpXE1S62QKDegBSnylD0tBI8NCNttxRI7rGIOv/mm\nTYHLIzM9sIC+3pV19Mypodur4JWjFzjcTq0lfbtQEEwdWjd9QgEnSN5kc0G8zvzW\nVyyNFtB/BOGmCLiS1gE7JE3FdhZfeoofJMUO3i6uGeaaCEqQxbpWm4A2H/J4bE+O\n4GuHQVlzAgMBAAECggEAK8tfBWv4DmUwZp2CJx2vNnJ6Xt8sshKnEHoQhkd9eVlQ\n363OsVTSnuAMV3fardKWLGpsSVSNCcVCMVhwlESXdu+oePo6Z4ErdrO5tWzXpMGp\nPSe9ZIFTWCUA7iZcaX/Yv4CyqkmNSOVsINhiX+0fafgMmSFJZPkcflXH8BbXv/HZ\nXJVQf3w0ZVeelXbyU4V/imKP+V4YGGZ51+YTsi9txD+FIIn286KykU2WFaBxvMu0\nLikkv5uu6Mf3Uo7mZd6XRlNG2Q2NLYMreqFaQ7tHhGQRvegA6HYg6+DLbKP5h80E\nehFXtY3IqPBQnCjcoRk1M5on4firfe8bRblWwHy3AQKBgQDpATnnnNo/ut/iqdcY\npc9HiQtcmrq0Sv/5KoyFxT+lod7T2ODoPudPIW5l1Fb7TYwQMlZUhnSeKebDvFy0\nEVVjBIYYw1NBetb8/uTRgVomPDYX9ckpw+MTV/FPAPwtDA82yanFV5saQCIrK+Rs\nsFYIwV1/3m4My2sXcFMt9AF2twKBgQDltNkuzdI6JsWV8SwfrmOXLXzyklwrQbAl\nguqKMMuvQXbL7XeRz1bF9f9oDp0oaK/XBoOhQoiLdkuLdvQY0K4DfUSdawnOOU9A\n7UljTityxUbqeN5P2BEwFnyOVJlsY2i1qc9na1/Bp/tu0LkvcaIAHQMCNHomTG8l\nO2hO/uVXJQKBgCLaTxoJCVBdGJ4j/4utSasOocdxUZokWdOgfLKJxbJ12wnfOA0l\nU54vhv7uWzBt8hR+IxGzpv/9jooaw9cffKE6DQDpPqvdvwjK69k2uxBbE1BUMInx\nxiafkfXaVN48Ho54bc+aAhZUH4hLoXhsjAH1QpIc6GM7jkJMR/TouctTAoGBAIUR\nH+NCLi+ruDhlTqdHsb+pBUHMUYJpei4wycel/siWxsfZ17NrBhyFpiBUnuwCwSJy\nTpyDW3BW5epzzXH2qWeyEKaUlEiX4HZ/P008wmSpLay0uixMwaA21o7pKTul1smu\nBk0l4YHg2wHV/gEi9bLVG6ISXlSDYLuTz5g7hwXVAoGAOi82YzOCaWjUCKyT1UC6\ngf+ekk6SeoGvuTI2V1s5mCBaTgfXzp/J7SRwxUFd3NF+4luKaWCBN2SK/AhQzyjI\nkNVONaHa1Puvw+mFXt81g7jcvtd5eg+KB/AOYvMUfXweJVMzMQ23xuxUT28U8Ycs\nzXIzcbSZoblyjH8Kspun7XI=\n-----END PRIVATE KEY-----\n";

    if(SeguridadHelper::CheckLoginAttempts($_SERVER['REMOTE_ADDR'])){

        // USER OBJECT
        $o_Usuario = Usuario_L::obtenerPorLogin($T_Usuario, $T_Clave);

        // IF USER IS NULL,
        if (is_null($o_Usuario)) {
            // SAVE LOG: USER LOGIN ATTEMP ID= 0
            SeguridadHelper::Login(0, $T_Usuario, $T_Clave);
            die();
        }

        else {

            // USER ID
            session_regenerate_id(true);
            $_SESSION['USUARIO']['id'] = $o_Usuario->getId();

            // SAVE LOG: LOGIN SUCCESSFULL USER ID= 'id'
            SeguridadHelper::Login($_SESSION['USUARIO']['id']);
            $_SESSION['authToken'] = apiLogin($T_Usuario,$T_Clave);

            // PAYLOAD
            $now_seconds = time();
            $payload = array(
                "iss" => $service_account_email,
                "sub" => $service_account_email,
                "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
                "iat" => $now_seconds,
                "exp" => $now_seconds+(60*60),  // Maximum expiration time is one hour
                "uid" => Registry::getInstance()->Cliente->getId()."_".$o_Usuario->getId(),
                "claims" => array(
                    "name"  => $o_Usuario->getNombreCompleto(),
                    "email" => $o_Usuario->getEmail(),
                    "remote_photo_url" => $o_Usuario->getImagenURL()
                )
            );

            $jwt = JWT::encode($payload, $private_key, "RS256");
            die($jwt);
        }
    }

    else{
        die();
    }
}


$array_dominio          =   explode         (   "."     ,   $_SERVER['HTTP_HOST']   );
$subdominio_inseguro    =   array_shift     (   $array_dominio                      );



global $subdominio;
$subdominio             =   preg_replace    (   "/[^a-zA-Z0-9]+/", "", $subdominio_inseguro);




function apiLogin($email,$password){


//     curl -X POST --header 'Content-Type: application/json' --header 'Accept: application/json' -d '{"email":"fabricio.collino@enpuntocontrol.com","password":"col377YO"}' 'https://dev.enpuntocontrol.com/api/v2/login';
    global $subdominio;

    //$xCurl1= "curl -X POST --header 'Content-Type: application/json' --header 'Accept: application/json' -d '{\"email\":\"{$email}\"}',\"password\":\"{$password}\" }' 'https://'{$subdominio}'.enpuntocontrol.com/api/v2/login'";

    $service_url = 'https://'.$subdominio.'.enpuntocontrol.com/api/v2/login';

    $curl = curl_init($service_url);

    $curl_post_data = array(
        "email" => $email,
        "password" => $password
    );


    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,  array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


    $curl_response = curl_exec($curl);
    $decoded = json_decode($curl_response);
    curl_close($curl);



    if(isset($decoded->authToken))
        return $decoded->authToken;
    else{
        return false;
    }

}


//if(isHTTPS())echo "Conexión segura";
//echo $_SERVER["HTTP_X_FORWARDED_FOR"];

include 'codigo/templates/login.html.php';
